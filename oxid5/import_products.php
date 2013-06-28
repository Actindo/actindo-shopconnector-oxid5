<?php

/**
 * import products
 *
 * actindo Faktura/WWS connector
 *
 * @package actindo
 * @author Patrick Prasse <prasse@actindo.de>
 * @version $Revision: 228 $
 * @copyright Copyright (c) 2008, Patrick Prasse (Schneebeerenweg 26, D-85551 Kirchheim, GERMANY, haimerl@actindo.de)
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/


function import_product( $request )
{
  $response = new ShopProductCreateUpdateResponse();

  for( $product_index=0; $product_index < $request->products_size(); $product_index++ )
  {
    $product = &$request->products($product_index);

    $result = $response->add_result( );
    $result->set_index( $product_index );
    $result->set_art_nr( $product->art_nr() );
    $ref = $product->reference();
    if( !is_null($ref) )
      $result->set_reference( $ref );

    __import_single_product( $product, $result );
  }

  $response->set_count( $product_index );
  return $response;
}


function _do_import_scaleprices(&$art,&$product,&$result)
  {
  if(empty($art['oxartid']))
    return false;

  $oxartid=$art['oxartid'];

  $qr = act_db_query( "DELETE FROM oxprice2article WHERE `oxartid` = '{$oxartid}'" );

  $spgs=_act_get_pricegroups( );

  $pgfgroup=array();

  for( $i=0; $i<$product->preisgruppen_size(); $i++ )
    {
    $pg = $product->preisgruppen( $i );
    $k = $pg->preisgruppe();

    if($GLOBALS['myConfig']->getEdition()=='EE')
      {
      if($k!=0 && isset($spgs[$k]))
        {
        $ks=(string)$k;
        $ilen=(int)substr($ks,0,1);

        $shop_id=substr($ks,1,$ilen);
        $k=substr($ks,$ilen+1);
        }
    else
        continue;
      }
    else
      $shop_id='oxbaseshop';

      if( $k != 0 )
      continue;

      $ps=array();
      $arr = $product->preisgruppen($i)->toArray();
      $is_brutto=$arr['is_brutto'];
      if( is_array($arr['preisstaffeln']) && count($arr['preisstaffeln']) )
        {
          foreach( $arr['preisstaffeln'] as $_ps )
          {
            if( $_ps['preis_range'] > 0 && $_ps['preis_gruppe'] > 0 )
              $ps[] = $_ps;
          }

          $ps_amountto = array();
          foreach ($ps as $k => $a)
          {
            $ps_amountto[$k-1] = $a['preis_range']-1;
          }
          $ps_amountto[]= 100 * 1000 * 1000; // some large, yet non-confusing number
          foreach ($ps as $k => $a)
          {
          if($product instanceof ShopProduct)
            $mwst=$product->mwst();
          else if(is_float($product->mwst))
            $mwst=$product->mwst;
          else
            $mwst=19;

            $arr = array(
              'oxid' => oxUtilsObject::getInstance()->generateUID(),
              'oxartid' => $oxartid,
              'oxaddabs' => $a['preis_gruppe']*($is_brutto? 1:((float)$mwst>0?(1+$mwst/100):1)),
              'oxamount' => $a['preis_range'],
              'oxamountto' => $ps_amountto[$k],
              'oxshopid' => $shop_id,
            );
            $set = construct_set( $arr, 'oxprice2article' );
            $res = act_db_query($q="INSERT INTO oxprice2article {$set['set']}" );

            if( !$res )
            {
              $result->set_ok( FALSE );
              $result->set_errno( EIO );
              $result->set_error( utf8_encode("Fehler beim einfügen/ändern der Preise in der Tabelle 'oxprice2article'") );
              return FALSE;
            }

          }
        }
    }

  return TRUE;
  }

function _do_import_pricegroups(&$art,&$product,&$result,$is_attr=false)
  {
  if(empty($art['oxartid']))
    return false;

  $oxartid=$art['oxartid'];

  $res = act_db_query($q="DELETE FROM  `oxfield2shop` WHERE oxartid='{$oxartid}'");

  $_pp_map = array(
    -1 => 'oxtprice',
    0 => 'oxprice',
    1 => 'oxpricea',
    2 => 'oxpriceb',
    3 => 'oxpricec',
  );
  $spgs=_act_get_pricegroups( );
  $pgfgroup=array();
  for( $i=0; $i<$product->preisgruppen_size(); $i++ )
    {
      $pg = $product->preisgruppen( $i );
      $k = $pg->preisgruppe();

    if($GLOBALS['myConfig']->getEdition()=='EE')
      {
      if($k!=0 && isset($spgs[$k]))
        {
        $ks=(string)$k;
        $ilen=(int)substr($ks,0,1);

        $shop_id=substr($ks,1,$ilen);
        $k=substr($ks,$ilen+1);
        }
      else
        continue;
      }
    else
      $shop_id='oxbaseshop';

      if (array_key_exists($k, $_pp_map)) {
        if ($_pp_map[$k] == 'oxtprice' && (float)$pg->grundpreis() <= (float)$product->grundpreis()) {
          continue;
        }
        if($product instanceof ShopProduct)
          $mwst=$product->mwst();
        else if(is_float($product->mwst))
          $mwst=$product->mwst;
        else
          $mwst=19;

        $pgfgroup[$shop_id][ $_pp_map[ $k ] ] = $pg->grundpreis();
        if (!$pg->is_brutto()) $pgfgroup[$shop_id][ $_pp_map[ $k ] ] *= ((float)$mwst>0?(1+$mwst/100):1); // XXX
      }

      if( $k != 0 )
        continue;

      if(!is_array($pg0))
        $pg0 = array( 'grundpreis'=>$pg->grundpreis(), 'is_brutto'=>$pg->is_brutto() );
      else if($pg0['grundpreis']<$pg->grundpreis()) //we use the smallest gp so it fits in all shops
        $pg0 = array( 'grundpreis'=>$pg->grundpreis(), 'is_brutto'=>$pg->is_brutto() );

    }

  foreach($pgfgroup as $shop_id=>$pgroup)
    {
      if($GLOBALS['myConfig']->getEdition()=='EE') //shopid may result in problems on non EE versions
      $pgroup['oxshopid']=$shop_id;

      $pgroup['oxartid']=esc($oxartid);

      if($shop_id==1 || $GLOBALS['myConfig']->getEdition()!='EE')
        {
        $pgroup['oxid']=esc($oxartid);
        $set = construct_set( $pgroup, 'oxarticles' );
        $PostSet=substr($set['set'],3);
        $res = act_db_query($q="INSERT INTO `oxarticles` ".$set['set']." ON DUPLICATE KEY UPDATE ".$PostSet);

        if( !$res )
          {
            $result->set_ok( FALSE );
            $result->set_errno( EIO );
            $result->set_error( utf8_encode("Fehler beim einfügen/ändern der Preise in der Tabelle 'oxarticles'") );
            return FALSE;
          }
        }
      else
        {
        $pgroup['oxid']= oxUtilsObject::getInstance()->generateUID();
        $set = construct_set( $pgroup, 'oxfield2shop' );
        $PostSet=substr($set['set'],3);
        $res = act_db_query($q="INSERT INTO `oxfield2shop` ".$set['set']." ON DUPLICATE KEY UPDATE ".$PostSet);

        if( !$res )
          {
            $result->set_ok( FALSE );
            $result->set_errno( EIO );
            $result->set_error( utf8_encode("Fehler beim einfügen/ändern der Preise in der Tabelle 'oxfield2shop'") );
            return FALSE;
          }
        }
    }

  if($is_attr==true)
    {
    $shop_prod=$product->shop();

    if(is_object($shop_prod))
      $shop_art=$shop_prod->shop();
    }
  else
  $shop_art=$product->shop();

  if(is_object($shop_art))
    {
    $ppset=array('oxid'=>esc($oxartid));
    for( $i=0; $i<$shop_art->products_pseudoprices_size(); $i++ )
      {
        $pp = $shop_art->products_pseudoprices( $i );
        $k = $pp->preisgruppe();

        if ($k == -1 && array_key_exists($k, $_pp_map))
        {
          if( $pp->pseudoprice() > $pg0['grundpreis'] )
            $ppset[ $_pp_map[$k] ] = $pp->pseudoprice();
          else
            $ppset[ $_pp_map[$k] ] = 0;
        }
      }
    $set = construct_set( $ppset, 'oxarticles' );
    $res = act_db_query($q="UPDATE `oxarticles` ".$set['set']." WHERE oxid='".$oxartid."'");
    }

  return TRUE;
  }

function __import_single_product( &$product, &$result )
{
  $langcode_to_id = array_flip( get_language_id_to_code() );

  $res = act_db_query( "SELECT `oxid` FROM `oxarticles` WHERE oxartnum='".esc($product->art_nr())."' AND `oxparentid`=''" );
  $art_oxid = act_db_fetch_assoc($res);
  if( !is_array($art_oxid) ) {
    $art_oxid = null;
  }
  else {
    $art_oxid = $art_oxid['oxid'];
  }
  act_db_free( $res );

  $shop_art = $product->shop();
  if( !is_object($shop_art) )
  {
    $result->set_ok( FALSE );
    $result->set_errno( EINVAL );
    $result->set_error( "Shop-Artikeldaten nicht gesetzt oder Fehler bei der Übermittlung" );
    return;
  }


  if(strpos($shop_art->shipping_status_text(),ACTINDO_SETTING_CLEAR)!==false)
    {
    $mindl='';
    $maxdl='';
    $delunit='';
    }
  else if(strpos($shop_art->shipping_status_text(),ACTINDO_SETTING_KEEP)!==false)
    {
    $mindl=null;
    $maxdl=null;
    $delunit=null;
    }
  else
    {
  $status_text=$shop_art->shipping_status_text();
  list($steps,$delunit)=explode(" ",$status_text);

    $delunit=substr($delunit,0,strlen($delunit)-1);
  list($mindl,$maxdl)=explode("-",$steps);
    }

  if(strpos($shop_art->shipping_status_lager_zero_text(),ACTINDO_SETTING_KEEP)!==false)
    $onnostock_text=null;
  else if(strpos($shop_art->shipping_status_lager_zero_text(),ACTINDO_SETTING_CLEAR)!==false)
    $onnostock_text='';
  else
    {
    $nostocktext=$shop_art->shipping_status_lager_zero_text();
    list($steps,$nostock_delunit)=explode(" ",$nostocktext);
    $tunit=oxLang::getInstance()->translateString($nostock_delunit,oxLang::getInstance()->getBaseLanguage());

    if($tunit==$nostock_delunit)
      $onnostock_text=$nostocktext;
    else
      $onnostock_text=$steps." ".$tunit;
    }

  $mmp_field=1;
  $incl=array(1=>1);
  for($x=0;$x<$product->multistore_permission_size();$x++)
    {
    if((int)$product->multistore_permission($x)->included()>0)
      {
      $shp=$product->multistore_permission($x)->included();
      $mmp_field=$mmp_field | 1<<((int)$shp-1);
      $incl[$shp]=$shp;
    }
    }

    $res1 = act_db_query( "SELECT * FROM oxshops WHERE oxismultishop = 0 AND oxid!=1" );

    $mmp_exclfield=0;
    while( $row = act_db_fetch_assoc($res1) )
    {
    if(!isset($incl[$row['oxid']]))
      $mmp_exclfield=$mmp_exclfield | 1<<((int)$row['oxid']-1);
    }
    act_db_free( $res1 );

  $arr = array(
    'oxshopincl'=>$mmp_field,
    'oxshopexcl'=>$mmp_exclfield,
    'oxprice' => $product->preisgruppen(0)->grundpreis() * ($product->preisgruppen(0)->is_brutto() ? 1 : ((float)$product->mwst()>0?(1+$product->mwst()/100):1)),    // XXX
    'oxactive' => ((int)$shop_art->products_status()==1) ? 1 : 0,
    'oxartnum' => $product->art_nr(),
    'oxtitle' => $product->art_name(),
    'oxvat' => $product->mwst() == $GLOBALS['myConfig']->getConfigParam('dDefaultVAT') ? null : $product->mwst(),
    'oxstock' => $product->l_bestand(),
    'oxweight' => $shop_art->products_weight(),
    'oxean' => $product->products_ean(),
    'oxactivefrom' => $shop_art->products_date_available() > 0 ? timestamp_to_datetime($shop_art->products_date_available()) : '0000-00-00 00:00:00',
    'oxdelivery' => (string)$shop_art->products_date_available() > 0 ? timestamp_to_datetime($shop_art->products_date_available()) : '0000-00-00 00:00:00',
//    'oxsort' => $shop_art->products_sort(),         FELD NUR FÜR VARIANTEN, nicht hauptartikel!!
    'oxunitquantity' => $shop_art->products_vpe_status() ? $shop_art->products_vpe_value() : 0,
    'oxunitname' => $shop_art->products_vpe_status() ? $shop_art->products_vpe() : '',
    'oxtemplate' => $shop_art->info_template(),
    'oxactiveto' => $shop_art->activeto() > 0 ? timestamp_to_datetime($shop_art->activeto()) : '0000-00-00 00:00:00',
    'oxnonmaterial' => $shop_art->products_digital(),
    'oxfreeshipping' => $shop_art->shipping_free(),
    'oxdistean' => $shop_art->supplierean(),
    'oxlength' => $shop_art->length(),
    'oxwidth' => $shop_art->width(),
    'oxheight' => $shop_art->height(),
    'oxnonmaterial' => $shop_art->nonmaterial(),
    'oxissearch' => is_null($shop_art->non_searchable()) ? null : ($shop_art->non_searchable() ? 0 : 1),
    'oxblfixedprice' => (float)$shop_art->fixedprice(),
    'oxskipdiscounts' => $shop_art->skipdiscounts(),
    'oxbprice' => $product->ek(),
    'oxnostocktext' => $onnostock_text,
    'oxmindeltime'=>$mindl,
    'oxmaxdeltime'=>$maxdl,
    'oxdeltimeunit'=>$delunit,
    'oxmpn'=>$shop_art->products_mpn(),
  );
  if( is_object($product->description(0)) )
  {
    $arr['oxexturl'] = strtr( $product->description(0)->products_url(), array('https://'=>'', 'http://'=>'') );
    $arr['oxurldesc'] = $product->description(0)->products_url();
  }


  if( $GLOBALS['myConfig']->getRevision() < 18998 )
  {
    $arr['oxvendorid'] = $shop_art->manufacturers_id();
  }
  else
  {
    $arr['oxvendorid'] = $shop_art->vendors_id();
    $arr['oxmanufacturerid'] = $shop_art->manufacturers_id();
  }

  $_pp_map = array(
    -1 => 'oxtprice',
    0 => 'oxprice',
    1 => 'oxpricea',
    2 => 'oxpriceb',
    3 => 'oxpricec',
  );



  if(is_null($art_oxid))
    $art_oxid = oxUtilsObject::getInstance()->generateUID();

  $arr['oxartid']=$art_oxid;

  // descriptions, part 1 of 2
  _do_import_descriptions_step1( $product, $arr, $oxartextends_array, $oxseo_array, $langcode_to_id );

  foreach( $arr as $_key => $_val )
  {
    if( $_key != 'oxvat' && is_null($_val) )
      unset( $arr[$_key] );
  }
  $arr['oxid']=$art_oxid;
  $set = construct_set( $arr, 'oxarticles' );
  $PostSet=substr($set['set'],3);
  $res = act_db_query($q="INSERT INTO `oxarticles` ".$set['set'].", `oxtimestamp`=NOW(),`oxinsert`=NOW() ON DUPLICATE KEY UPDATE ".$PostSet.", `oxtimestamp`=NOW()");

  if( !$res )
  {
    $result->set_ok( FALSE );
    $result->set_errno( EIO );
    $result->set_error( utf8_encode("Fehler beim einfügen/ändern des Artikels in der Tabelle 'oxarticles'") );
    return;
  }


  // descriptions, part 2 of 2
  if( !count($oxartextends_array) )
  {
    $res = act_db_query( $q="REPLACE INTO `oxartextends` SET `oxid`='".esc($art_oxid)."'" );
  }
  else
  {
    $set = construct_set( $oxartextends_array, 'oxartextends' );
    $res = act_db_query( $q="UPDATE `oxartextends` ".$set['set']." WHERE `oxid`='".esc($art_oxid)."'" );
    if( !act_affected_rows() && act_db_get_single_row("SELECT COUNT(*) FROM `oxartextends` WHERE `oxid`='".esc($art_oxid)."'") == 0 )
      $res = act_db_query( $q="INSERT INTO `oxartextends` ".$set['set'].", `oxid`='".esc($art_oxid)."'" );
  }

  if( !$res )
  {
    $result->set_ok( FALSE );
    $result->set_errno( EIO );
    $result->set_error( "Fehler beim einfügen/ändern des Artikels in der Tabelle 'oxartextends'" );
    return;
  }

  if( count($oxseo_array) )
  {
    $res=_do_import_seo($art_oxid,$oxseo_array,$result);

      if( !$res )
      {
        $result->set_ok( FALSE );
        $result->set_errno( EIO );
          $result->set_error( utf8_encode("Fehler beim einfügen/ändern der SEO Daten") );
        return;
      }
    }


  $res= _do_import_pricegroups($arr,$product,$result);
  if( !$res )
  {
    $result->set_ok( FALSE );
    $result->set_errno( EIO );
    $result->set_error( utf8_encode("Fehler beim einfügen/ändern der Preisgruppen.") );
    return;
  }

  $res= _do_import_scaleprices($arr,$product,$result);
  if( !$res )
  {
    $result->set_ok( FALSE );
    $result->set_errno( EIO );
    $result->set_error( utf8_encode("Fehler beim einfügen/ändern der Preisstaffeln") );
    return;
  }


  // categories
  $res = _do_import_all_categories( $art_oxid, $product, $result );
  if( !$res )
  {
    $result->set_ok( FALSE );
    $result->set_errno( EIO );
    $result->set_error( "Fehler beim Zuordnen der Kategorien" );
    return;
  }

  // xselling
  $res = _do_import_xselling( $art_oxid, $product, $result );
  if( !$res )
  {
    $result->set_ok( FALSE );
    $result->set_errno( EIO );
    $result->set_error( "Fehler beim Zuordnen der Cross-Sellings" );
    return;
  }

  // properties
  $res = _do_import_properties( $art_oxid, $product, $result, $langcode_to_id );
  if( !$res )
  {
    $result->set_ok( FALSE );
    $result->set_errno( EIO );
    $result->set_error( "Fehler beim Zuordnen der Attribute (Zusatzfelder)" );
    return;
  }

  // content
  $res = _do_import_content( $art_oxid, $product, $result, $langcode_to_id );
  if( !$res )
  {
    $result->set_ok( FALSE );
    $result->set_errno( EIO );
    $result->set_error( "Fehler beim Zuordnen der Attribute (Zusatzfelder)" );
    return;
  }

  // attributes
  $res = _do_import_attributes( $art_oxid, $product, $result );
  if( !$res )
  {
    $result->set_ok( FALSE );
    $result->set_errno( EIO );
    $result->set_error( "Fehler beim Zuordnen der Varianten" );
    return;
  }

  // images - call this at the end !IMPORTANT!
  $res = _do_import_images( $art_oxid, $product, $result );
  if( !$res )
  {
    $result->set_ok( FALSE );
    $result->set_errno( EIO );
    $result->set_error( "Fehler beim Zuordnen der Bilder" );
    return;
  }

  #bug #94491
  //set article sub shop
  $res = _do_import_subshops($art_oxid, $product, $result);
  $result->set_ok( TRUE );
  if( !$res )
  {
    $result->set_ok( FALSE );
    $result->set_errno( EIO );
    $result->set_error( "Fehler beim Zuordnen des Sub Shops" );
    return;
  }
  
  
  $result->set_ok( TRUE );
}


function _do_import_descriptions_step1( &$product, &$arr, &$oxartextends_array, &$oxseo_array, $langcode_to_id )
{
  $oxartextends_array = $oxseo_array = array();
  for( $i=0; $i<$product->description_size(); $i++ )
  {
    $desc = $product->description( $i );
    if( !isset($langcode_to_id[$desc->language_code()]) )
      continue;

    $language_id = $langcode_to_id[$desc->language_code()];

    // Stamm
    $pn = $desc->products_name();
    if( !empty($pn) )
      $arr[_actindo_get_lang_field('oxtitle', $language_id)] = $pn;
    else
      $arr[_actindo_get_lang_field('oxtitle', $language_id)] = $product->art_name();

    if( !is_null($desc->products_short_description()) )
    {
      $decoded = html_entity_decode( $desc->products_short_description() );
      $decoded = strtr( $decoded, array(chr(160)=>' ') );  // IMPORTANT!!
      $arr[_actindo_get_lang_field('oxshortdesc', $language_id)] = trim( strip_tags( $decoded ) );
    }
    if( !is_null($desc->products_keywords()) )
    {
      $arr[_actindo_get_lang_field('oxsearchkeys', $language_id)] = $desc->products_keywords();
    }

    // Stamm (oxartextends)
    if( !is_null($desc->products_description()) )
      $oxartextends_array[_actindo_get_lang_field('oxlongdesc', $language_id)] = $desc->products_description();
    if( !is_null($desc->products_tags()) )
      $oxartextends_array[_actindo_get_lang_field('oxtags', $language_id)] = $desc->products_tags();

    // SEO (oxseo) ist normalisiert (oxlang)
    if( !is_null($desc->products_meta_keywords()) )
      $oxseo_array[$language_id-1]['oxkeywords'] = $desc->products_meta_keywords();
    if( !is_null($desc->products_meta_description()) )
      $oxseo_array[$language_id-1]['oxdescription'] = $desc->products_meta_description();
  }
}


function _do_import_seo($art_oxid,$oxseo_array,&$result)
{
  if( count($oxseo_array) )
  {
  $shop_res=act_db_query("SELECT oxid FROM oxshops");

  $shops=array();
  if($GLOBALS['myConfig']->getEdition()=='EE')
    {
    while($shop=act_db_fetch_assoc($shop_res))
      {
      $shops[]=$shop['oxid'];
      }
    }
  else
    $shops[]='oxbaseshop';

  foreach($shops as $shop_id)
    {
    foreach( $oxseo_array as $_lang => $seo )
      {
      $seo['oxshopid']=$shop_id;

        if( version_compare($GLOBALS['myConfig']->getVersion(), '4.4.7', '<') )
        {
          $set = construct_set( $seo, 'oxseo' );
          $res = act_db_query( $q="UPDATE `oxseo` ".$set['set']." WHERE `oxobjectid`='".esc($art_oxid)."' AND `oxtype`='oxarticle' AND `oxlang`=".(int)$_lang . " AND oxshopid='".$seo['oxshopid']."'");
          if( $res && !act_affected_rows() && !act_db_get_single_row("SELECT COUNT(*) FROM `oxseo` WHERE `oxobjectid`='".esc($art_oxid)."' AND `oxtype`='oxarticle' AND `oxlang`=".((int)$_lang)." AND oxshopid='".$seo['oxshopid']."'"))
          {
            $oxident = oxUtilsObject::getInstance()->generateUID();
            $res = act_db_query( $q="INSERT INTO `oxseo` ".$set['set'].", `oxobjectid`='".esc($art_oxid)."', `oxtype`='oxarticle', `oxlang`=".(int)$_lang.", `oxident`='".esc($oxident));
          }
        }
        else
        {
          $set = construct_set( $seo, 'oxobject2seodata' );
          $res = act_db_query( $q="UPDATE `oxobject2seodata` ".$set['set']." WHERE `oxobjectid`='".esc($art_oxid)."' AND `oxlang`=".(int)$_lang . " AND oxshopid='".$seo['oxshopid']."'");
          if( $res && !act_affected_rows() && !act_db_get_single_row($q="SELECT COUNT(*) FROM `oxobject2seodata` WHERE `oxobjectid`='".esc($art_oxid)."' AND `oxlang`=".((int)$_lang)." AND oxshopid='".$seo['oxshopid']."'"))
          {
            $res = act_db_query( $q="INSERT INTO `oxobject2seodata` ".$set['set'].", `oxobjectid`='".esc($art_oxid)."', `oxlang`=".(int)$_lang);
          }
        }
        if( !$res )
        {
          $result->set_ok( FALSE );
          $result->set_errno( EIO );
          $result->set_error( "Fehler beim einfuegen/aendern des Artikels in der Tabelle 'oxseo' (oxlang=".(int)$_lang.")" );
          return;
        }
      }
    }
  }

return true;
}

#bug #94491
function _do_import_subshops($art_oxid, &$product, &$result){
	if($product->multistore_permission_size()>0)
		$storeid=1;
		for($i=0;$i<$product->multistore_permission_size();$i++){
			$storeid += (int)$product->multistore_permission($i)->included();
		}		
		$sql = 'UPDATE oxarticles set oxshopincl=\''.esc($storeid).'\' WHERE oxid=\''.esc($art_oxid).'\';';
		$return = act_db_query($sql);
		if($return === false){
			$result->set_ok(FALSE);
			$result->set_errno(EIO);
			$result->set_error( "Fehler beim einfuegen/aendern der Shop-Sichtbarkeit für shop $storeid" );
			return;
		}
	return true;
}

function _do_import_attributes( $art_oxid, &$product, &$result )
{
  $langcode_to_id = array_flip( get_language_id_to_code() );

  $attributes = $product->attributes();

  $has_active_childs=false;

  if( !is_object($attributes) )
    {
    $res = act_db_query( $q="SELECT `oxid` FROM `oxarticles` WHERE `oxparentid`='".esc($art_oxid)."'");

    while( $child_art = act_db_fetch_assoc($res) )
    {
      $art = new oxArticle();
      $art->delete( $child_art['oxid'] );
    }
    act_db_free( $res );
    return TRUE;
    }

  $names = array();
  for( $i=0; $i<$attributes->names_size(); $i++ )
  {
    $attr_name = $attributes->names( $i );
    $names[$attr_name->name_id()] = array();
    for( $j=0; $j<$attr_name->translation_size(); $j++ )
    {
      $xlation = $attr_name->translation( $j );
      if( !isset($langcode_to_id[$xlation->language_code()]) )
        continue;
      $lang_id = $langcode_to_id[$xlation->language_code()];
      $names[$attr_name->name_id()][$lang_id] = $xlation->name();
    }
  }

  $values = array();
  for( $i=0; $i<$attributes->values_size(); $i++ )
  {
    $attr_value = $attributes->values( $i );
    $values[$attr_value->name_id()][$attr_value->value_id()] = array();
    for( $j=0; $j<$attr_value->translation_size(); $j++ )
    {
      $xlation = $attr_value->translation( $j );
      if( !isset($langcode_to_id[$xlation->language_code()]) )
        continue;
      $lang_id = $langcode_to_id[$xlation->language_code()];
      $values[$attr_value->name_id()][$attr_value->value_id()][$lang_id] = $xlation->name();
    }
  }

  $res = act_db_query( "SELECT `oxid`,`oxartnum` FROM `oxarticles` WHERE `oxparentid`='".esc($art_oxid)."'" );
  $pre_child_arr=array();
  $post_child_arr=array();
  while( $child_art = act_db_fetch_assoc($res) )
  {
    $pre_child_arr[$child_art['oxartnum']]=$child_art['oxid'];
  }
  act_db_free( $res );

  $res = act_db_query( "SELECT * FROM `oxarticles` WHERE `oxid`='".esc($art_oxid)."'" );
  $parent_art_data = act_db_fetch_assoc( $res );
  foreach( $langcode_to_id as $language_id )
    unset( $parent_art_data[_actindo_get_lang_field('oxvarname', $language_id)] );
  act_db_free( $res );

  $res = TRUE;
  $oxvarname = array();
  $oxvarnamedone = FALSE;
  for( $i=0; $i<$attributes->combination_advanced_size(); $i++ )
  {
    $comb_adv = $attributes->combination_advanced( $i );
    $comb_adv->mwst=$product->mwst();

    $pg0 = array();
    $oxvarselect = array();

    for( $combidx=0; $combidx<$comb_adv->combination_size(); $combidx++ )
    {
      $comb = $comb_adv->combination( $combidx );
      if( !$oxvarnamedone )
      {
        foreach( $names[$comb->name_id()] as $_langid => $_val )
          $oxvarname[$_langid][] = $_val;
      }
      foreach( $values[$comb->name_id()][$comb->value_id()] as $_langid => $_val )
        $oxvarselect[$_langid][] = $_val;
    }
    $oxvarnamedone = TRUE;

    if( !$comb_adv->data()->products_status() )
      $products_status = false;
    else
    {
    if(is_object($attribute_product=$comb_adv->shop()) )
      {
      $products_status = (boolean)$attribute_product->products_status();
      }
    else
      $products_status = true;
    }

    $child_art_data = $parent_art_data;

    if($attrproduct=$comb_adv->shop())
      {
      $child_art_data['oxean'] = $attrproduct->products_ean();

      if(!is_object($shop_art=$comb_adv->shop()->shop()) )
        $shop_art=$product->shop();

      if(is_object($shop_art))
        {
        if(strpos($shop_art->shipping_status_text(),ACTINDO_SETTING_CLEAR)!==false)
          {
          $mindl='';
          $maxdl='';
          $delunit='';
          }
        else if(strpos($shop_art->shipping_status_text(),ACTINDO_SETTING_KEEP)!==false)
          {
          $mindl=null;
          $maxdl=null;
          $delunit=null;
          }
        else
          {
        $status_text=$shop_art->shipping_status_text();
        list($steps,$delunit)=explode(" ",$status_text);

          $delunit=substr($delunit,0,strlen($delunit)-1);
        list($mindl,$maxdl)=explode("-",$steps);
          }

        if(strpos($shop_art->shipping_status_lager_zero_text(),ACTINDO_SETTING_KEEP)!==false)
          $onnostock_text=null;
        else if(strpos($shop_art->shipping_status_lager_zero_text(),ACTINDO_SETTING_CLEAR)!==false)
          $onnostock_text='';
        else
          {
          $nostocktext=$shop_art->shipping_status_lager_zero_text();
          list($steps,$nostock_delunit)=explode(" ",$nostocktext);
          $tunit=oxLang::getInstance()->translateString($nostock_delunit,oxLang::getInstance()->getBaseLanguage());

          if($tunit==$nostock_delunit)
            $onnostock_text=$nostocktext;
          else
            $onnostock_text=$steps." ".$tunit;
          }

        if((int)$attrproduct->products_status()==0)
          $products_status=0;

        $arr = array(
            'oxweight' => (float)$shop_art->products_weight(),
            'oxactivefrom' => (string)$shop_art->products_date_available() > 0 ? timestamp_to_datetime($shop_art->products_date_available()) : '0000-00-00 00:00:00',
            'oxdelivery' => (string)$shop_art->products_date_available() > 0 ? timestamp_to_datetime($shop_art->products_date_available()) : '0000-00-00 00:00:00',
            'oxunitquantity' => $shop_art->products_vpe_status() ? $shop_art->products_vpe_value() : 0,
            'oxunitname' => $shop_art->products_vpe_status() ? $shop_art->products_vpe() : '',
            'oxtemplate' => $shop_art->info_template(),
            'oxactiveto' => $shop_art->activeto() > 0 ? timestamp_to_datetime($shop_art->activeto()) : '0000-00-00 00:00:00',
            'oxnonmaterial' => $shop_art->products_digital(),
            'oxfreeshipping' => $shop_art->shipping_free(),
            'oxdistean' => $shop_art->supplierean(),
            'oxlength' => $shop_art->length(),
            'oxwidth' => $shop_art->width(),
            'oxheight' => $shop_art->height(),
            'oxnonmaterial' => $shop_art->nonmaterial() ? 1 : 0,
            'oxissearch' => is_null($shop_art->non_searchable()) ? null : ($shop_art->non_searchable() ? 0 : 1),
            'oxblfixedprice' => (float)$shop_art->fixedprice(),
            'oxskipdiscounts' => $shop_art->skipdiscounts(),
            'oxnostocktext' => $onnostock_text,
            'oxmindeltime'=>$mindl,
            'oxmaxdeltime'=>$maxdl,
            'oxdeltimeunit'=>$delunit,
            'oxmpn'=>$shop_art->products_mpn(),
            'oxbprice'=>$attrproduct->ek()?$attrproduct->ek():$product->ek(), 
          );

          if( $GLOBALS['myConfig']->getRevision() < 18998 )
          {
            $arr['oxvendorid'] = $shop_art->manufacturers_id();
          }
          else
          {
            $arr['oxvendorid'] = $shop_art->vendors_id();
            $arr['oxmanufacturerid'] = $shop_art->manufacturers_id();
          }

        foreach($arr as $key=>$val)
          {
          if(!is_null($val))
          $child_art_data[$key]=$val;
          }
        }
      else
        {//fields wich are not handeld by the connector will resist
        $child_art_data['oxweight']='';
        $child_art_data['oxactivefrom']='';
        $child_art_data['oxdelivery']='';
        $child_art_data['oxunitquantity']='';
        $child_art_data['oxunitname']='';
        $child_art_data['oxtemplate']='';
        $child_art_data['oxactiveto']='';
        $child_art_data['oxnonmaterial']='';
        $child_art_data['oxfreeshipping']='';
        $child_art_data['oxdistean']='';
        $child_art_data['oxlength']='';
        $child_art_data['oxwidth']='';
        $child_art_data['oxheight']='';
        $child_art_data['oxnonmaterial']='';
        $child_art_data['oxissearch']='';
        $child_art_data['oxissearch']='';
        $child_art_data['oxblfixedprice']='';
        $child_art_data['oxskipdiscounts']='';
        $child_art_data['oxnostocktext']='';
        $child_art_data['oxmindeltime']='';
        $child_art_data['oxmaxdeltime']='';
        $child_art_data['oxdeltimeunit']='';
        $child_art_data['oxmpn']='';
        $child_art_data['oxvendorid']='';
        $child_art_data['oxmanufacturerid']='';
        }
          }


  if(is_object($attribute_product=$comb_adv->shop()) )
      {
  if( is_object($attribute_product->description(0)) )
  {
    $child_art_data['oxexturl'] = strtr( $attribute_product->description(0)->products_url(), array('https://'=>'', 'http://'=>'') );
    $child_art_data['oxurldesc'] = $attribute_product->description(0)->products_url();
        }
  }

    $child_oxid = isset($pre_child_arr[$comb_adv->art_nr()])?$pre_child_arr[$comb_adv->art_nr()]:oxUtilsObject::getInstance()->generateUID();

    if(isset($pre_child_arr[$comb_adv->art_nr()]))
      unset($pre_child_arr[$comb_adv->art_nr()]);

    $post_child_arr[]=$child_oxid;

    unset( $child_art_data['oxtprice'] );
    unset( $child_art_data['oxinsert']);
    unset( $child_art_data['oxsort'] );
    $child_art_data['oxid'] = $child_oxid;
    $child_art_data['oxparentid'] = $art_oxid;
    $child_art_data['oxactive'] = $products_status ? 1 : 0;
    $child_art_data['oxartnum'] = $comb_adv->art_nr();
    $child_art_data['oxprice'] = ($GLOBALS['myConfig']->getEdition()=='EE')? 0:($pg0['grundpreis']* ($pg0['is_brutto'] ? 1 : ((float)$product->mwst()>0?(1+$product->mwst()/100):1)));
    $child_art_data['oxthumb'] = 'nopic.jpg';
    $child_art_data['oxicon'] = 'nopic_ico.jpg';
    $child_art_data['oxstock'] = $comb_adv->l_bestand();
    $child_art_data['oxvarcount']=0;
    $child_art_data['oxvarstock']=0;

    if($child_art_data['oxactive']==1)
      $has_active_childs=true;

    for( $imgidx=1; $imgidx<=$GLOBALS['myConfig']->getConfigParam( 'iPicCount' ); $imgidx++ )
      $child_art_data['oxpic'.$imgidx] = 'nopic.jpg';

    if( version_compare($GLOBALS['myConfig']->getVersion(), '4.4.7', '<') )
    {
      for( $imgidx=1; $imgidx<=$GLOBALS['myConfig']->getConfigParam( 'iZoomPicCount' ); $imgidx++ )
        $child_art_data['oxzoom'.$imgidx] = 'nopic.jpg';
    }
    else
    {
      $child_art_data['oxpicsgenerated'] = 0;
    }

    foreach( $oxvarselect as $_langid => $_val )
    {
      $_val = join( ' | ', $_val );
      $child_art_data[_actindo_get_lang_field('oxvarselect', $_langid)] = $_val;
    }

    $oxartextends_array = $oxseo_array = array();
    if( is_object($attribute_product=$comb_adv->shop()) )
    {
      _do_import_descriptions_step1( $attribute_product, $child_art_data, $oxartextends_array, $oxseo_array, $langcode_to_id );
    }

    if( !count($oxartextends_array) )
    {
      $res &= act_db_query( $q="REPLACE INTO `oxartextends` SET `oxid`='".esc($child_oxid)."'" );
    }
    else
    {
      // descriptions, part 2 of 2
      $set = construct_set( $oxartextends_array, 'oxartextends' );
      $res &= act_db_query( $q="UPDATE `oxartextends` ".$set['set']." WHERE `oxid`='".esc($child_oxid)."'" );
      if( !act_affected_rows() && act_db_get_single_row("SELECT COUNT(*) FROM `oxartextends` WHERE `oxid`='".esc($child_oxid)."'") == 0 )
        $res &= act_db_query( $q="INSERT INTO `oxartextends` ".$set['set'].", `oxid`='".esc($child_oxid)."'" );
    }
    $set = construct_set( $child_art_data, 'oxarticles' );
    $PostSet=substr($set['set'],3);
    $res = act_db_query( $q="INSERT INTO `oxarticles` ".$set['set'].",`oxinsert`=NOW(),`oxsort`=".($i+1)." ON DUPLICATE KEY UPDATE ".$PostSet);

    if( !$res )
    {
      $result->set_ok( FALSE );
      $result->set_errno( EIO );
      $result->set_error( "Fehler beim einfügen des Varianten-Artikels in die Tabelle 'oxarticles'" );
      return FALSE;
    }

    if( count($oxseo_array) )
      {
      $res=_do_import_seo($child_oxid,$oxseo_array,$result);

      if( !$res )
        {
          $result->set_ok( FALSE );
          $result->set_errno( EIO );
          $result->set_error( utf8_encode("Fehler beim einfügen/ändern der SEO Daten") );
          return;
        }
      }

      $child_art_data['oxartid']=$child_oxid;

    $res= _do_import_pricegroups($child_art_data,$comb_adv,$result,true);
      if( !$res )
        {
          $result->set_ok( FALSE );
          $result->set_errno( EIO );
          $result->set_error( utf8_encode("Fehler beim einfügen/ändern der Preisgruppe") );
          return;
        }

    $res= _do_import_scaleprices($child_art_data,$comb_adv,$result);
      if( !$res )
        {
          $result->set_ok( FALSE );
          $result->set_errno( EIO );
          $result->set_error( utf8_encode("Fehler beim einfügen/ändern der Preisstaffeln") );
          return;
        }




    if( is_object($attribute_product=$comb_adv->shop()) )
    {
      $res=_do_import_xselling( $child_oxid, $attribute_product, $result);
      if( !$res )
      {
        $result->set_ok( FALSE );
        $result->set_errno( EIO );
        $result->set_error( "Fehler beim Zuordnen der Cross-Sellings" );
        return;
      }

      $prop_res=_do_import_properties( $child_oxid, $attribute_product, $result,$langcode_to_id);
      if( !$prop_res )
      {
        $result->set_ok( FALSE );
        $result->set_errno( EIO );
        $result->set_error( "Fehler beim Zuordnen der Attribute (Zusatzfelder)" );
        return;
      }

      $res=_do_import_content( $child_oxid, $attribute_product, $result,$langcode_to_id);
      if( !$res )
      {
        $result->set_ok( FALSE );
        $result->set_errno( EIO );
        $result->set_error( "Fehler beim Zuordnen des Contents" );
        return;
    }

      $res=_do_import_images( $child_oxid, $attribute_product, $result );
      if( !$res )
    {
        $result->set_ok( FALSE );
        $result->set_errno( EIO );
        $result->set_error( "Fehler beim Zuordnen der Bilder" );
        return;
      }

    }
  }

  $res = act_db_query( $q="SELECT `oxid` FROM `oxarticles` WHERE `oxparentid`='".esc($art_oxid)."' AND (oxid IN('".implode("','",$pre_child_arr)."') OR oxid NOT IN('".implode("','",$post_child_arr)."'))");

  while( $child_art = act_db_fetch_assoc($res) )
  {
    $art = new oxArticle();
    $art->delete( $child_art['oxid'] );
  }
  act_db_free( $res );


  $add_fields_to_parent = array();
  foreach( $oxvarname as $_langid => $_val )
  {
    $_val = join( ' | ', $_val );
    $add_fields_to_parent[_actindo_get_lang_field('oxvarname', $_langid)] = $_val;
  }
  $add_fields_to_parent['oxvarcount'] = $attributes->combination_advanced_size();
  $set = construct_set( $add_fields_to_parent, 'oxarticles' );
  $res = act_db_query( "UPDATE `oxarticles` ".$set['set']." WHERE `oxid`='".esc($art_oxid)."'" );
  if( !$res )
  {
    $result->set_ok( FALSE );
    $result->set_errno( EIO );
    $result->set_error( "Fehler beim ändern des Auswahl-Namens in der Tabelle 'oxarticles'" );
    return FALSE;
  }

  if($has_active_childs)
    {
    $res=act_db_query($q="UPDATE `oxarticles` SET oxactive=1 WHERE `oxid`='".esc($art_oxid)."'");
    }
  else
    {
    $res=act_db_query($q="UPDATE `oxarticles` SET oxactive=0 WHERE `oxid`='".esc($art_oxid)."'");
    }

  return TRUE;
}


  function _cleanupCustomFields( $oArticle )
      {
          $sIcon  = $oArticle->oxarticles__oxicon->value;
          $sThumb = $oArticle->oxarticles__oxthumb->value;

          if ( $sIcon == "nopic.jpg" ) {
              $oArticle->oxarticles__oxicon = new oxField();
          }

          if ( $sThumb == "nopic.jpg" ) {
              $oArticle->oxarticles__oxthumb = new oxField();
          }
      }

  function _resetMasterPicture( $oArticle, $iIndex, $blDeleteMaster = false )
    {
        if ( $oArticle->{"oxarticles__oxpic".$iIndex}->value ) {

            if ( !$oArticle->isDerived() ) {
                $oPicHandler = oxPictureHandler::getInstance();
                $oPicHandler->deleteArticleMasterPicture( $oArticle, $iIndex, $blDeleteMaster );
            }

            if ( $blDeleteMaster ) {
                //reseting master picture field
                $oArticle->{"oxarticles__oxpic".$iIndex} = new oxField();
            }

            // cleaning oxzoom fields
            if ( isset( $oArticle->{"oxarticles__oxzoom".$iIndex} ) ) {
                $oArticle->{"oxarticles__oxzoom".$iIndex} = new oxField();
            }

            if ( $iIndex == 1 ) {
                _cleanupCustomFields( $oArticle );
            }
        }
    }

function _do_import_images( $art_oxid, &$product, &$result )
{

  $piccount = $GLOBALS['myConfig']->getConfigParam( 'iPicCount' );
  $zoompiccount = $GLOBALS['myConfig']->getConfigParam( 'iZoomPicCount' );
  $imgCnt = 0;

  $oart = new oxArticle();
  $res = $oart->load( $art_oxid );

  for($x=0;$x<$piccount;$x++)
    {
    _resetMasterPicture( $oart, $x,true);
    }
  $oart->save();


  $db_fields = array();
  $images = array();
  $imageidx = 0;
  $tmpfiles=array();
  for( $i=0; $i<$product->images_size(); $i++ )
  {
    $img = $product->images( $i );
    $res = actindo_create_temporary_file( $img->image() );
    if( !$res['ok'] )
    {
      $result->set_ok( FALSE );
      $result->set_errno( $res['errno'] );
      $result->set_error( $res['error'] );
      return FALSE;
    }
    $tmpfile = $res['file'];
    $image_type = $img->image_type();
    $extension = array(
      'image/jpeg' => 'jpg',
      'image/png' => 'png',
      'image/gif' => 'gif'
    );
    $image_name = $img->image_name();
    if( empty($image_name) )
      $image_name = 'img_'.$art_oxid.'.'.$extension[$image_type];
    else
    {
      $image_name = split( '\.', $image_name );
      array_unshift( $image_name, $art_oxid );
      array_pop( $image_name );
      array_push( $image_name, $extension[$image_type] );
      $image_name = join( '.', $image_name );
    }
    $image_name=preg_replace("/[^a-zA-Z0-9._-]/u","_",$image_name);
    $imageidx++;

    $images[$imageidx] = array( $res['file'], $image_type, $image_name );

  $tmpfiles[]=$tmpfile;
  }

  if( !is_array($images[1]) )
    $db_fields['oxicon'] = 'nopic_ico.jpg';
  else
  {
    list( $tmpfile, $image_type, $image_name ) = $images[1];
    preg_match("/\.([^\.]+)$/", $image_name, $matches);
    $image_name = str_replace( $matches[0], sprintf("_ico%s", $matches[0]), $image_name);

    if(strlen($image_name)>128)
      $image_name=substr($image_name,strlen($image_name)-128,strlen($image_name));

    $name = _do_import_image( 'icon', 1, 'icon', $image_type, $tmpfile, $image_name );
    $db_fields['oxicon'] = $name;
  }


  if( version_compare($GLOBALS['myConfig']->getVersion(), '4.5.0', '<') )
  {
    if( !is_array($images[1]) )
      $db_fields['oxthumb'] = 'nopic.jpg';
    else
    {
      list( $tmpfile, $image_type, $image_name ) = $images[1];

      if(strlen($image_name)>128)
        $image_name=substr($image_name,strlen($image_name)-128,strlen($image_name));

      $name = _do_import_image( 'thumb', 1, '0', $image_type, $tmpfile, $image_name );
      $db_fields['oxthumb'] = $name;
    }

    for( $i=1; $i<=$piccount; $i++ )
    {
      if( !is_array($images[$i]) )
        $db_fields['oxpic'.$i] = 'nopic.jpg';
      else
      {
        list( $tmpfile, $image_type, $image_name ) = $images[$i];
        if(strlen($image_name)>128)
          $image_name=substr($image_name,strlen($image_name)-128,strlen($image_name));

        $name = _do_import_image( 'pic', 1, $i, $image_type, $tmpfile, $image_name );
        $db_fields['oxpic'.$i] = $name;
        $imgCnt++;
      }
    }
  }
  else
  {
    if( !is_array($images[1]) )
      $db_fields['oxthumb'] = 'nopic.jpg';
    else
    {
      list( $tmpfile, $image_type, $image_name ) = $images[1];
      if(strlen($image_name)>128)
        $image_name=substr($image_name,strlen($image_name)-128,strlen($image_name));

      $name = _do_import_image( 'thumb', 1, 'thumb', $image_type, $tmpfile, $image_name );
      $db_fields['oxthumb'] = $name;
    }
  }


  if( version_compare($GLOBALS['myConfig']->getVersion(), '4.4.7', '<') )
  {
    for( $i=1; $i<=$zoompiccount; $i++ )
    {
      if( !is_array($images[$i]) )
        $db_fields['oxzoom'.$i] = 'nopic.jpg';
      else
      {
        list( $tmpfile, $image_type, $image_name ) = $images[$i];
        if(strlen($image_name)>128)
        $image_name=substr($image_name,strlen($image_name)-128,strlen($image_name));

        $name = _do_import_image( 'zoom', 1, 'z'.$i, $image_type, $tmpfile, $image_name );
        $db_fields['oxzoom'.$i] = $name;
      }
    }
  }
  else if( version_compare($GLOBALS['myConfig']->getVersion(), '4.5.0', '<') )
  {
    for( $i=1; $i<=$piccount; $i++ )
    {
      if( is_array($images[$i]) ) {
        list( $tmpfile, $image_type, $image_name ) = $images[$i];
        preg_match("/\.([^\.]+)$/", $image_name, $matches);
        $image_name = str_replace( $matches[0], sprintf("_ico%s", $matches[0]), $image_name);
        if(strlen($image_name)>128)
        $image_name=substr($image_name,strlen($image_name)-128,strlen($image_name));

        $name = _do_import_image( 'icon', 1, $i, $image_type, $tmpfile, $image_name );
      }
    }

    for( $i=1; $i<=$piccount; $i++ )
    {
      if( is_array($images[$i]) ) {
        list( $tmpfile, $image_type, $image_name ) = $images[$i];
        preg_match("/\.([^\.]+)$/", $image_name, $matches);
        $image_name = str_replace( $matches[0], sprintf("_z%d%s", $i ,$matches[0]), $image_name);

        if(strlen($image_name)>128)
          $image_name=substr($image_name,strlen($image_name)-128,strlen($image_name));

        $name = _do_import_image( 'zoom', 1, 'z'.$i, $image_type, $tmpfile, $image_name );
      }
    }

    for( $i=1; $i<=$piccount; $i++ )
    {
      if( is_array($images[$i]) ) {
        list( $tmpfile, $image_type, $image_name ) = $images[$i];

      if(strlen($image_name)>128)
        $image_name=substr($image_name,strlen($image_name)-128,strlen($image_name));

        $name = _do_import_image( 'master', 1, $i, $image_type, $tmpfile, $image_name );
      }
    }
    $db_fields['oxpicsgenerated'] = $imgCnt;
  }
  else
  {
    $idx = 1;
    for( $i=1; $i<=$piccount; $i++ )
    {
      if( is_array($images[$i]) )
      {
        list( $tmpfile, $image_type, $image_name ) = $images[$i];

        if(strlen($image_name)>128)
          $image_name=substr($image_name,strlen($image_name)-128,strlen($image_name));

        $name = _do_import_image( 'master', 1, $i, $image_type, $tmpfile, $image_name );
        $db_fields['oxpic'.($idx++)] = $name;
        $imgCnt++;
      }
    }
    $db_fields['oxpicsgenerated'] = $imgCnt;
  }


  foreach($tmpfiles as $tmpfile)
    {
    actindo_delete_temporary_file( $tmpfile );
    }

  $set = construct_set( $db_fields, 'oxarticles' );
  $res = act_db_query( "UPDATE `oxarticles` ".$set['set']." WHERE `oxid`='".esc($art_oxid)."'" );
  if( !$res )
  {
    $result->set_ok( FALSE );
    $result->set_errno( EIO );
    $result->set_error( "Fehler beim einfügen der neuen Bilder in die Tabelle 'oxarticles' " );
    return FALSE;
  }


  return TRUE;
}


function _do_import_image( $imagetype, $imageidx, $iPos, $image_type, $tmpfile, $image_name )
{
  global $myConfig;

  if( version_compare($GLOBALS['myConfig']->getVersion(), '4.4.7', '<') )
  {
    $sTarget = $GLOBALS['myConfig']->getAbsDynImageDir() . "/$iPos/$image_name";
  }
  else if( version_compare($GLOBALS['myConfig']->getVersion(), '4.5.0', '<') )
  {
    $sTarget = sprintf( "%s%s%s/%s", $GLOBALS['myConfig']->getAbsDynImageDir(), $imagetype == "master" ? "master/" : "", $iPos, $image_name );
  }
  else
  {
    $sTarget = sprintf( "%smaster/product/%s/%s", $GLOBALS['myConfig']->getPictureDir(), $iPos, $image_name );
  }
  $sSource = $tmpfile;

  @mkdir(dirname($sTarget),0777,true);

  $blCopy = false;
  if( $imagetype == 'icon' )
  {
    // copied from oxutilsfile.php, function processFiles
    if ( $myConfig->getConfigParam( 'sIconsize' )) {
        // convert this file
        $aSize = explode( "*", $myConfig->getConfigParam( 'sIconsize' ));
        $iX = $aSize[0];
        $iY = $aSize[1];
        $blCopy = oxUtilspic::getInstance()->resizeImage( $sSource, $sTarget, $iX, $iY );
    }
  }
  elseif( $imagetype == 'thumb' )
  {
    // copied from oxutilsfile.php, function processFiles
    if ( $myConfig->getConfigParam( 'sThumbnailsize' )) {
        // convert this file
        $aSize = explode( "*", $myConfig->getConfigParam( 'sThumbnailsize' ));
        $iX = $aSize[0];
        $iY = $aSize[1];
        $blCopy = oxUtilspic::getInstance()->resizeImage( $sSource, $sTarget, $iX, $iY );
    }
  }
  elseif( $imagetype == 'pic' )
  {
    $aPType = array( 'P', $iPos );

    // copied from oxutilsfile.php, function processFiles
    $iPic = intval($aPType[1]) - 1;

    // #840A + compatibility with prev. versions
    $aDetailImageSizes = $myConfig->getConfigParam( 'aDetailImageSizes' );
    $sDetailImageSize = $myConfig->getConfigParam( 'sDetailImageSize' );
    if ( isset($aDetailImageSizes["oxpic".intval($aPType[1])])) {
        $sDetailImageSize = $aDetailImageSizes["oxpic".intval($aPType[1])];
    }

    if ( $sDetailImageSize ) {
        // convert this file
        $aSize = explode( "*", $sDetailImageSize);
        $iX = $aSize[0];
        $iY = $aSize[1];
        $blCopy = oxUtilspic::getInstance()->resizeImage( $sSource, $sTarget, $iX, $iY );

        //make an icon
        if( version_compare($GLOBALS['myConfig']->getVersion(), '4.4.7', '<') )
        {
          $sIconName = oxUtilsPic::getInstance()->iconName($sTarget);
          $aSize = explode( "*", $myConfig->getConfigParam( 'sIconsize' ) );
          $iX = $aSize[0];
          $iY = $aSize[1];
          $blCopy = oxUtilspic::getInstance()->resizeImage( $sSource, $sIconName, $iX, $iY );
        }

    }
  }
  elseif( $imagetype == 'zoom' )
  {
    $aPType = array( 'P', $iPos );

    // copied from oxutilsfile.php, function processFiles
    $iPic = intval($aPType[1]) - 1;

    // #840A + compatibility with prev. versions
    $aZoomImageSizes = $myConfig->getConfigParam( 'aZoomImageSizes' );
    $sZoomImageSize  = $myConfig->getConfigParam( 'sZoomImageSize' );
    if ( isset($aZoomImageSizes["oxzoom".intval($aPType[1])])) {
        $sZoomImageSize = $aZoomImageSizes["oxzoom".intval($aPType[1])];
    }

    //
    if ( $sZoomImageSize) {
        // convert this file
        $aSize = explode( "*", $sZoomImageSize);
        $iX = $aSize[0];
        $iY = $aSize[1];
        $blCopy = oxUtilspic::getInstance()->resizeImage( $sSource, $sTarget, $iX, $iY );
    }
  }

  if( !$blCopy )
  {
    if(is_file($sTarget))
      unlink($sTarget);

    copy( $sSource, $sTarget );
    chmod( $sTarget, 0644 );
  }

  return basename( $sTarget );
}


function _do_import_xselling( $art_oxid, &$product, &$result )
{
  $shop_art = $product->shop();

  if(!is_object($shop_art))
    return true;

  $xsellings = array();
  $oxbundleid = '';
  for( $i=0; $i<$shop_art->xselling_size(); $i++ )
  {
    $xs = $shop_art->xselling( $i );
    $xs_art_oxid = act_db_get_single_row( "SELECT `oxid` FROM `oxarticles` WHERE `oxartnum`='".esc($xs->art_nr())."'" );
    if( $xs->group_id() == 3 )
    {
      if( !empty($xs_art_oxid) )
        $oxbundleid = $xs_art_oxid;
    }
    else
    {
      if( !is_string($xs_art_oxid) )    // if the article we would like to add to cross selling has no oxid (which means it does not exist), we still add a key, so the foreach below clears the cross selling for this group id
      {
        is_array($xsellings[$xs->group_id()]) or $xsellings[$xs->group_id()] = array();
      }
      else
        $xsellings[$xs->group_id()][$xs_art_oxid] = array( 'oxid'=>$xs_art_oxid, 'oxsort'=>$xs->sort_order() );
    }
  }

  $res = act_db_query( "UPDATE `oxarticles` SET `oxbundleid`='".esc($oxbundleid)."' WHERE `oxid`='".esc($art_oxid)."'" );

  $res &= act_db_query( "DELETE FROM `oxaccessoire2article` WHERE `oxarticlenid`='".esc($art_oxid)."'" );
  $res &= act_db_query( "DELETE FROM `oxobject2article` WHERE `oxarticlenid`='".esc($art_oxid)."'" );

  foreach( $xsellings as $_id => $_arr )
  {
    if( $_id == 1 )
      $table = 'oxaccessoire2article';
    elseif( $_id == 2 )
      $table = 'oxobject2article';
    else
      continue;

    foreach( $_arr as $_xselling_oxid => $_xselling )
    {
      $set = construct_set( array(
        'oxid' => oxUtilsObject::getInstance()->generateUID(),
        'oxarticlenid' => $art_oxid,
        'oxobjectid' => $_xselling_oxid,
        'oxpos' => $_xselling['oxsort'],
      ), $table );
      $res &= act_db_query( "INSERT INTO `{$table}` ".$set['set'] );
    }
  }

  return TRUE;
}

function _do_import_properties( $art_oxid, &$product, &$result, $langcode_to_id )
{
  $res = TRUE;

  if( $product->properties_size() )
    act_db_query( "DELETE FROM `oxobject2attribute` WHERE oxobjectid='".esc($art_oxid)."'" );

  $attr_res=act_db_query( "SELECT oxid FROM `oxattribute`" );

  $attrs=array();
  while($row=act_db_fetch_assoc($attr_res))
    {
    $attrs[]=$row['oxid'];
    }

  $props = array();
  for( $i=0; $i<$product->properties_size(); $i++ )
  {
    $p = $product->properties( $i );
    
    if(!is_array($props[$p->field_id()]))
        $props[$p->field_id()]=array();
        
    $prop = array();
    if( $p->language_code() == "" )     // all languages same value (actindo special)
    {
      foreach( $langcode_to_id as $language_id )
        $props[$p->field_id()][_actindo_get_lang_field('oxvalue', $language_id)] = $p->field_value();
    }
    else
    {
      $language_id = $langcode_to_id[$p->language_code()];
      $props[$p->field_id()][_actindo_get_lang_field('oxvalue', $language_id)] = $p->field_value();
    }

  }

  foreach( $props as $_propid => $_prop )
  {
    if(!in_array($_propid, $attrs))
      continue;

    $_prop['oxid'] = oxUtilsObject::getInstance()->generateUID();
    $_prop['oxobjectid'] = $art_oxid;
    $_prop['oxattrid'] = $_propid;
    $set = construct_set( $_prop, 'oxobject2attribute' );
    $res &= act_db_query( $q="INSERT INTO `oxobject2attribute` ".$set['set'] );
  }

  return TRUE;
}


function _do_import_content( $art_oxid, &$product, &$result, $langcode_to_id )
{
  $res = TRUE;

  $res = act_db_query( "SELECT `oxid` FROM `oxmediaurls` WHERE oxobjectid='".esc($art_oxid)."'" );
  while( $med = act_db_fetch_assoc($res) )
  {
    $omu = oxNew( 'oxMediaUrl' );
    $omu->load( $med['oxid'] );
    $omu->delete( );

    unset( $omu );
  }
  act_db_free( $res );


  $oxmedia_array = array();
  for( $i=0; $i<$product->content_size(); $i++ )
  {
    $c = $product->content( $i );
    $oxmedia = array();

    if( $c->type() == ArtikelContent_ArtikelContentType::file )
    {
      $path = $GLOBALS['myConfig']->getConfig()->getConfigParam('sShopDir') . "/out/media/";
      $fn = $c->content_file_name();
      if( empty($fn) || strlen($fn) <= 5 )
        $fn = md5( time().rand(1,getrandmax()) );

      $fn = preg_replace( '/([^a-zA-Z0-9_\-\.\(\)])/', '_', $fn );

      $fpath = $path . $fn;
      echo '$fpath=';
      $res = file_put_contents( $fpath, $c->content() );
      echo '$res=';
      if( $res === FALSE )
      {
        $ret = array( 'ok' => FALSE, 'errno' => EIO, 'error' => 'Fehler beim schreiben des Bildes in das Dateisystem (Pfad '.var_dump_string($tmp_name).', written='.var_dump_string($written).', filesize='.var_dump_string(@filesize($tmp_name)).')' );
        unlink( $tmp_name );
        return $ret;
      }
      else if( $res != strlen($c->content()) )
      {
        $ret = array( 'ok' => FALSE, 'errno' => EIO, 'error' => 'Fehler beim schreiben des Bildes in das Dateisystem (Pfad '.var_dump_string($tmp_name).', written='.var_dump_string($written).', filesize='.var_dump_string(@filesize($tmp_name)).')' );
        continue;
      }

      $oxmedia = array(
        'oxid' => oxUtilsObject::getInstance()->generateUID(),
        'oxobjectid' => $art_oxid,
        'oxurl' => rawurlencode($fn),
        'oxisuploaded' => 1
      );
    }
    else if( $c->type() == ArtikelContent_ArtikelContentType::link )
    {
      $oxmedia = array(
        'oxid' => oxUtilsObject::getInstance()->generateUID(),
        'oxobjectid' => $art_oxid,
        'oxurl' => $c->content(),
      );
    }
    else if( $c->type() == ArtikelContent_ArtikelContentType::html )
    {
      // not supported
      continue;
    }
    else
    {
      continue;
    }

    $language_id = $langcode_to_id[$c->language_code()];
    $oxmedia[_actindo_get_lang_field('oxdesc', $language_id)] = $c->content_name();

    $set = construct_set( $oxmedia, $table='oxmediaurls' );
    $res &= act_db_query( "INSERT INTO `{$table}` ".$set['set'] );
  }


  return TRUE;
}


function _do_import_all_categories( $art_oxid, &$product, &$result )
{
  $shop_art = $product->shop();

  $res = act_db_query( "SELECT oxid,oxcatnid FROM `oxobject2category` WHERE `oxobjectid`='".esc($art_oxid)."'" );
  if( !$res )
  {
    $result->set_ok( FALSE );
    $result->set_errno( EIO );
    $result->set_error( "Fehler beim abfragen der alten Kategoriezuordnungen aus der Tabelle 'oxobject2category'" );
    return FALSE;
  }

  $old_cats=array();

  while($row=act_db_fetch_assoc($res))
    {
    $old_cats[$row['oxcatnid']]=$row['oxid'];
  }

  $all_cats = array( $product->categories_id() );
  for( $i=0; $i<$shop_art->all_categories_size(); $i++ )
  {
    $cat = $shop_art->all_categories( $i );
    $cat = $cat->categories_id();
    if( empty($cat) )
      continue;
    $all_cats[] = $cat;
  }
  $all_cats = array_unique( $all_cats );

  $res = TRUE;
  $no_pri_marker = 0;
  foreach( $all_cats as $_i => $cat )
  {
    $primary = $product->categories_id() == $cat ? 0 : $no_pri_marker+=10;

    if(isset($old_cats[$cat]))
      {
      $o2c_oxid = $old_cats[$cat];
      unset($old_cats[$cat]);
      }
    else
    $o2c_oxid = oxUtilsObject::getInstance()->generateUID();


    $set = construct_set( array(
      'oxid' => $o2c_oxid,
      'oxobjectid' => $art_oxid,
      'oxcatnid' => $cat,
      'oxtime' => $primary,
    ), 'oxobject2category' );

    $PostSet=substr($set['set'],3);
    $res = act_db_query($q="INSERT INTO `oxobject2category` ".$set['set'].",`oxpos`=0 ON DUPLICATE KEY UPDATE ".$PostSet);

  if( !$res )
  {
    $result->set_ok( FALSE );
    $result->set_errno( EIO );
    $result->set_error( "Fehler beim Einfügen der Kategoriezuordnungen in die Tabelle 'oxobject2category'" );
    return FALSE;
  }

  }

    $res=act_db_query("DELETE FROM `oxobject2category` WHERE oxid IN ('".implode("','",$old_cats)."')");
    if( !$res )
    {
      $result->set_ok( FALSE );
      $result->set_errno( EIO );
      $result->set_error( "Fehler beim entfernen der alten Kategoriezuordnungen aus der Tabelle 'oxobject2category'" );
      return FALSE;
    }

  return TRUE;
}





function product_update_stock( $request )
{
  $response = new ShopLagerUpdateResponse();

  for( $i=0; $i<$request->arts_size(); $i++ )
  {
    $art = $request->arts( $i );
    $result = $response->add_result();
    $result->set_index( $i );
    $result->set_art_nr( $art->art_nr() );
    $result->set_reference( $art->reference() );

    $oxid = act_db_get_single_row( "SELECT `oxid` FROM `oxarticles` WHERE `oxartnum`='".esc($art->art_nr())."'" );
    if( !is_string($oxid) )
    {
      $result->set_ok( FALSE );
      $result->set_errno( ENOENT );
      $art_nr = $art->art_nr();
      $result->set_error( "Artikel '{$art_nr}' nicht gefunden." );
      continue;
    }

    $res = act_db_query( "UPDATE `oxarticles` SET `oxstock`=".(int)$art->l_bestand()." WHERE `oxid`='".esc($oxid)."'" );
    $ps = $art->products_status() == 1 ? 1 : 0;
    $res &= act_db_query( "UPDATE `oxarticles` SET `oxactive`=".(int)$ps." WHERE `oxid`='".esc($oxid)."'" );
    if( !$res )
    {
      $result->set_ok( FALSE );
      $result->set_errno( EIO );
      $art_nr = $art->art_nr();
      $result->set_error( "Fehler beim Updaten des Artikels '{$art_nr}' nicht gefunden." );
      continue;
    }

    $attributes = $art->attributes();
    if( !is_null($attributes) )
    {
      $errors = array();
      $warnings = array();
      for( $j=0; $j<$attributes->combination_advanced_size(); $j++ )
      {
        $comb_adv = $attributes->combination_advanced( $j );

        $oxid = act_db_get_single_row( "SELECT `oxid` FROM `oxarticles` WHERE `oxartnum`='".esc($comb_adv->art_nr())."'" );
        if( !is_string($oxid) )
        {
          $warnings[] = "Attributs-Artikel '{$art_nr}' nicht gefunden.";
          continue;
        }

        $res = act_db_query( "UPDATE `oxarticles` SET `oxstock`=".(int)$comb_adv->l_bestand()." WHERE `oxid`='".esc($oxid)."'" );

        if(is_object($attribute_product=$comb_adv->shop()) )
          {
          $products_status = (boolean)$attribute_product->products_status();
          }
        else
          $products_status = (int)$art->products_status() == 1 ? 1 : 0;

        if($comb_adv->shop())
          {
          if( is_object($shop_art=$comb_adv->shop()->shop()) )
            {
            $products_status=$shop_art->products_status() ? 1 : 0;
            }
          }

          $res = act_db_query( "UPDATE `oxarticles` SET `oxactive`=".(int)$products_status." WHERE `oxid`='".esc($oxid)."'" );
        if( !$res )
        {
          $errors[] = "Fehler beim Updaten des Artikels '{$art_nr}'.";
        }
      }
      if( count($warnings) )
      {
        $result->set_warning( join("\n", $warnings) );
      }
      if( count($errors) )
      {
        $result->set_ok( FALSE );
        $result->set_errno( EIO );
        $result->set_error( join("\n", $errors) );
        continue;
      }
    }

    $result->set_ok( TRUE );
  }

  return $response;
}



function product_delete( $request )
{
  $response = new ShopProductDeleteResponse();

  for( $i=0; $i<$request->products_size(); $i++ )
  {
    $prod = $request->products( $i );
    $result = $response->add_result();
    $result->set_index( $i );
    $result->set_art_nr( $prod->art_nr() );
    $result->set_reference( $prod->reference() );

    $oxid = act_db_get_single_row( "SELECT `oxid` FROM `oxarticles` WHERE `oxartnum`='".esc($prod->art_nr())."'" );
    if( !is_string($oxid) )
    {
      $result->set_ok( FALSE );
      $result->set_errno( ENOENT );
      $art_nr = $prod->art_nr();
      $result->set_error( "Artikel '{$art_nr}' nicht gefunden." );
      continue;
    }

    $art = new oxArticle();
    $res = $art->delete( $oxid );
    if( !$res )
    {
      $result->set_ok( FALSE );
      $result->set_error( 'Fehler beim löschen des Artikels.' );
    }
    else
    {
      $result->set_ok( TRUE );
    }
  }

  return $response;
}

?>