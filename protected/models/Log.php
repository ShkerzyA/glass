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
class Log extends CActiveRecord
{
	/**f
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EquipmentLog the static model class
	 */
	public static $modelLabelS='Лог';
	public static $modelLabelP='Логи';

	public static $db_array=array('details');
	public static $typeM=array(
				0=>array('action'=>'add','name'=>'Добавление'),
				1=>array('action'=>'change','name'=>'Изменение'),
			);
	
	public $subject0subject;
	public $object0object;
	public $timestamp_end;
	public $confirm;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function filterType(){
		$res=array();
		foreach (self::$typeM as $key => $value) {
			$res[$key]=$value['name'];
		}
		return $res;
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
		return 'log';
	}

	protected function afterFind(){
		if(!empty($this->object_model))
			$this->metaData->addRelation('object',array(self::BELONGS_TO, $this->object_model, 'object_id'));
	}

	public function saveLog($action,$data){

			foreach(self::$typeM as $k=>$v){
				if($v['action']==$action){
					$this->type=$k;
				}
			}
			if(!isset($this->type))
				return false;

			if(!empty($data['timestamp']))
				$this->timestamp=$data['timestamp'];

			if(!empty($data['object_model']))
				$this->object_model=$data['object_model'];

			if(!empty($data['object_id']))
				$this->object_id=$data['object_id'];

			$this->details=$data['details'];
			if($this->save()){
				return true;
			}else{
				return false;
			}

	}


	public function subjectList(){
		$res=array();
		if(!empty(Yii::app()->user->id_departments[0]))
			$res=DepartmentPosts::colleagues(Yii::app()->user->id_departments[0]);
		//Тут находим всех коллег, и выводим списком
		return $res;
	}



	public function getType(){
		if(isset($this->type))
			return self::$typeM[$this->type];
		else
			return self::$typeM;
	}

	public function listSubject(){
		$res=array();
		$criteria = new CDbCriteria;
		$criteria->select = "subject";
		$criteria->with=array('subject0');

            //$criteria->compare('type',$_POST['type']);
            //$criteria->compare('producer',$_POST['producer']);
			//$criteria->condition = "type=:type and producer=:producer";
			//$criteria->params = array(':type'=>$_POST['type'],':producer'=>$_POST['producer']);
		$criteria->distinct = True;
		$models=self::model()->findAll($criteria);
		foreach ($models as $v) {
			$res[$v->subject0->surname]=$v->subject0->fio();
		}
		return $res;
	}

	public function listObjectModels(){
		$res=array();
		$criteria = new CDbCriteria;
		$criteria->select = "object_model";

            //$criteria->compare('type',$_POST['type']);
            //$criteria->compare('producer',$_POST['producer']);
			//$criteria->condition = "type=:type and producer=:producer";
			//$criteria->params = array(':type'=>$_POST['type'],':producer'=>$_POST['producer']);
		$criteria->distinct = True;
		$models=self::model()->findAll($criteria);
		foreach ($models as $v) {
			$model_name=$v->object_model;
			$res[$v->object_model]=$model_name::$modelLabelS;
		}
		return $res;
	}



	public function details(){
		switch ($this->type) {
			case '1':
				return 'Измененные поля: '.implode(',', $this->details);
				break;

			
			default:
				return implode(',', $this->details);
				break;
		}
	}

	public function details_full(){
		switch ($this->type) {
			case '1':
				return 'Измененные поля: '.implode(',', $this->details);
				break;

			
			default:
				return implode(', ', $this->details);
				break;
		}
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('confirm', 'numerical', 'integerOnly'=>true),
			array('subject, object_id, type', 'numerical', 'integerOnly'=>true),
			array('details','pgArray'),
			array('timestamp,timestamp_end, details, object_model','safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, timestamp, timestamp_end, subject,object_id,object_model,type,details,subject0subject,object0object,confirm', 'safe', 'on'=>'search'),
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
			//'object' => array(self::BELONGS_TO, $this->object_model, 'object_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'timestamp' => 'Дата/время действия',
			'timestamp_end' => 'Опциональный фильтр',
			'subject' => 'Субъект',
			'object_model' => 'Модель',
			'object_id' => 'Объект',
			'type' => 'Тип действия',
			'details' => 'Детали',
			'subject0subject' => 'Субъект',
			'object0object' => 'Объект',
			'confirm' => 'Подтвердить действие',
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

		$criteria->with=array('subject0' => array('alias' => 'personnel'));
		
		if(!empty($this->details))
			$criteria->addCondition(array('condition'=>"'".$this->details."'=ANY(t.details)"));
		$criteria->compare('t.id',$this->id);
		if(!empty($this->timestamp)){
			if(!empty($this->timestamp_end)){
				$criteria->addCondition(array('condition'=>"t.timestamp>'".$this->timestamp." 00:00:00' and t.timestamp<'".$this->timestamp_end." 23:59:59'"));
			}else{
				$criteria->addCondition(array('condition'=>"t.timestamp>'".$this->timestamp." 00:00:00' and t.timestamp<'".$this->timestamp." 23:59:59'"));
			}
		}
		//$criteria->compare('t."timestamp"::text',$this->timestamp,true);
		$criteria->compare('subject',$this->subject);
		$criteria->compare('object_model',$this->object_model);
		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('t.type',$this->type);
		$criteria->compare('personnel.surname',$this->subject0subject,true);
		$criteria->compare('equipment.inv',$this->object0object,true, 'OR');
		$criteria->compare('equipment.serialf',$this->object0object,true,'OR');

		$criteria->order='t.timestamp DESC, t.type DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
