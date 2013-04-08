<?php
class SearchQueryFilterData_FilterType extends PBEnum
{
  const DateFilter  = 1;
  const ListFilter  = 2;
  const BooleanFilter  = 3;
  const StringFilter  = 4;
  const NumericFilter  = 5;
}
class SearchQueryFilterData_Comparison extends PBEnum
{
  const lt  = 1;
  const le  = 2;
  const gt  = 3;
  const ge  = 4;
  const eq  = 5;
  const ne  = 6;
}
class SearchQueryFilterData extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "SearchQueryFilterData_FilterType";
    $this->fieldnames["1"] = "type";
    $this->values["1"] = "";
    $this->fields["2"] = "SearchQueryFilterData_Comparison";
    $this->fieldnames["2"] = "comparison";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "value";
    $this->values["3"] = "";
  }
  function type()
  {
    return $this->_get_value("1");
  }
  function set_type($value)
  {
    return $this->_set_value("1", $value);
  }
  function comparison()
  {
    return $this->_get_value("2");
  }
  function set_comparison($value)
  {
    return $this->_set_value("2", $value);
  }
  function value()
  {
    return $this->_get_value("3");
  }
  function set_value($value)
  {
    return $this->_set_value("3", $value);
  }
}
class SearchQueryFilter extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "field";
    $this->values["1"] = "";
    $this->fields["2"] = "SearchQueryFilterData";
    $this->fieldnames["2"] = "data";
    $this->values["2"] = "";
  }
  function field()
  {
    return $this->_get_value("1");
  }
  function set_field($value)
  {
    return $this->_set_value("1", $value);
  }
  function data()
  {
    return $this->_get_value("2");
  }
  function set_data($value)
  {
    return $this->_set_value("2", $value);
  }
}
class SearchQuery_LimitType extends PBEnum
{
  const NONE  = 0;
  const PAGENO  = 1;
  const START_LIMIT  = 2;
}
class SearchQuery extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "SearchQuery_LimitType";
    $this->fieldnames["1"] = "limit_type";
    $this->values["1"] = "";
    $this->fields["2"] = "PBInt";
    $this->fieldnames["2"] = "pageno";
    $this->values["2"] = "";
    $this->fields["3"] = "PBInt";
    $this->fieldnames["3"] = "n_per_page";
    $this->values["3"] = "";
    $this->fields["4"] = "PBInt";
    $this->fieldnames["4"] = "start";
    $this->values["4"] = "";
    $this->fields["5"] = "PBInt";
    $this->fieldnames["5"] = "limit";
    $this->values["5"] = "";
    $this->fields["6"] = "PBString";
    $this->fieldnames["6"] = "sortColName";
    $this->values["6"] = "";
    $this->fields["7"] = "PBString";
    $this->fieldnames["7"] = "sortOrder";
    $this->values["7"] = "";
    $this->fields["8"] = "PBString";
    $this->fieldnames["8"] = "searchText";
    $this->values["8"] = "";
    $this->fields["9"] = "PBString";
    $this->fieldnames["9"] = "searchColumns";
    $this->values["9"] = "";
    $this->fields["10"] = "SearchQueryFilter";
    $this->fieldnames["10"] = "filter";
    $this->values["10"] = array();
  }
  function limit_type()
  {
    return $this->_get_value("1");
  }
  function set_limit_type($value)
  {
    return $this->_set_value("1", $value);
  }
  function pageno()
  {
    return $this->_get_value("2");
  }
  function set_pageno($value)
  {
    return $this->_set_value("2", $value);
  }
  function n_per_page()
  {
    return $this->_get_value("3");
  }
  function set_n_per_page($value)
  {
    return $this->_set_value("3", $value);
  }
  function start()
  {
    return $this->_get_value("4");
  }
  function set_start($value)
  {
    return $this->_set_value("4", $value);
  }
  function limit()
  {
    return $this->_get_value("5");
  }
  function set_limit($value)
  {
    return $this->_set_value("5", $value);
  }
  function sortColName()
  {
    return $this->_get_value("6");
  }
  function set_sortColName($value)
  {
    return $this->_set_value("6", $value);
  }
  function sortOrder()
  {
    return $this->_get_value("7");
  }
  function set_sortOrder($value)
  {
    return $this->_set_value("7", $value);
  }
  function searchText()
  {
    return $this->_get_value("8");
  }
  function set_searchText($value)
  {
    return $this->_set_value("8", $value);
  }
  function searchColumns()
  {
    return $this->_get_value("9");
  }
  function set_searchColumns($value)
  {
    return $this->_set_value("9", $value);
  }
  function filter($offset)
  {
    return $this->_get_arr_value("10", $offset);
  }
  function add_filter()
  {
    return $this->_add_arr_value("10");
  }
  function set_filter($index, $value)
  {
    $this->_set_arr_value("10", $index, $value);
  }
  function remove_last_filter()
  {
    $this->_remove_last_arr_value("10");
  }
  function filter_size()
  {
    return $this->_get_arr_size("10");
  }
}
?>