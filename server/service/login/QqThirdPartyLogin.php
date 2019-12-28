<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/10/17
 * Time: 17:25
 */

namespace service\login;


class QqThirdPartyLogin implements ThirdPartyLogin {

  public function login(string $code): array {

  }

  public function getAccessToken(): array {
    // TODO: Implement getAccessToken() method.
  }
}