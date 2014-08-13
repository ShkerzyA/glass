<?php

/**
 * This is the model class for table "medical_equipment".
 *
 * The followings are the available columns in table 'medical_equipment':
 * @property string $date
 * @property string $cnum
 * @property string $name
 * @property string $date_exp
 * @property integer $number_research
 * @property string $name_research
 * @property string $fio_pac
 * @property string $diag
 * @property string $birthday
 * @property string $fio_sender
 * @property string $conclusion
 * @property integer $number_downtime
 * @property string $eed
 * @property string $reason_downtime
 * @property string $measures_taken
 * @property integer $id
 */
class MedicalEquipment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MedicalEquipment the static model class
	 */
	public static $modelLabelS='Мед. оборудование';
	public static $modelLabelP='Мед. оборудование';
	public $date_end;
	public $creator0creator;
	

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
			'FixedOwner'=>array(
				'class'=>'application.behaviors.FixedOwnerBehavior',
				),
			);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'medical_equipment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('number_research, number_downtime, creator', 'numerical', 'integerOnly'=>true),
			array('date, date_end, cnum, name, date_exp, name_research, fio_pac, diag, birthday, fio_sender, conclusion, eed, reason_downtime, measures_taken', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('date, cnum, name, date_exp, number_research, name_research, fio_pac, diag, birthday, fio_sender, conclusion, number_downtime, eed, reason_downtime, measures_taken, id, creator', 'safe', 'on'=>'search'),
		);
	}

	public function creators(){
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'date' => 'Дата обследования',
			'cnum' => '№ кабинета',
			'name' => 'Наименование оборудования',
			'date_exp' => 'Дата ввода в эксплуатацию',
			'number_research' => 'Количество выполненных исследований',
			'name_research' => 'Наименование исследования',
			'fio_pac' => 'Ф.И.О. пациента',
			'diag' => 'Диагноз при направлении',
			'birthday' => 'Дата рождения пациента',
			'fio_sender' => 'Ф.И.О. направившего подразделения',
			'conclusion' => 'Заключение врача',
			'eed' => 'Э.Э.Д.',			
			'number_downtime' => 'Количество дней простоя',
			'reason_downtime' => 'Причина простоя',
			'measures_taken' => 'Принятые меры',
			'creator' => 'Создатель записи',
			'id' => 'ID',
			'creator0creator' => 'creator',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function listCreators(){
		$criteria=new CDbCriteria;
        $criteria->with=array(
        //    'creator0' => array('alias' => 'creator'),
        );

		
		$criteria->distinct = True;
		$criteria->select='creator';
		$creators=self::model()->findAll($criteria);

		$result=array();

		foreach ($creators as $v) {
			$result[$v->creator]=$v->creator0->personnelPostsHistories[0]->idPost->postSubdivRn->name.'('.$v->creator0->surname.' '.$v->creator0->name.')';
		}
		return $result;

	}

	public function search_for_export(){
		$criteria=new CDbCriteria;

		if(!empty($this->date)){
			if(!empty($this->date_end)){
				$criteria->condition='t.date>=\'%'.$this->date.'%\' and t.date<=\'%'.$this->date_end.'%\'';
			}else{
				$criteria->condition='t.date=\'%'.$this->date.'%\' ';
			}
		}
		if(!empty($_GET['creator']))
				$criteria->compare('creator',$_GET['creator']);
		else
				$criteria->compare('creator',$this->creator);
		$criteria->compare('personnel.creator',$this->creator0creator,true);

		return self::model()->findAll($criteria);
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->date)){
			if(!empty($this->date_end)){
				$criteria->condition='t.date>=\'%'.$this->date.'%\' and t.date<=\'%'.$this->date_end.'%\'';
			}else{
				$criteria->condition='t.date=\'%'.$this->date.'%\' ';
			}
		}
	
		//$criteria->compare('date',$this->date);
		$criteria->compare('cnum',$this->cnum,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('date_exp',$this->date_exp);
		$criteria->compare('number_research',$this->number_research);
		$criteria->compare('name_research',$this->name_research,true);
		$criteria->compare('fio_pac',$this->fio_pac,true);
		$criteria->compare('diag',$this->diag,true);
		$criteria->compare('birthday',$this->birthday);
		$criteria->compare('fio_sender',$this->fio_sender,true);
		$criteria->compare('conclusion',$this->conclusion,true);
		$criteria->compare('number_downtime',$this->number_downtime);
		$criteria->compare('eed',$this->eed,true);
		$criteria->compare('reason_downtime',$this->reason_downtime,true);
		$criteria->compare('measures_taken',$this->measures_taken,true);
		$criteria->compare('id',$this->id);
		if(!empty($_GET['creator']))
				$criteria->compare('creator',$_GET['creator']);
		else
				$criteria->compare('creator',$this->creator);
		$criteria->compare('personnel.creator',$this->creator0creator,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
}
