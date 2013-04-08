<?php
/**
 * @author Nikolai Kordulla
 */
class PBString extends PBScalar
{
  /**
   * Set scalar value
   */
  public function set_value($value)
  {
    $this->value = $value;
  }

  /**
   * Get the scalar value
   */
  public function get_value()
  {
    return $this->value;
  }
}

?>