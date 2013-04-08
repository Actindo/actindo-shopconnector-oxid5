<?php
require_once( "pb_proto_shop_customer_address.php" );
require_once( "pb_proto_search_query.php" );
class ShopCustomerSetDebKredIdRequest extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "customer_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBInt";
    $this->fieldnames["2"] = "deb_kred_id";
    $this->values["2"] = "";
  }
  function customer_id()
  {
    return $this->_get_value("1");
  }
  function set_customer_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function deb_kred_id()
  {
    return $this->_get_value("2");
  }
  function set_deb_kred_id($value)
  {
    return $this->_set_value("2", $value);
  }
}
class ShopCustomerSetDebKredIdResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "customer_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBInt";
    $this->fieldnames["2"] = "deb_kred_id";
    $this->values["2"] = "";
  }
  function customer_id()
  {
    return $this->_get_value("1");
  }
  function set_customer_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function deb_kred_id()
  {
    return $this->_get_value("2");
  }
  function set_deb_kred_id($value)
  {
    return $this->_set_value("2", $value);
  }
}
class ShopCustomersListRequest extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "tmp";
    $this->values["1"] = "";
    $this->fields["2"] = "PBInt";
    $this->fieldnames["2"] = "just_list";
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
  function just_list()
  {
    return $this->_get_value("2");
  }
  function set_just_list($value)
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
class ShopCustomersListResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "count";
    $this->values["1"] = "";
    $this->fields["2"] = "ShopCustomer";
    $this->fieldnames["2"] = "customers";
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
  function customers($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_customers()
  {
    return $this->_add_arr_value("2");
  }
  function set_customers($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_customers()
  {
    $this->_remove_last_arr_value("2");
  }
  function customers_size()
  {
    return $this->_get_arr_size("2");
  }
}
class ShopCustomersCountRequest extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "tmp";
    $this->values["1"] = "";
  }
  function tmp()
  {
    return $this->_get_value("1");
  }
  function set_tmp($value)
  {
    return $this->_set_value("1", $value);
  }
}
class ShopCustomersCountResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "count";
    $this->values["1"] = "";
    $this->fields["2"] = "PBInt";
    $this->fieldnames["2"] = "max_deb_kred_id";
    $this->values["2"] = "";
  }
  function count()
  {
    return $this->_get_value("1");
  }
  function set_count($value)
  {
    return $this->_set_value("1", $value);
  }
  function max_deb_kred_id()
  {
    return $this->_get_value("2");
  }
  function set_max_deb_kred_id($value)
  {
    return $this->_set_value("2", $value);
  }
}
?>