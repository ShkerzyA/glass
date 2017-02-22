<?php

/**
 * This is the model class for table "call_log".
 *
 * The followings are the available columns in table 'call_log':
 * @property integer $id
 * @property string $timestamp
 * @property integer $code
 * @property string $direction
 * @property integer $calling_number
 * @property integer $called_number
 * @property integer $duration
 * @property double $cost
 */
class CallLogAuto extends CallLog
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CallLog the static model class
	 */
	public static $modelLabelS='Логи Звонков Автоматика';
	public static $modelLabelP='Логи Звонков Автоматика';
	
	


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'call_log';
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code', 'numerical', 'integerOnly'=>true),
			array('cost, duration', 'numerical'),
			array('calling_number,called_number', 'length', 'max'=>14),
			array('direction', 'length', 'max'=>250),
			array('timestamp,timestamp_end','safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, timestamp, code, direction, calling_number, called_number, duration, cost', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'timestamp' => 'Дата/Время',
			'timestamp_end' => 'До',
			'code' => 'Код',
			'direction' => 'Направление',
			'calling_number' => 'Вызывающий номер',
			'called_number' => 'Вызываемый номер',
			'duration' => 'Длительность(мин)',
			'cost' => 'Сумма',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($ret=NULL)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		if(!empty($this->timestamp)){
			if(!empty($this->timestamp_end)){
				$criteria->addCondition(array('condition'=>"t.timestamp>'".$this->timestamp." 00:00:00' and t.timestamp<'".$this->timestamp_end." 23:59:59'"));
			}else{
				$criteria->addCondition(array('condition'=>"t.timestamp>'".$this->timestamp." 00:00:00' and t.timestamp<'".$this->timestamp." 23:59:59'"));
			}
		}
		$criteria->compare('code',$this->code);
		$criteria->compare('direction',$this->direction,true);
		$criteria->compare('calling_number',$this->calling_number,true);
		$criteria->compare('called_number',$this->called_number,true);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('cost',$this->cost);

		if($ret){
			return self::model()->findAll($criteria);
		}else{
			return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                	'pageSize'=>100,
            	),
			));
		}
	}
}
