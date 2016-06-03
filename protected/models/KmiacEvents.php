<?php

/**
 * This is the model class for table "kmiac_events".
 *
 * The followings are the available columns in table 'kmiac_events':
 * @property integer $id
 * @property string $party
 * @property string $description
 * @property string $date
 * @property string $t_time
 * @property string $b_time
 * @property string $e_time
 * @property string $link
 */
class KmiacEvents extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KmiacEvents the static model class
	 */
	public static $modelLabelS='Видеоконференция';
	public static $modelLabelP='Видеоконференции';
	
	

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kmiac_events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('link', 'length', 'max'=>255),
			array('party, description, date, t_time, b_time, e_time', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, party, description, date, t_time, b_time, e_time, link', 'safe', 'on'=>'search'),
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

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'party' => 'Участники',
			'description' => 'Описание',
			'date' => 'Дата',
			't_time' => 'Техническое включение',
			'b_time' => 'Начало',
			'e_time' => 'Завершение',
			'link' => 'Ссылка',
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
		$criteria->compare('party',$this->party,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('t_time',$this->t_time,true);
		$criteria->compare('b_time',$this->b_time,true);
		$criteria->compare('e_time',$this->e_time,true);
		$criteria->compare('link',$this->link,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
