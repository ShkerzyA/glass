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
	);

	public $idPersonnelid_personnel;
	public $idCabinetid_cabinet;
	public $equipmentsid_workplace;

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
		return 'workplace';
	}

	public function wpName(){
		if(!empty($this->id_personnel))
			return $this->idPersonnel->fio();
		else
			return $this->wname;
	}

	public function wpNameFull($short=false){
		if(!empty($this->id_personnel))
			$wname=$this->idPersonnel->fio();
		else
			$wname=$this->wname;

		if($short){
			$result=$this->idCabinet->idFloor->idBuilding->bname.'/'.$this->idCabinet->idFloor->fnum.' эт./'.$this->idCabinet->num;	
		}else{
			$result="Кабинет: ".$this->idCabinet->idFloor->idBuilding->bname."/".$this->idCabinet->idFloor->fname."/".$this->idCabinet->num." ".$this->idCabinet->cname."/".$wname;	
		}	
		return $result;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cabinet, id_personnel', 'numerical', 'integerOnly'=>true),
			array('wname', 'length', 'max'=>50),
			array('phone', 'length', 'max'=>100),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_cabinet, id_personnel, wname,idPersonnelid_personnel,idCabinetid_cabinet,equipmentsid_workplace,phone', 'safe', 'on'=>'search'),
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
            'equipments' => array(self::HAS_MANY, 'Equipment', 'id_workplace'),
		);
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
			'idPersonnelid_personnel' => 'Персонал',
			'idCabinetid_cabinet' => 'Кабинет',
            'equipmentsid_workplace' => 'Оборудование',
            'phone'=>'Телефон',
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
		$criteria->compare('personnel.id_personnel',$this->idPersonnelid_personnel,true);
		$criteria->compare('cabinet.cname',$this->idCabinetid_cabinet,true);
        $criteria->compare('equipment.ename',$this->equipmentsid_workplace,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}