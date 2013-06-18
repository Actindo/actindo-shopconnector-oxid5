<?php

/**
 * include various files
 *
 **
 * actindo Faktura/WWS connector
 **
 * @package actindo
 * @author  Patrick Prasse <pprasse@actindo.de>
 * @version $Revision: 3004g$
 * @copyright Copyright (c) 2007, Patrick Prasse (Schneebeerenweg 26, D-85551 Kirchheim, GERMANY, pprasse@actindo.de)
 */

define( 'ACTINDO_SHOPCONN_REVISION', '$Revision: 3004g$' );
define( 'ACTINDO_PROTOCOL_REVISION_MINOR',trim(substr(ACTINDO_SHOPCONN_REVISION,11,-1)));
define( 'ACTINDO_PROTOCOL_REVISION', '2.'.ACTINDO_PROTOCOL_REVISION_MINOR);

/* change dir into admin interface and include application_top.php */
if( !strlen($wd) || !strlen($dwd) || $dwd == '/' || !is_file($dwd.'/core/oxconfig.php') )
{
  $wd = $_SERVER['SCRIPT_FILENAME'];
  $dwd = realpath( dirname($wd).'/../' );
  if( $dwd === FALSE )
    $dwd = dirname( dirname($wd) );
}
if( !strlen($wd) || !strlen($dwd) || $dwd == '/' || !is_file($dwd.'/core/oxconfig.php') )
{
  $wd = $_SERVER['ORIG_SCRIPT_FILENAME'];
  $dwd = realpath( dirname($wd).'/../' );
  if( $dwd === FALSE )
    $dwd = dirname( dirname($wd) );
}
if( !strlen($wd) || !strlen($dwd) || $dwd == '/' || !is_file($dwd.'/core/oxconfig.php') )
{
  $wd = trim( $_SERVER['PATH_TRANSLATED'] );
  $dwd = realpath( dirname($wd).'/../' );
  if( $dwd === FALSE )
    $dwd = dirname( dirname($wd) );
}

define( 'ACTINDO_SHOP_BASEDIR', $dwd );

if( !chdir($p=$dwd.'/core/') )
  _actindo_report_init_error( 14, "Error while chdir to &#39;{$p}&#39;" );

// oxid-specific
ini_set('session.name', 'sid' );
ini_set('session.use_cookies', 0 );
ini_set('session.use_trans_sid', 0);
ini_set('url_rewriter.tags', '');
ini_set('magic_quotes_runtime', 0);


/**
* Returns shop base path.
*
* @return string
*/
function getShopBasePath()
{
    return ACTINDO_SHOP_BASEDIR.'/';
}

// custom functions file
include getShopBasePath() . 'modules/functions.php';

// Generic utility method file
require_once getShopBasePath() . 'core/oxfunctions.php';
require_once getShopBasePath() . 'core/oxsession.php';
require_once getShopBasePath() . 'core/oxregistry.php';
require_once getShopBasePath() . 'core/oxutils.php';
// Including main ADODB include
require_once getShopBasePath() . 'core/adodblite/adodb.inc.php';

 // Including needed oxid classes
require_once getShopBasePath() . 'application/models/oxbasket.php';
// require_once getShopBasePath() . 'core/oxsession.php';

// set the exception handler already here to catch everything, also uncaught exceptions from the config or utils

// New Config Class
$oConfigFile = new oxConfigFile( getShopBasePath() . "config.inc.php" );
oxRegistry::set("oxConfigFile", $oConfigFile );
$oFileUtils = oxRegistry::get("oxUtilsFile");


$GLOBALS['myConfig'] = oxRegistry::getConfig();;

// reset it so it is done with oxnew
$iDebug = $GLOBALS['myConfig']->getConfigParam('iDebug');
//set_exception_handler(array(oxNew('oxexceptionhandler', $iDebug), 'handleUncaughtException'));

