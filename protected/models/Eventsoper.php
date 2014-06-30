<?php

/**
 * This is the model class for table "eventsoper".
 *
 * The followings are the available columns in table 'eventsoper':
 * @property integer $id
 * @property integer $id_room
 * @property string $date
 * @property string $timestamp
 * @property string $timestamp_end
 * @property string $fio_pac
 * @property integer $creator
 * @property integer $operator
 * @property string $date_gosp
 * @property string $brigade
 * @property integer $anesthesiologist
 * @property integer $operation
 * @property integer $type_operation
 *		 * The followings are the available model relations:


 * @property Personnel $creator0


 * @property Personnel $operator0


 * @property Personnel $anesthesiologist0


 * @property ListOperations $operation0


 * @property Rooms $idRoom
 */
class Eventsoper extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Eventsoper the static model class
	 */
	public static $modelLabelS='Eventsoper';
	public static $modelLabelP='Eventsoper';
	
	public $creator0creator;
public $operator0operator;
public $anesthesiologist0anesthesiologist;
public $operation0operation;
public $idRoomid_room;

	public function getTypeOper(){
		$status=array(  0 => 'полостная',
						1 => 'ангиографическая',
						2 => 'видеоэндохирургическая');
	

		return $status;
	}

	public function findEvents($showtype,$date){
		switch ($showtype){
			case 'day':
					$week['begin']=clone $date;
					$criteria=array('condition'=>'t.id_room='.Yii::app()->session['Rooms_id'].' and ((t.date=\''.$week['begin']->format('Y-m-d').'\') )');
					//$events=Events::model()->findAll();	
				break;
			case 'week':
					$week['begin']=clone $date;
					$dow=$week['begin']->format('N');
					$week['begin']->modify('-'.($dow-1).' days');
					$week['end']=clone Yii::app()->session['Rooms_date'];
					$week['end']->modify('+'.(7-$dow).' days'); 
					$criteria=array('condition'=>'t.id_room='.Yii::app()->session['Rooms_id'].' and ((t.date>=\''.$week['begin']->format('Y-m-d').'\' and t.date<=\''.$week['end']->format('Y-m-d').'\') )','order'=>'t.date ASC');
					//$events=Events::model()->findAll(array('condition'=>'t.id_room='.Yii::app()->session['Rooms_id'].' and ((t.date>=\''.$week['begin']->format('Y-m-d').'\' and t.date<=\''.$week['end']->format('Y-m-d').'\') or t.repeat is not null)','order'=>'t.date ASC'));	
				# code...
				break;
			
			default:
				# code...
				break;	
			}
			$events=Events::model()->findAll($criteria);
			return array('week'=>$week,'events'=>$events);
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'eventsoper';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_room, creator, operator, anesthesiologist, operation, type_operation', 'numerical', 'integerOnly'=>true),
			array('fio_pac', 'length', 'max'=>250),
			array('date, timestamp, timestamp_end, date_gosp, brigade', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_room, date, timestamp, timestamp_end, fio_pac, creator, operator, date_gosp, brigade, anesthesiologist, operation, type_operation,creator0creator,operator0operator,anesthesiologist0anesthesiologist,operation0operation,idRoomid_room', 'safe', 'on'=>'search'),
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
			'creator0' => array(self::BELONGS_TO, 'Personnel', 'creator'),
			'operator0' => array(self::BELONGS_TO, 'Personnel', 'operator'),
			'anesthesiologist0' => array(self::BELONGS_TO, 'Personnel', 'anesthesiologist'),
			'operation0' => array(self::BELONGS_TO, 'ListOperations', 'operation'),
			'idRoom' => array(self::BELONGS_TO, 'Rooms', 'id_room'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_room' => 'Id Room',
			'date' => 'Date',
			'timestamp' => 'Timestamp',
			'timestamp_end' => 'Timestamp End',
			'fio_pac' => 'Fio Pac',
			'creator' => 'Creator',
			'operator' => 'Operator',
			'date_gosp' => 'Date Gosp',
			'brigade' => 'Brigade',
			'anesthesiologist' => 'Anesthesiologist',
			'operation' => 'Operation',
			'type_operation' => 'Type Operation',
			'creator0creator' => 'creator',
			'operator0operator' => 'operator',
			'anesthesiologist0anesthesiologist' => 'anesthesiologist',
			'operation0operation' => 'operation',
			'idRoomid_room' => 'id_room',
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

		$criteria->with=array('creator0' => array('alias' => 'personnel_c'),'operator0' => array('alias' => 'personnel_o'),'anesthesiologist0' => array('alias' => 'personnel_a'),'operation0' => array('alias' => 'listoperations'),'idRoom' => array('alias' => 'rooms'),);
		$criteria->compare('id',$this->id);
		if(!empty($_GET['id_room']))
				$criteria->compare('id_room',$_GET['id_room']);
		else
				$criteria->compare('id_room',$this->id_room);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('timestamp_end',$this->timestamp_end,true);
		$criteria->compare('fio_pac',$this->fio_pac,true);
		if(!empty($_GET['creator']))
				$criteria->compare('creator',$_GET['creator']);
		else
				$criteria->compare('creator',$this->creator);
		if(!empty($_GET['operator']))
				$criteria->compare('operator',$_GET['operator']);
		else
				$criteria->compare('operator',$this->operator);
		$criteria->compare('date_gosp',$this->date_gosp,true);
		$criteria->compare('brigade',$this->brigade,true);
		if(!empty($_GET['anesthesiologist']))
				$criteria->compare('anesthesiologist',$_GET['anesthesiologist']);
		else
				$criteria->compare('anesthesiologist',$this->anesthesiologist);
		if(!empty($_GET['operation']))
				$criteria->compare('operation',$_GET['operation']);
		else
				$criteria->compare('operation',$this->operation);
		$criteria->compare('type_operation',$this->type_operation);
		$criteria->compare('personnel_c.creator',$this->creator0creator,true);
		$criteria->compare('personnel_o.operator',$this->operator0operator,true);
		$criteria->compare('personnel_a.anesthesiologist',$this->anesthesiologist0anesthesiologist,true);
		$criteria->compare('listoperations.operation',$this->operation0operation,true);
		$criteria->compare('rooms.id_room',$this->idRoomid_room,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
