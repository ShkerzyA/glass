<?php
// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
if(in_array($_SERVER['SERVER_NAME'],array('localhost','127.0.0.1','10.126.85.159'))){
	$config=dirname(__FILE__).'/protected/config/dev.php';
	defined('YII_DEBUG') or define('YII_DEBUG',true);
	defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
}else{
	$config=dirname(__FILE__).'/protected/config/main.php';
}
// remove the following lines when in production mode

require_once($yii);
Yii::createWebApplication($config)->run();
