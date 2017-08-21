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
 * @property integer $parent_id
 * @property string $ip
 * @property string $mac
 * @property string $released
 * @property string $hostname
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
	public static $cartRepair='744';
	public static $db_array=array();
	public static $netEqType=array(0,2,3,4,5,6,8,9,11,12,13,16,17,25,26);
	public static $ignoreLog=array('ip','lastdate');
	public $place;
	public $DopLog;
	public $idWorkplaceid_workplace;
	public $related_eq;
	public $parentparent_id;
	public $equipmentsparent_id;
	public $department;
	private $old_model;
	public $countPrint;
	public $onlyneteq;

	public function rememberMe(){
		$this->old_model=clone $this;
	}

	public function onlyNetEq(){
        $alias=$this->getTableAlias();
        $this->getDbCriteria()->mergeWith(
            array('condition'=>'"'.$alias.'".type in ('.implode(',',self::$netEqType).')'));
        return $this;
    }

	public function setMaxCartInv(){
		if($this->type==18){
			if(empty(self::$maxCartInv)){
				self::$maxCartInv=self::model()->find(array('condition'=>'t.type=18','order'=>'substring(t.inv from \'^\\d+\')::int  DESC'))->inv;
			}
			self::$maxCartInv++;
			$this->inv=self::$maxCartInv;
		}	
	}

	public function cartInvOnly(){
		if($this->type==18 and (empty($this->inv))){
			$this->addError('Equipment["inv"]','Не заполнен инвентарный номер картриджа');
		}
	}

	public function nameL(){
		$producer=(isset($data->producer))?$this->producer0->name:'';
		return $this->serial.' '.$this->type0->name.'/ '.$producer.'/ '.$this->mark;
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

	public static function printerRefillCou(){

	$sql="select t.object, count(t.object) as cou,  eq.mark, eq.serial,
(bl.bname||'/'||fl.fname||'/'||cb.cname||' '||cb.num||'/'||wp.wname) as place
from equipment_log as t
left join equipment as eq on (eq.id=t.object)
left join workplace as wp on (eq.id_workplace=wp.id)
left join cabinet as cb on (wp.id_cabinet=cb.id)
left join floor as fl on (cb.id_floor=fl.id)
left join building as bl on (fl.id_building=bl.id)
where t.type=2 
group by t.object, eq.mark, eq.serial,wp.wname, cb.cname, cb.num, fl.fname, bl.bname
order by cou DESC";
		$req = Yii::app()->db->createCommand($sql);
		$res=$req->queryAll();
		return $res;
	}

	public static function countCart(){

	$sql="select eq.mark, count(eq.mark) as cou, 
	count(lim.mark) as licou,
	count(stor.mark) as st,
	count(refill.mark) as ref,
	count(repair.mark) as rep,
	CAST(((CAST(count(lim.mark) as real)/CAST(count(eq.mark) as real))*100) as int ) as prc,
	CAST(((CAST(count(stor.mark) as real)/CAST(count(eq.mark) as real))*100) as int ) as prc_st,
	CAST(((CAST(count(refill.mark) as real)/CAST(count(eq.mark) as real))*100) as int ) as prc_ref,
	CAST(((CAST(count(repair.mark) as real)/CAST(count(eq.mark) as real))*100) as int ) as prc_rep
	from equipment eq 
	left join equipment lim on(eq.id=lim.id and lim.id_workplace=".self::$cartFull.") 
	left join equipment stor on(eq.id=stor.id and stor.id_workplace=".self::$cartStorage.")
	left join equipment refill on(eq.id=refill.id and refill.id_workplace=".self::$cartRefill.")
	left join equipment repair on(eq.id=repair.id and repair.id_workplace=".self::$cartRepair.")
	where eq.type=18 and eq.status=0 group by eq.mark order by count(eq.mark) desc";
		$req = Yii::app()->db->createCommand($sql);
		$res=$req->queryAll();
		return $res;
	}

	public static function countReloadsCarts(){
		$sql="select mark, reloads, count(reloads) as carts from (select ct.mark, ct.inv, count(log.id) reloads from equipment ct left join equipment_log log on (log.type=3 and ct.inv::varchar=SOME(log.details)) where ct.type=18 and ct.status=0 group by mark, inv order by inv) as w group by mark, reloads order by mark, reloads desc";
		$req = Yii::app()->db->createCommand($sql);
		$res=$req->queryAll();
		return $res;
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
			return "\n IP ".$this->ip."\nMAC ".$this->mac."\nHOST: ".$this->hostname."\nв сети: ".$this->lastdate;
		}
	}

	public function additionalInfo(){
		switch ($this->type) {
			case '18':
			case '2':
			case '3':
			case '4':
					return 'Отпечатано: '.$this->countPrint;
				break;
			
			default:
					return '';
				break;
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
		if(isset($this->producer))
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
		if(!empty($this->id_workplace) and !empty($this->id)){
			$models=self::model()->findAll(array('condition'=>'t.id_workplace='.$this->id_workplace.' and t.id<>'.$this->id.' and t.type not in (18)'));
			foreach ($models as $m) {
				$result['values'][$m->id]=$m->full_name();
			}
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
			case 9:
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
		/*if(!empty($this->equipments))  //Убрал привязку картриджа к принтеру. Такие дела
			$cart_old=$this->equipments[0];

		if(empty($cart_old)) */
		$cart_old=Equipment::model()->with('EquipmentLog')->find(array('condition'=>"t.type=18 and t.id_workplace=$this->id_workplace and \"EquipmentLog\".details[2]='$this->id'",'order'=>'"EquipmentLog".timestamp DESC'));
		
		return $cart_old;
	}


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_workplace, type, producer, status, parent_id', 'numerical', 'integerOnly'=>true),
			array('id_workplace,type,status','required'),
			array('serial,inv,released,hostname,lastdate', 'length', 'max'=>100),
			array('inv','cartInvOnly'),
			array('lastdate','safe'), //'datetimeFormat'=>'yyyy-MM-dd HH:ii:ss'),
			array('mark', 'length', 'max'=>200),
			array('notes,ip,mac,released,onlyneteq', 'safe'),
			array('id','uniqueInvSerial'),
			array('id, id_workplace, serial, type, producer, mark, inv, released, ip, mac, status, parent_id, notes,idWorkplaceid_workplace,place,department,parentparent_id,equipmentsparent_id,onlyneteq', 'safe', 'on'=>'search'),
		);
	}


	protected function beforeSave(){
		if(empty($this->released))
			$this->released=NULL;
		if (empty($this->ip))
			$this->ip=NULL;
		if (empty($this->mac))
			$this->mac=NULL;
		return parent::beforeSave();
	}

	protected function afterSave(){
		if (empty($this->old_model))
			return false;
		$chanded=array();
		foreach ($this->attributes as $k => $v) {
			if(in_array($k,Equipment::$ignoreLog))
				continue;
			//echo $v.'/'.$this->old_model->$k.'<br>';
			if($v!=$this->old_model->$k){
				switch ($k) {
					case 'id_workplace':
						$log=new EquipmentLog;
						$log->saveLog('moveEq',array('details'=>array($this->old_model->id_workplace,$this->id_workplace),'object'=>$this->id));
						/*if(!empty($this->equipments)) //Если приспичит вернуть - Переписать. Детеныш делает rememberMe, потом меняет workplace и сохраняется. Если рабочее место меняется - лог автоматически запишется
						foreach ($this->equipments as $eqId) {
							if($eqId->id_workplace==$this->old_model->id_workplace){
								$eqId->id_workplace=$this->id_workplace;
								$eqId->save();
								$log=new EquipmentLog;
								$log->saveLog('moveEq',array('details'=>array($this->old_model->id_workplace,$eqId->id_workplace),'object'=>$eqId->id));	
							}
						}*/
						break;
					default:
					$chanded[]=$this->getAttributeLabel($k).": ".$this->old_model->$k."/".$v."\n";
						break;
				}
			}
		}
		if(!empty($chanded)){
			$log=new EquipmentLog;
			$log->saveLog('chEq',array('details'=>$chanded,'object'=>$this->id));
		}
	}

	public function afterFind(){
		if(!empty($this->released)){
            $date = date('d.m.Y', strtotime($this->released));
            $this->released = $date;
        }

        
        if(in_array($this->type,array(2,3,4))){
        	$this->countPrint=(!empty($this->LogCountPrint))?$this->LogCountPrint[0]->details[0]:'n/a';
        }

       	if($this->type==18){
        	foreach ($this->EquipmentLog as $v) {
        		if($v->type==10 and is_numeric($v->details[0]))
        			$this->countPrint+=$v->details[0];
        	}
        }

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
    	}else if(!empty($this->inv) and $this->type==18){
    		$Ph=self::findAll(array('condition'=>'t.inv=\''.$this->inv.'\' '.$idCheck));
    		foreach ($Ph as $v){
        		$this->addError('inv','Оборудование с данным инвентарным номером зарегистрировано ID:'.$v->id.')');
        	}
    	}
   
    }

	public function inv(){
		if($this->type==18){
			return ' инв.'.$this->inv;
		}
	}

	public function full_name(){
		$prod=(!empty($this->producer))?$this->producer0->name:'';
		$notes=($this->type==0)?$this->notes:'';

		return $this->type0->name.' '.$prod.' '.$this->mark.' <b>'.$this->serial.'</b> '.$this->hostname.$notes.' '.$this->inv();
	}


	public function logInfo(){
		$result='';
		switch ($this->type) {
			case '18':
				$common=array('load_last'=>0,'load'=>0,'repare'=>0);
				$criteria=new CDbCriteria;
        		$criteria->addCondition(array('condition'=>'type in (3,4) and \''.$this->inv.'\'=ANY("details")'));
        		$criteria->order='t.timestamp DESC, t.type ASC';
				$logs=EquipmentLog::model()->findAll($criteria);
				foreach ($logs as $l) {
					if($l->type==3){
						$common['load']+=1;
						$common['load_last']+=1;
					}
					if($l->type==9){
						$common['repare']+=1;
						$common['load_last']=0;
					}
				}
				$result='Запр.(ВСЕ): '.$common['load'].'<br> Восст.: '.$common['repare'].'<br> Запр.(ПВ): '.$common['load_last'];
				break;
			
			default:
				# code...
				break;
		}
		return $result;
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
			'EquipmentLog' => array(self::HAS_MANY, 'EquipmentLog', 'object','order'=>'"EquipmentLog".id DESC'),
			//'printRefCount'=> array(self::STAT,'EquipmentLog','object','condition'=>'t.type=2','order'=>'s DESC'), // hard to order by cou in Eq result, use pure sql
			
			//'EquipmentLog' => array(self::HAS_MANY, 'EquipmentLog', '','with'=>'objectEq','on'=>'("EquipmentLog".type in (3,4) and '.$this->id.'=ANY("EquipmentLog"."details")) or "EquipmentLog"."object"='.$this->id),
			'parentEq' => array(self::BELONGS_TO, 'Equipment', 'parent_id'),
            'equipments' => array(self::HAS_MANY, 'Equipment', 'parent_id'),
            'dhcp' => array(self::HAS_MANY, 'DhcpLeases', '','on'=>'"dhcp".mac=t.mac','order'=>'"dhcp".date_end DESC'),
            'LogCountPrint' => array(self::HAS_MANY, 'EquipmentLog','object','on'=>'"LogCountPrint".type=2 and \'n/a\'<>"LogCountPrint".details[1]','select'=>'details','order'=>'"LogCountPrint".id DESC','limit'=>'1'),
            'eqActsoftransfers' => array(self::HAS_MANY, 'EqActsoftransfer', 'id_eq'),
            'actsoftransfers'=>array(self::HAS_MANY,'ActOfTransfer','id_act','through'=>'eqActsoftransfers'),
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
			'department' => 'Отдел',
			'parent_id' => 'Привязка',
			'released' => 'Дата выпуска',
			'ip' => 'IP',
			'mac' => 'MAC',
			'idWorkplaceid_workplace' => 'Рабочее место',
            'parentparent_id' => 'Принадлежность',
            'equipmentsparent_id' => 'Зависимое оборудование',
            'hostname' => 'Имя хоста',
            'lastdate' => 'Последняя аренда',
            'onlyneteq' => 'Только сетевое',
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
		$criteria->with=array('type0','producer0','idWorkplace.idPersonnel.personnelPostsHistories','idWorkplace.idCabinet.idFloor.idBuilding','idWorkplace.wpSubdivRn'); // 
		$criteria->order=('"idBuilding".bname ASC, "idFloor".fnum ASC, "idCabinet".num ASC');
		//$criteria->compare('personnel.creator',$this->creator0creator,true);
		return self::model()->findAll($criteria);
	}

	public function suggestTag($keyword){
		$keyword=mb_strtolower($keyword,'UTF-8');
 		$tags=$this->with('type0','producer0','idWorkplace.idPersonnel','idWorkplace.idCabinet.idFloor.idBuilding')->findAll(array(
   			'condition'=>'(LOWER("idPersonnel".surname) LIKE :keyword OR LOWER("idBuilding".bname) LIKE :keyword OR LOWER("idCabinet".num) LIKE :keyword OR LOWER("idCabinet".cname) LIKE :keyword) and t.status=0 and (t.type in (3,2,4,17))',
   			'params'=>array(
     		':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',

   		)
   		,'order'=>'"idBuilding".bname asc, "idFloor".fnum asc, "idCabinet".num||"idCabinet".cname asc, "idWorkplace".wname asc'
 		));
 		return $tags;
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('idWorkplace' => array('alias' => 'workplace'),'idWorkplace.idCabinet.idFloor.idBuilding','idWorkplace.wpSubdivRn'=>array('alias'=>'department'));
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
		$criteria->compare('t.producer',$this->producer);
		$criteria->compare('mark',$this->mark,true);
		$criteria->compare('inv',$this->inv,true);
		$criteria->compare('status',$this->status);
		
		if($this->ip=='*'){
			$criteria->addCondition("t.ip is NULL");
		}else{
			$criteria->compare('ip',$this->ip,true);
		}		

		if($this->mac=='*'){
			$criteria->addCondition("t.mac is NULL");
		}else{
			$criteria->compare('mac',$this->mac);
		}

		if($this->hostname=='*'){
			$criteria->addCondition("t.hostname is NULL");
		}else{
			$criteria->compare('hostname',$this->hostname,true);
		}

		if($this->notes=='*'){
			$criteria->addCondition("t.notes=''");
		}else{
			$criteria->compare('notes',$this->notes,true);
		}
		$criteria->compare('released',$this->released,true);
		$criteria->compare('department.subdiv_rn',$this->department,true);
		$criteria->compare('workplace.wname',$this->idWorkplaceid_workplace,true);
        $criteria->compare('equipment.parent_id',$this->parentparent_id,true);
        $criteria->compare('equipment.parent_id',$this->equipmentsparent_id,true);

        if(!empty($this->lastdate)){
        	switch ($this->lastdate[0]) {
        		case '<':
        			$criteria->addCondition("t.lastdate::DATE<'".substr($this->lastdate,1)."'");
        			break;

        		case '>':
        			$criteria->addCondition("t.lastdate::DATE>'".substr($this->lastdate,1)."'");
        			break;
        	
        		default:
        			$criteria->addCondition("t.lastdate::DATE='".$this->lastdate."'");
        			break;
        	}
        }

        if($this->onlyneteq){
			$criteria->scopes[]='onlyNetEq';
		}

		if($this->type==18)
			$criteria->order='t.inv::INT DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>50),
		));
	}
}
