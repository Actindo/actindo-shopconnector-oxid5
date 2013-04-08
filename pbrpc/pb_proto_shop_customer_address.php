<?php
class ShopCustomerAddress extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "delivery_address_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "email";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "anrede";
    $this->values["3"] = "";
    $this->fields["4"] = "PBString";
    $this->fieldnames["4"] = "kurzname";
    $this->values["4"] = "";
    $this->fields["5"] = "PBString";
    $this->fieldnames["5"] = "name";
    $this->values["5"] = "";
    $this->fields["6"] = "PBString";
    $this->fieldnames["6"] = "vorname";
    $this->values["6"] = "";
    $this->fields["7"] = "PBString";
    $this->fieldnames["7"] = "firma";
    $this->values["7"] = "";
    $this->fields["8"] = "PBString";
    $this->fieldnames["8"] = "adresse";
    $this->values["8"] = "";
    $this->fields["9"] = "PBString";
    $this->fieldnames["9"] = "adresse2";
    $this->values["9"] = "";
    $this->fields["10"] = "PBString";
    $this->fieldnames["10"] = "ort";
    $this->values["10"] = "";
    $this->fields["11"] = "PBString";
    $this->fieldnames["11"] = "plz";
    $this->values["11"] = "";
    $this->fields["12"] = "PBString";
    $this->fieldnames["12"] = "blnd";
    $this->values["12"] = "";
    $this->fields["13"] = "PBString";
    $this->fieldnames["13"] = "land";
    $this->values["13"] = "";
    $this->fields["14"] = "PBString";
    $this->fieldnames["14"] = "tel";
    $this->values["14"] = "";
    $this->fields["15"] = "PBString";
    $this->fieldnames["15"] = "fax";
    $this->values["15"] = "";
    $this->fields["16"] = "PBString";
    $this->fieldnames["16"] = "mobiltel";
    $this->values["16"] = "";
    $this->fields["17"] = "PBString";
    $this->fieldnames["17"] = "langcode";
    $this->values["17"] = "";
    $this->fields["18"] = "PBString";
    $this->fieldnames["18"] = "ustid";
    $this->values["18"] = "";
    $this->fields["19"] = "PBString";
    $this->fieldnames["19"] = "tel2";
    $this->values["19"] = "";
    $this->fields["20"] = "PBString";
    $this->fieldnames["20"] = "url";
    $this->values["20"] = "";
  }
  function delivery_address_id()
  {
    return $this->_get_value("1");
  }
  function set_delivery_address_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function email()
  {
    return $this->_get_value("2");
  }
  function set_email($value)
  {
    return $this->_set_value("2", $value);
  }
  function anrede()
  {
    return $this->_get_value("3");
  }
  function set_anrede($value)
  {
    return $this->_set_value("3", $value);
  }
  function kurzname()
  {
    return $this->_get_value("4");
  }
  function set_kurzname($value)
  {
    return $this->_set_value("4", $value);
  }
  function name()
  {
    return $this->_get_value("5");
  }
  function set_name($value)
  {
    return $this->_set_value("5", $value);
  }
  function vorname()
  {
    return $this->_get_value("6");
  }
  function set_vorname($value)
  {
    return $this->_set_value("6", $value);
  }
  function firma()
  {
    return $this->_get_value("7");
  }
  function set_firma($value)
  {
    return $this->_set_value("7", $value);
  }
  function adresse()
  {
    return $this->_get_value("8");
  }
  function set_adresse($value)
  {
    return $this->_set_value("8", $value);
  }
  function adresse2()
  {
    return $this->_get_value("9");
  }
  function set_adresse2($value)
  {
    return $this->_set_value("9", $value);
  }
  function ort()
  {
    return $this->_get_value("10");
  }
  function set_ort($value)
  {
    return $this->_set_value("10", $value);
  }
  function plz()
  {
    return $this->_get_value("11");
  }
  function set_plz($value)
  {
    return $this->_set_value("11", $value);
  }
  function blnd()
  {
    return $this->_get_value("12");
  }
  function set_blnd($value)
  {
    return $this->_set_value("12", $value);
  }
  function land()
  {
    return $this->_get_value("13");
  }
  function set_land($value)
  {
    return $this->_set_value("13", $value);
  }
  function tel()
  {
    return $this->_get_value("14");
  }
  function set_tel($value)
  {
    return $this->_set_value("14", $value);
  }
  function fax()
  {
    return $this->_get_value("15");
  }
  function set_fax($value)
  {
    return $this->_set_value("15", $value);
  }
  function mobiltel()
  {
    return $this->_get_value("16");
  }
  function set_mobiltel($value)
  {
    return $this->_set_value("16", $value);
  }
  function langcode()
  {
    return $this->_get_value("17");
  }
  function set_langcode($value)
  {
    return $this->_set_value("17", $value);
  }
  function ustid()
  {
    return $this->_get_value("18");
  }
  function set_ustid($value)
  {
    return $this->_set_value("18", $value);
  }
  function tel2()
  {
    return $this->_get_value("19");
  }
  function set_tel2($value)
  {
    return $this->_set_value("19", $value);
  }
  function url()
  {
    return $this->_get_value("20");
  }
  function set_url($value)
  {
    return $this->_set_value("20", $value);
  }
}
class ShopCustomer extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "deb_kred_id";
    $this->values["1"] = "";
    $this->fields["2"] = "ShopCustomerAddress";
    $this->fieldnames["2"] = "address";
    $this->values["2"] = "";
    $this->fields["3"] = "PBBool";
    $this->fieldnames["3"] = "delivery_as_customer";
    $this->values["3"] = "";
    $this->fields["4"] = "ShopCustomerAddress";
    $this->fieldnames["4"] = "delivery_address";
    $this->values["4"] = "";
    $this->fields["5"] = "PBString";
    $this->fieldnames["5"] = "gebdat";
    $this->values["5"] = "";
    $this->fields["6"] = "PBString";
    $this->fieldnames["6"] = "verf";
    $this->values["6"] = "";
    $this->fields["7"] = "PBString";
    $this->fieldnames["7"] = "_customers_id";
    $this->values["7"] = "";
    $this->fields["8"] = "PBBool";
    $this->fieldnames["8"] = "print_brutto";
    $this->values["8"] = "";
    $this->values["8"] = new PBBool();
    $this->values["8"]->value = true;
    $this->fields["9"] = "PBString";
    $this->fieldnames["9"] = "currency";
    $this->values["9"] = "";
    $this->values["9"] = new PBString();
    $this->values["9"]->value = "EUR";
    $this->fields["10"] = "ShopCustomerAddress";
    $this->fieldnames["10"] = "other_delivery_addresses";
    $this->values["10"] = array();
    $this->fields["11"] = "PBInt";
    $this->fieldnames["11"] = "preisgruppe";
    $this->values["11"] = "";
    $this->fields["12"] = "PBString";
    $this->fieldnames["12"] = "onetierarztnr";
    $this->values["12"] = "";
  }
  function deb_kred_id()
  {
    return $this->_get_value("1");
  }
  function set_deb_kred_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function address()
  {
    return $this->_get_value("2");
  }
  function set_address($value)
  {
    return $this->_set_value("2", $value);
  }
  function delivery_as_customer()
  {
    return $this->_get_value("3");
  }
  function set_delivery_as_customer($value)
  {
    return $this->_set_value("3", $value);
  }
  function delivery_address()
  {
    return $this->_get_value("4");
  }
  function set_delivery_address($value)
  {
    return $this->_set_value("4", $value);
  }
  function gebdat()
  {
    return $this->_get_value("5");
  }
  function set_gebdat($value)
  {
    return $this->_set_value("5", $value);
  }
  function verf()
  {
    return $this->_get_value("6");
  }
  function set_verf($value)
  {
    return $this->_set_value("6", $value);
  }
  function _customers_id()
  {
    return $this->_get_value("7");
  }
  function set__customers_id($value)
  {
    return $this->_set_value("7", $value);
  }
  function print_brutto()
  {
    return $this->_get_value("8");
  }
  function set_print_brutto($value)
  {
    return $this->_set_value("8", $value);
  }
  function currency()
  {
    return $this->_get_value("9");
  }
  function set_currency($value)
  {
    return $this->_set_value("9", $value);
  }
  function other_delivery_addresses($offset)
  {
    return $this->_get_arr_value("10", $offset);
  }
  function add_other_delivery_addresses()
  {
    return $this->_add_arr_value("10");
  }
  function set_other_delivery_addresses($index, $value)
  {
    $this->_set_arr_value("10", $index, $value);
  }
  function remove_last_other_delivery_addresses()
  {
    $this->_remove_last_arr_value("10");
  }
  function other_delivery_addresses_size()
  {
    return $this->_get_arr_size("10");
  }
  function preisgruppe()
  {
    return $this->_get_value("11");
  }
  function set_preisgruppe($value)
  {
    return $this->_set_value("11", $value);
  }
  function onetierarztnr()
  {
    return $this->_get_value("12");
  }
  function set_onetierarztnr($value)
  {
    return $this->_set_value("12", $value);
  }
}
?>