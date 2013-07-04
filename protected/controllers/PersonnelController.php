<?php
//Yii::import('application.vendors.*');
//require_once('phpExcelReader/reader.php');



class PersonnelController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','import','ajaxPost','ajaxPostAdm'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionajaxPost(){
		$id = Yii::app()->request->getPost('id');
       	$model=new PersonnelPostsHistory;
        $this->renderPartial('_form_post_hist', array('model'=>$model,'id'=>$id), false, true);
	}

	public function actionajaxPostAdm(){
		$id = Yii::app()->request->getPost('id');
		$dataprov=new CActiveDataProvider('PersonnelPostsHistory', array(
    'criteria'=>array(
        'condition'=>'id_personnel='.$id,
    ),));

        $this->renderPartial('admin_post_hist', array('models'=>$dataprov,'id'=>$id), false, true);
	}



	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Personnel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Personnel']))
		{
			$model->attributes=$_POST['Personnel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Personnel']))
		{
			$model->attributes=$_POST['Personnel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionImport()
	{
		//$model=$this->loadModel();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		//var_dump ( $_POST );
		
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
						//и выведем значения
						$val = $cell->getCalculatedValue();
						if(PHPExcel_Shared_Date::isDateTime($cell)) {
     						$val = date('d.m.Y', PHPExcel_Shared_Date::ExcelToPHP($val)); 
						}
						if ($i==0){
							$fio=explode(' ', $val);
							$pers['surname']=$fio[0];
       						$pers['name']=$fio[1];
       						$pers['patr']=$fio[2];
							$val=$fio[0]+$fio[1]+$fio[2];
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
       			$newpers->save();
       		}
       		
		} 

		$this->render('import',array('bfg'=>$bfg));

	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

		$model=new Personnel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Personnel']))
		$model->attributes=$_GET['Personnel'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Personnel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Personnel']))
			$model->attributes=$_GET['Personnel'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Personnel the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Personnel::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Personnel $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='personnel-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
