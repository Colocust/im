<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/10/17
 * Time: 17:24
 */

namespace service\login;


interface ThirdPartyLogin {

  public function login(string $code): array;

  public function getAccessToken(): array;
}