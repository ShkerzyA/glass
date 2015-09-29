<?php

/**
 * This is the model class for table "events".
 *
 * The followings are the available columns in table 'events':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $creator
 * @property integer $id_room
 * @property string $timestamp
 * @property string $timestamp_end
 * @property integer $repeat
 * @property integer $status
 * @property string $date
 *		 * The followings are the available model relations:


 * @property DepartmentPosts $creator0


 * @property Rooms $idRoom
 */
class Events extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Events the static model class
	 */
	public static $modelLabelS='Событие';
	public static $modelLabelP='События';
	public static $statFixEnd=array();
	public static $db_array=array();

	public $creator0creator;
	public $idRoomid_room;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getStatus(){
		$status=array(  0 => 'Заявка',
						1 => 'Одобрено',
						2 => 'Отклонено',
						3 => 'Требует уточнения');
	

		return $status;
	}




	public static function findEvents($showtype,$date,$eventstype=NULL){
		switch ($showtype){
			case 'day':
					$week['begin']=clone $date;
					$criteria=array('condition'=>'((t.date=\''.$week['begin']->format('Y-m-d').'\') or t.repeat is not null)','order'=>'t.id_room');
					//$events=Events::model()->findAll();	
				break;
			case 'week':
					$week['begin']=clone $date;
					$dow=$week['begin']->format('N');
					$week['begin']->modify('-'.($dow-1).' days');
					$week['end']=clone Yii::app()->session['Rooms_date'];
					$week['end']->modify('+'.(7-$dow).' days'); 
					$criteria=array('condition'=>'t.id_room='.Yii::app()->session['Rooms_id'].' and ((t.date>=\''.$week['begin']->format('Y-m-d').'\' and t.date<=\''.$week['end']->format('Y-m-d').'\') or t.repeat is not null)','order'=>'t.date ASC');
					//$events=Events::model()->findAll(array('condition'=>'t.id_room='.Yii::app()->session['Rooms_id'].' and ((t.date>=\''.$week['begin']->format('Y-m-d').'\' and t.date<=\''.$week['end']->format('Y-m-d').'\') or t.repeat is not null)','order'=>'t.date ASC'));	
				# code...
				break;
			
			default:
				# code...
				break;	
			}
			$events=self::model()->findAll($criteria);
			return array('week'=>$week,'events'=>$events);
	}


	public function isShow($date){
		$pass=false;
		if(!empty($this->repeat)){
				$i=new DateTime($this->date);
				switch ($this->repeat) {
					case '1':
						$pass=true;
						break;

					case '2':
						if($i->format('w')==$date->format('w'))
							$pass=true;
						break;

					case '3':
						if($i->format('d')==$date->format('d'))
							$pass=true;
						continue;
						break;
					
					default:
						break;
				}

			}
			else if($date->format('d.m.Y')==$this->date){
				$pass=true;
			}
			return $pass;
	}

	public function isOwner(){
		if(Yii::app()->user->isGuest)
			return False;
		if($this->creator==Yii::app()->user->id_pers)
			return True;
		else
			return False;

		
	}

	public static function mayCreateEvent(){
		return true;
	}

	public function getRepeat(){
		$repeat=array(  
						1 => 'Каждый день',
						2 => 'Каждую неделю',
						3 => 'Каждый месяц');


		return $repeat;
	}

	protected function beforeSave(){
		return parent::beforeSave();
	}



	protected function afterFind() {

        	if(!empty($this->timestamp)){
        		$this->timestamp=substr($this->timestamp,0,5);
        	}

        	if(!empty($this->timestamp_end)){
        		$this->timestamp_end=substr($this->timestamp_end,0,5);
        	}

        	if(!empty($this->date)){
        		$this->date=date('d.m.Y',strtotime($this->date));
        	}

		return parent::afterFind();
       
    }


	protected function beforeValidate(){
		return parent::beforeValidate();
	}


	public function gimmeStatus(){
		$status=array(  0 => array('label'=>'Заявка','css_class'=>'open'),
						1 => array('label'=>'Одобрено','css_class'=>'done'),
						2 => array('label'=>'Отклонено','css_class'=>'closed'),
						3 => array('label'=>'Требует уточнения','css_class'=>'closed'));
		return $status[$this->status];
	}
	/**
	 * @return string the associated database table name
	 */

	public function behaviors(){
	return array(
			'PreFill'=>array(
				'class'=>'application.behaviors.PreFillBehavior',
				),
			'FixedOwner'=>array(
				'class'=>'application.behaviors.FixedOwnerBehavior',
				),
			 'DbArray'=>array(
                'class'=>'application.behaviors.DbArrayBehavior',
                ));
	}



	public function tableName()
	{
		return 'events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_room,timestamp,timestamp_end','required'),
			array('creator, id_room, repeat, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			array('description, timestamp, timestamp_end, date', 'safe'),
			
			array('id','freeOnly'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, creator, id_room, timestamp, timestamp_end, repeat, status, date,creator0creator,idRoomid_room', 'safe', 'on'=>'search'),
		);
	}



	public function isChangeStatus(){
		if(in_array('secretaries', Yii::app()->user->groups))
			return true;
		$managers=explode(',',$this->idRoom->managers);
		if(in_array(Yii::app()->user->id_pers,$managers)){
			return true;
		}
		return false;
	}

	
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'creator0' => array(self::BELONGS_TO, 'Personnel', 'creator'),
			'idRoom' => array(self::BELONGS_TO, 'Rooms', 'id_room'),
			'EventsActions' => array(self::HAS_MANY, 'EventsActions', 'id_event','alias'=>'EventsActions','order'=>'"EventsActions".timestamp DESC'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */

	public function freeOnly()
    {   

    	if(!empty($_POST['Events']))
    		$this->attributes=$_POST['Events'];
    	//echo $this->id_post;

    	if(empty($this->timestamp) or empty($this->timestamp_end)){
    		$this->addError('Eventsoper["timestamp"]','Выберите время');
    		return true;
    	}

    	$Ph=Events::model()->findAll(array('condition'=>"id_room=".$this->id_room." and (date='".$this->date."' or repeat=1) and
    		((timestamp>='".$this->timestamp."' and timestamp<'".$this->timestamp_end."') or 
    		(timestamp_end>'".$this->timestamp."' and timestamp_end<='".$this->timestamp_end."') or 
    		(timestamp<='".$this->timestamp."' and timestamp_end>='".$this->timestamp_end."'))
    		and status not in (2) and id<>".(int)$this->id.""));
        foreach ($Ph as $v){
        	$this->addError('Events["id_post"]','Выбранное время занято. Событие "'.$v->name.'"('.$v->timestamp.'-'.$v->timestamp_end.')');
        }

        $Ph=Events::model()->findAll(array('condition'=>"id_room=".$this->id_room." and (repeat in (2,3)) and  
    		((timestamp>'".$this->timestamp."' and timestamp<'".$this->timestamp_end."') or (timestamp_end>'".$this->timestamp."' and timestamp_end<'".$this->timestamp_end."') or (timestamp<'".$this->timestamp."' and timestamp_end>'".$this->timestamp_end."'))
    		and status not in (2) and id<>".(int)$this->id.""));

        foreach ($Ph as $v){
        	$dat=new DateTime($this->date);
        	if($v->isShow($dat)){
        		$this->addError('Events["id_post"]','Выбранное время занято. Событие "'.$v->name.'"('.$v->date.') ('.$v->timestamp.'-'.$v->timestamp_end.')');	
        	}
        }


        
    }

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название мероприятия',
			'description' => 'Описание',
			'creator' => 'Создатель',
			'id_room' => 'Местоположение',
			'timestamp' => 'Время начала',
			'timestamp_end' => 'Время окончания',
			'repeat' => 'Повтор',
			'status' => 'Статус',
			'date' => 'Дата',
			'creator0creator' => 'Создатель',
			'idRoomid_room' => 'Местоположение',
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

		$criteria->with=array('creator0' => array('alias' => 'departmentposts'),'idRoom' => array('alias' => 'rooms'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		if(!empty($_GET['creator']))
				$criteria->compare('creator',$_GET['creator']);
		else
				$criteria->compare('creator',$this->creator);
		if(!empty($_GET['id_room']))
				$criteria->compare('id_room',$_GET['id_room']);
		else
				$criteria->compare('id_room',$this->id_room);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('timestamp_end',$this->timestamp_end,true);
		$criteria->compare('repeat',$this->repeat);
		$criteria->compare('status',$this->status);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('departmentposts.creator',$this->creator0creator,true);
		$criteria->compare('rooms.id_room',$this->idRoomid_room,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
