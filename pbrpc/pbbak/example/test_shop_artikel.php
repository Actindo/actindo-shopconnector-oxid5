<?php

require_once('../message/pb_message.php');
require_once('./pb_proto_shopconn_artikel.php');

$art = new ShopConn_Artikel( );
$art->set_products_id( 127 );
$art->set_grundpreis( 123.45 );
$art->set_is_brutto( false );
$art->set_products_status( 1 );
$art->set_created( time()-1000 );
$art->set_last_modified( time() );
$art->set_art_nr( "BLAKEKS1" );
$art->set_art_name( "BLA הצü" );
$art->set_mwst( 19.0 );

$str = $art->SerializeToString( );
var_dump($str);

file_put_contents( 'shop_artikel.pb', $str );

$art1 = new ShopConn_Artikel( );
$art1->parseFromString( $str );
print "products_id="; var_dump( $art1->products_id() );
print "grundpreis="; var_dump( $art1->grundpreis() );
print "mwst="; var_dump( $art1->mwst() );

?>