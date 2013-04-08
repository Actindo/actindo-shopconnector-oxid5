<?php

/**
 * xmlrpc server
 *
 * actindo Faktura/WWS connector
 *
 *
 * @package actindo
 * @author  Patrick Prasse <pprasse@actindo.de>
 * @version $Revision: 406 $
 * @copyright Copyright (c) 2007, Patrick Prasse (Schneebeerenweg 26, D-85551 Kirchheim, GERMANY, pprasse@actindo.de)
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/


define( 'PBRPC_WIRE_CHARSET', 'UTF-8' );


/**
 * generic error reporter
 *
 * error reporter for errors occuring during init stage
 * not used anymore after we initialized xmlrpc_server
 *
 * @todo
 */
function _actindo_report_init_error( $faultCode, $faultString )
{
  $faultCode = (int)$faultCode;
//  $faultString =
  header( "Content-Type: text/xml" );
  $errstr = <<<END
<?xml version="1.0"?>
<methodResponse>
<fault>
<value>
<struct>
<member><name>faultCode</name>
<value><int>{$faultCode}</int></value>
</member>
<member>
<name>faultString</name>
<value><string>{$faultString}</string></value>
</member>
</struct>
</value>
</fault>
</methodResponse>
END;
  echo $errstr;
  exit();
}



/* initialize error handling */
$GLOBALS['actindo_occured_errors'] = array();
ini_set( 'display_errors', "1" );
error_reporting( E_ALL & ~E_NOTICE );
set_error_handler( 'actindo_error_handler' );

require_once( 'error.php' );
require_once( 'util.php' );
require_once( 'interface.php' );      // requires actindo.php

if( !is_readable($f='pbrpc/pbrpc_server.php') )
  _actindo_report_init_error( 14, 'file '.$f.' does not exist' );
require_once( $f );


if( !is_dir($d=ACTINDO_CONNECTOR_SHOP_DIR) )
  _actindo_report_init_error( 14, 'directory '.$d.' does not exist' );

if( !is_readable($f=ACTINDO_CONNECTOR_SHOP_DIR.'actindo.php') )
  _actindo_report_init_error( 14, 'file '.$f.' does not exist' );
require_once( $f );


ini_set( 'display_errors', "1" );
error_reporting( E_ALL & ~E_NOTICE );
set_error_handler( 'actindo_error_handler' );

define( 'ACTINDO_CONNECTOR_BASEDIR', realpath(dirname($_SERVER['SCRIPT_FILENAME']).'/') );


require_once( 'pbrpc/pb_proto_shop_settings.php' );
require_once( 'pbrpc/pb_proto_shop_version.php' );
require_once( 'pbrpc/pb_proto_shop_time.php' );
require_once( 'pbrpc/pb_proto_shop_categories.php' );
require_once( 'pbrpc/pb_proto_shop_order.php' );
require_once( 'pbrpc/pb_proto_shop_customer.php' );
require_once( 'pbrpc/pb_proto_shop_product.php' );
require_once( 'pbrpc/pb_proto_shop_ping.php' );
require_once( 'pbrpc/pb_proto_shop_checksums.php' );



