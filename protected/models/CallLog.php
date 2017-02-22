<?php

/**
 * This is the model class for table "call_log".
 *
 * The followings are the available columns in table 'call_log':
 * @property integer $id
 * @property string $timestamp
 * @property integer $code
 * @property string $direction
 * @property integer $calling_number
 * @property integer $called_number
 * @property integer $duration
 * @property double $cost
 */
class CallLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CallLog the static model class
	 */
	public $timestamp_end;
	
	

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function parseCallLog($file){
		$result=array();
		$calling_number=NULL;
		$scenario=NULL;
		preg_match("/(\d{2}\.\d{2}\.\d{4})-(\d{2}\.\d{2}\.\d{4})/", $file[0],$fs);
		$condition="timestamp>='".$fs[1]." 00:00:00' and timestamp<='".$fs[2]." 23:59:59'";
		CallLogApus::model()->deleteAll(array('condition'=>$condition));
		CallLogAuto::model()->deleteAll(array('condition'=>$condition));
		
		foreach ($file as &$v) {
			$splitted_v=preg_split('/\s+/',$v);
			if(trim($splitted_v[0])=='Телефон'){
				$calling_number=trim($splitted_v[1]);
			}
			if(preg_match("/^(\d{2}\.\d{2}\.\d{4}\s+\d{2}:\d{2})\s+(\d+)\s+([\S\s]+?)(\d{11})\s+(\d*?\.??\d+?)\s+(\d{1,3}\.\d{2})/", $v,$matches)){
				$matches[]=$calling_number;
				$result[]=$matches;
				$callLog=new CallLogAuto;
				$callLog->timestamp=$matches[1];
				$callLog->code=$matches[2];
				$callLog->direction=$matches[3];
				$callLog->called_number=$matches[4];
				$callLog->duration=$matches[5];
				$callLog->cost=$matches[6];
				$callLog->calling_number=$matches[7];
				$callLog->save();
			}else if(preg_match("/^(\d{2}\.\d{2}\.\d{4})\s+(.+?)\s+(\d{1,3}\.?\d?)\s+(\d{1,4})\s+(\d{1,5}\.\d{2})/", $v,$matches)){
				$matches[]=$calling_number;
				$result[]=$matches;
				$callLog=new CallLogApus;
				$callLog->timestamp=$matches[1];
				$callLog->tarif=$matches[2];
				$callLog->duration=$matches[3];
				$callLog->quantity=$matches[4];
				$callLog->cost=$matches[5];
				$callLog->calling_number=$matches[6];
				$callLog->save();
			}

		}
		return $result;
	}

		public function attributeLabels()
	{
		return array(
			'timestamp_end' => 'До',
		);
	}

	/**
	 * @return string the associated database table name
	 */


	/**
	 * @return array validation rules for model attributes.
	 */

	/**
	 * @return array relational rules.
	 */

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */

}
