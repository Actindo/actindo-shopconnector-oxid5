<?php

/**
 * export orders
 *
 * actindo Faktura/WWS connector
 *
 * @package actindo
 * @author  Patrick Prasse <pprasse@actindo.de>
 * @version $Revision: 206 $
 * @copyright Copyright (c) 2007, Patrick Prasse (Schneebeerenweg 26, D-85551 Kirchheim, GERMANY, pprasse@actindo.de)
*/


function export_orders_count( )
{
  $response = new ShopOrdersCountResponse();

  $res = act_db_query( "SELECT COUNT(*) AS cnt FROM `oxorder`" );
  $tmp = act_db_fetch_assoc($res);
  $response->set_count( (int)$tmp['cnt'] );
  act_db_free($res);

  return $response;
}


function export_orders_list( $request )
{
  $response = new ShopOrdersListResponse();
  $search_request = $request->search_request();

  $sal_map = actindo_get_salutation_map();

  $invalid_oxremarks = get_invalid_oxremarks();
  $invalid_oxremarks = array_map( '_string_remove_specialchars', $invalid_oxremarks );

  // we've got to change sortColName if it's order_id as actindo relies on order_id being a normal auto_increment integer field
  // here we have a string.
  $p = $search_request->sortColName();
  if( empty($p) || $p === 'order_id' )
    $search_request->set_sortColName( 'oxorderdate' );

  $p = $search_request->sortOrder();
  if( empty($p) )
    $search_request->set_sortOrder( 'DESC' );

  $orderfolders = _act_get_orderfolders();
  $folder_to_folders_id = array_flip( $orderfolders );
  $langid_to_langcode = _act_get_langid_to_langcode();

  $mapping = array(
    'order_id' => array('o', 'oxid'),
    'external_order_id' => array('o', 'oxordernr'),
    'deb_kred_id' => array('o', 'customers_cid'),
    '_customers_id' => array('o', 'oxuserid'),
    'orders_status' => array( 'o', 'oxfolder', null, $orderfolders ),      // TODO -> this is the name, not the id gotten from actindo!
    'oxorderdate' => array('o', 'oxorderdate'),
  );
  $qry = create_query_from_filter( $search_request, $mapping );
  if( $qry === FALSE )
    return array( 'ok'=>false, 'errno'=>EINVAL, 'error'=>'Error in filter definition' );


  $orders = array();

  $order_count = 0;

  $_pg_map = get_pg_map();

  $extra_fields="";

  $fields_user = actindo_get_table_fields( 'oxuser' );
  if(in_array('onetierarztnr',$fields_user))
    $extra_fields.="cc.onetierarztnr as onetierarztnr_cust,";

  $fields_order = actindo_get_table_fields( 'oxorder' );
  if(in_array('onetierarztnr',$fields_order))
    $extra_fields.="o.onetierarztnr as onetierarztnr_order,";



//  $res = act_db_query( "SELECT o.*, cc.customers_cid AS cc_cid, o.language_code AS `langcode` FROM ".TABLE_ORDERS." AS o LEFT JOIN ".TABLE_CUSTOMERS." AS cc ON (cc.customers_id=o.customers_id) WHERE {$qry['q_search']} ORDER BY {$qry['order']} LIMIT {$qry['limit']}" );
    $res = act_db_query($q= "SELECT SQL_CALC_FOUND_ROWS ".$extra_fields."o.*, cc.oxcustnr, cc.oxusername, cc.oxbirthdate, o.oxlang AS langid FROM `oxorder` AS o LEFT JOIN `oxuser` AS cc ON (cc.oxid=o.oxuserid) WHERE {$qry['q_search']} ORDER BY {$qry['order']} LIMIT {$qry['limit']}" );

  while( $order = act_db_fetch_assoc($res) )
  {
    $order['langid'] = $order['langid'] + 1; // actindo langcodes start at 1, OXID counts from 0

    $actindoorder = $response->add_orders();
    $actindoorder->set_order_id( $order['oxid'] );
    $actindoorder->set_subshop_id((int)($GLOBALS['myConfig']->getEdition()=='EE'? $order['oxshopid']:0));
    $actindoorder->set_external_order_id( $order['oxordernr'] );
    $actindoorder->set__customers_id( $order['oxuserid'] );
//    $actindoorder->set_deb_kred_id( $order['oxcustnr'] );
    $actindoorder->set_deb_kred_id( 0 );
    $actindoorder->set_onetierarztnr( $order['onetierarztnr_order'] );

    $oxuser = new oxUser();
    $oxuser->load($order['oxuserid']);

    $customer = new ShopCustomer();
//    $customer->set_deb_kred_id( $order['oxcustnr'] );
    $customer->set_deb_kred_id( 0 );
    $customer->set__customers_id( $order['oxuserid'] );
    $customer->set_onetierarztnr( $order['onetierarztnr_cust'] );
    foreach ($oxuser->getUserGroups() as $oxgroup) {
      if (array_key_exists($oxgroup->getId(), $_pg_map)) {
        $customer->set_preisgruppe($_pg_map[ $oxgroup->getId() ]);
        break;
      }
    }

    $customer_address = new ShopCustomerAddress( );
    $customer_address->set_anrede( isset($sal_map[$order['oxbillsal']]) ? $sal_map[$order['oxbillsal']] : $order['oxbillsal'] );
    $customer_address->set_kurzname( !empty($order['oxbillcompany']) ? $order['oxbillcompany'] : $order['oxbillfname'].' '.$order['oxbilllname'] );
    $customer_address->set_name( $order['oxbilllname'] );
    $customer_address->set_vorname( $order['oxbillfname'] );
    $customer_address->set_firma( $order['oxbillcompany'] );
    $customer_address->set_adresse( trim($order['oxbillstreet']).' '.trim($order['oxbillstreetnr']) );
    $customer_address->set_adresse2( $order['oxbilladdinfo'] );
    $customer_address->set_ort( $order['oxbillcity'] );
    $customer_address->set_plz( $order['oxbillzip'] );
    $customer_address->set_land( act_db_get_single_row("SELECT `oxisoalpha2` FROM `oxcountry` WHERE `oxid`='".esc($order['oxbillcountryid'])."'") );
    $customer_address->set_plz( $order['oxbillzip'] );
    $customer_address->set_tel( $order['oxbillfon'] );
    $customer_address->set_fax( $order['oxbillfax'] );
    $customer_address->set_email( $order['oxusername'] );
    $customer_address->set_langcode( $langid_to_langcode[$order['langid']] );
    $customer_address->set_ustid( $order['oxbillustid'] );
    $customer->set_address( $customer_address );

    if( !empty($order['oxdelstreet']) && !empty($order['oxdelcity']) )
    {
      $customer->set_delivery_as_customer( 0 );
      $delivery_address = new ShopCustomerAddress();
      $delivery_address->set_anrede( isset($sal_map[$order['oxdelsal']]) ? $sal_map[$order['oxdelsal']] : $order['oxdelsal'] );
      $delivery_address->set_kurzname( !empty($order['oxdelcompany']) ? $order['oxdelcompany'] : $order['oxdelfname'].' '.$order['oxdelname'] );
      $delivery_address->set_name( $order['oxdellname'] );
      $delivery_address->set_vorname( $order['oxdelfname'] );
      $delivery_address->set_firma( $order['oxdelcompany'] );
      $delivery_address->set_adresse( trim($order['oxdelstreet']).' '.trim($order['oxdelstreetnr']) );
      $delivery_address->set_adresse2( $order['oxdeladdinfo'] );
      $delivery_address->set_ort( $order['oxdelcity'] );
      $delivery_address->set_plz( $order['oxdelzip'] );
      $delivery_address->set_land( act_db_get_single_row("SELECT `oxisoalpha2` FROM `oxcountry` WHERE `oxid`='".esc($order['oxdelcountryid'])."'") );
      $delivery_address->set_plz( $order['oxdelzip'] );
      $delivery_address->set_tel( $order['oxdelfon'] );
      $delivery_address->set_fax( $order['oxdelfax'] );
      $delivery_address->set_email( $order['oxusername'] );
      $delivery_address->set_langcode( $langid_to_langcode[$order['langid']] );
      $delivery_address->set_ustid( $order['oxdelustid'] );
      $customer->set_delivery_address( $delivery_address );
    }
    else {
      $customer->set_delivery_as_customer( 1 );
    }

    if( !empty($order['oxbirthdate']) && $order['oxbirthdate'] != '0000-00-00' )
    {
      $customer->set_gebdat( $order['oxbirthdate'] );
    }


    $actindoorder->set_customer( $customer );
    // TODO

    preg_match( '/^(\d{4}-\d{2}-\d{2})(\s+(\d+:\d+:\d+))?$/', $order['oxorderdate'], $matches );
    $actindoorder->set_webshop_order_date( $matches[1] );
    $actindoorder->set_webshop_order_time( $matches[3] );

    $actindoorder->set_bill_date( $matches[1] );
    $actindoorder->set_val_date( $matches[1] );

    $order['oxremark'] = trim( $order['oxremark'] );
    if( in_array(_string_remove_specialchars($order['oxremark']), $invalid_oxremarks) )     // codepage-neutral comparison
      $actindoorder->set_beleg_status_text( "" );
    else
      $actindoorder->set_beleg_status_text( $order['oxremark'] );

    $payment = new OrderPayment();

    if( 1 || $order['oxpaymenttype'] == 'oxiddebitnote' ) {
      $payment->set_type( 'ls' );
      $payment_l = new Payment_L();

      $bd = _get_debitnote_paymentdata($order['oxpaymentid']);
      if(preg_match('/[a-zA-Z]{2}[0-9]{2}[a-zA-Z0-9]{4}[0-9]{7}([a-zA-Z0-9]?){0,16}/', $bd['lsktonr']))
      {
          $payment_l->set_iban($bd['lsktonr']);
          $payment_l->set_swift($bd['lsblz']);
      }
      else
      {
          $payment_l->set_kto($bd['lsktonr']);
          $payment_l->set_blz($bd['lsblz']);
      }
      $payment_l->set_kto_inhaber( $bd['lsktoinhaber'] );

      $payment->set_ls( $payment_l );
    }
    //TODO : other payments

    //kundenerweiterung 71214
    if(false!=($hpprepaymentdata_tpl=act_have_table("oxhpprepaymentdata")?"oxhpprepaymentdata":(act_have_table("d3hpprepaymentdata")?"d3hpprepaymentdata":false)))
        {
        $fact_res = act_db_query( "SELECT d3xmldata FROM `".$hpprepaymentdata_tpl."` WHERE `oxorderid`='".esc($order['oxid'])."' LIMIT 1" );
        $hpTransaction = act_db_fetch_assoc($fact_res);

        if(is_array($hpTransaction))
            {
            $payment_factoring=new Payment_Factoring();
            $xml_str=unserialize(base64_decode($hpTransaction['d3xmldata']));

            $hpt_sxe=simplexml_load_string($xml_str);
            if($hpt_sxe instanceof SimpleXMLElement)
                {
                if(is_object($hpt_sxe->Transaction->Connector->Account))
                    {
                    $payment_factoring->set_bankCode((string)$hpt_sxe->Transaction->Connector->Account->Bank);
                    $payment_factoring->set_accountNumber((string)$hpt_sxe->Transaction->Connector->Account->Number);
                    $payment_factoring->set_recipient((string)$hpt_sxe->Transaction->Connector->Account->Holder);
                    $payment_factoring->set_iban((string)$hpt_sxe->Transaction->Connector->Account->Iban);
                    $payment_factoring->set_bic((string)$hpt_sxe->Transaction->Connector->Account->Bic);

                    $payment_factoring->set_currencyCode((string)$hpt_sxe->Transaction->Payment->Clearing->Currency);
                    $payment_factoring->set_amount((float)$hpt_sxe->Transaction->Payment->Clearing->Amount);
                    $payment_factoring->set_reference((string)$hpt_sxe->Transaction->Identification->ShortID);

                    $payment->set_factoring($payment_factoring);
                    }
                }
            }
        }

    $actindoorder->set_payment( $payment );

    $actindoorder->set_currency( $order['oxcurrency'] );
    $actindoorder->set_currency_value( $order['oxcurrate'] );


    $mean_vat = get_mean_vat( $order['oxid'] );

    $actindoorder->set_netto( $order['oxtotalnetsum'] );
//    $actindoorder->set_netto2( );
    if( round($order['oxdiscount'],2) != 0 )
    {
      $betrag=(float)$order['oxdiscount'];

      $rabatt = new ShopOrder_ShopOrderRabatt();
      $rabatt->set_rabatt_type( 'betrag' );
      $rabatt->set_rabatt_betrag( round($betrag / $mean_vat,2) );
      $actindoorder->set_rabatt( $rabatt );
    }




    $actindoorder->set_saldo( $order['oxtotalordersum'] );


    if( isset($folder_to_folders_id[$order['oxfolder']]) )
      $actindoorder->set_orders_status( $folder_to_folders_id[$order['oxfolder']] );

    $actindoorder->set__payment_method( $order['oxpaymenttype'] );


    $order_count++;
  }
  act_db_free($res);

  $response->set_count( $order_count );

  return $response;
}

