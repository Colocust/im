<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/23
 * Time: 11:57
 */

use tiny\Container;

if (!function_exists('config')) {
  function config(string $name = "") {
    return Container::get('config')->get($name);
  }
}

if (!function_exists('app')) {
  function app($name) {
    return Container::get($name);
  }
}

if (!function_exists('curl_get')) {
  function curl_get(string $url, &$httpCode = 0) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //不做证书校验,部署在linux环境下请改为true
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $file_contents = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $file_contents;
  }
}

if (!function_exists('curl_post')) {
  function curl_post(string $url, $params) {
    if (is_array($params) || is_object($params)) {
      $data_string = json_encode($params);
    } else {
      $data_string = $params;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt(
      $ch, CURLOPT_HTTPHEADER,
      array(
        'Content-Type: application/json'
      )
    );
    $data = curl_exec($ch);
    curl_close($ch);
    return ($data);
  }
}


if (!function_exists('get_client_ip')) {
  function get_client_ip() {
    if (!empty($_SERVER['SERVER_ADDR'])) {
      $ip = $_SERVER['SERVER_ADDR'];
    } elseif (!empty($_SERVER['SERVER_NAME'])) {
      $ip = gethostbyname($_SERVER['SERVER_NAME']);
    } else {
      $ip = defined('PHPUNIT_RUNNING') ? '127.0.0.1' : gethostbyname(gethostname());
    }
    return filter_var($ip, FILTER_VALIDATE_IP) ?: '127.0.0.1';
  }
}
