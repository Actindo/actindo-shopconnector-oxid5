<?php
class ArtikelWeightUnit extends PBEnum
{
  const kg  = 0;
  const g  = 1;
  const t  = 2;
}
class ArtikelPriceBracket_ArtikelPreisStaffel extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBDouble";
    $this->fieldnames["1"] = "preis_gruppe";
    $this->values["1"] = "";
    $this->fields["2"] = "PBDouble";
    $this->fieldnames["2"] = "preis_range";
    $this->values["2"] = "";
  }
  function preis_gruppe()
  {
    return $this->_get_value("1");
  }
  function set_preis_gruppe($value)
  {
    return $this->_set_value("1", $value);
  }
  function preis_range()
  {
    return $this->_get_value("2");
  }
  function set_preis_range($value)
  {
    return $this->_set_value("2", $value);
  }
}
class ArtikelPriceBracket extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "preisgruppe";
    $this->values["1"] = "";
    $this->fields["2"] = "PBBool";
    $this->fieldnames["2"] = "is_brutto";
    $this->values["2"] = "";
    $this->fields["3"] = "PBDouble";
    $this->fieldnames["3"] = "grundpreis";
    $this->values["3"] = "";
    $this->fields["4"] = "ArtikelPriceBracket_ArtikelPreisStaffel";
    $this->fieldnames["4"] = "preisstaffeln";
    $this->values["4"] = array();
  }
  function preisgruppe()
  {
    return $this->_get_value("1");
  }
  function set_preisgruppe($value)
  {
    return $this->_set_value("1", $value);
  }
  function is_brutto()
  {
    return $this->_get_value("2");
  }
  function set_is_brutto($value)
  {
    return $this->_set_value("2", $value);
  }
  function grundpreis()
  {
    return $this->_get_value("3");
  }
  function set_grundpreis($value)
  {
    return $this->_set_value("3", $value);
  }
  function preisstaffeln($offset)
  {
    return $this->_get_arr_value("4", $offset);
  }
  function add_preisstaffeln()
  {
    return $this->_add_arr_value("4");
  }
  function set_preisstaffeln($index, $value)
  {
    $this->_set_arr_value("4", $index, $value);
  }
  function remove_last_preisstaffeln()
  {
    $this->_remove_last_arr_value("4");
  }
  function preisstaffeln_size()
  {
    return $this->_get_arr_size("4");
  }
}
class ArtikelImage_ArtikelImageDescription extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "language_code";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "image_title";
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
  function image_title()
  {
    return $this->_get_value("2");
  }
  function set_image_title($value)
  {
    return $this->_set_value("2", $value);
  }
}
class ArtikelImage extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "image_nr";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "image_name";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "image_type";
    $this->values["3"] = "";
    $this->fields["4"] = "PBBytes";
    $this->fieldnames["4"] = "image";
    $this->values["4"] = "";
    $this->fields["5"] = "PBString";
    $this->fieldnames["5"] = "image_subfolder";
    $this->values["5"] = "";
    $this->fields["6"] = "ArtikelImage_ArtikelImageDescription";
    $this->fieldnames["6"] = "image_descriptions";
    $this->values["6"] = array();
    $this->fields["7"] = "PBString";
    $this->fieldnames["7"] = "image_md5";
    $this->values["7"] = "";
  }
  function image_nr()
  {
    return $this->_get_value("1");
  }
  function set_image_nr($value)
  {
    return $this->_set_value("1", $value);
  }
  function image_name()
  {
    return $this->_get_value("2");
  }
  function set_image_name($value)
  {
    return $this->_set_value("2", $value);
  }
  function image_type()
  {
    return $this->_get_value("3");
  }
  function set_image_type($value)
  {
    return $this->_set_value("3", $value);
  }
  function image()
  {
    return $this->_get_value("4");
  }
  function set_image($value)
  {
    return $this->_set_value("4", $value);
  }
  function image_subfolder()
  {
    return $this->_get_value("5");
  }
  function set_image_subfolder($value)
  {
    return $this->_set_value("5", $value);
  }
  function image_descriptions($offset)
  {
    return $this->_get_arr_value("6", $offset);
  }
  function add_image_descriptions()
  {
    return $this->_add_arr_value("6");
  }
  function set_image_descriptions($index, $value)
  {
    $this->_set_arr_value("6", $index, $value);
  }
  function remove_last_image_descriptions()
  {
    $this->_remove_last_arr_value("6");
  }
  function image_descriptions_size()
  {
    return $this->_get_arr_size("6");
  }
  function image_md5()
  {
    return $this->_get_value("7");
  }
  function set_image_md5($value)
  {
    return $this->_set_value("7", $value);
  }
}
class ArtikelDescription extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "language_code";
    $this->values["1"] = "";
    $this->fields["2"] = "PBInt";
    $this->fieldnames["2"] = "language_id";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "products_name";
    $this->values["3"] = "";
    $this->fields["4"] = "PBString";
    $this->fieldnames["4"] = "products_description";
    $this->values["4"] = "";
    $this->fields["5"] = "PBString";
    $this->fieldnames["5"] = "products_short_description";
    $this->values["5"] = "";
    $this->fields["6"] = "PBString";
    $this->fieldnames["6"] = "products_keywords";
    $this->values["6"] = "";
    $this->fields["7"] = "PBString";
    $this->fieldnames["7"] = "products_meta_title";
    $this->values["7"] = "";
    $this->fields["8"] = "PBString";
    $this->fieldnames["8"] = "products_meta_description";
    $this->values["8"] = "";
    $this->fields["9"] = "PBString";
    $this->fieldnames["9"] = "products_meta_keywords";
    $this->values["9"] = "";
    $this->fields["10"] = "PBString";
    $this->fieldnames["10"] = "products_url";
    $this->values["10"] = "";
    $this->fields["11"] = "PBString";
    $this->fieldnames["11"] = "products_tags";
    $this->values["11"] = "";
    $this->fields["12"] = "PBString";
    $this->fieldnames["12"] = "products_mpn";
    $this->values["12"] = "";
  }
  function language_code()
  {
    return $this->_get_value("1");
  }
  function set_language_code($value)
  {
    return $this->_set_value("1", $value);
  }
  function language_id()
  {
    return $this->_get_value("2");
  }
  function set_language_id($value)
  {
    return $this->_set_value("2", $value);
  }
  function products_name()
  {
    return $this->_get_value("3");
  }
  function set_products_name($value)
  {
    return $this->_set_value("3", $value);
  }
  function products_description()
  {
    return $this->_get_value("4");
  }
  function set_products_description($value)
  {
    return $this->_set_value("4", $value);
  }
  function products_short_description()
  {
    return $this->_get_value("5");
  }
  function set_products_short_description($value)
  {
    return $this->_set_value("5", $value);
  }
  function products_keywords()
  {
    return $this->_get_value("6");
  }
  function set_products_keywords($value)
  {
    return $this->_set_value("6", $value);
  }
  function products_meta_title()
  {
    return $this->_get_value("7");
  }
  function set_products_meta_title($value)
  {
    return $this->_set_value("7", $value);
  }
  function products_meta_description()
  {
    return $this->_get_value("8");
  }
  function set_products_meta_description($value)
  {
    return $this->_set_value("8", $value);
  }
  function products_meta_keywords()
  {
    return $this->_get_value("9");
  }
  function set_products_meta_keywords($value)
  {
    return $this->_set_value("9", $value);
  }
  function products_url()
  {
    return $this->_get_value("10");
  }
  function set_products_url($value)
  {
    return $this->_set_value("10", $value);
  }
  function products_tags()
  {
    return $this->_get_value("11");
  }
  function set_products_tags($value)
  {
    return $this->_set_value("11", $value);
  }

  function products_mpn()
  {
    return $this->_get_value("12");
  }
  function set_products_mpn($value)
  {
    return $this->_set_value("12", $value);
  }
}
class ArtikelProperty extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "field_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "field_value";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "language_code";
    $this->values["3"] = "";
  }
  function field_id()
  {
    return $this->_get_value("1");
  }
  function set_field_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function field_value()
  {
    return $this->_get_value("2");
  }
  function set_field_value($value)
  {
    return $this->_set_value("2", $value);
  }
  function language_code()
  {
    return $this->_get_value("3");
  }
  function set_language_code($value)
  {
    return $this->_set_value("3", $value);
  }
}
class ArtikelContent_ArtikelContentType extends PBEnum
{
  const file  = 0;
  const link  = 1;
  const html  = 2;
}
class ArtikelContent extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "content_name";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "language_code";
    $this->values["2"] = "";
    $this->fields["3"] = "PBBytes";
    $this->fieldnames["3"] = "content";
    $this->values["3"] = "";
    $this->fields["4"] = "ArtikelContent_ArtikelContentType";
    $this->fieldnames["4"] = "type";
    $this->values["4"] = "";
    $this->fields["5"] = "PBString";
    $this->fieldnames["5"] = "content_target";
    $this->values["5"] = "";
    $this->fields["6"] = "PBString";
    $this->fieldnames["6"] = "content_file_name";
    $this->values["6"] = "";
    $this->fields["7"] = "PBString";
    $this->fieldnames["7"] = "content_file_type";
    $this->values["7"] = "";
    $this->fields["8"] = "PBString";
    $this->fieldnames["8"] = "content_file_md5";
    $this->values["8"] = "";
    $this->fields["9"] = "PBInt";
    $this->fieldnames["9"] = "content_file_size";
    $this->values["9"] = "";
  }
  function content_name()
  {
    return $this->_get_value("1");
  }
  function set_content_name($value)
  {
    return $this->_set_value("1", $value);
  }
  function language_code()
  {
    return $this->_get_value("2");
  }
  function set_language_code($value)
  {
    return $this->_set_value("2", $value);
  }
  function content()
  {
    return $this->_get_value("3");
  }
  function set_content($value)
  {
    return $this->_set_value("3", $value);
  }
  function type()
  {
    return $this->_get_value("4");
  }
  function set_type($value)
  {
    return $this->_set_value("4", $value);
  }
  function content_target()
  {
    return $this->_get_value("5");
  }
  function set_content_target($value)
  {
    return $this->_set_value("5", $value);
  }
  function content_file_name()
  {
    return $this->_get_value("6");
  }
  function set_content_file_name($value)
  {
    return $this->_set_value("6", $value);
  }
  function content_file_type()
  {
    return $this->_get_value("7");
  }
  function set_content_file_type($value)
  {
    return $this->_set_value("7", $value);
  }
  function content_file_md5()
  {
    return $this->_get_value("8");
  }
  function set_content_file_md5($value)
  {
    return $this->_set_value("8", $value);
  }
  function content_file_size()
  {
    return $this->_get_value("9");
  }
  function set_content_file_size($value)
  {
    return $this->_set_value("9", $value);
  }
}
?>