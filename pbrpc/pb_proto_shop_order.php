<?php
require_once( "pb_proto_shop_customer_address.php" );
require_once( "pb_proto_search_query.php" );
class ShopOrdersCountResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "count";
    $this->values["1"] = "";
    $this->fields["2"] = "PBInt";
    $this->fieldnames["2"] = "max_order_id";
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
  function max_order_id()
  {
    return $this->_get_value("2");
  }
  function set_max_order_id($value)
  {
    return $this->_set_value("2", $value);
  }
}
class Payment_CC extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "cr_type";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "cr_nameoncard";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "cr_nr";
    $this->values["3"] = "";
    $this->fields["4"] = "PBString";
    $this->fieldnames["4"] = "cr_valid_to";
    $this->values["4"] = "";
    $this->fields["5"] = "PBString";
    $this->fieldnames["5"] = "cr_cvv";
    $this->values["5"] = "";
    $this->fields["6"] = "PBString";
    $this->fieldnames["6"] = "payment_provider";
    $this->values["6"] = "";
    $this->fields["7"] = "PBString";
    $this->fieldnames["7"] = "payment_provider_trx_no";
    $this->values["7"] = "";
  }
  function cr_type()
  {
    return $this->_get_value("1");
  }
  function set_cr_type($value)
  {
    return $this->_set_value("1", $value);
  }
  function cr_nameoncard()
  {
    return $this->_get_value("2");
  }
  function set_cr_nameoncard($value)
  {
    return $this->_set_value("2", $value);
  }
  function cr_nr()
  {
    return $this->_get_value("3");
  }
  function set_cr_nr($value)
  {
    return $this->_set_value("3", $value);
  }
  function cr_valid_to()
  {
    return $this->_get_value("4");
  }
  function set_cr_valid_to($value)
  {
    return $this->_set_value("4", $value);
  }
  function cr_cvv()
  {
    return $this->_get_value("5");
  }
  function set_cr_cvv($value)
  {
    return $this->_set_value("5", $value);
  }
  function payment_provider()
  {
    return $this->_get_value("6");
  }
  function set_payment_provider($value)
  {
    return $this->_set_value("6", $value);
  }
  function payment_provider_trx_no()
  {
    return $this->_get_value("7");
  }
  function set_payment_provider_trx_no($value)
  {
    return $this->_set_value("7", $value);
  }
}
class Payment_L extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBBool";
    $this->fieldnames["1"] = "address_iban";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "kto";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "blz";
    $this->values["3"] = "";
    $this->fields["4"] = "PBString";
    $this->fieldnames["4"] = "iban";
    $this->values["4"] = "";
    $this->fields["5"] = "PBString";
    $this->fieldnames["5"] = "bic";
    $this->values["5"] = "";
    $this->fields["6"] = "PBString";
    $this->fieldnames["6"] = "kto_inhaber";
    $this->values["6"] = "";

    $this->fields['7']     = 'PBString';
    $this->fieldnames['7'] = 'swift';
    $this->values['7']     = '';
  }
  function address_iban()
  {
    return $this->_get_value("1");
  }
  function set_address_iban($value)
  {
    return $this->_set_value("1", $value);
  }
  function kto()
  {
    return $this->_get_value("2");
  }
  function set_kto($value)
  {
    return $this->_set_value("2", $value);
  }
  function blz()
  {
    return $this->_get_value("3");
  }
  function set_blz($value)
  {
    return $this->_set_value("3", $value);
  }
  function iban()
  {
    return $this->_get_value("4");
  }
  function set_iban($value)
  {
    return $this->_set_value("4", $value);
  }
  function bic()
  {
    return $this->_get_value("5");
  }
  function set_bic($value)
  {
    return $this->_set_value("5", $value);
  }
  function kto_inhaber()
  {
    return $this->_get_value("6");
  }
  function set_kto_inhaber($value)
  {
    return $this->_set_value("6", $value);
  }

  function swift()
  {
      return $this->_get_value('7');
  }
  function set_swift($value)
  {
      return $this->_set_value('7', $value);
  }
}
class Payment_PP extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "email";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "trx_no";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "type";
    $this->values["3"] = "";
    $this->values["3"] = new PBString();
    $this->values["3"]->value = "payment";
    $this->fields["4"] = "PBString";
    $this->fieldnames["4"] = "payer_id";
    $this->values["4"] = "";
  }
  function email()
  {
    return $this->_get_value("1");
  }
  function set_email($value)
  {
    return $this->_set_value("1", $value);
  }
  function trx_no()
  {
    return $this->_get_value("2");
  }
  function set_trx_no($value)
  {
    return $this->_set_value("2", $value);
  }
  function type()
  {
    return $this->_get_value("3");
  }
  function set_type($value)
  {
    return $this->_set_value("3", $value);
  }
  function payer_id()
  {
    return $this->_get_value("4");
  }
  function set_payer_id($value)
  {
    return $this->_set_value("4", $value);
  }
}
class Payment_Factoring extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "recipient";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "currencyCode";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "bankCode";
    $this->values["3"] = "";
    $this->fields["4"] = "PBString";
    $this->fieldnames["4"] = "accountNumber";
    $this->values["4"] = "";
    $this->fields["5"] = "PBString";
    $this->fieldnames["5"] = "bankName";
    $this->values["5"] = "";
    $this->fields["6"] = "PBString";
    $this->fieldnames["6"] = "bic";
    $this->values["6"] = "";
    $this->fields["7"] = "PBString";
    $this->fieldnames["7"] = "iban";
    $this->values["7"] = "";
    $this->fields["8"] = "PBString";
    $this->fieldnames["8"] = "reference";
    $this->values["8"] = "";
    $this->fields["9"] = "PBDouble";
    $this->fieldnames["9"] = "amount";
    $this->values["9"] = "";
    $this->fields["10"] = "PBString";
    $this->fieldnames["10"] = "note";
    $this->values["10"] = "";
    $this->fields["11"] = "PBString";
    $this->fieldnames["11"] = "legalNote";
    $this->values["11"] = "";
  }
  function recipient()
  {
    return $this->_get_value("1");
  }
  function set_recipient($value)
  {
    return $this->_set_value("1", $value);
  }
  function currencyCode()
  {
    return $this->_get_value("2");
  }
  function set_currencyCode($value)
  {
    return $this->_set_value("2", $value);
  }
  function bankCode()
  {
    return $this->_get_value("3");
  }
  function set_bankCode($value)
  {
    return $this->_set_value("3", $value);
  }
  function accountNumber()
  {
    return $this->_get_value("4");
  }
  function set_accountNumber($value)
  {
    return $this->_set_value("4", $value);
  }
  function bankName()
  {
    return $this->_get_value("5");
  }
  function set_bankName($value)
  {
    return $this->_set_value("5", $value);
  }
  function bic()
  {
    return $this->_get_value("6");
  }
  function set_bic($value)
  {
    return $this->_set_value("6", $value);
  }
  function iban()
  {
    return $this->_get_value("7");
  }
  function set_iban($value)
  {
    return $this->_set_value("7", $value);
  }
  function reference()
  {
    return $this->_get_value("8");
  }
  function set_reference($value)
  {
    return $this->_set_value("8", $value);
  }
  function amount()
  {
    return $this->_get_value("9");
  }
  function set_amount($value)
  {
    return $this->_set_value("9", $value);
  }
  function note()
  {
    return $this->_get_value("10");
  }
  function set_note($value)
  {
    return $this->_set_value("10", $value);
  }
  function legalNote()
  {
    return $this->_get_value("11");
  }
  function set_legalNote($value)
  {
    return $this->_set_value("11", $value);
  }
}
class OrderPayment extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "type";
    $this->values["1"] = "";
    $this->fields["2"] = "Payment_CC";
    $this->fieldnames["2"] = "cc";
    $this->values["2"] = "";
    $this->fields["3"] = "Payment_L";
    $this->fieldnames["3"] = "ls";
    $this->values["3"] = "";
    $this->fields["4"] = "Payment_PP";
    $this->fieldnames["4"] = "pp";
    $this->values["4"] = "";
    $this->fields["5"] = "Payment_Factoring";
    $this->fieldnames["5"] = "factoring";
    $this->values["5"] = "";
  }
  function type()
  {
    return $this->_get_value("1");
  }
  function set_type($value)
  {
    return $this->_set_value("1", $value);
  }
  function cc()
  {
    return $this->_get_value("2");
  }
  function set_cc($value)
  {
    return $this->_set_value("2", $value);
  }
  function ls()
  {
    return $this->_get_value("3");
  }
  function set_ls($value)
  {
    return $this->_set_value("3", $value);
  }
  function pp()
  {
    return $this->_get_value("4");
  }
  function set_pp($value)
  {
    return $this->_set_value("4", $value);
  }
  function factoring()
  {
    return $this->_get_value("5");
  }
  function set_factoring($value)
  {
    return $this->_set_value("5", $value);
  }
}
class ShopOrder_ShopOrderRabatt extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "rabatt_type";
    $this->values["1"] = "";
    $this->fields["2"] = "PBDouble";
    $this->fieldnames["2"] = "rabatt_prozent";
    $this->values["2"] = "";
    $this->fields["3"] = "PBDouble";
    $this->fieldnames["3"] = "rabatt_betrag";
    $this->values["3"] = "";
  }
  function rabatt_type()
  {
    return $this->_get_value("1");
  }
  function set_rabatt_type($value)
  {
    return $this->_set_value("1", $value);
  }
  function rabatt_prozent()
  {
    return $this->_get_value("2");
  }
  function set_rabatt_prozent($value)
  {
    return $this->_set_value("2", $value);
  }
  function rabatt_betrag()
  {
    return $this->_get_value("3");
  }
  function set_rabatt_betrag($value)
  {
    return $this->_set_value("3", $value);
  }
}
class ShopOrder extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "order_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "external_order_id";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "_customers_id";
    $this->values["3"] = "";
    $this->fields["4"] = "PBInt";
    $this->fieldnames["4"] = "deb_kred_id";
    $this->values["4"] = "";
    $this->fields["5"] = "ShopCustomer";
    $this->fieldnames["5"] = "customer";
    $this->values["5"] = "";
    $this->fields["6"] = "PBString";
    $this->fieldnames["6"] = "webshop_order_date";
    $this->values["6"] = "";
    $this->fields["7"] = "PBString";
    $this->fieldnames["7"] = "webshop_order_time";
    $this->values["7"] = "";
    $this->fields["6"] = "PBString";
    $this->fieldnames["6"] = "bill_date";
    $this->values["6"] = "";
    $this->fields["7"] = "PBString";
    $this->fieldnames["7"] = "val_date";
    $this->values["7"] = "";
    $this->fields["8"] = "PBString";
    $this->fieldnames["8"] = "beleg_status_text";
    $this->values["8"] = "";
    $this->fields["9"] = "OrderPayment";
    $this->fieldnames["9"] = "payment";
    $this->values["9"] = "";
    $this->fields["10"] = "PBString";
    $this->fieldnames["10"] = "currency";
    $this->values["10"] = "";
    $this->fields["11"] = "PBDouble";
    $this->fieldnames["11"] = "currency_value";
    $this->values["11"] = "";
    $this->fields["12"] = "PBDouble";
    $this->fieldnames["12"] = "netto";
    $this->values["12"] = "";
    $this->fields["13"] = "PBDouble";
    $this->fieldnames["13"] = "netto2";
    $this->values["13"] = "";
    $this->fields["14"] = "ShopOrder_ShopOrderRabatt";
    $this->fieldnames["14"] = "rabatt";
    $this->values["14"] = "";
    $this->fields["15"] = "PBDouble";
    $this->fieldnames["15"] = "saldo";
    $this->values["15"] = "";
    $this->fields["16"] = "PBInt";
    $this->fieldnames["16"] = "orders_status";
    $this->values["16"] = "";
    $this->fields["17"] = "PBString";
    $this->fieldnames["17"] = "_payment_method";
    $this->values["17"] = "";
    $this->fields["18"] = "PBInt";
    $this->fieldnames["18"] = "subshop_id";
    $this->values["18"] = 0;
    
    $this->fields['19'] = 'PBString';
    $this->fieldnames['19'] = 'webshop_order_klarna_order_id';
    $this->values['19'] = '';
    
    $this->fields['20'] = 'PBString';
    $this->fieldnames['20'] = 'webshop_order_klarna_pclass';
    $this->values['20'] = '';

    $this->fields["21"] = "PBString";
    $this->fieldnames["21"] = "onetierarztnr";
    $this->values["21"] = "";
    
    $this->fields["22"] = "PBString";
    $this->fieldnames["22"] = "marketing_campaign_1";
    $this->values["22"] = "";  
  
    $this->fields["23"] = "PBString";
    $this->fieldnames["23"] = "marketing_campaign_2";
    $this->values["23"] = "";

    $this->fields["24"] = "PBString";
    $this->fieldnames["24"] = "payment_type";
    $this->values["24"] = "";

    $this->fields["25"] = "PBString";
    $this->fieldnames["25"] = "payment_order_id";
    $this->values["25"] = "";

    $this->fields["26"] = "PBString";
    $this->fieldnames["26"] = "payed_date";
    $this->values["26"] = "";

  }
  function order_id()
  {
    return $this->_get_value("1");
  }
  function set_order_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function external_order_id()
  {
    return $this->_get_value("2");
  }
  function set_external_order_id($value)
  {
    return $this->_set_value("2", $value);
  }
  function _customers_id()
  {
    return $this->_get_value("3");
  }
  function set__customers_id($value)
  {
    return $this->_set_value("3", $value);
  }
  function deb_kred_id()
  {
    return $this->_get_value("4");
  }
  function set_deb_kred_id($value)
  {
    return $this->_set_value("4", $value);
  }
  function customer()
  {
    return $this->_get_value("5");
  }
  function set_customer($value)
  {
    return $this->_set_value("5", $value);
  }
  function webshop_order_date()
  {
    return $this->_get_value("6");
  }
  function set_webshop_order_date($value)
  {
    return $this->_set_value("6", $value);
  }
  function webshop_order_time()
  {
    return $this->_get_value("7");
  }
  function set_webshop_order_time($value)
  {
    return $this->_set_value("7", $value);
  }
  function bill_date()
  {
    return $this->_get_value("6");
  }
  function set_bill_date($value)
  {
    return $this->_set_value("6", $value);
  }
  function val_date()
  {
    return $this->_get_value("7");
  }
  function set_val_date($value)
  {
    return $this->_set_value("7", $value);
  }
  function beleg_status_text()
  {
    return $this->_get_value("8");
  }
  function set_beleg_status_text($value)
  {
    return $this->_set_value("8", $value);
  }
  function payment()
  {
    return $this->_get_value("9");
  }
  function set_payment($value)
  {
    return $this->_set_value("9", $value);
  }
  function currency()
  {
    return $this->_get_value("10");
  }
  function set_currency($value)
  {
    return $this->_set_value("10", $value);
  }
  function currency_value()
  {
    return $this->_get_value("11");
  }
  function set_currency_value($value)
  {
    return $this->_set_value("11", $value);
  }
  function netto()
  {
    return $this->_get_value("12");
  }
  function set_netto($value)
  {
    return $this->_set_value("12", $value);
  }
  function netto2()
  {
    return $this->_get_value("13");
  }
  function set_netto2($value)
  {
    return $this->_set_value("13", $value);
  }
  function rabatt()
  {
    return $this->_get_value("14");
  }
  function set_rabatt($value)
  {
    return $this->_set_value("14", $value);
  }
  function saldo()
  {
    return $this->_get_value("15");
  }
  function set_saldo($value)
  {
    return $this->_set_value("15", $value);
  }
  function orders_status()
  {
    return $this->_get_value("16");
  }
  function set_orders_status($value)
  {
    return $this->_set_value("16", $value);
  }
  function _payment_method()
  {
    return $this->_get_value("17");
  }
  function set__payment_method($value)
  {
    return $this->_set_value("17", $value);
  }
  function subshop_id()
  {
    return $this->_get_value("18");
  }
  function set_subshop_id($value)
  {
    return $this->_set_value("18", $value);
  }
  function webshop_order_klarna_order_id()
  {
    return $this->_get_value('19');
  }
  function set_webshop_order_klarna_order_id($value)
  {
    return $this->_set_value('19', $value);
  }
  function webshop_order_klarna_pclass()
  {
    return $this->_get_value('20');
  }
  function set_webshop_order_klarna_pclass($value)
  {
    return $this->_set_value('20', $value);
  }

  function onetierarztnr()
  {
    return $this->_get_value("21");
  }
  function set_onetierarztnr($value)
  {
    return $this->_set_value("21", $value);
  }
  
  function marketing_campaign_1(){
      return $this->_get_value("22");
  }
  function set_marketing_campaign_1($value){
      return $this->_set_value("22", $value);
  }
  function marketing_campaign_2(){
      return $this->_get_value("23");
  }
  function set_marketing_campaign_2($value){
      return $this->_set_value("23", $value);
  }

    function payment_type(){
        return $this->_get_value("24");
    }
    function set_payment_type($value){
        return $this->_set_value("24", $value);
    }

    function payment_order_id(){
        return $this->_get_value("25");
    }
    function set_payment_order_id($value){
        return $this->_set_value("25", $value);
    }

    function payed_date(){
        return $this->_get_value("26");
    }
    function set_payed_date($value){
        return $this->_set_value("26", $value);
    }
}
class ShopOrdersListResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "count";
    $this->values["1"] = "";
    $this->fields["2"] = "ShopOrder";
    $this->fieldnames["2"] = "orders";
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
  function orders($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_orders()
  {
    return $this->_add_arr_value("2");
  }
  function set_orders($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_orders()
  {
    $this->_remove_last_arr_value("2");
  }
  function orders_size()
  {
    return $this->_get_arr_size("2");
  }
}
class ShopOrdersListRequest extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "tmp";
    $this->values["1"] = "";
    $this->fields["2"] = "SearchQuery";
    $this->fieldnames["2"] = "search_request";
    $this->values["2"] = "";
  }
  function tmp()
  {
    return $this->_get_value("1");
  }
  function set_tmp($value)
  {
    return $this->_set_value("1", $value);
  }
  function search_request()
  {
    return $this->_get_value("2");
  }
  function set_search_request($value)
  {
    return $this->_set_value("2", $value);
  }
}
class OrderPosition extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "art_nr";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "art_name";
    $this->values["2"] = "";
    $this->fields["3"] = "PBDouble";
    $this->fieldnames["3"] = "preis";
    $this->values["3"] = "";
    $this->fields["4"] = "PBBool";
    $this->fieldnames["4"] = "is_brutto";
    $this->values["4"] = "";
    $this->fields["5"] = "PBString";
    $this->fieldnames["5"] = "type";
    $this->values["5"] = "";
    $this->fields["6"] = "PBDouble";
    $this->fieldnames["6"] = "mwst";
    $this->values["6"] = "";
    $this->fields["7"] = "PBDouble";
    $this->fieldnames["7"] = "menge";
    $this->values["7"] = "";
    $this->fields["8"] = "PBString";
    $this->fieldnames["8"] = "langtext";
    $this->values["8"] = "";
    $this->fields["9"] = "PBString";
    $this->fieldnames["9"] = "art_nr_base";
    $this->values["9"] = "";
    $this->fields["10"] = "PBString";
    $this->fieldnames["10"] = "subtype";
    $this->values["10"] = "";
  }
  function art_nr()
  {
    return $this->_get_value("1");
  }
  function set_art_nr($value)
  {
    return $this->_set_value("1", $value);
  }
  function art_name()
  {
    return $this->_get_value("2");
  }
  function set_art_name($value)
  {
    return $this->_set_value("2", $value);
  }
  function preis()
  {
    return $this->_get_value("3");
  }
  function set_preis($value)
  {
    return $this->_set_value("3", $value);
  }
  function is_brutto()
  {
    return $this->_get_value("4");
  }
  function set_is_brutto($value)
  {
    return $this->_set_value("4", $value);
  }
  function type()
  {
    return $this->_get_value("5");
  }
  function set_type($value)
  {
    return $this->_set_value("5", $value);
  }
  function mwst()
  {
    return $this->_get_value("6");
  }
  function set_mwst($value)
  {
    return $this->_set_value("6", $value);
  }
  function menge()
  {
    return $this->_get_value("7");
  }
  function set_menge($value)
  {
    return $this->_set_value("7", $value);
  }
  function langtext()
  {
    return $this->_get_value("8");
  }
  function set_langtext($value)
  {
    return $this->_set_value("8", $value);
  }
  function art_nr_base()
  {
    return $this->_get_value("9");
  }
  function set_art_nr_base($value)
  {
    return $this->_set_value("9", $value);
  }
  function subtype()
  {
    return $this->_get_value("10");
  }
  function set_subtype($value)
  {
    return $this->_set_value("10", $value);
  }
}
class ShopOrdersPositionsResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBInt";
    $this->fieldnames["1"] = "n_pos";
    $this->values["1"] = "";
    $this->fields["2"] = "OrderPosition";
    $this->fieldnames["2"] = "positions";
    $this->values["2"] = array();
  }
  function n_pos()
  {
    return $this->_get_value("1");
  }
  function set_n_pos($value)
  {
    return $this->_set_value("1", $value);
  }
  function positions($offset)
  {
    return $this->_get_arr_value("2", $offset);
  }
  function add_positions()
  {
    return $this->_add_arr_value("2");
  }
  function set_positions($index, $value)
  {
    $this->_set_arr_value("2", $index, $value);
  }
  function remove_last_positions()
  {
    $this->_remove_last_arr_value("2");
  }
  function positions_size()
  {
    return $this->_get_arr_size("2");
  }
}
class ShopOrdersPositionsRequest extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "order_id";
    $this->values["1"] = "";
  }
  function order_id()
  {
    return $this->_get_value("1");
  }
  function set_order_id($value)
  {
    return $this->_set_value("1", $value);
  }
}
class ShopOrderSetStatusRequest extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "order_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBBool";
    $this->fieldnames["2"] = "send_customer";
    $this->values["2"] = "";
    $this->fields["3"] = "PBInt";
    $this->fieldnames["3"] = "status_id";
    $this->values["3"] = "";
    $this->fields["4"] = "PBString";
    $this->fieldnames["4"] = "comment";
    $this->values["4"] = "";
    $this->fields["5"] = "PBBool";
    $this->fieldnames["5"] = "send_comments";
    $this->values["5"] = "";
    $this->fields["6"] = "PBBool";
    $this->fieldnames["6"] = "set_sent";
    $this->values["6"] = "";
    $this->fields["7"] = "PBString";
    $this->fieldnames["7"] = "sent_date";
    $this->values["7"] = "";
    $this->fields["8"] = "PBBool";
    $this->fieldnames["8"] = "set_paid";
    $this->values["8"] = "";
    $this->fields["9"] = "PBString";
    $this->fieldnames["9"] = "paid_date";
    $this->values["9"] = "";
    $this->fields["10"] = "PBString";
    $this->fieldnames["10"] = "bill_nr";
    $this->values["10"] = "";

    $this->fields["11"] = "PBBool";
    $this->fieldnames["11"] = "sent_state";
    $this->fields["12"] = "PBBool";
    $this->fieldnames["12"] = "paid_state";
  }
  function order_id()
  {
    return $this->_get_value("1");
  }
  function set_order_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function send_customer()
  {
    return $this->_get_value("2");
  }
  function set_send_customer($value)
  {
    return $this->_set_value("2", $value);
  }
  function status_id()
  {
    return $this->_get_value("3");
  }
  function set_status_id($value)
  {
    return $this->_set_value("3", $value);
  }
  function comment()
  {
    return $this->_get_value("4");
  }
  function set_comment($value)
  {
    return $this->_set_value("4", $value);
  }
  function send_comments()
  {
    return $this->_get_value("5");
  }
  function set_send_comments($value)
  {
    return $this->_set_value("5", $value);
  }
  function set_sent()
  {
    return $this->_get_value("6");
  }
  function set_set_sent($value)
  {
    return $this->_set_value("6", $value);
  }
  function sent_date()
  {
    return $this->_get_value("7");
  }
  function set_sent_date($value)
  {
    return $this->_set_value("7", $value);
  }
  function set_paid()
  {
    return $this->_get_value("8");
  }
  function set_set_paid($value)
  {
    return $this->_set_value("8", $value);
  }
  function paid_date()
  {
    return $this->_get_value("9");
  }
  function set_paid_date($value)
  {
    return $this->_set_value("9", $value);
  }
  function bill_nr()
  {
    return $this->_get_value("10");
  }
  function set_bill_nr($value)
  {
    return $this->_set_value("10", $value);
  }

  function sent_state()
  {
    return $this->_get_value("11");
  }
  function set_sent_state($value)
  {
    return $this->_set_value("11", $value);
  }
  function paid_state()
  {
    return $this->_get_value("12");
  }
  function set_paid_state($value)
  {
    return $this->_set_value("12", $value);
  }


}
class ShopOrderSetStatusResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "order_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "send_customer";
    $this->values["2"] = "";
    $this->fields["3"] = "PBBool";
    $this->fieldnames["3"] = "send_comments";
    $this->values["3"] = "";
    $this->fields["4"] = "PBBool";
    $this->fieldnames["4"] = "set_sent";
    $this->values["4"] = "";
    $this->fields["5"] = "PBBool";
    $this->fieldnames["5"] = "set_paid";
    $this->values["5"] = "";
    $this->fields["5"] = "PBBool";
    $this->fieldnames["5"] = "status_set";
    $this->values["5"] = "";
    $this->fields["6"] = "PBBool";
    $this->fieldnames["6"] = "bill_nr_set";
    $this->values["6"] = "";
  }
  function order_id()
  {
    return $this->_get_value("1");
  }
  function set_order_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function send_customer()
  {
    return $this->_get_value("2");
  }
  function set_send_customer($value)
  {
    return $this->_set_value("2", $value);
  }
  function send_comments()
  {
    return $this->_get_value("3");
  }
  function set_send_comments($value)
  {
    return $this->_set_value("3", $value);
  }
  function set_sent()
  {
    return $this->_get_value("4");
  }
  function set_set_sent($value)
  {
    return $this->_set_value("4", $value);
  }
  function set_paid()
  {
    return $this->_get_value("5");
  }
  function set_set_paid($value)
  {
    return $this->_set_value("5", $value);
  }
  function status_set()
  {
    return $this->_get_value("5");
  }
  function set_status_set($value)
  {
    return $this->_set_value("5", $value);
  }
  function bill_nr_set()
  {
    return $this->_get_value("6");
  }
  function set_bill_nr_set($value)
  {
    return $this->_set_value("6", $value);
  }
}
class ShopOrderSetTrackingcodeRequest extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "order_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBString";
    $this->fieldnames["2"] = "trackingcode";
    $this->values["2"] = "";
    $this->fields["3"] = "PBString";
    $this->fieldnames["3"] = "shipper";
    $this->values["3"] = "";
    $this->fields["4"] = "PBString";
    $this->fieldnames["4"] = "send_date";
    $this->values["4"] = "";
    $this->fields["5"] = "PBString";
    $this->fieldnames["5"] = "expected_arrival";
    $this->values["5"] = "";
  }
  function order_id()
  {
    return $this->_get_value("1");
  }
  function set_order_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function trackingcode()
  {
    return $this->_get_value("2");
  }
  function set_trackingcode($value)
  {
    return $this->_set_value("2", $value);
  }
  function shipper()
  {
    return $this->_get_value("3");
  }
  function set_shipper($value)
  {
    return $this->_set_value("3", $value);
  }
  function send_date()
  {
    return $this->_get_value("4");
  }
  function set_send_date($value)
  {
    return $this->_set_value("4", $value);
  }
  function expected_arrival()
  {
    return $this->_get_value("5");
  }
  function set_expected_arrival($value)
  {
    return $this->_set_value("5", $value);
  }
}
class ShopOrderSetTrackingcodeResponse extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    $this->fields["1"] = "PBString";
    $this->fieldnames["1"] = "order_id";
    $this->values["1"] = "";
    $this->fields["2"] = "PBBool";
    $this->fieldnames["2"] = "trackingcode_set";
    $this->values["2"] = "";
    $this->fields["3"] = "PBBool";
    $this->fieldnames["3"] = "shipper_set";
    $this->values["3"] = "";
    $this->fields["4"] = "PBBool";
    $this->fieldnames["4"] = "send_date_set";
    $this->values["4"] = "";
    $this->fields["5"] = "PBBool";
    $this->fieldnames["5"] = "expected_arrival_set";
    $this->values["5"] = "";
  }
  function order_id()
  {
    return $this->_get_value("1");
  }
  function set_order_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function trackingcode_set()
  {
    return $this->_get_value("2");
  }
  function set_trackingcode_set($value)
  {
    return $this->_set_value("2", $value);
  }
  function shipper_set()
  {
    return $this->_get_value("3");
  }
  function set_shipper_set($value)
  {
    return $this->_set_value("3", $value);
  }
  function send_date_set()
  {
    return $this->_get_value("4");
  }
  function set_send_date_set($value)
  {
    return $this->_set_value("4", $value);
  }
  function expected_arrival_set()
  {
    return $this->_get_value("5");
  }
  function set_expected_arrival_set($value)
  {
    return $this->_set_value("5", $value);
  }
}
?>