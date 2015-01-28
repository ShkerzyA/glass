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
 	private $pathToDb;

 	public function __construct(){
 		$this->pathToDb=$_SERVER['DOCUMENT_ROOT'].'/glass/base/';
 	}

 	public function read_table($tablename,$keycolumn=NULL,$charset=array('cp1251','UTF8')){
 		$result=array();
 		$this->dbase=dbase_open($this->pathToDb.$tablename,0);
 		for($i=1;$i<=dbase_numrecords($this->dbase);$i++){
 			$row=dbase_get_record_with_names($this->dbase,$i);

 			if(!empty($charset)){
 				foreach ($row as &$v){
 					$v=iconv($charset[0],$charset[1], $v);	
 				}
 			}

 			foreach ($row as &$v){
 				$v=trim($v);
 			}

 			if(!empty($keycolumn)){
 				$result[trim($row[$keycolumn])]=$row;
 			}else{
 				$result[]=$row;
 			}

 		}
 		dbase_close($this->dbase);
 		return $result;
 	}


 	public function readMuDbf(){
 		//$x='60';
 		$mu=$this->read_table('MU.dbf','IDMU',array('cp866','UTF8'));
 		//$mu=array_filter($mu, function($var) use ($x){return ($var['IDOFFICE']==$x);});


 		$mu0=$this->read_table('_MU0.dbf','IDMU',array('cp866','UTF8'));
 		return array('mu'=>$mu,'mu0'=>$mu0);
 	}


 	public function otdelImport(){

 		$acatalog=$this->read_table('ACATALOG.DBF','N1');
 		$zSubDiv=$this->read_table('zsubdiv.dbf','CATALOG_RN');
		
		//$acatalog=array_filter($acatalog, function($var){return ($var['UNIT_RN']=="001g");});

 		//print_r ($zSubDiv);
		//print_r ($acatalog);
		//print_r ($zSubDiv);

		
		foreach ($zSubDiv as &$v){
			$v['cataloginfo']=$acatalog[$v['CATALOG_RN']];
			//002c это корневой каталог. Его нет в отделениях
			if(array_key_exists(trim($v['cataloginfo']['N2']),$zSubDiv))
				$v['PARENTPARENT']=$zSubDiv[trim($v['cataloginfo']['N2'])]['SUBDIV_RN'];
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
			if(!empty($v['PARENTPARENT']))
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
				if(empty($v['PASSPORT_R'])){
					//$pers=Personnel::model()->deleteAll(array('condition'=>'orbase_rn=:orbase_rn','params'=>array(":orbase_rn"=>$v['ORBASE_RN'])));
					continue;
				}
					

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

 		//DepartmentPosts::model()->deleteAll();
 		DepartmentPosts::model()->updateAll(array('upd_flag' => NULL));
 	
 		$posts=$this->read_table('ZPOST.DBF','POST_RN');
 		$zpostch=$this->read_table('ZPOSTCH.DBF');
 		$ztipdol=$this->read_table('zTipDol.DBF','TIPDOL_RN');

		foreach ($posts as &$v) {
			$t=$v['POST_RN'];
			$v['zpostch']=array_filter($zpostch, function($var) use ($t){return ($var['POSTBS_RN']===$t);});
			$v['ztipdol']=$ztipdol[$v['TIPDOL_RN']];
		}

		foreach ($posts as $v) {
			echo $v['POST_RN'].'<br>';
			foreach ($v['zpostch'] as $z) {

						if($findPost=DepartmentPosts::model()->find(array('condition'=>'post_rn=:post_rn and upd_flag is NULL','params'=>array(":post_rn"=>$v['POST_RN'])))){
							$depPost=$findPost;
						}else{
							echo 'создана должность<br>';
							$depPost=new DepartmentPosts();
						}
       					$depPost->post=trim($v['ztipdol']['NAME']);
       					$depPost->post_rn=$v['POST_RN'];
       					$depPost->date_begin=substr($z['CHSTARTDAT'] , 6,2).'.'.substr($z['CHSTARTDAT'] , 4,2).'.'.substr($z['CHSTARTDAT'] ,0,4);
       					$depPost->date_end=substr($z['CHENDDATE'] , 6,2).'.'.substr($z['CHENDDATE'] , 4,2).'.'.substr($z['CHENDDATE'] ,0,4);
       					if($findDep=Department::model()->find(array('condition'=>'subdiv_rn=:subdiv_rn','params'=>array(":subdiv_rn"=>$v['SUBDIV_RN'])))){
       						$depPost->post_subdiv_rn=trim($v['SUBDIV_RN']);
       					}else{
       						$depPost->post_subdiv_rn='XXXX';
       					}
       					$depPost->upd_flag=1;
       					$depPost->rate=$z['STQNT'];
       					$depPost->save();
       					//var_dump($depPost->getErrors()); //вызывает задвоение	
			}
				
		}

		//DepartmentPosts::model()->updateAll(array('upd_flag' => NULL));
		DepartmentPosts::model()->updateAll(array( 'date_end' => NULL ), 'date_end = \'01.01.1970\'');

 		return $posts;

 	}

 	public function personnelPostsHistoryImport(){

 		//$wtf=array();
 		
 		$zfcac=$this->read_table('ZFCAC.DBF');
 		$zank=$this->read_table('zank.dbf','ANK_RN');

 		//к лицевым счетам прикрепляем анкетные данные
		foreach ($zfcac as &$v) {
			$x=$v['ANK_RN'];
			//echo($v['ANK_RN']).'<br>';
			$v['ank']=array_filter($zank, function($var) use ($x){return ($var['ANK_RN']===$x);});

		}
		unset($zank);
		$posts_tabl=$this->read_table('ZPOST.DBF','TIPDOL_RN');
		PersonnelPostsHistory::model()->deleteAll();

		//$g=0;
		foreach ($zfcac as $v) {
			/*$g++;
			if($g>100){
				break;
			}*/

			//echo '|'.$v['POST_RN'].'|<br>';
			//echo ($v['FCAC_RN'].'<br>');

			if(!empty(trim($v['POST_RN']))){
				$post=DepartmentPosts::model()->find(array('condition'=>'post_rn=:post_rn','params'=>array(":post_rn"=>$v['POST_RN'])));	
			}else if (array_key_exists($v['TIPDOL_RN'],$posts_tabl)){
				$post=DepartmentPosts::model()->find(array('condition'=>'post_rn=:post_rn','params'=>array(":post_rn"=>$posts_tabl[$v['TIPDOL_RN']]['POST_RN'])));
			}

			$date_begin=date('d.m.Y',strtotime(substr($v['STARTDATE'] , 6,2).'.'.substr($v['STARTDATE'] , 4,2).'.'.substr($v['STARTDATE'] ,0,4)));
			if(strripos($v['ENDDATE'],'8888')){
				$date_end=NULL;
			}else{
				$date_end=date('d.m.Y',strtotime(substr($v['ENDDATE'] , 6,2).'.'.substr($v['ENDDATE'] , 4,2).'.'.substr($v['ENDDATE'] ,0,4)));
				$date_end=($date_end!='01.01.1970')?$date_end:NULL;	
			}
			
			if(!empty($v['ank']))
			foreach ($v['ank'] as $z) {

				$pers=Personnel::model()->find(array('condition'=>'orbase_rn=:orbase_rn','params'=>array(":orbase_rn"=>trim($z['ORGBASE_RN']))));
				//echo $pers->surname.' | '.$z['ORGBASE_RN'].'<br>';
				$postH=new PersonnelPostsHistory();
				if(!empty($pers))
					$postH->id_personnel=$pers->id;
				$postH->is_main=$v['ISMAINISP'];
				$postH->date_begin=$date_begin;
				$postH->date_end=$date_end;
				if(!empty($post))
					$postH->id_post=$post->id;
				$postH->save();
				
			}
		}
		//PersonnelPostsHistory::model()->updateAll(array( 'date_end' => NULL ), 'date_end = \'01.01.1970\'');

 		//return $zfcac;
 		//return $wtf;
 		echo 'Синхронизация завершена';
 		
 	}



}