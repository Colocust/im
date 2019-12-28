<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/19
 * Time: 16:00
 */
return [
  //高德地图
  'amap' => [
    'url' => [
      //获取经纬度url(逆地址解析)
      'geocode_url' => 'http://restapi.amap.com/v3/geocode/geo?address=%s&key=%s',
    ],
    'key' => ''
  ],

  //腾讯地图
  'tmap' => [
    'url' => [
       //获取经纬度url(逆地址解析)
      'geocode_url' => 'http://apis.map.qq.com/ws/geocoder/v1/?address=%s&key=%s'
    ],
    'key' => ''
  ],

  //百度地图
  'bmap' => [
    'url' => [
       //获取经纬度url(逆地址解析)
      'geocode_url' => 'http://api.map.baidu.com/geocoder/v2/?callback=renderOption&output=json&address=%s&ak=%s'
    ],
    'ak' => ''
  ],
];