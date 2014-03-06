<?php

/**
 * This is the model class for table "department_posts".
 *
 * The followings are the available columns in table 'department_posts':
 * @property integer $id
 * @property string $post
 * @property integer $id_department
 * @property string $date_begin
 * @property string $date_end
 *		 * The followings are the available model relations:


 * @property Department $idDepartment


 * @property PersonnelPostsHistory[] $personnelPostsHistories
 */
class DepartmentPosts extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DepartmentPosts the static model class
	 */
	public static $modelLabelS='Штатная структура';
	public static $modelLabelP='Штатная структура';
	
    public $personnelPostsHistoriesid_post;
    public $postSubdivRnpost_subdiv_rn;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
	return array(
			'DateBeginEnd'=>array(
				'class'=>'application.behaviors.DateBeginEndBehavior',
				),
            'Multichoise'=>array(
                'class'=>'application.behaviors.MultichoiseBehavior',
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
		return 'department_posts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
   public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('islead, upd_flag', 'numerical', 'integerOnly'=>true),
            array('post', 'length', 'max'=>200),
            array('post_subdiv_rn', 'length', 'max'=>10),
            array('date_begin, date_end', 'safe'),
            array('post_rn', 'length', 'max'=>8),
            array('groups', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, post, date_begin, date_end, islead, upd_flag groups, post_rn, post_subdiv_rn,personnelPostsHistoriesid_post,postSubdivRnpost_subdiv_rn', 'safe', 'on'=>'search'),
        );
    }


    public function freeOnly()
    {   

    	if(!empty($_POST['DepartmentPosts']))
    		$this->attributes=$_POST['DepartmentPosts'];

    	$Ph=PersonnelPostsHistory::model()->findAll(array('condition'=>"id_post=".$this->id." and (date_end is null or date_end>current_date)"));

    	//echo '<pre>';
    	//print_r($Ph->attributes);
    	//echo '</pre>';
        if (!empty($Ph)){
        	return False;
        }
        else {
        	return True;
        }
    }
	/**
	 * @return array relational rules.
	 */
   public function relations(){
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'personnelPostsHistories' => array(self::HAS_MANY, 'PersonnelPostsHistory', 'id_post','alias'=>'personnelPostsHistories','order'=>'"personnelPostsHistories".date_end DESC, "personnelPostsHistories".date_begin DESC'),
            'postSubdivRn' => array(self::BELONGS_TO, 'Department', 'post_subdiv_rn'),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'post' => 'Должность',
			'id_department' => 'Отдел',
			'date_begin' => 'Дата начала',
			'date_end' => 'Дата окончания',
			'idDepartmentid_department' => 'Отдел',
			'personnelPostsHistoriesid_post' => 'Должность',
            'post_rn' => 'Код в парусе',
			'islead' => 'Является руководителем',
            'upd_flag' => 'служебный флаг. для синхронизации',
            'post_subdiv_rn' => 'Post Subdiv Rn',
            'personnelPostsHistoriesid_post' => 'id_post',
            'postSubdivRnpost_subdiv_rn' => 'post_subdiv_rn',
            'groups' => 'Группы',
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

        $criteria->with=array('personnelPostsHistories' => array('alias' => 'personnelPostsHistories'),'postSubdivRn' => array('alias' => 'department'),);
        $criteria->compare('t.id',$this->id);
        $criteria->compare('post',$this->post,true);
        $criteria->compare('date_begin',$this->date_begin,true);
        $criteria->compare('date_end',$this->date_end,true);
        $criteria->compare('islead',$this->islead);
        $criteria->compare('post_rn',$this->post_rn,true);
        $criteria->compare('groups',$this->groups,true);
        if(!empty($_GET['post_subdiv_rn']))
                $criteria->compare('post_subdiv_rn',$_GET['post_subdiv_rn']);
        else
                $criteria->compare('post_subdiv_rn',$this->post_subdiv_rn,true);
        if(!empty($_GET['id_post']))
                $criteria->compare('t.id',$_GET['id_post']);
        else
                $criteria->compare('t.id',$this->id);
        $criteria->compare('personnelPostsHistories.id_post',$this->personnelPostsHistoriesid_post,true);
        $criteria->compare('department.post_subdiv_rn',$this->postSubdivRnpost_subdiv_rn,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}