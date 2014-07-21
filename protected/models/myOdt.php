<?php

/**
 * This is the model class for table "sex".
 *
 * The followings are the available columns in table 'sex':
 * @property integer $id
 * @property string $name
 */

$odfPath  = Yii::getPathOfAlias('ext.odtphp');
require_once($odfPath . DIRECTORY_SEPARATOR . 'library/odf.php');


class myOdt extends odf{
}