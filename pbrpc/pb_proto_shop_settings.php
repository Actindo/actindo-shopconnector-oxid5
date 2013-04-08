<?php
class ShopSettingsResponse_Language extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "language_code";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "language_name";
    $this->values["2"] = "";
    $this->fields["3"] = "PBInt";
    $this->fieldnames["3"] = "language_id";
    $this->values["3"] = "";
    $this->fields["4"] = "PBBool";
    $this->fieldnames["4"] = "is_default";
    $this->values["4"] = "";
  }
  function language_code()
  {
    return $this->_get_value("1");
  }
  function set_language_code($value)
  {
    return $this->_set_value("1", $value);
  }
  function language_name()
  {
    return $this->_get_value("2");
  }
  function set_language_name($value)
  {
    return $this->_set_value("2", $value);
  }
  function language_id()
  {
    return $this->_get_value("3");
  }
  function set_language_id($value)
  {
    return $this->_set_value("3", $value);
  }
  function is_default()
  {
    return $this->_get_value("4");
  }
  function set_is_default($value)
  {
    return $this->_set_value("4", $value);
  }
}
class ShopSettingsResponse_Manufacturer extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "manufacturers_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "manufacturers_name";
    $this->values["2"] = "";
  }
  function manufacturers_id()
  {
    return $this->_get_value("1");
  }
  function set_manufacturers_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function manufacturers_name()
  {
    return $this->_get_value("2");
  }
  function set_manufacturers_name($value)
  {
    return $this->_set_value("2", $value);
  }
}
class ShopSettingsResponse_OrderStatus extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "name";
    $this->values["2"] = "";
  }
  function id()
  {
    return $this->_get_value("1");
  }
  function set_id($value)
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
class ShopSettingsResponse_CustomerStatus extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "customers_status_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "customers_status_name";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "customers_status_internal_id";
    $this->values["3"] = "";
    $this->fields["4"] = "PBDouble";
    $this->fieldnames["4"] = "customers_status_min_order";
    $this->values["4"] = "";
  }
  function customers_status_id()
  {
    return $this->_get_value("1");
  }
  function set_customers_status_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function customers_status_name()
  {
    return $this->_get_value("2");
  }
  function set_customers_status_name($value)
  {
    return $this->_set_value("2", $value);
  }
  function customers_status_internal_id()
  {
    return $this->_get_value("3");
  }
  function set_customers_status_internal_id($value)
  {
    return $this->_set_value("3", $value);
  }
  function customers_status_min_order()
  {
    return $this->_get_value("4");
  }
  function set_customers_status_min_order($value)
  {
    return $this->_set_value("4", $value);
  }
}
class ShopSettingsResponse_XSellGroup extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "products_xsell_grp_name_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "groupname";
    $this->values["2"] = "";
    $this->fields["3"] = "PBInt";
    $this->fieldnames["3"] = "xsell_sort_order";
    $this->values["3"] = "";
  }
  function products_xsell_grp_name_id()
  {
    return $this->_get_value("1");
  }
  function set_products_xsell_grp_name_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function groupname()
  {
    return $this->_get_value("2");
  }
  function set_groupname($value)
  {
    return $this->_set_value("2", $value);
  }
  function xsell_sort_order()
  {
    return $this->_get_value("3");
  }
  function set_xsell_sort_order($value)
  {
    return $this->_set_value("3", $value);
  }
}
class ShopSettingsResponse_InstalledModule extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "code";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "name";
    $this->values["2"] = "";
    $this->fields["3"] = "PBBool";
    $this->fieldnames["3"] = "active";
    $this->values["3"] = "";
    $this->fields["4"] = "PBString";
    $this->fieldnames["4"] = "description";
    $this->values["4"] = "";
  }
  function code()
  {
    return $this->_get_value("1");
  }
  function set_code($value)
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
  function active()
  {
    return $this->_get_value("3");
  }
  function set_active($value)
  {
    return $this->_set_value("3", $value);
  }
  function description()
  {
    return $this->_get_value("4");
  }
  function set_description($value)
  {
    return $this->_set_value("4", $value);
  }
}
class ShopSettingsResponse_InstalledTemplate extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "name";
    $this->values["2"] = "";
  }
  function id()
  {
    return $this->_get_value("1");
  }
  function set_id($value)
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
class ShopSettingsResponse_ArtikelPropertySet extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "name";
    $this->values["2"] = "";
    $this->fields["3"] = "PBBool";
    $this->fieldnames["3"] = "comparable";
    $this->values["3"] = "";
    $this->fields["4"] = "PBInt";
    $this->fieldnames["4"] = "position";
    $this->values["4"] = "";
  }
  function id()
  {
    return $this->_get_value("1");
  }
  function set_id($value)
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
  function comparable()
  {
    return $this->_get_value("3");
  }
  function set_comparable($value)
  {
    return $this->_set_value("3", $value);
  }
  function position()
  {
    return $this->_get_value("4");
  }
  function set_position($value)
  {
    return $this->_set_value("4", $value);
  }
}
class ShopSettingsResponse_ArtikelPropertyFieldValue extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "value";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "text";
    $this->values["2"] = "";
  }
  function value()
  {
    return $this->_get_value("1");
  }
  function set_value($value)
  {
    return $this->_set_value("1", $value);
  }
  function text()
  {
    return $this->_get_value("2");
  }
  function set_text($value)
  {
    return $this->_set_value("2", $value);
  }
}
class ShopSettingsResponse_ArtikelPropertyFieldType extends PBEnum
{
  const textfield  = 0;
  const numberfield  = 1;
  const textarea  = 2;
  const combobox  = 3;
  const boolean  = 4;
  const datefield  = 5;
  const timefield  = 6;
}
class ShopSettingsResponse_ArtikelProperty extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "field_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "field_name";
    $this->values["2"] = "";
    $this->fields["3"] = "PBBool";
    $this->fieldnames["3"] = "field_i18n";
    $this->values["3"] = "";
    $this->fields["4"] = "PBString";
    $this->fieldnames["4"] = "field_set";
    $this->values["4"] = "";
    $this->fields["5"] = "PBBool";
    $this->fieldnames["5"] = "field_noempty";
    $this->values["5"] = "";
    $this->fields["6"] = "ShopSettingsResponse_ArtikelPropertyFieldType";
    $this->fieldnames["6"] = "field_type";
    $this->values["6"] = "";
    $this->fields["7"] = "PBString";
    $this->fieldnames["7"] = "field_set_ids";
    $this->values["7"] = array();
    $this->fields["8"] = "PBString";
    $this->fieldnames["8"] = "field_help";
    $this->values["8"] = "";
    $this->fields["9"] = "ShopSettingsResponse_ArtikelPropertyFieldValue";
    $this->fieldnames["9"] = "field_values";
    $this->values["9"] = array();
  }
  function field_id()
  {
    return $this->_get_value("1");
  }
  function set_field_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function field_name()
  {
    return $this->_get_value("2");
  }
  function set_field_name($value)
  {
    return $this->_set_value("2", $value);
  }
  function field_i18n()
  {
    return $this->_get_value("3");
  }
  function set_field_i18n($value)
  {
    return $this->_set_value("3", $value);
  }
  function field_set()
  {
    return $this->_get_value("4");
  }
  function set_field_set($value)
  {
    return $this->_set_value("4", $value);
  }
  function field_noempty()
  {
    return $this->_get_value("5");
  }
  function set_field_noempty($value)
  {
    return $this->_set_value("5", $value);
  }
  function field_type()
  {
    return $this->_get_value("6");
  }
  function set_field_type($value)
  {
    return $this->_set_value("6", $value);
  }
  function field_set_ids($offset)
  {
    $v = $this->_get_arr_value("7", $offset);
    return $v->get_value();
  }
  function append_field_set_ids($value)
  {
    $v = $this->_add_arr_value("7");
    $v->set_value($value);
  }
  function set_field_set_ids($index, $value)
  {
    $v = new $this->fields["7"]();
    $v->set_value($value);
    $this->_set_arr_value("7", $index, $v);
  }
  function remove_last_field_set_ids()
  {
    $this->_remove_last_arr_value("7");
  }
  function field_set_ids_size()
  {
    return $this->_get_arr_size("7");
  }
  function field_help()
  {
    return $this->_get_value("8");
  }
  function set_field_help($value)
  {
    return $this->_set_value("8", $value);
  }
  function field_values($offset)
  {
    return $this->_get_arr_value("9", $offset);
  }
  function add_field_values()
  {
    return $this->_add_arr_value("9");
  }
  function set_field_values($index, $value)
  {
    $this->_set_arr_value("9", $index, $value);
  }
  function remove_last_field_values()
  {
    $this->_remove_last_arr_value("9");
  }
  function field_values_size()
  {
    return $this->_get_arr_size("9");
  }
}
class ShopSettingsResponse_Vendor extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "vendors_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "vendors_name";
    $this->values["2"] = "";
  }
  function vendors_id()
  {
    return $this->_get_value("1");
  }
  function set_vendors_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function vendors_name()
  {
    return $this->_get_value("2");
  }
  function set_vendors_name($value)
  {
    return $this->_set_value("2", $value);
  }
}
class ShopSettingsResponse_ShippingTime extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "shippingtime_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "shippingtime_name";
    $this->values["2"] = "";
  }
  function shippingtime_id()
  {
    return $this->_get_value("1");
  }
  function set_shippingtime_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function shippingtime_name()
  {
    return $this->_get_value("2");
  }
  function set_shippingtime_name($value)
  {
    return $this->_set_value("2", $value);
  }
}
class ShopSettingsResponse_VPELang extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "vpe_lang_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "vpe_lang_name";
    $this->values["2"] = "";
  }
  function vpe_lang_id()
  {
    return $this->_get_value("1");
  }
  function set_vpe_lang_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function vpe_lang_name()
  {
    return $this->_get_value("2");
  }
  function set_vpe_lang_name($value)
  {
    return $this->_set_value("2", $value);
  }
  }
