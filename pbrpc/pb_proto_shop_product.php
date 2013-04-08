<?php
require_once( "pb_proto_shop_product_ArtikelShopData.php" );
require_once( "pb_proto_shop_product_various.php" );
require_once( "pb_proto_shop_product_attributes.php" );
require_once( "pb_proto_search_query.php" );
class AttributeShopProduct extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "art_nr";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "art_name";
    $this->values["2"] = "";
    $this->fields["3"] = "PBDouble";
    $this->fieldnames["3"] = "grundpreis";
    $this->values["3"] = "";
    $this->fields["4"] = "PBBool";
    $this->fieldnames["4"] = "is_brutto";
    $this->values["4"] = "";
    $this->values["4"] = new PBBool();
    $this->values["4"]->value = true;
    $this->fields["5"] = "PBString";
    $this->fieldnames["5"] = "categories_id";
    $this->values["5"] = "";
    $this->fields["6"] = "PBInt";
    $this->fieldnames["6"] = "products_status";
    $this->values["6"] = "";
    $this->fields["7"] = "PBInt";
    $this->fieldnames["7"] = "created";
    $this->values["7"] = "";
    $this->fields["8"] = "PBInt";
    $this->fieldnames["8"] = "last_modified";
    $this->values["8"] = "";
    $this->fields["9"] = "PBString";
    $this->fieldnames["9"] = "products_id";
    $this->values["9"] = "";
    $this->fields["10"] = "PBFloat";
    $this->fieldnames["10"] = "mwst";
    $this->values["10"] = "";
    $this->fields["11"] = "PBInt";
    $this->fieldnames["11"] = "mwst_stkey";
    $this->values["11"] = "";
    $this->fields["12"] = "PBDouble";
    $this->fieldnames["12"] = "l_bestand";
    $this->values["12"] = "";
    $this->fields["13"] = "PBDouble";
    $this->fieldnames["13"] = "products_weight";
    $this->values["13"] = "";
    $this->fields["14"] = "ArtikelWeightUnit";
    $this->fieldnames["14"] = "weight_unit";
    $this->values["14"] = "";
    $this->fields["16"] = "ArtikelDescription";
    $this->fieldnames["16"] = "description";
    $this->values["16"] = array();
    $this->fields["17"] = "ArtikelPriceBracket";
    $this->fieldnames["17"] = "preisgruppen";
    $this->values["17"] = array();
    $this->fields["21"] = "ArtikelImage";
    $this->fieldnames["21"] = "images";
    $this->values["21"] = array();
    $this->fields["22"] = "PBString";
    $this->fieldnames["22"] = "products_ean";
    $this->values["22"] = "";
    $this->fields["23"] = "ArtikelShopData";
    $this->fieldnames["23"] = "shop";
    $this->values["23"] = "";
    $this->fields["24"] = "ArtikelProperty";
    $this->fieldnames["24"] = "properties";
    $this->values["24"] = array();
    $this->fields["25"] = "ArtikelContent";
    $this->fieldnames["25"] = "content";
    $this->values["25"] = array();
    $this->fields["26"] = "PBString";
    $this->fieldnames["26"] = "reference";
    $this->values["26"] = "";
    $this->fields["27"] = "PBBool";
    $this->fieldnames["27"] = "products_is_standard";
    $this->values["27"] = "";
    $this->fields["28"] = "PBDouble";
    $this->fieldnames["28"] = "ek";
    $this->values["28"] = "";
  }
  function art_nr()
  {
    return $this->_get_value("1");
  }
  function set_art_nr($value)
  {
    return $this->_set_value("1", $value);
  }
  function art_name()
  {
    return $this->_get_value("2");
  }
  function set_art_name($value)
  {
    return $this->_set_value("2", $value);
  }
  function grundpreis()
  {
    return $this->_get_value("3");
  }
  function set_grundpreis($value)
  {
    return $this->_set_value("3", $value);
  }
  function is_brutto()
  {
    return $this->_get_value("4");
  }
  function set_is_brutto($value)
  {
    return $this->_set_value("4", $value);
  }
  function categories_id()
  {
    return $this->_get_value("5");
  }
  function set_categories_id($value)
  {
    return $this->_set_value("5", $value);
  }
  function products_status()
  {
    return $this->_get_value("6");
  }
  function set_products_status($value)
  {
    return $this->_set_value("6", $value);
  }
  function created()
  {
    return $this->_get_value("7");
  }
  function set_created($value)
  {
    return $this->_set_value("7", $value);
  }
  function last_modified()
  {
    return $this->_get_value("8");
  }
  function set_last_modified($value)
  {
    return $this->_set_value("8", $value);
  }
  function products_id()
  {
    return $this->_get_value("9");
  }
  function set_products_id($value)
  {
    return $this->_set_value("9", $value);
  }
  function mwst()
  {
    return $this->_get_value("10");
  }
  function set_mwst($value)
  {
    return $this->_set_value("10", $value);
  }
  function mwst_stkey()
  {
    return $this->_get_value("11");
  }
  function set_mwst_stkey($value)
  {
    return $this->_set_value("11", $value);
  }
  function l_bestand()
  {
    return $this->_get_value("12");
  }
  function set_l_bestand($value)
  {
    return $this->_set_value("12", $value);
  }
  function weight()
  {
    return $this->_get_value("13");
  }
  function set_weight($value)
  {
    return $this->_set_value("13", $value);
  }
  function products_weight()
  {
    return $this->_get_value("13");
  }
  function set_products_weight($value)
  {
    return $this->_set_value("13", $value);
  }
  function weight_unit()
  {
    return $this->_get_value("14");
  }
  function set_weight_unit($value)
  {
    return $this->_set_value("14", $value);
  }
  function description($offset)
  {
    return $this->_get_arr_value("16", $offset);
  }
  function add_description()
  {
    return $this->_add_arr_value("16");
  }
  function set_description($index, $value)
  {
    $this->_set_arr_value("16", $index, $value);
  }
  function remove_last_description()
  {
    $this->_remove_last_arr_value("16");
  }
  function description_size()
  {
    return $this->_get_arr_size("16");
  }
  function preisgruppen($offset)
  {
    return $this->_get_arr_value("17", $offset);
  }
  function add_preisgruppen()
  {
    return $this->_add_arr_value("17");
  }
  function set_preisgruppen($index, $value)
  {
    $this->_set_arr_value("17", $index, $value);
  }
  function remove_last_preisgruppen()
  {
    $this->_remove_last_arr_value("17");
  }
  function preisgruppen_size()
  {
    return $this->_get_arr_size("17");
  }
  function images($offset)
  {
    return $this->_get_arr_value("21", $offset);
  }
  function add_images()
  {
    return $this->_add_arr_value("21");
  }
  function set_images($index, $value)
  {
    $this->_set_arr_value("21", $index, $value);
  }
  function remove_last_images()
  {
    $this->_remove_last_arr_value("21");
  }
  function images_size()
  {
    return $this->_get_arr_size("21");
  }
  function products_ean()
  {
    return $this->_get_value("22");
  }
  function set_products_ean($value)
  {
    return $this->_set_value("22", $value);
  }
  function shop()
  {
    return $this->_get_value("23");
  }
  function set_shop($value)
  {
    return $this->_set_value("23", $value);
  }
  function properties($offset)
  {
    return $this->_get_arr_value("24", $offset);
  }
  function add_properties()
  {
    return $this->_add_arr_value("24");
  }
  function set_properties($index, $value)
  {
    $this->_set_arr_value("24", $index, $value);
  }
  function remove_last_properties()
  {
    $this->_remove_last_arr_value("24");
  }
  function properties_size()
  {
    return $this->_get_arr_size("24");
  }
  function content($offset)
  {
    return $this->_get_arr_value("25", $offset);
  }
  function add_content()
  {
    return $this->_add_arr_value("25");
  }
  function set_content($index, $value)
  {
    $this->_set_arr_value("25", $index, $value);
  }
  function remove_last_content()
  {
    $this->_remove_last_arr_value("25");
  }
  function content_size()
  {
    return $this->_get_arr_size("25");
  }
  function reference()
  {
    return $this->_get_value("26");
  }
  function set_reference($value)
  {
    return $this->_set_value("26", $value);
  }
  function products_is_standard()
  {
    return $this->_get_value("27");
  }
  function set_products_is_standard($value)
  {
    return $this->_set_value("27", $value);
  }
  function ek()
  {
    return $this->_get_value("28");
  }
  function set_ek($value)
  {
    return $this->_set_value("28", $value);
  }
}
class ArtikelAttributesCombinationAdvanced_Combination extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "value_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "name_id";
    $this->values["2"] = "";
  }
  function value_id()
  {
    return $this->_get_value("1");
  }
  function set_value_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function name_id()
  {
    return $this->_get_value("2");
  }
  function set_name_id($value)
  {
    return $this->_set_value("2", $value);
  }
}
class ArtikelAttributesCombinationAdvanced_CombinationAdvancedData extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBBool";
    $this->fieldnames["1"] = "products_status";
    $this->values["1"] = "";
    $this->fields["2"] = "PBBool";
    $this->fieldnames["2"] = "products_is_standard";
    $this->values["2"] = "";
  }
  function products_status()
  {
    return $this->_get_value("1");
  }
  function set_products_status($value)
  {
    return $this->_set_value("1", $value);
  }
  function products_is_standard()
  {
    return $this->_get_value("2");
  }
  function set_products_is_standard($value)
  {
    return $this->_set_value("2", $value);
  }
}
class ArtikelAttributesCombinationAdvanced extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "art_nr";
    $this->values["1"] = "";
    $this->fields["2"] = "ArtikelAttributesCombinationAdvanced_Combination";
    $this->fieldnames["2"] = "combination";
    $this->values["2"] = array();
    $this->fields["3"] = "PBDouble";
    $this->fieldnames["3"] = "l_bestand";
    $this->values["3"] = "";
    $this->fields["4"] = "ArtikelPriceBracket";
    $this->fieldnames["4"] = "preisgruppen";
    $this->values["4"] = array();
    $this->fields["5"] = "ArtikelAttributesCombinationAdvanced_CombinationAdvancedData";
    $this->fieldnames["5"] = "data";
    $this->values["5"] = "";
    $this->fields["6"] = "AttributeShopProduct";
    $this->fieldnames["6"] = "shop";
    $this->values["6"] = "";
    $this->fields["7"] = "PBDouble";
    $this->fieldnames["7"] = "grundpreis";
    $this->values["7"] = "";
    $this->fields["8"] = "PBBool";
    $this->fieldnames["8"] = "is_brutto";
    $this->values["8"] = "";
  }
  function art_nr()
  {
    return $this->_get_value("1");
  }
  function set_art_nr($value)
  {
    return $this->_set_value("1", $value);
  }
  function combination($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_combination()
  {
    return $this->_add_arr_value("2");
  }
  function set_combination($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_combination()
  {
    $this->_remove_last_arr_value("2");
  }
  function combination_size()
  {
    return $this->_get_arr_size("2");
  }
  function l_bestand()
  {
    return $this->_get_value("3");
  }
  function set_l_bestand($value)
  {
    return $this->_set_value("3", $value);
  }
  function preisgruppen($offset)
  {
    return $this->_get_arr_value("4", $offset);
  }
  function add_preisgruppen()
  {
    return $this->_add_arr_value("4");
  }
  function set_preisgruppen($index, $value)
  {
    $this->_set_arr_value("4", $index, $value);
  }
  function remove_last_preisgruppen()
  {
    $this->_remove_last_arr_value("4");
  }
  function preisgruppen_size()
  {
    return $this->_get_arr_size("4");
  }
  function data()
  {
    return $this->_get_value("5");
  }
  function set_data($value)
  {
    return $this->_set_value("5", $value);
  }
  function shop()
  {
    return $this->_get_value("6");
  }
  function set_shop($value)
  {
    return $this->_set_value("6", $value);
  }
  function grundpreis()
  {
    return $this->_get_value("7");
  }
  function set_grundpreis($value)
  {
    return $this->_set_value("7", $value);
  }
  function is_brutto()
  {
    return $this->_get_value("8");
  }
  function set_is_brutto($value)
  {
    return $this->_set_value("8", $value);
  }
}
class ArtikelAttributes extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "ArtikelAttributesName";
    $this->fieldnames["1"] = "names";
    $this->values["1"] = array();
    $this->fields["2"] = "ArtikelAttributesValues";
    $this->fieldnames["2"] = "values";
    $this->values["2"] = array();
    $this->fields["3"] = "ArtikelAttributesCombinationSimple";
    $this->fieldnames["3"] = "combination_simple";
    $this->values["3"] = array();
    $this->fields["4"] = "ArtikelAttributesCombinationAdvanced";
    $this->fieldnames["4"] = "combination_advanced";
    $this->values["4"] = array();
    $this->fields["5"] = "PBBool";
    $this->fieldnames["5"] = "other_combinations_dont_exist";
    $this->values["5"] = "";
  }
  function names($offset)
  {
    return $this->_get_arr_value("1", $offset);
  }
  function add_names()
  {
    return $this->_add_arr_value("1");
  }
  function set_names($index, $value)
  {
    $this->_set_arr_value("1", $index, $value);
  }
  function remove_last_names()
  {
    $this->_remove_last_arr_value("1");
  }
  function names_size()
  {
    return $this->_get_arr_size("1");
  }
  function values($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_values()
  {
    return $this->_add_arr_value("2");
  }
  function set_values($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_values()
  {
    $this->_remove_last_arr_value("2");
  }
  function values_size()
  {
    return $this->_get_arr_size("2");
  }
  function combination_simple($offset)
  {
    return $this->_get_arr_value("3", $offset);
  }
  function add_combination_simple()
  {
    return $this->_add_arr_value("3");
  }
  function set_combination_simple($index, $value)
  {
    $this->_set_arr_value("3", $index, $value);
  }
  function remove_last_combination_simple()
  {
    $this->_remove_last_arr_value("3");
  }
  function combination_simple_size()
  {
    return $this->_get_arr_size("3");
  }
  function combination_advanced($offset)
  {
    return $this->_get_arr_value("4", $offset);
  }
  function add_combination_advanced()
  {
    return $this->_add_arr_value("4");
  }
  function set_combination_advanced($index, $value)
  {
    $this->_set_arr_value("4", $index, $value);
  }
  function remove_last_combination_advanced()
  {
    $this->_remove_last_arr_value("4");
  }
  function combination_advanced_size()
  {
    return $this->_get_arr_size("4");
  }
  function other_combinations_dont_exist()
  {
    return $this->_get_value("5");
  }
  function set_other_combinations_dont_exist($value)
  {
    return $this->_set_value("5", $value);
  }
}
class ShopProduct extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "art_nr";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "art_name";
    $this->values["2"] = "";
    $this->fields["3"] = "PBDouble";
    $this->fieldnames["3"] = "grundpreis";
    $this->values["3"] = "";
    $this->fields["4"] = "PBBool";
    $this->fieldnames["4"] = "is_brutto";
    $this->values["4"] = "";
    $this->values["4"] = new PBBool();
    $this->values["4"]->value = true;
    $this->fields["5"] = "PBString";
    $this->fieldnames["5"] = "categories_id";
    $this->values["5"] = "";
    $this->fields["6"] = "PBInt";
    $this->fieldnames["6"] = "products_status";
    $this->values["6"] = "";
    $this->fields["7"] = "PBInt";
    $this->fieldnames["7"] = "created";
    $this->values["7"] = "";
    $this->fields["8"] = "PBInt";
    $this->fieldnames["8"] = "last_modified";
    $this->values["8"] = "";
    $this->fields["9"] = "PBString";
    $this->fieldnames["9"] = "products_id";
    $this->values["9"] = "";
    $this->fields["10"] = "PBFloat";
    $this->fieldnames["10"] = "mwst";
    $this->values["10"] = "";
    $this->fields["11"] = "PBInt";
    $this->fieldnames["11"] = "mwst_stkey";
    $this->values["11"] = "";
    $this->fields["12"] = "PBDouble";
    $this->fieldnames["12"] = "l_bestand";
    $this->values["12"] = "";
    $this->fields["13"] = "PBDouble";
    $this->fieldnames["13"] = "weight";
    $this->values["13"] = "";
    $this->fields["14"] = "ArtikelWeightUnit";
    $this->fieldnames["14"] = "weight_unit";
    $this->values["14"] = "";
    $this->fields["28"] = "PBDouble";
    $this->fieldnames["28"] = "ek";
    $this->values["28"] = "";
    $this->fields["16"] = "ArtikelDescription";
    $this->fieldnames["16"] = "description";
    $this->values["16"] = array();
    $this->fields["17"] = "ArtikelPriceBracket";
    $this->fieldnames["17"] = "preisgruppen";
    $this->values["17"] = array();
    $this->fields["18"] = "ArtikelAttributes";
    $this->fieldnames["18"] = "attributes";
    $this->values["18"] = "";
    $this->fields["21"] = "ArtikelImage";
    $this->fieldnames["21"] = "images";
    $this->values["21"] = array();
    $this->fields["22"] = "PBString";
    $this->fieldnames["22"] = "products_ean";
    $this->values["22"] = "";
    $this->fields["23"] = "ArtikelShopData";
    $this->fieldnames["23"] = "shop";
    $this->values["23"] = "";
    $this->fields["24"] = "ArtikelProperty";
    $this->fieldnames["24"] = "properties";
    $this->values["24"] = array();
    $this->fields["25"] = "ArtikelContent";
    $this->fieldnames["25"] = "content";
    $this->values["25"] = array();
    $this->fields["26"] = "PBString";
    $this->fieldnames["26"] = "reference";
    $this->values["26"] = "";
    $this->fields["27"] = "PBBool";
    $this->fieldnames["27"] = "products_is_standard";
    $this->values["27"] = "";
    $this->fields["29"] = "PBString";
    $this->fieldnames["29"] = "products_mpn";
    $this->values["29"] = "";
    $this->fields["30"] = "MultiStorePermission";
    $this->fieldnames["30"] = "multistore_permission";
    $this->values["30"] = array();
  }
  function art_nr()
  {
    return $this->_get_value("1");
  }
  function set_art_nr($value)
  {
    return $this->_set_value("1", $value);
  }
  function art_name()
  {
    return $this->_get_value("2");
  }
  function set_art_name($value)
  {
    return $this->_set_value("2", $value);
  }
  function grundpreis()
  {
    return $this->_get_value("3");
  }
  function set_grundpreis($value)
  {
    return $this->_set_value("3", $value);
  }
  function is_brutto()
  {
    return $this->_get_value("4");
  }
  function set_is_brutto($value)
  {
    return $this->_set_value("4", $value);
  }
  function categories_id()
  {
    return $this->_get_value("5");
  }
  function set_categories_id($value)
  {
    return $this->_set_value("5", $value);
  }
  function products_status()
  {
    return $this->_get_value("6");
  }
  function set_products_status($value)
  {
    return $this->_set_value("6", $value);
  }
  function created()
  {
    return $this->_get_value("7");
  }
  function set_created($value)
  {
    return $this->_set_value("7", $value);
  }
  function last_modified()
  {
    return $this->_get_value("8");
  }
  function set_last_modified($value)
  {
    return $this->_set_value("8", $value);
  }
  function products_id()
  {
    return $this->_get_value("9");
  }
  function set_products_id($value)
  {
    return $this->_set_value("9", $value);
  }
  function mwst()
  {
    return $this->_get_value("10");
  }
  function set_mwst($value)
  {
    return $this->_set_value("10", $value);
  }
  function mwst_stkey()
  {
    return $this->_get_value("11");
  }
  function set_mwst_stkey($value)
  {
    return $this->_set_value("11", $value);
  }
  function l_bestand()
  {
    return $this->_get_value("12");
  }
  function set_l_bestand($value)
  {
    return $this->_set_value("12", $value);
  }
  function weight()
  {
    return $this->_get_value("13");
  }
  function set_weight($value)
  {
    return $this->_set_value("13", $value);
  }
  function weight_unit()
  {
    return $this->_get_value("14");
  }
  function set_weight_unit($value)
  {
    return $this->_set_value("14", $value);
  }
  function ek()
  {
    return $this->_get_value("28");
  }
  function set_ek($value)
  {
    return $this->_set_value("28", $value);
  }
  function description($offset)
  {
    return $this->_get_arr_value("16", $offset);
  }
  function add_description()
  {
    return $this->_add_arr_value("16");
  }
  function set_description($index, $value)
  {
    $this->_set_arr_value("16", $index, $value);
  }
  function remove_last_description()
  {
    $this->_remove_last_arr_value("16");
  }
  function description_size()
  {
    return $this->_get_arr_size("16");
  }
  function preisgruppen($offset)
  {
    return $this->_get_arr_value("17", $offset);
  }
  function add_preisgruppen()
  {
    return $this->_add_arr_value("17");
  }
  function set_preisgruppen($index, $value)
  {
    $this->_set_arr_value("17", $index, $value);
  }
  function remove_last_preisgruppen()
  {
    $this->_remove_last_arr_value("17");
  }
  function preisgruppen_size()
  {
    return $this->_get_arr_size("17");
  }
  function attributes()
  {
    return $this->_get_value("18");
  }
  function set_attributes($value)
  {
    return $this->_set_value("18", $value);
  }
  function images($offset)
  {
    return $this->_get_arr_value("21", $offset);
  }
  function add_images()
  {
    return $this->_add_arr_value("21");
  }
  function set_images($index, $value)
  {
    $this->_set_arr_value("21", $index, $value);
  }
  function remove_last_images()
  {
    $this->_remove_last_arr_value("21");
  }
  function images_size()
  {
    return $this->_get_arr_size("21");
  }
  function products_ean()
  {
    return $this->_get_value("22");
  }
  function set_products_ean($value)
  {
    return $this->_set_value("22", $value);
  }
  function shop()
  {
    return $this->_get_value("23");
  }
  function set_shop($value)
  {
    return $this->_set_value("23", $value);
  }
  function properties($offset)
  {
    return $this->_get_arr_value("24", $offset);
  }
  function add_properties()
  {
    return $this->_add_arr_value("24");
  }
  function set_properties($index, $value)
  {
    $this->_set_arr_value("24", $index, $value);
  }
  function remove_last_properties()
  {
    $this->_remove_last_arr_value("24");
  }
  function properties_size()
  {
    return $this->_get_arr_size("24");
  }
  function content($offset)
  {
    return $this->_get_arr_value("25", $offset);
  }
  function add_content()
  {
    return $this->_add_arr_value("25");
  }
  function set_content($index, $value)
  {
    $this->_set_arr_value("25", $index, $value);
  }
  function remove_last_content()
  {
    $this->_remove_last_arr_value("25");
  }
  function content_size()
  {
    return $this->_get_arr_size("25");
  }
  function reference()
  {
    return $this->_get_value("26");
  }
  function set_reference($value)
  {
    return $this->_set_value("26", $value);
  }
  function products_is_standard()
  {
    return $this->_get_value("27");
  }
  function set_products_is_standard($value)
  {
    return $this->_set_value("27", $value);
  }
  function products_mpn()
  {
    return $this->_get_value("29");
  }
  function set_products_mpn($value)
  {
    return $this->_set_value("29", $value);
  }
  function multistore_permission($offset)
  {
    return $this->_get_arr_value("30", $offset);
  }
  function add_multistore_permission()
  {
    return $this->_add_arr_value("30");
  }
  function set_multistore_permission($index, $value)
  {
    $this->_set_arr_value("30", $index, $value);
  }
  function remove_last_multistore_permission()
  {
    $this->_remove_last_arr_value("30");
  }
  function multistore_permission_size()
  {
    return $this->_get_arr_size("30");
  }

}


