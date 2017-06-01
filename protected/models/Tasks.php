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

	public static $types=array('0'=>'Обычные','1'=>'Картриджи');
	#public static $multifield=array('executors','group');
	public static $db_array=array('group','details','executors','deadlocks');
	public static $statJoin=array(1,2,5);
	public static $statFixEnd=array(2,3);
	public static $taskType=array(0=>array('Зачада','add_task_40.png'),1=>array('Замена картриджа','printer_40.png'));
	public static $locks=array(1=>'Определенные навыки',2=>'Требуется группа бойцов',3=>'Определенное время',4=>'Оборудование со склада после согласования',5=>'Сторонний чел');
	public $inExecutors=0;
	public $place;
	private $old_model;
	
	public $creator0creator;
	public $executor0executor;


	public function init(){
		if(empty($this->executors)){
			$this->executors=array();
		}
	}

	public function scopes()
	{
    	$t=$this->getTableAlias(false);
    	return array(
        	'actual_today'=>array('condition'=>"(($t.timestamp::date=current_date or $t.timestamp_end::date=current_date) or $t.status in (0,1,5,6))"),
    	);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getLocks(){
		$result=array();
		foreach (self::$locks as $k => $v) {
			$act=(in_array($k,$this->deadlocks))?'a':'d';
			$result[]=array($k,$act,$v);
		}
		return $result;
	}

	/**
	 * @return string the associated database table name
	 */

	public function tableName()
	{
		return 'tasks';
	}

	private function anyway($x){
        if(is_array($x)){
            $x=implode('|',$x);
            
        }
        $x=str_replace(array('{','}'),'',$x);
        $x=str_replace(array(','),'|',$x);
        return $x;
    }

	public function isChangeStatus(){
		if(Yii::app()->user->isGuest)
			return False;
		if((in_array($this->id_department,Yii::app()->user->id_departments) and empty($this->group)) or (in_array($this->group,Yii::app()->user->groups)) or !empty(array_intersect($this->Project0->group,Yii::app()->user->groups))){
			return True; 
		}else {
			return False;
		}
	}

	public function deadKlok(){
		if(!empty($this->deadline)){
			$current=new DateTime();
			$dl=new DateTime($this->deadline);
			$interval=date_diff($current,$dl);
			return array($interval->format('%r'),$interval->format('%d'),$interval->format('%h'),$interval->format('%i'));
		}
	}

	public function join($id_pers){
		$tmp=$this->executors;
		$tmp[]=$id_pers;
		$tmp=array_unique(array_diff($tmp,array('')));
		$this->executors=$tmp;
	}

	protected function beforeSave(){
		if($this->scenario!='insert'){
            $this->old_model=self::model()->findByPk($this->id);
            $this->old_model->TimeStamp->beforeSave(Null);
        }
		return parent::beforeSave();
	}

	public function afterSave(){
        $ta=new TasksActions();
		switch ($this->scenario) {
            case 'insert':
            		$ta->saveAction($this->id,0);
                break;
            
            default:
                if (empty($this->old_model))
                    return false;
                $chanded=array();
                foreach ($this->attributes as $k => $v) {
                    if(trim($this->anyway($v))!=trim($this->anyway($this->old_model->$k))){
                        switch ($k) {
                            default:
                                $a=$this->anyway($this->old_model->$k);
                                $b=$this->anyway($v);
                                $chanded[]=$this->owner->getAttributeLabel($k).": ".$a."/".$b."\n";   
                                break;
                        }
 
                    }
                }
                if(!empty($chanded)){
                    $ta->saveAction($this->id,1,$chanded);
                }
                break;
        }

		return parent::afterSave();
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

	public function sendMail(){
		$tmp=$this->potentialExecutors(True);
		foreach ($tmp as $prs) {
			if(!empty($prs->idUser)){
				$head=$this->id.' '.$this->tname;
				$body=$this->status0->label."\n".$this->detailsShow(0,0,0).' '.$this->ttext;
				$prs->idUser->sendMail($head,$body);
			}
			
		}
	}


	public function isGroovy(){
		$now=new DateTime();
		if(!empty($this->TasksActions)){
			$timestamp=new DateTime($this->TasksActions[0]->timestamp);
			$interval=$now->diff($timestamp);
			$min=$interval->format('%a%h%i');
			if($min<10){
				return 'groovy';
			}
			else{
				return ' ';
			}
		}else{
			return ' ';
		}

	}

	public function suggestTag($keyword){
		$keyword=mb_strtolower($keyword,'UTF-8');
 		$tags=$this->findAll(array(
   			'condition'=>'(LOWER(t.tname) LIKE :keyword OR LOWER(t.ttext) LIKE :keyword)',
   			'params'=>array(
     		':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',

   		)
   		,'order'=>'t.timestamp ASC'
 		));
 		return $tags;
	}

	public function nameL(){
		return $this->tname;
	}


	public function getStatus(){
		return TasksStatus::statusList();
	}


	public function tasksUnits(){

		return $result;
	}

	/*
	public function gimmeStatus(){
		$status=array(  0 => array('label'=>'Назначено','css_class'=>'open','css_status'=>'red'),
						6 => array('label'=>'Требует уточнения','css_class'=>'open','css_status'=>''),
						1 => array('label'=>'Принято','css_class'=>'open','css_status'=>'green'),
						5 => array('label'=>'В работе','css_class'=>'neurtal','css_status'=>'gray'),
						2 => array('label'=>'Выполнено','css_class'=>'done','css_status'=>'green'),
						3 => array('label'=>'Не выполнено','css_class'=>'closed','css_status'=>'red'),
						4 => array('label'=>'Подтверждено выполнение','css_class'=>'done','css_status'=>'green'));
		return $status[$this->status];
	} */



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


	public function potentialExecutors($obj=false){
		$group=$this->Project0->group;
		return Personnel::groupMembers($group,$obj);
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
			'status0' => array(self::BELONGS_TO, 'TasksStatus', 'status','order'=>'"status0".sort ASC'),
			'place' => array(self::BELONGS_TO,'Workplace','','on'=>'t.type=0 and details[0]::integer="place".id'),
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
			'deadlocks' => 'Траблы',
		);
	}

	public static function isHorn(){
		$res=false;
		$condition=" (\"Project0\".\"group\"::text[] && array['".implode("','",Yii::app()->user->groups)."'])";
		$order="t.timestamp desc  LIMIT 2";
		$model=Tasks::model()->with('Project0')->findAll(array('condition'=>$condition,'order'=>$order));



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

	public function mayUserView(){
		if(Yii::app()->user->isGuest)
			return False;
		return $this->isChangeStatus();
	}

	public static function staffEmployment($group=array()){
		$tgArray=PostsGroups::tasksGroupKeys();
		$wh_group=(!empty($group))?array_uintersect($group,Yii::app()->user->groups,"strcasecmp"):Yii::app()->user->groups;
		$wh_group=array_uintersect($wh_group,$tgArray,"strcasecmp");
	 	$sql = Yii::app()->db->createCommand(
        	"
        	select pr.id,pr.surname,pr.name,pr.patr,pr.photo, count(ts.id) as tasks from personnel as pr
			left join personnel_posts_history as ph on(ph.id_personnel=pr.id and (ph.date_end is null or ph.date_end>current_date))
			left join department_posts as dp on(ph.id_post=dp.id and (dp.date_end is null or dp.date_end>current_date))
			left join tasks as ts on (pr.id::varchar=ANY(ts.executors) and ts.status in(1))
			where (dp.groups::text[] && array['".implode("','",$wh_group)."']) group by pr.id,pr.surname,pr.name,pr.patr order by tasks asc
        	"   
        );
    	$result = $sql->queryAll();
    	return $result;
	}

	public static function deadLineTasks(){
		$criteria=new CDbCriteria;
		$criteria->with=array('Project0','place','status0','TasksActions'=>array('alias'=>'TasksActions','order'=>'"TasksActions".timestamp DESC'),'TasksActions.creator0.personnelPostsHistories.idPersonnel');
		$criteria->addCondition(array('condition'=>"t.deadline<current_timestamp and t.status in (0,1,5,6) and '".Yii::app()->user->id_pers."'=ANY(t.\"executors\")"));
		$model=self::model()->findAll($criteria);
		return $model;
	}

	public static function GroupTasks ($group=array(),$type=3,$date='current_date',$search=NULL){
		$criteria=new CDbCriteria;
		$criteria->with=array('Project0','place','status0','TasksActions'=>array('alias'=>'TasksActions','order'=>'"TasksActions".timestamp DESC'),'TasksActions.creator0.personnelPostsHistories.idPersonnel');

		$wh_group=(!empty($group))?array_uintersect($group,Yii::app()->user->groups,"strcasecmp"):Yii::app()->user->groups;

		//print_r($wh_group); 
		switch ($type) {
			//все, кроме помеченных как просмотренные
			//текущие
			case '1':
				$criteria->addCondition(array('condition'=>"t.status in (0,1,5,6) "));
				$order="status0.sort asc,t.deadline asc,t.timestamp desc";
				break;

			case '2':
				$criteria->addCondition(array('condition'=>"t.status in (0,1,5,6) and '".Yii::app()->user->id_pers."'=ANY(t.\"executors\")"));
				$criteria->order="status0.sort asc, t.deadline asc, t.timestamp desc";
				break;
			
			case '3':
				$criteria->addCondition(array('condition'=>"((t.timestamp::date=$date or t.timestamp_end::date=$date) or t.status in (0,1,5,6))"));
				$criteria->order="status0.sort asc,t.deadline asc,t.timestamp desc";
				break;
			//за день
			case '4':
				$criteria->addCondition(array('condition'=>"((t.timestamp::date=$date or t.timestamp_end::date=$date))"));
				$criteria->order="status0.sort asc,t.deadline asc,t.timestamp desc";
				break;

			case '5':
				$search=mb_strtolower($search,'UTF-8');
				if(!empty($search) and strlen($search)>4){
					$criteria->compare('LOWER(t.tname)',$search,true, 'OR');	
					$criteria->compare('LOWER(t.ttext)',$search,true, 'OR');	
				}else{
					$criteria->compare('t.id',0);
				}
				$criteria->order="status0.sort asc,t.timestamp desc";
				break;

			default:
				
			break;
		}

		$criteria->addCondition(array('condition'=>"((t.\"group\"::text[] && array['".implode("','",$wh_group)."']) or (\"Project0\".\"group\"::text[] && array['".implode("','",$wh_group)."']) )"));

		//	$model=Tasks::model()->with(array(
 		//		'TasksActions'=>array('alias'=>'TasksActions','condition'=>'"TasksActions".type=0','order'=>'"TasksActions".date DESC,"TasksActions".timestamp DESC')))->findAll(array('condition'=>$condition,'order'=>$order));
		$model=Tasks::model()->findAll($criteria);
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
		if(!empty($this->Project0))
			return $this->Project0->ico();
	}
	/*
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
	} */
	
	public function detailsShow($short=False,$place=True,$htmlinfo=False){
		$result='';
		if($htmlinfo)
			$result.='<div class=rightinfo><i>Срок исполнения: '.$this->deadline.'</i></div>';	
		switch ($this->type) {
			case '1':
				$m=Equipment::model()->with('idWorkplace.idCabinet.idFloor.idBuilding')->findByPk($this->details[0]);
				if(!empty($m)){
					$result.=$m->idWorkplace->wpNameFull($short);
					if($place==True){
						$result.=' <a href=/glass/Workplace/'.$m->idWorkplace->id.'><img src="'.Yii::app()->request->baseUrl.'/images/door.png" style="height: 24px;"></a>';
						$result.=' <img src="'.Yii::app()->request->baseUrl.'/images/funnel.png" class=plcJsFilter id="'.$m->idWorkplace->getBuildingName().'" >';
					}
					if(!$short)
						$result.="\nПринтер: $m->mark";
				}			
				break;

			case '0':
				
				$m=Workplace::model()->with('idCabinet.idFloor.idBuilding')->findByPk($this->details[0]);
				if(!empty($m)){
					$result.=$m->wpNameFull($short);
					if($place==True){
						$result.=' <a href=/glass/Workplace/'.$m->id.'><img src="'.Yii::app()->request->baseUrl.'/images/door.png" style="height: 24px;"></a>';
						$result.=' <img src="'.Yii::app()->request->baseUrl.'/images/funnel.png" class=plcJsFilter id="'.$m->getBuildingName().'" ">';
					}
					if(!$short)
						$result.=" ";
				}
				/*
				if(!empty($this->place)){
					$result.=$this->place->wpNameFull($short);
					$result.=' <a href=/glass/Workplace/'.$m->id.'><img src="../images/door.png" style="height: 24px;"></a>';
				}	*/	
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
		#$criteria->compare("'".Yii::app()->user->id_pers."'=ANY(\"executors\")",$this->inExecutors);

		$tname=explode(' ',$this->tname);
		foreach ($tname as $v) {
			$criteria->compare('LOWER(t.tname)||LOWER(t.ttext)',mb_strtolower($v),true);
		}

		if(!empty($this->timestamp)){
			if(!empty($this->timestamp_end)){
				$criteria->addCondition(array('condition'=>"t.timestamp>'".$this->timestamp." 00:00:00' and t.timestamp<'".$this->timestamp_end." 23:59:59'"));
			}else{
				$criteria->addCondition(array('condition'=>"t.timestamp>'".$this->timestamp." 00:00:00' and t.timestamp<'".$this->timestamp." 23:59:59'"));
			}
		}

		$criteria->compare('status',$this->status);
		$criteria->compare('type',$this->type);


		$criteria->compare('project',$this->project);

		/*
		if(!empty($this->place)){
			$place=explode('_',$this->place);
			switch ($place[0]) {
				case 'b':
					$criteria->compare('"idBuilding".id',$place[1]);
					break;
				case 'f':
					$criteria->compare('"idFloor".id',$place[1]);
					break;
				default:
					# code...
					break;
			}
		}*/


		$criteria->compare('departmentposts.id',$this->creator);
		if(is_array($this->executors))
		foreach ($this->executors as $v) {
			$criteria->addCondition('\''.$v.'\'=ANY("executors")');
		}
	
		
		$criteria->compare('departmentposts.creator',$this->creator0creator,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>30),
		));
	}
}
