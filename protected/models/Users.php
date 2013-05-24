<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $id_post
 *
 * The followings are the available model relations:
 * @property UsersRules[] $usersRules
 * @property Personnel[] $personnels
 * @property UsersPosts $idPost
 */
class Users extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */


	public function behaviors(){
		return array(
            // наше поведение для работы с файлом
			'GlassLogin'=>array(
				'class'=>'application.behaviors.GlassLoginBehavior',
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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_post', 'numerical', 'integerOnly'=>true),
			array('username, password', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, id_post', 'safe', 'on'=>'search'),
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
			'usersRules' => array(self::HAS_MANY, 'UsersRules', 'id_user'),
			'personnels' => array(self::HAS_ONE, 'Personnel', 'id_user'),
			'idPost' => array(self::BELONGS_TO, 'UsersPosts', 'id_post'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'id_post' => 'Id Post',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('id_post',$this->id_post);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}