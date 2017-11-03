<?php

// change the following paths if necessary
$yiic=dirname(__FILE__).'/../../yii/framework/yiic.php';
$yii = dirname(__FILE__) . '/../../framework/yii.php';
$config=dirname(__FILE__).'/config/main.php';

require_once($yiic);
require_once($yii);
Yii::createConsoleApplication($config)->run();