class ShopSettingsResponse_MultiStores extends PBMessage
  {
  public function __construct($reader=null)
  {
  $this->fields["1"] = "PBInt";
  $this->fieldnames["1"] = "id";

  $this->fields["2"] = "PBInt";
  $this->fieldnames["2"] = "parent_id";

  $this->fields["3"] = "PBString";
  $this->fieldnames["3"] = "name";

  $this->fields["4"] = "PBString";
  $this->fieldnames["4"] = "url_http";

  $this->fields["5"] = "PBString";
  $this->fieldnames["5"] = "url_https";

  $this->fields["6"] = "PBBool";
  $this->fieldnames["6"] = "active";

  $this->fields["7"] = "PBBool";
  $this->fieldnames["7"] = "is_inherited";
  }

  function set_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function set_parent_id($value)
  {
    return $this->_set_value("2", $value);
  }
  function set_name($value)
  {
    return $this->_set_value("3", $value);
  }
  function set_url_http($value)
  {
    return $this->_set_value("4", $value);
  }
  function set_url_https($value)
  {
    return $this->_set_value("5", $value);
  }
  function set_active($value)
  {
    return $this->_set_value("6", $value);
  }
  function set_is_inherited($value)
  {
    return $this->_set_value("7", $value);
  }

  function id()
  {
    return $this->_get_value("1");
  }
  function parent_id()
  {
    return $this->_get_value("2");
  }
  function name()
  {
    return $this->_get_value("3");
  }
  function url_http()
  {
    return $this->_get_value("4");
  }
  function url_https()
  {
    return $this->_get_value("5");
  }
  function active()
  {
    return $this->_get_value("6");
  }
  function is_inherited()
  {
    return $this->_get_value("7");
  }

}
class ShopSettingsResponse_VPE extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "vpe_id";
    $this->values["1"] = "";
    $this->fields["2"] = "ShopSettingsResponse_VPELang";
    $this->fieldnames["2"] = "lang";
    $this->values["2"] = array();
  }
  function vpe_id()
  {
    return $this->_get_value("1");
  }
  function set_vpe_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function lang($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_lang()
  {
    return $this->_add_arr_value("2");
  }
  function set_lang($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_lang()
  {
    $this->_remove_last_arr_value("2");
  }
  function lang_size()
  {
    return $this->_get_arr_size("2");
  }
}
class ShopSettingsResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "timestamp";
    $this->values["1"] = "";
    $this->fields["2"] = "ShopSettingsResponse_Language";
    $this->fieldnames["2"] = "languages";
    $this->values["2"] = array();
    $this->fields["3"] = "ShopSettingsResponse_Manufacturer";
    $this->fieldnames["3"] = "manufacturers";
    $this->values["3"] = array();
    $this->fields["4"] = "ShopSettingsResponse_OrderStatus";
    $this->fieldnames["4"] = "orders_status";
    $this->values["4"] = array();
    $this->fields["5"] = "ShopSettingsResponse_CustomerStatus";
    $this->fieldnames["5"] = "customers_status";
    $this->values["5"] = array();
    $this->fields["6"] = "ShopSettingsResponse_XSellGroup";
    $this->fieldnames["6"] = "xsell_groups";
    $this->values["6"] = array();
    $this->fields["7"] = "ShopSettingsResponse_InstalledModule";
    $this->fieldnames["7"] = "installed_payment_modules";
    $this->values["7"] = array();
    $this->fields["8"] = "ShopSettingsResponse_InstalledModule";
    $this->fieldnames["8"] = "installed_shipping_modules";
    $this->values["8"] = array();
    $this->fields["9"] = "ShopSettingsResponse_InstalledTemplate";
    $this->fieldnames["9"] = "info_template";
    $this->values["9"] = array();
    $this->fields["10"] = "ShopSettingsResponse_InstalledTemplate";
    $this->fieldnames["10"] = "options_template";
    $this->values["10"] = array();
    $this->fields["11"] = "ShopSettingsResponse_ArtikelPropertySet";
    $this->fieldnames["11"] = "artikel_property_sets";
    $this->values["11"] = array();
    $this->fields["12"] = "ShopSettingsResponse_ArtikelProperty";
    $this->fieldnames["12"] = "artikel_properties";
    $this->values["12"] = array();
    $this->fields["13"] = "ShopSettingsResponse_Vendor";
    $this->fieldnames["13"] = "vendors";
    $this->values["13"] = array();
    $this->fields["14"] = "ShopSettingsResponse_ShippingTime";
    $this->fieldnames["14"] = "shipping";
    $this->values["14"] = array();
    $this->fields["15"] = "ShopSettingsResponse_VPE";
    $this->fieldnames["15"] = "vpe";
    $this->values["15"] = array();
    $this->fields["16"] = "ShopSettingsResponse_MultiStores";
    $this->fieldnames["16"] = "multistores";
    $this->values["16"] = array();
  }
  function timestamp()
  {
    return $this->_get_value("1");
  }
  function set_timestamp($value)
  {
    return $this->_set_value("1", $value);
  }
  function languages($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_languages()
  {
    return $this->_add_arr_value("2");
  }
  function set_languages($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_languages()
  {
    $this->_remove_last_arr_value("2");
  }
  function languages_size()
  {
    return $this->_get_arr_size("2");
  }
  function manufacturers($offset)
  {
    return $this->_get_arr_value("3", $offset);
  }
  function add_manufacturers()
  {
    return $this->_add_arr_value("3");
  }
  function set_manufacturers($index, $value)
  {
    $this->_set_arr_value("3", $index, $value);
  }
  function remove_last_manufacturers()
  {
    $this->_remove_last_arr_value("3");
  }
  function manufacturers_size()
  {
    return $this->_get_arr_size("3");
  }
  function orders_status($offset)
  {
    return $this->_get_arr_value("4", $offset);
  }
  function add_orders_status()
  {
    return $this->_add_arr_value("4");
  }
  function set_orders_status($index, $value)
  {
    $this->_set_arr_value("4", $index, $value);
  }
  function remove_last_orders_status()
  {
    $this->_remove_last_arr_value("4");
  }
  function orders_status_size()
  {
    return $this->_get_arr_size("4");
  }
  function customers_status($offset)
  {
    return $this->_get_arr_value("5", $offset);
  }
  function add_customers_status()
  {
    return $this->_add_arr_value("5");
  }
  function set_customers_status($index, $value)
  {
    $this->_set_arr_value("5", $index, $value);
  }
  function remove_last_customers_status()
  {
    $this->_remove_last_arr_value("5");
  }
  function customers_status_size()
  {
    return $this->_get_arr_size("5");
  }
  function xsell_groups($offset)
  {
    return $this->_get_arr_value("6", $offset);
  }
  function add_xsell_groups()
  {
    return $this->_add_arr_value("6");
  }
  function set_xsell_groups($index, $value)
  {
    $this->_set_arr_value("6", $index, $value);
  }
  function remove_last_xsell_groups()
  {
    $this->_remove_last_arr_value("6");
  }
  function xsell_groups_size()
  {
    return $this->_get_arr_size("6");
  }
  function installed_payment_modules($offset)
  {
    return $this->_get_arr_value("7", $offset);
  }
  function add_installed_payment_modules()
  {
    return $this->_add_arr_value("7");
  }
  function set_installed_payment_modules($index, $value)
  {
    $this->_set_arr_value("7", $index, $value);
  }
  function remove_last_installed_payment_modules()
  {
    $this->_remove_last_arr_value("7");
  }
  function installed_payment_modules_size()
  {
    return $this->_get_arr_size("7");
  }
  function installed_shipping_modules($offset)
  {
    return $this->_get_arr_value("8", $offset);
  }
  function add_installed_shipping_modules()
  {
    return $this->_add_arr_value("8");
  }
  function set_installed_shipping_modules($index, $value)
  {
    $this->_set_arr_value("8", $index, $value);
  }
  function remove_last_installed_shipping_modules()
  {
    $this->_remove_last_arr_value("8");
  }
  function installed_shipping_modules_size()
  {
    return $this->_get_arr_size("8");
  }
  function info_template($offset)
  {
    return $this->_get_arr_value("9", $offset);
  }
  function add_info_template()
  {
    return $this->_add_arr_value("9");
  }
  function set_info_template($index, $value)
  {
    $this->_set_arr_value("9", $index, $value);
  }
  function remove_last_info_template()
  {
    $this->_remove_last_arr_value("9");
  }
  function info_template_size()
  {
    return $this->_get_arr_size("9");
  }
  function options_template($offset)
  {
    return $this->_get_arr_value("10", $offset);
  }
  function add_options_template()
  {
    return $this->_add_arr_value("10");
  }
  function set_options_template($index, $value)
  {
    $this->_set_arr_value("10", $index, $value);
  }
  function remove_last_options_template()
  {
    $this->_remove_last_arr_value("10");
  }
  function options_template_size()
  {
    return $this->_get_arr_size("10");
  }
  function artikel_property_sets($offset)
  {
    return $this->_get_arr_value("11", $offset);
  }
  function add_artikel_property_sets()
  {
    return $this->_add_arr_value("11");
  }
  function set_artikel_property_sets($index, $value)
  {
    $this->_set_arr_value("11", $index, $value);
  }
  function remove_last_artikel_property_sets()
  {
    $this->_remove_last_arr_value("11");
  }
  function artikel_property_sets_size()
  {
    return $this->_get_arr_size("11");
  }
  function artikel_properties($offset)
  {
    return $this->_get_arr_value("12", $offset);
  }
  function add_artikel_properties()
  {
    return $this->_add_arr_value("12");
  }
  function set_artikel_properties($index, $value)
  {
    $this->_set_arr_value("12", $index, $value);
  }
  function remove_last_artikel_properties()
  {
    $this->_remove_last_arr_value("12");
  }
  function artikel_properties_size()
  {
    return $this->_get_arr_size("12");
  }
  function vendors($offset)
  {
    return $this->_get_arr_value("13", $offset);
  }
  function add_vendors()
  {
    return $this->_add_arr_value("13");
  }
  function set_vendors($index, $value)
  {
    $this->_set_arr_value("13", $index, $value);
  }
  function remove_last_vendors()
  {
    $this->_remove_last_arr_value("13");
  }
  function vendors_size()
  {
    return $this->_get_arr_size("13");
  }
  function shipping($offset)
  {
    return $this->_get_arr_value("14", $offset);
  }
  function add_shipping()
  {
    return $this->_add_arr_value("14");
  }
  function set_shipping($index, $value)
  {
    $this->_set_arr_value("14", $index, $value);
  }
  function remove_last_shipping()
  {
    $this->_remove_last_arr_value("14");
  }
  function shipping_size()
  {
    return $this->_get_arr_size("14");
  }
  function vpe($offset)
  {
    return $this->_get_arr_value("15", $offset);
  }
  function add_vpe()
  {
    return $this->_add_arr_value("15");
  }
  function set_vpe($index, $value)
  {
    $this->_set_arr_value("15", $index, $value);
  }
  function remove_last_vpe()
  {
    $this->_remove_last_arr_value("15");
  }
  function vpe_size()
  {
    return $this->_get_arr_size("15");
  }
  function multistores($offset)
  {
    return $this->_get_arr_value("16", $offset);
  }
  function add_multistores()
  {
    return $this->_add_arr_value("16");
  }
  function set_multistores($index, $value)
  {
    $this->_set_arr_value("16", $index, $value);
  }
  function remove_last_multistores()
  {
    $this->_remove_last_arr_value("16");
  }
  function multistores_size()
  {
    return $this->_get_arr_size("16");
  }
}
?>