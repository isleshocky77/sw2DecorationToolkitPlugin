<?php
/**
 * This is a class for debugging
 *
 */
class sw2Debug {

  /**
   * Prints a formatted var_dump with some extra options
   *
   * @param mixed $variable
   * @param string $die Will die with this string if not false
   * @param boolean $print Will return the information instead of printing when false
   */
  static public function p($variable, $die = false, $print = true) {
    $return = '';
    $return .= "<pre>";
    $return .= var_export($variable, true);
    $return .= "</pre>";

    if($print) {
      echo $return;
    } else {
      return $return;
    }

    if($die !== false) {
      die($die);
    }
  }
}
