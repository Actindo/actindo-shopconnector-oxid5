<?php

/**
 * export customers
 *
 * actindo Faktura/WWS connector
 *
 * @package actindo
 * @author  Patrick Prasse <pprasse@actindo.de>
 * @version $Revision: 148 $
 * @copyright Copyright (c) 2007, Patrick Prasse (Schneebeerenweg 26, D-85551 Kirchheim, GERMANY, pprasse@actindo.de)
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

function customers_count( $request )
{
  $response = new ShopCustomersCountResponse();

  $row = act_db_get_single_row( "SELECT COUNT(*) FROM `oxuser`" );
  $response->set_count( $row );

  $row = act_db_get_single_row( "SELECT MAX(oxcustnr) FROM `oxuser`" );
  $response->set_max_deb_kred_id( $row );

  return $response;
}



function customers_list( $request )
{
  $response = new ShopCustomersListResponse();
  $search_request = $request->search_request();

  $sal_map = actindo_get_salutation_map();

  $_pg_map = get_pg_map();

  $p = $search_request->sortColName();
  if( empty($p) )
    $search_request->set_sortColName( 'customers_id' );

  $p = $search_request->sortOrder();
  if( empty($p) )
    $search_request->set_sortOrder( 'ASC' );

  $mapping = array(
    '_customers_id' => array('u', 'oxid'),
    'deb_kred_id' => array('u', 'oxcustnr'),
    'vorname' => array('u', 'oxfname'),
    'name' => array('u', 'oxlname'),
    'firma' => array('u', 'oxcompany'),
    'land' => array('oc', 'oxisoalpha2'),
    'email' => array('u', 'oxusername'),
  );
  $qry = create_query_from_filter( $search_request, $mapping );

  $fields = actindo_get_table_fields( 'oxuser' );
  
  $extra_fields="";
  if(in_array('onetierarztnr',$fields))
    $extra_fields.="onetierarztnr,";

  if( $request->just_list() )
  {
    $sql = "SELECT SQL_CALC_FOUND_ROWS ".$extra_fields."u.oxid AS customers_id, u.oxusername AS email, u.oxcustnr, u.oxsal, u.oxcompany, u.oxfname, u.oxlname, u.oxstreet, u.oxstreetnr, u.oxzip, u.oxcity, oc.oxisoalpha2 FROM `oxuser` AS u LEFT JOIN `oxcountry` AS oc ON(oc.`oxid`=u.`oxcountryid`) WHERE 1 AND {$qry['q_search']} GROUP BY u.oxid ORDER BY {$qry['order']}, u.oxid DESC LIMIT {$qry['limit']}";
  }
  else
  {
    $sql = "SELECT SQL_CALC_FOUND_ROWS ".$extra_fields."u.oxid AS customers_id, u.oxusername AS email, u.*, oc.oxisoalpha2 FROM `oxuser` AS u LEFT JOIN `oxcountry` AS oc ON(oc.`oxid`=u.`oxcountryid`) WHERE 1 AND {$qry['q_search']} GROUP BY u.oxid ORDER BY {$qry['order']}, u.oxid DESC LIMIT {$qry['limit']}";
  }
  $res = act_db_query( $sql );
  while( $customer = act_db_fetch_assoc($res) )
  {
    if( $request->just_list() )
    {
      $actindocustomer = array(
        'deb_kred_id' => (int)($customer['oxcustnr'] > 0 ? $customer['oxcustnr'] : 0),
        'anrede' => isset($sal_map[$customer['oxsal']]) ? $sal_map[$customer['oxsal']] : $order['oxsal'],
        'kurzname' => !empty($customer['oxcompany']) ? $customer['oxcompany'] : $customer['oxlname'],
        'firma' => $customer['oxcompany'],
        'name' => $customer['oxlname'],
        'vorname' => $customer['oxfname'],
        'adresse' => $customer['oxstreet'].' '.$customer['oxstreetnr'],
        'plz' => $customer['oxzip'],
        'ort' => $customer['oxcity'],
        'land' => $customer['oxisoalpha2'],
        'email' => $customer['email'],
        'onetierarztnr'=>$customer['onetierarztnr']
      );
    }
    else
    {
      $actindocustomer = array(
        'deb_kred_id' => (int)($customer['oxcustnr'] > 0 ? $customer['oxcustnr'] : 0),
        'anrede' => isset($sal_map[$customer['oxsal']]) ? $sal_map[$customer['oxsal']] : $order['oxsal'],
        'kurzname' => !empty($customer['oxcompany']) ? $customer['oxcompany'] : $customer['oxlname'],
        'firma' => $customer['oxcompany'],
        'name' => $customer['oxlname'],
        'vorname' => $customer['oxfname'],
        'adresse' => $customer['oxstreet'].' '.$customer['oxstreetnr'],
        'adresse2' => $customer['oxaddinfo'],
        'plz' => $customer['oxzip'],
        'ort' => $customer['oxcity'],
        'land' => $customer['oxisoalpha2'],
        'tel' => $customer['oxfon'],
        'fax' => $customer['oxfax'],
        'tel2' => $customer['oxprivfon'],
        'mobiltel' => $customer['oxmobfon'],
        'ustid' => $customer['oxustid'],
        'email' => $customer['email'],
        'url' => $customer['oxurl'],
        'print_brutto' => 1,
        '_customers_id' => $customer['customers_id'],
        'currency' => 'EUR',
        'gebdat' => $customer['oxbirthdate'],
        'onetierarztnr'=>$customer['onetierarztnr'],
      );

      $delivery_addresses = array();

      $res1 = act_db_query( $sql = "SELECT SQL_CALC_FOUND_ROWS a.oxid AS id, a.*, oc.oxisoalpha2 FROM `oxaddress` AS a LEFT JOIN `oxcountry` AS oc ON(oc.`oxid`=a.`oxcountryid`) WHERE a.oxuserid='".esc($customer['customers_id'])."' ORDER BY a.oxid ASC" );
      while( $delivery = act_db_fetch_assoc($res1) )
      {
        $actindodelivery = array(
          'delivery_address_id' => (int)hexdec( substr($delivery['id'], 0, 3) ),
          'kurzname' => !empty($delivery['oxcompany']) ? $delivery['oxcompany'] : $delivery['oxlname'],
          'firma' => $delivery['oxcompany'],
          'name' => $delivery['oxlname'],
          'vorname' => $delivery['oxfname'],
          'adresse' => $delivery['oxstreet'].' '.$delivery['oxstreetnr'],
          'adresse2' => $delivery['oxaddinfo'],
          'plz' => $delivery['oxzip'],
          'ort' => $delivery['oxcity'],
          'land' => $delivery['oxisoalpha2'],
          'tel' => $delivery['oxfon'],
          'fax' => $delivery['oxfax'],
          'ustid' => $delivery['oxustid'],
          'email' => $customer['email'],
        );
        $delivery_addresses[] = array_merge( $actindocustomer, $actindodelivery );
      }
      act_db_free( $res1 );
      $actindocustomer['delivery_addresses'] = $delivery_addresses;
    }

    $customers[] = $actindocustomer;
  }
  act_db_free( $res );

  foreach( $customers as $cust )
  {
    $oxuser = new oxUser();
    $oxuser->load( $cust['_customers_id'] );

    $customer = $response->add_customers();
    $customer->set_deb_kred_id( $cust['deb_kred_id'] );
    $customer->set__customers_id( $cust['_customers_id'] );
    $customer->set_onetierarztnr($cust['onetierarztnr']);
    if( !empty($cust['gebdat']) && $cust['gebdat'] != '0000-00-00' )
      $customer->set_gebdat( $cust['gebdat'] );

    foreach ($oxuser->getUserGroups() as $oxgroup) {
      if (array_key_exists($oxgroup->getId(), $_pg_map)) {
        $customer->set_preisgruppe($_pg_map[ $oxgroup->getId() ]);
        break;
      }
    }


    $address = new ShopCustomerAddress();
    $address->set_delivery_address_id( 0 );
    $address->fromArray( $cust );
    $customer->set_address( $address );

    $customer->set_delivery_as_customer( 1 );

    foreach( $cust['delivery_addresses'] as $_addr )
    {
      $addr = $customer->add_other_delivery_addresses();
      $addr->fromArray( $_addr );
    }
  }

  $count = act_db_get_single_row( "SELECT FOUND_ROWS()" );
  $response->set_count( $count );
  return $response;
}


?>