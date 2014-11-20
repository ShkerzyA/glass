<?php

/**
 * This is the model class for table "messages".
 *
 * The followings are the available columns in table 'messages':
 * @property integer $id
 * @property string $ttext
 * @property string $timestamp
 * @property integer $type
 * @property integer $creator
 * @property string $users
 * @property string $groups
 * @property string $departments
 *		 * The followings are the available model relations:


 * @property Personnel $creator0
 */
class Messages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Messages the static model class
	 */
	public static $modelLabelS='Сообщение';
	public static $modelLabelP='Сообщения';
	
	public $creator0creator;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
	return array(
			'TimeStamp'=>array(
				'class'=>'application.behaviors.TimeStampBehavior',
				),
			'PreFill'=>array(
				'class'=>'application.behaviors.PreFillBehavior',
				),
			'FixedOwner'=>array(
				'class'=>'application.behaviors.FixedOwnerBehavior',
				),
			);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'messages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, creator', 'numerical', 'integerOnly'=>true),
			array('ttext, timestamp, users, groups, departments', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ttext, timestamp, type, creator, users, groups, departments,creator0creator', 'safe', 'on'=>'search'),
		);
	}


	public function beforeSave(){
		$pattern='~http://([^\s]+(?=\.(jpg|jpeg|JPG|JPEG|GIF|PNG|gif|png))\.\2)~';
		$replacement='<img class=chatImg src=$0>';
		$this->ttext=preg_replace($pattern,$replacement, $this->ttext);
		echo $this->ttext;
		return parent::beforeSave();
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'creator0' => array(self::BELONGS_TO, 'Personnel', 'creator'),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ttext' => 'Ttext',
			'timestamp' => 'Timestamp',
			'type' => 'Type',
			'creator' => 'Creator',
			'users' => 'Users',
			'groups' => 'Groups',
			'departments' => 'Departments',
			'creator0creator' => 'creator',
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

		$criteria->with=array('creator0' => array('alias' => 'personnel'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('ttext',$this->ttext,true);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('type',$this->type);
		if(!empty($_GET['creator']))
				$criteria->compare('creator',$_GET['creator']);
		else
				$criteria->compare('creator',$this->creator);
		$criteria->compare('users',$this->users,true);
		$criteria->compare('groups',$this->groups,true);
		$criteria->compare('departments',$this->departments,true);
		$criteria->compare('personnel.creator',$this->creator0creator,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
