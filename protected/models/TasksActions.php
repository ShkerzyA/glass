<?php

/**
 * This is the model class for table "tasks_actions".
 *
 * The followings are the available columns in table 'tasks_actions':
 * @property integer $id
 * @property string $ttext
 * @property string $date_begin
 * @property integer $type
 * @property integer $creator
 * @property integer $id_task
 *		 * The followings are the available model relations:


 * @property DepartmentPosts $creator0


 * @property Tasks $idTask
 */
class TasksActions extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TasksActions the static model class
	 */

	public $limiter='\/';
	public static $modelLabelS='TasksActions';
	public static $modelLabelP='TasksActions';
	
	public $creator0creator;
	public $idTaskid_task;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tasks_actions';
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

	public function saveReport(){

		$this->ttext=$_POST['taskname'].$this->limiter.$_POST['mess'].$this->limiter.$_POST['taskstat'].$this->limiter.$_POST['note'];
		$this->type=2;
		$this->save();
	}


	public function saveStatus(){
		$this->ttext=$_POST['stat'];
		$this->type=0;
		$this->save();
	}


	public static function UserReportToday(){
		$models=self::model()->findAll(array('condition'=>"t.creator=".Yii::app()->user->id_pers." and t.type=2 and t.timestamp::date=current_date"));
		return $models;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, creator, id_task', 'numerical', 'integerOnly'=>true),
			array('ttext, timestamp', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ttext, timestamp, type, creator, id_task,creator0creator,idTaskid_task', 'safe', 'on'=>'search'),
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
			'idTask' => array(self::BELONGS_TO, 'Tasks', 'id_task'),
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
			'timestamp' => 'Дата/время создания',
			'type' => 'Type',
			'creator' => 'Creator',
			'id_task' => 'Id Task',
			'creator0creator' => 'creator',
			'idTaskid_task' => 'id_task',
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

		$criteria->with=array('creator0' => array('alias' => 'creator0'),'idTask' => array('alias' => 'idTask'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('ttext',$this->ttext,true);
		$criteria->compare('date_begin',$this->date_begin,true);
		$criteria->compare('type',$this->type);
		if(!empty($_GET['creator']))
				$criteria->compare('creator',$_GET['creator']);
		else
				$criteria->compare('creator',$this->creator);
		if(!empty($_GET['id_task']))
				$criteria->compare('id_task',$_GET['id_task']);
		else
				$criteria->compare('id_task',$this->id_task);
		$criteria->compare('creator0.creator',$this->creator0creator,true);
		$criteria->compare('idTask.id_task',$this->idTaskid_task,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
