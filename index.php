<?php
//echo 'Im alive';
//die();
// change the following paths if necessary
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$yii=dirname(__FILE__).'/../yii/framework/yii.php';
if(in_array($_SERVER['SERVER_NAME'],array('localhost'))){
	$config=dirname(__FILE__).'/protected/config/dev.php';
	defined('YII_DEBUG') or define('YII_DEBUG',true);
	defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
}else{
	$config=dirname(__FILE__).'/protected/config/main.php';
}
require_once($yii);
Yii::createWebApplication($config)->run();
