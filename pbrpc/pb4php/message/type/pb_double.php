<?php
/**
 * @author Nikolai Kordulla
 */
class PBDouble extends PBScalar
{
  /**
   * Set scalar value
   */
  public function set_value($value)
  {
    $this->value = (double)$value;
  }

  /**
   * Get the scalar value
   */
  public function get_value()
  {
    return (double)$this->value;
  }

  public function toArray()
  {
    return $this->value;
  }

  public function _do_SerializeToPHPSerialize( )
  {
    return $this->value;
  }
}
?>