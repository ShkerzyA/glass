<?php

/**
 * This is the model class for table "equipment_log".
 *
 * The followings are the available columns in table 'equipment_log':
 * @property integer $id
 * @property string $timestamp
 * @property integer $subject
 * @property integer $object
 * @property string $details
 *		 * The followings are the available model relations:


 * @property Personnel $subject0


 * @property Equipment $object0
 */
class EquipmentLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EquipmentLog the static model class
	 */
	public static $modelLabelS='EquipmentLog';
	public static $modelLabelP='EquipmentLog';
	
	public $subject0subject;
public $object0object;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'equipment_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject, object', 'numerical', 'integerOnly'=>true),
			array('details', 'length', 'max'=>255),
			array('timestamp', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, timestamp, subject, object, details,subject0subject,object0object', 'safe', 'on'=>'search'),
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
			'subject0' => array(self::BELONGS_TO, 'Personnel', 'subject'),
			'object0' => array(self::BELONGS_TO, 'Equipment', 'object'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'timestamp' => 'Timestamp',
			'subject' => 'Subject',
			'object' => 'Object',
			'details' => 'Details',
			'subject0subject' => 'subject',
			'object0object' => 'object',
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

		$criteria->with=array('subject0' => array('alias' => 'personnel'),'object0' => array('alias' => 'equipment'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('timestamp',$this->timestamp,true);
		if(!empty($_GET['subject']))
				$criteria->compare('subject',$_GET['subject']);
		else
				$criteria->compare('subject',$this->subject);
		if(!empty($_GET['object']))
				$criteria->compare('object',$_GET['object']);
		else
				$criteria->compare('object',$this->object);
		$criteria->compare('details',$this->details,true);
		$criteria->compare('personnel.subject',$this->subject0subject,true);
		$criteria->compare('equipment.object',$this->object0object,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
