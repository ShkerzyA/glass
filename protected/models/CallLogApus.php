<?php

/**
 * This is the model class for table "call_log_apus".
 *
 * The followings are the available columns in table 'call_log_apus':
 * @property integer $id
 * @property string $timestamp
 * @property string $tarif
 * @property double $duration
 * @property integer $quantity
 * @property double $cost
 * @property string $calling_number
 */
class CallLogApus extends CallLog
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CallLogApus the static model class
	 */
	public static $modelLabelS='Лог Звонков АПУС';
	public static $modelLabelP='Лог Звонков АПУС';
	
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'call_log_apus';
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
			array('quantity', 'numerical', 'integerOnly'=>true),
			array('duration, cost', 'numerical'),
			array('tarif', 'length', 'max'=>250),
			array('calling_number', 'length', 'max'=>14),
			array('timestamp,timestamp_end', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, timestamp, timestamp_end, tarif, duration, quantity, cost, calling_number', 'safe', 'on'=>'search'),
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
			'timestamp' => 'Дата',
			'timestamp_end' => 'До',
			'tarif' => 'Тариф',
			'duration' => 'Длительность',
			'quantity' => 'Количество',
			'cost' => 'Сумма',
			'calling_number' => 'Вызывающий номер',
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
		$criteria->compare('tarif',$this->tarif,true);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('calling_number',$this->calling_number,true);

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
