<?php

/**
 * This is the model class for table "docs".
 *
 * The followings are the available columns in table 'docs':
 * @property integer $id
 * @property integer $creator
 * @property string $doc_name
 * @property string $text_docs
 * @property string $link
 * @property string $date_begin
 * @property string $date_end
 * @property integer $type
 * @property integer $id_catalog
 *		 * The followings are the available model relations:


 * @property Catalogs $idCatalog


 * @property DepartmentPosts $creator0
 */
class Docs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Docs the static model class
	 */
	public static $modelLabelS='Документ';
	public static $modelLabelP='Документы';
	
	public $idCatalogid_catalog;
public $creator0creator;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
			'File'=>array(
				'class'=>'application.behaviors.FileBehavior',
				),
			'DateBeginEnd'=>array(
				'class'=>'application.behaviors.DateBeginEndBehavior',
				),
			);
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'docs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('creator, type, id_catalog', 'numerical', 'integerOnly'=>true),
			array('doc_name, link', 'length', 'max'=>100),
			array('text_docs, date_begin, date_end', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, creator, doc_name, text_docs, link, date_begin, date_end, type, id_catalog,idCatalogid_catalog,creator0creator', 'safe', 'on'=>'search'),
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
			'idCatalog' => array(self::BELONGS_TO, 'Catalogs', 'id_catalog'),
			'creator0' => array(self::BELONGS_TO, 'DepartmentPosts', 'creator'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'creator' => 'Создатель',
			'doc_name' => 'Название',
			'text_docs' => 'Текст',
			'link' => 'Ссылка',
			'date_begin' => 'Дата создания',
			'date_end' => 'Дата закрытия',
			'type' => 'Тип',
			'id_catalog' => 'Каталог',
			'idCatalogid_catalog' => 'Каталог',
			'creator0creator' => 'Создатель',
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

		$criteria->with=array('idCatalog' => array('alias' => 'catalogs'),'creator0' => array('alias' => 'departmentposts'),);
		$criteria->compare('id',$this->id);
		if(!empty($_GET['creator']))
				$criteria->compare('creator',$_GET['creator']);
		else
				$criteria->compare('creator',$this->creator);
		$criteria->compare('doc_name',$this->doc_name,true);
		$criteria->compare('text_docs',$this->text_docs,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('date_begin',$this->date_begin,true);
		$criteria->compare('date_end',$this->date_end,true);
		$criteria->compare('type',$this->type);
		if(!empty($_GET['id_catalog']))
				$criteria->compare('id_catalog',$_GET['id_catalog']);
		else
				$criteria->compare('id_catalog',$this->id_catalog);
		$criteria->compare('catalogs.id_catalog',$this->idCatalogid_catalog,true);
		$criteria->compare('departmentposts.post',$this->creator0creator,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
