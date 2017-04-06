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
	public $pdo;
	public $dbase;
 	private $pathToDb;

 	public function __construct(){
 		$this->pathToDb=$_SERVER['DOCUMENT_ROOT'].'/glass/base/';
 		$this->pdo=new PDO('pgsql:host=localhost;port=5432;dbname=parus', 'postgres', '123',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
 	}

 	/*
 	public function read_table($tablename,$keycolumn=NULL,$charset=array('cp1251','UTF8')){
 		$result=array();
 		$this->dbase=dbase_open($this->pathToDb.$tablename,0);
 		$num=dbase_numrecords($this->dbase);
 		for($i=1;$i<=$num;$i++){
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
 	} */


 	public function read_table($tablename,$keycolumn=NULL){
 		$result=array();
 		$sql="SELECT * FROM $tablename";
 		$sth=$this->pdo->query($sql);
        while($row=$sth->fetch(PDO :: FETCH_ASSOC)) {
     		if($keycolumn){
     			$result[$row[$keycolumn]]=$row;
     		}else{
     			$result[]=$row;
     		}
        }
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

 		$acatalog=$this->read_table('acatalog','rn');
 		$zSubDiv=$this->read_table('zsubdiv','catalog_rn');
		
		//$acatalog=array_filter($acatalog, function($var){return ($var['UNIT_RN']=="001g");});

 		//print_r ($zSubDiv);
		//print_r ($acatalog);
		//print_r ($zSubDiv);

		
		foreach ($zSubDiv as &$v){
			$v['cataloginfo']=$acatalog[$v['catalog_rn']];
			//002c это корневой каталог. Его нет в отделениях
			if(array_key_exists(trim($v['cataloginfo']['parent_rn']),$zSubDiv))
				$v['parentparent']=$zSubDiv[trim($v['cataloginfo']['parent_rn'])]['subdiv_rn'];
		}

		foreach ($zSubDiv as &$v) {

			$dep=Department::model()->find(array('condition'=>'subdiv_rn=:subdiv_rn','params'=>array(":subdiv_rn"=>$v['subdiv_rn'])));
			if(empty($dep)){
				$dep=new Department();	
			}
			$dep->name=trim($v['name']);
			$dep->date_begin=$v['startdate'];
            $dep->date_end=$v['enddate'];
			$dep->subdiv_rn=$v['subdiv_rn'];
			$dep->save();
		}
		
		foreach ($zSubDiv as &$v) {
			$dep=Department::model()->find(array('condition'=>'subdiv_rn=:subdiv_rn','params'=>array(":subdiv_rn"=>$v['subdiv_rn'])));
			if(!empty($v['parentparent']))
				$dep->parent_subdiv_rn=$v['parentparent'];
			$dep->save();
		}

		Department::model()->updateAll(array( 'date_end' => NULL ), 'date_end = \'01.01.1970\'');

 		return $zSubDiv; 
 	}


 	public function personnelImport(){
 		$personnel=$this->read_table('person','orbase_rn');
 		$zank=$this->read_table('zank','ank_rn');
 		$zempleav=$this->read_table('zempleav','empleav_rn');
		foreach ($personnel as &$z) {
			$x=$z['orbase_rn'];
			$z['ank']=array_filter($zank, function($var) use ($x){return ($var['orgbase_rn']==$x);});
			$z['empleav']=array_filter($zempleav, function($var) use ($x){return ($var['orgbase_rn']==$x);});
		}
		
		foreach ($personnel as $v) {
				if(empty($v['passport_r'])){
					//$pers=Personnel::model()->deleteAll(array('condition'=>'orbase_rn=:orbase_rn','params'=>array(":orbase_rn"=>$v['ORBASE_RN'])));
					continue;
				}
					

				if($pers=Personnel::model()->find(array('condition'=>'orbase_rn=:orbase_rn','params'=>array(":orbase_rn"=>$v['orbase_rn'])))){
					$newpers=$pers;
				}else{
					$newpers=new Personnel();
				}
       			$newpers->surname=trim($v['surname']);
       			$newpers->name=trim($v['firstname']);
       			$newpers->patr=trim($v['secondname']);
       			$newpers->birthday=date('Y-m-d',strtotime($v['birthday']));

       			$date_begin=array();
       			$date_end=array();

       			if (!empty($v['ank'])){
       				foreach ($v['ank'] as $q) {
       					$date_begin[]=new DateTime(date('Y-m-d',strtotime($q['jobbegin'])));
						$date_end[]=new DateTime(date('Y-m-d',strtotime($q['jobend'])));
       				}
       				$newpers->date_begin=min($date_begin)->format('Y-m-d');
       				$newpers->date_end=max($date_end)->format('Y-m-d');

       				$newpers->date_end=($newpers->date_end!='1970-01-01')?$newpers->date_end:NULL;
       			}
       			$newpers->orbase_rn=$v['orbase_rn'];
       			if(trim($v['sex'])=='М')
       				$newpers->sex=0;
       			else if(trim($v['sex'])=='Ж')
       				$newpers->sex=1;
       			$newpers->save();
       			//var_dump($depPost->getErrors()); //вызывает задвоение
		}
 		return $personnel; 
 	}

 	public function otdelPostsImport(){
 	
 		$posts=$this->read_table('zpost','post_rn');
 		$zpostch=$this->read_table('zpostch');
 		$ztipdol=$this->read_table('ztipdol','tipdol_rn');

		foreach ($posts as &$c) {
			$t=$c['post_rn'];
			$c['zpostch']=array_filter($zpostch, function($var) use ($t){return ($var['postbs_rn']===$t);});
			$c['ztipdol']=$ztipdol[$c['tipdol_rn']];
		}

		foreach ($posts as $v) {
			foreach ($v['zpostch'] as $z) {

						if($findPost=DepartmentPosts::model()->find(array('condition'=>'post_rn=:post_rn','params'=>array(":post_rn"=>$v['post_rn'])))){
							$depPost=$findPost;
						}else{
							//echo 'создана должность<br>';
							$depPost=new DepartmentPosts();
						}
       					$depPost->post=trim($v['ztipdol']['name']);
       					$depPost->post_rn=$v['post_rn'];
       					$depPost->date_begin=$z['chstartdat'];
       					$depPost->date_end=$z['chenddate'];
       					$depPost->date_end=($depPost->date_end=='8888-12-31')?'':$depPost->date_end;
       					if($findDep=Department::model()->find(array('condition'=>'subdiv_rn=:subdiv_rn','params'=>array(":subdiv_rn"=>$v['subdiv_rn'])))){
       						$depPost->post_subdiv_rn=trim($v['subdiv_rn']);
       					}else{
       						$depPost->post_subdiv_rn='XXXX';
       					}
       					$depPost->rate=$z['stqnt'];
       					$depPost->save();
			}
				
		}


 		return $posts;

 	}

 	public function personnelPostsHistoryImport(){

 		//$wtf=array();
 		$zfcac=$this->read_table('zfcac');
 		$zank=$this->read_table('zank','ank_rn');

 		//к лицевым счетам прикрепляем анкетные данные
		foreach ($zfcac as &$c) {
			$x=$c['ank_rn'];
			//echo($c['ANK_RN']).'<br>';
			$c['ank']=array_filter($zank, function($var) use ($x){return ($var['ank_rn']===$x);});

		}
		unset($zank);
		$posts_tabl=$this->read_table('zpost','tipdol_rn');
		PersonnelPostsHistory::model()->deleteAll();
		foreach ($zfcac as $v) {

			if(!empty(trim($v['post_rn']))){
				$post=DepartmentPosts::model()->find(array('condition'=>'post_rn=:post_rn','params'=>array(":post_rn"=>$v['post_rn'])));	
			}else if (array_key_exists($v['tipdol_rn'],$posts_tabl)){
				$post=DepartmentPosts::model()->find(array('condition'=>'post_rn=:post_rn','params'=>array(":post_rn"=>$posts_tabl[$v['tipdol_rn']]['post_rn'])));
			}

			$date_begin=(!empty($v['startdate']))?date('Y-m-d',strtotime($v['startdate'])):NULL;
			$date_end=($v['enddate']=='8888-12-31')?NULL:date('Y-m-d',strtotime($v['enddate']));

			if(!empty($v['ank']))
			foreach ($v['ank'] as $z) {

				$pers=Personnel::model()->find(array('condition'=>'orbase_rn=:orbase_rn','params'=>array(":orbase_rn"=>trim($z['orgbase_rn']))));
				//echo $pers->surname.' | '.$z['ORGBASE_RN'].'<br>';
				$postH=new PersonnelPostsHistory();
				if(!empty($pers))
					$postH->id_personnel=$pers->id;
				$postH->is_main=$v['ismainisp'];
				if(!empty($post))
					$postH->id_post=$post->id;
				$postH->date_begin=$date_begin;
				if(!empty($date_end))
					$postH->date_end=$date_end;

				$postH->save();
			}
		}
		//PersonnelPostsHistory::model()->updateAll(array( 'date_end' => NULL ), 'date_end = \'01.01.1970\'');

 		//return $zfcac;
 		//return $wtf;
 		echo 'Синхронизация завершена';
 		
 	}



}