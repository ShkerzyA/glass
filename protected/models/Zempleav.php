<?php

/**
 * This is the model class for table "zempleav".
 *
 * The followings are the available columns in table 'zempleav':
 * @property string $empleav_rn
 * @property string $ank_rn
 * @property string $type
 * @property string $leavekind_
 * @property string $grrbdc_rn
 * @property string $startdate
 * @property string $enddate
 * @property string $maindays
 * @property string $adddays
 * @property string $docdate
 * @property string $docnum
 * @property string $fromdate
 * @property string $todate
 * @property boolean $storno
 * @property string $kfindbs_rn
 * @property string $source
 * @property string $orgbase_rn
 * @property string $docbase_rn
 * @property string $docorg_rn
 * @property boolean $delayinlea
 * @property string $reason
 *		 * The followings are the available model relations:


 * @property Personnel $orgbaseRn
 */
class Zempleav extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Zempleav the static model class
	 */
	public static $modelLabelS='Отпуск';
	public static $modelLabelP='Отпуска';
	
	public $orgbaseRnorgbase_rn;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function scopes()
    {
    	$alias=$this->getTableAlias();
        return array(
            'is_today'=>array(
                'condition' => '"'.$alias.'".startdate<=current_date and "'.$alias.'".enddate>=current_date'
            ),
            'current_year'=>array(
                'condition' => '"'.$alias.'".docdate>=\''.date('Y').'-01-01'.'\''
            ),
        );
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'zempleav';
	}

	public function behaviors(){
		return array(
            // наше поведение для работы с файлом
			'PreFill'=>array(
				'class'=>'application.behaviors.PreFillBehavior',
				),
			);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
/*
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('empleav_rn', 'required'),
			array('empleav_rn, ank_rn, leavekind_, grrbdc_rn, maindays, kfindbs_rn, orgbase_rn, docbase_rn, docorg_rn', 'length', 'max'=>4),
			array('type, source', 'length', 'max'=>1),
			array('adddays', 'length', 'max'=>3),
			array('docnum', 'length', 'max'=>21),
			array('reason', 'length', 'max'=>254),
			array('startdate, enddate, docdate, fromdate, todate, storno, delayinlea', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('empleav_rn, ank_rn, type, leavekind_, grrbdc_rn, startdate, enddate, maindays, adddays, docdate, docnum, fromdate, todate, storno, kfindbs_rn, source, orgbase_rn, docbase_rn, docorg_rn, delayinlea, reason,orgbaseRnorgbase_rn', 'safe', 'on'=>'search'),
		);
	}
*/
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('empleav_rn', 'required'),
			array('empleav_rn, orgbase_rn', 'length', 'max'=>4),
			array('type', 'length', 'max'=>1),
			array('startdate, enddate, docdate', 'safe'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('empleav_rn, ank_rn, type, leavekind_, grrbdc_rn, startdate, enddate, maindays, adddays, docdate, docnum, fromdate, todate, storno, kfindbs_rn, source, orgbase_rn, docbase_rn, docorg_rn, delayinlea, reason,orgbaseRnorgbase_rn', 'safe', 'on'=>'search'),
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
			'orgbaseRn' => array(self::BELONGS_TO, 'Personnel', 'orgbase_rn'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'empleav_rn' => 'ID',
			'type' => 'Тип отпуска',
			#'leavekind_' => 'Leavekind',
			#'grrbdc_rn' => 'Grrbdc Rn',
			'startdate' => 'Дата начала',
			'enddate' => 'Дата окончания',
			#'maindays' => 'Maindays',
			#'adddays' => 'Adddays',
			'docdate' => 'Дата приказа',
			#'docnum' => 'Docnum',
			#'fromdate' => 'Fromdate',
			#'todate' => 'Todate',
			#'storno' => 'Storno',
			#'kfindbs_rn' => 'Kfindbs Rn',
			#'source' => 'Source',
			'orgbase_rn' => 'Сотрудник',
			#'docbase_rn' => 'Docbase Rn',
			#'docorg_rn' => 'Docorg Rn',
			#'delayinlea' => 'Delayinlea',
			#'reason' => 'Reason',
			'orgbaseRnorgbase_rn' => 'Сотрудник',
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

		$criteria->with=array('orgbaseRn' => array('alias' => 'personnel'),);
		$criteria->compare('empleav_rn',$this->empleav_rn,true);
		#$criteria->compare('ank_rn',$this->ank_rn,true);
		$criteria->compare('type',$this->type,true);
		#$criteria->compare('leavekind_',$this->leavekind_,true);
		#$criteria->compare('grrbdc_rn',$this->grrbdc_rn,true);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);
		#$criteria->compare('maindays',$this->maindays,true);
		#$criteria->compare('adddays',$this->adddays,true);
		$criteria->compare('docdate',$this->docdate,true);
		#$criteria->compare('docnum',$this->docnum,true);
		#$criteria->compare('fromdate',$this->fromdate,true);
		#$criteria->compare('todate',$this->todate,true);
		#$criteria->compare('storno',$this->storno);
		#$criteria->compare('kfindbs_rn',$this->kfindbs_rn,true);
		#$criteria->compare('source',$this->source,true);
		if(!empty($_GET['orgbase_rn']))
				$criteria->compare('orgbase_rn',$_GET['orgbase_rn'],true);
		else
				$criteria->compare('orgbase_rn',$this->orgbase_rn,true);
		
		#$criteria->compare('docbase_rn',$this->docbase_rn,true);
		#$criteria->compare('docorg_rn',$this->docorg_rn,true);
		#$criteria->compare('delayinlea',$this->delayinlea);
		#$criteria->compare('reason',$this->reason,true);
		$criteria->compare('personnel.surname',$this->orgbaseRnorgbase_rn,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
