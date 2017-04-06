<?php

/**
 * This is the model class for table "vacation".
 *
 * The followings are the available columns in table 'vacation':
 * @property string $id
 * @property integer $type
 * @property string $startdate
 * @property string $enddate
 * @property string $orgbase_rn
 *		 * The followings are the available model relations:


 * @property Personnel $orgbaseRn
 */
class Vacation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Vacation the static model class
	 */
	public static $modelLabelS='Отпуск';
	public static $modelLabelP='Отпуска';
	
	public $orgbaseRnorgbase_rn;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vacation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('id, orgbase_rn', 'length', 'max'=>6),
			array('startdate, enddate', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, startdate, enddate, orgbase_rn,orgbaseRnorgbase_rn', 'safe', 'on'=>'search'),
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
			'orgbaseRn' => array(self::BELONGS_TO, 'Personnel', 'orgbase_rn','order'=>'"personnel".surname ASC'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Тип',
			'startdate' => 'Начало отпуска',
			'enddate' => 'Конец отпуска',
			'orgbase_rn' => 'Сотрудник',
			'orgbaseRnorgbase_rn' => 'Сотрудник',
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

		$criteria->with=array('orgbaseRn' => array('alias' => 'personnel'),);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);
		$criteria->compare('orgbase_rn',$this->orgbase_rn,true);
		$criteria->compare('personnel.orgbase_rn',$this->orgbaseRnorgbase_rn,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
