<?php

/**
 * This is the model class for table "dhcp_leases".
 *
 * The followings are the available columns in table 'dhcp_leases':
 * @property string $ip
 * @property boolean $act
 * @property string $date_end
 * @property string $mac
 * @property string $hostname
 */
class DhcpLeases extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DhcpLeases the static model class
	 */
	public static $modelLabelS='DhcpLeases';
	public static $modelLabelP='DhcpLeases';
	
	

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dhcp_leases';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hostname', 'length', 'max'=>40),
			array('ip, act, date_end, mac', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ip, act, date_end, mac, hostname', 'safe', 'on'=>'search'),
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
			'ip' => 'Ip',
			'act' => 'Act',
			'date_end' => 'Date End',
			'mac' => 'Mac',
			'hostname' => 'Hostname',
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

		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('act',$this->act);
		$criteria->compare('date_end',$this->date_end,true);
		$criteria->compare('mac',$this->mac,true);
		$criteria->compare('hostname',$this->hostname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
