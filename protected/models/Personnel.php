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

	public static $modelLabelS='Кадры';
    public static $modelLabelP='Кадры';
    
    public $idUserid_user;
	public $workplacesid_personnel;
	public $personnelPostsHistoriesid_personnel;
    public $departments_name;

	 public function defaultScope()
    {
        return array(
            'order'=>'surname ASC',
        );
    }


	public function behaviors(){
		return array(
            // наше поведение для работы с файлом
			'Photo'=>array(
				'class'=>'application.behaviors.PhotoBehavior',
				),
			'DateBeginEnd'=>array(
				'class'=>'application.behaviors.DateBeginEndBehavior',
				),
			);
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className)->with('idUser');
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
			array('id_user,sex', 'numerical', 'integerOnly'=>true),
			array('surname, name, patr', 'length', 'max'=>50),
			array('photo', 'length', 'max'=>200),
            array('birthday, date_begin, date_end', 'safe'),
            array('orbase_rn', 'length', 'max'=>8),
            array('orbase_rn', 'unique',),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, surname, name, patr, photo, id_user, birthday, date_begin, orbase_rn, sex, date_end,idUserid_user,workplacesid_personnel,personnelPostsHistoriesid_personnel,departments_name', 'safe', 'on'=>'search'),
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
			//'users' => array(self::BELONGS_TO, 'Users', 'id_user'),
			//'PostsHistory' => array(self::HAS_MANY, 'PersonnelPostsHistory', 'id_personnel'),
			//'idWorkplace' => array(self::HAS_ONE, 'Workplace', 'id_personnel'),

			'idUser' => array(self::BELONGS_TO, 'Users', 'id_user'),
            'workplaces' => array(self::HAS_ONE, 'Workplace', 'id_personnel'),
            'personnelPostsHistories' => array(self::HAS_MANY, 'PersonnelPostsHistory', 'id_personnel'),
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
			'birthday' => 'Дата рождения',
            'date_begin' => 'Дата приема',
            'date_end' => 'Дата увольнения',
			'idUserid_user' => 'Пользователь',
            'departments_name' => 'Отдел',
            'workplacesid_personnel' => 'Рабочее место',
            'personnelPostsHistoriesid_personnel' => 'Занимаемые должности',
            'orbase_rn' => 'Код в парусе',
            'sex' => 'Пол',
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

        $criteria->order='photo ASC, surname ASC';

        $criteria->with=array('idUser' => array('alias' => 'users'),'workplaces' => array('alias' => 'workplace'),'personnelPostsHistories' => array('alias' => 'personnel_posts_history'),);
        $criteria->compare('id',$this->id);
        $criteria->compare('surname',$this->surname,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('patr',$this->patr,true);
        $criteria->compare('birthday',$this->birthday,true);
        $criteria->compare('date_begin',$this->date_begin,true);
        $criteria->compare('date_end',$this->date_end,true);
        $criteria->compare('photo',$this->photo,true);
        $criteria->compare('orbase_rn',$this->orbase_rn,true);
        $criteria->compare('sex',$this->sex);
        if(!empty($_GET['id_user']))
                $criteria->compare('id_user',$_GET['id_user']);
        else
                $criteria->compare('id_user',$this->id_user);
        $criteria->compare('users.username',$this->idUserid_user,true);
        $criteria->compare('workplace.id_personnel',$this->workplacesid_personnel,true);
        $criteria->compare('personnel_posts_history.id_personnel',$this->personnelPostsHistoriesid_personnel,true);
        


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
            	'pageSize'=>9
            ),
        ));
    }


        public function search_phones()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.


        $criteria=new CDbCriteria;

        $criteria->order='photo ASC, surname ASC';
        $pag=20;
        foreach ($this->attributes as $x) {
        	if(!empty($x)){
        		$pag=100;
        		break;
        	}
        }
        

        $criteria->with=array(
            'idUser' => array('alias' => 'users'),
            'workplaces' => array('alias' => 'workplace'),
            'personnelPostsHistories' => array('alias' => 'personnel_posts_history','condition'=>"\"personnel_posts_history\".date_end is NULL",'together'=>True),
            'personnelPostsHistories.idPost.postSubdivRn'=>array('alias'=>'departments'));
        //$criteria->condition=;
        $criteria->compare('id',$this->id);
        $criteria->compare('surname',$this->surname,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('patr',$this->patr,true);
        $criteria->compare('birthday',$this->birthday,true);
        $criteria->compare('date_begin',$this->date_begin,true);
        $criteria->compare('date_end',$this->date_end,true);
        $criteria->compare('photo',$this->photo,true);
        $criteria->compare('orbase_rn',$this->orbase_rn,true);
        $criteria->compare('sex',$this->sex);
        if(!empty($_GET['id_user']))
                $criteria->compare('id_user',$_GET['id_user']);
        else
                $criteria->compare('id_user',$this->id_user);
        $criteria->compare('users.username',$this->idUserid_user,true);
        $criteria->compare('workplace.id_personnel',$this->workplacesid_personnel,true);
        $criteria->compare('personnel_posts_history.id_personnel',$this->personnelPostsHistoriesid_personnel,true);
        $criteria->compare('departments.name',$this->departments_name,true);
        $criteria->order='departments.name ASC';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
            	'pageSize'=>$pag
            ),
        ));
    }
}