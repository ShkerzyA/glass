<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $id_post
 *		 * The followings are the available model relations:


 * @property UsersRules[] $usersRules


 * @property UsersPosts $idPost


 * @property Personnel[] $personnels
  * @property string $startpage
 * @property string $bg
 * @property string $horn
 * @property integer $tasksound
 * @property integer $chatsound
 */
class Users extends CActiveRecord
{
	const ROLE_ADMIN = 'administrator';
    const ROLE_MODER = 'moderator';
    const ROLE_USER = 'user';
    const ROLE_BANNED = 'banned';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static $modelLabelS='Пользователь';
	public static $modelLabelP='Пользователи';
	
	public $usersRulesid_user;
public $idPostid_post;
public $personnelsid_user;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
            // наше поведение для работы с файлом
			'GlassLogin'=>array(
				'class'=>'application.behaviors.GlassLoginBehavior',
				),
			);
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
			array('id_post, tasksound, chatsound', 'numerical', 'integerOnly'=>true),
			array('username, password', 'length', 'max'=>50),
			array('startpage, bg', 'length', 'max'=>250),
			array('horn', 'length', 'max'=>100),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, startpage, bg, id_post,usersRulesid_user,idPostid_post,personnelsid_user', 'safe', 'on'=>'search'),
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
			'idPost' => array(self::BELONGS_TO, 'UsersPosts', 'id_post'),
			'personnels' => array(self::HAS_ONE, 'Personnel', 'id_user'),
		);
	}

	public function post(){
		if(!empty($this->idPost))
			return $this->idPost->post;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Логин',
			'password' => 'Пароль',
			'startpage' => 'Стартовая страница',
			'bg' => 'Фон',
			'id_post' => 'Роль',
			'usersRulesid_user' => 'Правила',
			'idPostid_post' => 'Роль',
			'personnelsid_user' => 'Сотрудник',
			'horn' => 'Вариант звучания',
			'tasksound' => 'Звук задачи',
			'chatsound' => 'Звук чата',
		);
	}

	public static function SoundList(){
		$res=array();
		$src=Yii::getPathOfAlias('webroot').'/media/horn/';
        if ($handle = opendir($src)) {
            while (false !== ($file = readdir($handle))) {
            	if($file!='.' && $file!='..')
            		$res[$file]=$file; 
            }
        }
        return $res;
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

		$criteria->with=array('usersRules' => array('alias' => 'usersrules'),'idPost' => array('alias' => 'usersposts'),'personnels' => array('alias' => 'personnel'),);
		$criteria->compare('t.id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		if(!empty($_GET['id_post']))
				$criteria->compare('id_post',$_GET['id_post']);
		else
				$criteria->compare('id_post',$this->id_post);
		$criteria->compare('usersrules.id_user',$this->usersRulesid_user,true);
		$criteria->compare('usersposts.id_post',$this->idPostid_post,true);
		$criteria->compare('personnel.id_user',$this->personnelsid_user,true);
		$criteria->compare('horn',$this->horn,true);
		$criteria->compare('tasksound',$this->tasksound);
		$criteria->compare('chatsound',$this->chatsound);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
