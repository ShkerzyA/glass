<?php

/**
 * This is the model class for table "sex".
 *
 * The followings are the available columns in table 'sex':
 * @property integer $id
 * @property string $name
 */
class MyDbase extends CFormModel{

	public static $modelLabelS='Операции с Dbase';
	public static $modelLabelP='Операции с Dbase';
	public $dbase;
 	private $pathToDb='/home/al/localhost/www/onko2003/data/';

 	public function read_table($tablename,$keycolumn=NULL){
 		$result=array();
 		$this->dbase=dbase_open($this->pathToDb.$tablename,0);
 		for($i=1;$i<=dbase_numrecords($this->dbase);$i++){
 			$row=dbase_get_record_with_names($this->dbase,$i);

 			foreach ($row as &$v){
 				$v=iconv('cp1251','UTF8', $v);
 			}
 			if(!empty($keycolumn)){
 				$result[$row[$keycolumn]]=$row;
 			}else{

 				$result[]=$row;
 			}

 		}
 		dbase_close($this->dbase);
 		return $result;
 	}




 	public function otdelImport(){
 		$zSubDiv=$this->read_table('zSubDiv.DBF','CATALOG_RN');
 		$acatalog=$this->read_table('acatalog2.dbf','RN');
		
		$acatalog=array_filter($acatalog, function($var){return ($var['UNIT_RN']=="001g");});

		foreach ($zSubDiv as &$v){
			$v['cataloginfo']=$acatalog[$v['CATALOG_RN']];
			$v['PARENTPARENT']=$zSubDiv[$v['cataloginfo']['PARENT_RN']]['SUBDIV_RN'];
		}

		foreach ($zSubDiv as $v) {

			$dep=new Department();
			$dep->name=trim($v['NAME']);
			$dep->date_begin=substr($v['STARTDATE'] , 6,2).'.'.substr($v['STARTDATE'] , 4,2).'.'.substr($v['STARTDATE'] , 0,4);
            $dep->date_end=substr($v['ENDDATE'] , 6,2).'.'.substr($v['ENDDATE'] , 4,2).'.'.substr($v['ENDDATE'] ,0,4);
			$dep->subdiv_rn=$v['SUBDIV_RN'];
			//$dep->parent_subdiv_rn=$v['PARENTPARENT'];
			$dep->save();
			//var_dump($dep->getErrors()); 
		}

		foreach ($zSubDiv as $v) {
			$dep=Department::model()->find(array('condition'=>'subdiv_rn=:subdiv_rn','params'=>array(":subdiv_rn"=>$v['SUBDIV_RN'])));
			$dep->parent_subdiv_rn=$v['PARENTPARENT'];
			$dep->save();
		}

		Department::model()->updateAll(array( 'date_end' => NULL ), 'date_end = \'01.01.1970\'');

 		//$result[]=$acatalog;
 		return $zSubDiv;
 	}


 	public function personnelImport(){
 		$personnel=$this->read_table('person.dbf','ORBASE_RN');

		foreach ($personnel as $v) {

				if($pers=Personnel::model()->find(array('condition'=>'orbase_rn=:orbase_rn','params'=>array(":orbase_rn"=>$v['ORBASE_RN'])))){
					$newpers=$pers;
				}else{
					$newpers=new Personnel();
				}
       			$newpers->surname=trim($v['SURNAME']);
       			$newpers->name=trim($v['FIRSTNAME']);
       			$newpers->patr=trim($v['SECONDNAME']);
       			$newpers->birthday=date('d.m.Y',strtotime($v['BIRTHDAY']));
       			$newpers->orbase_rn=$v['ORBASE_RN'];
       			if(trim($v['SEX'])=='М')
       				$newpers->sex=0;
       			else if(trim($v['SEX'])=='Ж')
       				$newpers->sex=1;
       			$newpers->save();
       			var_dump($newpers->getErrors());
		}

 		return $personnel;
 	}


}