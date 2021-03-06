<?php

/**
 * This is the model class for table "rooms".
 *
 * The followings are the available columns in table 'rooms':
 * @property integer $id
 * @property integer $id_cabinet
 * @property string $managers
 *		 * The followings are the available model relations:


 * @property Cabinet $idCabinet
 */
class Rooms extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rooms the static model class
	 */
	public static $modelLabelS='Помещение';
	public static $modelLabelP='Помещения';
	public static $db_array=array('managers');
	
	public $idCabinetid_cabinet;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
	return array(
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
		return 'rooms';
	}

	public function getType(){
		return array(
			0=>'Презентационные',
			1=>'Операционные'
			);
	}

	public static function getRooms($EventType){
		$rooms=NULL;
		switch ($EventType) {
			case 'events':
					$rooms=Rooms::model()->findAll(array('condition'=>'t.type=0'));
				break;
			case 'eventsOpPl':
			case 'eventsOpMon':
					//if(Yii::app()->user->checkAccess('operationSV',array('mod'=>Yii::app()->user))){
					$rooms=Rooms::model()->with(array(
   						'idCabinet'=>array(
        				'joinType'=>'LEFT JOIN',
        				'alias'=>'f'
    				)))->findAll(array('condition'=>'t.type=1','order'=>'f.cname ASC'));	
					/*}else{
						if(!Yii::app()->user->isGuest){
							$id_pers=Yii::app()->user->id_pers;
						}else{
							$id_pers=-1;
						}
						$rooms=Rooms::model()->with(array(
   						'idCabinet'=>array(
        				'joinType'=>'LEFT JOIN',
        				'alias'=>'f'
    				)))->findAll(array('condition'=>'t.type=1 and \''.$id_pers.'\'=ANY("managers")','order'=>'f.cname ASC'));	
					}*/
					
				break;
			
			default:
					$rooms=Rooms::model()->findAll(array('condition'=>'t.type=0'));
				break;

		}
		return $rooms;
	}

	public static function getArrayRooms($EventType){
		$roomsM=array();
		$rooms=self::getRooms($EventType);
		if(!empty($rooms))
			foreach ($rooms as $r) {
				$roomsM[$r->id]=$r->idCabinet->cname.'  №'.$r->idCabinet->num;
			}
		return $roomsM;

	}

	public function getCabName(){
		if(!empty($this->idCabinet))
			return $this->idCabinet->cabNameFull(1);
		else
			return '';
	}


	public function getOperRoomsWithOperation(){
		$criteria=new CDbCriteria;
		$Eventsoper=new Eventsoper;
		if(!empty($_GET['Eventsoper']))
			$Eventsoper->attributes=$_GET['Eventsoper'];



		$criteria->with=array('eventsoper' => array('alias' => 'eventsoper'),'idCabinet' => array('alias' => 'cabinet'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('eventsoper.id_room',$Eventsoper->id_room,true);
		$criteria->compare('eventsoper.date',$Eventsoper->id_room,true);
		if(!empty($Eventsoper->status))
			$criteria->addCondition(array('condition'=>'eventsoper.status in ('.$Eventsoper->status.')'));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function isManagerUser(){
		$tmp=explode(',',$this->managers);
		if(!Yii::app()->user->isGuest){
			return in_array(Yii::app()->user->id_pers, $tmp);
		}else{
			return false;
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
			array('id_cabinet,type','numerical', 'integerOnly'=>true),
			array('managers', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_cabinet, managers,eventsid_room,idCabinetid_cabinet', 'safe', 'on'=>'search'),
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
			'events' => array(self::HAS_MANY, 'Events', 'id_room'),
			'eventsoper' => array(self::HAS_MANY, 'Eventsoper', 'id_room'),
			'idCabinet' => array(self::BELONGS_TO, 'Cabinet', 'id_cabinet'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_cabinet' => 'Кабинет',

			'eventsid_room' => 'События',
			'managers' => 'Ответственные',
			'idCabinetid_cabinet' => 'Кабинет',
			'type' => 'Тип',
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

		$criteria->with=array('events' => array('alias' => 'events'),'idCabinet' => array('alias' => 'cabinet'),);
		$criteria->compare('id',$this->id);
		if(!empty($_GET['id_cabinet']))
				$criteria->compare('id_cabinet',$_GET['id_cabinet']);
		else
				$criteria->compare('id_cabinet',$this->id_cabinet);
		$criteria->compare('events.id_room',$this->getCabName(),true);
		$criteria->compare('managers',$this->managers,true);
		$criteria->compare('cabinet.id_cabinet',$this->idCabinetid_cabinet,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