define( 'ACTINDO_SHOP_CHARSET', $GLOBALS['myConfig']->getConfigParam('iUtfMode') != 0 ? 'UTF-8' : 'ISO-8859-1' );


//strips magics quote if any
oxUtils::getInstance()->stripGpcMagicQuotes();

error_reporting( E_ALL & ~E_NOTICE );
set_error_handler( 'actindo_error_handler' );


require_once( 'util.php' );
require_once( 'import.php' );
require_once( 'export.php' );



function actindo_authenticate( $user, $pass )
{
  $pass_verify = act_db_get_single_row( "SELECT `oxpassword` FROM `oxuser` WHERE `oxusername`='".esc($user)."' AND `oxrights`='malladmin'" );
  if( $pass === $pass_verify )
    return TRUE;

  return "Benutzername / Passwort inkorrekt.";
}


function categories_get( $params )
{
  $response = new ShopCategoriesResponse( );

  require_once getShopBasePath() . 'application/models/oxcategory.php';
  require_once getShopBasePath() . 'application/models/oxcategorylist.php';
  require_once( 'extends/actindo_oxcategorylist.php' );

  $shops=array();
  if($GLOBALS['myConfig']->getEdition()=='EE')
    {
    $res1 = act_db_query( "SELECT * FROM oxshops");

    while( $row = act_db_fetch_assoc($res1) )
      {
      $shops[]=$row['oxid'];
      }
    }
  else
    $shops=array(false);


  foreach($shops as $shop_id)
    {
    if($shop_id!=false)
      $shop_set="oxshopid='".$shop_id."' AND ";
    else
      $shop_set="";

    $Query="SELECT * FROM oxcategories WHERE ".$shop_set." oxparentid='oxrootid' ORDER BY oxsort";

    $res=act_db_query($Query);
    while($cat=act_db_fetch_assoc($res))
  {
    $category = $response->add_categories();

        $category->set_categories_id( $cat['oxid'] );
        $category->set_categories_name( $cat['oxtitle'] );

//    echo '0='; var_dump($cat->oxcategories__oxtitle->rawValue );
    _recurse_categories( $cat, $category );
  }
    }

  return $response;
}

function _recurse_categories( $cat, &$category, $depth=1 )
{
    $Query="SELECT * FROM oxcategories WHERE oxshopid='".$cat['oxshopid']."' AND oxparentid='".$cat['oxid']."'  ORDER BY oxsort";

    $res=act_db_query($Query);
    while($subcat=act_db_fetch_assoc($res))
      {
      $category1 = $category->add_children();

      $category1->set_categories_id( $subcat['oxid']);
      $category1->set_categories_name( $subcat['oxtitle'] );
      $category1->set_parent_id( $cat['oxid'] );

//    echo $depth.'=';var_dump($_cat->oxcategories__oxtitle->rawValue );
      _recurse_categories( $subcat, $category1, $depth++ );
      }
}

function _get_debitnote_paymentdata( $oxpaymentid ) {
  require_once getShopBasePath() . 'application/models/oxuserpayment.php';
  $ouPayment = new oxUserPayment();
  $key = $ouPayment->getPaymentKey();

  $oUP = act_db_query( $q="select oxid, oxuserid, oxpaymentsid, DECODE( oxvalue, '".$key."' ) as oxvalue from oxuserpayments where oxid = " . oxDb::getDb()->quote( $oxpaymentid ));
  while( $_res = act_db_fetch_assoc( $oUP ))  {
    $oPayment = $_res['oxvalue'];
  }

  $oPayment = explode( '@@', $oPayment );
  foreach( $oPayment as $key => $val )
  {
    if( strlen( $val ) ) {
      $tmp = explode( "__", $val );
      $ret[$tmp[0]] = $tmp[1];
    }
  }
  return $ret;
}


