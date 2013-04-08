<?php
class ShopPingResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "pong";
    $this->values["1"] = "";
  }
  function pong()
  {
    return $this->_get_value("1");
  }
  function set_pong($value)
  {
    return $this->_set_value("1", $value);
  }
}
?>