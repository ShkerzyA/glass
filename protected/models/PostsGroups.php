<?php

/**
 * This is the model class for table "posts_groups".
 *
 * The followings are the available columns in table 'posts_groups':
 * @property integer $id
 * @property string $group_name
 * @property string $group_key
 */
class PostsGroups extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PostsGroups the static model class
	 */
	public static $modelLabelS='Группа должностей';
	public static $modelLabelP='Группы должностей';
	
	

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}



	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'posts_groups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_name', 'length', 'max'=>50),
			array('group_key', 'length', 'max'=>30),
			array('type', 'numerical', 'integerOnly'=>true),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, group_name, group_key, type', 'safe', 'on'=>'search'),
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
		);
	}

	public static function tasksGroupKeys(){
		$tasksGroup=self::model()->findAll(array('condition'=>'t.type=2'));
		$tgArray=array();
		foreach ($tasksGroup as $g) {
			$tgArray[]=$g->group_key;
		}
		return $tgArray;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'group_name' => 'Название группы',
			'group_key' => 'Ключ группы',
			'type' => 'Тип группы'
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

		$criteria->compare('id',$this->id);
		$criteria->compare('group_name',$this->group_name,true);
		$criteria->compare('group_key',$this->group_key,true);
		$criteria->compare('group_key',$this->group_key,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
