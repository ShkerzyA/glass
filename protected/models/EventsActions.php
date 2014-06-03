<?php

/**
 * This is the model class for table "events_actions".
 *
 * The followings are the available columns in table 'events_actions':
 * @property integer $id
 * @property string $ttext
 * @property string $timestamp
 * @property integer $type
 * @property integer $id_event
 * @property integer $creator
 *		 * The followings are the available model relations:


 * @property Personnel $creator0


 * @property Tasks $idEvent
 */
class EventsActions extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EventsActions the static model class
	 */
	public static $modelLabelS='EventsActions';
	public static $modelLabelP='EventsActions';
	
	public $creator0creator;
	public $idEventid_event;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'events_actions';
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
			);
	}

	public function saveMessage(){

		$this->ttext=$_POST['mess'];
		$this->type=1;
		$this->save();
	}


	public function saveStatus(){
		$this->ttext=$_POST['stat'];
		$this->type=0;
		$this->save();
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, id_event, creator', 'numerical', 'integerOnly'=>true),
			array('ttext, timestamp', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ttext, timestamp, type, id_event, creator,creator0creator,idEventid_event', 'safe', 'on'=>'search'),
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
			'idEvent' => array(self::BELONGS_TO, 'Events', 'id_event'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ttext' => 'Ttext',
			'timestamp' => 'Timestamp',
			'type' => 'Type',
			'id_event' => 'Id Event',
			'creator' => 'Creator',
			'creator0creator' => 'creator',
			'idEventid_event' => 'id_event',
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

		$criteria->with=array('creator0' => array('alias' => 'personnel'),'idEvent' => array('alias' => 'events'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('ttext',$this->ttext,true);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('type',$this->type);
		if(!empty($_GET['id_event']))
				$criteria->compare('id_event',$_GET['id_event']);
		else
				$criteria->compare('id_event',$this->id_event);
		if(!empty($_GET['creator']))
				$criteria->compare('creator',$_GET['creator']);
		else
				$criteria->compare('creator',$this->creator);
		$criteria->compare('personnel.creator',$this->creator0creator,true);
		$criteria->compare('events.id_event',$this->idEventid_event,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
