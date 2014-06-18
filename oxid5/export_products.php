<?php

/**
 * export products
 *
 * actindo Faktura/WWS connector
 *
 * @package actindo
 * @author Patrick Prasse <pprasse@actindo.de>
 * @version $Revision: 227 $
 * @copyright Copyright (c) 2007-2008, Patrick Prasse (Schneebeerenweg 26, D-85551 Kirchheim, GERMANY, pprasse@actindo.de)
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/


function export_products_count( )
{
  $response = new ShopProductCountResponse();

  $res = act_db_query( "SELECT COUNT(*) AS cnt FROM `oxarticles` WHERE OXPARENTID=''" );
  $cnt = act_db_fetch_assoc( $res );
  act_db_free( $res );
  $response->set_product_count( (int)$cnt['cnt'] );

  $res = act_db_query( "SELECT o2c.OXCATNID AS cat, COUNT(*) AS cnt FROM oxarticles AS a, oxobject2category AS o2c WHERE a.OXPARENTID='' AND o2c.OXOBJECTID=a.OXID GROUP BY o2c.OXCATNID" );
  while( $cnt = act_db_fetch_assoc($res) )
  {
    $c2c = $response->add_count_by_category();
    $c2c->set_category_id( $cnt['cat'] );
    $c2c->set_product_count( (int)$cnt['cnt'] );
  }
  act_db_free( $res );

  return $response;
}




function __do_export_products( $just_list=TRUE, $search_request, &$response )
{

  $mapping = array(
    'products_id' => array('a', 'oxid'),
    'art_nr' => array('a', 'oxartnum'),
    'products_date_added' => array('a', 'oxinsert'),
    'products_date_modified' => array('a', 'oxtimestamp'),
    'products_status' => array('a', 'oxactive', 'boolean'),
    'art_name' => array('a', 'oxtitle'),
//    'categories_id' => array('pc', 'categoryparentID')
  );
  $qry = create_query_from_filter( $search_request, $mapping );
  if( $qry === FALSE )
    return array( 'ok'=>false, 'errno'=>EINVAL, 'error'=>'Error in filter definition' );

  if( $just_list )
    $sql = "SELECT a.*, o2c.OXCATNID catid FROM oxarticles AS a, oxobject2category AS o2c WHERE a.OXPARENTID='' AND o2c.OXOBJECTID=a.OXID AND ({$qry['q_search']}) GROUP BY a.`OXID` ORDER BY {$qry['order']} LIMIT {$qry['limit']}";
  else
    $sql = "SELECT a.*, o2c.OXCATNID AS catid, ae.* FROM oxarticles AS a, oxartextends AS ae, oxobject2category AS o2c WHERE a.OXPARENTID='' AND o2c.OXOBJECTID=a.OXID AND ae.OXID=a.OXID AND ({$qry['q_search']}) GROUP BY a.`OXID` ORDER BY {$qry['order']} LIMIT {$qry['limit']}";
  $cnt = 0;
  $res = act_db_query( $sql );
  while( $prod = act_db_fetch_assoc($res) )
  {
//    var_dump($prod);
    $cnt++;
    $art = $response->add_products();

    $art->set_products_id( $prod['oxid'] );
    $art->set_grundpreis( $prod['oxprice'] );
    $art->set_is_brutto( TRUE );
    $art->set_categories_id( $prod['catid'] );
    $art->set_products_status( $prod['oxactive'] );

    $created = datetime_to_timestamp( $prod['oxinsert'] );
    $modified = datetime_to_timestamp( $prod['oxtimestamp'] );
    $art->set_created( $created > 0 ? $created : $modified );
    $art->set_last_modified( $modified );
    $art->set_art_nr( $prod['oxartnum'] );
    $art->set_art_name( $prod['oxtitle'] );

    if( $just_list )
      continue;

    $shop_art = new ArtikelShopData();

    $art->set_mwst( (float)(is_null($prod['oxvat']) ? $GLOBALS['myConfig']->getConfigParam('dDefaultVAT') : $prod['oxvat']) );
//    $art->set_mwst_stkey(); not needed.
    $art->set_l_bestand( $prod['oxstock'] );
    $art->set_weight( $prod['oxweight'] );
    $art->set_weight_unit( ArtikelWeightUnit::kg );    // guess...
    $art->set_products_ean( $prod['oxean'] );

    $art->set_ek( $prod['oxbprice'] );


    $shop_art->set_products_status( $prod['oxactive'] );
    $shop_art->set_products_date_available(datetime_to_timestamp($prod['oxdelivery'])>0?datetime_to_timestamp($prod['oxdelivery']):datetime_to_timestamp($prod['oxactivefrom']) );
    $shop_art->set_products_sort( $prod['oxsort'] );

    if( $GLOBALS['myConfig']->getRevision() < 18998 )
    {
      $shop_art->set_manufacturers_id( $prod['oxvendorid'] );
    }
    else
    {
      $shop_art->set_manufacturers_id( $prod['oxmanufacturerid'] );
      $shop_art->set_vendors_id( $prod['oxvendorid'] );
    }

    $shop_art->set_products_vpe_status( !empty($prod['oxunitname']) && $prod['oxunitquantity'] > 0 );
    if( $shop_art->products_vpe_status() )
    {
      $shop_art->set_products_vpe_value( $prod['oxunitquantity'] );
      $shop_art->set_products_vpe( $prod['oxunitname'] );
    }

    $shop_art->set_products_weight( $prod['oxweight'] );

    $shop_art->set_info_template( $prod['oxtemplate'] );

    $shop_art->set_activeto( datetime_to_timestamp($prod['oxactiveto']) );
    $shop_art->set_nonmaterial( $prod['oxnonmaterial'] );
    $shop_art->set_non_searchable( $prod['oxissearch'] ? 0 : 1 );
    $shop_art->set_fixedprice( $prod['oxblfixedprice'] );
    $shop_art->set_skipdiscounts( $prod['oxskipdiscounts'] );
    $shop_art->set_shipping_free( $prod['oxfreeshipping'] );
    $shop_art->set_supplierean( $prod['oxdistean'] );
    $shop_art->set_products_mpn($prod['oxmpn']);

    $shop_art->set_length( $prod['oxlength'] );
    $shop_art->set_width( $prod['oxwidth'] );
    $shop_art->set_height( $prod['oxheight'] );

    $shop_art->set_shipping_status_text($prod['oxmindeltime']."-".$prod['oxmaxdeltime']." ".$prod['oxdeltimeunit']."S");
    $shop_art->set_shipping_status_lager_zero_text($prod['oxnostocktext']);

    // UVP steht in $prod['oxtprice'], wird als pseudoprice behandelt
    $pp = $shop_art->add_products_pseudoprices();
    $pp->set_preisgruppe( -1 );
    $pp->set_pseudoprice( $prod['oxtprice'] );

    // categories
    _do_export_all_categories( $prod, $art, $shop_art );

    // descriptions
    _do_export_descriptions( $prod, $art );

    // preisgruppen & preisstaffeln
    _do_export_pricegroups( $prod, $art );

    // attributes (varianten)
    _do_export_attributes( $prod, $art ,$shop_art);

    // xselling
    _do_export_xselling( $prod, $art, $shop_art );

    // images
    _do_export_images( $prod, $art );

    // content
    _do_export_content( $prod, $art, $shop_art );

    // Attributes [Zusatzfelder!]
    _do_export_properties( $prod, $art, $shop_art );

    _do_export_multistore_permission($prod,$art);

//    var_dump($prod);
    $art->set_shop( $shop_art );
  }
  act_db_free( $res );

  $response->set_count( $cnt );


  return array( 'ok' => TRUE );
}


function export_products_list( $request )
{
  $response = new ShopProductListResponse();
  $search_request = $request->search_request();

  $p = $search_request->sortColName();
  if( empty($p) )
    $search_request->set_sortColName( 'oxartnum' );

  $p = $search_request->sortOrder();
  if( empty($p) )
    $search_request->set_sortOrder( 'ASC' );

  $res = __do_export_products( TRUE, $search_request, $response );
  if( !$res['ok'] )
    return $res;

  return $response;
}



function export_products( $request )
{
  $response = new ShopProductGetResponse();
  $search_request = $request->search_request();

  $p = $search_request->sortColName();
  if( empty($p) )
    $search_request->set_sortColName( 'oxartnum' );

  $p = $search_request->sortOrder();
  if( empty($p) )
    $search_request->set_sortOrder( 'ASC' );

  $res = __do_export_products( FALSE, $search_request, $response );
  if( !$res['ok'] )
    return $res;

  return $response;
}

function _do_export_multistore_permission(&$prod,&$art)
  {
  $res = act_db_query( "SELECT `oxshopincl` FROM `oxarticles` WHERE `oxid`='".esc($prod['oxid'])."' Limit 1" );
  $row=act_db_fetch_array($res);
  act_db_free( $res );

  $inc_field=(int)$row['oxshopincl'];

  $idctr=1;
  do
    {

    if($inc_field & 1)
      {
      $mp = $art->add_multistore_permission();
      $mp->set_included((int)$idctr);
      }
    $idctr++;
    }while(($inc_field=$inc_field>>1)>0);

  return true;
  }

function sub_attribute_matrix($attr1, $attr2,$name_id1,$name_id2)
  {
  $combination = array();
  foreach($attr1 as $key1=>$a1)
    {
    foreach($attr2 as $key2=>$a2)
      {
      $comb_entry = $a1;
      if(is_array($a1))
        $comb_entry[$name_id2]=$a2;
      else
        $comb_entry=array($name_id1=>$a1,$name_id2=>$a2);

      $combination[]=$comb_entry;
      }
    }
  return $combination;
  }

function _attr_matrix($attributes)
  {
  $name_id1=array_shift(array_keys($attributes));
  $attr_combinations=array_shift($attributes);

  foreach($attributes as $name_id2=>$attribute)
    {
    $attr_combinations=sub_attribute_matrix($attr_combinations, $attribute,$name_id1,$name_id2);
    $name_id1=$name_id2;
    }

  return $attr_combinations;
  }

function _mkartnr($combination,$attr_models)
  {
  $art_nr='';
  foreach($combination as $name=>$value)
    {
    $art_nr.=$attr_models[$name][$value];
    }

  return $art_nr;
  }

function _do_export_attributes( &$prod, &$art )
{
  if( empty($prod['oxvarname']) && empty($prod['oxvarname_1']) && empty($prod['oxvarname_2']) )
  {
    // no attributes
    return array( 'ok'=> TRUE );
  }

  $lang_id_to_code = get_language_id_to_code();
  $attributes = new ArtikelAttributes();
  $attributes->set_other_combinations_dont_exist( TRUE );

  $attribute_names = array();
  foreach( $lang_id_to_code as $language_id => $code )
  {
    $var_name = $prod[$p=_actindo_get_lang_field('oxvarname', $language_id)];
    if( empty($var_name) )
      continue;

    $names = split( '\|', $var_name );
    foreach( $names as $_i => $_name )
    {
      $attribute_names[$_i][$code] = $_name;
    }
  }
  foreach( $attribute_names as $_i => $tmp )
  {
    $name = $attributes->add_names();
    $name->set_name_id( $prod['oxid'].'__'.$_i );
    foreach( $tmp as $_code => $_name )
    {
      $xlation = $name->add_translation( );
      $xlation->set_language_code( $_code );
      $xlation->set_name( $_name );
    }
  }
  unset( $tmp );

  $children = array();
  $res = act_db_query( "SELECT * FROM `oxarticles` WHERE `oxparentid`='".esc($prod['oxid'])."' ORDER BY `oxsort`" );
  while( $child = act_db_fetch_assoc($res) )
  {
    $children[] = $child;
  }
  act_db_free( $res );

  $attribute_values = array();
  $attribute_values_to_child = array();
  $attribute_prices = array();
  foreach( $children as $_child_i => $child )
  {
    $newval = array();
    foreach( $lang_id_to_code as $language_id => $code )
    {
      $var_name = $child[_actindo_get_lang_field('oxvarselect', $language_id)];
      if( empty($var_name) )
        continue;

      $values = split( '\|', $var_name );
      foreach( $values as $_name_id => $_name )
      {
        $newval[$_name_id][$code] = $_name;
      }
    }

    foreach( $newval as $_name_id => $_descr )
    {
      $found = 0;
      foreach( $attribute_values[$_name_id] as $_val_id => $tmp )
      {
        if( $tmp == $_descr )
        {
          $found++;
          break;
        }
      }
      if( !$found )
      {
        $_val_id = count($attribute_values[$_name_id]);
        $attribute_values[$_name_id][$_val_id] = $_descr;
      }
      $attribute_values_to_child[$child['oxid']][] = array( $_name_id, $_val_id );
      $attribute_prices[$child['oxid']] = $child['oxprice'];
    }

  }

  $attr_combination=array();
  $attr_models=array();
  foreach( $attribute_values as $_name_id => $tmp1 )
  {
    foreach( $tmp1 as $_value_id => $tmp )
    {
      $value = $attributes->add_values();
      $name_id = $prod['oxid'].'__'.$_name_id;
      $value_id = 'V'.$_name_id.'__'.$_value_id;
      $value->set_name_id( $name_id );
      $value->set_value_id( $value_id );

      foreach( $tmp as $_code => $_name )
      {
        if(!isset($_model))$_model=$_name;
        $xlation = $value->add_translation( );
        $xlation->set_language_code( $_code );
        $xlation->set_name( $_name );
      }

       $attr_combination[$name_id][]=$value_id;
      $attr_models[$name_id][$value_id]='-'.trim($_model);

      $combination_simple = $attributes->add_combination_simple();
      $combination_simple->set_value_id( $value_id );
      $combination_simple->set_name_id( $name_id );
      $combination_simple->set_attributes_model('-'.trim($_model) );

      unset($_model);
    }
  }

  $combinations_left=_attr_matrix($attr_combination);

  foreach( $children as $_child_i => $child )
  {
    $ca = $attributes->add_combination_advanced();
    $ca->set_l_bestand( $child['oxstock'] );
    $ca->set_grundpreis( $attribute_prices[ $child['oxid'] ] );
    $ca->set_is_brutto( 1 );

    $combi = $attribute_values_to_child[$child['oxid']];
    $combination=array();
    foreach( $combi as $_c )
    {
      $comb = $ca->add_combination();
      $comb->set_name_id( $prod['oxid'].'__'.$_c[0] );
      $comb->set_value_id( 'V'.$_c[0].'__'.$_c[1] );
      $combination[$prod['oxid'].'__'.$_c[0]]='V'.$_c[0].'__'.$_c[1];
    }

    foreach($combinations_left as $ckey=>$comb_left)
      {
      if(!count(array_diff_assoc($comb_left,$combination)))
        {
        unset($combinations_left[$ckey]);
        }
      }

    $ca->set_art_nr( empty($child['oxartnum'])?$prod['oxartnum']._mkartnr($combination,$attr_models):$child['oxartnum'] );

    $data = new ArtikelAttributesCombinationAdvanced_CombinationAdvancedData();
    $data->set_products_status( true);


    _do_export_pricegroups( $child, $ca );

    $attr_shop_product = new AttributeShopProduct();
    $shop_art=new ArtikelShopData();


//////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
    $shop_art->set_products_status( $child['oxactive'] );
    $shop_art->set_products_date_available((int)datetime_to_timestamp($child['oxdelivery'])>0?datetime_to_timestamp($child['oxdelivery']):datetime_to_timestamp($child['oxactivefrom']));
    $shop_art->set_products_sort( $child['oxsort'] );

    if( $GLOBALS['myConfig']->getRevision() < 18998 )
    {
      $shop_art->set_manufacturers_id( $child['oxvendorid'] );
    }
    else
    {
      $shop_art->set_manufacturers_id( $child['oxmanufacturerid'] );
      $shop_art->set_vendors_id( $child['oxvendorid'] );
    }

    $shop_art->set_products_vpe_status( !empty($child['oxunitname']) && $child['oxunitquantity'] > 0 );
    if( $shop_art->products_vpe_status() )
    {
      $shop_art->set_products_vpe_value( $child['oxunitquantity'] );
      $shop_art->set_products_vpe( $child['oxunitname'] );
    }

    $shop_art->set_products_weight( $child['oxweight'] );

    $shop_art->set_info_template( $child['oxtemplate'] );

    $shop_art->set_activeto( datetime_to_timestamp($child['oxactiveto']) );
    $shop_art->set_nonmaterial( $child['oxnonmaterial'] );
    $shop_art->set_non_searchable( $child['oxissearch'] ? 0 : 1 );
    $shop_art->set_fixedprice( $child['oxblfixedprice'] );
    $shop_art->set_skipdiscounts( $child['oxskipdiscounts'] );
    $shop_art->set_shipping_free( $child['oxfreeshipping'] );
    $shop_art->set_supplierean( $child['oxdistean'] );

    $shop_art->set_length( $child['oxlength'] );
    $shop_art->set_width( $child['oxwidth'] );
    $shop_art->set_height( $child['oxheight'] );


    $shop_art->set_shipping_status_text($child['oxmindeltime']."-".$child['oxmaxdeltime']." ".$child['oxdeltimeunit']."S");
    $shop_art->set_shipping_status_lager_zero_text($child['oxnostocktext']);
    $shop_art->set_products_mpn($child['oxmpn']);
    $attr_shop_product->set_products_ean($child['oxean']);
    //$shop_art->set_search_request('');
    //$shop_art->set_keywords('');




    // UVP steht in $child['oxtprice'], wird als pseudoprice behandelt
    $pp = $shop_art->add_products_pseudoprices();
    $pp->set_preisgruppe( -1 );
    $pp->set_pseudoprice( $child['oxtprice'] );

//////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

    _do_export_xselling($child, $shop_art,$shop_art);
    _do_export_properties($child, $attr_shop_product,$shop_art);
    _do_export_content($child, $attr_shop_product,$shop_art);
    _do_export_images( $child, $attr_shop_product );
    _do_export_descriptions($prod,$attr_shop_product);

    $ca->set_data( $data );

    $attr_shop_product->set_shop($shop_art);
    $ca->set_shop( $attr_shop_product );

  }

  foreach($combinations_left as $comb_left)
    {
      $ca = $attributes->add_combination_advanced();
      $ca->set_art_nr($prod['oxartnum']._mkartnr($comb_left,$attr_models));
      $ca->set_l_bestand(0);
      $ca->set_is_brutto( 1 );

      foreach( $comb_left as $name_id=>$value_id)
      {
        $comb = $ca->add_combination();
        $comb->set_name_id($name_id);
        $comb->set_value_id($value_id);
      }

      $data = new ArtikelAttributesCombinationAdvanced_CombinationAdvancedData();
      $data->set_products_status(false);

    $attr_shop_product = new AttributeShopProduct();
    $shop_art=new ArtikelShopData();
    $attr_shop_product->set_art_nr($prod['oxartnum']._mkartnr($comb_left,$attr_models));

    $shop_art->set_products_status( 0 );

      $ca->set_data( $data );

    $attr_shop_product->set_shop($shop_art);
    $ca->set_shop( $attr_shop_product );

  }

  $art->set_attributes( $attributes );
  return array( 'ok' => TRUE );
}



function _do_export_content( &$prod, &$art, &$shop_art )
{
  $lang_id_to_code = get_language_id_to_code();
  $res1 = act_db_query( $sql="SELECT * FROM `oxmediaurls` WHERE `oxobjectid`='".esc($prod['oxid'])."'" );

  while( $row=act_db_fetch_assoc($res1) )
  {
    foreach( $lang_id_to_code as $language_id => $code )
    {
      $content_name = $row[_actindo_get_lang_field('oxdesc', $language_id)];
      if( empty($content_name) )
        continue;

      $ct = $art->add_content();
      if( $row['oxisuploaded'] > 0 )
      {
        $ct->set_type( ArtikelContent_ArtikelContentType::file );

        $cmp = parse_url( $row['oxurl'] );
        $path = $cmp['path'];
        $ct->set_content_file_name( basename($path) );

        $filepath = strtr( $row['oxurl'], array('https'=>'http', $GLOBALS['myConfig']->getConfigParam('sShopURL') => $GLOBALS['myConfig']->getConfigParam('sShopDir')) );

        if(!file_exists($filepath))
          $filepath=$GLOBALS['myConfig']->getConfigParam('sShopDir')."out/media/".$row['oxurl'];

        if( file_exists($filepath) )
        {
          $content = file_get_contents($filepath);
          $ct->set_content( $content );
          $ct->set_content_file_md5( md5($content) );
          $ct->set_content_file_size( strlen($content) );
          unset( $content );
        }
        else
        {
          // if the calculated path does not exist, get using URL!
          $c1 = curl_init( $row['oxurl'] );
          curl_setopt( $c1, CURLOPT_RETURNTRANSFER, TRUE );
          curl_setopt( $c1, CURLOPT_BINARYTRANSFER, TRUE );
          $content = curl_exec( $c1 );
          curl_close( $c1 );
          $ct->set_content( $content );
          $ct->set_content_file_md5( md5($content) );
          $ct->set_content_file_size( strlen($content) );
          unset( $content );
        }
      }
      else
      {
        $ct->set_type( ArtikelContent_ArtikelContentType::link );
        $ct->set_content( $row['oxurl'] );
      }
      $ct->set_language_code( $code );
      $ct->set_content_name( $content_name );
    }
  }
  act_db_free( $res1 );

  return array( 'ok' => TRUE );
}

function _do_export_properties( &$prod, &$art, &$shop_art )
{
  $lang_id_to_code = get_language_id_to_code();
  $res1 = act_db_query( $sql="SELECT * FROM `oxobject2attribute` WHERE `oxobjectid`='".esc($prod['oxid'])."' ORDER BY `oxpos` ASC" );
  while( $row=act_db_fetch_assoc($res1) )
  {
    foreach( $lang_id_to_code as $language_id => $code )
    {
      $xs = $art->add_properties();
      $xs->set_field_id( $row['oxattrid'] );
      $xs->set_language_code( $code );
      $xs->set_field_value( $row[_actindo_get_lang_field('oxvalue', $language_id)] );
    }
  }
  act_db_free( $res1 );

  return array( 'ok' => TRUE );
}

function _do_export_xselling( &$prod, &$art, &$shop_art )
{
  $res1 = act_db_query( $sql="SELECT a.`oxartnum`, o2a.`oxsort` FROM `oxaccessoire2article` AS o2a, `oxarticles` AS a WHERE a.oxid=o2a.oxobjectid AND o2a.`oxarticlenid`='".esc($prod['oxid'])."' ORDER BY o2a.`oxsort` ASC" );
  while( $row=act_db_fetch_assoc($res1) )
  {
    $xs = $shop_art->add_xselling();
    $xs->set_group_id( 1 );
    $xs->set_art_nr( $row['oxartnum'] );
    $xs->set_sort_order( $row['oxsort'] );
  }
  act_db_free( $res1 );

  $res1 = act_db_query( $sql="SELECT a.`oxartnum`, o2a.`oxsort` FROM `oxobject2article` AS o2a, `oxarticles` AS a WHERE a.oxid=o2a.oxobjectid AND o2a.`oxarticlenid`='".esc($prod['oxid'])."' ORDER BY o2a.`oxsort` ASC" );
  while( $row=act_db_fetch_assoc($res1) )
  {
    $xs = $shop_art->add_xselling();
    $xs->set_group_id( 2 );
    $xs->set_art_nr( $row['oxartnum'] );
    $xs->set_sort_order( $row['oxsort'] );
  }
  act_db_free( $res1 );

  if( !empty($prod['oxbundleid']) )
  {
    $res1 = act_db_query( "SELECT `oxartnum` FROM `oxarticles` WHERE `oxid`='".esc($prod['oxbundleid'])."'" );
    $row = act_db_fetch_assoc($res1);
    act_db_free( $res1 );

    $xs = $shop_art->add_xselling();
    $xs->set_group_id( 3 );
    $xs->set_art_nr( $row['oxartnum'] );
    $xs->set_sort_order( 0 );
  }

  return array( 'ok' => TRUE );
}

function _do_export_pricegroups_ee(&$prod,&$art)
  {
  if($GLOBALS['myConfig']->getEdition()=='EE')
    {
    $pgs = _act_get_pricegroups_to_field( );

    $res1 = act_db_query( "SELECT * FROM `oxshops`" );
    while( $row = act_db_fetch_assoc($res1) )
      {
      if($row['oxid']!=1)
        {
        $rprod=act_db_query("SELECT * FROM oxfield2shop WHERE oxartid='{$prod['oxid']}' AND oxshopid='{$row['oxid']}' LIMIT 1");
        $prod_fields=act_db_fetch_assoc($rprod);
        }
      else
        $prod_fields=$prod;

      $actpgs=_act_get_pricegroups();

      reset($pgs);
      foreach( $pgs as $_pgid => $_field )
        {
          if( is_null($prod_fields[$_field]) )
            continue;
      //    var_dump($_field);

          $preis = (float)$prod_fields[$_field];
      //    var_dump($preis);
          if( round($preis,4) == 0 )
            continue;

          $pg = $art->add_preisgruppen();
          $pg->set_preisgruppe(strlen((string)$row['oxid']).$row['oxid'].$_pgid);
          $pg->set_is_brutto( $art->is_brutto() );
          $pg->set_grundpreis( $preis );

          if( $_field == 'oxprice' )    // preisstaffeln gehen im OXID nur im Grundpreis
          {
            $qr = act_db_query($q="SELECT * FROM oxprice2article WHERE `oxartid` = '{$prod['oxid']}' AND oxshopid= '{$row['oxid']}' ORDER BY `oxamount`");

            while ($qa = act_db_fetch_assoc($qr))
            {
              $price = $prod['oxprice'];
              $ps = $pg->add_preisstaffeln();
              if ($qa['oxaddperc'] != 0) {
                $price = round( $price - $price * ((float)$qa['oxaddperc']) / 100, 2 );
              }
              else {
                $price = ((float)$qa['oxaddabs']);
              }
              $ps->set_preis_gruppe($price);
              $ps->set_preis_range($qa['oxamount']);
            }
          }
        }
      }
      return array( 'ok' => TRUE );
    }
  }

function _do_export_pricegroups( &$prod, &$art )
{
//  echo "\n\n=========================== {$prod['oxartnum']} ===========================\n";

  if($GLOBALS['myConfig']->getEdition()=='EE')
    return _do_export_pricegroups_ee($prod,$art);


  $pgs = _act_get_pricegroups_to_field( );
  foreach( $pgs as $_pgid => $_field )
  {
    if( is_null($prod[$_field]) )
      continue;
//    var_dump($_field);

    $preis = (float)$prod[$_field];
//    var_dump($preis);
    if( round($preis,4) == 0 )
      continue;

    $pg = $art->add_preisgruppen();
    $pg->set_preisgruppe( $_pgid );
    $pg->set_is_brutto( $art->is_brutto() );
    $pg->set_grundpreis( $preis );

    if( $_field == 'oxprice' )    // preisstaffeln gehen im OXID nur im Grundpreis
    {
      $qr = act_db_query("SELECT * FROM oxprice2article WHERE `oxartid` = '{$prod['oxid']}' ORDER BY `oxamount`");
      while ($qa = act_db_fetch_assoc($qr))
      {
        $price = $prod['oxprice'];
        $ps = $pg->add_preisstaffeln();
        if ($qa['oxaddperc'] != 0) {
          $price = round( $price - $price * ((float)$qa['oxaddperc']) / 100, 2 );
        }
        else {
          $price = ((float)$qa['oxaddabs']);
        }
        $ps->set_preis_gruppe($price);
        $ps->set_preis_range($qa['oxamount']);
      }
    }
  }

  return array( 'ok' => TRUE );
}


function _do_export_all_categories( &$prod, &$art, &$shop_art )
{
  $res1 = act_db_query( "SELECT o2c.OXCATNID AS catid FROM oxobject2category AS o2c WHERE o2c.OXOBJECTID='".esc($prod['oxid'])."'" );
  while( $row = act_db_fetch_assoc($res1) )
  {
    $cat = $shop_art->add_all_categories();
    $cat->set_categories_id( $row['catid'] );
  }
  act_db_free( $res1 );
  return array( 'ok' => TRUE );
}


function _do_export_descriptions( &$prod, &$art )
{
  $oxseo_arr = array();
  $res1 = act_db_query( "SELECT * FROM oxseo WHERE oxobjectid='".esc($prod['oxid'])."'" );
  while( $row = act_db_fetch_assoc($res1) )
  {
    $oxseo_arr[$row['oxlang']+1] = $row;
  }
  act_db_free( $res1 );

  if( version_compare($GLOBALS['myConfig']->getVersion(), '4.5.0', '>=') )
  {
    $oxseo_arr = array();
    $res1 = act_db_query( "SELECT oxlang,oxkeywords,oxdescription FROM oxobject2seodata WHERE oxobjectid='".esc($prod['oxid'])."'" );
    while( $row = act_db_fetch_assoc($res1) )
    {
      $oxseo_arr[$row['oxlang']+1] = $row;
    }
    act_db_free( $res1 );
  }

  foreach( get_language_id_to_code() as $language_id => $code )
  {
    $desc = $art->add_description();
    $desc->set_language_code( $code );
    $desc->set_language_id( $language_id );
    $desc->set_products_name( $prod[_actindo_get_lang_field('oxtitle', $language_id)] );
    $desc->set_products_description( $prod[_actindo_get_lang_field('oxlongdesc', $language_id)] );
    $desc->set_products_short_description( $prod[_actindo_get_lang_field('oxshortdesc', $language_id)] );
    $desc->set_products_keywords( $prod[_actindo_get_lang_field('oxsearchkeys', $language_id)] );
    $desc->set_products_tags( rtrim( $prod[_actindo_get_lang_field('oxtags', $language_id)], '_' ) );
    $desc->set_products_meta_keywords( $oxseo_arr[$language_id]['oxkeywords'] );
    $desc->set_products_meta_description( $oxseo_arr[$language_id]['oxdescription'] );
    $desc->set_products_url( 'http://'.$prod['oxexturl'] );
//    $desc->set_products_url_desc( $prod[_actindo_get_lang_field('oxdescription', $language_id)] );
  }
}

function _do_export_images( &$prod, &$art )
{
  $piccount = $GLOBALS['myConfig']->getConfigParam( 'iPicCount' );
  if( version_compare($GLOBALS['myConfig']->getVersion(), '4.5.0', '>=') )
  {
    $p = $GLOBALS['myConfig']->getPictureDir();
    $image_nr = 0;
    for( $i=1; $i<=$piccount; $i++ )
    {
      $pic = $prod['oxpic'.$i];
      if( empty($pic) )
        continue;
      $image_name = $pic;
      $subfolder = sprintf("master/product/%d/", $i);
      $_p = sprintf( "%s%s%s", $p, $subfolder, $pic );

      if( !is_file( $_p ) )
      {
        // TODO: error
      }
      else
      {
        if( strlen( $content=file_get_contents($_p) ) )
        {
          $img = $art->add_images();
          $img->set_image_nr( $image_nr++ );
          $img->set_image_name( $image_name );
          $img->set_image_type( 'image/jpeg' );
          $img->set_image_subfolder( $subfolder );
          $img->set_image_md5( md5($content) );
          $img->set_image( $content );
          unset( $content );
        }
        else
        {
          // TODO: error
        }
      }
    }
  }
  elseif( version_compare($GLOBALS['myConfig']->getVersion(), '4.4.7', '>=') )
  {
    $imageTypes = array( 'master', 'zoom', 'pic' );
    $p = $GLOBALS['myConfig']->getPictureDir();
    $trans = array( "_z1." => ".", "_z2." => ".", "_z3." => ".", "_z4." => ".", "_z5." => ".", "_z6." => ".", "_z7." => ".", "_z8." => ".", "_z9." => ".", "_z10." => ".", "_z11." => ".", "_z12." => ".", "_p1." => ".", "_p2." => ".", "_p3." => ".", "_p4." => ".", "_p5." => ".", "_p6." => ".", "_p7." => ".", "_p8." => ".", "_p9." => ".", "_p10." => ".", "_p11." => ".", "_p12." => "." );

    for( $i=1; $i<=$piccount; $i++ )
    {
      $pic = $subfolder = $path = null;
      foreach( $imageTypes as $imageType ) {

        switch ($imageType) {
            case "master":
                $pic = $prod['oxpic'.$i];
                $image_name = strtr( $pic, $trans );
                $subfolder = sprintf("master/%d/", $i);
                break;
            case "zoom":
                $pic = $prod['oxpic'.$i];
                preg_match("/\.([^\.]+)$/", $pic, $matches);
                $pic = str_replace( $matches[0], sprintf("_z%d%s", $i, $matches[0]), $pic);
                $image_name = strtr( $pic, $trans );
                $subfolder = sprintf("z%d/", $i);
                break;
            case "pic":
                $pic = $prod['oxpic'.$i];
                $image_name = strtr( $pic, $trans );
                $subfolder = sprintf("%d/", $i);
                break;
            default:
                break;
        }
        if( file_exists( $_p=sprintf( "%s%s%s", $p, $subfolder, $pic ) ) && is_file( $_p ) ) {
          $path = $_p;
          break;
        }
      }

      if( strlen( $f=file_get_contents($path) ) && !empty($pic) ) {
        $img = $art->add_images();
        $img->set_image_nr( $i-1 );
        $img->set_image_name( $image_name );
        $img->set_image_type( 'image/jpeg' );
        $img->set_image_subfolder( $subfolder );
        $content = file_get_contents($path);
        $img->set_image_md5( md5($content) );
        $img->set_image( $content );
        unset( $content );
      }
    }
  }  // if( version_compare($GLOBALS['myConfig']->getVersion(), '4.4.7', '<') )
  else
  {
    $zoompiccount = $GLOBALS['myConfig']->getConfigParam( 'iZoomPicCount' );

    for( $i=1; $i<$piccount; $i++ )
    {
      $pic = $subfolder = null;
      if( $i<=$zoompiccount && !_check_nopic($prod['oxzoom'.$i]) )
      {
        $pic = $prod['oxzoom'.$i];
        $subfolder = 'zoom';
      }
      else
      {
        $pic = $prod['oxpic'.$i];
        $subfolder = 'pic';
      }
      if( _check_nopic($pic) )
        continue;

      $path = $GLOBALS['myConfig']->getPictureDir();
      if( $subfolder == 'zoom' )
        $path .= 'z'.$i.'/';
      else
        $path .= $i.'/';
      $path .= $pic;

      $img = $art->add_images();
      $img->set_image_nr( $i-1 );
      $img->set_image_name( $pic );
      $img->set_image_type( 'image/jpeg' );
      $img->set_image_subfolder( $subfolder );
      $content = file_get_contents($path);
      $img->set_image_md5( md5($content) );
      $img->set_image( $content );
      unset( $content );
    }
  } // if( version_compare($GLOBALS['myConfig']->getVersion(), '4.4.7', '<') ) else
}

function _check_nopic( $str )
{
  if( is_null($str) || preg_match('/^nopic.+/', $str) )
    return TRUE;
  return FALSE;
}



?>