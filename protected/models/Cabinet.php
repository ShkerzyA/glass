<?php

/**
 * This is the model class for table "cabinet".
 *
 * The followings are the available columns in table 'cabinet':
 * @property integer $id
 * @property integer $id_floor
 * @property string $cname
 * @property string $num
 * @property string $phone
 *		 * The followings are the available model relations:


 * @property Floor $idFloor


 * @property Workplace[] $workplaces
 */
class Cabinet extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cabinet the static model class
	 */
	public static $modelLabelS='Кабинет';
	public static $modelLabelP='Кабинеты';
	
	public $idFloorid_floor;public $workplacesid_cabinet;

	public function behaviors(){
		return array(
			'PreFill'=>array(
				'class'=>'application.behaviors.PreFillBehavior',
				),
			);
	}


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
			array('id_floor', 'required'),
			array('id_floor', 'numerical', 'integerOnly'=>true),
			array('cname', 'length', 'max'=>50),
			array('num', 'length', 'max'=>10),
			array('phone', 'length', 'max'=>100),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_floor, cname, num, phone,idFloorid_floor,workplacesid_cabinet', 'safe', 'on'=>'search'),
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
			'idFloor' => array(self::BELONGS_TO, 'Floor', 'id_floor'),
			'workplaces' => array(self::HAS_MANY, 'Workplace', 'id_cabinet'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_floor' => 'Здание/Этаж',
			'cname' => 'Название',
			'num' => 'Номер',
			'phone' => 'Телефон',
			'idFloorid_floor' => 'Этаж',
			'workplacesid_cabinet' => 'Рабочие места',
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

		$criteria->with=array('idFloor' => array('alias' => 'floor'),'workplaces' => array('alias' => 'workplace'),);
		$criteria->compare('id',$this->id);
		if(!empty($_GET['id_floor']))
				$criteria->compare('id_floor',$_GET['id_floor']);
		else
				$criteria->compare('id_floor',$this->id_floor);
		$criteria->compare('cname',$this->cname,true);
		$criteria->compare('num',$this->num,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('floor.fname',$this->idFloorid_floor,true);
		$criteria->compare('workplace.id_cabinet',$this->workplacesid_cabinet,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}