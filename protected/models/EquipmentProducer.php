<?php

/**
 * This is the model class for table "equipment_producer".
 *
 * The followings are the available columns in table 'equipment_producer':
 * @property integer $id
 * @property string $name
 * @property string $type
 *		 * The followings are the available model relations:


 * @property Equipment[] $equipments
 */
class EquipmentProducer extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EquipmentProducer the static model class
	 */
	public static $modelLabelS='Производитель оборудования';
	public static $modelLabelP='Производители оборудования';
	
	public $equipmentsproducer;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getAll(){
		$result=array();
		$models=self::model()->findAll();
		foreach ($models as $m) {
			$result['values'][$m->id]=$m->name;
			$result['css_class'][$m->id]=array('class'=>$m->type);
		}
		return $result;

	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'equipment_producer';
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
			array('type', 'length', 'max'=>255),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, type,equipmentsproducer', 'safe', 'on'=>'search'),
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
			'equipments' => array(self::HAS_MANY, 'Equipment', 'producer'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Наименование',
			'type' => 'Принадлежность к типу',
			'equipmentsproducer' => 'Производитель',
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

		$criteria->with=array('equipments' => array('alias' => 'equipment'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('equipment.producer',$this->equipmentsproducer,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
