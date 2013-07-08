<?php

/**
 * This is the model class for table "personnel".
 *
 * The followings are the available columns in table 'personnel':
 * @property integer $id
 * @property string $surname
 * @property string $name
 * @property string $patr
 * @property string $photo
 * @property integer $id_user
 * @property integer $id_post
 * @property integer $id_cabinet
 *
 * The followings are the available model relations:
 * @property Department[] $departments
 * @property Users $idUser
 * @property PersonnelPosts $idPost
 * @property Cabinet $idCabinet
 */
class Personnel extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Personnel the static model class
	 */

	public $username;


	public function behaviors(){
		return array(
            // наше поведение для работы с файлом
			'Photo'=>array(
				'class'=>'application.behaviors.PhotoBehavior',
				),
			);
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className)->with('users');
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'personnel';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user,id_cabinet', 'numerical', 'integerOnly'=>true),
			array('surname, name, patr', 'length', 'max'=>50),
			array('photo', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, surname, name, patr, photo, id_user, id_cabinet, username',  'safe', 'on'=>'search'),
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
			'users' => array(self::BELONGS_TO, 'Users', 'id_user'),
			'PostsHistory' => array(self::HAS_MANY, 'PersonnelPostsHistory', 'id_personnel'),
			'idWorkplace' => array(self::HAS_ONE, 'Workplace', 'id_personnel'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'surname' => 'Фамилия',
			'name' => 'Имя',
			'patr' => 'Отчество',
			'photo' => 'Фото',
			'username' => 'Логин',
			'id_user' => 'Пользователь',
			'id_cabinet' => 'Кабинет',
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

		$usser=Users::model()->findByPk($this->id_user);

		print_r($usser);
		//$this->username=$usser->username;

		$criteria=new CDbCriteria;


		$criteria->with = array('users');

		$criteria->compare('id',$this->id);
		$criteria->compare('surname',$this->surname,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('patr',$this->patr,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('username',$this->username,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
        		'pageSize'=>9,
    		),
		));
	}
}