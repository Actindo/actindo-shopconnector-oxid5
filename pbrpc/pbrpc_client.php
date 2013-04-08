<?php

require_once( UTILDIR.'3rdparty/pb4php/message/pb_message.php' );

class pbrpc_client
{
  protected $curlhandle;
  protected $curl_response_headers;

  protected $url;

  protected $force_http_10;
  protected $timeout;

  protected $request_encoding;
  protected $requested_response_encoding;

  protected $curr_request_id;

  protected $debug_output;
  protected $debug = FALSE;

  protected $resp_str;

  protected $user = '';
  protected $pass = '';

  protected $request_compression = '';
  protected $accepted_compression = '';

  function __construct( $url, $force_http_10=FALSE, $timeout=20 )
  {
    $this->url = $url;
    $this->force_http_10 = $force_http_10;
    $this->timeout = $timeout > 0 ? $timeout : 20;

//    $this->request_encoding = 'raw';
    $this->request_encoding = 'post';
//    $this->requested_response_encoding = 'base64';
    $this->requested_response_encoding = 'raw';
  }

  function setAcceptedCompression( $compmethod )
  {
    if ($compmethod == 'any')
      $this->accepted_compression = '';
    else
      $this->accepted_compression = $compmethod;
  }
  function setRequestCompression( $compmethod )
  {
    $this->request_compression = $compmethod;
  }
  function setForceHTTP10( $force_http_10 )
  {
    $this->force_http_10 = $force_http_10 ? 1 : 0;
  }

  function get_debug_output()
  {
    return $this->debug_output;
  }


  function get_valid_request_encodings( )
  {
    return array( 'raw', 'base64', 'post' );
  }


  function set_user_pass( $user, $pass )
  {
    $this->user = $user;
    $this->pass = $pass;
  }


