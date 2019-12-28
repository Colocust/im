<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/16
 * Time: 16:53
 */

namespace tiny;

use tiny\validate\Message;
use tiny\validate\Rule;

class Validate {

  const BASE_METHODS = [
    'int' => 'checkInt',
    'float' => 'checkFloat',
    'string' => 'checkString',
    'int[]' => 'checkIntArray',
    'float[]' => 'checkFloatArray',
    'string[]' => 'checkStringArray',
    'telephone' => 'checkTelephone',
    'email' => 'checkEmail',
    'idNumber' => 'checkIdNumber',
    'file' => 'checkFile'
  ];

  /**
   * @param object $class
   * @return bool
   * @throws \Exception
   */
  public function goCheck(object $class): bool {
    $annotation = $this->getAnnotation($class);

    //指定第一个rule为参数类型,第二个rule判断是否为必填参数
    foreach ($annotation as $key => $rule) {
      //判断必填参数是否有值
      if (isset($rule->uses) && !array_key_exists($key, toArray($class))) {
        throw new \Exception("$key must be required ,but not exists", HttpStatus::ARGS_ERROR);
      }

      //判断参数是否定义规则
      if (empty($rule->var)) {
        throw new \Exception("$key not have rule", HttpStatus::ARGS_ERROR);
      }

      if (isset($class->{$key})) {
        $validateRule = new Rule($class->{$key});

        if (array_key_exists($rule->var, self::BASE_METHODS)) {
          $res = $validateRule->{self::BASE_METHODS[$rule->var]}();
        } else {
          $res = $validateRule->checkObjectArray($rule->var);
        }

        if (!$res) {
          $errorMsg = Message::getErrorMsg($rule->var, $key, $class->{$key});
          throw new \Exception($errorMsg, HttpStatus::ARGS_ERROR);
        }
      }
    }
    return true;
  }

  public function getAnnotation(object $metaClass): object {
    try {
      $reflection = new \ReflectionClass($metaClass);
    } catch (\ReflectionException $e) {
      Logger::getInstance()->error($e->getMessage());
    }

    $annotation = new Annotation();
    return $annotation->getMetaClass($reflection->getName());
  }
}