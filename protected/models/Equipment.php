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

	//id рабочих мест, для оборота картриджей
	public static $cartStorage='574';
	public static $cartFull='597';
	public static $cartRefill='596';
	public $place;
	
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


	public static function getStatus(){
		return array(
			0=>'В эксплуатации',
			1=>'Не в эксплуатации',
			2=>'Неисправно',
			3=>'К списанию',
			4=>'Списано',
			);
	}

	public static function cartMassMovie($type,$inv){

		$carts=array();
		$errors=array();

		switch ($type) {
			case 3:
				$from=self::$cartStorage;
				$to=self::$cartRefill;
				break;
			case 4:
				$from=self::$cartRefill;
				$to=self::$cartFull;
				break;
			
			default:
				return array('Неопределенное действие');
				break;
		}


		$inv=explode(',', $inv);
		foreach ($inv as $v) {
			$mod=self::model()->find(array('condition'=>'t.id_workplace='.$from.' and t.inv=\''.$v.'\''));
			if($mod)
				$carts[]=$mod;
			else
				$errors[]='картридж с таким инв. отсутствует: '.$v;
		}
		if(!empty($errors)){
			return $errors;
		}else{
			foreach ($carts as $v) {
				$v->id_workplace=$to;
				$v->save();
			}
		}

	}


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_workplace, type, producer, status', 'numerical', 'integerOnly'=>true),
			array('type','required'),
			array('serial, inv', 'length', 'max'=>100),
			array('mark', 'length', 'max'=>200),
			array('notes', 'safe'),
			array('id','uniqueInvSerial'),
			array('id, id_workplace, serial, type, producer, mark, inv, status, notes,idWorkplaceid_workplace,place', 'safe', 'on'=>'search'),
		);
	}

		public function uniqueInvSerial()
    {   

    	$idCheck='';
    	if(!empty($this->id))
    		$idCheck=' and t.id<>'.$this->id.'';

    	if(!empty($this->serial)){
    		$Ph=self::findAll(array('condition'=>'t.serial=\''.$this->serial.'\' '.$idCheck));
    		foreach ($Ph as $v){
        		$this->addError('serial','Оборудование с данным серийным номером зарегистрировано ID:'.$v->id.')');
        	}
    	}else if(!empty($this->inv)){
    		$Ph=self::findAll(array('condition'=>'t.inv=\''.$this->inv.'\' '.$idCheck));
    		foreach ($Ph as $v){
        		$this->addError('inv','Оборудование с данным инвентарным номером зарегистрировано ID:'.$v->id.')');
        	}
    	}
   
    }

	public function inv(){
		if($this->type==18)
			return ' инв.'.$this->inv;
	}

	public function full_name(){
		return $this->serial.' '.$this->type0->name.' '.$this->producer0->name.' '.$this->mark.' '.$this->inv();
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
			'type0' => array(self::BELONGS_TO, 'EquipmentType', 'type'),
			'producer0' => array(self::BELONGS_TO, 'EquipmentProducer', 'producer'),
			'EquipmentLog' => array(self::HAS_MANY, 'EquipmentLog', 'object'),
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
			'place' => 'Местоположение',
			'idWorkplaceid_workplace' => 'Рабочее место',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */

	public function search_for_export(){
		$criteria=new CDbCriteria;
		$criteria->with=array('type0','producer0','idWorkplace.idPersonnel','idWorkplace.idCabinet.idFloor.idBuilding'); // 
		$criteria->order=('"idBuilding".bname ASC, "idFloor".fnum ASC, "idCabinet".num ASC');
		//$criteria->compare('personnel.creator',$this->creator0creator,true);
		return self::model()->findAll($criteria);
	}

	public function suggestTag($keyword){
		$keyword=mb_strtolower($keyword,'UTF-8');
 		$tags=$this->with('type0','producer0','idWorkplace.idPersonnel','idWorkplace.idCabinet.idFloor.idBuilding')->findAll(array(
   			'condition'=>'(LOWER("idPersonnel".surname) LIKE :keyword OR LOWER("idBuilding".bname) LIKE :keyword OR LOWER("idCabinet".num) LIKE :keyword OR LOWER("idCabinet".cname) LIKE :keyword) and (t.type in (3,2,4,17))',
   			'params'=>array(
     		':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',

   		)
   		,'order'=>'"idBuilding".bname asc, "idFloor".fnum asc, "idCabinet".num asc'
 		));
 		return $tags;
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('idWorkplace' => array('alias' => 'workplace'),'idWorkplace.idCabinet.idFloor.idBuilding');
		$criteria->compare('t.id',$this->id);
		if(!empty($_GET['id_workplace']))
				$criteria->compare('workplace.wname',$_GET['id_workplace'],true);
		else
				$criteria->compare('workplace.wname',$this->id_workplace);

		if(!empty($this->place)){
			$place=explode('_',$this->place);
			switch ($place[0]) {
				case 'b':
					$criteria->compare('"idBuilding".id',$place[1]);
					break;
				case 'f':
					$criteria->compare('"idFloor".id',$place[1]);
					break;
				default:
					# code...
					break;
			}
		}

		$criteria->compare('LOWER(t.serial)',mb_strtolower($this->serial,'UTF-8'),true);
		$criteria->compare('type',$this->type);
		$criteria->compare('producer',$this->producer);
		$criteria->compare('mark',$this->mark,true);
		$criteria->compare('inv',$this->inv,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('workplace.wname',$this->idWorkplaceid_workplace,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>30),
		));
	}
}
