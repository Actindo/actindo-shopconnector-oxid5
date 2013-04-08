<?php

/**
 * export settings
 *
 * actindo Faktura/WWS connector
 *
 * @package actindo
 * @author Daniel Haimerl <haimerl@actindo.de>
 * @version $Revision: 454 $
 * @copyright Copyright (c) 2007, Daniel Haimerl (Schneebeerenweg 26, D-85551 Kirchheim, GERMANY, haimerl@actindo.de)
*/

require_once( 'export_orders.php' );
require_once( 'export_products.php' );
require_once( 'export_customers.php' );

function export_shop_languages( )
{
  $lang = array();
  $i = 0;
  foreach( $GLOBALS['myConfig']->getConfigParam('aLanguages') as $key => $val )
  {
    $i++;
    $lang[(int)$i] = array(
      "language_id" => $i,
      "language_name" => $val,
      'language_code' => $key,
      'is_default' => $i == 1,
    );
  }
  return $lang;
}


function export_customers_status( )
{
  $status = array();
  $res = act_db_query( "SELECT cs.*, csd.`language_code`, csd.`customers_status_name` FROM ".TABLE_CUSTOMERS_STATUS." AS cs, ".TABLE_CUSTOMERS_STATUS_DESCRIPTION." AS csd WHERE cs.customers_status_id=csd.customers_status_id" );
  while( $val = act_db_fetch_array( $res ) )
  {
    if( !isset($status[(int)$val['customers_status_id']]) )
    {
      $val1 = $val;
      unset( $val1['customers_status_name'] );
      $status[(int)$val['customers_status_id']] = $val1;
    }
    $status[(int)$val['customers_status_id']]['customers_status_name'][get_language_id_by_code( $val['language_code'] )] = $val['customers_status_name'];
  }
  act_db_free( $res );
  return $status;
}

function export_xsell_groups( )
{
  $grps = array();
  $res = act_db_query( "SELECT * FROM ".TABLE_PRODUCTS_XSELL_GROUPS );
  while( $val = act_db_fetch_array( $res ) )
  {
    if( !isset($grps[(int)$val['products_xsell_grp_name_id']]) )
    {
      $val1 = $val;
      unset( $val1['groupname'] );
      unset( $val1['language_id'] );
      $grps[(int)$val['products_xsell_grp_name_id']] = $val1;
    }
    $grps[(int)$val['products_xsell_grp_name_id']]['groupname'][(int)$val['language_id']] = $val['groupname'];
  }
  act_db_free( $res );
  return $grps;
}


function export_manufacturers( )
{
  $manufacturers_arr = array();

  $manufacturers = new oxManufacturerList();
  $manufacturers->setAdminMode( true );
  $manufacturers->loadManufacturerList();
  foreach( $manufacturers->getArray() as $_key => $_oxman )
  {
    $manufacturers_arr[] = array(
      'manufacturers_id' => $_key,
      'manufacturers_name' => !empty($_oxman->oxmanufacturers__oxtitle->value) ? $_oxman->oxmanufacturers__oxtitle->value : $_oxman->oxmanufacturers__oxtitle->rawValue,
    );
  }
  return $manufacturers_arr;
}

function export_vendors( )
{
  $vendors_arr = array();

  $vendors = new oxVendorList();
  $vendors->setAdminMode( true );
  $vendors->loadVendorList();
  foreach( $vendors->getArray() as $_key => $_oxvendor )
  {
    $vendors_arr[] = array(
      'vendors_id' => $_key,
      'vendors_name' => !empty($_oxvendor->oxvendor__oxtitle->value) ? $_oxvendor->oxvendor__oxtitle->value : $_oxvendor->oxvendor__oxtitle->rawValue,
    );
  }
  return $vendors_arr;
}

function export_status_lager_zero()
{
  $res = array();
  $qr = act_db_query( "SELECT DISTINCT c.v FROM (SELECT `OXSTOCKTEXT` AS v FROM `oxarticles` UNION SELECT `OXNOSTOCKTEXT` AS v FROM `oxarticles`) c" );
  while( $qa = act_db_fetch_array( $qr ) )
  {
    if( strlen( trim( $qa['v'] ) ) ) {
      $res[]= array('name' => $qa['v']);
    }
  }
  act_db_free( $qr );
  return $res;
}

function export_shippingtime()
{
  $res = array();
  $qr = act_db_query( "SELECT DISTINCT concat(OXMINDELTIME,'-',OXMAXDELTIME,' ',OXDELTIMEUNIT,'S') AS u_str,OXDELTIMEUNIT,OXMAXDELTIME,OXMINDELTIME  FROM oxarticles WHERE OXMAXDELTIME!=0 OR OXMINDELTIME!=0 ORDER BY OXMINDELTIME" );
  $res[]=array('name' => '0-0 Behalten');
  $res[]=array('name' => '0-0 Leeren');
  while( $qa = act_db_fetch_array( $qr ) )
  {
    if( strlen( trim( $qa['u_str'] ) ) ) {
      $res[]= array('name' => $qa['u_str']);
    }
  }
  act_db_free( $qr );
  return $res;
}

function export_vpe()
{
  $res = array();
  $qr = act_db_query( "SELECT DISTINCT `OXUNITNAME` AS v FROM `oxarticles`" );
  while( $qa = act_db_fetch_array( $qr ) )
  {
    $res[]= array( 'lang' => 1, 'name' => $qa['v'] );
  }
  act_db_free( $qr );
  return $res;
}




?>