<?php
class PersProgramCommand extends CConsoleCommand
{
	public function actionFromXlsQms($filepath) {
		$xls=new Xls();
		$fileXls=$xls->load($filepath,True);
		//print_r($fileXls);
		$now=strtotime("now");
		foreach ($fileXls as $persArr) {
			if(!empty($persArr[3])){
				$fio=explode(' ',$persArr[3]);
				if(empty($fio[2]))
					continue;

				if ($persArr[7]!=1 or (!empty($persArr[6]) and ($now>strtotime($persArr[6]))))
					continue;
				//print_r($persArr);
				if($pers=Personnel::model()->find(array('condition'=>'t.surname=\''.$fio[0].'\' and t.name=\''.$fio[1].'\' and t.patr=\''.$fio[2].'\''))){
					$pp=new PersProgram;
					$pp->attributes=array('id_pers'=>$pers->id,'id_program'=>2,'login'=>$persArr[2]);
					if($pp->validate()){
						try{
							$pp->save();
						} catch (Exception $e) {
							echo ($persArr[3]." ".$e->getMessage()."\n\n");  
						}
					}
				}
			}
		}
		echo "\nend\n";
	}

	public function actionFromXlsQuickq($filepath) {
		$xls=new Xls();
		$fileXls=$xls->load($filepath,True);
		//print_r($fileXls);
		//die();
		foreach ($fileXls as $persArr) {
			if(empty($persArr[1]) or empty($persArr[2]) or empty($persArr[3]) ){
				continue;
			}
			if($pers=Personnel::model()->find(array('condition'=>'t.surname=\''.$persArr[1].'\' and t.name=\''.$persArr[2].'\' and t.patr=\''.$persArr[3].'\''))){
				$pp=new PersProgram;
				$pp->attributes=array('id_pers'=>$pers->id,'id_program'=>4,'login'=>$persArr[0]);
				if($pp->validate()){
					//print_r($pp->attributes);
					
					try{
						$pp->save();
					} catch (Exception $e) {
						echo ($persArr[2]." ".$e->getMessage()."\n\n");  
					}
					
				}
			}
			
		}
		echo "\nend\n";
	}

	public function actionFromJsonSpg($filepath) {
		$data=file_get_contents($filepath);
		$arr=json_decode($data);
		foreach ($arr->children as $spgUser) {
			$fio=explode(' ',$spgUser->fullName);
			if(empty($fio[2]))
				continue;
			if($pers=Personnel::model()->find(array('condition'=>'t.surname=\''.$fio[0].'\' and t.name=\''.$fio[1].'\' and t.patr=\''.$fio[2].'\''))){
				$pp=new PersProgram();
				$pp->attributes=array('id_pers'=>$pers->id,'id_program'=>3,'login'=>$spgUser->ID);
				if($pp->validate()){
					try {
						$pp->save();
					} catch (Exception $e) {
						echo ($spgUser->fullName." ".$e->getMessage()."\n\n");	
					}
				}
				
			}
		}
		echo "\nend\n";
	}
}
?>