<?php

/**
 * various utilities
 *
 * actindo Faktura/WWS connector
 *
 * @package actindo
 * @author  Patrick Prasse <pprasse@actindo.de>
 * @version $Revision: 494 $
 * @copyright Copyright (c) 2007, Patrick Prasse (Schneebeerenweg 26, D-85551 Kirchheim, GERMANY, pprasse@actindo.de)
*/

/**
 * NICHT ÄNDERN
 */
function act_get_shop_type( )
{
  return SHOP_TYPE_OXID5;
}


/**
 * Mapping der Anreden auf Herr/Frau
 */
function actindo_get_salutation_map( )
{
  $gender = array(
    'Mr' => 'Herr',
    'Mrs' => 'Frau',
    'Ms' => 'Frau',
    'MR' => 'Herr',
    'MRS' => 'Frau',
    'MS' => 'Frau',
  );
  return $gender;
}


/**
 * Mapping der OXID der Preisgruppe (aus Table oxgroups) zu actindo-Preisgruppen
 *
 * actindo zählt hier dann noch den eingestellten Offset (meist 250) hinzu
 */
function get_pg_map()
{
  $_pg_map = array(
//   OXID der Preisgruppe       |     Preisgruppen-ID actindo (aufsteigend ab 1!!)
    'oxidpricea'                =>    1,
    'oxidpriceb'                =>    2,
    'oxidpricec'                =>    3,
  );
  return $_pg_map;
}



function _act_get_pricegroups( )
{
  $pricegroups = array();

  if($GLOBALS['myConfig']->getEdition()=='EE')
    {
    $res1 = act_db_query( "SELECT * FROM `oxshops`" );
    while( $row = act_db_fetch_assoc($res1) )
      {
      $pricegroups[strlen((string)$row['oxid']).$row['oxid']."0"] = 'Grundpreis ('.$row['oxname'].')';

      foreach( get_pg_map() as $_oxid => $_pgid )
        {
          $p = act_db_get_single_row( "SELECT `oxtitle` FROM `oxgroups` WHERE `oxid`='".esc($_oxid)."'" );
          !empty($p) or $p = 'Preisgruppe '.$_pgid;
          $escind=strlen((string)$row['oxid']).$row['oxid'].$_pgid;
          $csm=0;

          $pricegroups[$escind] = $p." (".$row['oxname'].")";
        }
      }
    }
  else
    {
    $pricegroups[0] = 'Grundpreis';
    foreach( get_pg_map() as $_oxid => $_pgid )
      {
        $p = act_db_get_single_row( "SELECT `oxtitle` FROM `oxgroups` WHERE `oxid`='".esc($_oxid)."'" );
        !empty($p) or $p = 'Preisgruppe '.$_pgid;
        $pricegroups[$_pgid] = $p;
      }
    }

  return $pricegroups;
}

function _act_get_pricegroups_to_field( )
{
  $pricegroups = array();
  $i = 0;
  $pricegroups[$i++] = 'oxprice';
  $fields = actindo_get_table_fields( 'oxarticles' );
  foreach( $fields as $_fieldname )
  {
    if( !preg_match('/^oxprice(\w+)$/', $_fieldname, $matches) )
      continue;
    $pricegroups[$i] = strtolower( $matches[0] );
    $i++;
  }
  return $pricegroups;
}



//
// NOTE:
//
function default_lang( )
{
  return $GLOBALS['myConfig']->getConfigParam('sDefaultLang') + 1;
}

function get_language_id_by_code( $code )
{
  $i = 0;
  foreach( $GLOBALS['myConfig']->getConfigParam('aLanguages') as $key => $val )
  {
    $i++;
    if( $key == $code )
      return $i;
  }
  return null;
}

function get_language_code_by_id( $languages_id )
{
  $i = 0;
  foreach( $GLOBALS['myConfig']->getConfigParam('aLanguages') as $key => $val )
  {
    $i++;
    if( $i == $languages_id )
      return $key;
  }
  return null;
}

function _actindo_get_lang_field( $fieldname, $language_id )
{
  if( $language_id == 1 )
    return $fieldname;
  return sprintf( "%s_%d", $fieldname, $language_id-1 );
}

function get_language_id_to_code()
{
  $arr = array();
  $i = 0;
  foreach( $GLOBALS['myConfig']->getConfigParam('aLanguages') as $key => $val )
  {
    $arr[++$i] = $key;
  }
  return $arr;
}



