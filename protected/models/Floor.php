<?php

/**
 * This is the model class for table "floor".
 *
 * The followings are the available columns in table 'floor':
 * @property integer $id
 * @property integer $id_building
 * @property string $name
 * @property string $num
 *		 * The followings are the available model relations:


 * @property Building $idBuilding
 */
class Floor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Floor the static model class
	 */
	public static $modelLabelS='Этаж';
	public static $modelLabelP='Этажи';
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'floor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_building', 'required'),
			array('id_building', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('num', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_building, name, num', 'safe', 'on'=>'search'),
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
			'idBuilding' => array(self::BELONGS_TO, 'Building', 'id_building'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_building' => 'Id Building',
			'name' => 'Name',
			'num' => 'Num',
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
		if(!empty($_GET['id_building']))
				$criteria->compare('id_building',$_GET['id_building']);
		else
				$criteria->compare('id_building',$this->id_building);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('num',$this->num,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}