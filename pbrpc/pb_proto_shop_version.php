<?php
class ShopVersionResponse_Capability extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "name";
    $this->values["1"] = "";
    $this->fields["2"] = "PBBool";
    $this->fieldnames["2"] = "capable";
    $this->values["2"] = "";
  }
  function name()
  {
    return $this->_get_value("1");
  }
  function set_name($value)
  {
    return $this->_set_value("1", $value);
  }
  function capable()
  {
    return $this->_get_value("2");
  }
  function set_capable($value)
  {
    return $this->_set_value("2", $value);
  }
}
class ShopVersionResponse_PhpExtension extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "name";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "version";
    $this->values["2"] = "";
  }
  function name()
  {
    return $this->_get_value("1");
  }
  function set_name($value)
  {
    return $this->_set_value("1", $value);
  }
  function version()
  {
    return $this->_get_value("2");
  }
  function set_version($value)
  {
    return $this->_set_value("2", $value);
  }
}
class ShopVersionResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "xmlrpc_server_revision";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "interface_type";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "shop_type";
    $this->values["3"] = "";
    $this->fields["4"] = "PBString";
    $this->fieldnames["4"] = "shop_version";
    $this->values["4"] = "";
    $this->fields["5"] = "PBString";
    $this->fieldnames["5"] = "revision";
    $this->values["5"] = "";
    $this->fields["6"] = "PBString";
    $this->fieldnames["6"] = "protocol_version";
    $this->values["6"] = "";
    $this->fields["7"] = "PBString";
    $this->fieldnames["7"] = "default_charset";
    $this->values["7"] = "";
    $this->fields["8"] = "ShopVersionResponse_Capability";
    $this->fieldnames["8"] = "capabilities";
    $this->values["8"] = array();
    $this->fields["9"] = "PBString";
    $this->fieldnames["9"] = "php_version";
    $this->values["9"] = "";
    $this->fields["10"] = "PBString";
    $this->fieldnames["10"] = "zend_version";
    $this->values["10"] = "";
    $this->fields["11"] = "PBString";
    $this->fieldnames["11"] = "cpuinfo";
    $this->values["11"] = "";
    $this->fields["12"] = "PBString";
    $this->fieldnames["12"] = "meminfo";
    $this->values["12"] = "";
    $this->fields["13"] = "PBBytes";
    $this->fieldnames["13"] = "phpinfo";
    $this->values["13"] = "";
    $this->fields["14"] = "ShopVersionResponse_PhpExtension";
    $this->fieldnames["14"] = "extensions";
    $this->values["14"] = array();
  }
  function xmlrpc_server_revision()
  {
    return $this->_get_value("1");
  }
  function set_xmlrpc_server_revision($value)
  {
    return $this->_set_value("1", $value);
  }
  function interface_type()
  {
    return $this->_get_value("2");
  }
  function set_interface_type($value)
  {
    return $this->_set_value("2", $value);
  }
  function shop_type()
  {
    return $this->_get_value("3");
  }
  function set_shop_type($value)
  {
    return $this->_set_value("3", $value);
  }
  function shop_version()
  {
    return $this->_get_value("4");
  }
  function set_shop_version($value)
  {
    return $this->_set_value("4", $value);
  }
  function revision()
  {
    return $this->_get_value("5");
  }
  function set_revision($value)
  {
    return $this->_set_value("5", $value);
  }
  function protocol_version()
  {
    return $this->_get_value("6");
  }
  function set_protocol_version($value)
  {
    return $this->_set_value("6", $value);
  }
  function default_charset()
  {
    return $this->_get_value("7");
  }
  function set_default_charset($value)
  {
    return $this->_set_value("7", $value);
  }
  function capabilities($offset)
  {
    return $this->_get_arr_value("8", $offset);
  }
  function add_capabilities()
  {
    return $this->_add_arr_value("8");
  }
  function set_capabilities($index, $value)
  {
    $this->_set_arr_value("8", $index, $value);
  }
  function remove_last_capabilities()
  {
    $this->_remove_last_arr_value("8");
  }
  function capabilities_size()
  {
    return $this->_get_arr_size("8");
  }
  function php_version()
  {
    return $this->_get_value("9");
  }
  function set_php_version($value)
  {
    return $this->_set_value("9", $value);
  }
  function zend_version()
  {
    return $this->_get_value("10");
  }
  function set_zend_version($value)
  {
    return $this->_set_value("10", $value);
  }
  function cpuinfo()
  {
    return $this->_get_value("11");
  }
  function set_cpuinfo($value)
  {
    return $this->_set_value("11", $value);
  }
  function meminfo()
  {
    return $this->_get_value("12");
  }
  function set_meminfo($value)
  {
    return $this->_set_value("12", $value);
  }
  function phpinfo()
  {
    return $this->_get_value("13");
  }
  function set_phpinfo($value)
  {
    return $this->_set_value("13", $value);
  }
  function extensions($offset)
  {
    return $this->_get_arr_value("14", $offset);
  }
  function add_extensions()
  {
    return $this->_add_arr_value("14");
  }
  function set_extensions($index, $value)
  {
    $this->_set_arr_value("14", $index, $value);
  }
  function remove_last_extensions()
  {
    $this->_remove_last_arr_value("14");
  }
  function extensions_size()
  {
    return $this->_get_arr_size("14");
  }
}
?>