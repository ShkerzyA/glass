<?php

/**
 * This is the model class for table "catalogs".
 *
 * The followings are the available columns in table 'catalogs':
 * @property integer $id
 * @property integer $id_parent
 * @property string $cat_name
 * @property integer $owner
 * @property string $groups
 *		 * The followings are the available model relations:


 * @property Docs[] $docs


 * @property Catalogs $idParent


 * @property Catalogs[] $catalogs


 * @property DepartmentPosts $owner0
 */
class Catalogs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Catalogs the static model class
	 */
	public static $modelLabelS='Каталог';
	public static $modelLabelP='Каталоги';
	
	public $docsid_catalog;
public $idParentid_parent;
public $catalogsid_parent;
public $owner0owner;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function behaviors(){
		return array(
			'Multichoise'=>array(
				'class'=>'application.behaviors.MultichoiseBehavior',
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
		return 'catalogs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_parent, owner', 'numerical', 'integerOnly'=>true),
			array('cat_name', 'length', 'max'=>100),
			array('groups', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_parent, cat_name, owner, groups,docsid_catalog,idParentid_parent,catalogsid_parent,owner0owner', 'safe', 'on'=>'search'),
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
			'docs' => array(self::HAS_MANY, 'Docs', 'id_catalog'),
			'idParent' => array(self::BELONGS_TO, 'Catalogs', 'id_parent'),
			'catalogs' => array(self::HAS_MANY, 'Catalogs', 'id_parent'),
			'owner0' => array(self::BELONGS_TO, 'DepartmentPosts', 'owner'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_parent' => 'Родительский каталог',
			'cat_name' => 'Название каталога',
			'owner' => 'Владелец',
			'groups' => 'Группы',
			'docsid_catalog' => 'id_catalog',
			'idParentid_parent' => 'Родительский каталог',
			'catalogsid_parent' => 'Дочерние каталоги',
			'owner0owner' => 'Владелец',
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

		$criteria->with=array('docs' => array('alias' => 'docs'),'idParent' => array('alias' => 'catalogsP'),'catalogs' => array('alias' => 'catalogs'),'owner0' => array('alias' => 'departmentposts'),);
		$criteria->compare('id',$this->id);
		if(!empty($_GET['id_parent']))
				$criteria->compare('id_parent',$_GET['id_parent']);
		else
				$criteria->compare('id_parent',$this->id_parent);
		$criteria->compare('cat_name',$this->cat_name,true);
		if(!empty($_GET['owner']))
				$criteria->compare('owner',$_GET['owner']);
		else
				$criteria->compare('owner',$this->owner);
		$criteria->compare('groups',$this->groups,true);
		$criteria->compare('docs.id_catalog',$this->docsid_catalog,true);
		$criteria->compare('catalogsP.id',$this->idParentid_parent,true);
		$criteria->compare('catalogs.id',$this->catalogsid_parent,true);
		$criteria->compare('departmentposts.post',$this->owner0owner,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