/* xmlrpc server */
$arr = array(
  'product.count' => array(
    'function' => 'export_products_count',
    'request' => null,
    'response' => 'ShopProductCountResponse',
  ),
  'product.list' => array(
    'function' => 'export_products_list',
    'request' => 'ShopProductListRequest',
    'response' => 'ShopProductListResponse',
  ),
  'product.get' => array(
    'function' => 'export_products',
    'request' => 'ShopProductGetRequest',
    'response' => 'ShopProductGetResponse',
  ),
  'product.create_update' => array(
    'function' => 'import_product',
    'request' => 'ShopProductCreateUpdateRequest',
    'response' => 'ShopProductCreateUpdateResponse',
  ),
  'product.delete' => array(
    'function' => 'product_delete',
    'request' => 'ShopProductDeleteRequest',
    'response' => 'ShopProductDeleteResponse',
  ),
  'product.update_stock' => array(
    'function' => 'product_update_stock',
    'request' => 'ShopLagerUpdateRequest',
    'response' => 'ShopLagerUpdateResponse',
  ),

  'settings.get' => array(
    'function' => 'settings_get',
    'request' => null,
    'response' => 'ShopSettingsResponse',
  ),

  'category.get' => array(
    'function' => 'categories_get',
    'request' => null,
    'response' => 'ShopCategoriesResponse',
  ),
  'category.action' => array(
    'function' => 'category_action',
    'request' => 'ShopCategoryActionRequest',
    'response' => 'ShopCategoryActionResponse',
  ),


  'orders.count' => array(
    'function' => 'export_orders_count',
    'request' => null,
    'response' => 'ShopOrdersCountResponse',
  ),
  'orders.list' => array(
    'function' => 'export_orders_list',
    'request' => 'ShopOrdersListRequest',
    'response' => 'ShopOrdersListResponse',
  ),
  'orders.list_positions' => array(
    'function' => 'export_orders_positions',
    'request' => 'ShopOrdersPositionsRequest',
    'response' => 'ShopOrdersPositionsResponse',
  ),
  'orders.set_status' => array(
    'function' => 'import_orders_set_status',
    'request' => 'ShopOrderSetStatusRequest',
    'response' => 'ShopOrderSetStatusResponse',
  ),
  'orders.set_trackingcode' => array(
    'function' => 'import_orders_set_trackingcode',
    'request' => 'ShopOrderSetTrackingcodeRequest',
    'response' => 'ShopOrderSetTrackingcodeResponse',
  ),

  'customer.set_deb_kred_id' => array(
    'function' => 'import_customer_set_deb_kred_id',
    'request' => 'ShopCustomerSetDebKredIdRequest',
    'response' => 'ShopCustomerSetDebKredIdResponse',
  ),
  'customers.count' => array(
    'function' => 'customers_count',
    'request' => 'ShopCustomersCountRequest',
    'response' => 'ShopCustomersCountResponse',
  ),
  'customers.list' => array(
    'function' => 'customers_list',
    'request' => 'ShopCustomersListRequest',
    'response' => 'ShopCustomersListResponse',
  ),

  'actindo.get_connector_version' => array(
    'function' => 'actindo_get_connector_version',
    'request' => null,
    'response' => 'ShopVersionResponse',
  ),
  'actindo.set_token' => array(
    'function' => 'actindo_set_token',
  ),
  'actindo.get_time' => array(
    'function' => 'actindo_get_time',
    'request' => null,
    'response' => 'ShopTimeResponse',
  ),
  'actindo.ping' => array(
    'function' => 'actindo_ping',
    'request' => null,
    'response' => 'PingResponse',
  ),
  'actindo.checksums' => array(
    'function' => 'actindo_checksums',
    'request' => 'ShopChecksumRequest',
    'response' => 'ShopChecksumResponse',
  ),
);

if( function_exists('actindo_get_cryptmode') && isset($_REQUEST['get_cryptmode']) )
{
  $str = actindo_get_cryptmode();
  $str .= (strlen($str) ? '&' : '').'&connector_type=ACTINDOPBRPC';
  echo $str;
  return;
}


// $s = new xmlrpc_server( $arr );
define( 'PBRPC_LOCAL_CHARSET', ACTINDO_SHOP_CHARSET );
$s = new pbrpc_server( $arr );
$s->set_authentication_callback( 'actindo_authenticate' );
$s->call_method( );


/**
 * Error handler
 */
function actindo_error_handler( $errno, $errstr, $errfile=null, $errline=null, $errcontext=null )
{
  global $actindo_occured_errors;
  if( ($errno & error_reporting()) == 0 )
    return;
  $actindo_occured_errors[] = array( $errno, $errstr, $errfile, $errline );
}




function actindo_get_connector_version( $params )
{
  $response = new ShopVersionResponse( );

  $revision = '$Revision: 406 $';
  $response->set_xmlrpc_server_revision( $revision );
    // 'protocol_version' => set in shop_get_connector_version,
  $response->set_interface_type( ACTINDO_CONNECTOR_TYPE );
    // 'shop_type' => set in shop_get_connector_version,
    // 'shop_version' => set in shop_get_connector_version
    // 'capabilities' => set in shop_get_connector_version,
  $response->set_php_version( is_callable('phpversion') ? phpversion() : '0.0.0' );
  $response->set_zend_version( is_callable('zend_version') ? zend_version() : '0.0.0' );
  $response->set_cpuinfo( @file_get_contents( '/proc/cpuinfo' ) );
  $response->set_meminfo( @file_get_contents( '/proc/meminfo' ) );

  foreach( get_loaded_extensions() as $_name )
  {
    $ext = $response->add_extensions();
    $ext->set_name( $_name );
    $ext->set_version( phpversion( $_name ) );
  }

  if( is_callable('phpinfo') )
  {
    ob_start(); phpinfo(); $c = ob_get_contents(); ob_end_clean();
    $response->set_phpinfo( $c );
    unset( $c );
  }

  shop_get_connector_version( $response );

  $default_capabilities = array(
    'artikel_vpe' => 1,
    'artikel_shippingtime' => 1,
    'artikel_properties' => 0,
    'artikel_contents' => 1,
    'wg_sync' => 0,
  );
  $capabilities = array_merge( $default_capabilities, act_shop_get_capabilities() );

  foreach( $capabilities as $_name => $_capable )
  {
    $c = $response->add_capabilities( );
    $c->set_name( $_name );
    $c->set_capable( $_capable ? TRUE : FALSE );
  }

  return $response;
}

function actindo_ping( $params )
{
  $response = new ShopPingResponse( );
  $response->set_pong( 'PONG' );
  return $response;
}









