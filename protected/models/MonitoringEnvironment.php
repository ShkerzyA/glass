<?php

/**
 * This is the model class for table "monitoring_environment".
 *
 * The followings are the available columns in table 'monitoring_environment':
 * @property integer $id
 * @property integer $qms1
 * @property integer $qms2
 * @property integer $intet
 * @property integer $dns
 * @property integer $mos_gate
 * @property integer $mos_intro
 */
class MonitoringEnvironment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MonitoringEnvironment the static model class
	 */
	public static $modelLabelS='MonitoringEnvironment';
	public static $modelLabelP='MonitoringEnvironment';
	
	

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'monitoring_environment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('qms1, qms2, intet, dns, mos_gate, mos_intro', 'numerical', 'integerOnly'=>true),
			array('fog_space', 'length', 'max'=>200),
			array('hosts_up', 'length', 'max'=>255),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('qms1, intet, dns, mos_gate, mos_intro, fog_space, hosts_up', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'qms1' => 'QMS 10.61.103.49',
			'qms2' => 'QMS 172.16.46.4',
			'intet' => 'Интернет',
			'dns' => 'DNS сервер',
			'mos_gate' => 'Шлюз Московской',
			'mos_intro' => 'Внутренняя сеть московской',
			'fog_space' => 'Свободное место на fog',
			'hosts_up' => 'Под присмотром',
		);
	}

	public function monArray(){
		$cols=$this->attributes;
		$result=array();
		unset($cols['id']);
		unset($cols['mos_gate']);
		unset($cols['qms2']);
		foreach ($cols as $key => $value) {
			switch ($key) {
				case 'fog_space':
					$val=($value>100)?1:0;
					$result[]=array('label'=>'Свободно на ОБМЕННИКЕ '.$value.'мб','value'=>$val);
					break;

				case 'hosts_up':
					$ud=array('down','up');
					$val=1;
					$hosts=explode('|',$value);
					$lb=array();
					foreach ($hosts as $v) {
						$v=explode(',',$v);
						if(!empty($v)){
							if($v[1]==0)
								$val=0;
							$lb[]=$v[0].'-'.$ud[$v[1]];
						}
					}
					$result[]=array('label'=>$this->attributeLabels()[$key].': '.implode(',',$lb),'value'=>$val);
					break;

				default:
					$result[]=array('label'=>$this->attributeLabels()[$key],'value'=>$value);
					break;
			}

				
		}
		return $result;
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

		$criteria->compare('qms1',$this->qms1);
		$criteria->compare('qms2',$this->qms2);
		$criteria->compare('intet',$this->intet);
		$criteria->compare('dns',$this->dns);
		$criteria->compare('mos_gate',$this->mos_gate);
		$criteria->compare('mos_intro',$this->mos_intro);
		$criteria->compare('hosts_up',$this->hosts_up);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
