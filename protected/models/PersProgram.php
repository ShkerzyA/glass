<?php

/**
 * This is the model class for table "pers_program".
 *
 * The followings are the available columns in table 'pers_program':
 * @property integer $id
 * @property integer $id_program
 * @property integer $id_pers
 * @property string $login
 *		 * The followings are the available model relations:


 * @property Programs3p $idProgram


 * @property Personnel $idPers
 */
class PersProgram extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PersProgram the static model class
	 */
	public static $modelLabelS='PersProgram';
	public static $modelLabelP='PersProgram';
	
	public $idProgramid_program;
public $idPersid_pers;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pers_program';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_program', 'required'),
			array('id_program, id_pers', 'numerical', 'integerOnly'=>true),
			array('login', 'length', 'max'=>100),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_program, id_pers, login,idProgramid_program,idPersid_pers', 'safe', 'on'=>'search'),
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
			'idProgram' => array(self::BELONGS_TO, 'Programs3p', 'id_program'),
			'idPers' => array(self::BELONGS_TO, 'Personnel', 'id_pers'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_program' => 'Id Program',
			'id_pers' => 'Id Pers',
			'login' => 'Login',
			'idProgramid_program' => 'id_program',
			'idPersid_pers' => 'id_pers',
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

		$criteria->with=array('idProgram' => array('alias' => 'programs3p'),'idPers' => array('alias' => 'personnel'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('id_program',$this->id_program);
		$criteria->compare('id_pers',$this->id_pers);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('programs3p.id_program',$this->idProgramid_program,true);
		$criteria->compare('personnel.id_pers',$this->idPersid_pers,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
