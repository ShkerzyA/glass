<?php

/**
 * This is the model class for table "equipment_log".
 *
 * The followings are the available columns in table 'equipment_log':
 * @property integer $id
 * @property string $timestamp
 * @property integer $subject
 * @property integer $object
 * @property integer $type
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

	public static $db_array=array('details');
	
	public $subject0subject;
	public $object0object;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function behaviors(){
	return array(
			'TimeStamp'=>array(
				'class'=>'application.behaviors.TimeStampBehavior',
				),
			'PreFill'=>array(
				'class'=>'application.behaviors.PreFillBehavior',
				),
			'FixedOwner'=>array(
				'class'=>'application.behaviors.FixedOwnerBehavior',
				),
			'DbArray'=>array(
				'class'=>'application.behaviors.DbArrayBehavior',
				),
			);
	}


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'equipment_log';
	}


	public function getType(){
		return array(
				0=>array('name'=>'Перемещение','fields'=>array('workplace')),
				1=>array('name'=>'Замена картриджа','fields'=>array('workplace','id_printer','serial_printer')),
				2=>array('name'=>'Проверка счетчика принтера','fields'=>array('num_str')),
			);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject, object, type', 'numerical', 'integerOnly'=>true),
			array('details','pgArray'),
			array('timestamp, details', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, timestamp, subject, object, type, details,subject0subject,object0object', 'safe', 'on'=>'search'),
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
			'type' => 'Type',
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
		$criteria->compare('subject',$this->subject);
		$criteria->compare('object',$this->object);
		$criteria->compare('type',$this->type);
		$criteria->compare('details',$this->details,true);
		$criteria->compare('personnel.subject',$this->subject0subject,true);
		$criteria->compare('equipment.object',$this->object0object,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