function actindo_get_table_fields( $table )
{
  global $export;

  $cols = array();
  $result = act_db_query( "DESCRIBE $table" );
  while( $row = act_db_fetch_assoc( $result ) )
  {
    $cols[] = strtolower( current($row) );
  }
  act_db_free( $result );
  return $cols;
}



function check_admin_pass( $pass, $login )
{
  $login = trim( $login );

  return TRUE;

  $oDb = oxDb::getDb();

  $okay = $oDb->getOne( "SELECT IF(".$oDb->Quote($pass)."=oxpassword,1,0) AS okay FROM oxuser WHERE oxusername=".$oDb->quote($login) );
  if( $okay > 0 )
    return TRUE;

  return FALSE;
}





function _actindo_get_verf( $payment_modulename )
{
  $payment_modulename = 'MODULE_PAYMENT_'.strtoupper( $payment_modulename ).'_actindo_VERF';
  if( !defined($payment_modulename) )
    return null;
  return constant( $payment_modulename );
}


function act_failsave_db_query( $text )
{
  return mysql_query( $text );
}

function act_db_query( $text )
{
  try
  {
    $db = oxDb::getDb();

    $fm = $db->setFetchMode( ADODB_FETCH_ASSOC );
    $res = &$db->Execute( $text );
    $db->setFetchMode( $fm );
  }
  catch( Exception $e )
  {
    return FALSE;
  }
  return $res;
}

function act_db_free( &$res )
{
  if( !is_object($res) )
    return null;

  return $res->Close( );
}

function act_db_num_rows( &$res )
{
  if( !is_object($res) )
    return null;

  return $res->RecordCount();
}

function act_db_fetch_array( &$res )
{
  if( !is_object($res) )
    return null;

  $row = $res->FetchRow();
  $row1 = array();
  if( is_array($row) )
  {
    foreach( $row as $_key => $_val )
    {
      if( is_string($_key) )
        $row1[strtolower($_key)] = $_val;
      else
        $row1[$_key] = $_val;
    }
  }
  else
    $row1 = $row;

  return $row1;
}

function act_db_fetch_assoc( $res )
{
  return act_db_fetch_array( $res );
}

function act_db_fetch_row( $res )
{
  $row = act_db_fetch_array( $res );
  if( !is_array($row) || !count($row) )
    return $row;
  $data = array();
  foreach( $row as $_val )
    $data[] = $_val;
  return $data;
}

function act_db_insert_id( $res=null )
{
  $db = oxDb::getDb();
  return $db->Insert_ID();
}

function act_affected_rows( )
{
  $db = oxDb::getDb();
  return $db->Affected_Rows();
}

function esc( $str )
{
  return mysql_real_escape_string( $str );
}

function act_db_get_single_row( $query )
{
  $res = act_db_query( $query );
  if( !$res )
    return null;
  $row = act_db_fetch_row( $res );
  act_db_free( $res );
  if( is_array($row) && count($row) == 1 )
    return $row[0];
  return $row;
}


function act_have_table( $name )
{
  global $act_have_table_cache;
  is_array($act_have_table_cache) or $act_have_table_cache = array();
  if( isset($act_have_table_cache[$name]) )
    return $act_have_table_cache[$name];

  $have=FALSE;
  $res = act_db_query( "SHOW TABLES LIKE '".esc($name)."'" );
  while( $n=act_db_fetch_row($res) )    // get mixed case here, therefore check again
  {
    if( !strcmp( $n[0], $name ) )
    {
      $have=TRUE;
      break;
    }
  }
  act_db_free( $res );
  $act_have_table_cache[$name] = $have;
  return $have;
}

function act_have_column( $tablename, $column )
{
  $have = FALSE;

  $res = act_db_query( "DESCRIBE {$tablename}" );
  while( $row = act_db_fetch_row($res) )
  {
    $have |= ($row[0] == $column);
  }
  act_db_free( $res );

  return $have;
}



function act_get_tax_rate( $class_id )
{
  require_once( SHOP_BASEDIR._SRV_WEB_FRAMEWORK.'classes/class.tax.php' );
  $tax_rate = new tax();
  return $tax_rate->_getTaxRates( $class_id );
}


