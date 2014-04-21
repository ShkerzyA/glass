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
			else if($date->format('Y-m-d')==$this->date){
				$pass=true;
			}
			return $pass;
	}

	public function getRepeat(){
		$repeat=array(  
						1 => 'Каждый день',
						2 => 'Каждую неделю',
						3 => 'Каждый месяц');


		return $repeat;
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
			);
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
			array('id','freeOnly'),
			array('creator, id_room, repeat, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			array('description, timestamp, timestamp_end, date', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, creator, id_room, timestamp, timestamp_end, repeat, status, date,creator0creator,idRoomid_room', 'safe', 'on'=>'search'),
		);
	}

	public function afterFind() {

        	if(!empty($this->timestamp)){
        		$this->timestamp=substr($this->timestamp,0,5);
        	}

        	if(!empty($this->timestamp_end)){
        		$this->timestamp_end=substr($this->timestamp_end,0,5);
        	}
       
    	}

	public function isChangeStatus(){
		$managers=explode(',',$this->idRoom->managers);
		if(in_array(Yii::app()->user->id_pers,$managers)){
			return true;
		}
		return false;
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

    	$Ph=Events::model()->findAll(array('condition'=>"id_room=".$this->id_room." and (date='".$this->date."' or repeat=1) and  
    		((timestamp>'".$this->timestamp."' and timestamp<'".$this->timestamp_end."') or (timestamp_end>'".$this->timestamp."' and timestamp_end<'".$this->timestamp_end."') or (timestamp<'".$this->timestamp."' and timestamp_end>'".$this->timestamp_end."'))
    		and status not in (2)"));
        foreach ($Ph as $v){
        	$this->addError('Events["id_post"]','Выбранное время занято. Событие "'.$v->name.'"('.$v->timestamp.'-'.$v->timestamp_end.')');
        }

        $Ph=Events::model()->findAll(array('condition'=>"id_room=".$this->id_room." and (repeat in (2,3)) and  
    		((timestamp>'".$this->timestamp."' and timestamp<'".$this->timestamp_end."') or (timestamp_end>'".$this->timestamp."' and timestamp_end<'".$this->timestamp_end."') or (timestamp<'".$this->timestamp."' and timestamp_end>'".$this->timestamp_end."'))
    		and status not in (2)"));

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
