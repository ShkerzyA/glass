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

			$dep=Department::model()->find(array('condition'=>'subdiv_rn=:subdiv_rn','params'=>array(":subdiv_rn"=>$v['SUBDIV_RN'])));
			if(empty($dep)){
				$dep=new Department();	
			}
			$dep->name=trim($v['NAME']);
			$dep->date_begin=substr($v['STARTDATE'] , 6,2).'.'.substr($v['STARTDATE'] , 4,2).'.'.substr($v['STARTDATE'] , 0,4);
            $dep->date_end=substr($v['ENDDATE'] , 6,2).'.'.substr($v['ENDDATE'] , 4,2).'.'.substr($v['ENDDATE'] ,0,4);
			$dep->subdiv_rn=$v['SUBDIV_RN'];
			//$dep->parent_subdiv_rn=$v['PARENTPARENT'];
			$dep->save();
			//var_dump($depPost->getErrors()); //вызывает задвоение 
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
 		$zank=$this->read_table('zank.dbf','ANK_RN');

		foreach ($personnel as &$v) {
			$x=$v['ORBASE_RN'];
			$v['ank']=array_filter($zank, function($var) use ($x){return ($var['ORGBASE_RN']==$x);});
		}

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

       			$date_begin=array();
       			$date_end=array();

       			if (!empty($v['ank'])){
       				foreach ($v['ank'] as $q) {
       					$date_begin[]=new DateTime(date('d.m.Y',strtotime(substr($q['JOBBEGIN'] , 6,2).'.'.substr($q['JOBBEGIN'] , 4,2).'.'.substr($q['JOBBEGIN'] ,0,4))));
						$date_end[]=new DateTime(date('d.m.Y',strtotime(substr($q['JOBEND'] , 6,2).'.'.substr($q['JOBEND'] , 4,2).'.'.substr($q['JOBEND'] ,0,4))));
       				}

       				$newpers->date_begin=min($date_begin)->format('d.m.Y');
       				$newpers->date_end=max($date_end)->format('d.m.Y');
       				$newpers->date_end=($newpers->date_end!='01.01.1970')?$newpers->date_end:NULL;
       			}
       			$newpers->orbase_rn=$v['ORBASE_RN'];
       			if(trim($v['SEX'])=='М')
       				$newpers->sex=0;
       			else if(trim($v['SEX'])=='Ж')
       				$newpers->sex=1;
       			$newpers->save();
       			//var_dump($depPost->getErrors()); //вызывает задвоение
		}

 		return $personnel;
 	}

 	public function otdelPostsImport(){

 	
 		$posts=$this->read_table('zpost.dbf','POST_RN');
 		$zpostch=$this->read_table('zpostch.dbf');
 		$ztipdol=$this->read_table('ztipdol.dbf','TIPDOL_RN');

		foreach ($posts as &$v) {
			$t=$v['POST_RN'];
			$v['zpostch']=array_filter($zpostch, function($var) use ($t){return ($var['POSTBS_RN']==$t);});
			$v['ztipdol']=$ztipdol[$v['TIPDOL_RN']];
		}

		foreach ($posts as $v) {

			foreach ($v['zpostch'] as $z) {
				$i=0;
				while($i<$z['STQNT']){

					if($findPost=DepartmentPosts::model()->find(array('condition'=>'post_rn=:post_rn','params'=>array(":post_rn"=>$v['POST_RN'])))){
						$depPost=$findPost;
					}else{
						$depPost=new DepartmentPosts();
					}
       				$depPost->post=trim($v['ztipdol']['NAME']);
       				$depPost->post_rn=$v['POST_RN'];
       				$depPost->date_begin=substr($z['CHSTARTDAT'] , 6,2).'.'.substr($z['CHSTARTDAT'] , 4,2).'.'.substr($z['CHSTARTDAT'] ,0,4);
       				$depPost->date_end=substr($z['CHENDDATE'] , 6,2).'.'.substr($z['CHENDDATE'] , 4,2).'.'.substr($z['CHENDDATE'] ,0,4);
       				$depPost->post_subdiv_rn=trim($v['SUBDIV_RN']);
       				$depPost->save();
       				//var_dump($depPost->getErrors()); //вызывает задвоение
					$i++;	
				}
			}
				
		}

		DepartmentPosts::model()->updateAll(array( 'date_end' => NULL ), 'date_end = \'01.01.1970\'');

 		return $posts;

 	}

 	public function personnelPostsHistoryImport(){

 		//$wtf=array();
 		$zfcac=$this->read_table('zfcac.dbf');
 		$zank=$this->read_table('zank.dbf','ANK_RN');

		foreach ($zfcac as &$v) {
			$x=$v['ANK_RN'];
			$v['ank']=array_filter($zank, function($var) use ($x){return ($var['ANK_RN']==$x);});
		}

		//$x=0;
		PersonnelPostsHistory::model()->deleteAll();
		foreach ($zfcac as $v) {
			$posts=DepartmentPosts::model()->findAll(array('condition'=>'post_rn=:post_rn','params'=>array(":post_rn"=>$v['POST_RN'])));
			$date_begin=date('d.m.Y',strtotime(substr($v['STARTDATE'] , 6,2).'.'.substr($v['STARTDATE'] , 4,2).'.'.substr($v['STARTDATE'] ,0,4)));
			$date_end=date('d.m.Y',strtotime(substr($v['ENDDATE'] , 6,2).'.'.substr($v['ENDDATE'] , 4,2).'.'.substr($v['ENDDATE'] ,0,4)));
			$date_end=($date_end!='01.01.1970')?$date_end:NULL;
			foreach ($v['ank'] as $z) {
				$pers=Personnel::model()->find(array('condition'=>'orbase_rn=:orbase_rn','params'=>array(":orbase_rn"=>trim($z['ORGBASE_RN']))));
				
				$postH=new PersonnelPostsHistory();
				$postH->id_personnel=$pers->id;
				$postH->is_main=$v['ISMAINISP'];
				$postH->date_begin=$date_begin;
				$postH->date_end=$date_end;
				//$postH->date_begin=substr($z['JOBBEGIN'] , 6,2).'.'.substr($z['JOBBEGIN'] , 4,2).'.'.substr($z['JOBBEGIN'] ,0,4);
				//$date_end=date('d.m.Y',strtotime(substr($z['JOBEND'] , 6,2).'.'.substr($z['JOBEND'] , 4,2).'.'.substr($z['JOBEND'] ,0,4)));
				//$date_end=(strtotime($date_end)>strtotime($v['ENDDATE']))?(date('d.m.Y',strtotime($v['ENDDATE']))):$date_end;
				
				
				
				
				foreach ($posts as $post){
					if($post->freeOnly()){
						$postH->id_post=$post->id;
						$postH->save();
						//var_dump($postH->getErrors());
						//$wtf[]=$postH->attributes;
						break;
					}//else{
					//	echo'Уже занят';
					//
					
				}
			}
			//$x++;
			//if ($x>20)
			//	break;

		}
		//PersonnelPostsHistory::model()->updateAll(array( 'date_end' => NULL ), 'date_end = \'01.01.1970\'');

 		//return $zfcac;
 		//return $wtf;
 		echo 'Синхронизация завершена';
 	}



}