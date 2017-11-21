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
	public function ico($default_ico=False){
		$mark=($this->isMyProject())?'<div style="position: absolute; top: 0; left: 0;"><img src="/glass/images/dot8.png"></div>':'';
		if($default_ico)
			$result='<img label="'.$this->name.'" class=taskico src="/glass/images/add_task_40.png">';
		else
			$result='';
		if(!empty($this->photo)){
			//$result='<img label="'.$this->name.'" class=taskico src="/glass/media/'.$this->photo.'">';
			$result='<div label="'.$this->name.'" class=divico style="background-image: url(\'/glass/media'.'/'.$this->photo.'\');  background-size:100% 100%;">'.$mark.'</div>';
		}else{
			$result='<div label="'.$this->name.'" class=divico style="background: '.$this->color().';">'.$mark.'<h2 style="color: white">'.mb_substr($this->name,0,1).'</h2></div>';
		}
		return $result;
	}

	public function isMyProject(){
		return in_array(Yii::app()->user->id_pers, $this->executors);
	}

	public function color(){
		$a=array();
		$time=strtotime($this->timestamp);
	
		$a[]=dechex($t=(mb_substr($time,-2,2)>55)?mb_substr($time,-2,2)+40:mb_substr($time,-2,2)+140);
		$a[]=dechex($t=(mb_substr($time,-4,2)>55)?mb_substr($time,-4,2)+40:mb_substr($time,-4,2)+140);
		$a[]=dechex($t=(mb_substr($time,-6,2)>55)?mb_substr($time,-6,2)+40:mb_substr($time,-6,2)+140);

		//$a[]=dechex($t=round(mb_substr($time,-3,3)*0.25));
		//$a[]=dechex($t=round(mb_substr($time,-6,3)*0.25));
		//$a[]=dechex($t=round(mb_substr($time,-9,3)*0.25));
		//echo ($this->name);
		//print_r($a);
		return '#'.implode('',$a);
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('creator, id_department, status, order', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('description, timestamp, timestamp_end, executors, group, tasktype', 'safe'),
			array('photo', 'length', 'max'=>100),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, timestamp, timestamp_end, creator, id_department, status, order, executors, group,creator0creator', 'safe', 'on'=>'search'),
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
		$exec=(is_array($this->executors))?$this->executors:array();
		$tmp=array_diff($exec,array(''));
		$result = Personnel::model()->findAllByAttributes(array("id"=>$tmp));
		return $result;
	}

	public function potentialExecutors($obj=false){
		return Personnel::groupMembers($this->group,$obj);
	}

	public function projectInfo(){
	 	$sql = Yii::app()->db->createCommand(
        	"
        	select t1.status, t1.cou, t2.cou as my, ts.label, ts.css_class, ts.ico, ts.css_status from (SELECT status, count(status) cou from tasks where project=".$this->id." group by status) as t1 left join 
			(SELECT status, count(status) cou from tasks where project=".$this->id." and '".Yii::app()->user->id_pers."'=ANY(executors) group by status ) as t2 on (t1.status=t2.status) 
			left join tasks_status as ts on (ts.id=t1.status) where t1.status in (0,1,5,6) order by ts.sort
			"   
        );
    	$result = $sql->queryAll();
    	return $result;
	}

	public static function allProjectsPersStat(){
		$sql = Yii::app()->db->createCommand(
        	"
			select res.pid, res.id, res.status, sum(res.cou) from (select pj.id as pid, pj.name,t2.cou, t2.status, ps.id from projects pj
			left join personnel as ps on(ps.id::text=ANY(pj.executors))
			left join (SELECT status, project,executors, count(status) cou from tasks group by status,project,executors order by status) as t2 on(pj.id = t2.project and ps.id::TEXT=ANY(t2.executors))) as res group by res.pid,res.id,res.status order by pid, status, id
		"   
        );
    	$result = $sql->queryAll();
    	$strictRes=array();
    	foreach ($result as $v) {
    		$strictRes[$v['pid']][$v['id']][$v['status']]=$v['sum'];
    	}
    	return $strictRes;
	}

	public static function allProjectsStat(){
		$sql = Yii::app()->db->createCommand(
        	"SELECT project, status, count(status) cou from tasks group by status,project order by project,status"   
        );
    	$result = $sql->queryAll();
    	$strictRes=array();
    	foreach ($result as $v) {
    		$strictRes[$v['project']][$v['status']]=$v['cou'];
    	}
    	return $strictRes;
	}


	public function allTaskCount(){
		$sql = Yii::app()->db->createCommand(
        	"
        	select t2.status, t2.cou, ts.label, ts.css_class, ts.ico, ts.css_status from 
			(SELECT status, count(status) cou from tasks where project=".$this->id." group by status ) as t2
			left join tasks_status as ts on (ts.id=t2.status) order by ts.sort
			" 
        );
    	$result = $sql->queryAll();
    	return $result;
	}


	public function persTaskCount($id_pers){
		$sql = Yii::app()->db->createCommand(
        	"
        	select t2.status, t2.cou, ts.label, ts.css_class, ts.ico, ts.css_status from 
			(SELECT status, count(status) cou from tasks where project=".$this->id." and '".$id_pers."'=ANY(executors) group by status ) as t2
			left join tasks_status as ts on (ts.id=t2.status) order by ts.sort
			" 
        );
    	$result = $sql->queryAll();
    	return $result;
	}

	public function actualTaskCount(){
		$sql = Yii::app()->db->createCommand(
        	"SELECT count(status) cou from tasks where project=".$this->id."  and status in (0,1,5,6)"   
        );
    	$result = $sql->queryAll();
    	return $result;
	}

	public function getType(){
		if(!empty($this->tasktype))
			return $this->tasktype[0];
		else
			return 0;
	}

	public static function inArrayPrj($fnc){
		$mdl=self::$fnc();
		$res=array();
		foreach ($mdl as $v) {
			$res[$v->id]=$v->name;
		}
		return $res;
	}


	public static function myGroupProjects(){
		$models=self::model()->with('Tasks.status0')->findAll(array('condition'=>'t.group[1] in (\''.implode('\',\'',Yii::app()->user->groups).'\')','order'=>'t.order DESC'));
		return $models;
	}

	public static function myExecProjects(){
		$models=self::model()->with('Tasks.status0')->findAll(array('condition'=>'t.group[1] in (\''.implode('\',\'',Yii::app()->user->groups).'\') and \''.Yii::app()->user->id_pers.'\'=ANY(t.executors) '));
		return $models;
	}

	public static function myProjects(){
		$models=self::model()->findAll(array('condition'=>'t.group[1] in (\''.implode('\',\'',Yii::app()->user->groups).'\')','order'=>'t.order DESC'));
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
			'photo' => 'Логотип',
			'order' => 'Сортировка'
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
		$criteria->compare('order',$this->order);
		$criteria->compare('executors',$this->executors,true);
		$criteria->compare('group',$this->group,true);
		$criteria->compare('personnel.creator',$this->creator0creator,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