function category_action( $request )
{
  $response = new ShopCategoryActionResponse();

  require_once getShopBasePath() . 'application/models/oxcategory.php';
  require_once getShopBasePath() . 'application/models/oxcategorylist.php';
  require_once( 'extends/actindo_oxcategory.php' );

    $oxsort = null;
    $aid = $request->after_id();
    if( !empty($aid) )
    {
      $res = act_db_query( $q="SELECT `oxsort` FROM `oxcategories` WHERE `oxid`='".esc($request->after_id())."' AND `oxparentid`='".esc($request->parent_id())."'" );
      $row = act_db_fetch_array( $res );
      if( is_array($row) )
        $oxsort = (int)$row['oxsort'];
      act_db_free( $res );
    }
    else
        {
        $oxsort=0;
        }
    if( !is_null($oxsort) )
    {
      $res = act_db_query( $q="UPDATE `oxcategories` SET `oxsort`=`oxsort`+1 WHERE `oxsort`>".(int)$oxsort." AND `oxparentid`='".esc($request->parent_id())."'" );
      if( !$res )
      {
        $response->set_ok( FALSE );
        $response->set_errno( EIO );
        $response->set_error( "Datenbank-Fehler beim verschieben der Kategorie" );
        return $response;
      }
      $oxsort++;
    }
   else
    $oxsort=0;


  if( $request->point() == 'add' )
  {
    if( is_null($data=$request->data()) )
    {
      throw new Exception( "", 123 );
    }

    $langcode_to_id = array_flip( get_language_id_to_code() );

    $oc = new actindo_oxCategory();
    for( $idx=0; $idx < $data->description_size(); $idx++ )
    {
      $desc = &$data->description($idx);
      if( !isset($langcode_to_id[$desc->language_code()]) )
        continue;
      $language_id = $langcode_to_id[$desc->language_code()];

      if( !is_null($txt=$desc->name()) )
      {
        $var = 'oxcategories__'._actindo_get_lang_field('oxtitle', $language_id);
        // for some reason we have to set the value twice to get saved on php 5.2.8
        $oc->$var->rawValue = $txt;
        $oc->$var->rawValue = $txt;
        $oc->$var->value = $txt;
        $oc->$var->value = $txt;
      }
    }
    $oc->oxcategories__oxactive->value = 1;
    $oc->oxcategories__oxactive_1->value = 1;
    $oc->oxcategories__oxactive_2->value = 1;
    $oc->oxcategories__oxactive_3->value = 1;
    $oc->oxcategories__oxsort->value = $oxsort;
    $pid = $request->parent_id();
    $oc->oxcategories__oxparentid->value = !empty($pid) ? $pid : 'oxrootid';

    $ret = $oc->save();
    if( $ret === FALSE )
    {
      $response->set_ok( FALSE );
      $response->set_errno( EIO );
      $response->set_error( "Fehler beim speichern der Kategorie" );
    }
    else
    {
      $response->set_ok( TRUE );
      $response->set_id( $ret );
    }
  }
  else if( $request->point() == 'delete' )
  {
    $oc = new actindo_oxCategory();
    $res = $oc->load( $request->id() );
    if( !$res )
    {
      $response->set_ok( FALSE );
      $response->set_errno( ENOENT );
      $response->set_error( "Kategorie existiert nicht" );
    }
    else
    {
      $res = $oc->delete( );
      if( $res === FALSE )
      {
        $response->set_ok( FALSE );
        $response->set_errno( EIO );
        $response->set_error( "Kategorie enthält wahrscheinlich Artikel oder Unterkategorien" );
      }
      else
      {
        $response->set_ok( TRUE );
      }
    }
  }
  else if( $request->point() == 'textchange' )
  {
    if( is_null($data=$request->data()) )
    {
      throw new Exception( "", 123 );
    }

    $langcode_to_id = array_flip( get_language_id_to_code() );

    $change_fields = array();
    for( $idx=0; $idx < $data->description_size(); $idx++ )
    {
      $desc = &$data->description($idx);
      if( !isset($langcode_to_id[$desc->language_code()]) )
        continue;
      $language_id = $langcode_to_id[$desc->language_code()];
      if( !is_null($txt=$desc->name()) )
        $change_fields[_actindo_get_lang_field('oxtitle', $language_id)] = $txt;
    }
    if( count($change_fields) )
    {
      $set = construct_set( $change_fields, 'oxcategories' );
      $res = act_db_query( "UPDATE `oxcategories` ".$set['set']." WHERE `oxid`='".esc($request->id())."'" );
      $response->set_ok( $res ? true : false );
      if( !$res )
      {
        $response->set_errno( EIO );
        $response->set_error( "Fehler beim schreiben in die Datenbank" );
      }
    }
    else
    {
      $response->set_ok( TRUE );
    }
  }
  else if( $request->point() == 'above' || $request->point() == 'below' || $request->point() == 'append' )
  {
    $parent_oc = new actindo_oxCategory();
    $res = $parent_oc->load( $request->parent_id() );
    if( !$res )
    {
      $response->set_ok( FALSE );
      $response->set_errno( ENOENT );
      $response->set_error( "Die Kategorie, unter die die Kategorie geschoben werden soll, existiert nicht" );
      return $response;
    }

    $oc = new actindo_oxCategory();
    $res = $oc->load( $request->id() );
    if( !$res )
    {
      $response->set_ok( FALSE );
      $response->set_errno( ENOENT );
      $response->set_error( "Die Kategorie existiert nicht" );
      return $response;
    }

    $oc->setParentCategory( $parent_oc );
    $oc->oxcategories__oxparentid->value = $request->parent_id();
    $oc->oxcategories__oxparentid->rawValue = $request->parent_id();

    $oc->oxcategories__oxsort->value=$oxsort;
    $oc->oxcategories__oxsort->rawValue=$oxsort;

    $res = $oc->save();

    if( $res === FALSE )
    {
      $response->set_ok( FALSE );
      $response->set_errno( EIO );
      $response->set_error( "Fehler beim verschieben der Kategorie" );
    }
    else
    {
      $response->set_ok( TRUE );
    }

  }
  else
  {
  }

  return $response;
}



