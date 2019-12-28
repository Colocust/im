<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/17
 * Time: 16:07
 */

namespace service\wechat;

class AccessToken {

  //获取AccessToken
  public static function getAccessToken() :array {
    $accessTokenUrl = sprintf(
      config('wechat.access_token.interface_url'),
      config('wechat.access_token.app_id'),
      config('wechat.access_token.secret'));
    $token = curl_get($accessTokenUrl);
    $token = json_decode($token, true);

    //获取AccessToken异常
    if (!$token) {
      throw new \Exception('获取AccessToken异常');
    }

    //获取失败
    if (!empty($token['errcode'])) {
      throw new \Exception('获取AccessToken异常');
    }

    return $token;
  }
}