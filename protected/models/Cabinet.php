<?php

/**
 * This is the model class for table "cabinet".
 *
 * The followings are the available columns in table 'cabinet':
 * @property integer $id
 * @property integer $id_building
 * @property string $name
 * @property string $num
 * @property string $floor
 * @property string $phone
 *
 * The followings are the available model relations:
 * @property Personnel[] $personnels
 * @property Building $idBuilding
 */
class Cabinet extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cabinet the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cabinet';
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
			array('name, phone', 'length', 'max'=>50),
			array('num', 'length', 'max'=>10),
			array('floor', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_building, name, num, floor, phone', 'safe', 'on'=>'search'),
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
			'personnels' => array(self::HAS_MANY, 'Personnel', 'id_cabinet'),
			'Building' => array(self::BELONGS_TO, 'Building', 'id_building'),
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
			'floor' => 'Floor',
			'phone' => 'Phone',
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
		$criteria->compare('id_building',$this->id_building);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('num',$this->num,true);
		$criteria->compare('floor',$this->floor,true);
		$criteria->compare('phone',$this->phone,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}