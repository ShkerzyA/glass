<?php

/**
 * This is the model class for table "department".
 *
 * The followings are the available columns in table 'department':
 * @property integer $id
 * @property integer $id_parent
 * @property string $name
 * @property integer $manager
 *
 * The followings are the available model relations:
 * @property Personnel $manager0
 * @property PersonnelPosts[] $personnelPosts
 */
class Department extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Department the static model class
	 */
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
			array('id_parent, manager', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('date_begin, date_end', 'date', 'format'=>'dd.MM.yyyy'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_parent, name, manager', 'safe', 'on'=>'search'),
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
			'managerDep' => array(self::BELONGS_TO, 'Personnel', 'manager'),
			'postsDep' => array(self::HAS_MANY, 'DepartmentPosts', 'id_department'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_parent' => 'Id Parent',
			'name' => 'Name',
			'manager' => 'Manager',
			'date_begin' => 'Date Begin',
			'date_end' => 'Date End',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('id_parent',$this->id_parent);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('manager',$this->manager);
		$criteria->compare('date_begin',$this->date_begin,true);
		$criteria->compare('date_end',$this->date_end,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}