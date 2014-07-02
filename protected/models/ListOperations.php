<?php

/**
 * This is the model class for table "list_operations".
 *
 * The followings are the available columns in table 'list_operations':
 * @property integer $id
 * @property string $name
 *		 * The followings are the available model relations:


 * @property Eventsoper[] $eventsopers
 */
class ListOperations extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ListOperations the static model class
	 */
	public static $modelLabelS='ListOperations';
	public static $modelLabelP='ListOperations';
	
	public $eventsopersoperation;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'list_operations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>200),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name,eventsopersoperation', 'safe', 'on'=>'search'),
		);
	}

	public function suggestTag($keyword){
 		$tags=$this->findAll(array(
   			'condition'=>'name LIKE :keyword OR s_kod LIKE :keyword',
   			'params'=>array(
     		':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
   		)
 		));
 		return $tags;
}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'eventsopers' => array(self::HAS_MANY, 'Eventsoper', 'operation'),
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
			'eventsopersoperation' => 'operation',
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

		$criteria->with=array('eventsopers' => array('alias' => 'eventsoper'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('eventsoper.operation',$this->eventsopersoperation,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
