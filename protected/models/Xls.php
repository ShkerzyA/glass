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


    public function exportLogCart($data){

		$tpl=Yii::getPathOfAlias('webroot').'/tpl';
		$media=Yii::getPathOfAlias('webroot.media');
    	$phpExcelPath = Yii::getPathOfAlias('ext.PHPExcel.Classes');
		spl_autoload_unregister(array('YiiBase','autoload'));
		include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
		include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel/IOFactory.php');
		include($phpExcelPath . DIRECTORY_SEPARATOR . 'chunkReadFilter.php');

			//$type=Equipment::getType();
			//$producer=Equipment::getProducer();
			$status=Equipment::getStatus();

			$PHPExcel = PHPExcel_IOFactory::load($tpl.'/cart_tpl.xls');
			$PHPExcel->getProperties()
	    	->setCreator("ebdp")
	    	->setLastModifiedBy("ebdp")
	    	->setTitle('Office 2003 XLS Document')
	    	->setSubject('Office 2003 XLS Document')
	    	->setDescription('Document for Office 2003 XLS, generated using PHP classes.')
	    	->setKeywords('office 2003 openxml php')
	    	->setCategory('Nodes export result file');

			$i=3; //Начинаем с 3 строки
			foreach ($data as $row) {

		
	
	$PHPExcel->getActiveSheet()->setCellValue("A$i",$row['timestamp']); 
	$PHPExcel->getActiveSheet()->setCellValue("B$i",$row['fio']);
	$PHPExcel->getActiveSheet()->setCellValue("C$i",$row['place']); 
	$PHPExcel->getActiveSheet()->setCellValue("D$i",$row['printer']); 
	$PHPExcel->getActiveSheet()->setCellValue("E$i",$row['printerSN']);
	$PHPExcel->getActiveSheet()->setCellValue("F$i",$row['num_st']);
	$PHPExcel->getActiveSheet()->setCellValue("G$i",$out_cart=(!empty($row['out_cart_inv'])?$row['out_cart_inv']:''));
	$PHPExcel->getActiveSheet()->setCellValue("H$i",$out_cart=(!empty($row['out_cart_mark'])?$row['out_cart_mark']:''));
	$PHPExcel->getActiveSheet()->setCellValue("I$i",$row['in_cart_inv']);
	$PHPExcel->getActiveSheet()->setCellValue("J$i",$row['in_cart_mark']);
	/*$PHPExcel->getActiveSheet()->setCellValue("I$i",$row->idWorkplace->idCabinet->idFloor->idBuilding->bname);
	$PHPExcel->getActiveSheet()->setCellValue("J$i",$row->idWorkplace->idCabinet->idFloor->fname);
	$PHPExcel->getActiveSheet()->setCellValue("K$i",$row->idWorkplace->idCabinet->num.' '.$row->idWorkplace->idCabinet->cname); */
	/*
	//$PHPExcel->getActiveSheet()->setCellValue("H$i",$row->name_research);
	$PHPExcel->getActiveSheet()->setCellValue("I$i",$row->birthday);
	$PHPExcel->getActiveSheet()->setCellValue("J$i",$row->fio_sender);
	$PHPExcel->getActiveSheet()->setCellValue("K$i",$row->conclusion);
	$PHPExcel->getActiveSheet()->setCellValue("L$i",$row->eed);
	$PHPExcel->getActiveSheet()->setCellValue("M$i",$row->number_downtime);
	$PHPExcel->getActiveSheet()->setCellValue("N$i",$row->reason_downtime);
	$PHPExcel->getActiveSheet()->setCellValue("O$i",$row->measures_taken); */

				/*$PHPExcel->getActiveSheet()->setCellValue("B$i",$row['CREATE_DATE']);
				$PHPExcel->getActiveSheet()->setCellValue("C$i",$row['SENT_DOC']);
				$PHPExcel->getActiveSheet()->setCellValue("D$i",$row['SURNAME'].' '.$row['NAME'].' '.$row['PATR']);
				$PHPExcel->getActiveSheet()->setCellValue("E$i",$row['AREA'].' '.$row['RAION'].' '.$row['CITY'].' ул.'.$row['STREET'].' д.'.$row['HOME'].' кв.'.$row['APART']);

				$PHPExcel->getActiveSheet()->setCellValue("F$i",$row['BIRTHDAY']);
				$PHPExcel->getActiveSheet()->setCellValue("G$i",$sex[$row['SEX']]);
				$PHPExcel->getActiveSheet()->setCellValue("I$i",$row['mkb10'].' '.$row['DIAG']);
				$PHPExcel->getActiveSheet()->setCellValue("O$i",$row['DRUG'].' '.$row['BENEFIT']); */

				$i++;
			
			}

			$bordercells=array(
						'borders' => array(
      							'allborders' => array(
        							'style' => PHPExcel_Style_Border::BORDER_THIN,
      							),
    					),
    					'alignment' => array(
      							'wrap'=>true,
      							'horizontal' 	=> PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
								'vertical'   	=> PHPExcel_Style_Alignment::VERTICAL_TOP,
      					),
      					'font' => array(
								'name'      	=> 'Times New Roman',
      					));


			$PHPExcel->getActiveSheet()->getStyle('A3:'.'O'.$i)->applyFromArray($bordercells);
			$name='v';
   			 
   			$PHPExcel->getActiveSheet()->setTitle($name);
   			$PHPExcel->setActiveSheetIndex(0);
   			$filename = 'export.xls';
   			 //$path = file_create_filename($filename, 'public://nodes_export');
  			$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
  			$objWriter->save($media.'/'.$filename);
  			header("Location: ".Yii::app()->baseUrl."/media/$filename"); 

    }

    public function exportEq($data){

		$tpl=Yii::getPathOfAlias('webroot').'/tpl';
		$media=Yii::getPathOfAlias('webroot.media');
    	$phpExcelPath = Yii::getPathOfAlias('ext.PHPExcel.Classes');
		spl_autoload_unregister(array('YiiBase','autoload'));
		include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
		include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel/IOFactory.php');
		include($phpExcelPath . DIRECTORY_SEPARATOR . 'chunkReadFilter.php');

			//$type=Equipment::getType();
			//$producer=Equipment::getProducer();
			$status=Equipment::getStatus();

			$PHPExcel = PHPExcel_IOFactory::load($tpl.'/eq_tpl.xls');
			$PHPExcel->getProperties()
	    	->setCreator("ebdp")
	    	->setLastModifiedBy("ebdp")
	    	->setTitle('Office 2003 XLS Document')
	    	->setSubject('Office 2003 XLS Document')
	    	->setDescription('Document for Office 2003 XLS, generated using PHP classes.')
	    	->setKeywords('office 2003 openxml php')
	    	->setCategory('Nodes export result file');

			$i=3; //Начинаем с 3 строки
			foreach ($data as $row) {

		
	$PHPExcel->getActiveSheet()->setCellValue("A$i",$row->serial); 
	$PHPExcel->getActiveSheet()->setCellValue("B$i",$row->type0->name);
	$PHPExcel->getActiveSheet()->setCellValue("C$i",$producer=(!empty($row->producer))?$row->producer0->name:'');
	$PHPExcel->getActiveSheet()->setCellValue("D$i",$row->mark);
	$PHPExcel->getActiveSheet()->setCellValue("E$i",$row->inv);
	$PHPExcel->getActiveSheet()->setCellValue("F$i",$status[$row->status]);
	$PHPExcel->getActiveSheet()->setCellValue("G$i",$row->notes);
	//$PHPExcel->getActiveSheet()->setCellValue("H$i",$row->idWorkplace->idPersonnel->surname.' '.$row->idWorkplace->idPersonnel->name.' '.$row->idWorkplace->idPersonnel->patr);
	if(!empty($row->idWorkplace))
		$PHPExcel->getActiveSheet()->setCellValue("H$i",$row->idWorkplace->wpName());
	$PHPExcel->getActiveSheet()->setCellValue("I$i",$row->idWorkplace->idCabinet->idFloor->idBuilding->bname);
	$PHPExcel->getActiveSheet()->setCellValue("J$i",$row->idWorkplace->idCabinet->idFloor->fname);
	$PHPExcel->getActiveSheet()->setCellValue("K$i",$row->idWorkplace->idCabinet->num.' '.$row->idWorkplace->idCabinet->cname);
	/*
	//$PHPExcel->getActiveSheet()->setCellValue("H$i",$row->name_research);
	$PHPExcel->getActiveSheet()->setCellValue("I$i",$row->birthday);
	$PHPExcel->getActiveSheet()->setCellValue("J$i",$row->fio_sender);
	$PHPExcel->getActiveSheet()->setCellValue("K$i",$row->conclusion);
	$PHPExcel->getActiveSheet()->setCellValue("L$i",$row->eed);
	$PHPExcel->getActiveSheet()->setCellValue("M$i",$row->number_downtime);
	$PHPExcel->getActiveSheet()->setCellValue("N$i",$row->reason_downtime);
	$PHPExcel->getActiveSheet()->setCellValue("O$i",$row->measures_taken); */

				/*$PHPExcel->getActiveSheet()->setCellValue("B$i",$row['CREATE_DATE']);
				$PHPExcel->getActiveSheet()->setCellValue("C$i",$row['SENT_DOC']);
				$PHPExcel->getActiveSheet()->setCellValue("D$i",$row['SURNAME'].' '.$row['NAME'].' '.$row['PATR']);
				$PHPExcel->getActiveSheet()->setCellValue("E$i",$row['AREA'].' '.$row['RAION'].' '.$row['CITY'].' ул.'.$row['STREET'].' д.'.$row['HOME'].' кв.'.$row['APART']);

				$PHPExcel->getActiveSheet()->setCellValue("F$i",$row['BIRTHDAY']);
				$PHPExcel->getActiveSheet()->setCellValue("G$i",$sex[$row['SEX']]);
				$PHPExcel->getActiveSheet()->setCellValue("I$i",$row['mkb10'].' '.$row['DIAG']);
				$PHPExcel->getActiveSheet()->setCellValue("O$i",$row['DRUG'].' '.$row['BENEFIT']); */

				$i++;
			
			}

			$bordercells=array(
						'borders' => array(
      							'allborders' => array(
        							'style' => PHPExcel_Style_Border::BORDER_THIN,
      							),
    					),
    					'alignment' => array(
      							'wrap'=>true,
      							'horizontal' 	=> PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
								'vertical'   	=> PHPExcel_Style_Alignment::VERTICAL_TOP,
      					),
      					'font' => array(
								'name'      	=> 'Times New Roman',
      					));


			$PHPExcel->getActiveSheet()->getStyle('A3:'.'O'.$i)->applyFromArray($bordercells);
			$name='v';
   			 
   			$PHPExcel->getActiveSheet()->setTitle($name);
   			$PHPExcel->setActiveSheetIndex(0);
   			$filename = 'export.xls';
   			 //$path = file_create_filename($filename, 'public://nodes_export');
  			$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
  			$objWriter->save($media.'/'.$filename);
  			header("Location: ".Yii::app()->baseUrl."/media/$filename"); 

    }


    public function exportMedEq($data){

		$tpl=Yii::getPathOfAlias('webroot').'/tpl';
		$media=Yii::getPathOfAlias('webroot.media');
    	$phpExcelPath = Yii::getPathOfAlias('ext.PHPExcel.Classes');
		spl_autoload_unregister(array('YiiBase','autoload'));
		include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
		include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel/IOFactory.php');
		include($phpExcelPath . DIRECTORY_SEPARATOR . 'chunkReadFilter.php');

			$PHPExcel = PHPExcel_IOFactory::load($tpl.'/med_eq_tpl.xls');
			$PHPExcel->getProperties()
	    	->setCreator("ebdp")
	    	->setLastModifiedBy("ebdp")
	    	->setTitle('Office 2003 XLS Document')
	    	->setSubject('Office 2003 XLS Document')
	    	->setDescription('Document for Office 2003 XLS, generated using PHP classes.')
	    	->setKeywords('office 2003 openxml php')
	    	->setCategory('Nodes export result file');

			$i=3; //Начинаем с 3 строки
			foreach ($data as $row) {
		
	$PHPExcel->getActiveSheet()->setCellValue("A$i",$row->date);
	$PHPExcel->getActiveSheet()->setCellValue("B$i",$row->cnum);
	$PHPExcel->getActiveSheet()->setCellValue("C$i",$row->name);
	$PHPExcel->getActiveSheet()->setCellValue("D$i",$row->date_exp);
	$PHPExcel->getActiveSheet()->setCellValue("E$i",$row->number_research);
	$PHPExcel->getActiveSheet()->setCellValue("F$i",$row->name_research);
	$PHPExcel->getActiveSheet()->setCellValue("G$i",$row->fio_pac);
	$PHPExcel->getActiveSheet()->setCellValue("H$i",$row->diag);
	$PHPExcel->getActiveSheet()->setCellValue("I$i",$row->birthday);
	$PHPExcel->getActiveSheet()->setCellValue("J$i",$row->fio_sender);
	$PHPExcel->getActiveSheet()->setCellValue("K$i",$row->conclusion);
	$PHPExcel->getActiveSheet()->setCellValue("L$i",$row->eed);
	$PHPExcel->getActiveSheet()->setCellValue("M$i",$row->number_downtime);
	$PHPExcel->getActiveSheet()->setCellValue("N$i",$row->reason_downtime);
	$PHPExcel->getActiveSheet()->setCellValue("O$i",$row->measures_taken);

				/*$PHPExcel->getActiveSheet()->setCellValue("B$i",$row['CREATE_DATE']);
				$PHPExcel->getActiveSheet()->setCellValue("C$i",$row['SENT_DOC']);
				$PHPExcel->getActiveSheet()->setCellValue("D$i",$row['SURNAME'].' '.$row['NAME'].' '.$row['PATR']);
				$PHPExcel->getActiveSheet()->setCellValue("E$i",$row['AREA'].' '.$row['RAION'].' '.$row['CITY'].' ул.'.$row['STREET'].' д.'.$row['HOME'].' кв.'.$row['APART']);

				$PHPExcel->getActiveSheet()->setCellValue("F$i",$row['BIRTHDAY']);
				$PHPExcel->getActiveSheet()->setCellValue("G$i",$sex[$row['SEX']]);
				$PHPExcel->getActiveSheet()->setCellValue("I$i",$row['mkb10'].' '.$row['DIAG']);
				$PHPExcel->getActiveSheet()->setCellValue("O$i",$row['DRUG'].' '.$row['BENEFIT']); */

				$i++;
			}
		//	$PHPExcel->getActiveSheet()->getStyle('A4:'.'O'.$i)->applyFromArray($this->style['bordercells']);
			$name='v';
   			 
   			$PHPExcel->getActiveSheet()->setTitle($name);
   			$PHPExcel->setActiveSheetIndex(0);
   			$filename = 'export.xls';
   			 //$path = file_create_filename($filename, 'public://nodes_export');
  			$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
  			$objWriter->save($media.'/'.$filename);
  			header("Location: ".Yii::app()->baseUrl."/media/$filename"); 

    }

    public function load($table){

    	$file=Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'base'.DIRECTORY_SEPARATOR.$table;

    	$chunkSize = 2000;		//размер считываемых строк за раз
		$startRow = 1;			//начинаем читать со строки 2, в PHPExcel первая строка имеет индекс 1, и как правило это строка заголовков
		$exit = false;			//флаг выхода
		$empty_value = 0;
		

    	$phpExcelPath = Yii::getPathOfAlias('ext.PHPExcel.Classes');
		spl_autoload_unregister(array('YiiBase','autoload'));
		include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
		include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel/IOFactory.php');
		include($phpExcelPath . DIRECTORY_SEPARATOR . 'chunkReadFilter.php');

		if (!file_exists($file)) {
 		   exit();
		}

		$objReader = PHPExcel_IOFactory::createReaderForFile($file);
		$objReader->setReadDataOnly(true);

		$chunkFilter = new chunkReadFilter(); 
		$objReader->setReadFilter($chunkFilter); 
		//внешний цикл, пока файл не кончится
		$foo=1;
		while ( !$exit ) 
		{
   			$chunkFilter->setRows($startRow,$chunkSize); 	//устанавливаем знаечние фильтра
    		$objPHPExcel = $objReader->load($file);		//открываем файл
    		$objPHPExcel->setActiveSheetIndex(0);		//устанавливаем индекс активной страницы
    		$objWorksheet = $objPHPExcel->getActiveSheet();	//делаем активной нужную страницу

    		$empty_value=0;
    		for ($i = $startRow; $i < $startRow + $chunkSize; $i++) 	//внутренний цикл по строкам
    		{	
    			
    			$row = $objPHPExcel->getActiveSheet()->getRowIterator($i)->current();
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(false);

				//print_r($cellIterator);

	//			echo iconv('UTF-8','cp1251',$cellIterator[0]->getValue()).' | ' ;

				echo $foo.' | ';
				$foo++;
				$num_col=1;
				foreach ($cellIterator as $cell) {
					if ($num_col==1){
						if(empty(trim($cell->getValue()))){
							//echo 'пустое значение';
						   	$empty_value++;		
						}
					}
    				echo iconv('UTF-8','cp1251',$cell->getValue()).' | ' ;
    				//echo $cell->getValue();
        			$num_col++;
				}
				if ($empty_value > 2){			//после трех пустых значений, завершаем обработку файла, думая, что это конец
           		 		$exit = true;	
            			break;		
        		}
				echo '<br>';
    			/*
        		$value = trim(htmlspecialchars($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));		//получаем первое знаение в строке
        		if ( empty($value) )		//проверяем значение на пустоту
            	$empty_value++;			
        		if ($empty_value == 3)		//после трех пустых значений, завершаем обработку файла, думая, что это конец
        		{	
           		 	$exit = true;	
            		continue;		
        		}	*/

        		//echo $foo.iconv('UTF-8','cp1251',$value).'<br>';
        		
        		/*Манипуляции с данными каким Вам угодно способом, в PHPExcel их превеликое множество*/
    		}
    		$objPHPExcel->disconnectWorksheets(); 				//чистим 
    		unset($objPHPExcel); 						//память
    		$startRow += $chunkSize;					//переходим на следующий шаг цикла, увеличивая строку, с которой будем читать файл
		}
    	/*
    	$phpExcelPath = Yii::getPathOfAlias('ext.PHPExcel.Classes');
		spl_autoload_unregister(array('YiiBase','autoload'));
		include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
		include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel/IOFactory.php');
		/*
    	$objPHPExcel=PHPExcel_IOFactory::load(Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'base'.DIRECTORY_SEPARATOR.$table);
    	$objPHPExcel->setReadDataOnly(true);
    	$objPHPExcel->setActiveSheetIndex(0);
		$aSheet = $objPHPExcel->getActiveSheet();
		foreach($aSheet->getRowIterator() as $row){
			$cellIterator = $row->getCellIterator();
			foreach($cellIterator as $cell){
				$val = $cell->getCalculatedValue();
				if(PHPExcel_Shared_Date::isDateTime($cell)) {
					$val = date('d.m.Y', PHPExcel_Shared_Date::ExcelToPHP($val)); 
				}
				echo iconv('UTF-8','cp1251',$val);
			}
		}
		*/
		/*
		$inputFileName=Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'base'.DIRECTORY_SEPARATOR.$table;
		$inputFileType = PHPExcel_IOFactory::identify($inputFileName); // Определяем тип
		$objReader = PHPExcel_IOFactory::createReader($inputFileType); // Создаем ридер
		$objReader->setReadDataOnly(true); // Очень сильно влияет и на память и на время, это если нужны только данные... Плюс нужно смотреть ограничения...
		$worksheetNames = $objReader->listWorksheetNames($inputFileName); // Читаем имена страниц// Постранично читаем данные 
		foreach ($worksheetNames as $wsName) { 
			$objReader->setLoadSheetsOnly($wsName); 
			$oExcel = $objReader->load($inputFileName); 
			$oExcel->setActiveSheetIndexByName($wsName); 
			$aSheet = $oExcel->getActiveSheet(); 
			foreach ($aSheet->getRowIterator() as $rowId => $row) { 
				$cellIterator = $row->getCellIterator(); 
				$cellIterator->setIterateOnlyExistingCells(false); 
				foreach($cellIterator as $cellId=>$cell) { // здесь код... 
					echo $cellId.' '.$cell;
				} 
			}
		}
		*/

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

						$val = $cell->getCalculatedValue();
						if(PHPExcel_Shared_Date::isDateTime($cell)) {
							$val = date('d.m.Y', PHPExcel_Shared_Date::ExcelToPHP($val)); 
						}
						switch ($i) {
							case '1':
								//$val = $cell->getCalculatedValue();
								$pers['surname']=$val;
								break;
							case '2':
								//$val = $cell->getCalculatedValue();
       							$pers['name']=$val;
								break;
							case '3':
								//$val = $cell->getCalculatedValue();
       							$pers['patr']=$val;
								break;
							case '5':
								//$val = $cell->getCalculatedValue();
								//$val = date('d.m.Y', PHPExcel_Shared_Date::ExcelToPHP($val)); 
								$pers['birthday']=$val;
								break;
							case '6':
								$pers['date_begin']=$val;
								break;
							case '7':
								//$val = $cell->getCalculatedValue();
								//$val = date('d.m.Y', PHPExcel_Shared_Date::ExcelToPHP($val)); 
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