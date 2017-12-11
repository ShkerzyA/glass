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

*  @property files[] $Files
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
	public static $ownerField='creator';
	public static $db_array=array('link');
	public static $pic_array=array('jpg','jpeg','png','gif','tif');

	public $idCatalogid_catalog;
public $creator0creator;
public $dellink=array();


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
			'PreFill'=>array(
				'class'=>'application.behaviors.PreFillBehavior',
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
			'DbArray'=>array(
				'class'=>'application.behaviors.DbArrayBehavior',
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

	public function access($exception=True){
		$this->idCatalog->access();
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('creator,  id_catalog', 'numerical', 'integerOnly'=>true),
			array('id_catalog','required'),
			array('doc_name', 'length', 'max'=>100),
			array('text_docs, date_begin, date_end, dellink, files', 'safe'),
			array('files', 'safe'),
			array('link','file','types'=>'jpg,jpeg,doc,docx,rar,zip,xls,xlsx,png,gif,pdf,djvu,txt,tif','allowEmpty'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, creator, doc_name, text_docs, link, date_begin, dellink, date_end, id_catalog,idCatalogid_catalog,creator0creator', 'safe', 'on'=>'search'),
		);
	}

	public function suggestTag($keyword){
		$keyword=mb_strtolower($keyword,'UTF-8');
 		$tags=$this->with('idCatalog')->findAll(array(
   			'condition'=>'(LOWER(t.doc_name) LIKE :keyword OR LOWER(t.text_docs) LIKE :keyword OR LOWER("idCatalog".cat_name) LIKE :keyword)',
   			'params'=>array(
     		':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',

   		)
   		,'order'=>'t.date_begin ASC'
 		));
 		return $tags;
	}


	public function getFilePath($link){
		return Yii::app()->request->baseUrl.'/media/docs/'.$link;
	}

	public function getIco($link){
		$fp=$this->getFilePath($link);
		$fl=explode('.', $link);
		if(in_array(mb_strtolower($fl[1]),self::$pic_array)){
			$d=$fp;
		}else{
			$d=(is_file(Yii::getPathOfAlias('webroot').'/images/ico/'.mb_strtolower($fl[1]).'.png')?Yii::app()->request->baseUrl.'/images/ico/'.mb_strtolower($fl[1]).'.png':Yii::app()->request->baseUrl.'/images/ico/hz.png');	
		}


		
		return $d;
	}

	public function isOwner(){
		if(Yii::app()->user->id_pers==$this->creator)
			return True;
		else
			return False;
	}

	public function nameL(){
		return $this->idCatalog->cat_name.'/'.$this->doc_name;
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
			'creator0' => array(self::BELONGS_TO, 'Personnel', 'creator'),
			'files'=>array(self::MANY_MANY,'Files','files_throw(id_doc,id_file)'),
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
			'link' => 'Добавить файлы',
			'date_begin' => 'Дата создания',
			'date_end' => 'Дата закрытия',
			'id_catalog' => 'Каталог',
			'idCatalogid_catalog' => 'Каталог',
			'creator0creator' => 'Создатель',
			'dellink' => 'Удалить файлы',
			'files' => 'Файлы',
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

		$criteria->with=array('idCatalog' => array('alias' => 'catalogs'),'creator0' => array('alias' => 'personnel'),);
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
		$criteria->compare('files',$this->files);
		if(!empty($_GET['id_catalog']))
				$criteria->compare('id_catalog',$_GET['id_catalog']);
		else
				$criteria->compare('id_catalog',$this->id_catalog);
		$criteria->compare('catalogs.id_catalog',$this->idCatalogid_catalog,true);
		$criteria->compare('personnel.post',$this->creator0creator,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
