<?php
class ShopTimeResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "time_server";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "gmtime_server";
    $this->values["2"] = "";
    $this->fields["3"] = "PBInt";
    $this->fieldnames["3"] = "diff_seconds";
    $this->values["3"] = "";
    $this->fields["4"] = "PBString";
    $this->fieldnames["4"] = "diff";
    $this->values["4"] = "";
    $this->fields["5"] = "PBString";
    $this->fieldnames["5"] = "time_database";
    $this->values["5"] = "";
    $this->fields["6"] = "PBString";
    $this->fieldnames["6"] = "gmtime_database";
    $this->values["6"] = "";
  }
  function time_server()
  {
    return $this->_get_value("1");
  }
  function set_time_server($value)
  {
    return $this->_set_value("1", $value);
  }
  function gmtime_server()
  {
    return $this->_get_value("2");
  }
  function set_gmtime_server($value)
  {
    return $this->_set_value("2", $value);
  }
  function diff_seconds()
  {
    return $this->_get_value("3");
  }
  function set_diff_seconds($value)
  {
    return $this->_set_value("3", $value);
  }
  function diff()
  {
    return $this->_get_value("4");
  }
  function set_diff($value)
  {
    return $this->_set_value("4", $value);
  }
  function time_database()
  {
    return $this->_get_value("5");
  }
  function set_time_database($value)
  {
    return $this->_set_value("5", $value);
  }
  function gmtime_database()
  {
    return $this->_get_value("6");
  }
  function set_gmtime_database($value)
  {
    return $this->_set_value("6", $value);
  }
}
?>