<?php

/**
 * This is the model class for table "vehicles".
 *
 * The followings are the available columns in table 'vehicles':
 * @property integer $id
 * @property integer $owner
 * @property string $mark
 * @property string $number
 * @property integer $deactive
 * @property integer $status
 *		 * The followings are the available model relations:


 * @property Personnel $owner0
 */
class Vehicles extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Vehicles the static model class
	 */
	public static $modelLabelS='Транспорт';
	public static $modelLabelP='Транспорт';

	public static $status=array('1'=>'Вне территории','2'=>'На территории');
	
	public $owner0owner;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vehicles';
	}

	public function getStatus(){
		if(!empty($this->status))
			return self::$status[$this->status];
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('owner, deactive, status', 'numerical', 'integerOnly'=>true),
			array('owner,mark,number','required'),
			array('mark', 'length', 'max'=>200),
			array('number', 'length', 'max'=>10),
			array('shedule', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, owner, mark, number, deactive,shedule, status,owner0owner', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'owner0' => array(self::BELONGS_TO, 'Personnel', 'owner'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'owner' => 'Владелец',
			'mark' => 'Марка',
			'number' => 'Номер',
			'deactive' => 'Запрет',
			'status' => 'Статус',
			'shedule' => 'Расписание въезда',
			'owner0owner' => 'Владелец',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with=array('owner0' => array('alias' => 'personnel'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('owner',$this->owner);
		$criteria->compare('mark',$this->mark,true);
		$criteria->compare('number',$this->number,true);
		$criteria->compare('deactive',$this->deactive);
		$criteria->compare('status',$this->status);
		$criteria->compare('shedule',$this->shedule,true);
		$criteria->compare('personnel.owner',$this->owner0owner,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
