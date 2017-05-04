<?php

/**
 * This is the model class for table "sex".
 *
 * The followings are the available columns in table 'sex':
 * @property integer $id
 * @property string $name
 */

$odfPath  = Yii::getPathOfAlias('ext.odtphp.lib');
Yii::setPathOfAlias('Odtphp',Yii::getPathOfAlias('ext.odtphp.src'));
require_once($odfPath . DIRECTORY_SEPARATOR . 'pclzip.lib.php');


class myOdt extends Odtphp\Odf{
}