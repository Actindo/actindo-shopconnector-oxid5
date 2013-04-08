<?php

require_once( '/home/framework/util/3rdparty/pb4php/message/pb_message.php' );
// require_once( 'pbrpc_client.php' );
require_once( 'pb_proto_protobufrpc.php' );

require_once( 'pb_proto_shop_order.php' );


    $request = new ShopOrdersListRequest();
    $request->set_tmp( "BLA" );
    {
      $sq = new SearchQuery( );
      $sq->set_limit_type( SearchQuery_LimitType::START_LIMIT );
      $sq->set_start( 0 );
      $sq->set_limit( 9999 );


      $sq->set_searchText( "TEST" );
      $sq->set_searchColumns( "name" );

      $pb_filter = $sq->add_filter();
      $pb_filter->set_field( 'order_id' );


      $request->set_search_request( $sq );
    }

//  echo $request->serializeToString();
  $string = $request->SerializeToPHPSerialize();
  $request_array = $request->toArray();
  var_dump($request_array);
  echo $string;


  $req_test = new ShopOrdersListRequest();
  $req_test->ParseFromPHPSerialize( $string );
//  var_dump($req_test);
  $req_test_array = $req_test->toArray();
  var_dump($req_test_array);


?>