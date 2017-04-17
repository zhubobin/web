<?php
/**
 * 配置文件
 */
return array(
    'DB_TYPE' => 'mysqli',
    'DB_HOST' => '192.168.1.109',
    'DB_NAME' => 'phonelive',
//    'DB_USER' => 'phonelive',
//    'DB_PWD' => 'tieweishivps',
    'DB_USER' => 'root',
    'DB_PWD' => 'qq123',
    'DB_PORT' => '3306',
    'DB_PREFIX' => 'cmf_',
						
	/* redis */
	'REDIS_HOST' => "localhost",
	'REDIS_AUTH' => "tieweishivps",
    //密钥
    "AUTHCODE" => 'rCt52pF2cnnKNB3Hkp',
    //cookies
    "COOKIE_PREFIX" => 'AJ1sOD_',
);
