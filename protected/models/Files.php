<?php

/**
 * This is the model class for table "files".
 *
 * The followings are the available columns in table 'files':
 * @property integer $id
 * @property integer $creator
 * @property string $name
 * @property string $timestamp
 * @property string $link
 *		 * The followings are the available model relations:


 * @property Personnel $creator0
 */
class Files extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Files the static model class
	 */
	public static $modelLabelS='Files';
	public static $modelLabelP='Files';
	
	public $creator0creator;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
			'PreFill'=>array(
				'class'=>'application.behaviors.PreFillBehavior',
				),
			'FixedOwner'=>array(
				'class'=>'application.behaviors.FixedOwnerBehavior',
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
		return 'files';
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
			array('link', 'length', 'max'=>255),
			array('timestamp', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, creator, name, timestamp, link,creator0creator', 'safe', 'on'=>'search'),
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
			'tasks'=>array(self::MANY_MANY,'Tasks','files_throw(id_file,id_task)'),
		);
	}

	public function beforeSave(){
        if(($this->scenario=='insert' || $this->scenario=='update') && ($document=CUploadedFile::getInstances($this,'link')) && !empty($document)){
            $sourcePath = pathinfo($document[0]->getName());  
            $fileName = date('YmdHsi').mt_rand(10,99).'.'. $sourcePath['extension'];
            $this->name=(empty($this->name))?$sourcePath['filename'].'.'. $sourcePath['extension']:$this->name;  // имя будущего файла в базе и ФС
            $document[0]->saveAs(
            Yii::getPathOfAlias('webroot.media').DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.$fileName);
            $this->link=$fileName;
        }
        return parent::beforeSave();
    }


    public function beforeDelete(){
        $this->deleteFile(); // удалили модель? удаляем и файл
        return parent::beforeDelete();
    }
 
  

    public function deleteFile(){
        $filePath=Yii::getPathOfAlias('webroot.media').DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.$this->link;
            if(is_file($filePath)){
            	unlink($filePath);
            }
            unset($this->link);
       
        return true;
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'creator' => 'Creator',
			'name' => 'Name',
			'timestamp' => 'Timestamp',
			'link' => 'Link',
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
		$criteria->compare('creator',$this->creator);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('personnel.creator',$this->creator0creator,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
