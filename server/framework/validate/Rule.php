<?php

namespace tiny\validate;

use tiny\Validate;

class Rule {
  private $value;

  public function __construct($value) {
    $this->value = $value;
  }

  public function checkInt(): bool {
    return is_int($this->value) ? true : false;
  }

  public function checkFloat(): bool {
    return is_float($this->value) ? true : false;
  }

  public function checkString(): bool {
    return is_string($this->value) ? true : false;
  }

  public function checkTelephone(): bool {
    if (preg_match('/^1[3-9]\d{9}$/', $this->value) || preg_match('/^([0-9]{3,4}-)?([0-9]{7,8})([\x{4e00}-\x{9fa5}]{1}[0-9]*)?$/u', $this->value)) {
      return true;
    }
    return false;
  }

  public function checkEmail(): bool {
    if (filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
      return true;
    }
    return false;
  }

  public function checkIdNumber(): bool {
    return preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $this->value) ? true : false;
  }

  public function checkFile(): bool {
    return is_file($this->value['tmp_name']) ? true : false;
  }

  public function checkIntArray(): bool {
    if (is_array($this->value)) {
      foreach ($this->value as $one) {
        if (!is_int($one)) {
          return false;
        }
      }
      return true;
    }
    return false;
  }

  public function checkFloatArray(): bool {
    if (is_array($this->value)) {
      foreach ($this->value as $one) {
        if (!is_float($one)) {
          return false;
        }
      }
      return true;
    }
    return false;
  }

  public function checkStringArray(): bool {
    if (is_array($this->value)) {
      foreach ($this->value as $one) {
        if (!is_string($one)) {
          return false;
        }
      }
      return true;
    }
    return false;
  }

  /**
   * @param $rule
   * @return bool
   * @throws \Exception
   */
  public function checkObjectArray($rule): bool {
    $isArray = false;
    if (strstr($rule, '[]')) {
      $isArray = true;
      $rule = substr($rule, 0, strlen($rule) - 2);
    }

    $namespace = "\\api\\{$rule}";

    $class = new $namespace;

    if ($isArray) {
      if (is_array($this->value)) {
        foreach ($this->value as $value) {
          $value = json_decode(json_encode($value));
          foreach ($class as $k => $v) {
            if (isset($value->{$k})) {
              $class->{$k} = $value->{$k};
            }
          }
          $validate = new Validate();
          if (!$validate->goCheck($class)) {
            return false;
          }
        }
      } else {
        return false;
      }
    } else {
      if (is_object($this->value)) {
        foreach ($class as $k => $v) {
          if (isset($this->value->{$k})) {
            $class->{$k} = $this->value->{$k};
          }
        }
        $validate = new Validate();
        if (!$validate->goCheck($class)) {
          return false;
        }
      } else {
        return false;
      }
    }
    return true;
  }
}