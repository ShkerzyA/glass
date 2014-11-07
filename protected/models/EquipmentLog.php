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
	/**f
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EquipmentLog the static model class
	 */
	public static $modelLabelS='Лог оборудования';
	public static $modelLabelP='Логи оборудования';

	public static $db_array=array('details');
	public static $typeM=array(
				0=>array('name'=>'Перемещение оборудования','fields'=>array('old_workplace','workplace')),
				1=>array('name'=>'Установка картриджа','fields'=>array('workplace','id_printer')),
				2=>array('name'=>'Проверка счетчика принтера','fields'=>array('num_str')),
				3=>array('name'=>'Отправка на заправку','fields'=>array('idcart')),
				4=>array('name'=>'Возврат с заправки','fields'=>array('idcart')),
				5=>array('name'=>'Возврат картриджа','fields'=>array('workplace')),
			);
	
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
		if(isset($this->type))
			return self::$typeM[$this->type];
		else
			return self::$typeM;
	}

	public function details(){
		$det=explode(',', $this->details);
		switch ($this->type) {
			case '0':
				return 'Откуда: '.$det[0].' Куда: '.$det[1];
				break;
			case '1':
				return 'Рабочее место: '.$det[0].' Принтер: '.$det[1];
				break;
			case '2':
				return 'Число отпечатков: '.$det[0];
				break;

			case '3':
			case '4':
				return 'номера картриджей: '.$det[0];
				break;

			case '5':
				return 'Рабочее место: '.$det[0];
				break;

			
			default:
				return implode(',', $det);
				break;
		}
	}

		public function details_full(){
		$det=explode(',', $this->details);
		switch ($this->type) {
			case '0':
				return 'Откуда: '.Workplace::model()->findByPk($det[0])->wpNameFull()."\n\n Куда: ".Workplace::model()->findByPk($det[1])->wpNameFull();
				break;
			case '1':
				$printer=(isset($det[1]))?Equipment::model()->findByPk($det[1])->full_name():'';
				return 'Рабочее место: '.Workplace::model()->findByPk($det[0])->wpNameFull()."\n Принтер: $printer";
				break;
			case '2':
				return 'Число отпечатков: '.$det[0];
				break;
			case '3':
			case '4':
				return 'номера картриджей: '.implode(', ',$det);
				break;

			case '5':
				return 'Рабочее место: '.Workplace::model()->findByPk($det[0])->wpNameFull();
				break;
			
			default:
				return implode(', ', $det);
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
			'objectEq' => array(self::BELONGS_TO, 'Equipment', 'object'),
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
			'subject' => 'Субъект',
			'object' => 'Объект',
			'type' => 'Тип действия',
			'details' => 'Детали',
			'subject0subject' => 'Субъект',
			'object0object' => 'Объект',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */

	public function search_for_export_cart(){
		$data=array();
		$criteria=new CDbCriteria;
		$criteria->with=array('subject0','objectEq.idWorkplace.idPersonnel','objectEq.idWorkplace.idCabinet.idFloor.idBuilding'); // 
		$criteria->order='t.timestamp DESC';
		$criteria->condition='t.type in (1,2)';
		//$criteria->compare('personnel.creator',$this->creator0creator,true);
		$model=self::model()->findAll($criteria);

		foreach ($model as $v) {
			$v->details=explode(',', $v->details);
			if($v->type==2){
				$data[$v->timestamp]['timestamp']=$v->timestamp;
				$data[$v->timestamp]['fio']=$v->subject0->fio();
				$data[$v->timestamp]['place']=$v->objectEq->idWorkplace->wpNameFull();
				$data[$v->timestamp]['printer']=$v->objectEq->full_name();
				$data[$v->timestamp]['printerSN']=$v->objectEq->serial;
				$data[$v->timestamp]['num_st']=$v->details[0];
			}else if($v->type==1){
				$data[$v->timestamp]['in_cart_inv']=$v->objectEq->inv;
				$data[$v->timestamp]['in_cart_mark']=$v->objectEq->mark;
			}else if($v->type==5){
				$data[$v->timestamp]['out_cart_inv']=$v->objectEq->inv;
				$data[$v->timestamp]['out_cart_mark']=$v->objectEq->mark;
			}
			
		}

		return $data;

	}


	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with=array('subject0' => array('alias' => 'personnel'),'objectEq' => array('alias' => 'equipment'),);
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t."timestamp"::text',$this->timestamp,true);
		$criteria->compare('subject',$this->subject);
		$criteria->compare('object',$this->object);
		$criteria->compare('t.type',$this->type);
		$criteria->compare('t.details',$this->details,true);
		$criteria->compare('personnel.surname',$this->subject0subject,true);
		$criteria->compare('equipment.inv',$this->object0object,true, 'OR');
		$criteria->compare('equipment.serial',$this->object0object,true,'OR');

		$criteria->order='t.timestamp DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
