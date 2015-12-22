<?php

/**
 * This is the model class for table "cars_mark".
 *
 * The followings are the available columns in table 'cars_mark':
 * @property integer $id
 * @property integer $producer
 * @property string $name
 *		 * The followings are the available model relations:


 * @property CarsProducer $producer0
 */
class CarsMark extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CarsMark the static model class
	 */
	public static $modelLabelS='CarsMark';
	public static $modelLabelP='CarsMark';
	
	public $producer0producer;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cars_mark';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('producer', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, producer, name,producer0producer', 'safe', 'on'=>'search'),
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
			'producer0' => array(self::BELONGS_TO, 'CarsProducer', 'producer'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'producer' => 'Producer',
			'name' => 'Name',
			'producer0producer' => 'producer',
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

		$criteria->with=array('producer0' => array('alias' => 'carsproducer'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('producer',$this->producer);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('carsproducer.producer',$this->producer0producer,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
