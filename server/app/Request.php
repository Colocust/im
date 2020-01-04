<?php

namespace api;

class Request {
  /**
   * @param API $api
   * @return static
   */
  public static function fromAPI(API $api) {
    return static::cast($api->getRequest());
  }

  /**
   * @param Request $request
   * @return static
   */
  public static function cast(Request $request) {
    return $request;
  }
}