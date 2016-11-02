<?php

/**
 * This is the model class for table "users_qq".
 *
 * The followings are the available columns in table 'users_qq':
 * @property integer $id
 * @property integer $login
 * @property integer $id_personnel
 *		 * The followings are the available model relations:


 * @property Personnel $idPersonnel
 */
class UsersQq extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UsersQq the static model class
	 */
	public static $modelLabelS='Пользователь Quickq';
	public static $modelLabelP='Пользователи Quickq';
	public static $postprefix=array('006ь'=>'4','006ъ'=>'8','00Ep'=>'8','00Ee'=>'7','00Eh'=>'7','0077'=>'7','009A'=>'7','0075'=>'7');
	public static $newuser='9';
	
	public $idPersonnelid_personnel;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_qq';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_personnel', 'numerical', 'integerOnly'=>true),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, login, id_personnel,idPersonnelid_personnel', 'safe', 'on'=>'search'),
		);
	}

	public function getRole(){
		foreach ($this->idPersonnel->personnelPostsHistories as $ph) {
			if(!empty(self::$postprefix[$ph->idPost->post_rn]))
				$res=self::$postprefix[$ph->idPost->post_rn];
		}
		$res=(!empty($res))?$res:self::$newuser;
		return $res;
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'login' => 'Login',
			'id_personnel' => 'Id Personnel',
			'idPersonnelid_personnel' => 'id_personnel',
		);
	}

	public function getLogin(){
		while (strlen($this->login)<3){
			$this->login='0'.$this->login;
		}
		return $this->login;
	}

	public function getPassword(){
		$str=mb_strtolower($this->idPersonnel->surname.$this->idPersonnel->name.$this->idPersonnel->patr.$this->idPersonnel->birthday,'binary').'scotland';
        $res=md5($str);
		return substr(preg_replace('/[^\d]/','',$res),0,3);
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

		$criteria->with=array('idPersonnel' => array('alias' => 'personnel'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('login',$this->login);
		$criteria->compare('id_personnel',$this->id_personnel);
		$criteria->compare('personnel.id_personnel',$this->idPersonnelid_personnel,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