/**
 * @done
 */
function settings_get( $params )
{
  $response = new ShopSettingsResponse();
  $response->set_timestamp( time() );

  $i = 0;
  foreach( $GLOBALS['myConfig']->getConfigParam('aLanguages') as $key => $val )
  {
    $i++;
    $lang = $response->add_languages();
    $lang->set_language_code( $key );
    $lang->set_language_name( $val );
    $lang->set_language_id( $i );
    $lang->set_is_default( $i == 1 );
  }

  // manufacturers (Hersteller)
  foreach( export_manufacturers() as $_man )
  {
    $man = $response->add_manufacturers();
    $man->set_manufacturers_id( $_man['manufacturers_id'] );
    $man->set_manufacturers_name( $_man['manufacturers_name'] );
  }


  // vendors (Lieferanten)
  foreach( export_vendors() as $_man )
  {
    $man = $response->add_vendors();
    $man->set_vendors_id( $_man['vendors_id'] );
    $man->set_vendors_name( $_man['vendors_name'] );
  }

  // shippingtime
  foreach ( export_shippingtime() as $_sht ) {
    $sht = $response->add_shipping();
    $sht->set_shippingtime_id( md5( $_sht['name'] ) );
    $sht->set_shippingtime_name( $_sht['name'] );
  }

  // NO shipping_status

  // vpe
  foreach ( export_vpe() as $_vpe ) {
    $vpe = $response->add_vpe();
    $vpe->set_vpe_id( md5( $_vpe['name'] ) );
    $vpelang = $vpe->add_lang();
    $vpelang->set_vpe_lang_id( $_vpe['lang'] );
    $vpelang->set_vpe_lang_name( $_vpe['name'] );
  }

  // orders_status
  $i=0;
  foreach( $GLOBALS['myConfig']->getConfigParam('aOrderfolder') as $key => $color )
  {
    $i++;
    $os = $response->add_orders_status( );
    $os->set_id( (string)$i );
    $os->set_name( $key );
  }
//  var_dump($GLOBALS['myConfig']);

  // Cross-Selling, Zubehör
  for( $i=1; $i<=2; $i++ )
  {
    $xsg = $response->add_xsell_groups();
    $xsg->set_products_xsell_grp_name_id( $i );
    $xsg->set_groupname( $i == 1 ? 'Zubehoer-Artikel' : 'Crosssellings' );
  }


  // info_template
  $tpls = array();
  $arr = glob( getShopBasePath().'out/basic/tpl/details*.tpl' );
  foreach( $arr as $_filename )
  {
    $_fn = basename( $_filename );
    $tpls[$_fn] = $_fn;
  }

  // add all other used templates also...
  $res1 = act_db_query( "SELECT DISTINCT `oxtemplate` FROM `oxarticles`" );
  while( $row=act_db_fetch_assoc($res1) )
  {
    $tpls[$row['oxtemplate']] = $row['oxtemplate'];
  }
  act_db_free( $res1 );

  $it = $response->add_info_template();
  $it->set_id( "" );
  $it->set_name( "- Standard-Template -" );

  foreach( $tpls as $_tpl )
  {
    if( $_tpl == 'details.tpl' || empty($_tpl) )
      continue;

    $it = $response->add_info_template();
    $it->set_id( $_tpl );
    $it->set_name( $_tpl );
  }


  // NO options_template

  // customers_status
  foreach( _act_get_pricegroups() as $_pgid => $_pgname )
  {
    $status = $response->add_customers_status();
    $status->set_customers_status_id( $_pgid );
    $status->set_customers_status_name( $_pgname );
  }

  // installed_payment_modules
  $res1 = act_db_query( "SELECT * FROM `oxpayments`" );
  while( $row = act_db_fetch_assoc($res1) )
  {
    $pm = $response->add_installed_payment_modules();
    $pm->set_code( $row['oxid'] );
    $pm->set_name( $row['oxdesc'] );
    $pm->set_active( $row['oxactive'] );
    $pm->set_description( $row['oxlongdesc'] );
  }
  act_db_free( $res1 );

  // installed_shipping_modules
  $res1 = act_db_query( "SELECT * FROM `oxdeliveryset`" );
  while( $row = act_db_fetch_assoc($res1) )
  {
    $pm = $response->add_installed_shipping_modules();
    $pm->set_code( $row['oxid'] );
    $pm->set_name( $row['oxtitle'] );
    $pm->set_active( $row['oxactive'] );
  }
  act_db_free( $res1 );


  // NO property_sets

  // properties
  $res1 = act_db_query( "SELECT * FROM `oxattribute`" );
  while( $row = act_db_fetch_assoc($res1) )
  {
    $pm = $response->add_artikel_properties();
    $pm->set_field_id( $row['oxid'] );
    $pm->set_field_name( $row['oxtitle'] );
    $pm->set_field_i18n( TRUE );
    $pm->set_field_set( 'OXID-Attribute' );
    $pm->set_field_noempty( FALSE );
    $pm->set_field_type( ShopSettingsResponse_ArtikelPropertyFieldType::textfield );
  }
  act_db_free( $res1 );


  //multi-shops
  if($GLOBALS['myConfig']->getEdition()=='EE')
    {
    $res1 = act_db_query( "SELECT * FROM oxshops WHERE oxismultishop = 0 AND oxid!=1" );

    while( $row = act_db_fetch_assoc($res1) )
    {
    $pm = $response->add_multistores();
    $pm->set_id($row['oxid']);
    $pm->set_parent_id($row['oxparentid']);
    $pm->set_name($row['oxname']);
    $pm->set_url_http($row['oxurl']);
    $pm->set_url_https('');
    $pm->set_active($row['oxactive']);
    $pm->set_is_inherited($row['oxisinherited']);
    }
    act_db_free( $res1 );
    }

  return $response;
}

