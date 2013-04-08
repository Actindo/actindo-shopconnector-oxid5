<?php

require_once( 'pb4php/message/pb_message.php' );
require_once( 'pb_proto_protobufrpc.php' );

class pbrpc_server
{
  protected $methodmap;
  protected $authentication_callback = null;

  protected $response_encoding;

  function __construct( $methodmap=null )
  {
//    $this->response_encoding = 'raw';
    $this->response_encoding = 'base64';
    $this->methodmap = array();
    if( is_array($methodmap) )
      $this->methodmap = $methodmap;

    $this->methodmap['system_listMethods'] = array(
      'function' => array(&$this, '_listMethods'),
      'request' => null,
      'response' => 'ListMethodsResponse'
    );
  }

  function get_valid_encodings( )
  {
    return array( 'raw', 'base64' );
  }

  function set_authentication_callback( $cb )
  {
    $this->authentication_callback = $cb;
  }

  function call_method( $raw=null )
  {
    global $actindo_occured_errors;
    header( 'X-PBRPC-Response-Charset: utf-8' );

    if( isset($_SERVER['HTTP_X_PBRPC_RESPONSE_ENCODING']) )
    {
      $requested_resp_encoding = $_SERVER['HTTP_X_PBRPC_RESPONSE_ENCODING'];
      if( !in_array($requested_resp_encoding, $this->get_valid_encodings()) )
      {
        $str = 'Invalid response encoding requested. Supported are: '.join( ',', $this->get_valid_encodings() );
        header( 'X-PBRPC-Error: '.$str );
        $this->_return_message_error( 5, $str, -1 );
        return FALSE;
      }
      else
        $this->response_encoding = $requested_resp_encoding;
    }

    header( 'X-PBRPC-Response-Encoding: server-error' );

    ob_start();

    if( !is_null($this->authentication_callback) )
    {
      if( !is_callable($this->authentication_callback) )
      {
        $this->_return_application_error( 1001, "No valid authentication callback" );
        return FALSE;
      }
      $ret = call_user_func( $this->authentication_callback, $_SERVER['HTTP_X_PBRPC_USERNAME'], $_SERVER['HTTP_X_PBRPC_PASSWORD'] );
      if( $ret !== TRUE )
      {
        $this->_return_application_error( ELOGINFAILED, "Ungültige Authentifizierung: ".$ret );
        return FALSE;
      }
    }

    if( is_null($raw) )
      $raw = file_get_contents( 'php://input' );

    if( stripos($raw, 'message=') === 0 )   // the way PBMessage->Send does it
    {
      $raw = substr( $raw, 8 );
      $raw = rawurldecode( $raw );
    }

    if( !strlen($raw) )
    {
      $this->_return_message_error( 0x7F15, "Ungültige Anfrage-Daten: ".var_dump_string($raw), -1 );
    }

    $request = new Request();
    try
    {
//      $request->parseFromString( $raw );
      $request->ParseFromPHPSerialize( $raw );
    }
    catch( Exception $e )
    {
      $this->_return_message_error( 1, $e->__toString(), $request->id() );
      return FALSE;
    }

    if( !isset($this->methodmap[$request->method()]) )
    {
      $this->_return_message_error( 2, sprintf("Unknown method '%s'.", $request->method()), $request->id() );
      return FALSE;
    }

    $method = $this->methodmap[$request->method()];
    $respclass = $method['response'];

    $req = null;
    if( !empty($method['request']) )
    {
      $reqclass = $method['request'];
      if( !class_exists($reqclass) )
      {
        $this->_return_message_error( 3, sprintf("Error finding request class '%s'", $reqclass), $request->id() );
        return FALSE;
      }

      $req = new $reqclass();
      try
      {
//        $req->parseFromString( $request->serialized_request() );
        $req->ParseFromPHPSerialize( $request->serialized_request() );
      }
      catch( Exception $e )
      {
        $this->_return_message_error( 4, sprintf("Error parsing request message of type '%s': %s", $reqclass, $e->__toString()), $request->id() );
        return FALSE;
      }
    }


    $resp = new Response();
    $resp->set_id( $id );

    $ret = call_user_func( $method['function'], $req );
    if( $ret instanceof PBMessage )
    {
      if( $ret instanceof $respclass )
      {
//        $resp->set_serialized_response( $ret->SerializeToString() );
        $resp->set_serialized_response( $ret->SerializeToPHPSerialize() );
      }
      else
      {
        $this->_return_message_error( 5, sprintf("Response is not of class '%s'", $respclass), $request->id() );
      }
    }

    $resp->set_debug_output( ob_get_contents() );
    $resp->set_debug_errors( var_dump_string($actindo_occured_errors) );
    ob_end_clean();

    echo $this->_encode_response( $resp->SerializeToPHPSerialize() );
//    echo $this->_encode_response( $resp->SerializeToString() );

    return TRUE;
  }


  function actindo_error_handler( $errno, $errstr, $errfile=null, $errline=null, $errcontext=null )
  {
    global $actindo_occured_errors;
    if( ($errno & error_reporting()) == 0 )
      return;
    $actindo_occured_errors[] = array( $errno, $errstr, $errfile, $errline );
  }



  protected function _return_message_error( $code, $text, $id )
  {
    global $actindo_occured_errors;

    $error = new Error( );
    $error->set_error_type( Error_ErrorType::MESSAGE );
    $error->set_code( $code );
    $error->set_text( $text );

    $resp = new Response( );
    $resp->set_error( $error );
    $resp->set_id( $id );
    $resp->set_debug_output( ob_get_contents() );
    $resp->set_debug_errors( var_dump_string($actindo_occured_errors) );
    ob_end_clean();

//    echo $this->_encode_response( $resp->SerializeToString() );
    echo $this->_encode_response( $resp->SerializeToPHPSerialize() );
  }

  protected function _return_application_error( $code, $text, $id )
  {
    global $actindo_occured_errors;

    $error = new Error( );
    $error->set_error_type( Error_ErrorType::APPLICATION );
    $error->set_code( $code );
    $error->set_text( $text );

    $resp = new Response( );
    $resp->set_error( $error );
    $resp->set_id( $id );
    $resp->set_debug_output( ob_get_contents() );
    $resp->set_debug_errors( var_dump_string($actindo_occured_errors) );
    ob_end_clean();

//    echo $this->_encode_response( $resp->SerializeToString() );
    echo $this->_encode_response( $resp->SerializeToPHPSerialize() );
  }

  protected function _encode_response( $str )
  {
    header( 'X-PBRPC-Response-Encoding: '.$this->response_encoding );
    if( !strcasecmp($this->response_encoding, 'base64') )
      return base64_encode( $str );
    else
      return $str;
  }


  protected function _listMethods( )
  {
    
  }


}


?>