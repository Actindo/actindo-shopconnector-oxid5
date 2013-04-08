<?php
/**
 * @author Nikolai Kordulla
 */
class PBBool extends PBInt
{
  /**
   * Set scalar value
   */
  public function set_value($value)
  {
    $this->value = (bool)$value;
  }

  /**
   * Get the scalar value
   */
  public function get_value()
  {
    return (bool)$this->value;
  }
}
?>
