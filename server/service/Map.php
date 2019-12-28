<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/17
 * Time: 17:33
 */

namespace service;

class Map {

  //url地址需要包括完整的请求参数
  public static function getLatAndLng(string $url) {
    return curl_get($url);
  }

  //两对经纬度,顺序没有影响
  public static function getDistance($lat1, $lng1, $lat2, $lng2) {
    $distance = self::calcDistance($lat1, $lng1, $lat2, $lng2);
    return round($distance / 1000, 1);
  }

  //计算距离
  private static function calcDistance($lat1, $lng1, $lat2, $lng2) {
    /** 转换数据类型为 double */
    $lat1 = doubleval($lat1);
    $lng1 = doubleval($lng1);
    $lat2 = doubleval($lat2);
    $lng2 = doubleval($lng2);
    /** 以下算法是 Google 出来的,与大多数经纬度计算工具结果一致 */
    $theta = $lng1 - $lng2;
    $dist = sin(
        deg2rad($lat1)) * sin(deg2rad($lat2)) +
      cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)
      );
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    return ($miles * 1.609344 * 1000);
  }

  //计算某个坐标指定距离的经纬度范围
  public static function calcScope($lat, $lng, $radius) {
    $degree = (24901 * 1609) / 360.0;
    $dpmLat = 1 / $degree;
    $radiusLat = $dpmLat * $radius;
    $minLat = $lat - $radiusLat;       // 最小纬度
    $maxLat = $lat + $radiusLat;       // 最大纬度
    $mpdLng = $degree * cos($lat * (3.14 / 180));
    $dpmLng = 1 / $mpdLng;
    $radiusLng = $dpmLng * $radius;
    $minLng = $lng - $radiusLng;      // 最小经度
    $maxLng = $lng + $radiusLng;      // 最大经度
    /** 返回范围数组 */
    $scope = array(
      'minLat' => $minLat,
      'maxLat' => $maxLat,
      'minLng' => $minLng,
      'maxLng' => $maxLng
    );
    return $scope;
  }
}