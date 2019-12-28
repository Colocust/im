<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/23
 * Time: 14:15
 */

if (!function_exists('millisecond')) {
  function millisecond() {
    return (int)(microtime(true) * 1000);
  }
}

if (!function_exists('millisecondToString')) {
  function millisecondToString() {
    return date("Y-m-d H:i:s") . "," . millisecond() % 1000;
  }
}

if (!function_exists('toArray')) {
  function toArray($obj) {
    $object = json_decode(json_encode($obj), true);
    return array_filter($object, function ($v, $k) {
      return $v !== null;
    }, ARRAY_FILTER_USE_BOTH);
  }
}

if (!function_exists('toXML')) {
  function toXML(array $array) {
    $xmlData = "<xml>";
    foreach ($array as $key => $value) {
      $xmlData .= "<" . $key . "><![CDATA[" . $value . "]]></" . $key . ">";
    }
    $xmlData = $xmlData . "</xml>";
    return $xmlData;
  }
}