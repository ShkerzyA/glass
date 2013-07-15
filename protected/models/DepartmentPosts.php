<?php

/**
 * This is the model class for table "department_posts".
 *
 * The followings are the available columns in table 'department_posts':
 * @property integer $id
 * @property string $post
 * @property integer $id_department
 * @property string $date_begin
 * @property string $date_end
 *		 * The followings are the available model relations:


 * @property Department $idDepartment


 * @property PersonnelPostsHistory[] $personnelPostsHistories
 */
class DepartmentPosts extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DepartmentPosts the static model class
	 */
	public static $modelLabelS='Штатная структура';
	public static $modelLabelP='Штатная структура';
	
	public $idDepartmentid_department;
public $personnelPostsHistoriesid_post;


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
		return 'department_posts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_department,islead,kod_parus', 'numerical', 'integerOnly'=>true),
			array('post', 'length', 'max'=>80),
			array('date_begin, date_end', 'date', 'format'=>'dd.MM.yyyy'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, post, id_department, date_begin, date_end, islead, kod_parus, idDepartmentid_department, personnelPostsHistoriesid_post', 'safe', 'on'=>'search'),
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
			'idDepartment' => array(self::BELONGS_TO, 'Department', 'id_department'),
			'personnelPostsHistories' => array(self::HAS_MANY, 'PersonnelPostsHistory', 'id_post','order'=>'t.date_end DESC'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'post' => 'Должность',
			'id_department' => 'Отдел',
			'date_begin' => 'Дата начала',
			'date_end' => 'Дата окончания',
			'idDepartmentid_department' => 'Отдел',
			'personnelPostsHistoriesid_post' => 'Должность',
            'kod_parus' => 'Номер в Парусе',
			'islead' => 'Является руководителем',
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

		$criteria->with=array('idDepartment' => array('alias' => 'department'),'personnelPostsHistories' => array('alias' => 'personnel_posts_history'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('post',$this->post,true);
		if(!empty($_GET['id_department']))
				$criteria->compare('id_department',$_GET['id_department']);
		else
				$criteria->compare('id_department',$this->id_department);
		$criteria->compare('date_begin',$this->date_begin,true);
		$criteria->compare('date_end',$this->date_end,true);
        $criteria->compare('islead',$this->islead,true);
        $criteria->compare('kod_parus',$this->kod_parus);
		$criteria->compare('department.name',$this->idDepartmentid_department,true);
		$criteria->compare('personnel_posts_history.post',$this->personnelPostsHistoriesid_post,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}