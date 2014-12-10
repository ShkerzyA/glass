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
    public $allfields;
    public $actions=array();

	 public function defaultScope()
    {
        return array(
            //'order'=>'surname ASC',
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


    public function getPhoto(){
        if (!empty($this->photo)){
                            echo (Yii::app()->request->baseUrl.'/media'.DIRECTORY_SEPARATOR.CHtml::encode($this->photo)); 
                        }else{
                            echo (Yii::app()->request->baseUrl.'/images/no_avatar.jpg');
                        }
    }

    public function fio(){
        return $this->surname.' '.mb_substr($this->name,0,1,'utf-8').'. '.mb_substr($this->patr,0,1,'utf-8').'.';
    }

    public function fio_full(){
        return $this->surname.' '.$this->name.' '.$this->patr;
    }

    public function ava(){
        if (!empty($this->photo)){
            echo (Yii::app()->request->baseUrl.'/media'.DIRECTORY_SEPARATOR.CHtml::encode($this->photo)); 
        }else{
            echo (Yii::app()->request->baseUrl.'/images/no_avatar.jpg');
        }

    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'personnel';
	}


    public function allPhones(){
        $phone['cab']=array();
        $phone['pers']=array();
        if(!empty($this->workplaces)){
            foreach ($this->workplaces as $wp) {
                $phone['cab'][]=CHtml::encode($wp->idCabinet->phone);
                $phone['pers'][]=CHtml::encode($wp->phone);
            }
        }
        $phone['cab']=array_unique($phone['cab']);
        $phone['pers']=array_unique($phone['pers']);
        return $phone;
    }

    public function suggestTag($keyword){
        $tags=$this->findAll(array(
            'condition'=>'surname LIKE :keyword OR name LIKE :keyword',
            'params'=>array(
            ':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
        )
        ));
        return $tags;
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
			array('id, surname, name, patr, photo, id_user, birthday, date_begin, orbase_rn, sex, date_end,idUserid_user,workplacesid_personnel,personnelPostsHistoriesid_personnel,departments_name,allfields', 'safe', 'on'=>'search'),
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
            'workplaces' => array(self::HAS_MANY, 'Workplace', 'id_personnel'),
            'personnelPostsHistories' => array(self::HAS_MANY, 'PersonnelPostsHistory', 'id_personnel','alias'=>'personnelPostsHistories'),
            'TasksActions' => array(self::HAS_MANY, 'TasksActions', 'creator'),
            'EventsActions' => array(self::HAS_MANY, 'EventsActions', 'creator'),
            'Eventsoper' => array(self::HAS_MANY, 'Eventsoper', 'creator'),
            'MedicalEquipment' => array(self::HAS_MANY, 'MedicalEquipment', 'creator'),
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
            'allfields' => 'Поиск',
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

        $criteria->with=array('EventsActions' => array('alias' => 'EventsActions'),'personnelPostsHistories' => array('alias' => 'personnelpostshistory'),'workplaces' => array('alias' => 'workplace'),'idUser' => array('alias' => 'users'));
        $criteria->compare('id',$this->id);
        $criteria->compare('surname',$this->surname,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('patr',$this->patr,true);
        $criteria->compare('photo',$this->photo,true);
        $criteria->compare('id_user',$this->id_user);
        $criteria->compare('birthday',$this->birthday,true);
        $criteria->compare('date_begin',$this->date_begin,true);
        $criteria->compare('date_end',$this->date_end,true);
        $criteria->compare('orbase_rn',$this->orbase_rn,true);
        $criteria->compare('allfields',$this->allfields,true);
        $criteria->compare('sex',$this->sex);
        $criteria->compare('personnelpostshistory.id_personnel',$this->personnelPostsHistoriesid_personnel,true);
        $criteria->compare('workplace.id_personnel',$this->workplacesid_personnel,true);
        $criteria->compare('users.id_user',$this->idUserid_user,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
       




    public function search_pers()
    {
        $criteria=new CDbCriteria;
        $criteria->with=array(
            'idUser' => array('alias' => 'users'),
            'workplaces' => array('alias' => 'workplace','together'=>True),
            'workplaces.idCabinet' => array('alias' => 'cabinet','together'=>True),
            'personnelPostsHistories' => array('order'=>'"personnelPostsHistories".date_end DESC','alias' => 'personnelPostsHistories','condition'=>"\"personnelPostsHistories\".date_end is NULL",'together'=>True),
            'personnelPostsHistories.idPost'=>array('alias'=>'department_posts'),
            'personnelPostsHistories.idPost.postSubdivRn'=>array('alias'=>'departments'),);

        $criteria->compare('id',$this->id);
        $words=explode(" ",$this->allfields);

        foreach ($words as $v) {
        $criteria2=new CDbCriteria;
            $criteria2->compare('LOWER(t.surname)',mb_strtolower($v,'UTF-8'),true, 'OR');
            $criteria2->compare('LOWER(t.name)',mb_strtolower($v,'UTF-8'),true, 'OR');
            $criteria2->compare('LOWER(t.patr)',mb_strtolower($v,'UTF-8'),true, 'OR');
            $criteria2->compare('LOWER(department_posts.post)',mb_strtolower($v,'UTF-8'),true, 'OR');
            $criteria2->compare('LOWER(departments.name)',mb_strtolower($v,'UTF-8'),true, 'OR' );
            $criteria2->compare('LOWER(cabinet.cname)',mb_strtolower($v,'UTF-8'),true, 'OR' );
            $criteria2->compare('LOWER(cabinet.num)',mb_strtolower($v,'UTF-8'),true, 'OR' );
            $criteria2->compare('LOWER(cabinet.phone)',mb_strtolower($v,'UTF-8'),true, 'OR' );
            $criteria2->compare('LOWER(workplace.phone)',mb_strtolower($v,'UTF-8'),true, 'OR' );
        $criteria->mergeWith($criteria2);
        }
        $criteria->order='"t".surname ASC';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20,
            ),
        ));
    }

}