im
========

使用`Swoole4`+`Angular`实现的WebApp即时聊天工具。

* 基于`Swoole4`协程实现，可以同时支持数百万`TCP`连接在线
* 使用`MongoDB`存储数据
* 使用`Redis`存储uid以及线程id之间的关系

   
扩展
---- 
需要`Swoole-4.4.7`或更高版本

    pecl install swoole
   
需要`MongoDB-4.2.1`或更高版本

    pecl install mongodb
    
需要`Redis-5.0.2`或更高版本

    pecl install redis
    
### 启动服务器
    php WebSocketServer.php
