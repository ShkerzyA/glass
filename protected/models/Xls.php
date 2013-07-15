<?php

/**
 * This is the model class for table "sex".
 *
 * The followings are the available columns in table 'sex':
 * @property integer $id
 * @property string $name
 */
class Xls extends CFormModel{
	public $xls;
 
    public function rules(){
        return array(
            array('xls', 'file'),
        );
    } 

    public function import_Personnel(){
    	if(isset($_POST['Xls'])){
			$modelxls=new Xls();
			$modelxls->attributes=$_POST['Xls'];
            $modelxls->xls=CUploadedFile::getInstance($modelxls,'xls');
            try {
            	$modelxls->xls->saveAs(Yii::getPathOfAlias('webroot.media').DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'import.xls');
			} catch (Exception $e) {
    			echo 'Не удалось загрузить файл';
			}	

			$phpExcelPath = Yii::getPathOfAlias('ext.PHPExcel.Classes');
			spl_autoload_unregister(array('YiiBase','autoload'));

			include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
			include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel/IOFactory.php');
    		$objPHPExcel=PHPExcel_IOFactory::load(Yii::getPathOfAlias('webroot.media').DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'import.xls');
    		$objPHPExcel->setActiveSheetIndex(0);
			$aSheet = $objPHPExcel->getActiveSheet();
			$bfg='';
			$bfg.='<table cellpadding="0" cellspacing="0">';
			//получим итератор строки и пройдемся по нему циклом

			$mass_pers=array();
			foreach($aSheet->getRowIterator() as $row){

				$pers=array();
				$bfg.="<tr>\r\n";
				//получим итератор ячеек текущей строки
				$cellIterator = $row->getCellIterator();
				//пройдемся циклом по ячейкам строки
					$i=0;
					foreach($cellIterator as $cell){

						switch ($i) {
							case '1':
								$val = $cell->getCalculatedValue();
								$pers['surname']=$val;
								break;
							case '2':
								$val = $cell->getCalculatedValue();
       							$pers['name']=$val;
								break;
							case '3':
								$val = $cell->getCalculatedValue();
       							$pers['patr']=$val;
								break;
							case '4':
								$val = date('d.m.Y', PHPExcel_Shared_Date::ExcelToPHP($val)); 
								$pers['birthday']=$val;
								break;
							case '5':
								$val = date('d.m.Y', PHPExcel_Shared_Date::ExcelToPHP($val)); 
								$pers['date_begin']=$val;
								break;
							case '6':
								$val = date('d.m.Y', PHPExcel_Shared_Date::ExcelToPHP($val)); 
								$pers['date_end']=$val;
								break;
							default:
								break;
						}


						$bfg.="<td>".$val."</td>";
						$i++;
				}
				$mass_pers[]=$pers;	
				$bfg.="<tr>\r\n";
			}
			$bfg.='</table>';
       		spl_autoload_register(array('YiiBase','autoload'));

       		foreach ($mass_pers as $pers) {
       			$newpers=new Personnel();
       			$newpers->surname=$pers['surname'];
       			$newpers->name=$pers['name'];
       			$newpers->patr=$pers['patr'];
       			$newpers->birthday=$pers['birthday'];
       			$newpers->date_begin=$pers['date_begin'];
       			$newpers->date_end=$pers['date_end'];
       			$newpers->save();
       		}
       		return $bfg;
		} 

    }

        public function import_Department(){
    	if(isset($_POST['Xls'])){
			$modelxls=new Xls();
			$modelxls->attributes=$_POST['Xls'];
            $modelxls->xls=CUploadedFile::getInstance($modelxls,'xls');
            try {
            	$modelxls->xls->saveAs(Yii::getPathOfAlias('webroot.media').DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'import.xls');
			} catch (Exception $e) {
    			echo 'Не удалось загрузить файл';
			}	

			$phpExcelPath = Yii::getPathOfAlias('ext.PHPExcel.Classes');
			spl_autoload_unregister(array('YiiBase','autoload'));

			include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
			include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel/IOFactory.php');
    		$objPHPExcel=PHPExcel_IOFactory::load(Yii::getPathOfAlias('webroot.media').DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'import.xls');
    		$objPHPExcel->setActiveSheetIndex(0);
			$aSheet = $objPHPExcel->getActiveSheet();
			//получим итератор строки и пройдемся по нему циклом
			$depNames=array();

			foreach($aSheet->getRowIterator() as $row){

				
				//получим итератор ячеек текущей строки
				$cellIterator = $row->getCellIterator();
				$i=0;
					foreach($cellIterator as $cell){
					if ($i==5)
						$depNames[]=$cell->getCalculatedValue();
					//	if(PHPExcel_Shared_Date::isDateTime($cell)) {
     				//		$val = date('d.m.Y', PHPExcel_Shared_Date::ExcelToPHP($val)); 
					$i++;	
					}
					
				}

			spl_autoload_register(array('YiiBase','autoload'));
       		//тут буду сохранять в модель подразделения

       		$depNamesU=array_unique($depNames);
       		foreach ($depNamesU as $v) {
       			$dep=new Department();
       			$dep->name=$v;
       			$dep->date_begin='11.11.1954';
       			$dep->id_parent=NULL;
       			$dep->save();
       		}

       		
       		return implode("\n <br>", $depNamesU);
			}

       		
       		
		} 

