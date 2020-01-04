<?php

namespace service\wechat;

class MiniProgram {

  //获取openid等用户信息
  public static function getCode2Session(string $code) {
    $loginUrl = sprintf(
      config('wechat.mini_program.interface_url.login_url'),
      config('wechat.mini_program.app_id'),
      config('wechat.mini_program.secret'),
      $code);
    $res = curl_get($loginUrl);
    if ($res === false) return null;
    $obj = json_decode($res);
    if (isset($obj->errcode)) return null;
    if (!isset($obj->openid)) return null;
    return $obj;
  }

  //发送模板消息
  public static function sendTemplateMessage(array $data) {
    $accessToken = AccessToken::getAccessToken();
    $templateMessageUrl = sprintf(
      config('wechat.miniprogram.interface_url.template_message_url'),
      $accessToken['access_token']);
    $res = curl_post($templateMessageUrl, $data);
    return $res;
  }

  //通过该接口生成的小程序码，永久有效，有数量限制
  public static function getWxaCode(array $data) {
    $accessToken = AccessToken::getAccessToken();
    $wxaCodeUrl = sprintf(
      config('wechat.mini_program.interface_url.wxa_code_url'),
      $accessToken['access_token']);
    $res = curl_post($wxaCodeUrl, $data);
    return $res;
  }

  //获取小程序码，适用于需要的码数量极多的业务场景。通过该接口生成的小程序码，永久有效，数量暂无限制
  public static function getWxaCodeUnlimit(array $data) {

    $accessToken = AccessToken::getAccessToken();
    $wxaCodeUrl = sprintf(
      config('wechat.mini_program.interface_url.wxa_code_unlimit_url'),
      $accessToken['access_token']);
    $res = curl_post($wxaCodeUrl, $data);
    return $res;
  }

  //获取小程序二维码，适用于需要的码数量较少的业务场景。通过该接口生成的小程序码，永久有效，有数量限制
  public static function createQRCode(array $data) {
    $accessToken = AccessToken::getAccessToken();
    $wxaCodeUrl = sprintf(
      config('wechat.mini_program.interface_url.qr_code_url'),
      $accessToken['access_token']);
    $res = curl_post($wxaCodeUrl, $data);
    return $res;
  }

}
