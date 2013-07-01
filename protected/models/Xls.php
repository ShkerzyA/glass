<?php

/**
 * This is the model class for table "sex".
 *
 * The followings are the available columns in table 'sex':
 * @property integer $id
 * @property string $name
 */
class Xls extends CFormModel{
	public $xls;
 
    public function rules(){
        return array(
            array('xls', 'file'),
        );
    } 

}