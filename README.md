im
========

使用`Swoole4`+`Vue2.0`实现的即时聊天工具。

* 使用`MongoDB`存储数据
* 使用`Redis`存储uid与线程id之间的关系

   
扩展
---- 
需要`Swoole-4.4.7`或更高版本

    pecl install swoole
   
需要`MongoDB-4.2.1`或更高版本

    pecl install mongodb
    
需要`Redis-5.0.2`或更高版本

    pecl install redis
    
启动WebSocket服务
---- 
    php WebSocketServer.php
    
步骤
---
    1、用户id与线程id的绑定，我在这里使用的redis集合来实现的。WebSocket连接成功后会向Server传一个uid，此时便与线程id进行绑定。代码可参考WebSocketServer类中的onOpen方法。
    
    2、在消息发送成功后Client会自行更新消息列表,Server触发onMessage事件后会向redis拿指定用户(该消息的接收者)的线程id并进行push操作。代码可参考WebSocketServer类中的onMessage方法。
    
    3、Client触发onmessage事件后会拿到消息内容并更新本地消息列表。
    
        
体验地址
---
![image](http://qim.colocust.cn/images/qim.png)

    
End
--- 
    为什么要做这个？
    
    长连接一直是我的一个心结。
    
    大三第一次实习时,Boss让我做一个类似头脑王者的小游戏.而当时的我根本算不上一个coder,遇到问题只会百度,没有独立思考并解决问题的习惯,就这样折腾了1个多月也毫无进展。再加上那会儿心态上的不成熟,那次实习也给我留下了较大阴影。就这样,长连接成为了我必须攻克的技术。快两年过去了(准确说应该是快两年后才想起来还有这么一回事儿),终于还是做了个小demo出来。
    
    这个demo吧其实有很多不合理的地方,但目前来说我只想实现消息的互通,后续会不断的完善。
    
    最后,感谢我鸡哥和刚哥的help,让我能顺利完成前端的开发。
 
    
   
