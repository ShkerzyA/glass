<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property string $timestamp
 * @property integer $creator
 *		 * The followings are the available model relations:


 * @property Personnel $creator0
 */
class News extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return News the static model class
	 */
	public static $modelLabelS='Новость';
	public static $modelLabelP='Новости';
	
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
			'FixedOwner'=>array(
				'class'=>'application.behaviors.FixedOwnerBehavior',
				),
			'FileModel'=>array(
				'class'=>'application.behaviors.FileModelBehavior',
				),
			'ESaveRelatedBehavior'=>array(
				'class'=>'application.behaviors.ESaveRelatedBehavior',
				),
			);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'news';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('creator', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('text, timestamp, files', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, text, timestamp, creator,creator0creator', 'safe', 'on'=>'search'),
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
			'creator0' => array(self::BELONGS_TO, 'Personnel', 'creator'),
			'files'=>array(self::MANY_MANY,'Files','files_throw(id_news,id_file)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'text' => 'Text',
			'timestamp' => 'Timestamp',
			'creator' => 'Creator',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('creator',$this->creator);
		$criteria->compare('personnel.creator',$this->creator0creator,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
