<?php

/**
 * This is the model class for table "eq_actsoftransfer".
 *
 * The followings are the available columns in table 'eq_actsoftransfer':
 * @property integer $id
 * @property integer $id_eq
 * @property integer $id_act
 *		 * The followings are the available model relations:


 * @property Equipment $idEq


 * @property ActOfTransfer $idAct
 */
class EqActsoftransfer extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EqActsoftransfer the static model class
	 */
	public static $modelLabelS='EqActsoftransfer';
	public static $modelLabelP='EqActsoftransfer';
	
	public $idEqid_eq;
	public $idActid_act;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'eq_actsoftransfer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, id_eq, id_act', 'required'),
			array('id, id_eq, id_act', 'numerical', 'integerOnly'=>true),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_eq, id_act,idEqid_eq,idActid_act', 'safe', 'on'=>'search'),
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
			'idEq' => array(self::BELONGS_TO, 'Equipment', 'id_eq'),
			'idAct' => array(self::BELONGS_TO, 'ActOfTransfer', 'id_act'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_eq' => 'Id Eq',
			'id_act' => 'Id Act',
			'idEqid_eq' => 'id_eq',
			'idActid_act' => 'id_act',
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

		$criteria->with=array('idEq' => array('alias' => 'equipment'),'idAct' => array('alias' => 'actoftransfer'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('id_eq',$this->id_eq);
		$criteria->compare('id_act',$this->id_act);
		$criteria->compare('equipment.id_eq',$this->idEqid_eq,true);
		$criteria->compare('actoftransfer.id_act',$this->idActid_act,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