/**
 * Construct SET statement for INSERT,UPDATE,REPLACE with escaping the data
 *
 * This method also takes care of field names which are in the array but not in
 * the table.
 *
 * @param array Array( 'fieldname'=>'data for field'
 * @param string Table name to read field descriptions from
 * @param boolean Do not escape the data to be inserted (USE WITH GREAT CARE)
 * @param boolean Encode null as NULL? (Normally null is encoded as empty string)
 * @returns array Result array( 'ok'=>TRUE/FALSE, 'set'=> string( 'SET `field1`='data1',...), 'warning'=>string() )
*/
function construct_set( $data, $table, $noescape=FALSE, $encode_null=TRUE )
{
  $fields = array();
  $set = "SET ";
  $warning = "";
  $ok = TRUE;

  $fields = actindo_get_table_fields( $table );

  foreach( $data as $field => $data )
  {
    $field = trim( $field );
    if( !in_array( $field, $fields ) )
    {
      $warning .= "Field $field does not exsist in $table!\n";
      continue;
    }

    if( $encode_null && is_null($data) )
    {
      $set .= "`$field`=NULL,";
      continue;
    }

    if( ! $noescape )
      $data = mysql_real_escape_string( $data );
    $set .= "`$field`='$data',";
  }

  if( substr( $set, strlen($set)-1, 1 ) == ',' )
    $set = substr( $set, 0, strlen($set)-1 );
  return array( "ok" => $ok, "set" => $set, "warning" => $warning );
}




/* ******** admin interface **** */

function actindo_check_config( )
{
}




/**
 * @todo
 */
function actindo_create_temporary_file( $data )
{
  global $import;

  $tmp_name = tempnam( "/tmp", "" );
  if( $tmp_name === FALSE || !is_writable($tmp_name) )
    $tmp_name = tempnam( ini_get('upload_tmp_dir'), "" );
  if( $tmp_name === FALSE || !is_writable($tmp_name) )
    $tmp_name = tempnam( $GLOBALS['myConfig']->getConfigParam('sCompileDir'), "" );   // last resort: try sCompileDir
  if( $tmp_name === FALSE || !is_writable($tmp_name) )
    return array( 'ok' => FALSE, 'errno' => EIO, 'error' => 'Konnte keine temporäre Datei anlegen' );
  $written = file_put_contents( $tmp_name, $data );
  if( $written != strlen($data) )
  {
    $ret = array( 'ok' => FALSE, 'errno' => EIO, 'error' => 'Fehler beim schreiben des Bildes in das Dateisystem (Pfad '.var_dump_string($tmp_name).', written='.var_dump_string($written).', filesize='.var_dump_string(@filesize($tmp_name)).')' );
    unlink( $tmp_name );
    return $ret;
  }

  return array( 'ok'=>TRUE, 'file' => $tmp_name );
}

/**
 * @todo
 */
function actindo_delete_temporary_file( $tmp_name )
{
  global $import;

  if(is_file($tmp_name))
    unlink( $tmp_name );

  //always ok since this dosen't block behavior
  return array( 'ok'=>TRUE, 'file' => $tmp_name );
}


/**
 * actindo ADODB Error Handler. This will be called with the following params
 *
 * @param $dbms         the RDBMS you are connecting to
 * @param $fn           the name of the calling function (in uppercase)
 * @param $errno                the native error number from the database
 * @param $errmsg       the native error msg from the database
 * @param $p1           $fn specific parameter - see below
 * @param $p2           $fn specific parameter - see below
 * @param $thisConn     $current connection object - can be false if no connection object created
 */
function actindo_ADODB_Error_Handler($dbms, $fn, $errno, $errmsg, $p1, $p2, &$thisConnection)
{
  if (error_reporting() == 0) return; // obey @ protocol
  switch($fn) {
          case 'EXECUTE':
                  $sql = $p1;
                  $inputparams = $p2;

                  $s = "$dbms error: [$errno: $errmsg] in $fn(\"$sql\")\n";
                  break;

          case 'PCONNECT':
          case 'CONNECT':
                  $host = $p1;
                  $database = $p2;

                  $s = "$dbms error: [$errno: $errmsg] in $fn($host, '****', '****', $database)\n";
                  break;
          default:
                  $s = "$dbms error: [$errno: $errmsg] in $fn($p1, $p2)\n";
                  break;
  }

  $t = date('Y-m-d H:i:s');
  trigger_error("ADODB_ERROR ($t) $s", E_USER_WARNING);
}


