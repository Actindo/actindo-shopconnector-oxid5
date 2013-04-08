<?php
class AttributesTranslation extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "language_code";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "name";
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
class ArtikelAttributesName extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "name_id";
    $this->values["1"] = "";
    $this->fields["2"] = "AttributesTranslation";
    $this->fieldnames["2"] = "translation";
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
  function set_translation($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_translation()
  {
    $this->_remove_last_arr_value("2");
  }
  function translation_size()
  {
    return $this->_get_arr_size("2");
  }
}
class ArtikelAttributesValues extends PBMessage
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
    $this->fields["3"] = "AttributesTranslation";
    $this->fieldnames["3"] = "translation";
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
  function set_translation($index, $value)
  {
    $this->_set_arr_value("3", $index, $value);
  }
  function remove_last_translation()
  {
    $this->_remove_last_arr_value("3");
  }
  function translation_size()
  {
    return $this->_get_arr_size("3");
  }
}
class ArtikelAttributesCombinationSimple extends PBMessage
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
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "attributes_model";
    $this->values["3"] = "";
    $this->fields["4"] = "PBDouble";
    $this->fieldnames["4"] = "options_values_price";
    $this->values["4"] = "";
    $this->values["4"] = new PBDouble();
    $this->values["4"]->value = 0;
    $this->fields["5"] = "PBDouble";
    $this->fieldnames["5"] = "options_values_weight";
    $this->values["5"] = "";
    $this->values["5"] = new PBDouble();
    $this->values["5"]->value = 0;
    $this->fields["6"] = "PBDouble";
    $this->fieldnames["6"] = "l_bestand";
    $this->values["6"] = "";
    $this->values["6"] = new PBDouble();
    $this->values["6"]->value = 0;
    $this->fields["7"] = "PBInt";
    $this->fieldnames["7"] = "sort_order";
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
?>