function _export_payment( $orders_id, $payment_method, &$actindoorder, $order, $order_data )
{
  $data = @unserialize( $order_data['order_data']['orders_data'] );
  is_array($data) or $data = array();
  switch( strtolower($payment_method) )
  {
    case 'xt_banktransfer':
      $actindoorder['customer']['kto'] = $data['banktransfer_number'];
      $actindoorder['customer']['blz'] = $data['banktransfer_blz'];
      $actindoorder['customer']['bankname'] = $data['banktransfer_bank_name'];
      $actindoorder['customer']['kto_inhaber'] = $data['banktransfer_owner'];
      $actindoorder['customer']['iban'] = $data['banktransfer_iban'];
      $actindoorder['customer']['swiftcode'] = $data['banktransfer_bic'];
      return TRUE;
  }

  $actindoorder['_payment'] = $data;
  return FALSE;
}



function export_orders_positions( $request )
{
  require_once getShopBasePath() . 'application/models/oxorderarticle.php';
  require_once getShopBasePath() . 'application/models/oxorder.php';

  $response = new ShopOrdersPositionsResponse();

  $order = new OxOrder();
  $res = $order->load( $request->order_id() );
  if( $res === false )
  {
    // TODO: throw ENOENT
  }

  $mean_vat = get_mean_vat( $request->order_id() );

  $articles = $order->getOrderArticles();
  $articles->rewind();
  $pos_count = 0;
  $vat_collection=array();
  while( $articles->valid() )
  {
    $pos_count++;

    $article = $articles->current();

    $actindoarticle = $response->add_positions();

    $actindoarticle->set_art_nr( $article->oxorderarticles__oxartnum->rawValue );
    $actindoarticle->set_art_name( $article->oxorderarticles__oxtitle->value );
    $actindoarticle->set_preis( $article->getPrice()->getBruttoPrice() );
    $actindoarticle->set_is_brutto( 1 );
    $actindoarticle->set_type( 'Lief' );
    $actindoarticle->set_mwst( (float)$article->oxorderarticles__oxvat->rawValue );
    $actindoarticle->set_menge( (float)$article->oxorderarticles__oxamount->rawValue );

    $artvat=round((float)$article->oxorderarticles__oxvat->rawValue,2);
    if(!isset($vat_collection[$artvat]))
      $vat_collection[$artvat]=(float)$article->getPrice()->getBruttoPrice();
    else
      $vat_collection[$artvat]+=(float)$article->getPrice()->getBruttoPrice();

    // Wrapping
    $artnr = $article->oxorderarticles__oxwrapid->rawValue;
    if( !empty($artnr) )
    {
      $actindoarticle = $response->add_positions();

      $actindoarticle->set_art_nr( $artnr );
      $actindoarticle->set_art_name( 'Geschenkverpackung '.act_db_get_single_row("SELECT `oxname` FROM `oxwrapping` WHERE `oxid`='".esc($artnr)."' AND oxtype='WRAP'") );

      // preis & mwst berechnung wenn keine Karte gegeben ist.
      $artnr_card = $order->oxorder__oxcardid->value;
      if(empty($artnr_card))
        {
        $actindoarticle->set_preis( (float)$order->oxorder__oxwrapcost->value );
        if( (float)$order->oxorder__oxwrapvat->value > 0 )   // steuersatz angegeben ?
          {
            $actindoarticle->set_mwst( (float)$order->oxorder__oxwrapvat->value );

          $artvat=round((float)$order->oxorder__oxwrapvat->value,2);
          if(!isset($vat_collection[$artvat]))
            $vat_collection[$artvat]=(float)$order->oxorder__oxwrapcost->value;
          else
            $vat_collection[$artvat]+=(float)$order->oxorder__oxwrapcost->value;
          }
          else
          {
            // nein? schlecht.
            // schauen ob Bestellung generell 0%. Wenn nein, dDefaultVAT
            $nvat=(float)( $mean_vat != 1 ? $GLOBALS['myConfig']->getConfigParam('dDefaultVAT') : 0 );
            $actindoarticle->set_mwst($nvat);

            $artvat=round((float)$nvat,2);
            if(!isset($vat_collection[$artvat]))
              $vat_collection[$artvat]=(float)$order->oxorder__oxwrapcost->value;
            else
              $vat_collection[$artvat]+=(float)$order->oxorder__oxwrapcost->value;
          }
        }
      else
      $actindoarticle->set_preis( 0 );

      $actindoarticle->set_is_brutto( 1 );
      $actindoarticle->set_type( 'NLeist' );
      $actindoarticle->set_subtype( 'wrap' );
      $actindoarticle->set_mwst( 0 );
      $actindoarticle->set_menge( 1 );
      $pos_count++;
    }

    $articles->next();
  }


  // Payment
  $pmt = $order->oxorder__oxpaymenttype->value;
  if( !empty($pmt) && round($order->oxorder__oxpaycost->value,2) != 0 )
  {
    $actindoarticle = $response->add_positions();

    // TODO: column oxpayments.oxartnumerp
    // $actindoarticle->set_art_nr( oxpayments.oxartnumerp );
    $actindoarticle->set_art_nr( 'payment' );
    $actindoarticle->set_art_name( ACTINDO_SHOP_CHARSET=='UTF-8' ? utf8_encode('Zahlungsart-Gebühren') : 'Zahlungsart-Gebühren' );

    $actindoarticle->set_preis( (float)$order->oxorder__oxpaycost->value );
    $actindoarticle->set_is_brutto( 1 );
    $actindoarticle->set_type( 'NLeist' );
    $actindoarticle->set_subtype( 'payment' );
    if( (float)$order->oxorder__oxpayvat->value > 0 )   // steuersatz angegeben ?
    {
      $actindoarticle->set_mwst( (float)$order->oxorder__oxpayvat->value );

    $artvat=round((float)$order->oxorder__oxpayvat->value,2);
    if(!isset($vat_collection[$artvat]))
      $vat_collection[$artvat]=(float)$order->oxorder__oxpaycost->value;
    else
      $vat_collection[$artvat]+=(float)$order->oxorder__oxpaycost->value;
    }
    else
    {
      // nein? schlecht.
      // schauen ob Bestellung generell 0%. Wenn nein, dDefaultVAT
    $nvat=(float)($mean_vat != 1 ? $GLOBALS['myConfig']->getConfigParam('dDefaultVAT') : 0);
    $actindoarticle->set_mwst( $nvat);

    $artvat=round((float)$nvat,2);
    if(!isset($vat_collection[$artvat]))
      $vat_collection[$artvat]=(float)$order->oxorder__oxpaycost->value;
    else
      $vat_collection[$artvat]+=(float)$order->oxorder__oxpaycost->value;
    }
    $actindoarticle->set_menge( 1 );
    $pos_count++;
  }


  // Card
  $artnr = $order->oxorder__oxcardid->value;
  if( !empty($artnr) )
  {
    $actindoarticle = $response->add_positions();

    $actindoarticle->set_art_nr( $artnr );
    $actindoarticle->set_art_name( 'Karte '.act_db_get_single_row("SELECT `oxname` FROM `oxwrapping` WHERE `oxid`='".esc($artnr)."' AND oxtype='CARD'") );
    $actindoarticle->set_langtext( $order->oxorder__oxcardtext->value );

    $actindoarticle->set_preis( (float)$order->oxorder__oxwrapcost->value );
    $actindoarticle->set_is_brutto( 1 );
    $actindoarticle->set_type( 'NLeist' );
    $actindoarticle->set_subtype( 'card' );
//    $actindoarticle->set_mwst( (float)$order->oxorder__oxwrapvat->value );
    if( (float)$order->oxorder__oxwrapvat->value > 0 )   // steuersatz angegeben ?
    {
      $actindoarticle->set_mwst( (float)$order->oxorder__oxwrapvat->value );

    $artvat=round((float)$order->oxorder__oxwrapvat->value,2);
    if(!isset($vat_collection[$artvat]))
      $vat_collection[$artvat]=(float)$order->oxorder__oxwrapcost->value;
    else
      $vat_collection[$artvat]+=(float)$order->oxorder__oxwrapcost->value;
    }
    else
    {
      // nein? schlecht.
      // schauen ob Bestellung generell 0%. Wenn nein, dDefaultVAT
      $nvat=(float)( $mean_vat != 1 ? $GLOBALS['myConfig']->getConfigParam('dDefaultVAT') : 0 );
      $actindoarticle->set_mwst($nvat);

      $artvat=round((float)$nvat,2);
      if(!isset($vat_collection[$artvat]))
        $vat_collection[$artvat]=(float)$order->oxorder__oxwrapcost->value;
      else
        $vat_collection[$artvat]+=(float)$order->oxorder__oxwrapcost->value;
    }
    $actindoarticle->set_menge( 1 );
    $pos_count++;
  }

  // Delivery
  $del = $order->oxorder__oxdeltype->value;
  if( !empty($del) )
  {
    $actindoarticle = $response->add_positions();

    // TODO: column oxpayments.oxartnumerp
    // $actindoarticle->set_art_nr( $pmt->oxpayments__oxartnumerp->value );
    $actindoarticle->set_art_nr( 'shipping-'.$del );
    $actindoarticle->set_art_name( 'Versand '.act_db_get_single_row("SELECT `oxtitle` FROM `oxdeliveryset` WHERE `oxid`='".esc($del)."'") );

    $actindoarticle->set_preis( (float)$order->oxorder__oxdelcost->value );
    $actindoarticle->set_is_brutto( 1 );
    $actindoarticle->set_type( 'NLeist' );
    $actindoarticle->set_subtype( 'delivery' );
    $actindoarticle->set_mwst( (float)$order->oxorder__oxdelvat->value );

    if((float)$order->oxorder__oxdelcost->value > 0.0)
      {
    if( (float)$order->oxorder__oxdelvat->value > 0 )   // steuersatz angegeben ?
    {
      $actindoarticle->set_mwst( (float)$order->oxorder__oxdelvat->value );

        $artvat=round((float)$order->oxorder__oxdelvat->value,2);
        if(!isset($vat_collection[$artvat]))
          $vat_collection[$artvat]=(float)$order->oxorder__oxdelcost->value;
        else
          $vat_collection[$artvat]+=(float)$order->oxorder__oxdelcost->value;
    }
    else
    {
      // nein? schlecht.
      // schauen ob Bestellung generell 0%. Wenn nein, dDefaultVAT
        $nvat=(float)( $mean_vat != 1 ? $GLOBALS['myConfig']->getConfigParam('dDefaultVAT') : 0 );
        $actindoarticle->set_mwst($nvat);

        $artvat=round((float)$nvat,2);
        if(!isset($vat_collection[$artvat]))
          $vat_collection[$artvat]=(float)$order->oxorder__oxdelcost->value;
        else
          $vat_collection[$artvat]+=(float)$order->oxorder__oxdelcost->value;
        }
      }
    else
      {
      $actindoarticle->set_mwst((float)0);
    }
    $actindoarticle->set_menge( 1 );
    $pos_count++;
  }


   if((float)$order->oxorder__oxvoucherdiscount->rawValue>0)
     {
     $vats=array();
     $sum=0;

     $sum=array_sum($vat_collection);

     foreach($vat_collection as $mwst=>$value)
       {
       $val_amount=round(((float)$order->oxorder__oxvoucherdiscount->rawValue/100)*($value/($sum/100)),2);

       $actindoarticle = $response->add_positions();

       $actindoarticle->set_art_nr( 'ox_gutschein_'.$mwst );
       $actindoarticle->set_art_name('OXID Gutschein');

       $actindoarticle->set_preis( (float)$val_amount*-1);
       $actindoarticle->set_is_brutto( 1 );
       $actindoarticle->set_type( 'Gutschein' );
       $actindoarticle->set_mwst( (float)$mwst );

       $actindoarticle->set_menge( 1 );
       }

    }

  $response->set_n_pos( $pos_count );

  return $response;
}


