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
	public static $db_array=array('groups');
	
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
			'DbArray'=>array(
				'class'=>'application.behaviors.DbArrayBehavior',
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
	public function getType(){
		$status=array(  0 => 'приказы',
						1 => 'внутренние',
						2 => 'входящие',
						3 => 'исходящие');
		return $status;
	}



	public function tableName()
	{
		return 'catalogs';
	}


	public function access($exception=True){
		if(!(Yii::app()->user->checkAccess('inGroup',array('group'=>$this->groups))) and !(Yii::app()->user->checkAccess('isOwner',array('mod'=>$this)))){
			if($exception){
				throw new CHttpException(403, 'У вас недостаточно прав');
			}else{
				return False;
			}
		}
		return True;
		//if (!Yii::app()->user->checkAccess('isOwner',array('mod'=>$this)))
           
	}

	public function isOwner(){
		if(Yii::app()->user->id_pers==$this->owner)
			return True;
		else
			return False;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_parent, owner, type', 'numerical', 'integerOnly'=>true),
			array('cat_name', 'length', 'max'=>100),
			array('groups', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_parent, cat_name, owner, type, groups,docsid_catalog,idParentid_parent,catalogsid_parent,owner0owner', 'safe', 'on'=>'search'),
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
			'owner0' => array(self::BELONGS_TO, 'Personnel', 'owner'),
		);
	}

	public function parentId(){
		if(!empty($this->idParent))
			return $this->idParent->id;
	}

	public function parentName(){
		if(!empty($this->idParent))
			return $this->idParent->cat_name;
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
			'type' => 'Тип',
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
		$criteria->with=array('docs' => array('alias' => 'docs'),'idParent' => array('alias' => 'catalogsP'),'catalogs' => array('alias' => 'catalogs'),'owner0' => array('alias' => 'personnel'),);
		$criteria->compare('id',$this->id);
		if(!empty($_GET['id_parent']))
			$criteria->compare('t.id_parent',$_GET['id_parent']);
		else
			$criteria->compare('t.id_parent',$this->id_parent);
		$criteria->compare('cat_name',$this->cat_name,true);
		if(!empty($_GET['owner']))
			$criteria->compare('owner',$_GET['owner']);
		else
			$criteria->compare('owner',$this->owner);
		$criteria->compare('groups',$this->groups,true);
		$criteria->compare('docs.id_catalog',$this->docsid_catalog,true);
		$criteria->compare('catalogsP.id',$this->idParentid_parent,true);
		$criteria->compare('catalogs.id',$this->catalogsid_parent,true);
		$criteria->compare('personnel.surname',$this->owner0owner,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
