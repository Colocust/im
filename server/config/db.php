<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/10/5
 * Time: 22:53
 */
return [
  'mongodb' => [
    //数据库名
    'db_name' => '',

    //连接地址 需要端口号
    'address' => '',

    //连接用户
    'user' => '',

    //连接密码
    'password' => ''

  ],
  'redis' => [
    //集群地址
    'host' => '127.0.0.1',

    //端口号
    'port' => '6379',

    //当客户端闲置多长时间后关闭连接
    'timeout' => '300',

    //db库的选择
    'db' => 1,
  ],

  'mysql' => [
    //集群地址
    'host' => 'localhost',

    //端口号
    'port' => 3306,

    //数据库名
    'database' => '',

    //用户名
    'username' => '',

    //密码
    'password' => ''
  ]
];