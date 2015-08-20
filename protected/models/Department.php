<?php

/**
 * This is the model class for table "department".
 *
 * The followings are the available columns in table 'department':
 * @property integer $id
 * @property integer $id_parent
 * @property string $name
 * @property string $date_begin
 * @property string $date_end
 *		 * The followings are the available model relations:


 * @property DepartmentPosts[] $departmentPosts
 */
class Department extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Department the static model class
	 */
	public static $modelLabelS='Отдел';
	public static $modelLabelP='Отделы';
	
 public $parentSubdivRnparent_subdiv_rn;
public $departmentsparent_subdiv_rn;
public $departmentPostspost_subdiv_rn;

    public static $tree=array(
        'parent_id'=>'id',
        'query'=>"SELECT m1.id, m1.bname AS text, m1.id as parent_id, count(m2.id) AS \"hasChildren\" FROM building AS m1 LEFT JOIN floor AS m2 ON m1.id=m2.id_building",
        'group'=>'GROUP BY m1.id  ORDER BY m1.bname ASC',
        'child'=>'Floor',
        );



	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
			'DateBeginEnd'=>array(
				'class'=>'application.behaviors.DateBeginEndBehavior',
				),
            'PreFill'=>array(
                'class'=>'application.behaviors.PreFillBehavior',
                ),
			);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'department';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date_begin', 'required'),
            array('name', 'length', 'max'=>100),
            array('subdiv_rn, parent_subdiv_rn', 'length', 'max'=>10),
            array('date_end', 'safe'),
        	array('subdiv_rn', 'unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, date_begin, date_end, subdiv_rn, parent_subdiv_rn,parentSubdivRnparent_subdiv_rn,departmentsparent_subdiv_rn,departmentPostspost_subdiv_rn', 'safe', 'on'=>'search'),
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
            'parentSubdivRn' => array(self::BELONGS_TO, 'Department', 'parent_subdiv_rn'),
            'departments' => array(self::HAS_MANY, 'Department', 'parent_subdiv_rn'),
            'departmentPosts' => array(self::HAS_MANY, 'DepartmentPosts', 'post_subdiv_rn'),
            'workplaces' => array(self::HAS_MANY, 'workplaces', 'wp_subdiv_rn'),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название отдела',
			'date_begin' => 'Начало работы',
			'date_end' => 'Окончание работы',
            'subdiv_rn' => 'Код Отдела в Парусе',
            'parent_subdiv_rn' => 'Вышестоящий отдел в парусе',
            'parentSubdivRnparent_subdiv_rn' => 'Вышестоящий отдел',
            'departmentsparent_subdiv_rn' => 'Подчиненные отделы',
            'departmentPostspost_subdiv_rn' => 'Код должностей в парусе',
		);
	}



	public function beforeSave() {
        foreach ($this->attributes as $key => $value)
                if (!$value)
                        $this->$key = NULL;
                
        return parent::beforeSave();
	}

	    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->with=array('parentSubdivRn' => array('alias' => 'department'),'departments' => array('alias' => 'departments'),'departmentPosts' => array('alias' => 'departmentposts'),);
        $criteria->compare('id',$this->id);
        $criteria->compare('t.name',$this->name,true);
        $criteria->compare('date_begin',$this->date_begin,true);
        $criteria->compare('date_end',$this->date_end,true);
        $criteria->compare('subdiv_rn',$this->subdiv_rn,true);
        if(!empty($_GET['parent_subdiv_rn']))
            $criteria->compare('parent_subdiv_rn',$_GET['parent_subdiv_rn'],true);
        else
            $criteria->compare('parent_subdiv_rn',$this->parent_subdiv_rn,true);
        $criteria->compare('department.name',$this->parentSubdivRnparent_subdiv_rn,true);
        $criteria->compare('departments.name',$this->departmentsparent_subdiv_rn,true);
        //$criteria->compare('department_posts.name',$this->departmentPostspost_subdiv_rn,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

}