function _act_get_orderfolders( )
{
  $orderfolders = array();
  foreach( $GLOBALS['myConfig']->getConfigParam('aOrderfolder') as $key => $color )
  {
    $i++;
    $orderfolders[$i] = $key;
  }
  return $orderfolders;
}

function _act_get_langid_to_langcode( )
{
  $langcodes = array();

  $i = 0;
  foreach( $GLOBALS['myConfig']->getConfigParam('aLanguages') as $key => $val )
  {
    $i++;
    $langcodes[$i] = $key;
  }
  return $langcodes;
}



/**
 * @todo
 */
function actindo_set_token( $params )
{
}


/**
 * @done
 */
function actindo_get_time( $params )
{
  $response = new ShopTimeResponse( );

  $res = act_db_query( "SHOW VARIABLES LIKE 'version'" );
  $v_db = act_db_fetch_array( $res );
  act_db_free( $res );

  $res = act_db_query( "SELECT NOW() as datetime" );
  $time_database = act_db_fetch_array( $res );
  act_db_free( $res );

  if( version_compare($v_db['Value'], "4.1.1") > 0 )
  {
    $res = act_db_query( "SELECT UTC_TIMESTAMP() as datetime" );
    $utctime_database = act_db_fetch_array( $res );
    act_db_free( $res );
  }
  else
  {
    // we hope that utctime_database is the same as gmtime-server
    $utctime_database = array( 'datetime'=> '' );
  }

  $response->set_time_server( date( 'Y-m-d H:i:s' ) );
  $response->set_gmtime_server( gmdate( 'Y-m-d H:i:s' ) );
  $response->set_time_database( $time_database['datetime'] );
  $response->set_gmtime_database( $utctime_database['datetime'] );

  if( !empty($utctime_database['datetime']) )
  {
    $diff = strtotime( $time_database['datetime'] ) - strtotime( $utctime_database['datetime'] );
  }
  else
  {
    $diff = strtotime( date( 'Y-m-d H:i:s' ) ) - strtotime( gmdate( 'Y-m-d H:i:s' ) );
  }
  $response->set_diff_seconds( $diff );
  $diff_neg = $diff < 0;
  $diff = abs( $diff );
  $response->set_diff( ($diff_neg ? '-':'').sprintf( "%02d:%02d:%02d", floor($diff / 3600), floor( ($diff % 3600) / 60 ), $diff % 60 ) );

  return $response;
}


