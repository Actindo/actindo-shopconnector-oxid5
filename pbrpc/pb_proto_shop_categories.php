<?php
class ShopCategory7 extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "categories_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "categories_name";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "parent_id";
    $this->values["3"] = "";
  }
  function categories_id()
  {
    return $this->_get_value("1");
  }
  function set_categories_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function categories_name()
  {
    return $this->_get_value("2");
  }
  function set_categories_name($value)
  {
    return $this->_set_value("2", $value);
  }
  function parent_id()
  {
    return $this->_get_value("3");
  }
  function set_parent_id($value)
  {
    return $this->_set_value("3", $value);
  }
}
class ShopCategory6 extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "categories_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "categories_name";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "parent_id";
    $this->values["3"] = "";
    $this->fields["4"] = "ShopCategory7";
    $this->fieldnames["4"] = "children";
    $this->values["4"] = array();
  }
  function categories_id()
  {
    return $this->_get_value("1");
  }
  function set_categories_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function categories_name()
  {
    return $this->_get_value("2");
  }
  function set_categories_name($value)
  {
    return $this->_set_value("2", $value);
  }
  function parent_id()
  {
    return $this->_get_value("3");
  }
  function set_parent_id($value)
  {
    return $this->_set_value("3", $value);
  }
  function children($offset)
  {
    return $this->_get_arr_value("4", $offset);
  }
  function add_children()
  {
    return $this->_add_arr_value("4");
  }
  function set_children($index, $value)
  {
    $this->_set_arr_value("4", $index, $value);
  }
  function remove_last_children()
  {
    $this->_remove_last_arr_value("4");
  }
  function children_size()
  {
    return $this->_get_arr_size("4");
  }
}
class ShopCategory5 extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "categories_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "categories_name";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "parent_id";
    $this->values["3"] = "";
    $this->fields["4"] = "ShopCategory6";
    $this->fieldnames["4"] = "children";
    $this->values["4"] = array();
  }
  function categories_id()
  {
    return $this->_get_value("1");
  }
  function set_categories_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function categories_name()
  {
    return $this->_get_value("2");
  }
  function set_categories_name($value)
  {
    return $this->_set_value("2", $value);
  }
  function parent_id()
  {
    return $this->_get_value("3");
  }
  function set_parent_id($value)
  {
    return $this->_set_value("3", $value);
  }
  function children($offset)
  {
    return $this->_get_arr_value("4", $offset);
  }
  function add_children()
  {
    return $this->_add_arr_value("4");
  }
  function set_children($index, $value)
  {
    $this->_set_arr_value("4", $index, $value);
  }
  function remove_last_children()
  {
    $this->_remove_last_arr_value("4");
  }
  function children_size()
  {
    return $this->_get_arr_size("4");
  }
}
class ShopCategory4 extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "categories_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "categories_name";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "parent_id";
    $this->values["3"] = "";
    $this->fields["4"] = "ShopCategory5";
    $this->fieldnames["4"] = "children";
    $this->values["4"] = array();
  }
  function categories_id()
  {
    return $this->_get_value("1");
  }
  function set_categories_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function categories_name()
  {
    return $this->_get_value("2");
  }
  function set_categories_name($value)
  {
    return $this->_set_value("2", $value);
  }
  function parent_id()
  {
    return $this->_get_value("3");
  }
  function set_parent_id($value)
  {
    return $this->_set_value("3", $value);
  }
  function children($offset)
  {
    return $this->_get_arr_value("4", $offset);
  }
  function add_children()
  {
    return $this->_add_arr_value("4");
  }
  function set_children($index, $value)
  {
    $this->_set_arr_value("4", $index, $value);
  }
  function remove_last_children()
  {
    $this->_remove_last_arr_value("4");
  }
  function children_size()
  {
    return $this->_get_arr_size("4");
  }
}
class ShopCategory3 extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "categories_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "categories_name";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "parent_id";
    $this->values["3"] = "";
    $this->fields["4"] = "ShopCategory4";
    $this->fieldnames["4"] = "children";
    $this->values["4"] = array();
  }
  function categories_id()
  {
    return $this->_get_value("1");
  }
  function set_categories_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function categories_name()
  {
    return $this->_get_value("2");
  }
  function set_categories_name($value)
  {
    return $this->_set_value("2", $value);
  }
  function parent_id()
  {
    return $this->_get_value("3");
  }
  function set_parent_id($value)
  {
    return $this->_set_value("3", $value);
  }
  function children($offset)
  {
    return $this->_get_arr_value("4", $offset);
  }
  function add_children()
  {
    return $this->_add_arr_value("4");
  }
  function set_children($index, $value)
  {
    $this->_set_arr_value("4", $index, $value);
  }
  function remove_last_children()
  {
    $this->_remove_last_arr_value("4");
  }
  function children_size()
  {
    return $this->_get_arr_size("4");
  }
}
class ShopCategory2 extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "categories_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "categories_name";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "parent_id";
    $this->values["3"] = "";
    $this->fields["4"] = "ShopCategory3";
    $this->fieldnames["4"] = "children";
    $this->values["4"] = array();
  }
  function categories_id()
  {
    return $this->_get_value("1");
  }
  function set_categories_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function categories_name()
  {
    return $this->_get_value("2");
  }
  function set_categories_name($value)
  {
    return $this->_set_value("2", $value);
  }
  function parent_id()
  {
    return $this->_get_value("3");
  }
  function set_parent_id($value)
  {
    return $this->_set_value("3", $value);
  }
  function children($offset)
  {
    return $this->_get_arr_value("4", $offset);
  }
  function add_children()
  {
    return $this->_add_arr_value("4");
  }
  function set_children($index, $value)
  {
    $this->_set_arr_value("4", $index, $value);
  }
  function remove_last_children()
  {
    $this->_remove_last_arr_value("4");
  }
  function children_size()
  {
    return $this->_get_arr_size("4");
  }
}
class ShopCategory1 extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "categories_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "categories_name";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "parent_id";
    $this->values["3"] = "";
    $this->fields["4"] = "ShopCategory2";
    $this->fieldnames["4"] = "children";
    $this->values["4"] = array();
  }
  function categories_id()
  {
    return $this->_get_value("1");
  }
  function set_categories_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function categories_name()
  {
    return $this->_get_value("2");
  }
  function set_categories_name($value)
  {
    return $this->_set_value("2", $value);
  }
  function parent_id()
  {
    return $this->_get_value("3");
  }
  function set_parent_id($value)
  {
    return $this->_set_value("3", $value);
  }
  function children($offset)
  {
    return $this->_get_arr_value("4", $offset);
  }
  function add_children()
  {
    return $this->_add_arr_value("4");
  }
  function set_children($index, $value)
  {
    $this->_set_arr_value("4", $index, $value);
  }
  function remove_last_children()
  {
    $this->_remove_last_arr_value("4");
  }
  function children_size()
  {
    return $this->_get_arr_size("4");
  }
}
class ShopCategory extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "categories_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "categories_name";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "parent_id";
    $this->values["3"] = "";
    $this->fields["4"] = "ShopCategory1";
    $this->fieldnames["4"] = "children";
    $this->values["4"] = array();
  }
  function categories_id()
  {
    return $this->_get_value("1");
  }
  function set_categories_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function categories_name()
  {
    return $this->_get_value("2");
  }
  function set_categories_name($value)
  {
    return $this->_set_value("2", $value);
  }
  function parent_id()
  {
    return $this->_get_value("3");
  }
  function set_parent_id($value)
  {
    return $this->_set_value("3", $value);
  }
  function children($offset)
  {
    return $this->_get_arr_value("4", $offset);
  }
  function add_children()
  {
    return $this->_add_arr_value("4");
  }
  function set_children($index, $value)
  {
    $this->_set_arr_value("4", $index, $value);
  }
  function remove_last_children()
  {
    $this->_remove_last_arr_value("4");
  }
  function children_size()
  {
    return $this->_get_arr_size("4");
  }
}
class CategoryData_CategoryDataTranslation extends PBMessage
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
class CategoryData extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "tmp";
    $this->values["1"] = "";
    $this->fields["2"] = "CategoryData_CategoryDataTranslation";
    $this->fieldnames["2"] = "description";
    $this->values["2"] = array();
  }
  function tmp()
  {
    return $this->_get_value("1");
  }
  function set_tmp($value)
  {
    return $this->_set_value("1", $value);
  }
  function description($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_description()
  {
    return $this->_add_arr_value("2");
  }
  function set_description($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_description()
  {
    $this->_remove_last_arr_value("2");
  }
  function description_size()
  {
    return $this->_get_arr_size("2");
  }
}
class ShopCategoriesResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "categories_count";
    $this->values["1"] = "";
    $this->fields["2"] = "ShopCategory";
    $this->fieldnames["2"] = "categories";
    $this->values["2"] = array();
  }
  function categories_count()
  {
    return $this->_get_value("1");
  }
  function set_categories_count($value)
  {
    return $this->_set_value("1", $value);
  }
  function categories($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_categories()
  {
    return $this->_add_arr_value("2");
  }
  function set_categories($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_categories()
  {
    $this->_remove_last_arr_value("2");
  }
  function categories_size()
  {
    return $this->_get_arr_size("2");
  }
}
class ShopCategoryActionRequest extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "point";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "id";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "parent_id";
    $this->values["3"] = "";
    $this->fields["4"] = "PBString";
    $this->fieldnames["4"] = "after_id";
    $this->values["4"] = "";
    $this->fields["5"] = "CategoryData";
    $this->fieldnames["5"] = "data";
    $this->values["5"] = "";
  }
  function point()
  {
    return $this->_get_value("1");
  }
  function set_point($value)
  {
    return $this->_set_value("1", $value);
  }
  function id()
  {
    return $this->_get_value("2");
  }
  function set_id($value)
  {
    return $this->_set_value("2", $value);
  }
  function parent_id()
  {
    return $this->_get_value("3");
  }
  function set_parent_id($value)
  {
    return $this->_set_value("3", $value);
  }
  function after_id()
  {
    return $this->_get_value("4");
  }
  function set_after_id($value)
  {
    return $this->_set_value("4", $value);
  }
  function data()
  {
    return $this->_get_value("5");
  }
  function set_data($value)
  {
    return $this->_set_value("5", $value);
  }
}
class ShopCategoryActionResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBBool";
    $this->fieldnames["1"] = "ok";
    $this->values["1"] = "";
    $this->fields["2"] = "PBInt";
    $this->fieldnames["2"] = "errno";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "error";
    $this->values["3"] = "";
    $this->fields["4"] = "PBString";
    $this->fieldnames["4"] = "id";
    $this->values["4"] = "";
  }
  function ok()
  {
    return $this->_get_value("1");
  }
  function set_ok($value)
  {
    return $this->_set_value("1", $value);
  }
  function errno()
  {
    return $this->_get_value("2");
  }
  function set_errno($value)
  {
    return $this->_set_value("2", $value);
  }
  function error()
  {
    return $this->_get_value("3");
  }
  function set_error($value)
  {
    return $this->_set_value("3", $value);
  }
  function id()
  {
    return $this->_get_value("4");
  }
  function set_id($value)
  {
    return $this->_set_value("4", $value);
  }
}
?>