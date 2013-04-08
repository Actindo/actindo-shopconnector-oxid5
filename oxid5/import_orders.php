<?php

/**
 * import orders, specifically: set status, etc
 *
 * actindo Faktura/WWS connector
 *
 * @package actindo
 * @author  Patrick Prasse <pprasse@actindo.de>
 * @version $Revision: 181 $
 * @copyright Copyright (c) 2008, Patrick Prasse (Schneebeerenweg 26, D-85551 Kirchheim, GERMANY, pprasse@actindo.de)
*/

function import_orders_set_status( $request )
{
  require_once getShopBasePath() . 'application/models/oxorderarticle.php';
  require_once getShopBasePath() . 'application/models/oxorder.php';
  require getShopBasePath() . 'modules/functions.php';
  require_once getShopBasePath() . 'core/oxfunctions.php';


  $response = new ShopOrderSetStatusResponse();
  $response->set_order_id( $request->order_id() );

  $order = new OxOrder();
  $res = $order->load( $request->order_id() );
  if( $res === false )
  {
    throw new Exception( "Fehler beim Setzen des Bestellungsstatus", ENOENT );
  }

  if( !is_null($request->status_id()) )
  {
    $orderfolders = _act_get_orderfolders();
    if( !isset($orderfolders[$request->status_id()]) )
    {
      throw new Exception( "Bestellungs-Ordner mit der ID ".$request->status_id()." unbekannt!", EIO );
    }

    $status = $orderfolders[$request->status_id()];
    $res = act_db_query( "UPDATE `oxorder` SET `oxfolder`='".esc($status)."' WHERE oxid='".esc($request->order_id())."'" );
    if( !$res )
    {
      throw new Exception( "Fehler beim Ändern des Ordners der Bestellung", EIO );
    }
    $response->set_status_set( 1 );
  }

  $send_cmt = $request->send_comments();
  $cmt = $request->comment();
  if( !is_null($send_cmt) && $send_cmt && !is_null($cmt) && !empty($cmt) )
  {
    // XXX OXID hat keine vergleichbare Funktion
  }
  
  $is_sent = $request->sent_state();

  if((int)$is_sent>0)
  {
        $oOrder = oxNew( "oxorder" );
        $oOrder->load( $request->order_id() );

        $timeout = oxUtilsDate::getInstance()->getTime(); //time();
        $now = date("Y-m-d H:i:s", $timeout);
        $oOrder->oxorder__oxsenddate->setValue($now);
        $oOrder->save();

        $oOrderArticles = $oOrder->getOrderArticles();
        foreach ( $oOrderArticles as $oxid=>$oArticle) {
      if ( $oArticle->oxorderarticles__oxstorno->value == 1 )
        $oOrderArticles->offsetUnset($oxid);
        }

    if ( $request->send_customer() ) {
        

        //Admin-settings for Email-Templates
        $myConfig = oxConfig::getInstance();
        $myConfig->setConfigParam( 'blAdmin', true );
        $myConfig->setConfigParam( 'blTemplateCaching', false );
        if(!empty($sAdminDir))
            $myConfig->setConfigParam( 'sAdminDir', $sAdminDir );
        else
            $myConfig->setConfigParam( 'sAdminDir', "admin" );


        
            $oxEMail = oxNew( "oxemail" );
            $oOrder->oxorder__oxlang=new oxField( $oOrder->getOrderLanguage() );
            $oxEMail->SendSendedNowMail( $oOrder );
        }

    $response->set_set_sent( 1 );
  }

  $is_paid = $request->paid_state();
  if((int)$is_paid>0)
  {
        $oOrder = oxNew( "oxorder" );
        $oOrder->load( $request->order_id() );
        $timeout = oxUtilsDate::getInstance()->getTime();
        $now = date("Y-m-d H:i:s", $timeout);
        $oOrder->oxorder__oxpaid->setValue($now);
        $oOrder->save();
    
    $response->set_set_paid( 1 );
  }

  return $response;
}


function import_orders_set_trackingcode( $request )
{
  require_once getShopBasePath() . 'core/oxorderarticle.php';
  require_once getShopBasePath() . 'core/oxorder.php';

  $response = new ShopOrderSetTrackingcodeResponse();
  $response->set_order_id( $request->order_id() );

  $order = new OxOrder();
  $res = $order->load( $request->order_id() );
  if( $res === false )
  {
    throw new Exception( "Fehler beim Setzen des Bestellungsstatus", ENOENT );
  }

  $sql = "";

  $send_date = $request->send_date();
  if( !is_null($send_date) && !empty($send_date))
  {
    $sql .= ", `oxsenddate`='".esc($send_date)."'";
    $response->set_send_date_set( 1 );
  }

  $res = act_db_query( "UPDATE `oxorder` SET `oxtrackcode`='".esc($request->trackingcode())."'".$sql." WHERE oxid='".esc($request->order_id())."'" );
  if( !$res )
  {
    throw new Exception( "Fehler beim Setzen des Trackingcodes der Bestellung", EIO );
  }
  $response->set_trackingcode_set( 1 );

  // XXX: shipper, expected_arrival not (yet) supported by oxid

  return $response;
}

?>