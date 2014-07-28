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

	public function isChangeStatus(){
		if(Yii::app()->user->isGuest)
			return False;
		if((in_array($this->id_department,Yii::app()->user->id_departments) and empty($this->group)) or (in_array($this->group,Yii::app()->user->groups))){
			return True; 
		}else {
			return False;
		}
	}

	public function getStatus(){

		$status=array(  0 => 'Назначено',
						1 => 'Принято',
						5 => 'Отложено',
						2 => 'Выполнено',
						3 => 'Не выполнено');
		if(!empty(Yii::app()->user->islead)){
			if(Yii::app()->user->islead==1){
				$status[4]='Подтверждено выполнение';
			}	
		}
		

		return $status;
	}

	public function tasksUnits(){

		return $result;
	}

	public function gimmeStatus(){
		$status=array(  0 => array('label'=>'Назначено','css_class'=>'open','css_status'=>'red'),
						1 => array('label'=>'Принято','css_class'=>'open','css_status'=>'green'),
						5 => array('label'=>'Отложено','css_class'=>'neurtal','css_status'=>'gray'),
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
			array('tname','required'),
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
			'TasksActions' => array(self::HAS_MANY, 'TasksActions', 'id_task','alias'=>'TasksActions','order'=>'"TasksActions".timestamp ASC'),
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

	public static function isHorn($id_department=0,$group=NULL){
		$res=false;
		$condition="id_department=".$id_department;
		if(!empty($group))
			$condition.=" and '".$group."'=ANY(\"group\")";
		$order="t.timestamp desc  LIMIT 2";
		$model=Tasks::model()->findAll(array('condition'=>$condition,'order'=>$order));

		if(in_array($id_department,Yii::app()->user->id_departments)){
			if(Yii::app()->user->last_task!=$model[0]->id){
				if(!empty(Yii::app()->user->last_task))
					$res=true;
				Yii::app()->user->last_task=$model[0]->id;
			}
		}
		return $res;
	}


	public function mayUserUpd(){
		if(Yii::app()->user->isGuest)
			return False;
		if(Yii::app()->user->id_pers==$this->creator){
			return True;
		}else if(empty($this->creator)){
			return $this->isChangeStatus();
		}else{
			return False;
		}
	}

	public static function tasksForOtdAndGroup($id_department,$type=3,$group=NULL){

		switch ($type) {
			//все, кроме помеченных как просмотренные
			case '0':
				$condition="id_department=".$id_department." and status not in (4)";
				$order="status asc,t.timestamp desc";
				break;
			//текущие
			case '1':
				$condition="id_department=".$id_department." and status in (0,1,5) ";
				$order="status asc,t.timestamp desc";
				break;
			
			//все
			case '2':
				$condition="id_department=".$id_department." ";
				$order="status asc,t.timestamp desc";
				break;

			//за день
			case '3':
				$condition="id_department=".$id_department." and ((t.timestamp::date=current_date or t.timestamp_end::date=current_date) or status in (0,1,5))";
				$order="status asc,t.timestamp desc";
				break;
			default:
				
			break;
		}

		if(!empty($group))
			$condition.=" and '".$group."'=ANY(\"group\")";

		//	$model=Tasks::model()->with(array(
 		//		'TasksActions'=>array('alias'=>'TasksActions','condition'=>'"TasksActions".type=0','order'=>'"TasksActions".date DESC,"TasksActions".timestamp DESC')))->findAll(array('condition'=>$condition,'order'=>$order));
		

		$model=Tasks::model()->with(array('TasksActions'=>array('alias'=>'TasksActions','order'=>'"TasksActions".type ASC, "TasksActions".timestamp DESC')))->findAll(array('condition'=>$condition,'order'=>$order));
		return $model;

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


    public function reportInc(){
    	$rep=0;
    	$myrep=0;
    	$id_pers=(!empty(Yii::app()->user->id_pers))?Yii::app()->user->id_pers:NULL;
    	foreach ($this->TasksActions as $v) {
    		if($v->type==2){
    			$rep=1;
    			if($id_pers==$v->creator)
    				$myrep=1;
    		}
    	}
    	if($myrep==1){
    		return 'myrep';
    	}elseif($rep==1){
    		return 'rep';
    	}else{
    		return false;
    	}

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
