<?php

/**
 * This is the model class for table "act_of_transfer".
 *
 * The followings are the available columns in table 'act_of_transfer':
 * @property integer $id
 * @property string $timestamp
 * @property integer $status
 * @property integer $transferring
 * @property integer $receiving
 * @property string $receiving_var
 * @property integer $creator
 *		 * The followings are the available model relations:


 * @property EqActsoftransfer[] $eqActsoftransfers
 */
class ActOfTransfer extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ActOfTransfer the static model class
	 */
	public static $modelLabelS='Акт перемещения';
	public static $modelLabelP='Акты перемещения';
	public static $statusArr=array(
		0=>'Создан',
		1=>'Распечатан',
		2=>'Подписан',
		3=>'В архиве',
		);
	
	public $eqActsoftransfersid_act;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'act_of_transfer';
	}

	public function behaviors(){
		return array(
			'TimeStamp'=>array(
				'class'=>'application.behaviors.TimeStampBehavior',
				),
			'PreFill'=>array(
				'class'=>'application.behaviors.PreFillBehavior',
				),
			'FixedOwner'=>array(
				'class'=>'application.behaviors.FixedOwnerBehavior',
				),
			'ESaveRelatedBehavior'=>array(
				'class'=>'application.behaviors.ESaveRelatedBehavior',
				),


			);
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, transferring, receiving, creator', 'numerical', 'integerOnly'=>true),
			array('receiving_var', 'length', 'max'=>100),
			array('timestamp,equipments', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, timestamp, status, transferring, receiving, receiving_var,equipments, creator,eqActsoftransfersid_act', 'safe', 'on'=>'search'),
		);
	}

	public function getStatus(){
		if(!empty($this->status))
			return self::$statusArr[$this->status];
	}

	public function getTransferring(){
		return (!empty($this->transferring))?$this->transferring0->fio_full():'';
	}

	public function getReceiving(){
		return (!empty($this->receiving))?$this->receiving0->fio_full():((!empty($this->receiving_var))?$this->receiving_var:'');
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'creator0' => array(self::BELONGS_TO, 'Personnel', 'creator'),
			'transferring0' => array(self::BELONGS_TO, 'Personnel', 'transferring'),
			'receiving0' => array(self::BELONGS_TO, 'Personnel', 'receiving'),
			'equipments'=>array(self::MANY_MANY,'Equipment','eq_actsoftransfer(id_act,id_eq)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'timestamp' => 'Дата',
			'status' => 'Статус',
			'transferring' => 'Передал',
			'receiving' => 'Принял',
			'receiving_var' => 'Принял',
			'creator' => 'Создал акт',
			'eqActsoftransfersid_act' => 'id_act',
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

		//$criteria->with=array('eqActsoftransfers' => array('alias' => 'eqactsoftransfer'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('transferring',$this->transferring);
		$criteria->compare('receiving',$this->receiving);
		$criteria->compare('receiving_var',$this->receiving_var,true);
		$criteria->compare('creator',$this->creator);
		//$criteria->compare('eqactsoftransfer.id_act',$this->eqActsoftransfersid_act,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
