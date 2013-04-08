<?php
/**
 * @author Nikolai Kordulla
 */
class PBInt extends PBScalar
{
  /**
   * Set scalar value
   */
  public function set_value($value)
  {
    $this->value = (int)$value;
  }

  /**
   * Get the scalar value
   */
  public function get_value()
  {
    return (int)$this->value;
  }

}
?>
