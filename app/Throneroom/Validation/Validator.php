<?php

namespace Throneroom\Validation;

class Validator {

  protected $_errors;

  public function validate(array $array) {

    $this->_errors = [];

    foreach($array as $field => $data) {

      $value = $data[0];
      $rules = explode('|', $data[1]);

      foreach($rules as $rule) {
        $args = explode(':', $rule);
        $rule = $args[0];
        unset($args[0]);
        $args = array_values($args);

        $result = call_user_func_array([__NAMESPACE__ . '\Rules', 'validation_' . $rule], [$field, $value, $args]);

        if($result !== true) {
          $error = (isset($data[2]['message'])) ? $data[2]['message'] : $result;
          $alias = (isset($data[2]['alias'])) ? $data[2]['alias'] : $field;
          $error = str_replace('{field}', $alias, $error);
          $error = str_replace('{value}', $value, $error);
          $this->_errors[$field] = $error;
        }

        unset($args);
      }

    }

    return $this;

  }

  public function passes() {
    return (empty($this->_errors)) ? true : false;
  }

  public function errors() {
    return $this->_errors;
  }
}
