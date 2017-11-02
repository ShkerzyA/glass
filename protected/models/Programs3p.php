<?php

/**
 * This is the model class for table "programs3p".
 *
 * The followings are the available columns in table 'programs3p':
 * @property integer $id
 * @property string $name
 * @property string $create_date
 * @property string $close_date
 */
class Programs3p extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Programs3p the static model class
	 */
	public static $modelLabelS='Сторонняя программа';
	public static $modelLabelP='Сторонние программы';
	
	

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'programs3p';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>100),
			array('create_date, close_date', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, create_date, close_date', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'create_date' => 'Create Date',
			'close_date' => 'Close Date',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('close_date',$this->close_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
