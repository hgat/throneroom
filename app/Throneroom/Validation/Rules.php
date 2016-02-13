<?php

namespace Throneroom\Validation;

class Rules {
  public static function validation_required($field, $value, $args) {
    return (!empty($value)) ? true : "The {field} field is required.";
  }

  public static function validation_number($field, $value, $args) {
    return (is_numeric($value)) ? true : "The {field} field needs to be a number.";
  }

  public static function validation_email($field, $value) {
    return (filter_var($value, FILTER_VALIDATE_EMAIL)) ? true : "The {field} field is on not a valid email.";
  }

  public static function validation_belongs_to($field, $value, $args) {
    foreach($args as $arg) {
      if($value == $arg) {
        return true;
      }
    }
    $string = implode(', ', $args);
    return "The {field} parameter must be one of {$string}.";
  }
}
