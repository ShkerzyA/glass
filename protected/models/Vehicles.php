<?php

/**
 * This is the model class for table "vehicles".
 *
 * The followings are the available columns in table 'vehicles':
 * @property integer $id
 * @property integer $owner
 * @property string $mark
 * @property string $number
 * @property integer $deactive
 * @property integer $status
 *		 * The followings are the available model relations:


 * @property Personnel $owner0
 */
class Vehicles extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Vehicles the static model class
	 */
	public static $modelLabelS='Транспорт';
	public static $modelLabelP='Транспорт';
	public static $db_array=array('shedule');
	public static $status=array('1'=>'Вне территории','2'=>'На территории');
	public $shedule0=array();
	
	public $owner0owner;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vehicles';
	}

	public function getStatus(){
		if(!empty($this->status))
			return self::$status[$this->status];
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('owner, deactive, status', 'numerical', 'integerOnly'=>true),
			array('owner,mark,number','required'),
			array('mark', 'length', 'max'=>200),
			array('number', 'length', 'max'=>10),
			array('number','unique'),
			array('number', 'match', 'pattern'=>'/[A-Za-zА-Яа-я]\d{3}[A-Za-zА-Яа-я]{2}\d{2,3}/u'),
			array('shedule', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, owner, mark, number, deactive,shedule, status,owner0owner', 'safe', 'on'=>'search'),
		);
	}

	public function behaviors(){
	return array(
			'PreFill'=>array(
				'class'=>'application.behaviors.PreFillBehavior',
				),
			'DbArray'=>array(
                'class'=>'application.behaviors.DbArrayBehavior',
                ),
            'Log'=>array(
                'class'=>'application.behaviors.LogBehavior',
                ));
	}




	/**
	 * @return array relational rules.
	 */
	public function joinShedule(){
		if(!empty($this->shedule))
		foreach ($this->shedule as $v) {
			$this->shedule0[]=VehicleShedule::model()->findByPk($v);
		}
	}

	public function StrShedule(){
		$res=array();
		foreach ($this->shedule0 as $v) {
			$res[]=$v->name();
		}
		return implode('<br>',$res);	
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'owner0' => array(self::BELONGS_TO, 'Personnel', 'owner'),
		);
	}

	public function nameL(){
        return $this->mark.' '.$this->number;
    }

    protected function beforeSave(){
        //$this->prepareSave();
        return parent::beforeSave();
    }

    protected function afterFind(){
    	parent::afterFind();
    	$this->joinShedule();
    }

	public function beforeValidate(){
		$this->Ru2Lat();
		return parent::beforeValidate();
	}

	public function Ru2Lat(){
        $string=mb_strtoupper($this->number,'UTF-8');

        $rus1=array("А","В","Е","К","М","Н","О","Р","С","Т","У","Х");
        $lat1=array("A","B","E","K","M","H","O","P","C","T","Y","X");
        $string = str_replace($rus1,$lat1,$string);
        $this->number=$string;
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'owner' => 'Владелец',
			'mark' => 'Марка',
			'number' => 'Номер',
			'deactive' => 'Запрет',
			'status' => 'Статус',
			'shedule' => 'Расписание въезда',
			'owner0owner' => 'Владелец',
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

		$criteria->with=array('owner0' => array('alias' => 'personnel'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('owner',$this->owner);
		$criteria->compare('mark',$this->mark,true);
		$criteria->compare('number',$this->number,true);
		$criteria->compare('deactive',$this->deactive);
		$criteria->compare('status',$this->status);
		$criteria->compare('shedule',$this->shedule,true);
		$criteria->compare('personnel.owner',$this->owner0owner,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