  function call_method( $methodname, $param=null, $response_messagetype=null )
  {
    $start00 = getmicrotime();

//    printf( "\n" );
    $this->_init_curl_handle();

    $this->curr_request_id = rand( 0, 0x7FFFFFFF );

    $start = getmicrotime();

    $request = new Request();
    $request->set_method( $methodname );
    $request->set_id( $this->curr_request_id );
    if( !is_null($param) )
    {
      if( !is_object($param) || !($param instanceof PBMessage) )
        throw new pbrpc_InvalidParamException( "Parameter is not an object or not a child of PBMessage" );
//      $request->set_serialized_request( $param->SerializeToString() );
      $request->set_serialized_request( $param->SerializeToPHPSerialize() );
    }


    if( !strcasecmp($this->request_encoding, 'base64') )
    {
//      $res = curl_setopt( $this->curlhandle, CURLOPT_POSTFIELDS, $q=base64_encode($request->SerializeToString()) );
      $res = curl_setopt( $this->curlhandle, CURLOPT_POSTFIELDS, $q=base64_encode($request->SerializeToPHPSerialize()) );
    }
    elseif( !strcasecmp($this->request_encoding, 'post') )
    {
//      $res = curl_setopt( $this->curlhandle, CURLOPT_POSTFIELDS, $q='message='.rawurlencode($request->SerializeToString()) );
      $res = curl_setopt( $this->curlhandle, CURLOPT_POSTFIELDS, $q='message='.rawurlencode($request->SerializeToPHPSerialize()) );
    }
    elseif( !strcasecmp($this->request_encoding, 'raw') )
    {
//      $res = curl_setopt( $this->curlhandle, CURLOPT_POSTFIELDS, $q=$request->SerializeToString() );
      $res = curl_setopt( $this->curlhandle, CURLOPT_POSTFIELDS, $q=$request->SerializeToPHPSerialize() );
    }
    else
    {
      throw new pbrpc_LocalSystemErrorException( "Invalid request encoding '{$this->request_encoding}'", 0x7F15 );
    }
    if( $this->debug )
      printf( "%s:\t\t serializing and encoding took %.04f\n", $methodname, getmicrotime() - $start );


    $start = getmicrotime();
    $this->resp_str = $resp_str = curl_exec( $this->curlhandle );
    if( $resp_str === FALSE )
    {
      throw new pbrpc_CurlException( "Error sending request: (".curl_errno($this->curlhandle)."): ".curl_error($this->curlhandle), curl_errno($this->curlhandle) );
    }
    if( $this->debug )
      printf( "%s:\t\t curl_exec took %.04f\n", $methodname, getmicrotime() - $start );

    $start = getmicrotime();
    $info = curl_getinfo( $this->curlhandle );
    if( $info['http_code'] != 200 )
    {
      throw new pbrpc_HttpException( "Der Server gab nicht 200 OK zurück. (HTTP ".$info['http_code'].')', 0x7F05 );
    }
    if( $this->debug )
      printf( "%s:\t\t curl_getinfo took %.04f\n", $methodname, getmicrotime() - $start );


//    echo "resp_str= "; var_dump($resp_str);

    $enc = $this->curl_response_headers['X-PBRPC-Response-Encoding'];
    $resp_charset = $this->curl_response_headers['X-PBRPC-Response-Charset'];
    isset($resp_charset) or $resp_charset = 'ISO-8859-1';
    if( !strcasecmp($enc, 'base64') )
    {
      $resp_str = base64_decode( $resp_str );
    }
    elseif( !strcasecmp($enc, 'raw') )
    {
      // do nothing
    }
    elseif( !strcasecmp($enc, 'server-error') )
    {
      throw new pbrpc_LocalSystemErrorException( "Der Server gab einen PHP-Fehler zurück: ".$resp_str, 0x7F02 );
    }
    else
    {
      throw new pbrpc_LocalSystemErrorException( "Invalid response encoding '{$enc}'", 0x7F02 );
    }

//    printf( "%s: strlen(\$resp_str)=%d\n", $methodname, strlen($resp_str) );
//    print $resp_str."\n";

    $start = getmicrotime();
    $response = new Response();
    try
    {
//      $response->parseFromString( $resp_str );
      $response->ParseFromPHPSerialize( $resp_str );
    }
    catch( Exception $e )
    {
      throw new pbrpc_FormatException( "Invalid response: ".$e->__toString() );
    }

    if( defined('DEVELOPER_SYSTEM') && DEVELOPER_SYSTEM && strlen($response->debug_output()) )
      trigger_error( "debug_output = ".var_dump_string($response->debug_output()), E_USER_NOTICE );
//    echo "debug_output = "; var_dump($response->debug_output());
    $this->debug_output = $response->debug_output();

    $err = $response->error();
    if( is_object($err) )
    {
      if( $err->error_type() == Error_ErrorType::MESSAGE )
        throw new pbrpc_RemoteSystemErrorException( $err->text(), $err->code() );
      else
        throw new pbrpc_ApplicationErrorException( $err->text(), $err->code() );
    }

    // TODO: get from message
    $resp_msgtype = $response_messagetype;
    if( is_null($resp_msgtype) )
    {
      throw new pbrpc_LocalSystemErrorException( "No response message type given and none returned by server" );
    }
    if( !class_exists($resp_msgtype) )
    {
      throw new pbrpc_LocalSystemErrorException( "Response message type '{$resp_msgtype}' could not be found" );
    }
    if( $this->debug )
      printf( "%s:\t\t unserializing took %.04f\n", $methodname, getmicrotime() - $start );

    $resp_msg = new $resp_msgtype();

    if( !($resp_msg instanceof PBMessage) )
    {
      throw new pbrpc_LocalSystemErrorException( "Response message type '{$resp_msgtype}' is not a child of PBMessage" );
    }

    $start = getmicrotime();
    try
    {
//      $resp_msg->parseFromString( $response->serialized_response() );
      $resp_msg->ParseFromPHPSerialize( $response->serialized_response() );
    }
    catch( Exception $e )
    {
      throw new pbrpc_FormatException( "Error decoding method response of type '{$resp_msgtype}': ".$e->__toString() );
    }
    if( $this->debug )
      printf( "%s:\t\t decoding took %.04f\n", $methodname, getmicrotime() - $start );

//    var_dump($resp_msg );
/*
    var_dump($enc);
//    var_dump( $this->curl_response_headers );
//    var_dump($info);
*/


    curl_close( $this->curlhandle );
    $this->curlhandle = null;

    if( $this->debug )
      printf( "%s:\t\t EPSILON %.04f\n", $methodname, getmicrotime()-$start00 );

    return $resp_msg;
  }


