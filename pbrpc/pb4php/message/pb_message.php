<?php
/**
 * Including of all files needed to parse messages
 * @author Nikolai Kordulla
 */
require_once(dirname(__FILE__). '/' . 'encoding/pb_base128.php');
require_once(dirname(__FILE__). '/' . 'type/pb_scalar.php');
require_once(dirname(__FILE__). '/' . 'type/pb_enum.php');
require_once(dirname(__FILE__). '/' . 'type/pb_bytes.php');
require_once(dirname(__FILE__). '/' . 'type/pb_string.php');
require_once(dirname(__FILE__). '/' . 'type/pb_int.php');
require_once(dirname(__FILE__). '/' . 'type/pb_bool.php');
require_once(dirname(__FILE__). '/' . 'type/pb_signed_int.php');
require_once(dirname(__FILE__). '/' . 'reader/pb_input_reader.php');
require_once(dirname(__FILE__). '/' . 'reader/pb_input_string_reader.php');
require_once(dirname(__FILE__). '/' . 'type/pb_double.php');
require_once(dirname(__FILE__). '/' . 'type/pb_float.php');
/**
 * Abstract Message class
 * @author Nikolai Kordulla
 */
abstract class PBMessage
{
    const WIRED_VARINT = 0;
    const WIRED_64BIT = 1;
    const WIRED_LENGTH_DELIMITED = 2;
    const WIRED_START_GROUP = 3;
    const WIRED_END_GROUP = 4;
    const WIRED_32BIT = 5;

    var $base128;

    // here are the field types
    var $fields = array();
    // the values for the fields
    var $values = array();

    // type of the class
    var $wired_type = 2;

    // the value of a class
    var $value = null;

    // modus byte or string parse (byte for productive string for better reading and debuging)
    // 1 = byte, 2 = String
    const MODUS = 1;

    // now use pointer for speed improvement
    // pointer to begin
    protected $reader;

    // chunk which the class not understands
    var $chunk = '';

    // variable for Send method
    var $_d_string = '';

    /**
     * Constructor - initialize base128 class
     */
    public function __construct($reader=null)
    {
        $this->reader = $reader;
        $this->value = $this;
        if( !defined('PBRPC_LOCAL_CHARSET') )
          define( 'PBRPC_LOCAL_CHARSET', 'ISO-8858-1' );
        if( !defined('PBRPC_WIRE_CHARSET') )
          define( 'PBRPC_WIRE_CHARSET', 'UTF-8' );
    }

    /**
     * Add an array value
     * @param int - index of the field
     */
    protected function _add_arr_value($index)
    {
        return $this->values[$index][] = new $this->fields[$index]();
    }

    /**
     * Set an array value - @TODO failure check
     * @param int - index of the field
     * @param int - index of the array
     * @param object - the value
     */
    protected function _set_arr_value($index, $index_arr, $value)
    {
        $this->values[$index][$index_arr] = $value;
    }

    /**
     * Remove the last array value
     * @param int - index of the field
     */
    protected function _remove_last_arr_value($index)
    {
      array_pop($this->values[$index]);
    }

    /**
     * Set an value
     * @param int - index of the field
     * @param Mixed value
     */
    protected function _set_value($index, $value)
    {
        if (gettype($value) == 'object')
        {
            $this->values[$index] = $value;
        }
        else
        {
            $this->values[$index] = new $this->fields[$index]();
          if( is_subclass_of($this->values[$index], 'PBScalar') )
            $this->values[$index]->set_value( $value );
          else
            $this->values[$index]->value = $value;
        }
    }

    /**
     * Get a value
     * @param id of the field
     */
    protected function _get_value($index)
    {
        if ($this->values[$index] == null)
            return null;

//        var_dump($this->values[$index]);
      if( is_subclass_of($this->values[$index], 'PBScalar') )
        return $this->values[$index]->get_value();
      else
        return $this->values[$index]->value;
    }