function datetime_to_timestamp( $date )
{
  preg_match( '/(\d+)-(\d+)-(\d+)\s+(\d+):(\d+)(:(\d+))/', $date, $ndate );
  if( (!((int)$ndate[1]) && !((int)$ndate[2]) && !((int)$ndate[0])) )
    {
    preg_match( '/(\d+)-(\d+)-(\d+)/', $date, $ndate );
    
    if( (!((int)$ndate[1]) && !((int)$ndate[2]) && !((int)$ndate[0])) )
        return -1;
    }
    
  return mktime( (int)$ndate[4], (int)$ndate[5], (int)$ndate[7], (int)$ndate[2], (int)$ndate[3], (int)$ndate[1] );
}



function actindo_checksums( $request )
{
  $response = new ShopChecksumResponse();
  $subdirectory = $request->subdirectory();
  $pattern = $request->pattern();
  $checksum_type = $request->checksum_type();
  $recursive = $request->recursive();


  $path = add_last_slash( ACTINDO_SHOP_BASEDIR ).$subdirectory;
  if( is_file($path) )
  {
    $files_arr = array( $subdirectory => _checksum_file( $path, $checksum_type ) );
  }
  else
  {
    $files_arr = array();
    $files_arr_2 = _checksum_dir( $path, $pattern, $checksum_type, $recursive );
    foreach( $files_arr_2 as $_fn => $_cs )
    {
      $_fn = substr( $_fn, strlen($path) );
      $files_arr[$_fn] = $_cs;
    }
  }

  $conn_relative_dir = 'actindo/';

  foreach( array_keys($files_arr) as $fn )
  {
    if( strpos($fn, $conn_relative_dir) === 0 )
    {
      $fn1 = strtr( $fn, array($conn_relative_dir => 'SHOPCONN-'.constant('ACTINDO_PROTOCOL_REVISION').'/') );
      $files_arr[$fn1] = $files_arr[$fn];
      unset( $files_arr[$fn] );
    }
  }

  $response->set_n_sums( count($files_arr) );


  foreach( $files_arr as $_path => $_checksum )
  {
    $c = $response->add_checksums();
    $c->set_path( $_path );
    $c->set_checksum( $_checksum );
  }

  return $response;
}

function _checksum_dir( $dirname, $pattern, $checksum_type, $recursive )
{
  $dirs = array();
  $files = array();

  $dir = opendir( $dirname );
  if( !is_resource($dir) )
    return FALSE;

  while( $fn = readdir($dir) )
  {
    if( $fn == '.' || $fn == '..' )
      continue;

    if( $fn == 'templates_c' )
      continue;

    $basename = $fn;
    $fn = add_last_slash($dirname).$fn;

    if( is_dir($fn) )
      $dirs[] = $fn;
    else if( is_file($fn) && (!function_exists('fnmatch') || fnmatch($pattern, $basename)) )
    {
      $files[$fn] = _checksum_file( $fn, $checksum_type );
    }
  }
  closedir( $dir );

  if( $recursive && count($dirs) )
  {
    foreach( $dirs as $_dir )
    {
      $files = array_merge( $files, _checksum_dir($_dir, $pattern, $checksum_type, $recursive) );
    }
  }

  return $files;
}


function _checksum_file( $fn, $checksum_type='MD5' )
{
  if( !is_readable($fn) )
  {
    return 'UNREADABLE';
  }

  if( empty($checksum_type) )
    return 'NO-CHECKSUM-TYPE';

  if( $checksum_type == 'FILESIZE' )
    return filesize( $fn );

  $data = file_get_contents( $fn );
  if( $checksum_type == 'MD5' )
  {
    $data = md5( $data );
  }
  else if( $checksum_type == 'SHA1' )
  {
    $data = sha1( $data );
  }
  else if( $checksum_type == 'MD5-TRIM' )
  {
    $data = strtr( $data, array("\r"=>"", "\n"=>"", "\t"=>"", " "=>"") );
    $data = md5( trim($data) );
  }
  else if( $checksum_type == 'SHA1-TRIM' )
  {
    $data = strtr( $data, array("\r"=>"", "\n"=>"", "\t"=>"", " "=>"") );
    $data = sha1( trim($data) );
  }
  else if( $checksum_type == 'SIZE' )
  {
    $data = strlen( $data );
  }
  else if( $checksum_type == 'SIZE-TRIM' )
  {
    $data = strtr( $data, array("\r"=>"", "\n"=>"", "\t"=>"", " "=>"") );
    $data = strlen( trim($data) );
  }
  return $data;
}

?>