<?php

/**
 * This is the model class for table "tasks".
 *
 * The followings are the available columns in table 'tasks':
 * @property integer $id
 * @property string $tname
 * @property string $ttext
 * @property string $date_begin
 * @property string $date_end
 * @property integer $type
 * @property integer $creator
 * @property integer $executor
 *		 * The followings are the available model relations:
 * @property DepartmentPosts $creator0
 * @property DepartmentPosts $executor0
 */
class Tasks extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tasks the static model class
	 */
	public static $modelLabelS='Задача';
	public static $modelLabelP='Задачи';
	
	public $creator0creator;
	public $executor0executor;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tasks';
	}

	public function getStatus(){

		$status=array(  0 => 'Назначено',
						1 => 'Принято',
						2 => 'Выполнено',
						3 => 'Не выполнено');
		if(!empty(Yii::app()->user->islead)){
			if(Yii::app()->user->islead==1){
				$status[4]='Подтверждено выполнение';
			}	
		}
		

		return $status;
	}

	public function gimmeStatus(){
		$status=array(  0 => array('label'=>'Назначено','css_class'=>'open','css_status'=>'red'),
						1 => array('label'=>'Принято','css_class'=>'open','css_status'=>'green'),
						2 => array('label'=>'Выполнено','css_class'=>'done','css_status'=>'green'),
						3 => array('label'=>'Не выполнено','css_class'=>'closed','css_status'=>'red'),
						4 => array('label'=>'Подтверждено выполнение','css_class'=>'done','css_status'=>'green'));
		return $status[$this->status];
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
			'Multichoise'=>array(
				'class'=>'application.behaviors.MultichoiseBehavior',
				),
			);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, creator, id_department, status', 'numerical', 'integerOnly'=>true),
			array('tname', 'length', 'max'=>100),
			array('group', 'length', 'max'=>255),
			array('ttext, timestamp, timestamp_end', 'safe'),

			array('executors', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tname, ttext, timestamp, timestamp_end, type, id_department, status, creator, executors,creator0creator,executor0executor,group', 'safe', 'on'=>'search'),
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
			'TasksActions' => array(self::HAS_MANY, 'TasksActions', 'id_task','alias'=>'TasksActions','order'=>'"TasksActions".timestamp DESC'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tname' => 'Заголовок',
			'ttext' => 'Описание заявки',
			'timestamp' => 'Date Begin',
			'timestamp_end' => 'Date End',
			'type' => 'Тип',
			'creator' => 'Создатель',
			'executors' => 'Сопричастные',
			'id_department' => 'Отдел', 
			'status' => 'Статус',
			'creator0creator' => 'Создатель',
			'group' => 'Группа',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */

	public function beforeSave(){
		$this->group='{'.$this->group.'}';
		return parent::beforeSave();
	}

    public function afterFind(){
    	$this->group=substr($this->group,1,-1);
		return parent::afterFind();
    } 

	public function search(){

		$criteria=new CDbCriteria;

		$criteria->with=array('creator0' => array('alias' => 'departmentposts'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('tname',$this->tname,true);
		$criteria->compare('ttext',$this->ttext,true);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('timestamp_end',$this->timestamp_end,true);
		$criteria->compare('id_department',$this->id_department,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('group',$this->group,true);
		$criteria->compare('type',$this->type);
		if(!empty($_GET['creator']))
				$criteria->compare('creator',$_GET['creator']);
		else
				$criteria->compare('creator',$this->creator);
		if(!empty($_GET['executors']))
				$criteria->compare('executors',$_GET['executors']);
		else
				$criteria->compare('executors',$this->executors,true);
		$criteria->compare('departmentposts.creator',$this->creator0creator,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
