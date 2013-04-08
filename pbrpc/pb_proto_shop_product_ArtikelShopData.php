<?php
class ArtikelShopData_ArtikelCategory extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "categories_id";
    $this->values["1"] = "";
  }
  function categories_id()
  {
    return $this->_get_value("1");
  }
  function set_categories_id($value)
  {
    return $this->_set_value("1", $value);
  }
}
class ArtikelShopData_ArtikelGroupPermission extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "group_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBInt";
    $this->fieldnames["2"] = "perm";
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
class ArtikelShopData_ArtikelXSelling extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "group_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "art_nr";
    $this->values["2"] = "";
    $this->fields["3"] = "PBInt";
    $this->fieldnames["3"] = "sort_order";
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
class ArtikelShopData_ArtikelPseudoPrice extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "preisgruppe";
    $this->values["1"] = "";
    $this->fields["2"] = "PBDouble";
    $this->fieldnames["2"] = "pseudoprice";
    $this->values["2"] = "";
  }
  function preisgruppe()
  {
    return $this->_get_value("1");
  }
  function set_preisgruppe($value)
  {
    return $this->_set_value("1", $value);
  }
  function pseudoprice()
  {
    return $this->_get_value("2");
  }
  function set_pseudoprice($value)
  {
    return $this->_set_value("2", $value);
  }
}
class ArtikelShopData extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "products_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBInt";
    $this->fieldnames["2"] = "products_status";
    $this->values["2"] = "";
    $this->fields["3"] = "PBInt";
    $this->fieldnames["3"] = "products_status_lager_zero";
    $this->values["3"] = "";
    $this->fields["4"] = "PBInt";
    $this->fieldnames["4"] = "products_date_available";
    $this->values["4"] = "";
    $this->fields["5"] = "PBBool";
    $this->fieldnames["5"] = "products_startpage";
    $this->values["5"] = "";
    $this->fields["6"] = "PBInt";
    $this->fieldnames["6"] = "products_startpage_sort";
    $this->values["6"] = "";
    $this->fields["7"] = "PBInt";
    $this->fieldnames["7"] = "products_sort";
    $this->values["7"] = "";
    $this->fields["8"] = "PBString";
    $this->fieldnames["8"] = "manufacturers_id";
    $this->values["8"] = "";
    $this->fields["9"] = "PBBool";
    $this->fieldnames["9"] = "products_vpe_status";
    $this->values["9"] = "";
    $this->fields["10"] = "PBDouble";
    $this->fieldnames["10"] = "products_vpe_value";
    $this->values["10"] = "";
    $this->fields["11"] = "PBString";
    $this->fieldnames["11"] = "products_vpe";
    $this->values["11"] = "";
    $this->fields["12"] = "PBBool";
    $this->fieldnames["12"] = "fsk18";
    $this->values["12"] = "";
    $this->fields["13"] = "PBDouble";
    $this->fieldnames["13"] = "products_weight";
    $this->values["13"] = "";
    $this->fields["14"] = "PBString";
    $this->fieldnames["14"] = "shipping_status";
    $this->values["14"] = "";
    $this->fields["15"] = "PBString";
    $this->fieldnames["15"] = "shipping_status_lager_zero";
    $this->values["15"] = "";
    $this->fields["16"] = "PBString";
    $this->fieldnames["16"] = "shipping_status_text";
    $this->values["16"] = "";
    $this->fields["17"] = "PBString";
    $this->fieldnames["17"] = "shipping_status_lager_zero_text";
    $this->values["17"] = "";
    $this->fields["18"] = "PBString";
    $this->fieldnames["18"] = "info_template";
    $this->values["18"] = "";
    $this->fields["19"] = "PBString";
    $this->fieldnames["19"] = "options_template";
    $this->values["19"] = "";
    $this->fields["20"] = "ArtikelShopData_ArtikelCategory";
    $this->fieldnames["20"] = "all_categories";
    $this->values["20"] = array();
    $this->fields["21"] = "ArtikelShopData_ArtikelGroupPermission";
    $this->fieldnames["21"] = "group_permission";
    $this->values["21"] = array();
    $this->fields["22"] = "ArtikelShopData_ArtikelXSelling";
    $this->fieldnames["22"] = "xselling";
    $this->values["22"] = array();
    $this->fields["23"] = "PBInt";
    $this->fieldnames["23"] = "activeto";
    $this->values["23"] = "";
    $this->fields["24"] = "PBBool";
    $this->fieldnames["24"] = "topseller";
    $this->values["24"] = "";
    $this->fields["25"] = "PBString";
    $this->fieldnames["25"] = "suppliernumber";
    $this->values["25"] = "";
    $this->fields["26"] = "PBBool";
    $this->fieldnames["26"] = "products_digital";
    $this->values["26"] = "";
    $this->fields["27"] = "PBInt";
    $this->fieldnames["27"] = "pseudosales";
    $this->values["27"] = "";
    $this->fields["28"] = "PBBool";
    $this->fieldnames["28"] = "shipping_free";
    $this->values["28"] = "";
    $this->fields["29"] = "PBString";
    $this->fieldnames["29"] = "products_option_list_template";
    $this->values["29"] = "";
    $this->fields["30"] = "ArtikelShopData_ArtikelPseudoPrice";
    $this->fieldnames["30"] = "products_pseudoprices";
    $this->values["30"] = array();
    $this->fields["31"] = "PBString";
    $this->fieldnames["31"] = "filtergroup_id";
    $this->values["31"] = "";
    $this->fields["32"] = "PBString";
    $this->fieldnames["32"] = "supplierean";
    $this->values["32"] = "";
    $this->fields["33"] = "PBDouble";
    $this->fieldnames["33"] = "length";
    $this->values["33"] = "";
    $this->fields["34"] = "PBDouble";
    $this->fieldnames["34"] = "width";
    $this->values["34"] = "";
    $this->fields["35"] = "PBDouble";
    $this->fieldnames["35"] = "height";
    $this->values["35"] = "";
    $this->fields["36"] = "PBString";
    $this->fieldnames["36"] = "vendors_id";
    $this->values["36"] = "";
    $this->fields["37"] = "PBBool";
    $this->fieldnames["37"] = "nonmaterial";
    $this->values["37"] = "";
    $this->fields["38"] = "PBBool";
    $this->fieldnames["38"] = "non_searchable";
    $this->values["38"] = "";
    $this->fields["39"] = "PBBool";
    $this->fieldnames["39"] = "skipdiscounts";
    $this->values["39"] = "";
    $this->fields["40"] = "PBBool";
    $this->fieldnames["40"] = "fixedprice";
    $this->values["40"] = "";
    $this->fields["41"] = "PBString";
    $this->fieldnames["41"] = "products_mpn";
    $this->values["41"] = "";
  }
  function products_id()
  {
    return $this->_get_value("1");
  }
  function set_products_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function products_status()
  {
    return $this->_get_value("2");
  }
  function set_products_status($value)
  {
    return $this->_set_value("2", $value);
  }
  function products_status_lager_zero()
  {
    return $this->_get_value("3");
  }
  function set_products_status_lager_zero($value)
  {
    return $this->_set_value("3", $value);
  }
  function products_date_available()
  {
    return $this->_get_value("4");
  }
  function set_products_date_available($value)
  {
    return $this->_set_value("4", $value);
  }
  function products_startpage()
  {
    return $this->_get_value("5");
  }
  function set_products_startpage($value)
  {
    return $this->_set_value("5", $value);
  }
  function products_startpage_sort()
  {
    return $this->_get_value("6");
  }
  function set_products_startpage_sort($value)
  {
    return $this->_set_value("6", $value);
  }
  function products_sort()
  {
    return $this->_get_value("7");
  }
  function set_products_sort($value)
  {
    return $this->_set_value("7", $value);
  }
  function manufacturers_id()
  {
    return $this->_get_value("8");
  }
  function set_manufacturers_id($value)
  {
    return $this->_set_value("8", $value);
  }
  function products_vpe_status()
  {
    return $this->_get_value("9");
  }
  function set_products_vpe_status($value)
  {
    return $this->_set_value("9", $value);
  }
  function products_vpe_value()
  {
    return $this->_get_value("10");
  }
  function set_products_vpe_value($value)
  {
    return $this->_set_value("10", $value);
  }
  function products_vpe()
  {
    return $this->_get_value("11");
  }
  function set_products_vpe($value)
  {
    return $this->_set_value("11", $value);
  }
  function fsk18()
  {
    return $this->_get_value("12");
  }
  function set_fsk18($value)
  {
    return $this->_set_value("12", $value);
  }
  function products_weight()
  {
    return $this->_get_value("13");
  }
  function set_products_weight($value)
  {
    return $this->_set_value("13", $value);
  }
  function shipping_status()
  {
    return $this->_get_value("14");
  }
  function set_shipping_status($value)
  {
    return $this->_set_value("14", $value);
  }
  function shipping_status_lager_zero()
  {
    return $this->_get_value("15");
  }
  function set_shipping_status_lager_zero($value)
  {
    return $this->_set_value("15", $value);
  }
  function shipping_status_text()
  {
    return $this->_get_value("16");
  }
  function set_shipping_status_text($value)
  {
    return $this->_set_value("16", $value);
  }
  function shipping_status_lager_zero_text()
  {
    return $this->_get_value("17");
  }
  function set_shipping_status_lager_zero_text($value)
  {
    return $this->_set_value("17", $value);
  }
  function info_template()
  {
    return $this->_get_value("18");
  }
  function set_info_template($value)
  {
    return $this->_set_value("18", $value);
  }
  function options_template()
  {
    return $this->_get_value("19");
  }
  function set_options_template($value)
  {
    return $this->_set_value("19", $value);
  }
  function all_categories($offset)
  {
    return $this->_get_arr_value("20", $offset);
  }
  function add_all_categories()
  {
    return $this->_add_arr_value("20");
  }
  function set_all_categories($index, $value)
  {
    $this->_set_arr_value("20", $index, $value);
  }
  function remove_last_all_categories()
  {
    $this->_remove_last_arr_value("20");
  }
  function all_categories_size()
  {
    return $this->_get_arr_size("20");
  }
  function group_permission($offset)
  {
    return $this->_get_arr_value("21", $offset);
  }
  function add_group_permission()
  {
    return $this->_add_arr_value("21");
  }
  function set_group_permission($index, $value)
  {
    $this->_set_arr_value("21", $index, $value);
  }
  function remove_last_group_permission()
  {
    $this->_remove_last_arr_value("21");
  }
  function group_permission_size()
  {
    return $this->_get_arr_size("21");
  }
  function xselling($offset)
  {
    return $this->_get_arr_value("22", $offset);
  }
  function add_xselling()
  {
    return $this->_add_arr_value("22");
  }
  function set_xselling($index, $value)
  {
    $this->_set_arr_value("22", $index, $value);
  }
  function remove_last_xselling()
  {
    $this->_remove_last_arr_value("22");
  }
  function xselling_size()
  {
    return $this->_get_arr_size("22");
  }
  function activeto()
  {
    return $this->_get_value("23");
  }
  function set_activeto($value)
  {
    return $this->_set_value("23", $value);
  }
  function topseller()
  {
    return $this->_get_value("24");
  }
  function set_topseller($value)
  {
    return $this->_set_value("24", $value);
  }
  function suppliernumber()
  {
    return $this->_get_value("25");
  }
  function set_suppliernumber($value)
  {
    return $this->_set_value("25", $value);
  }
  function products_digital()
  {
    return $this->_get_value("26");
  }
  function set_products_digital($value)
  {
    return $this->_set_value("26", $value);
  }
  function pseudosales()
  {
    return $this->_get_value("27");
  }
  function set_pseudosales($value)
  {
    return $this->_set_value("27", $value);
  }
  function shipping_free()
  {
    return $this->_get_value("28");
  }
  function set_shipping_free($value)
  {
    return $this->_set_value("28", $value);
  }
  function products_option_list_template()
  {
    return $this->_get_value("29");
  }
  function set_products_option_list_template($value)
  {
    return $this->_set_value("29", $value);
  }
  function products_pseudoprices($offset)
  {
    return $this->_get_arr_value("30", $offset);
  }
  function add_products_pseudoprices()
  {
    return $this->_add_arr_value("30");
  }
  function set_products_pseudoprices($index, $value)
  {
    $this->_set_arr_value("30", $index, $value);
  }
  function remove_last_products_pseudoprices()
  {
    $this->_remove_last_arr_value("30");
  }
  function products_pseudoprices_size()
  {
    return $this->_get_arr_size("30");
  }
  function filtergroup_id()
  {
    return $this->_get_value("31");
  }
  function set_filtergroup_id($value)
  {
    return $this->_set_value("31", $value);
  }
  function supplierean()
  {
    return $this->_get_value("32");
  }
  function set_supplierean($value)
  {
    return $this->_set_value("32", $value);
  }
  function length()
  {
    return $this->_get_value("33");
  }
  function set_length($value)
  {
    return $this->_set_value("33", $value);
  }
  function width()
  {
    return $this->_get_value("34");
  }
  function set_width($value)
  {
    return $this->_set_value("34", $value);
  }
  function height()
  {
    return $this->_get_value("35");
  }
  function set_height($value)
  {
    return $this->_set_value("35", $value);
  }
  function vendors_id()
  {
    return $this->_get_value("36");
  }
  function set_vendors_id($value)
  {
    return $this->_set_value("36", $value);
  }
  function nonmaterial()
  {
    return $this->_get_value("37");
  }
  function set_nonmaterial($value)
  {
    return $this->_set_value("37", $value);
  }
  function non_searchable()
  {
    return $this->_get_value("38");
  }
  function set_non_searchable($value)
  {
    return $this->_set_value("38", $value);
  }
  function skipdiscounts()
  {
    return $this->_get_value("39");
  }
  function set_skipdiscounts($value)
  {
    return $this->_set_value("39", $value);
  }
  function fixedprice()
  {
    return $this->_get_value("40");
  }
  function set_fixedprice($value)
  {
    return $this->_set_value("40", $value);
  }
  function products_mpn()
  {
    return $this->_get_value("41");
  }
  function set_products_mpn($value)
  {
    return $this->_set_value("41", $value);
  }
}
?>