<?php

/**
 * This is the model class for table "equipment".
 *
 * The followings are the available columns in table 'equipment':
 * @property integer $id
 * @property integer $id_workplace
 * @property string $serial
 * @property integer $type
 * @property integer $producer
 * @property string $mark
 * @property string $inv
 * @property integer $status
 * @property string $notes
 *		 * The followings are the available model relations:


 * @property Workplace $idWorkplace
 */
class Equipment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Equipment the static model class
	 */
	public static $modelLabelS='Оборудование';
	public static $modelLabelP='Оборудование';
	
	public $idWorkplaceid_workplace;


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
		return 'equipment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public static function getType(){
		return array(
			0=>'Системный блок',
			1=>'Монитор',
			2=>'Принтер',
			3=>'МФУ',
			4=>'Копир',
			5=>'Сканер',
			6=>'Телефон(IP)',
			7=>'ИБП',
			8=>'Коммутатор',
			9=>'Ноутбук',
			10=>'Телефон',
			11=>'Телевизор',
			12=>'Кодек ВКС',
			13=>'Преобразователь',
		);
	}

	public static function getProducer(){
		return array(
			'values'=>(array(
				0=>'HP',
				1=>'Samsung',
				2=>'Xerox',
				3=>'Kraftway',
				4=>'Canon',
				5=>'Asus',
				6=>'Aquarius',
				7=>'LG',
				8=>'AOC',
				9=>'Acer',
				10=>'Avaya',
				11=>'Powercom',
				12=>'Ippon',
				13=>'D-link',
				14=>'Zyxel',
				15=>'Panasonic',
				16=>'LifeSize',
				17=>'Neon',
				18=>'Philips',
				19=>'Riello',
				20=>'MB',
				21=>'Depo',
				22=>'Starcom',
				23=>'Sharp',
				24=>'Epson',
				25=>'MOXA',
				26=>'TP-link',
				27=>'SonicWall',
				28=>'Averion',

				)),
			'css_class'=>(array(
				0=>array('class'=>'c0 c1 c2 c3 с5 с6 c9'),
				1=>array('class'=>'c1 c2 c3 c4 c5 c11'),
				2=>array('class'=>'c2 c3 c4 c5'),
				3=>array('class'=>'c0 c1'),
				4=>array('class'=>'c2 c3'),
				5=>array('class'=>'c1 c9'),
				6=>array('class'=>'c0 c1'),
				7=>array('class'=>'c1 c2 c3 c4 c5 c11'),
				8=>array('class'=>'c1'),
				9=>array('class'=>'c1 c9'),
				10=>array('class'=>'c6'),
				11=>array('class'=>'c7'),
				12=>array('class'=>'c7'),
				13=>array('class'=>'c8'),
				14=>array('class'=>'c8'),
				15=>array('class'=>'c10'),
				16=>array('class'=>'c12'),
				17=>array('class'=>'c0'),
				18=>array('class'=>'c1'),
				19=>array('class'=>'c7'),
				20=>array('class'=>'c3'),
				21=>array('class'=>'c0'),
				22=>array('class'=>'c0'),
				23=>array('class'=>'c3'),
				24=>array('class'=>'c5 c2'),
				25=>array('class'=>'c13'),
				26=>array('class'=>'c8'),
				27=>array('class'=>'c8'),
				28=>array('class'=>'c0'),
				)
			),
		);
	}

	public static function getStatus(){
		return array(
			0=>'В эксплуатации',
			1=>'Не в эксплуатации',
			2=>'Неисправно',
			3=>'К списанию',
			4=>'Списано',
			);
	}


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_workplace, type, producer, status', 'numerical', 'integerOnly'=>true),
			array('serial, inv', 'length', 'max'=>100),
			array('mark', 'length', 'max'=>200),
			array('notes', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_workplace, serial, type, producer, mark, inv, status, notes,idWorkplaceid_workplace', 'safe', 'on'=>'search'),
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
			'idWorkplace' => array(self::BELONGS_TO, 'Workplace', 'id_workplace'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_workplace' => 'Рабочее место',
			'serial' => 'Серийный номер',
			'type' => 'Тип',
			'producer' => 'Производитель',
			'mark' => 'Модель',
			'inv' => 'Инвентарный номер',
			'status' => 'Состояние',
			'notes' => 'Примечания',
			'idWorkplaceid_workplace' => 'Рабочее место',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */

	public function search_for_export(){
		$criteria=new CDbCriteria;
		$criteria->with=array('idWorkplace','idWorkplace.idPersonnel','idWorkplace.idCabinet.idFloor.idBuilding'); // 
		//$criteria->compare('personnel.creator',$this->creator0creator,true);
		return self::model()->findAll($criteria);
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with=array('idWorkplace' => array('alias' => 'workplace'),);
		$criteria->compare('id',$this->id);
		if(!empty($_GET['id_workplace']))
				$criteria->compare('id_workplace',$_GET['id_workplace']);
		else
				$criteria->compare('id_workplace',$this->id_workplace);
		$criteria->compare('serial',$this->serial,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('producer',$this->producer);
		$criteria->compare('mark',$this->mark,true);
		$criteria->compare('inv',$this->inv,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('workplace.id_workplace',$this->idWorkplaceid_workplace,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
