<?php

/**
 * This is the model class for table "users_session".
 *
 * The followings are the available columns in table 'users_session':
 * @property integer $id
 * @property integer $id_user
 * @property string $timestamp
 * @property string $ip
 *		 * The followings are the available model relations:


 * @property Users $idUser
 */
class UsersSession extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UsersSession the static model class
	 */
	public static $modelLabelS='Сессия Пользователя';
	public static $modelLabelP='Сессии Пользователей';
	
	public $idUserid_user;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_session';
	}

	public function lastLogin(){
		return 'последний вход: время:'.$this->timestamp.' IP: '.$this->ip;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user', 'required'),
			array('id, id_user', 'numerical', 'integerOnly'=>true),
			array('timestamp, ip', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_user, timestamp, ip,idUserid_user', 'safe', 'on'=>'search'),
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
			'idUser' => array(self::BELONGS_TO, 'Users', 'id_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_user' => 'Id Пользователя',
			'timestamp' => 'Дата\Время',
			'ip' => 'IP',
			'idUserid_user' => 'id_user',
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

		$criteria->with=array('idUser' => array('alias' => 'users'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('users.id_user',$this->idUserid_user,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
