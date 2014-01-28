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
		return array(  	0 => 'Назначено',
						1 => 'Принято',
						2 => 'Выполнено',
						3 => 'Не выполнено',
						4 => 'Подтверждено выполнение');
	}

	public function gimmeStatus(){
		$status=array(  0 => array('label'=>'Назначено','css_class'=>'open'),
						1 => array('label'=>'Принято','css_class'=>'open'),
						2 => array('label'=>'Выполнено','css_class'=>'done'),
						3 => array('label'=>'Не выполнено','css_class'=>'closed'),
						4 => array('label'=>'Подтверждено выполнение','css_class'=>'done'));
		return $status[$this->status];
	}

	public function behaviors(){
	return array(
			'DateBeginEnd'=>array(
				'class'=>'application.behaviors.DateBeginEndBehavior',
				),
			'PreFill'=>array(
				'class'=>'application.behaviors.PreFillBehavior',
				),
			'FixedOwner'=>array(
				'class'=>'application.behaviors.FixedOwnerBehavior',
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
			array('type, creator, executor, id_department, status', 'numerical', 'integerOnly'=>true),
			array('tname', 'length', 'max'=>100),
			array('ttext, date_begin, date_end', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tname, ttext, date_begin, date_end, type, id_department, status, creator, executor,creator0creator,executor0executor', 'safe', 'on'=>'search'),
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
			'creator0' => array(self::BELONGS_TO, 'DepartmentPosts', 'creator'),
			'executor0' => array(self::BELONGS_TO, 'DepartmentPosts', 'executor'),
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
			'date_begin' => 'Date Begin',
			'date_end' => 'Date End',
			'type' => 'Тип',
			'creator' => 'Создатель',
			'executor' => 'Исполнитель',
			'id_department' => 'Отдел', 
			'status' => 'Статус',
			'creator0creator' => 'Создатель',
			'executor0executor' => 'Исполнитель',
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

		$criteria->with=array('creator0' => array('alias' => 'departmentposts'),'executor0' => array('alias' => 'departmentposts1'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('tname',$this->tname,true);
		$criteria->compare('ttext',$this->ttext,true);
		$criteria->compare('date_begin',$this->date_begin,true);
		$criteria->compare('date_end',$this->date_end,true);
		$criteria->compare('id_department',$this->date_end,true);
		$criteria->compare('status',$this->date_end,true);
		$criteria->compare('type',$this->type);
		if(!empty($_GET['creator']))
				$criteria->compare('creator',$_GET['creator']);
		else
				$criteria->compare('creator',$this->creator);
		if(!empty($_GET['executor']))
				$criteria->compare('executor',$_GET['executor']);
		else
				$criteria->compare('executor',$this->executor);
		$criteria->compare('departmentposts.creator',$this->creator0creator,true);
		$criteria->compare('departmentposts1.executor',$this->executor0executor,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
