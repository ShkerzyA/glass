<?php

/**
 * This is the model class for table "tasks_status".
 *
 * The followings are the available columns in table 'tasks_status':
 * @property integer $id
 * @property string $label
 * @property string $css_class
 * @property string $css_status
 * @property integer $sort
 *		 * The followings are the available model relations:


 * @property Tasks[] $tasks
 */
class TasksStatus extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TasksStatus the static model class
	 */
	public static $modelLabelS='TasksStatus';
	public static $modelLabelP='TasksStatus';
	
	public $tasksstatus;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tasks_status';
	}

	public static function statusList(){
		$res=array();
		$models=self::model()->findAll(array('order'=>'t.sort asc'));
		foreach ($models as $m) {
			$res[$m->id]=$m->label;
		}
		return $res;
	}

	public static function statusListFull(){
		$res=array();
		$models=self::model()->findAll(array('order'=>'t.sort asc'));
		foreach ($models as $m) {
			$res[$m->id]=$m->label;
		}
		return $res;
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sort', 'numerical', 'integerOnly'=>true),
			array('label, css_class, css_status', 'length', 'max'=>100),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, label, css_class, css_status, sort,tasksstatus', 'safe', 'on'=>'search'),
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
			'tasks' => array(self::HAS_MANY, 'Tasks', 'status'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'label' => 'Label',
			'css_class' => 'Css Class',
			'css_status' => 'Css Status',
			'sort' => 'Sort',
			'tasksstatus' => 'status',
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

		$criteria->with=array('tasks' => array('alias' => 'tasks'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('css_class',$this->css_class,true);
		$criteria->compare('css_status',$this->css_status,true);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('tasks.status',$this->tasksstatus,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
