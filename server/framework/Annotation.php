<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/20
 * Time: 15:18
 */

namespace tiny;

use ReflectionClass;
use StdClass;

class Annotation {

  //获取目标类的注释
  public function getMetaClass(string $metaClass): stdClass {
    try {
      $clazz = new ReflectionClass($metaClass);
    } catch (\ReflectionException $e) {
      Logger::getInstance()->warn($e->getMessage());
    }
    $properties = $clazz->getProperties();

    $stdClass = new StdClass();

    foreach ($properties as $property) {
      if ($property->isPublic()) {
        $stdClass->{$property->getName()} = $this->getAnnotationValue($property->getDocComment());
      }
    }
    return $stdClass;
  }

  //获取注释中定义的数据类型规则
  private function getAnnotationValue(string $annotation): stdClass {
    $values = new stdClass();

    $start = strpos($annotation, 'var');
    $end = strstr($annotation, '* @uses') ? strpos($annotation, '* @uses') : strpos($annotation, '*/');

    $values->var = trim(substr($annotation, $start + 3, $end - $start - 3));

    if (strstr($annotation, 'required')) {
      $values->uses = 'required';
    }

    return $values;
  }
}