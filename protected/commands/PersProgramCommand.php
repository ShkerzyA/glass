<?php
class PersProgramCommand extends CConsoleCommand
{
	public function actionFromXlsQms($filepath) {
		$xls=new Xls();
		$fileXls=$xls->load($filepath,True);
		//print_r($fileXls);
		foreach ($fileXls as $persArr) {
			if(!empty($persArr[2])){
				$fio=explode(' ',$persArr[2]);
				if($pers=Personnel::model()->find(array('condition'=>'t.surname=\''.$fio[0].'\' and t.name=\''.$fio[1].'\' and t.patr=\''.$fio[2].'\''))){
					$pp=new PersProgram;
					$pp->attributes=array('id_pers'=>$pers->id,'id_program'=>2,'login'=>$persArr[1]);
					if($pp->validate()){
						try{
							$pp->save();
						} catch (Exception $e) {
							echo ($persArr[2]." ".$e->getMessage()."\n\n");  
						}
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