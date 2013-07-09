<?php

/**
 * This is the model class for table "personnel_posts".
 *
 * The followings are the available columns in table 'personnel_posts':
 * @property integer $id
 * @property string $post
 * @property integer $id_department
 *
 * The followings are the available model relations:
 * @property Personnel[] $personnels
 * @property Department $idDepartment
 */
class DepartmentPosts extends CActiveRecord
{		
	public $id_post; //Люди, работающие на должности
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DepartmentPosts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
            // наше поведение для работы с файлом
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
			array('post', 'length', 'max'=>50),

			array('id_department', 'numerical', 'integerOnly'=>true),
			array('date_begin, date_end', 'date', 'format'=>'dd.MM.yyyy'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, post, id_department, date_begin, date_end, department, id_post', 'safe', 'on'=>'search'),
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
			'personnel_posts_history' => array(self::HAS_MANY, 'PersonnelPostsHistory', 'id_post'),
			'department' => array(self::BELONGS_TO, 'Department', 'id_department'),
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
			'department'=>'Отдел',
			'date_begin' => 'Дата включения',
			'date_end' => 'Дата закрытия',
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
		$criteria->with = array('personnel_posts_history','department');

		//$all_person=PersonnelPostsHistory::model()->findAll(array('condition'=>"id_post=$this->id"));

		//$this->inpost=1;

		$criteria->compare('id',$this->id);
		$criteria->compare('department.name', $this->department, true );
		$criteria->compare('post',$this->post,true);
		$criteria->compare('t.date_begin',$this->date_begin,true);
		$criteria->compare('t.date_end',$this->date_end,true);

		$criteria->compare('personnel_posts_history.post',$this->id_post);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


}