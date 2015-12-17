<?php

/**
 * This is the model class for table "vehicle_shedule".
 *
 * The followings are the available columns in table 'vehicle_shedule':
 * @property integer $id
 * @property string $date_begin
 * @property string $date_end
 * @property string $timestamp
 * @property string $timestamp_end
 * @property integer $creator
 * @property string $week
 * @property integer $weekdays
 * @property integer $holydays
 *		 * The followings are the available model relations:


 * @property Personnel $creator0
 */
class VehicleShedule extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VehicleShedule the static model class
	 */

	public static $beginDay='06'; //часы
	public static $endDay='22'; //часы
	public static $step='5'; //минуты
	public static $modelLabelS='Расписание въезда';
	public static $modelLabelP='Расписание въезда';
	public static $db_array=array('week');
	
	public $creator0creator;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vehicle_shedule';
	}

	public function checkNow(){
		$week=array(6,0,1,2,3,4,5);
		$now=new DateTime();
		$time=$now->format('H:i:s');
		if(!($this->timestamp<$time and $time<$this->timestamp_end))
			return false;
		$dow=$now->format('w');
		if($this->week[$week[$dow]]!=1)
			return false;
		return true;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('creator, weekdays, holydays', 'numerical', 'integerOnly'=>true),
			array('date_begin, date_end, timestamp, timestamp_end, week', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date_begin, date_end, timestamp, timestamp_end, creator, week, weekdays, holydays,creator0creator', 'safe', 'on'=>'search'),
		);
	}

	public function behaviors(){
	return array(
			'DateBeginEnd'=>array(
				'class'=>'application.behaviors.DateBeginEndBehavior',
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
			 'Log'=>array(
                'class'=>'application.behaviors.LogBehavior',
                )
			 );
	}


	/**
	 * @return array relational rules.
	 */
	public function nameL(){
		return $this->name();
	}
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'creator0' => array(self::BELONGS_TO, 'Personnel', 'creator'),
		);
	}

	public function name(){
		return '('.$this->date_begin.'/'.$this->date_end.') '.$this->timestamp.'-'.$this->timestamp_end.'['.$this->DaysOfWeek().']';
	}

	private function DaysOfWeek(){
		$res=array();
		$lb=array('Пн','Вт','Ср','Чт','Пт','Сб','Вс','Будни','Праздники');
		foreach ($this->week as $key => $v) {
			if($v==1)
				$res[]=$lb[$key];
		}
		if($this->weekdays==1)
			$res[]=$lb[7];
		if($this->holydays==1)
			$res[]=$lb[8];
		return implode(',',$res);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date_begin' => 'Дата начала',
			'date_end' => 'Дата окончания',
			'timestamp' => 'Время начала',
			'timestamp_end' => 'Время окончания',
			'creator' => 'Субъект',
			'week' => 'Неделя',
			'weekdays' => 'Будни',
			'holydays' => 'Праздники',
			'creator0creator' => 'Субъект',
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

		$criteria->with=array('creator0' => array('alias' => 'personnel'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('date_begin',$this->date_begin,true);
		$criteria->compare('date_end',$this->date_end,true);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('timestamp_end',$this->timestamp_end,true);
		$criteria->compare('creator',$this->creator);
		$criteria->compare('week',$this->week,true);
		$criteria->compare('weekdays',$this->weekdays);
		$criteria->compare('holydays',$this->holydays);
		$criteria->compare('personnel.creator',$this->creator0creator,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
