<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/10/17
 * Time: 17:23
 */

namespace service\login;

use service\wechat\AccessToken;

class WeChatThirdPartyLogin implements ThirdPartyLogin {

  public function login(string $code): array {
    $accessToken = $this->getAccessToken();
    $url = sprintf(
      config('wechat.third_party_login.interface_url'),
      $accessToken['access_token'],
      $accessToken['openid']);
    $res = curl_get($url);
    return json_decode($res);
  }

  public function getAccessToken(): array {
    $accessToken = AccessToken::getAccessToken();
    return $accessToken;
  }
}