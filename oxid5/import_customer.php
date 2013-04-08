<?php

/**
 * import customer cid
 *
 * actindo Faktura/WWS connector
 *
 * @package actindo
 * @author  Patrick Prasse <pprasse@actindo.de>
 * @version $Revision: 181 $
 * @copyright Copyright (c) 2007, Patrick Prasse (Schneebeerenweg 26, D-85551 Kirchheim, GERMANY, pprasse@actindo.de)
*/

function import_customer_set_deb_kred_id( $request )
{
  $response = new ShopCustomerSetDebKredIdResponse();

  $customer_id = $request->customer_id();
  $deb_kred_id = $request->deb_kred_id();

  if( empty($customer_id) || !$deb_kred_id )    // TODO
  {
    throw new Exception( "Shop-Kdnr oder actindo-Kdnr leer", EINVAL );
  }

  $response->set_customer_id( $customer_id );
  $response->set_deb_kred_id( $deb_kred_id );

  $res = act_db_query( "UPDATE `oxuser` SET oxcustnr=".(int)$deb_kred_id." WHERE `oxid`='".esc($customer_id)."'" );

  return $response;
}



?>