/**
 * @done
 */
function shop_get_connector_version( &$response )
{
  $response->set_revision( ACTINDO_SHOPCONN_REVISION );
  $response->set_protocol_version( ACTINDO_PROTOCOL_REVISION );
  $response->set_shop_type( act_get_shop_type( ) );
  $response->set_shop_version( $GLOBALS['myConfig']->getVersion().'-'.$GLOBALS['myConfig']->getEdition().'-r'.$GLOBALS['myConfig']->getRevision() );
  $response->set_default_charset( 'UTF-8' );
//  $response->set_capabilities( act_shop_get_capabilities() );
}


/**
 * @done
 */
function act_shop_get_capabilities()
{
  return array(
    'artikel_vpe' => 1,
    'artikel_shippingtime' =>1,
    'artikel_properties' => 1,
    'artikel_contents' => 1,
    'artikel_attributsartikel' => 1,    // Attributs-Kombinationen werden tatsächlich eigene Artikel
    'wg_sync' => 1,
    'multi_livelager' => 1,
//    'artikel_list_filters' => 1,  // ????
  );
}


/**
 * @done
 */
function actindo_get_cryptmode( )
{
  $oDb = oxDb::getDb();

  $salt = $oDb->getOne( "SELECT UNHEX(OXPASSSALT) FROM oxuser WHERE oxusername=".$oDb->quote( $_REQUEST['username'] ) );

  $str = "cryptmode=MD5withSalt&salt=".rawurlencode($salt);
  return $str;
}

?>
