<?php

namespace service\payment;


class WeChatPay implements ThirdPartyPayment {
  //统一支付
  public function pay(array $params) {
    $params['appid'] = config('wechat.payment.app_id');
    $params['mch_id'] = config('wechat.payment.mch_id');
    $params['nonce_str'] = uniqid();
    $params['sign'] = $this->makeSign($params, config('wechat.payment.key'));
    $params["spbill_create_ip"] = get_client_ip();
    $response = curl_post(config('wechat.payment.interface_url'), toXML($params));
    return $response;
  }

  //生成签名
  private function makeSign(array $attributes, $key, $encryptMethod = 'md5') {
    ksort($attributes);
    $attributes['key'] = $key;
    return strtoupper(call_user_func_array($encryptMethod, [urldecode(http_build_query($attributes))]));
  }
}