function get_mean_vat( $order_id )
{
  $order = new OxOrder();
  $res = $order->load( $order_id );
  if( $res === false )
  {
    return FALSE;
  }

  $brutto = $netto = 0.0;

  $articles = $order->getOrderArticles();
  $articles->rewind();
  $pos_count = 0;
  while( $articles->valid() )
  {
    $pos_count++;

    $article = $articles->current();

    $brutto += $article->getPrice()->getBruttoPrice();
    $netto += $article->getPrice()->getBruttoPrice() / (1+((float)$article->oxorderarticles__oxvat->rawValue/100));

    $articles->next();
  }

  return $brutto / $netto;
}



function get_invalid_oxremarks( )
{
  $excludes = array();
  $arr = glob( getShopBasePath().'out/basic/*/lang.php' );
  foreach( $arr as $_filename )
  {
    $arr = file( $_filename );
    foreach( $arr as $_line )
    {
      if( preg_match('/[\'\"]USER_MESSAGEHERE[\'\"]\s*=>\s*[\'\"](.+)[\'\"]/', $_line, $matches) )
        $excludes[] = $matches[1];
    }
  }

  $arr = glob( getShopBasePath().'out/basic/*/cust_lang.php' );
  foreach( $arr as $_filename )
  {
    $arr = file( $_filename );
    foreach( $arr as $_line )
    {
      if( preg_match('/[\'\"]USER_MESSAGEHERE[\'\"]\s*=>\s*[\'\"](.+)[\'\"]/', $_line, $matches) )
        $excludes[] = trim( $matches[1] );
    }
  }

  return $excludes;
}

function _string_remove_specialchars( $str )
{
  return preg_replace('/[^\x20-\x7a]/', '', $str );
}

?>