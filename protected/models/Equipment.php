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
	public static $maxCartInv;
	public static $cartStorage='574';
	public static $cartFull='597';
	public static $cartRefill='596';
	public static $db_array=array();
	public static $netEqType=array(0,2,3,4,5,6,8,9,11,12,13,16,17);
	public $place;
	public $DopLog;
	public $idWorkplaceid_workplace;
	public $related_eq;
	public $parentparent_id;
	public $equipmentsparent_id;




	public function setMaxCartInv(){
		if($this->type==18){
			if(empty(self::$maxCartInv)){
				self::$maxCartInv=self::model()->find(array('condition'=>'t.type=18','order'=>'substring(t.inv from \'^\\d+\')::int  DESC'))->inv;
			}
			self::$maxCartInv++;
			$this->inv=self::$maxCartInv;
		}	
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
			'PreFill'=>array(
				'class'=>'application.behaviors.PreFillBehavior',
				),
			'DbArray'=>array(
				'class'=>'application.behaviors.DbArrayBehavior',
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

	public function netinfo(){
		if(in_array($this->type, self::$netEqType)){
			return "\n IP ".$this->ip."\n MAC ".$this->mac;
		}
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

	public function getProducer(){
		if(!empty($this->producer))
			return $this->producer0->name;
	}

	public function getWorkplace(){
		if(!empty($this->id_workplace))
			return $this->idWorkplace->wpNameFull();
	}

	public function filterType(){
		$res=array();
		$models=EquipmentType::model()->findall();
		foreach ($models as $v) {
			$res[$v->id]=$v->name;
		}
		return $res;
	}

	public function filterProducer(){
		$res=array();
		$models=EquipmentProducer::model()->findall();
		foreach ($models as $v) {
			$res[$v->id]=$v->name;
		}
		return $res;
	}

	public function neighborsEq(){
		$result=array('values'=>array());
		$models=self::model()->findAll(array('condition'=>'t.id_workplace='.$this->id_workplace.' and t.id<>'.$this->id.' and t.type not in (18)'));
		foreach ($models as $m) {
			$result['values'][$m->id]=$m->full_name();
		}
		return $result;
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

	public function findMyCart(){
		if(!empty($this->equipments))
			$cart_old=$this->equipments[0];

		if(empty($cart_old))
			$cart_old=Equipment::model()->with('EquipmentLog')->find(array('condition'=>"t.type=18 and t.id_workplace=$this->id_workplace and \"EquipmentLog\".details[2]='$this->id'",'order'=>'"EquipmentLog".timestamp DESC'));
		
		return $cart_old;
	}


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_workplace, type, producer, status, parent_id', 'numerical', 'integerOnly'=>true),
			array('id_workplace,type','required'),
			array('serial,inv', 'length', 'max'=>100),
			array('mark', 'length', 'max'=>200),
			array('notes,ip,mac', 'safe'),
			array('id','uniqueInvSerial'),
			array('id, id_workplace, serial, type, producer, mark, inv, ip, mac, status, parent_id, notes,idWorkplaceid_workplace,place,parentparent_id,equipmentsparent_id', 'safe', 'on'=>'search'),
		);
	}

	protected function beforeSave(){
		if (empty($this->ip))
			$this->ip=NULL;
		if (empty($this->mac))
			$this->mac=NULL;
		return parent::beforeSave();
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
		$prod=(!empty($this->producer))?$this->producer0->name:'';
		$notes=($this->type==0)?$this->notes:'';

		return $this->type0->name.' '.$prod.' '.$this->mark.' <b>'.$this->serial.'</b> '.$notes.' '.$this->inv();
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
			'parentEq' => array(self::BELONGS_TO, 'Equipment', 'parent_id'),
            'equipments' => array(self::HAS_MANY, 'Equipment', 'parent_id'),
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
			'parent_id' => 'Привязка',
			'ip' => 'IP',
			'mac' => 'MAC',
			'idWorkplaceid_workplace' => 'Рабочее место',
            'parentparent_id' => 'Принадлежность',
            'equipmentsparent_id' => 'Зависимое оборудование',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public static function printersWithLog(){
		$models=self::model()->with('EquipmentLog')->findAll(array('condition'=>'t.type in (2,3,4,17)'));	
		foreach ($models as &$v) {
			$tmp=EquipmentLog::model()->findAll(array('condition'=>'t.type=1 and \''.$v->id.'\'=t.details[2]'));
			//print_r($tmp);
			//$v->EquipmentLog=array_merge($v->EquipmentLog,$tmp);
		}
		return $models;
	}


	public function removeChildRel($idchild){
		if(!empty($this->equipments)){
			foreach ($this->equipments as $v) {
				if($v->id==$idchild){
					$v->parent_id=NULL;
					$v->save();
				}
			}
		}
	}

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
		$criteria->compare('t.type',$this->type);
		$criteria->compare('producer',$this->producer);
		$criteria->compare('mark',$this->mark,true);
		$criteria->compare('inv',$this->inv,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('mac',$this->mac,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('workplace.wname',$this->idWorkplaceid_workplace,true);
        $criteria->compare('equipment.parent_id',$this->parentparent_id,true);
        $criteria->compare('equipment.parent_id',$this->equipmentsparent_id,true);

		if($this->type==18)
			$criteria->order='t.inv::INT DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>30),
		));
	}
}
