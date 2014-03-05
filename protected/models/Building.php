<?php

/**
 * This is the model class for table "building".
 *
 * The followings are the available columns in table 'building':
 * @property integer $id
 * @property string $adress
 * @property string $bname
 *		 * The followings are the available model relations:


 * @property Floor[] $floors
 */
class Building extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Building the static model class
	 */
	public static $modelLabelS='Здание';
	public static $modelLabelP='Здания';
	
	public $floorsid_building;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
			//'File'=>array(
			//	'class'=>'application.behaviors.FileBehavior',
			//	),
			//'DateBeginEnd'=>array(
			//	'class'=>'application.behaviors.DateBeginEndBehavior',
			//	),
			'PreFill'=>array(
				'class'=>'application.behaviors.PreFillBehavior',
				),
			);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'building';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('adress', 'length', 'max'=>100),
			array('bname', 'length', 'max'=>50),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, adress, bname,floorsid_building', 'safe', 'on'=>'search'),
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
			'floors' => array(self::HAS_MANY, 'Floor', 'id_building'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'adress' => 'Адрес',
			'bname' => 'Название',
			'floorsid_building' => 'Этаж',
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

		$criteria->with=array('floors' => array('alias' => 'floor'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('adress',$this->adress,true);
		$criteria->compare('bname',$this->bname,true);
		$criteria->compare('floor.fname',$this->floorsid_building,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}