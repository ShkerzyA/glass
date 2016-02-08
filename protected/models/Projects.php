<?php

/**
 * This is the model class for table "projects".
 *
 * The followings are the available columns in table 'projects':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $timestamp
 * @property string $timestamp_end
 * @property integer $creator
 * @property integer $id_department
 * @property integer $status
 * @property string $executors
 * @property string $group
 *		 * The followings are the available model relations:


 * @property Personnel $creator0
 */
class Projects extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Projects the static model class
	 */
	public static $modelLabelS='Проект';
	public static $modelLabelP='Проекты';
	public static $db_array=array('group','executors','tasktype');
	public $countTask=array();
	
	public $creator0creator;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'projects';
	}

	protected function beforeSave(){
		return parent::beforeSave();
	}


	protected function afterFind(){
		return parent::afterFind();
	}


	protected function beforeValidate(){
		return parent::beforeValidate();
	}

	public function behaviors(){
	return array(
			'Photo'=>array(
				'class'=>'application.behaviors.PhotoBehavior',
				),
			'DbArray'=>array(
				'class'=>'application.behaviors.DbArrayBehavior',
				),
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

	public function ava(){
        if (!empty($this->photo)){
            echo (Yii::app()->request->baseUrl.'/media'.DIRECTORY_SEPARATOR.CHtml::encode($this->photo)); 
        }else{
            echo (Yii::app()->request->baseUrl.'/images/no_avatar.jpg');
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
			array('creator, id_department, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('description, timestamp, timestamp_end, executors, group, tasktype', 'safe'),
			array('photo', 'length', 'max'=>100),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, timestamp, timestamp_end, creator, id_department, status, executors, group,creator0creator', 'safe', 'on'=>'search'),
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
			'Tasks' => array(self::HAS_MANY,'Tasks','project','on'=>'(("Tasks".timestamp::date=current_date or "Tasks".timestamp_end::date=current_date) or "Tasks".status in (0,1,5,6))','order'=>'"status0".sort ASC, "Tasks".timestamp DESC'),
		);
	}

	public function findExecutors(){
		$result=array();
		$exec=(is_array($this->executors))?$this->executors:array();
		$tmp=array_diff($exec,array(''));
		foreach ($tmp as $v) {
			$result[]=Personnel::model()->findByPk($v);
		}
		return $result;
	}

	public function projectInfo(){
	 	$sql = Yii::app()->db->createCommand(
        	"
        	select t1.status, t1.cou, t2.cou as my, ts.label, ts.css_class, ts.ico, ts.css_status from (SELECT status, count(status) cou from tasks where project=".$this->id." group by status) as t1 left join 
			(SELECT status, count(status) cou from tasks where project=".$this->id." and '".Yii::app()->user->id_pers."'=ANY(executors) group by status ) as t2 on (t1.status=t2.status) 
			left join tasks_status as ts on (ts.id=t1.status) where t1.status not in (2,4,3) order by ts.sort
			"   
        );
    	$result = $sql->queryAll();
    	return $result;
	}


	public static function myGroupProjects(){
		$models=self::model()->with('Tasks.status0')->findAll(array('condition'=>'t.group[1] in (\''.implode('\',\'',Yii::app()->user->groups).'\')'));
		return $models;
	}

	public static function myExecProjects(){
		$models=self::model()->with('Tasks.status0')->findAll(array('condition'=>'t.group[1] in (\''.implode('\',\'',Yii::app()->user->groups).'\') and \''.Yii::app()->user->id_pers.'\'=ANY(t.executors) '));
		return $models;
	}

	public static function myProjects(){
		$models=self::model()->findAll(array('condition'=>'t.group[1] in (\''.implode('\',\'',Yii::app()->user->groups).'\')'));
		return $models;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Назвение',
			'description' => 'Описание',
			'timestamp' => 'Начало',
			'timestamp_end' => 'Окончание',
			'creator' => 'Создатель',
			'id_department' => 'Отдел',
			'status' => 'Статус',
			'executors' => 'Исполнители',
			'group' => 'Группа',
			'creator0creator' => 'Создатель',
			'photo' => 'Логотип'
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

		$criteria->with=array('creator0' => array('alias' => 'personnel'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('timestamp_end',$this->timestamp_end,true);
		$criteria->compare('creator',$this->creator);
		$criteria->compare('id_department',$this->id_department);
		$criteria->compare('status',$this->status);
		$criteria->compare('executors',$this->executors,true);
		$criteria->compare('group',$this->group,true);
		$criteria->compare('personnel.creator',$this->creator0creator,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
