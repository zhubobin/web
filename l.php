<?php
$redis = new Redis();
$redis->connect('127.0.0.1',6379);

//存储数据到列表中
$redis->lpush("t", "Redis");
$redis->lpush("t", "Mongodb");
$redis->lpush("t", "Mysql");
$arList = $redis->lrange("t", 0, 5);

print_r($arList);
?>