class MultiStorePermission extends PBMessage
{
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "included";
  }

  function included()
  {
    return $this->_get_value("1");
  }
  function set_included($value)
  {
    return $this->_set_value("1", $value);
  }

}

class ShopListProduct extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "products_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBDouble";
    $this->fieldnames["2"] = "grundpreis";
    $this->values["2"] = "";
    $this->fields["3"] = "PBBool";
    $this->fieldnames["3"] = "is_brutto";
    $this->values["3"] = "";
    $this->values["3"] = new PBBool();
    $this->values["3"]->value = true;
    $this->fields["4"] = "PBInt";
    $this->fieldnames["4"] = "categories_id";
    $this->values["4"] = "";
    $this->fields["5"] = "PBInt";
    $this->fieldnames["5"] = "products_status";
    $this->values["5"] = "";
    $this->fields["6"] = "PBInt";
    $this->fieldnames["6"] = "created";
    $this->values["6"] = "";
    $this->fields["7"] = "PBInt";
    $this->fieldnames["7"] = "last_modified";
    $this->values["7"] = "";
    $this->fields["8"] = "PBString";
    $this->fieldnames["8"] = "art_nr";
    $this->values["8"] = "";
    $this->fields["9"] = "PBString";
    $this->fieldnames["9"] = "art_name";
    $this->values["9"] = "";
  }
  function products_id()
  {
    return $this->_get_value("1");
  }
  function set_products_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function grundpreis()
  {
    return $this->_get_value("2");
  }
  function set_grundpreis($value)
  {
    return $this->_set_value("2", $value);
  }
  function is_brutto()
  {
    return $this->_get_value("3");
  }
  function set_is_brutto($value)
  {
    return $this->_set_value("3", $value);
  }
  function categories_id()
  {
    return $this->_get_value("4");
  }
  function set_categories_id($value)
  {
    return $this->_set_value("4", $value);
  }
  function products_status()
  {
    return $this->_get_value("5");
  }
  function set_products_status($value)
  {
    return $this->_set_value("5", $value);
  }
  function created()
  {
    return $this->_get_value("6");
  }
  function set_created($value)
  {
    return $this->_set_value("6", $value);
  }
  function last_modified()
  {
    return $this->_get_value("7");
  }
  function set_last_modified($value)
  {
    return $this->_set_value("7", $value);
  }
  function art_nr()
  {
    return $this->_get_value("8");
  }
  function set_art_nr($value)
  {
    return $this->_set_value("8", $value);
  }
  function art_name()
  {
    return $this->_get_value("9");
  }
  function set_art_name($value)
  {
    return $this->_set_value("9", $value);
  }
}
class ShopLagerUpdateProduct extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "art_nr";
    $this->values["1"] = "";
    $this->fields["2"] = "PBDouble";
    $this->fieldnames["2"] = "l_bestand";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "shipping_status";
    $this->values["3"] = "";
    $this->fields["4"] = "PBString";
    $this->fieldnames["4"] = "shipping_status_text";
    $this->values["4"] = "";
    $this->fields["5"] = "PBInt";
    $this->fieldnames["5"] = "products_status";
    $this->values["5"] = "";
    $this->fields["6"] = "ArtikelAttributes";
    $this->fieldnames["6"] = "attributes";
    $this->values["6"] = "";
    $this->fields["7"] = "PBString";
    $this->fieldnames["7"] = "reference";
    $this->values["7"] = "";
  }
  function art_nr()
  {
    return $this->_get_value("1");
  }
  function set_art_nr($value)
  {
    return $this->_set_value("1", $value);
  }
  function l_bestand()
  {
    return $this->_get_value("2");
  }
  function set_l_bestand($value)
  {
    return $this->_set_value("2", $value);
  }
  function shipping_status()
  {
    return $this->_get_value("3");
  }
  function set_shipping_status($value)
  {
    return $this->_set_value("3", $value);
  }
  function shipping_status_text()
  {
    return $this->_get_value("4");
  }
  function set_shipping_status_text($value)
  {
    return $this->_set_value("4", $value);
  }
  function products_status()
  {
    return $this->_get_value("5");
  }
  function set_products_status($value)
  {
    return $this->_set_value("5", $value);
  }
  function attributes()
  {
    return $this->_get_value("6");
  }
  function set_attributes($value)
  {
    return $this->_set_value("6", $value);
  }
  function reference()
  {
    return $this->_get_value("7");
  }
  function set_reference($value)
  {
    return $this->_set_value("7", $value);
  }
}
class ShopProductListRequest extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "tmp";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "art_nr";
    $this->values["2"] = "";
    $this->fields["3"] = "SearchQuery";
    $this->fieldnames["3"] = "search_request";
    $this->values["3"] = "";
  }
  function tmp()
  {
    return $this->_get_value("1");
  }
  function set_tmp($value)
  {
    return $this->_set_value("1", $value);
  }
  function art_nr()
  {
    return $this->_get_value("2");
  }
  function set_art_nr($value)
  {
    return $this->_set_value("2", $value);
  }
  function search_request()
  {
    return $this->_get_value("3");
  }
  function set_search_request($value)
  {
    return $this->_set_value("3", $value);
  }
}
class ShopProductListResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "count";
    $this->values["1"] = "";
    $this->fields["2"] = "ShopListProduct";
    $this->fieldnames["2"] = "products";
    $this->values["2"] = array();
  }
  function count()
  {
    return $this->_get_value("1");
  }
  function set_count($value)
  {
    return $this->_set_value("1", $value);
  }
  function products($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_products()
  {
    return $this->_add_arr_value("2");
  }
  function set_products($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_products()
  {
    $this->_remove_last_arr_value("2");
  }
  function products_size()
  {
    return $this->_get_arr_size("2");
  }
}
class ShopProductGetRequest extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "tmp";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "art_nr";
    $this->values["2"] = "";
    $this->fields["3"] = "SearchQuery";
    $this->fieldnames["3"] = "search_request";
    $this->values["3"] = "";
  }
  function tmp()
  {
    return $this->_get_value("1");
  }
  function set_tmp($value)
  {
    return $this->_set_value("1", $value);
  }
  function art_nr()
  {
    return $this->_get_value("2");
  }
  function set_art_nr($value)
  {
    return $this->_set_value("2", $value);
  }
  function search_request()
  {
    return $this->_get_value("3");
  }
  function set_search_request($value)
  {
    return $this->_set_value("3", $value);
  }
}
class ShopProductGetResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "count";
    $this->values["1"] = "";
    $this->fields["2"] = "ShopProduct";
    $this->fieldnames["2"] = "products";
    $this->values["2"] = array();
  }
  function count()
  {
    return $this->_get_value("1");
  }
  function set_count($value)
  {
    return $this->_set_value("1", $value);
  }
  function products($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_products()
  {
    return $this->_add_arr_value("2");
  }
  function set_products($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_products()
  {
    $this->_remove_last_arr_value("2");
  }
  function products_size()
  {
    return $this->_get_arr_size("2");
  }
}
class ShopProductCreateUpdateRequest extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "tmp";
    $this->values["1"] = "";
    $this->fields["2"] = "ShopProduct";
    $this->fieldnames["2"] = "products";
    $this->values["2"] = array();
  }
  function tmp()
  {
    return $this->_get_value("1");
  }
  function set_tmp($value)
  {
    return $this->_set_value("1", $value);
  }
  function products($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_products()
  {
    return $this->_add_arr_value("2");
  }
  function set_products($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_products()
  {
    $this->_remove_last_arr_value("2");
  }
  function products_size()
  {
    return $this->_get_arr_size("2");
  }
}
class ProductResult extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "index";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "art_nr";
    $this->values["2"] = "";
    $this->fields["3"] = "PBBool";
    $this->fieldnames["3"] = "ok";
    $this->values["3"] = "";
    $this->fields["4"] = "PBInt";
    $this->fieldnames["4"] = "errno";
    $this->values["4"] = "";
    $this->fields["5"] = "PBString";
    $this->fieldnames["5"] = "error";
    $this->values["5"] = "";
    $this->fields["6"] = "PBString";
    $this->fieldnames["6"] = "warning";
    $this->values["6"] = "";
    $this->fields["7"] = "PBString";
    $this->fieldnames["7"] = "reference";
    $this->values["7"] = "";
  }
  function index()
  {
    return $this->_get_value("1");
  }
  function set_index($value)
  {
    return $this->_set_value("1", $value);
  }
  function art_nr()
  {
    return $this->_get_value("2");
  }
  function set_art_nr($value)
  {
    return $this->_set_value("2", $value);
  }
  function ok()
  {
    return $this->_get_value("3");
  }
  function set_ok($value)
  {
    return $this->_set_value("3", $value);
  }
  function errno()
  {
    return $this->_get_value("4");
  }
  function set_errno($value)
  {
    return $this->_set_value("4", $value);
  }
  function error()
  {
    return $this->_get_value("5");
  }
  function set_error($value)
  {
    return $this->_set_value("5", $value);
  }
  function warning()
  {
    return $this->_get_value("6");
  }
  function set_warning($value)
  {
    return $this->_set_value("6", $value);
  }
  function reference()
  {
    return $this->_get_value("7");
  }
  function set_reference($value)
  {
    return $this->_set_value("7", $value);
  }
}
class ShopProductCreateUpdateResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "count";
    $this->values["1"] = "";
    $this->fields["2"] = "ProductResult";
    $this->fieldnames["2"] = "result";
    $this->values["2"] = array();
  }
  function count()
  {
    return $this->_get_value("1");
  }
  function set_count($value)
  {
    return $this->_set_value("1", $value);
  }
  function result($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_result()
  {
    return $this->_add_arr_value("2");
  }
  function set_result($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_result()
  {
    $this->_remove_last_arr_value("2");
  }
  function result_size()
  {
    return $this->_get_arr_size("2");
  }
}
class ShopProductDeleteRequest_DeleteProduct extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "art_nr";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "reference";
    $this->values["2"] = "";
  }
  function art_nr()
  {
    return $this->_get_value("1");
  }
  function set_art_nr($value)
  {
    return $this->_set_value("1", $value);
  }
  function reference()
  {
    return $this->_get_value("2");
  }
  function set_reference($value)
  {
    return $this->_set_value("2", $value);
  }
}
class ShopProductDeleteRequest extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "tmp";
    $this->values["1"] = "";
    $this->fields["2"] = "ShopProductDeleteRequest_DeleteProduct";
    $this->fieldnames["2"] = "products";
    $this->values["2"] = array();
  }
  function tmp()
  {
    return $this->_get_value("1");
  }
  function set_tmp($value)
  {
    return $this->_set_value("1", $value);
  }
  function products($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_products()
  {
    return $this->_add_arr_value("2");
  }
  function set_products($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_products()
  {
    $this->_remove_last_arr_value("2");
  }
  function products_size()
  {
    return $this->_get_arr_size("2");
  }
}
class ShopProductDeleteResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "count";
    $this->values["1"] = "";
    $this->fields["2"] = "ProductResult";
    $this->fieldnames["2"] = "result";
    $this->values["2"] = array();
  }
  function count()
  {
    return $this->_get_value("1");
  }
  function set_count($value)
  {
    return $this->_set_value("1", $value);
  }
  function result($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_result()
  {
    return $this->_add_arr_value("2");
  }
  function set_result($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_result()
  {
    $this->_remove_last_arr_value("2");
  }
  function result_size()
  {
    return $this->_get_arr_size("2");
  }
}
class ShopProductCountResponse_ProductCountByCategory extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "category_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBInt";
    $this->fieldnames["2"] = "product_count";
    $this->values["2"] = "";
  }
  function category_id()
  {
    return $this->_get_value("1");
  }
  function set_category_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function product_count()
  {
    return $this->_get_value("2");
  }
  function set_product_count($value)
  {
    return $this->_set_value("2", $value);
  }
}
class ShopProductCountResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "product_count";
    $this->values["1"] = "";
    $this->fields["2"] = "ShopProductCountResponse_ProductCountByCategory";
    $this->fieldnames["2"] = "count_by_category";
    $this->values["2"] = array();
  }
  function product_count()
  {
    return $this->_get_value("1");
  }
  function set_product_count($value)
  {
    return $this->_set_value("1", $value);
  }
  function count_by_category($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_count_by_category()
  {
    return $this->_add_arr_value("2");
  }
  function set_count_by_category($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_count_by_category()
  {
    $this->_remove_last_arr_value("2");
  }
  function count_by_category_size()
  {
    return $this->_get_arr_size("2");
  }
}
class ShopLagerUpdateRequest extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "tmp";
    $this->values["1"] = "";
    $this->fields["2"] = "ShopLagerUpdateProduct";
    $this->fieldnames["2"] = "arts";
    $this->values["2"] = array();
  }
  function tmp()
  {
    return $this->_get_value("1");
  }
  function set_tmp($value)
  {
    return $this->_set_value("1", $value);
  }
  function arts($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_arts()
  {
    return $this->_add_arr_value("2");
  }
  function set_arts($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_arts()
  {
    $this->_remove_last_arr_value("2");
  }
  function arts_size()
  {
    return $this->_get_arr_size("2");
  }
}
class ShopLagerUpdateResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "count";
    $this->values["1"] = "";
    $this->fields["2"] = "ProductResult";
    $this->fieldnames["2"] = "result";
    $this->values["2"] = array();
  }
  function count()
  {
    return $this->_get_value("1");
  }
  function set_count($value)
  {
    return $this->_set_value("1", $value);
  }
  function result($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_result()
  {
    return $this->_add_arr_value("2");
  }
  function set_result($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_result()
  {
    $this->_remove_last_arr_value("2");
  }
  function result_size()
  {
    return $this->_get_arr_size("2");
  }
}
?>