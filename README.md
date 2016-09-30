# stock-trade-workerman
采用workerman框架实现的真实股票交易服务端 <br />

#介绍
这是一个使用php实现的可多并发、长连接的股票交易服务端。<br />
该服务端通过使用t2sdk php扩展连接恒生开放平台，进行股票交易。 <br />
该项目使用workerman长连接php框架, monolog日志输出，t2sdk扩展链接。 <br />
目前消息传递（请求发送和返回数据）均采用的是json格式

#使用教程
1. 需要安装t2sdk扩展，请参见(https://github.com/caizixingit/php-t2sdk-ext). 很久没有使用c++，代码方面有点捉急，见谅~~~ <br />
2. 恒生开放平台注册测试账号，需要下载libt2sdk.so和t2sdk.ini，该文件不再项目中，需要另行配置。。。 <br />
3. 在目录T2Gateway/Config/T2Config.php目录下，需要将刚才下载的libt2sdk.so和t2sdk.ini文件地址配置好。 <br/>
4. php start.php start开启服务
5. T2Gateway/cmd文件包含了目前支持的几个接口

#参考
workerman(https://github.com/walkor/Workerman) <br />
monolog(https://github.com/Seldaek/monolog) <br />
t2sdk(https://github.com/caizixingit/php-t2sdk-ext) <br />