    /**
     * Get array value
     * @param id of the field
     * @param value
     */
    protected function _get_arr_value($index, $value)
    {
        return $this->values[$index][$value];
    }

    /**
     * Get array size
     * @param id of the field
     */
    protected function _get_arr_size($index)
    {
        return count($this->values[$index]);
    }

    /**
     * Helper method for send string
     */
    protected function _save_string($ch, $string)
    {
        $this->_d_string .= $string;
        $content_length = strlen($this->_d_string);
        return strlen($string);
    }

  /**
     * Fix Memory Leaks with Objects in PHP 5
     * http://paul-m-jones.com/?p=262
     *
     * thanks to cheton
     * http://code.google.com/p/pb4php/issues/detail?id=3&can=1
     */
    public function __destruct()
    {
        if (isset($this->reader))
        {
            unset($this->reader);
        }
        if (isset($this->value))
        {
            unset($this->value);
        }
        // base128
        if (isset($this->base128))
        {
           unset($this->base128);
        }
        // fields
        if (isset($this->fields))
        {
            foreach ($this->fields as $name => $value)
            {
                unset($this->$name);
            }
            unset($this->fields);
        }
        // values
        if (isset($this->values))
        {
            foreach ($this->values as $name => $value)
            {
                if (is_array($value))
                {
                    foreach ($value as $name2 => $value2)
                    {
                        if (is_object($value2) AND method_exists($value2, '__destruct'))
                        {
                            $value2->__destruct();
                        }
                        unset($value2);
                    }
                    if (isset($name2))
                      unset($value->$name2);
                }
                else
                {
                    if (is_object($value) AND method_exists($value, '__destruct'))
                    {
                        $value->__destruct();
                    }
                    unset($value);
                }
                unset($this->values->$name);
            }
            unset($this->values);
        }
    }


    function toArray()
    {
      $arr = array();
      if( !is_array($this->fieldnames) )
        return null;
      foreach( $this->fieldnames as $_fieldid => $_fieldname )
      {
        if( is_array($this->values[$_fieldid]) )      // repeated
        {
          $arr[$_fieldname] = array();

          $size_fcn = $_fieldname.'_size';
          $get_fcn = $_fieldname;
          $size = $this->$size_fcn();
          for( $i=0; $i<$size; $i++ )
          {
            $arr[$_fieldname][] = $this->$get_fcn($i)->toArray();
          }
        }
        else    // required, optional
        {
          if( is_object($this->$_fieldname()) )
          {   // complex type
            $arr[$_fieldname] = $this->$_fieldname()->toArray();
          }
          else
          {   // simple type
            $arr[$_fieldname] = $this->$_fieldname();
          }
        }
      }

      return $arr;
    }

    function fromArray( $arr )
    {
      if( !is_array($this->fieldnames) )
        return null;
      foreach( $this->fieldnames as $_fieldid => $_fieldname )
      {
        if( !isset($arr[$_fieldname]) )
          continue;

        $data = $arr[$_fieldname];

        if( is_array($this->values[$_fieldid]) )      // repeated
        {
          $add_fcn = 'add_'.$_fieldname;
          $fld = $this->$add_fcn();
          $fld->fromArray( $data );
        }
        else
        {
          $_setfieldname = 'set_'.$_fieldname;
          if( !is_subclass_of($this->fields[$_fieldid], 'PBScalar') )
          {   // complex type
            $p = new $this->fields[$_fieldid]();
//            echo "complex type ".($this->fields[$_fieldid])."\n";
//            var_dump($data);
            $p->fromArray( $data );
            $this->$_setfieldname( $p );
          }
          else
          {   // simple type
            $this->$_setfieldname( $data );
          }
        }

      }
    }