		public function import_DepartmentPosts(){
    	if(isset($_POST['Xls'])){
			$modelxls=new Xls();
			$modelxls->attributes=$_POST['Xls'];
            $modelxls->xls=CUploadedFile::getInstance($modelxls,'xls');
            try {
            	$modelxls->xls->saveAs(Yii::getPathOfAlias('webroot.media').DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'import.xls');
			} catch (Exception $e) {
    			echo 'Не удалось загрузить файл';
			}	

			$phpExcelPath = Yii::getPathOfAlias('ext.PHPExcel.Classes');
			spl_autoload_unregister(array('YiiBase','autoload'));

			include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
			include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel/IOFactory.php');
    		$objPHPExcel=PHPExcel_IOFactory::load(Yii::getPathOfAlias('webroot.media').DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'import.xls');
    		$objPHPExcel->setActiveSheetIndex(0);
			$aSheet = $objPHPExcel->getActiveSheet();
			//получим итератор строки и пройдемся по нему циклом
			$depPosts=array();

			foreach($aSheet->getRowIterator() as $row){

				
				//получим итератор ячеек текущей строки
				$post=array();

				$cellIterator = $row->getCellIterator();
				$i=0;
					foreach($cellIterator as $cell){

						switch($i){
							case'0':
								$post['kod_parus']=$cell->getCalculatedValue();
							break;
							case'1':
								$post['post_name']=$cell;
							break;
							case'5':
								$post['department']=$cell;
							break;
						}
				 
					$i++;	
					}
					$depPosts[]=$post;
					
				}

			spl_autoload_register(array('YiiBase','autoload'));
       		//тут буду сохранять в модель подразделения

			
       		foreach ($depPosts as $v) {

       			$dep=Department::model()->find(array('condition'=>'name=:name','params'=>array(":name"=>$v['department'])));

       			$depPost=new DepartmentPosts();
       			$depPost->post=$v['post_name'];
       			$depPost->kod_parus=$v['kod_parus'];
       			$depPost->date_begin='11.11.1954';

       			$depPost->id_department=$dep->id;
       			$depPost->save();
       		}
       		

       		
       		return implode("\n <br>", $depPosts);
			}

       		
       		
		} 

		public function import_PersonnelPostsHistory(){
    	if(isset($_POST['Xls'])){
			$modelxls=new Xls();
			$modelxls->attributes=$_POST['Xls'];
            $modelxls->xls=CUploadedFile::getInstance($modelxls,'xls');
            try {
            	$modelxls->xls->saveAs(Yii::getPathOfAlias('webroot.media').DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'import.xls');
			} catch (Exception $e) {
    			echo 'Не удалось загрузить файл';
			}	

			$phpExcelPath = Yii::getPathOfAlias('ext.PHPExcel.Classes');
			spl_autoload_unregister(array('YiiBase','autoload'));

			include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
			include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel/IOFactory.php');
    		$objPHPExcel=PHPExcel_IOFactory::load(Yii::getPathOfAlias('webroot.media').DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'import.xls');
    		$objPHPExcel->setActiveSheetIndex(0);
			$aSheet = $objPHPExcel->getActiveSheet();
			//получим итератор строки и пройдемся по нему циклом
			$personnelPostsHistory=array();

			foreach($aSheet->getRowIterator() as $row){

				
				//получим итератор ячеек текущей строки
				$post=array();

				$cellIterator = $row->getCellIterator();
				$i=0;
					foreach($cellIterator as $cell){

						switch($i){
							case'0':
								$post['surname']=$cell;
							break;
							case'1':
								$post['name']=$cell;
							break;
							case'2':
								$post['patr']=$cell;
							break;
							case'3':
								$post['kod_parus']=$cell->getCalculatedValue();
							break;
							default:
							break;
						}
				 
					$i++;	
					}
					$personnelPostsHistory[]=$post;
					
				}

			spl_autoload_register(array('YiiBase','autoload'));
       		//тут буду сохранять в модель подразделения

			
       		foreach ($personnelPostsHistory as $v) {

       			$pers=Personnel::model()->find(array('condition'=>'name=:name and surname=:surname and patr=:patr','params'=>array(":name"=>$v['name'],":surname"=>$v['surname'],":patr"=>$v['patr'],)));
				$post=DepartmentPosts::model()->find(array('condition'=>'kod_parus=:kod_parus','params'=>array(":kod_parus"=>$v['kod_parus'])));


       			$ppH=new PersonnelPostsHistory();

       			$ppH->date_begin='11.11.1954';
       			$ppH->id_post=$post->id;
       			$ppH->id_personnel=$pers->id;
       			$ppH->save();
       		}
       		

       		
       		return implode("\n <br>", $personnelPostsHistory);
			}

       		
       		
		} 

 

}