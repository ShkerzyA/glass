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
	public static $actType=array('Задача создана','Задача изменена');


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function scopes()
	{
    	$t=$this->getTableAlias(false);
    	return array(
        	'defaultScope'=>array('with'=>array('creator0')),
    	);
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

	private function cartInfo($moreinfo){
		$result='<br>';
		if(!empty($moreinfo['cart']))
			$result.='установлен: '.$moreinfo['cart']."<br>";
		if(!empty($moreinfo['cart_old']))
			$result.='возвращен: '.$moreinfo['cart_old']."<br>";
		if(!empty($moreinfo['num_str']))
			$result.='Кол-во отпечатков: '.$moreinfo['num_str']."<br>";
		if(!empty($moreinfo['subs_num']))
			$result.='Отпечатано на картридже: '.$moreinfo['subs_num']."<br>";

		return $result;
	}

	public function saveReport($moreinfo=array()){

		$cartInfo=$this->cartInfo($moreinfo);
		$this->ttext=$_POST['taskname'].$this->limiter.$_POST['mess'].$cartInfo.$this->limiter.$_POST['taskstat'].$this->limiter.$_POST['note'];
		$this->type=2;
		$this->save();
	}


	public function saveAction($id_task,$actt,$fields=array()){
		$this->type=3;
		$this->id_task=$id_task;
		$this->ttext=$actt.$this->limiter.(implode("\n",$fields));
		$this->save();
	}


	public function saveStatus(){
		$this->ttext=$_POST['stat'];
		$this->type=0;
		$this->save();
	}


	public static function UserReportToday($date='current_date'){
		$models=self::model()->findAll(array('condition'=>"t.creator=".Yii::app()->user->id_pers." and t.type=2 and t.timestamp::date=$date"));
		return $models;
	}

	public static function OtdelReportToday($date='current_date'){
		$models=array();
		$posts=DepartmentPosts::depPosts(Yii::app()->user->departments_rn[0]);
		foreach ($posts as $dp) {
			if(!empty($dp->personnelPostsHistories)){
				foreach ($dp->personnelPostsHistories as $ph) {
					if (!$ph->inactive()){
						$pers=$ph->idPersonnel;
						$pers['actions']=self::model()->findAll(array('condition'=>"t.creator=".$ph->id_personnel." and t.type=2 and t.timestamp::date=$date"));
						$models[]=$pers;
					}
				}
			}
		}
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
			array('creator, id_task', 'required'),
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
			'creator0' => array(self::BELONGS_TO, 'Personnel', 'creator','alias'=>'ccreator0'),
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
	public function tapesearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with=array('creator0' => array('alias' => 'creator0'),'idTask' => array('alias' => 'idTask'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('ttext',$this->ttext,true);
		$criteria->compare('timestamp',$this->timestamp,true);
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
		$criteria->order='t.id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>30),
		));
	}

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
