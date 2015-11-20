<?php

/**
 * This is the model class for table "log".
 *
 * The followings are the available columns in table 'log':
 * @property integer $id
 * @property string $timestamp
 * @property integer $subject
 * @property string $object_model
 * @property integer $object_id
 * @property integer $type
 * @property string $details
 *		 * The followings are the available model relations:


 * @property Personnel $subject0
 */
class Log extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Log the static model class
	 */
	public static $modelLabelS='Log';
	public static $modelLabelP='Log';
	
	public $subject0subject;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject, object_id, type', 'numerical', 'integerOnly'=>true),
			array('timestamp, object_model, details', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, timestamp, subject, object_model, object_id, type, details,subject0subject', 'safe', 'on'=>'search'),
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
			'object_model' => 'Object Model',
			'object_id' => 'Object',
			'type' => 'Type',
			'details' => 'Details',
			'subject0subject' => 'subject',
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

		$criteria->with=array('subject0' => array('alias' => 'personnel'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('subject',$this->subject);
		$criteria->compare('object_model',$this->object_model,true);
		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('details',$this->details,true);
		$criteria->compare('personnel.subject',$this->subject0subject,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
