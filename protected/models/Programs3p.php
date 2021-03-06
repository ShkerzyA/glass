<?php

/**
 * This is the model class for table "programs3p".
 *
 * The followings are the available columns in table 'programs3p':
 * @property integer $id
 * @property string $name
 * @property string $date_begin
 * @property string $date_end
 *		 * The followings are the available model relations:


 * @property PersProgram[] $persPrograms
 */
class Programs3p extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Programs3p the static model class
	 */
	public static $modelLabelS='Стороннее ПО';
	public static $modelLabelP='Стороннее ПО';
	
	public $persProgramsid_program;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'programs3p';
	}

	public function behaviors(){
		return array(
            // наше поведение для работы с файлом
			'DateBeginEnd'=>array(
				'class'=>'application.behaviors.DateBeginEndBehavior',
				),

			);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>100),
			array('date_begin, date_end', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, date_begin, date_end,persProgramsid_program', 'safe', 'on'=>'search'),
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
			'persPrograms' => array(self::HAS_MANY, 'PersProgram', 'id_program'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Программа',
			'date_begin' => 'Дата начала использования',
			'date_end' => 'Дата окончания использования',
			'persProgramsid_program' => 'id_program',
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

		$criteria->with=array('persPrograms' => array('alias' => 'persprogram'),);
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('date_begin',$this->date_begin,true);
		$criteria->compare('date_end',$this->date_end,true);
		$criteria->compare('persprogram.id_program',$this->persProgramsid_program,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
