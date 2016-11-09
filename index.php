<?php

//入口文件
require __DIR__.'/bootstrap/autoload.php';


// 严格开发模式
error_reporting( E_ALL );
//ini_set('display_errors', 1);

// 永不超时
ini_set('max_execution_time', 0);
set_time_limit(0);
// 内存限制，如果外面设置的内存比 /etc/php/php-cli.ini 大，就不要设置了
if (intval(ini_get("memory_limit")) < 1024)
{
    ini_set('memory_limit', '1024M');
}

if( PHP_SAPI != 'cli' )
{
    exit("You must run the CLI environment\n");
}

// 设置时区
date_default_timezone_set('Asia/Shanghai');
define('PATH_ROOT', dirname(__FILE__));
define('FRAMEWORK_ROOT', PATH_ROOT.'/SpiderFramework');
define('PATH_DATA', PATH_ROOT.'/storage');

//系统配置
if( file_exists( PATH_ROOT."/config/inc_config.php" ) )
{
    require PATH_ROOT."/config/inc_config.php";
}

if ($argc != 2){
    echo '参数错误\n';
    echo '如运行糗事百科,请执行 php index qiushibaike';
    exit;
}

$app = 'app/'.$argv[1].'/index.php';

if (!is_file($app)) {
   die('没有该爬虫');
}


// 启动的时候生成data目录
util::path_exists(PATH_DATA."/lock");
util::path_exists(PATH_DATA."/log");
util::path_exists(PATH_DATA."/cache");
util::path_exists(PATH_DATA."/status");

require ($app);