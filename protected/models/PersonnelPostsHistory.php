<?php

/**
 * This is the model class for table "personnel_posts_history".
 *
 * The followings are the available columns in table 'personnel_posts_history':
 * @property integer $id
 * @property integer $id_personnel
 * @property integer $id_post
 * @property integer $id_department
 * @property string $date_begin
 * @property string $date_end
 *
 * The followings are the available model relations:
 * @property Personnel $idPersonnel
 */
class PersonnelPostsHistory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PersonnelPostsHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
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
		return 'personnel_posts_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_personnel, id_post', 'numerical', 'integerOnly'=>true),
			array('date_begin, date_end', 'date','format'=>'dd.MM.yyyy'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_personnel, id_post, department_posts, date_begin, date_end, personnel', 'safe', 'on'=>'search'),
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
			'personnel' => array(self::BELONGS_TO, 'Personnel', 'id_personnel'),
			'department_posts' => array(self::BELONGS_TO, 'DepartmentPosts', 'id_post'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'personnel' => 'Сотрудник',
			'department_posts' => 'Должность',
			'date_begin' => 'Дата начала',
			'date_end' => 'Дата окончания',
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

		$criteria->with = array('personnel','department_posts');

		$criteria->compare('id',$this->id);
		$criteria->compare('id_personnel',$this->id_personnel);
		$criteria->compare('id_post',$this->id_post);
		$criteria->compare('date_begin',$this->date_begin,true);
		$criteria->compare('date_end',$this->date_end,true);

		$criteria->compare('personnel.surname', $this->personnel, true );
		$criteria->compare('department_posts.post', $this->department_posts, true );

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function allPersonelForPost($id_post){
		$personnel=PersonnelPostsHistory::model()->with('personnel')->findAll(array('condition'=>"id_post=$id_post"));

		//echo '<pre>';
		//print_r($personnel[0]);
		//echo '</pre>';
		//$sSep=', ';
		foreach ($personnel as $itm) {
			echo($itm['personnel']['surname'].' '.$itm['personnel']['name'].' '.$itm['personnel']['patr'].'</br>');
			//$aRes[] = $itm->surname;
		}

		//return implode($sSep, $aRes);
	}
}