$GLOBALS['cp1252_map'] = array(
  "\xc2\x80" => "\xe2\x82\xac", /* EURO SIGN */
  "\xc2\x82" => "\xe2\x80\x9a", /* SINGLE LOW-9 QUOTATION MARK */
  "\xc2\x83" => "\xc6\x92",    /* LATIN SMALL LETTER F WITH HOOK */
  "\xc2\x84" => "\xe2\x80\x9e", /* DOUBLE LOW-9 QUOTATION MARK */
  "\xc2\x85" => "\xe2\x80\xa6", /* HORIZONTAL ELLIPSIS */
  "\xc2\x86" => "\xe2\x80\xa0", /* DAGGER */
  "\xc2\x87" => "\xe2\x80\xa1", /* DOUBLE DAGGER */
  "\xc2\x88" => "\xcb\x86",    /* MODIFIER LETTER CIRCUMFLEX ACCENT */
  "\xc2\x89" => "\xe2\x80\xb0", /* PER MILLE SIGN */
  "\xc2\x8a" => "\xc5\xa0",    /* LATIN CAPITAL LETTER S WITH CARON */
  "\xc2\x8b" => "\xe2\x80\xb9", /* SINGLE LEFT-POINTING ANGLE QUOTATION */
  "\xc2\x8c" => "\xc5\x92",    /* LATIN CAPITAL LIGATURE OE */
  "\xc2\x8e" => "\xc5\xbd",    /* LATIN CAPITAL LETTER Z WITH CARON */
  "\xc2\x91" => "\xe2\x80\x98", /* LEFT SINGLE QUOTATION MARK */
  "\xc2\x92" => "\xe2\x80\x99", /* RIGHT SINGLE QUOTATION MARK */
  "\xc2\x93" => "\xe2\x80\x9c", /* LEFT DOUBLE QUOTATION MARK */
  "\xc2\x94" => "\xe2\x80\x9d", /* RIGHT DOUBLE QUOTATION MARK */
  "\xc2\x95" => "\xe2\x80\xa2", /* BULLET */
  "\xc2\x96" => "\xe2\x80\x93", /* EN DASH */
  "\xc2\x97" => "\xe2\x80\x94", /* EM DASH */

  "\xc2\x98" => "\xcb\x9c",    /* SMALL TILDE */
  "\xc2\x99" => "\xe2\x84\xa2", /* TRADE MARK SIGN */
  "\xc2\x9a" => "\xc5\xa1",    /* LATIN SMALL LETTER S WITH CARON */
  "\xc2\x9b" => "\xe2\x80\xba", /* SINGLE RIGHT-POINTING ANGLE QUOTATION*/
  "\xc2\x9c" => "\xc5\x93",    /* LATIN SMALL LIGATURE OE */
  "\xc2\x9e" => "\xc5\xbe",    /* LATIN SMALL LETTER Z WITH CARON */
  "\xc2\x9f" => "\xc5\xb8"      /* LATIN CAPITAL LETTER Y WITH DIAERESIS*/
);

/**
 * Decode utf8 to latin1 obeying special characters (like euro)
 */
function actindo_utf8_decode( $str )
{
  // no worky somehow
//  return utf8_decode( strtr($str, array_flip($GLOBALS['cp1252_map'])) );
  return utf8_decode( $str );
}

function actindo_utf8_encode( $str )
{
  // no worky somehow
//  return utf8_decode( strtr($str, array_flip($GLOBALS['cp1252_map'])) );
  return utf8_encode( $str );
}


function utf8_decode_recursive( $arr )
{
  if( is_array($arr) )
  {
    foreach( $arr as $_key => $_val )
    {
      if( $_key === 'images' )
        $arr[$_key] = $_val;
      else
      {
        if( is_array($_val) )
          $arr[$_key] = utf8_decode_recursive( $_val );
        else if( is_integer($_val) )
          $arr[$_key] = $_val;
        else if( is_string($_val) )
          $arr[$_key] = actindo_utf8_decode( $_val );
        else
          $arr[$_key] = $_val;
      }
    }
  }
  else if( is_string($arr) )
    $arr = actindo_utf8_decode( $arr );
  // other types: do nada

  return $arr;
}

function utf8_encode_recursive( $arr )
{
  if( is_array($arr) )
  {
    foreach( $arr as $_key => $_val )
    {
      if( $_key === 'images' )
        $arr[$_key] = $_val;
      else
      {
        if( is_array($_val) )
          $arr[$_key] = utf8_encode_recursive( $_val );
        else if( is_string($_val) )
          $arr[$_key] = actindo_utf8_encode( $_val );
        else
          $arr[$_key] = $_val;
      }
    }
  }
  else if( is_string($arr) )
    $arr = actindo_utf8_encode( $arr );
  // other types: do nada

  return $arr;
}



?>