    protected function _do_SerializeToPHPSerialize( )
    {
      $arr = array();
      if( !is_array($this->fieldnames) )
          return null;

      foreach( $this->fieldnames as $_fieldid => $_fieldname )
      {
        if( is_array($this->values[$_fieldid]) )      // repeated
        {
          $arr[$_fieldid] = array();

          $size_fcn = $_fieldname.'_size';
          $get_fcn = $_fieldname;
          $size = $this->$size_fcn();
          for( $i=0; $i<$size; $i++ )
          {
            $arr[$_fieldid][] = $this->$get_fcn($i)->_do_SerializeToPHPSerialize();
          }
        }
        else    // required, optional
        {
          if( is_object($this->$_fieldname()) )
          {   // complex type
            $arr[$_fieldid] = $this->$_fieldname()->_do_SerializeToPHPSerialize();
          }
          else
          {   // simple type
            if( $this->fields[$_fieldid] == 'PBString' )
            {
              if( PBRPC_LOCAL_CHARSET != 'UTF-8' && PBRPC_WIRE_CHARSET == 'UTF-8' )
                $arr[$_fieldid] = utf8_encode( $this->$_fieldname() );
              else if( PBRPC_LOCAL_CHARSET == 'UTF-8' && PBRPC_WIRE_CHARSET != 'UTF-8' )
                $arr[$_fieldid] = utf8_decode( $this->$_fieldname() );
              else
                $arr[$_fieldid] = $this->$_fieldname();
            }
            else
            {
              $arr[$_fieldid] = $this->$_fieldname();
            }
          }
        }
      }

      return $arr;
    }

    function SerializeToPHPSerialize( )
    {
      return serialize( $this->_do_SerializeToPHPSerialize( ) );
    }

    function ParseFromPHPSerialize( $str )
    {
      $arr = unserialize( $str );
      if( $arr === FALSE )
      {
        trigger_error( 'error decoding '.$str, E_USER_NOTICE );
        return;
      }
//      var_dump($arr);
      $this->_do_ParseFromPHPSerialize( $arr );
    }

    protected function _do_ParseFromPHPSerialize( $arr )
    {
      if( !is_array($this->fieldnames) )
        return null;
      foreach( $this->fieldnames as $_fieldid => $_fieldname )
      {
        if( !isset($arr[$_fieldid]) )
          continue;

        if( is_array($this->values[$_fieldid]) )      // repeated
        {
          $add_fcn = 'add_'.$_fieldname;
          for( $i=0; $i<count($arr[$_fieldid]); $i++ )
          {
            $p = $this->$add_fcn( );
            $p->_do_ParseFromPHPSerialize( $arr[$_fieldid][$i] );
          }
        }
        else    // required, optional
        {
//          var_dump( $this->fields[$_fieldid] );
          $_setfieldname = 'set_'.$_fieldname;
          if( !is_subclass_of($this->fields[$_fieldid], 'PBScalar') )
          {   // complex type
            $p = new $this->fields[$_fieldid]();
//            echo "complex type ".($this->fields[$_fieldid])."\n";
            $p->_do_ParseFromPHPSerialize( $arr[$_fieldid] );
            $this->$_setfieldname( $p );
          }
          else
          {   // simple type
            $_setfieldname = 'set_'.$_fieldname;
//            var_dump($arr[$_fieldid]);
//            $this->$_setfieldname( $arr[$_fieldid] );
            $cn = $this->fields[$_fieldid];

            $this->values[$_fieldid] = new $cn();
            if( $cn == 'PBString' )
            {
              if( PBRPC_LOCAL_CHARSET != 'UTF-8' && PBRPC_WIRE_CHARSET == 'UTF-8' )
                $this->values[$_fieldid]->value = utf8_decode( $arr[$_fieldid] );
              else if( PBRPC_LOCAL_CHARSET == 'UTF-8' && PBRPC_WIRE_CHARSET != 'UTF-8' )
                $this->values[$_fieldid]->value = utf8_encode( $arr[$_fieldid] );
              else
                $this->values[$_fieldid]->value = $arr[$_fieldid];
            }
            else
            {
              $this->values[$_fieldid]->value = $arr[$_fieldid];
            }
          }
        }
      }
    }

}
?>
