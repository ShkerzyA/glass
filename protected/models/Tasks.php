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
	#public static $multifield=array('executors','group');
	public static $db_array=array('group','details','executors');
	public static $statJoin=array(1,2,5);
	public static $statFixEnd=array(2,3);
	public static $taskType=array(0=>array('Зачада','add_task_40.png'),1=>array('Замена картриджа','printer_40.png'));
	public $inExecutors=0;
	
	public $creator0creator;
	public $executor0executor;


	public function init(){
		if(empty($this->executors)){
			$this->executors=array();
		}
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

	public function join($id_pers){
		$tmp=$this->executors;
		$tmp[]=$id_pers;
		$tmp=array_unique(array_diff($tmp,array('')));
		$this->executors=$tmp;
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

	public function getDeadline(){
		if(empty($this->deadline))
			return false;
		$current_date=new DateTime();
		$date=new DateTime($this->deadline);

		$interval=$current_date->diff($date);

		$days=$interval->format('%r%a');
		$difhours=($days==0)?$interval->format('%r%h'):0;
		$hours=$date->format('H');

		return array('difdays'=>$days,'difhours'=>$difhours,'hours'=>$hours);
	}


	public function getStatus(){

		$status=array(  0 => 'Назначено',
						6 => 'Требует уточнения',
						1 => 'Принято',
						5 => 'В работе',
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
						6 => array('label'=>'Требует уточнения','css_class'=>'open','css_status'=>''),
						1 => array('label'=>'Принято','css_class'=>'open','css_status'=>'green'),
						5 => array('label'=>'В работе','css_class'=>'neurtal','css_status'=>'gray'),
						2 => array('label'=>'Выполнено','css_class'=>'done','css_status'=>'green'),
						3 => array('label'=>'Не выполнено','css_class'=>'closed','css_status'=>'red'),
						4 => array('label'=>'Подтверждено выполнение','css_class'=>'done','css_status'=>'green'));
		return $status[$this->status];
	}



	public function behaviors(){
	return array(
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

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, creator, id_department, status,project', 'numerical', 'integerOnly'=>true),
			array('details','checkDetails'),
			array('tname, project', 'required'),
			array('tname', 'length', 'max'=>100),
			array('group', 'length', 'max'=>255),
			//array('details', 'length', 'max'=>255),
			array('ttext, timestamp,deadline,timestamp_end', 'safe'),

			array('executors', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tname, ttext, timestamp, timestamp_end, type, deadline, id_department, status, creator, executors,creator0creator,executor0executor,group,details,project', 'safe', 'on'=>'search'),
		);
	}

	public function checkDetails(){
		switch($this->type){
			case '1':
				if(empty($this->details[0]))
					$this->addError('details','Поле принтер обязательно для заполнения');
				break;
			
			default:
				# code...
				break;
		}
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


	public function potentialExecutors(){
		$group=$this->Project0->group;
		return Personnel::groupMembers($group);
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
			'Project0' => array(self::BELONGS_TO, 'Projects', 'project'),
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
			'timestamp' => 'Дата начала',
			'timestamp_end' => 'Дата окончания',
			'type' => 'Тип',
			'creator' => 'Создатель',
			'executors' => 'Сопричастные',
			'id_department' => 'Отдел', 
			'status' => 'Статус',
			'creator0creator' => 'Создатель',
			'group' => 'Группа',
			'details' => 'Ключевые данные',
			'deadline' => 'Срок исполнения',
			'project' => 'Проект',
		);
	}

	public static function isHorn(){
		$res=false;
		$condition=" (t.\"group\"::text[] && array['".implode("','",Yii::app()->user->groups)."'])";
		$order="t.timestamp desc  LIMIT 2";
		$model=Tasks::model()->findAll(array('condition'=>$condition,'order'=>$order));



		if(!empty($model)){
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

	public static function GroupTasks ($group=array(),$type=3,$date='current_date'){
		

		$wh_group=(!empty($group))?array_uintersect($group,Yii::app()->user->groups,"strcasecmp"):Yii::app()->user->groups;
		//print_r($wh_group); 
		switch ($type) {
			//все, кроме помеченных как просмотренные
			//текущие
			case '1':
				$condition="t.status in (0,1,5,6) ";
				$order="t.status asc,t.deadline ASC,t.timestamp desc";
				break;

			case '2':
				$condition="t.status in (0,1,5,6) and '".Yii::app()->user->id_pers."'=ANY(t.\"executors\")";
				$order="t.status asc,t.deadline ASC,t.timestamp desc";
				break;
			
			case '3':
				$condition="((t.timestamp::date=$date or t.timestamp_end::date=$date) or t.status in (0,1,5,6))";
				$order="t.status asc,t.deadline ASC,t.timestamp desc";
				break;
			//за день
			case '4':
				$condition="((t.timestamp::date=$date or t.timestamp_end::date=$date))";
				$order="t.status asc,t.deadline ASC,t.timestamp desc";
				break;

			default:
				
			break;
		}

		$condition.=" and  ((t.\"group\"::text[] && array['".implode("','",$wh_group)."']) or (\"Project0\".\"group\"::text[] && array['".implode("','",$wh_group)."']) )";

		//	$model=Tasks::model()->with(array(
 		//		'TasksActions'=>array('alias'=>'TasksActions','condition'=>'"TasksActions".type=0','order'=>'"TasksActions".date DESC,"TasksActions".timestamp DESC')))->findAll(array('condition'=>$condition,'order'=>$order));
		

		$model=Tasks::model()->with(array('Project0','TasksActions'=>array('alias'=>'TasksActions','order'=>'"TasksActions".type ASC, "TasksActions".timestamp DESC'),'TasksActions.creator0.personnelPostsHistories.idPersonnel'))->findAll(array('condition'=>$condition,'order'=>$order));
		return $model;

	}

	/*
	public static function tasksForOtdAndGroup($id_department,$type=3,$group=NULL,$date='current_date'){

		if (!in_array($id_department,Yii::app()->user->id_departments))
			return array();
		
		if (!in_array($group,Yii::app()->user->groups))
			return array();
		switch ($type) {
			//все, кроме помеченных как просмотренные
			//текущие
			case '1':
				$condition="id_department=".$id_department." and status in (0,1,5) ";
				$order="status asc,t.timestamp desc";
				break;

			case '2':
				$condition="id_department=".$id_department." and status in (0,1,5) and '".Yii::app()->user->id_pers."'=ANY(\"executors\")";
				$order="status asc,t.timestamp desc";
				break;
			
			case '3':
				$condition="id_department=".$id_department." and ((t.timestamp::date=$date or t.timestamp_end::date=$date) or status in (0,1,5))";
				$order="status asc,t.timestamp desc";
				break;
			//за день
			case '4':
				$condition="id_department=".$id_department." and ((t.timestamp::date=$date or t.timestamp_end::date=$date))";
				$order="status asc,t.timestamp desc";
				break;

			default:
				
			break;
		}

		if(!empty($group))
			$condition.=" and '".$group."'=ANY(\"group\")";

		//	$model=Tasks::model()->with(array(
 		//		'TasksActions'=>array('alias'=>'TasksActions','condition'=>'"TasksActions".type=0','order'=>'"TasksActions".date DESC,"TasksActions".timestamp DESC')))->findAll(array('condition'=>$condition,'order'=>$order));
		

		$model=Tasks::model()->with(array('TasksActions'=>array('alias'=>'TasksActions','order'=>'"TasksActions".type ASC, "TasksActions".timestamp DESC'),'TasksActions.creator0.personnelPostsHistories.idPersonnel'))->findAll(array('condition'=>$condition,'order'=>$order));
		return $model;

	} */

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */

	public function ico(){
		$result='';
		switch ($this->type) {
			case '1':
					$m=Equipment::model()->findByPk($this->details[0]);
					$result='<img src="../images/cartridg_ico.png">';
				break;
			
			default:
				break;
		}
		return $result;
	}
	
	public function detailsShow($short=False,$place=True,$htmlinfo=False){
		$result='';
		if($htmlinfo)
			$result.='<div class=rightinfo><i>Срок исполнения: '.$this->deadline.'</i></div>';	
		switch ($this->type) {
			case '1':
				$m=Equipment::model()->findByPk($this->details[0]);
				if(!empty($m)){
					$result.=$m->idWorkplace->wpNameFull($short);
					if($place==True){
						$result.=' <a href=/glass/Workplace/'.$m->idWorkplace->id.'><img src="../images/door.png" style="height: 24px;"></a>';
					}
					if(!$short)
						$result.="\nПринтер: $m->mark";
				}			
				break;

			case '0':
				$m=Workplace::model()->findByPk($this->details[0]);
				if(!empty($m)){
					$result.=$m->wpNameFull($short);
					if($place==True){
						$result.=' <a href=/glass/Workplace/'.$m->id.'><img src="../images/door.png" style="height: 24px;"></a>';
					}
					if(!$short)
						$result.=" ";
				}			
				break;
			
			default:
				break;
		}
		return $result;
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
		$criteria->compare("'".Yii::app()->user->id_pers."'=ANY(\"executors\")",$this->inExecutors);
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.tname',$this->tname,true);
		$criteria->compare('t.ttext',$this->ttext,true);
		$criteria->compare('t.timestamp',$this->timestamp,true);
		$criteria->compare('timestamp_end',$this->timestamp_end,true);
		$criteria->compare('id_department',$this->id_department,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('group',$this->group,true);
		$criteria->compare('details',$this->details,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('project',$this->project);
		
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
