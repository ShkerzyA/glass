<?php

/**
 * This is the model class for table "cars_producer".
 *
 * The followings are the available columns in table 'cars_producer':
 * @property integer $id
 * @property string $name
 *		 * The followings are the available model relations:


 * @property CarsMark[] $carsMarks
 */
class CarsProducer extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CarsProducer the static model class
	 */
	public static $modelLabelS='CarsProducer';
	public static $modelLabelP='CarsProducer';
	
	public $carsMarksproducer;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cars_producer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>100),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name,carsMarksproducer', 'safe', 'on'=>'search'),
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
			'carsMarks' => array(self::HAS_MANY, 'CarsMark', 'producer'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'carsMarksproducer' => 'producer',
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

		$criteria->with=array('carsMarks' => array('alias' => 'carsmark'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('carsmark.producer',$this->carsMarksproducer,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