  function init( )
  {

  }


  function get_response_string( )
  {
    return $this->resp_str;
  }


  protected function _init_curl_handle( )
  {
//    if( !is_resource($this->curlhandle) )
    {
      $this->curl_response_headers = array();
      $this->curlhandle = curl_init( $this->url );

      $headers = array(
        'X-PBRPC-Request-Encoding: '.$this->request_encoding,
        'X-PBRPC-Response-Encoding: '.$this->requested_response_encoding,
        'X-PBRPC-Username: '.$this->user,
        'X-PBRPC-Password: '.$this->pass,
      );

      $res  = curl_setopt( $this->curlhandle, CURLOPT_POST, TRUE );
      $res &= curl_setopt( $this->curlhandle, CURLOPT_RETURNTRANSFER, TRUE );
      $res &= curl_setopt( $this->curlhandle, CURLOPT_HEADER, FALSE );
      $res &= curl_setopt( $this->curlhandle, CURLOPT_HEADERFUNCTION, array(&$this, '_set_response_headers') );
      $res &= curl_setopt( $this->curlhandle, CURLOPT_HTTPHEADER, $headers );

      $res &= curl_setopt( $this->curlhandle, CURLOPT_USERAGENT, "actindo protobufrpc client" );

      $res &= curl_setopt( $this->curlhandle, CURLOPT_ENCODING, $this->accepted_compression );

      if( $this->force_http_10 )
        $res &= curl_setopt( $this->curlhandle, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0 );

//      trigger_error( var_dump_string($this->accepted_compression, $this->force_http_10), E_USER_NOTICE );

      $res &= curl_setopt( $this->curlhandle, CURLOPT_TIMEOUT, $this->timeout );
      $res &= curl_setopt( $this->curlhandle, CURLOPT_CAPATH, '/etc/ssl/certs' );
      $res &= curl_setopt( $this->curlhandle, CURLOPT_SSL_VERIFYHOST, 2 );
//      $res &= curl_setopt( $this->curlhandle, CURLOPT_SSL_VERIFYPEER, FALSE );
      if( !$res )
        throw new Exception( 'Error initializing cURL with required parameters' );
    }
  }
  function _set_response_headers( $curl, $str )
  {
    if( !is_array($this->curl_response_headers) )
      $this->curl_response_headers = array();

    $arr = explode( ':', trim($str) );
    $name = array_shift( $arr );
    $val = join( ':', $arr );
    $val = trim( $val );
    if( isset($this->curl_response_headers[$name]) )
    {
      if( is_array($this->curl_response_headers[$name]) )
        $this->curl_response_headers[$name][] = $val;
      else
        $this->curl_response_headers[$name] = array( $this->curl_response_headers[$name], $val );
    }
    else
      $this->curl_response_headers[$name] = $val;

    return strlen($str);
  }


}

class pbrpc_InvalidParamException extends Exception
{
}
class pbrpc_CurlException extends Exception
{
}
class pbrpc_HttpException extends Exception
{
}
class pbrpc_FormatException extends Exception
{
}
class pbrpc_RemoteSystemErrorException extends Exception
{
}
class pbrpc_LocalSystemErrorException extends Exception
{
}
class pbrpc_ApplicationErrorException extends Exception
{
}


?>