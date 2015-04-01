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
	public static $multifield=array('executors');
	public static $db_array=array('group','details','executors');
	public static $statJoin=array(1,2,5);
	public static $statFixEnd=array(2,3);
	
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

	public function join($id_pers=NULL){
		$tmp=$this->executors;
		$tmp[]=(!empty($id_pers))?$id_pers:Yii::app()->user->id_pers;
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



	public function getStatus(){

		$status=array(  0 => 'Назначено',
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
			'Multichoise'=>array(
				'class'=>'application.behaviors.MultichoiseBehavior',
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
			array('type, creator, id_department, status', 'numerical', 'integerOnly'=>true),
			array('details','checkDetails'),
			array('tname', 'required'),
			array('tname', 'length', 'max'=>100),
			array('group', 'length', 'max'=>255),
			//array('details', 'length', 'max'=>255),
			array('ttext, timestamp, timestamp_end', 'safe'),

			array('executors', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tname, ttext, timestamp, timestamp_end, type, id_department, status, creator, executors,creator0creator,executor0executor,group,details', 'safe', 'on'=>'search'),
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
		);
	}

	public static function isHorn($id_department=0,$group=''){
		$res=false;
		$condition="id_department=".$id_department;
		if(!empty($group))
			$condition.=" and '".$group."'=ANY(\"group\")";
		$order="t.timestamp desc  LIMIT 2";
		$model=Tasks::model()->findAll(array('condition'=>$condition,'order'=>$order));

		if(in_array($id_department,Yii::app()->user->id_departments) and !empty($model)){
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

	public static function tasksForOtdAndGroup($id_department,$type=3,$group=NULL,$date='current_date'){

		switch ($type) {
			//все, кроме помеченных как просмотренные
			//текущие
			case '1':
				$condition="id_department=".$id_department." and status in (0,1,5) ";
				$order="status asc,t.timestamp desc";
				break;

			case '2':
				$condition="id_department=".$id_department." and ((t.timestamp::date=$date or t.timestamp_end::date=$date))";
				$order="status asc,t.timestamp desc";
				break;
			default:
			//за день
			case '3':
				$condition="id_department=".$id_department." and ((t.timestamp::date=$date or t.timestamp_end::date=$date) or status in (0,1,5))";
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

	}

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
	
	public function detailsShow($short=False,$place=True){
		$result='';
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
		$criteria->compare('id',$this->id);
		$criteria->compare('tname',$this->tname,true);
		$criteria->compare('ttext',$this->ttext,true);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('timestamp_end',$this->timestamp_end,true);
		$criteria->compare('id_department',$this->id_department,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('group',$this->group,true);
		$criteria->compare('details',$this->details,true);
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
