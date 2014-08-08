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
class Eventsoper extends Events
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Eventsoper the static model class
	 */
	public static $beginDay='08'; //часы
	public static $endDay='17'; //часы
	public static $step='5'; //минуты
	public static $modelLabelS='Операция';
	public static $modelLabelP='Операции';
	public $operator0operator;
	public $anesthesiologist0anesthesiologist;
	public $operation0operation;
	public $eventsopersid_eventsoper;
	public $idEventsoperid_eventsoper;

	public function getTypeOper($view='array'){
		$status=array(  0 => 'полостная',
						1 => 'ангиографическая',
						2 => 'видеоэндохирургическая',
						3 => 'минимально инвазивная',
						4 => 'внеполостная',
					);

		switch ($view) {
			case 'label':
				return $status[$this->type_operation];
				break;

			case 'array':
			default:
				return $status;
				break;
		}
	}

	public function getStatus(){
		$status=array(  0 => 'План',
						1 => 'Подтверждено',
						2 => 'Мониторинг',
						3 => 'Мониторинг',);
	

		return $status;
	}

	public function gimmeStatus(){
		$status=array(  0 => array('label'=>'План','css_class'=>'open'),
						1 => array('label'=>'Подтверждено','css_class'=>'done '),
						2 => array('label'=>'Мониторинг','css_class'=>'done '),
						3 => array('label'=>'Мониторинг','css_class'=>'done turnws10'));
		return $status[$this->status];
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
			array('id_room,date,operator, timestamp, timestamp_end, fio_pac', 'required'),
			array('id_room, creator, operator, anesthesiologist, operation, type_operation, id_eventsoper', 'numerical', 'integerOnly'=>true),
			array('fio_pac', 'length', 'max'=>250),
			array('date, timestamp, timestamp_end, date_gosp, brigade', 'safe'),
			array('id','freeOnly'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_room, date, timestamp, timestamp_end, status, fio_pac, creator, operator, date_gosp, brigade, id_eventsoper, anesthesiologist, operation, type_operation,creator0creator,operator0operator,anesthesiologist0anesthesiologist,operation0operation,idRoomid_room', 'safe', 'on'=>'search'),
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
            'idEventsoper' => array(self::BELONGS_TO, 'Eventsoper', 'id_eventsoper'),
            'eventsopers' => array(self::HAS_ONE, 'Eventsoper', 'id_eventsoper'),
		);
	}

	public function isShow($date){
		$pass=false;
		if($date->format('d.m.Y')==$this->date){
			$pass=true;
		}
		return $pass;
	}

	public function afterValidate(){
		$this->date_gosp=(empty($this->date_gosp))?NULL:$this->date_gosp;
	}

	 public function afterFind() {

       if($this->scenario=='update'){
            if(!empty($this->brigade)){
                $tmp=substr($this->brigade,1,-1);
                $this->brigade=$tmp;
            }
        }
        if(!empty($this->timestamp)){
        	$this->timestamp=substr($this->timestamp,0,5);
        }

        if(!empty($this->timestamp_end)){
        	$this->timestamp_end=substr($this->timestamp_end,0,5);
        }
        if(!empty($this->date))
        	$this->date=date('d.m.Y',strtotime($this->date));
       	if(!empty($this->date_gosp))
        	$this->date_gosp=date('d.m.Y',strtotime($this->date_gosp));
    }

		public function findEvents($showtype,$date){
		switch ($showtype){
			case 'day':
					$week['begin']=clone $date;
					$criteria=array('condition'=>'t.id_eventsoper is null and ((t.date=\''.$week['begin']->format('Y-m-d').'\'))','order'=>'t.id_room');
					//$events=Events::model()->findAll();	
				break;
			case 'week':
					$week['begin']=clone $date;
					$dow=$week['begin']->format('N');
					$week['begin']->modify('-'.($dow-1).' days');
					$week['end']=clone Yii::app()->session['Rooms_date'];
					$week['end']->modify('+'.(7-$dow).' days'); 
					$criteria=array('condition'=>'t.id_room='.Yii::app()->session['Rooms_id'].'  and t.id_eventsoper is null and ((t.date>=\''.$week['begin']->format('Y-m-d').'\' and t.date<=\''.$week['end']->format('Y-m-d').'\'))','order'=>'t.date ASC');
					//$events=Events::model()->findAll(array('condition'=>'t.id_room='.Yii::app()->session['Rooms_id'].' and ((t.date>=\''.$week['begin']->format('Y-m-d').'\' and t.date<=\''.$week['end']->format('Y-m-d').'\') or t.repeat is not null)','order'=>'t.date ASC'));	
				# code...
				break;
			
			default:
				# code...
				break;	
			}
			$events=Eventsoper::model()->findAll($criteria);
			//$events=Eventsoper::model()->findAll();
			//print_r($events);
			return array('week'=>$week,'events'=>$events);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_room' => 'Операционная',
			'date' => 'Дата',
			'timestamp' => 'Время начала',
			'timestamp_end' => 'Время окончания',
			'fio_pac' => 'ФИО пациента',
			'creator' => 'Creator',
			'operator' => 'Оператор',
			'date_gosp' => 'Дата госпитализации',
			'brigade' => 'Бригада',
			'anesthesiologist' => 'Анестезиолог',
			'operation' => 'Операция',
			'type_operation' => 'Тип операции',
			'creator0creator' => 'creator',
			'operator0operator' => 'Оператор',
			'anesthesiologist0anesthesiologist' => 'Анестезиолог',
			'operation0operation' => 'Операция',
			'idRoomid_room' => 'Комната',
		);
	}

	public function freeOnly()
    {   

    	if(!empty($_POST['Eventsoper']))
    		$this->attributes=$_POST['Eventsoper'];
    	if($this->status==3)
    		return false;

    	if(empty($this->timestamp) or empty($this->timestamp_end)){
    		$this->addError('Eventsoper["timestamp"]','Выберите время');
    		return true;
    	}
    	//echo $this->id_post;
    	$Ph=Eventsoper::model()->findAll(array('condition'=>"id_room=".$this->id_room." and (date='".$this->date."') and status in (0,1,2) and id<>".(int)$this->id." and  
    		((timestamp>='".$this->timestamp."' and timestamp<'".$this->timestamp_end."') or 
    		(timestamp_end>'".$this->timestamp."' and timestamp_end<='".$this->timestamp_end."') or 
    		(timestamp<='".$this->timestamp."' and timestamp_end>='".$this->timestamp_end."'))"));
        foreach ($Ph as $v){
        	$this->addError('Eventsoper["id_post"]','Выбранное время занято. Событие "'.$v->operation0->name.'"('.$v->timestamp.'-'.$v->timestamp_end.')');
        }
        
    }

    public function freeDay(){
    		$bd=$this::$beginDay*60;

    		$result=array();
    	    $Ph=Eventsoper::model()->findAll(array('condition'=>"id_room=".$this->id_room." and (date='".$this->date."') and status in (0,1,2) and id<>".(int)$this->id.""));
        foreach ($Ph as $v){
        	$b=explode(':',$v->timestamp);
        	$e=explode(':',$v->timestamp_end);
        	$result[]=array('b'=>($b[0]*60+$b[1])-$bd,'e'=>($e[0]*60+$e[1])-$bd);
        }
        return $result;
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
		$criteria->order='t.id_room ASC, t.date ASC, t.timestamp ASC';

		$criteria->with=array('creator0' => array('alias' => 'personnel_c'),'operator0' => array('alias' => 'personnel_o'),'anesthesiologist0' => array('alias' => 'personnel_a'),'operation0' => array('alias' => 'listoperations'),'idRoom' => array('alias' => 'rooms'),);
		$criteria->compare('t.id',$this->id);
		if(!empty($_GET['id_room']))
				$criteria->compare('t.id_room',$_GET['id_room']);
		else
				$criteria->compare('t.id_room',$this->id_room);
		$criteria->compare('t.date',$this->date);
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
		if(!empty($this->status))
			$criteria->addCondition(array('condition'=>'t.status in ('.$this->status.')'));

		$criteria->compare('personnel_c.creator',$this->creator0creator,true);
		$criteria->compare('personnel_o.operator',$this->operator0operator,true);
		$criteria->compare('personnel_a.anesthesiologist',$this->anesthesiologist0anesthesiologist,true);
		$criteria->compare('listoperations.operation',$this->operation0operation,true);
		$criteria->compare('rooms.id_room',$this->idRoomid_room,true);
        $criteria->compare('eventsoper.id_eventsoper',$this->idEventsoperid_eventsoper,true);
        $criteria->compare('eventsoper.id_eventsoper',$this->eventsopersid_eventsoper,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
