<?php

/**
 * This is the model class for table "workplace".
 *
 * The followings are the available columns in table 'workplace':
 * @property integer $id
 * @property integer $id_cabinet
 * @property integer $id_personnel
 * @property string $wname
 *		 * The followings are the available model relations:


 * @property Personnel $idPersonnel


 * @property Cabinet $idCabinet
 */
class Workplace extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Workplace the static model class
	 */
	public static $modelLabelS='Рабочее место';
	public static $modelLabelP='Рабочие места';
	

	public static $tree=array(
		'parent_id'=>'id_cabinet',
		'query'=>"SELECT m1.id, array_to_string(array[m1.wname,'(',m2.surname,m2.name,m2.patr,')'],' ') AS text, m1.id as parent_id, count(m2.id) AS \"hasChildren\" FROM workplace AS m1 LEFT JOIN personnel AS m2 ON m1.id_personnel=m2.id",
		'group'=>'GROUP BY m1.id, m2.surname, m2.name, m2.patr ORDER BY m1.wname ASC',
		'child'=>'Personnel',
		'where'=>'AND (m1.deactive is null or m1.deactive<>1)',
	);

	public $idPersonnelid_personnel;
	public $idCabinetid_cabinet;
	public $equipmentsid_workplace;
	public $wpSubdivRnwp_subdiv_rn;

	public function behaviors(){
		return array(
			'PreFill'=>array(
				'class'=>'application.behaviors.PreFillBehavior',
				),
			'Log'=>array(
                'class'=>'application.behaviors.LogBehavior',
                ),

			);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function autoSetDepartment(){
		echo 'не актуально';
		return false;
		//был разовый запуск, предположительно больше не понадобится и можно будет удалить функцию и действие в контроллере
		$models=Workplace::model()->findAll(array('condition'=>"t.wp_subdiv_rn is NULL"));
		foreach ($models as $v) {
			if(empty($v->idPersonnel) or empty($v->idPersonnel->personnelPostsHistories) or empty($v->idPersonnel->personnelPostsHistories[0]))
				continue;
			$v->wp_subdiv_rn=$v->idPersonnel->personnelPostsHistories[0]->idPost->postSubdivRn->subdiv_rn;
			if($v->save())
				echo $v->wpNameFull().'</br>';
		}
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'workplace';
	}

	public static function storageCabs(){
		$res=array();
		$models=Workplace::model()->with('idCabinet')->findAll(array('condition'=>'t.type=1'));
		foreach ($models as $v) {
			$res[$v->idCabinet->id]=array('label'=>$v->idCabinet->cabNameFull(),'url'=>$v->idCabinet->id);
		}
		return $res;
	}

	public function eqCount(){
		$query = Yii::app()->db->createCommand('select  count(eq.mark) num, eq.mark, eq_p.name producer, eq_t.name "type"  from workplace wp 
														left join equipment eq on (eq.id_workplace=wp.id) 
														left join equipment_producer eq_p on (eq.producer=eq_p.id) 
														left join equipment_type eq_t on (eq.type=eq_t.id) 
														where wp.id = '.$this->id.' group by eq.mark,eq_p.name, eq_t.name');

        return $query->queryAll();
	}

	public function phones(){
		$res=array();
		$res[]=$this->phone;
		if(!empty($this->idCabinet))
			$res[]=$this->idCabinet->phone;
		$res=array_filter($res);
		return implode(',',$res);
	}

	public function myEqStr($type=array()){
		$result=array();
		foreach ($this->equipments as $eq) {
			if(in_array($eq->type,$type))
				$result[]=$eq->mark;
		}

		return implode(', ',$result);

	}

	public function getBuildingName(){
		return $this->idCabinet->idFloor->idBuilding->bname;
	}

	public function wpName($withEq=false,$fio='fio'){
		$eqStr=($withEq)?'('.$this->myEqStr(array(2,3,4)).')':'';

		$res='';
		if(!empty($this->id_personnel))
			$res=$this->idPersonnel->wrapFio($fio);
		else
			$res=$this->wname;

		return $res.' '.$eqStr;

	}

	public function wpNameFull($short=false,$withEq=false,$fio='fio'){
	if(!empty($this->idCabinet)){
		if($short){
			$result=$this->idCabinet->cabNameFull($short);	
		}else{
			$result=$this->idCabinet->cabNameFull($short)."/ ".$this->wpName($withEq,$fio);;	
		}	
		return $result;}
	else{
		return '';
	}
	
	}

	public function nameL(){
        return $this->wpNameFull();
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cabinet, id_personnel, deactive, type', 'numerical', 'integerOnly'=>true),
			array('id_cabinet','required'),
			array('wname', 'length', 'max'=>50),
			array('phone', 'length', 'max'=>100),
			array('wp_subdiv_rn', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_cabinet,type, id_personnel, deactive, wname,idPersonnelid_personnel,idCabinetid_cabinet,equipmentsid_workplace,phone,wp_subdiv_rn', 'safe', 'on'=>'search'),
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
			'idPersonnel' => array(self::BELONGS_TO, 'Personnel', 'id_personnel'),
			'idCabinet' => array(self::BELONGS_TO, 'Cabinet', 'id_cabinet'),
            'equipments' => array(self::HAS_MANY, 'Equipment', 'id_workplace','order'=>'"equipments".mark ASC, "equipments".inv ASC'),
            'wpSubdivRn' => array(self::BELONGS_TO, 'Department', 'wp_subdiv_rn'),
		);
	}

	public function department(){
		if(!empty($this->wp_subdiv_rn))
			return $this->wpSubdivRn->name;
		else
			return '-//-';
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_cabinet' => 'Кабинет',
			'id_personnel' => 'Персонал',
			'wname' => 'Рабочее место',
			'idPersonnelid_personnel' => 'Рабочее место',
			'idCabinetid_cabinet' => 'Кабинет',
            'equipmentsid_workplace' => 'Оборудование',
            'phone'=>'Телефон',
            'type'=>'Тип рабочего места',
            'wp_subdiv_rn'=>'Отдел',
            'wpSubdivRnwp_subdiv_rn'=>'Отдел',
            'deactive'=>'Деактивация',
		);
	}

	protected function beforeSave(){
		if(empty($this->wp_subdiv_rn))
			$this->wp_subdiv_rn=NULL;
		if(!empty($this->id_personnel and !empty($this->idPersonnel) and !empty($this->idPersonnel->personnelPostsHistories) and !empty($this->idPersonnel->personnelPostsHistories[0])))
			$this->wp_subdiv_rn=$this->idPersonnel->personnelPostsHistories[0]->idPost->postSubdivRn->subdiv_rn;
		return parent::beforeSave();
	}

	public function suggestTag($keyword){
		$keyword=mb_strtolower($keyword,'UTF-8');
 		$tags=$this->with('idPersonnel','idCabinet.idFloor.idBuilding')->findAll(array(
   			'condition'=>'(LOWER("idPersonnel".surname) LIKE :keyword OR LOWER("idBuilding".bname) LIKE :keyword OR LOWER("idCabinet".num) LIKE :keyword OR LOWER("idCabinet".cname) LIKE :keyword OR LOWER(t.wname) LIKE :keyword) AND (t.deactive is null or t.deactive<>1)',
   			'params'=>array(
     		':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',

   		)
   		,'order'=>'"idBuilding".bname asc, "idFloor".fnum asc, "idCabinet".num||"idCabinet".cname asc, t.wname asc'
 		));
 		return $tags;
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

		$criteria->with=array('idPersonnel' => array('alias' => 'personnel'),'idCabinet' => array('alias' => 'cabinet'),);
		$criteria->compare('t.id',$this->id);
		if(!empty($_GET['id_cabinet']))
				$criteria->compare('id_cabinet',$_GET['id_cabinet']);
		else
				$criteria->compare('id_cabinet',$this->id_cabinet);
		if(!empty($_GET['id_personnel']))
				$criteria->compare('id_personnel',$_GET['id_personnel']);
		else
				$criteria->compare('id_personnel',$this->id_personnel);
		$criteria->compare('wname',$this->wname,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('deactive',$this->deactive);
		$criteria->compare('wp_subdiv_rn',$this->wp_subdiv_rn,true);
		$criteria->compare('personnel.id_personnel',$this->idPersonnelid_personnel,true);
		$criteria->compare('cabinet.cname',$this->idCabinetid_cabinet,true);
        $criteria->compare('equipment.ename',$this->equipmentsid_workplace,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
