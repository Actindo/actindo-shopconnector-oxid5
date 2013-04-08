<?php
class Request extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "method";
    $this->values["1"] = "";
    $this->fields["2"] = "PBBytes";
    $this->fieldnames["2"] = "serialized_request";
    $this->values["2"] = "";
    $this->fields["3"] = "PBInt";
    $this->fieldnames["3"] = "id";
    $this->values["3"] = "";
  }
  function method()
  {
    return $this->_get_value("1");
  }
  function set_method($value)
  {
    return $this->_set_value("1", $value);
  }
  function serialized_request()
  {
    return $this->_get_value("2");
  }
  function set_serialized_request($value)
  {
    return $this->_set_value("2", $value);
  }
  function id()
  {
    return $this->_get_value("3");
  }
  function set_id($value)
  {
    return $this->_set_value("3", $value);
  }
}
class Error_ErrorType extends PBEnum
{
  const APPLICATION  = 0;
  const MESSAGE  = 1;
}
class Error extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBSignedInt";
    $this->fieldnames["1"] = "code";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "text";
    $this->values["2"] = "";
    $this->fields["3"] = "Error_ErrorType";
    $this->fieldnames["3"] = "error_type";
    $this->values["3"] = "";
  }
  function code()
  {
    return $this->_get_value("1");
  }
  function set_code($value)
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
  function error_type()
  {
    return $this->_get_value("3");
  }
  function set_error_type($value)
  {
    return $this->_set_value("3", $value);
  }
}
class Response extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBBytes";
    $this->fieldnames["1"] = "serialized_response";
    $this->values["1"] = "";
    $this->fields["2"] = "Error";
    $this->fieldnames["2"] = "error";
    $this->values["2"] = "";
    $this->fields["3"] = "PBInt";
    $this->fieldnames["3"] = "id";
    $this->values["3"] = "";
    $this->fields["4"] = "PBBytes";
    $this->fieldnames["4"] = "debug_errors";
    $this->values["4"] = "";
    $this->fields["5"] = "PBBytes";
    $this->fieldnames["5"] = "debug_output";
    $this->values["5"] = "";
  }
  function serialized_response()
  {
    return $this->_get_value("1");
  }
  function set_serialized_response($value)
  {
    return $this->_set_value("1", $value);
  }
  function error()
  {
    return $this->_get_value("2");
  }
  function set_error($value)
  {
    return $this->_set_value("2", $value);
  }
  function id()
  {
    return $this->_get_value("3");
  }
  function set_id($value)
  {
    return $this->_set_value("3", $value);
  }
  function debug_errors()
  {
    return $this->_get_value("4");
  }
  function set_debug_errors($value)
  {
    return $this->_set_value("4", $value);
  }
  function debug_output()
  {
    return $this->_get_value("5");
  }
  function set_debug_output($value)
  {
    return $this->_set_value("5", $value);
  }
}
class MethodSignature extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "method_name";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "request_message_name";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "response_message_name";
    $this->values["3"] = "";
  }
  function method_name()
  {
    return $this->_get_value("1");
  }
  function set_method_name($value)
  {
    return $this->_set_value("1", $value);
  }
  function request_message_name()
  {
    return $this->_get_value("2");
  }
  function set_request_message_name($value)
  {
    return $this->_set_value("2", $value);
  }
  function response_message_name()
  {
    return $this->_get_value("3");
  }
  function set_response_message_name($value)
  {
    return $this->_set_value("3", $value);
  }
}
class ListMethodsResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "method_count";
    $this->values["1"] = "";
    $this->fields["2"] = "MethodSignature";
    $this->fieldnames["2"] = "method_list";
    $this->values["2"] = array();
  }
  function method_count()
  {
    return $this->_get_value("1");
  }
  function set_method_count($value)
  {
    return $this->_set_value("1", $value);
  }
  function method_list($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_method_list()
  {
    return $this->_add_arr_value("2");
  }
  function set_method_list($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_method_list()
  {
    $this->_remove_last_arr_value("2");
  }
  function method_list_size()
  {
    return $this->_get_arr_size("2");
  }
}
?>