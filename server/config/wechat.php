<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/17
 * Time: 14:53
 */

//腾讯产品配置
return [
  'mini_program' => [
    'app_id' => '',
    'secret' => '',

    //小程序各种接口url
    'interface_url' => [
      //登录url地址
      'login_url' => 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code',
      //模板消息url地址
      'template_message_url' => 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=%s',
      //有数量限制的小程序码url 微信接口1
      'wxa_code_url' => 'https://api.weixin.qq.com/wxa/getwxacode?access_token=%s',
      //无数量限制的小程序码url 微信接口2
      'wxa_code_unlimit_url' => 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=%s',
      //有数量限制的小程序码url 微信接口3
      'qr_code_url' => 'https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=%s'
    ]
  ],

  //微信支付配置
  'payment' => [
    'app_id' => '',
    'mch_id' => '',
    'key' => '',
    'cert_path' => '',    // XXX: 绝对路径！！！！
    'key_path' => '',      // XXX: 绝对路径！！！！
    'interface_url' => 'https://api.mch.weixin.qq.com/pay/unifiedorder',
  ],

  //获取accessToken配置
  'access_token' => [
    'app_id' => '',
    'secret' => '',
    'interface_url' => 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s',
  ],

  //第三方登录
  'third_party_login' => [
    'app_id' => '',
    'secret' => '',
    'redirect_url' => '',
    'interface_url' => 'https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s'
  ]
];  