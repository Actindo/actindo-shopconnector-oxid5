<?php
class ShopConn_Artikel_WeightUnit extends PBEnum
{
  const kg  = 0;
  const g  = 1;
  const t  = 2;
}
class ShopConn_Artikel_ArtikelCategory extends PBMessage
{
  var $wired_type = PBMessage::WIRED_STRING;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->values["1"] = "";
  }
  function cat_id()
  {
    return $this->_get_value("1");
  }
  function set_cat_id($value)
  {
    return $this->_set_value("1", $value);
  }
}
class ShopConn_Artikel_ArtikelDescription extends PBMessage
{
  var $wired_type = PBMessage::WIRED_STRING;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->values["1"] = "";
    $this->fields["2"] = "PBInt";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->values["3"] = "";
  }
  function language_code()
  {
    return $this->_get_value("1");
  }
  function set_language_code($value)
  {
    return $this->_set_value("1", $value);
  }
  function language_id()
  {
    return $this->_get_value("2");
  }
  function set_language_id($value)
  {
    return $this->_set_value("2", $value);
  }
  function products_name()
  {
    return $this->_get_value("3");
  }
  function set_products_name($value)
  {
    return $this->_set_value("3", $value);
  }
}
class ShopConn_Artikel_ArtikelPreisStaffel extends PBMessage
{
  var $wired_type = PBMessage::WIRED_STRING;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBDouble";
    $this->values["1"] = "";
    $this->fields["2"] = "PBDouble";
    $this->values["2"] = "";
  }
  function preis_gruppe()
  {
    return $this->_get_value("1");
  }
  function set_preis_gruppe($value)
  {
    return $this->_set_value("1", $value);
  }
  function preis_range()
  {
    return $this->_get_value("2");
  }
  function set_preis_range($value)
  {
    return $this->_set_value("2", $value);
  }
}
class ShopConn_Artikel_ArtikelPriceBracket extends PBMessage
{
  var $wired_type = PBMessage::WIRED_STRING;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->values["1"] = "";
    $this->fields["2"] = "PBBool";
    $this->values["2"] = "";
    $this->fields["3"] = "PBDouble";
    $this->values["3"] = "";
    $this->fields["4"] = "ShopConn_Artikel_ArtikelPreisStaffel";
    $this->values["4"] = array();
  }
  function preisgruppe()
  {
    return $this->_get_value("1");
  }
  function set_preisgruppe($value)
  {
    return $this->_set_value("1", $value);
  }
  function is_brutto()
  {
    return $this->_get_value("2");
  }
  function set_is_brutto($value)
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
  function preisstaffeln($offset)
  {
    return $this->_get_arr_value("4", $offset);
  }
  function add_preisstaffeln()
  {
    return $this->_add_arr_value("4");
  }
  function preisstaffeln_size()
  {
    return $this->_get_arr_size("4");
  }
}
class ShopConn_Artikel_AttributesTranslation extends PBMessage
{
  var $wired_type = PBMessage::WIRED_STRING;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->values["2"] = "";
  }
  function language_code()
  {
    return $this->_get_value("1");
  }
  function set_language_code($value)
  {
    return $this->_set_value("1", $value);
  }
  function name()
  {
    return $this->_get_value("2");
  }
  function set_name($value)
  {
    return $this->_set_value("2", $value);
  }
}
class ShopConn_Artikel_ArtikelAttributesName extends PBMessage
{
  var $wired_type = PBMessage::WIRED_STRING;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->values["1"] = "";
    $this->fields["2"] = "ShopConn_Artikel_AttributesTranslation";
    $this->values["2"] = array();
  }
  function name_id()
  {
    return $this->_get_value("1");
  }
  function set_name_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function translation($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_translation()
  {
    return $this->_add_arr_value("2");
  }
  function translation_size()
  {
    return $this->_get_arr_size("2");
  }
}
class ShopConn_Artikel_ArtikelAttributesValues extends PBMessage
{
  var $wired_type = PBMessage::WIRED_STRING;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->values["1"] = "";
    $this->fields["2"] = "PBInt";
    $this->values["2"] = "";
    $this->fields["3"] = "ShopConn_Artikel_AttributesTranslation";
    $this->values["3"] = array();
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
  function translation($offset)
  {
    return $this->_get_arr_value("3", $offset);
  }
  function add_translation()
  {
    return $this->_add_arr_value("3");
  }
  function translation_size()
  {
    return $this->_get_arr_size("3");
  }
}
class ShopConn_Artikel_ArtikelAttributesCombinationSimple extends PBMessage
{
  var $wired_type = PBMessage::WIRED_STRING;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->values["1"] = "";
    $this->fields["2"] = "PBInt";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->values["3"] = "";
    $this->fields["4"] = "PBDouble";
    $this->values["4"] = "";
    $this->values["4"] = new PBDouble();
    $this->values["4"]->value = 0;
    $this->fields["5"] = "PBDouble";
    $this->values["5"] = "";
    $this->values["5"] = new PBDouble();
    $this->values["5"]->value = 0;
    $this->fields["6"] = "PBDouble";
    $this->values["6"] = "";
    $this->values["6"] = new PBDouble();
    $this->values["6"]->value = 0;
    $this->fields["7"] = "PBInt";
    $this->values["7"] = "";
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
  function attributes_model()
  {
    return $this->_get_value("3");
  }
  function set_attributes_model($value)
  {
    return $this->_set_value("3", $value);
  }
  function options_values_price()
  {
    return $this->_get_value("4");
  }
  function set_options_values_price($value)
  {
    return $this->_set_value("4", $value);
  }
  function options_values_weight()
  {
    return $this->_get_value("5");
  }
  function set_options_values_weight($value)
  {
    return $this->_set_value("5", $value);
  }
  function l_bestand()
  {
    return $this->_get_value("6");
  }
  function set_l_bestand($value)
  {
    return $this->_set_value("6", $value);
  }
  function sort_order()
  {
    return $this->_get_value("7");
  }
  function set_sort_order($value)
  {
    return $this->_set_value("7", $value);
  }
}
class ShopConn_Artikel_ArtikelAttributes extends PBMessage
{
  var $wired_type = PBMessage::WIRED_STRING;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "ShopConn_Artikel_ArtikelAttributesName";
    $this->values["1"] = array();
    $this->fields["2"] = "ShopConn_Artikel_ArtikelAttributesValues";
    $this->values["2"] = array();
    $this->fields["3"] = "ShopConn_Artikel_ArtikelAttributesCombinationSimple";
    $this->values["3"] = array();
  }
  function names($offset)
  {
    return $this->_get_arr_value("1", $offset);
  }
  function add_names()
  {
    return $this->_add_arr_value("1");
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
  function combination_simple_size()
  {
    return $this->_get_arr_size("3");
  }
}
class ShopConn_Artikel_ArtikelXSelling extends PBMessage
{
  var $wired_type = PBMessage::WIRED_STRING;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->values["2"] = "";
    $this->fields["3"] = "PBInt";
    $this->values["3"] = "";
    $this->values["3"] = new PBInt();
    $this->values["3"]->value = 0;
  }
  function group_id()
  {
    return $this->_get_value("1");
  }
  function set_group_id($value)
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
  function sort_order()
  {
    return $this->_get_value("3");
  }
  function set_sort_order($value)
  {
    return $this->_set_value("3", $value);
  }
}
class ShopConn_Artikel_ArtikelGroupPermission extends PBMessage
{
  var $wired_type = PBMessage::WIRED_STRING;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->values["1"] = "";
    $this->fields["2"] = "PBInt";
    $this->values["2"] = "";
  }
  function group_id()
  {
    return $this->_get_value("1");
  }
  function set_group_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function perm()
  {
    return $this->_get_value("2");
  }
  function set_perm($value)
  {
    return $this->_set_value("2", $value);
  }
}
class ShopConn_Artikel_ArtikelImage extends PBMessage
{
  var $wired_type = PBMessage::WIRED_STRING;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->values["3"] = "";
    $this->fields["4"] = "PBString";
    $this->values["4"] = "";
    $this->fields["5"] = "PBString";
    $this->values["5"] = "";
  }
  function image_nr()
  {
    return $this->_get_value("1");
  }
  function set_image_nr($value)
  {
    return $this->_set_value("1", $value);
  }
  function image_name()
  {
    return $this->_get_value("2");
  }
  function set_image_name($value)
  {
    return $this->_set_value("2", $value);
  }
  function image_type()
  {
    return $this->_get_value("3");
  }
  function set_image_type($value)
  {
    return $this->_set_value("3", $value);
  }
  function image()
  {
    return $this->_get_value("4");
  }
  function set_image($value)
  {
    return $this->_set_value("4", $value);
  }
  function image_subfolder()
  {
    return $this->_get_value("5");
  }
  function set_image_subfolder($value)
  {
    return $this->_set_value("5", $value);
  }
}
class ShopConn_Artikel extends PBMessage
{
  var $wired_type = PBMessage::WIRED_STRING;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->values["1"] = "";
    $this->fields["2"] = "PBDouble";
    $this->values["2"] = "";
    $this->fields["3"] = "PBBool";
    $this->values["3"] = "";
    $this->values["3"] = new PBBool();
    $this->values["3"]->value = true;
    $this->fields["4"] = "PBInt";
    $this->values["4"] = "";
    $this->fields["5"] = "PBInt";
    $this->values["5"] = "";
    $this->fields["6"] = "PBInt";
    $this->values["6"] = "";
    $this->fields["7"] = "PBInt";
    $this->values["7"] = "";
    $this->fields["8"] = "PBString";
    $this->values["8"] = "";
    $this->fields["9"] = "PBString";
    $this->values["9"] = "";
    $this->fields["10"] = "PBFloat";
    $this->values["10"] = "";
    $this->fields["11"] = "PBInt";
    $this->values["11"] = "";
    $this->fields["12"] = "PBDouble";
    $this->values["12"] = "";
    $this->fields["13"] = "PBDouble";
    $this->values["13"] = "";
    $this->fields["14"] = "ShopConn_Artikel_WeightUnit";
    $this->values["14"] = "";
    $this->fields["15"] = "ShopConn_Artikel_ArtikelCategory";
    $this->values["15"] = array();
    $this->fields["16"] = "ShopConn_Artikel_ArtikelDescription";
    $this->values["16"] = array();
    $this->fields["17"] = "ShopConn_Artikel_ArtikelPriceBracket";
    $this->values["17"] = array();
    $this->fields["18"] = "ShopConn_Artikel_ArtikelAttributes";
    $this->values["18"] = "";
    $this->fields["19"] = "ShopConn_Artikel_ArtikelXSelling";
    $this->values["19"] = array();
    $this->fields["20"] = "ShopConn_Artikel_ArtikelGroupPermission";
    $this->values["20"] = array();
    $this->fields["21"] = "ShopConn_Artikel_ArtikelImage";
    $this->values["21"] = array();
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
  function all_categories($offset)
  {
    return $this->_get_arr_value("15", $offset);
  }
  function add_all_categories()
  {
    return $this->_add_arr_value("15");
  }
  function all_categories_size()
  {
    return $this->_get_arr_size("15");
  }
  function description($offset)
  {
    return $this->_get_arr_value("16", $offset);
  }
  function add_description()
  {
    return $this->_add_arr_value("16");
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
  function xselling($offset)
  {
    return $this->_get_arr_value("19", $offset);
  }
  function add_xselling()
  {
    return $this->_add_arr_value("19");
  }
  function xselling_size()
  {
    return $this->_get_arr_size("19");
  }
  function group_permission($offset)
  {
    return $this->_get_arr_value("20", $offset);
  }
  function add_group_permission()
  {
    return $this->_add_arr_value("20");
  }
  function group_permission_size()
  {
    return $this->_get_arr_size("20");
  }
  function images($offset)
  {
    return $this->_get_arr_value("21", $offset);
  }
  function add_images()
  {
    return $this->_add_arr_value("21");
  }
  function images_size()
  {
    return $this->_get_arr_size("21");
  }
}
?>