<?php

/**
 * This is the model class for table "floor".
 *
 * The followings are the available columns in table 'floor':
 * @property integer $id
 * @property integer $id_building
 * @property string $fnum
 * @property string $fname
 *		 * The followings are the available model relations:


 * @property Cabinet[] $cabinets


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

	public static $tree=array(
		'parent_id'=>'id_building',
		'query'=>"SELECT m1.id, m1.fname AS text, m1.id as parent_id, count(m2.id) AS \"hasChildren\" FROM floor AS m1 LEFT JOIN cabinet AS m2 ON m1.id=m2.id_floor",
		'group'=>'GROUP BY m1.id  ORDER BY m1.fnum ASC',
		'child'=>'Cabinet',
		'parent_id'=>'id_building'
	);
	
	public $cabinetsid_floor;public $idBuildingid_building;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
			'PreFill'=>array(
				'class'=>'application.behaviors.PreFillBehavior',
				),
			);
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
			array('fnum', 'length', 'max'=>10),
			array('fname', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_building, fnum, fname,cabinetsid_floor,idBuildingid_building', 'safe', 'on'=>'search'),
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
			'cabinets' => array(self::HAS_MANY, 'Cabinet', 'id_floor'),
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
			'id_building' => 'Id Здания',
			'fnum' => 'Номер',
			'fname' => 'Название',
			'cabinetsid_floor' => 'Кабинеты',
			'idBuildingid_building' => 'Здание',
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

		$criteria->with=array('cabinets' => array('alias' => 'cabinet'),'idBuilding' => array('alias' => 'building'),);
		$criteria->compare('id',$this->id);
		if(!empty($_GET['id_building']))
				$criteria->compare('id_building',$_GET['id_building']);
		else
				$criteria->compare('id_building',$this->id_building);
		$criteria->compare('fnum',$this->fnum,true);
		$criteria->compare('fname',$this->fname,true);
		$criteria->compare('cabinet.fname',$this->cabinetsid_floor,true);
		$criteria->compare('building.bname',$this->idBuildingid_building,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}