<?php

/**
 * This is the model class for table "equipment".
 *
 * The followings are the available columns in table 'equipment':
 * @property integer $id
 * @property integer $id_workplace
 * @property string $serial
 * @property integer $type
 * @property integer $producer
 * @property string $mark
 * @property string $inv
 * @property integer $status
 * @property string $notes
 *		 * The followings are the available model relations:


 * @property Workplace $idWorkplace
 */
class Equipment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Equipment the static model class
	 */
	public static $modelLabelS='Оборудование';
	public static $modelLabelP='Оборудование';
	
	public $idWorkplaceid_workplace;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'equipment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_workplace, type, producer, status', 'numerical', 'integerOnly'=>true),
			array('serial, inv', 'length', 'max'=>100),
			array('mark', 'length', 'max'=>200),
			array('notes', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_workplace, serial, type, producer, mark, inv, status, notes,idWorkplaceid_workplace', 'safe', 'on'=>'search'),
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
			'idWorkplace' => array(self::BELONGS_TO, 'Workplace', 'id_workplace'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_workplace' => 'Рабочее место',
			'serial' => 'Серийный номер',
			'type' => 'Тип',
			'producer' => 'Производитель',
			'mark' => 'Модель',
			'inv' => 'Инвентарный номер',
			'status' => 'Состояние',
			'notes' => 'Примечания',
			'idWorkplaceid_workplace' => 'Рабочее место',
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

		$criteria->with=array('idWorkplace' => array('alias' => 'workplace'),);
		$criteria->compare('id',$this->id);
		if(!empty($_GET['id_workplace']))
				$criteria->compare('id_workplace',$_GET['id_workplace']);
		else
				$criteria->compare('id_workplace',$this->id_workplace);
		$criteria->compare('serial',$this->serial,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('producer',$this->producer);
		$criteria->compare('mark',$this->mark,true);
		$criteria->compare('inv',$this->inv,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('workplace.id_workplace',$this->idWorkplaceid_workplace,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
