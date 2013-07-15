<?php

/**
 * This is the model class for table "department".
 *
 * The followings are the available columns in table 'department':
 * @property integer $id
 * @property integer $id_parent
 * @property string $name
 * @property string $date_begin
 * @property string $date_end
 *		 * The followings are the available model relations:


 * @property DepartmentPosts[] $departmentPosts
 */
class Department extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Department the static model class
	 */
	public static $modelLabelS='Отдел';
	public static $modelLabelP='Отделы';
	
	public $idParentid_parent;
	public $departmentsid_parent;
	public $departmentPostsid_department;



	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
			'DateBeginEnd'=>array(
				'class'=>'application.behaviors.DateBeginEndBehavior',
				),
			);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'department';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date_begin', 'required'),
			array('id_parent', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('date_end', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_parent, name, date_begin, date_end,departmentPostsid_department', 'safe', 'on'=>'search'),
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
			'idParent' => array(self::BELONGS_TO, 'Department', 'id_parent','alias'=>'parent_dept'),
            'departments' => array(self::HAS_MANY, 'Department', 'id_parent'),
            'departmentPosts' => array(self::HAS_MANY, 'DepartmentPosts', 'id_department','order'=>'post DESC'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_parent' => 'Вышестоящий отдел',
			'name' => 'Название отдела',
			'date_begin' => 'Начало работы',
			'date_end' => 'Окончание работы',
			'departmentPostsid_department' => 'Должности отдела',
			'idParentid_parent' => 'Вышестоящий отдел',
            'departmentsid_parent' => 'Дочерние отделы',
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

		$criteria->with=array('idParent' => array('alias' => 'department'),'departments' => array('alias' => 'departments'),'departmentPosts' => array('alias' => 'department_posts'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('id_parent',$this->id_parent);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('date_begin',$this->date_begin,true);
		$criteria->compare('date_end',$this->date_end,true);
		$criteria->compare('department.name',$this->idParentid_parent,true);
        //$criteria->compare('department.id_parent',$this->departmentsid_parent,true);
		$criteria->compare('department_posts.name',$this->departmentPostsid_department,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}