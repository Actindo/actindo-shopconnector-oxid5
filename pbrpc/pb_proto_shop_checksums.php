<?php
class ShopChecksumRequest extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "subdirectory";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "pattern";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "checksum_type";
    $this->values["3"] = "";
    $this->fields["4"] = "PBBool";
    $this->fieldnames["4"] = "recursive";
    $this->values["4"] = "";
  }
  function subdirectory()
  {
    return $this->_get_value("1");
  }
  function set_subdirectory($value)
  {
    return $this->_set_value("1", $value);
  }
  function pattern()
  {
    return $this->_get_value("2");
  }
  function set_pattern($value)
  {
    return $this->_set_value("2", $value);
  }
  function checksum_type()
  {
    return $this->_get_value("3");
  }
  function set_checksum_type($value)
  {
    return $this->_set_value("3", $value);
  }
  function recursive()
  {
    return $this->_get_value("4");
  }
  function set_recursive($value)
  {
    return $this->_set_value("4", $value);
  }
}
class FileChecksum extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "path";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "checksum";
    $this->values["2"] = "";
  }
  function path()
  {
    return $this->_get_value("1");
  }
  function set_path($value)
  {
    return $this->_set_value("1", $value);
  }
  function checksum()
  {
    return $this->_get_value("2");
  }
  function set_checksum($value)
  {
    return $this->_set_value("2", $value);
  }
}
class ShopChecksumResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "n_sums";
    $this->values["1"] = "";
    $this->fields["2"] = "FileChecksum";
    $this->fieldnames["2"] = "checksums";
    $this->values["2"] = array();
  }
  function n_sums()
  {
    return $this->_get_value("1");
  }
  function set_n_sums($value)
  {
    return $this->_set_value("1", $value);
  }
  function checksums($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_checksums()
  {
    return $this->_add_arr_value("2");
  }
  function set_checksums($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_checksums()
  {
    $this->_remove_last_arr_value("2");
  }
  function checksums_size()
  {
    return $this->_get_arr_size("2");
  }
}
?>