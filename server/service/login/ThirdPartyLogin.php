<?php

namespace service\login;


interface ThirdPartyLogin {

  public function login(string $code): array;

  public function getAccessToken(): array;
}