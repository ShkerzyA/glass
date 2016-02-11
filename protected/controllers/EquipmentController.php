<?php

class EquipmentController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	private $preset=array(
		'default'=>array(
			array('type'=>'0'),
			array('type'=>'1'),
			array('type'=>'6'),
			array('type'=>'7'),
			),
		'HP'=>array(
			array('type'=>'0','producer'=>0,'mark'=>'HP PRO 3500 SERIES MT'),
			array('type'=>'1','producer'=>0,'mark'=>'PAVILION 23 XI'),
			array('type'=>'6','producer'=>10),
			array('type'=>'7'),
			),
		'cart'=>array(
			array('type'=>'18'),
			array('type'=>'18'),
			array('type'=>'18'),
			array('type'=>'18'),
			),
		);

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function access(){
		if(!(Yii::app()->user->checkAccess('inGroup',array('group'=>array('changeobjects')))))
            throw new CHttpException(403, 'У вас недостаточно прав');
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
				'actions'=>array('index','view','export','cartSearch','suggest','commonCartInfo'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','createPack','update','markSearch','delete','garant','ipmac','massUpd'),
				'roles'=>array('moderator'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'roles'=>array('administrator'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

public function actionCartSearch(){
		if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])) {
  		$models = Equipment::model()->findAll(array('condition'=>'t.inv=\''.$_GET['term'].'\''));
  		$result = array();
  		foreach ($models as $m)
   		$result[] = array(
     		'label' => $m->inv,
     		'value' => $m->inv,
     		'id' => $m->inv,
   		);
  		echo CJSON::encode($result);
 	}
}

	public function actionCommonCartInfo(){
		$this->layout='column1';
		$this->render('countCartFull',array('model'=>Equipment::countCart()));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionExport()
	{
		$this->access();
		$this->layout='//layouts/leaf';
		$model=new Equipment;
		$Xls=new Xls;
		$data=$model->search_for_export();
		$Xls->exportEq($data);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Equipment;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Equipment']))
		{
			$model->attributes=$_POST['Equipment'];
			if($model->save()){
				$log=new EquipmentLog;
				$log->saveLog('addEq',array('details'=>array($model->id_workplace),'object'=>$model->id));	
				$this->redirect(array('/Workplace/view','id'=>$model->id_workplace));
			}
				
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}


	public function actionCreatePack($preset='default')
	{
		$this->layout='//layouts/column1';
		$items[]=new Equipment;
		$items[]=new Equipment;
		$items[]=new Equipment;
		$items[]=new Equipment;

		$attr=$this->preset[$preset];

		$items[0]->attributes=$attr[0];
		$items[1]->attributes=$attr[1];
		$items[2]->attributes=$attr[2];
		$items[3]->attributes=$attr[3];

		foreach ($items as &$z) {
			$z->setMaxCartInv();
			# code...
		}

		//$items[4]->type=3;

		foreach ($items as &$it) {
			$it->id_workplace=$_GET['Equipment']['id_workplace'];
			//$it->id_workplace=23;
		}

    	if(isset($_POST['Equipment']))
    	{
       		$valid=true;
        	foreach($items as $i=>&$item)
        	{
            	if(isset($_POST['Equipment'][$i]))
                	$item->attributes=$_POST['Equipment'][$i];
            	$valid=$item->validate() && $valid;
        	}
        	$items=array_reverse($items);
        	if($valid){
        		foreach ($items as $item) {
        			if(!empty($item->mark))
        				if ($item->save()){
        					$log=new EquipmentLog;
							$log->saveLog('addEq',array('details'=>array($item->id_workplace),'object'=>$item->id));
        				}
        		}
        		$this->redirect(array('/Workplace/view','id'=>$items[0]->id_workplace));
        	}
    	}
    	// отображаем представление с формой для ввода табличных данных
    	$this->render('createPack',array('items'=>$items));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$model->rememberMe();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Equipment']))
		{
			$model->attributes=$_POST['Equipment'];
			if($model->save()){
				$this->redirect(array('/Workplace/view','id'=>$model->id_workplace));
			}
		
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionMassUpd(){
		$mass_id=NULL;
		$model=new Equipment;
		if(!empty($_POST['EquipmentMass']) and !empty($_POST['EquipmentMass']['id'])){
			$mass_id=$_POST['EquipmentMass']['id'];
			$model->scenario='massUpd';
			$models=Equipment::model()->findAll(array('condition'=>'t.id in ('.implode(',', $_POST['EquipmentMass']['id']).')'));
			$attr=array();
			foreach ($models as $v) {
				foreach ($v->attributes as $k => $x) {
					$attr[$k][]=$x; 
				}
			}

			foreach ($attr as $k => $x) {
				$uni=array_unique($x);
				if(count($uni)==1)
					$model->$k=$uni[0];
			}

			//print_r($model->attributes);
		}
		if(!empty($_POST['Equipment']) and !empty($_POST['mass_id'])){
			$model->attributes=$_POST['Equipment'];
			$models=Equipment::model()->findAll(array('condition'=>'t.id in ('.$_POST['mass_id'].')'));
			foreach ($models as &$md) {
				$md->rememberMe();
			}


			foreach ($model->attributes as $k => $v) {
				if($v!='' and $k!='id'){
					echo '<br>'.$k;
					foreach ($models as &$mod) {
						echo '|'.$mod->id.'('.$v.')';
						$mod->$k=$v;
					}
				}
			}
			
			foreach ($models as $modd) {
				if ($modd->save())
					echo 'ok';
				else
					echo 'error';
			}
			
			if(!empty($model->id_workplace)){
				$this->redirect(array('/Workplace/view','id'=>$model->id_workplace));
			}
			else{
				$this->redirect(array('/Equipment/index'));
			} 
		}

		$this->render('massUpd',array(
			'model'=>$model,'mass_id'=>$mass_id
		));
	}

	public function actionMarkSearch(){
		if(!Yii::app()->request->isAjaxRequest){
			exit();
		}
			if(!empty($_POST['search'])){
				$surname=$_POST['search'];
			}else{
				$surname='no';
			}

			$criteria = new CDbCriteria;
			$criteria->select = "t.mark, count(t.mark) as cou";


            $criteria->compare('type',$_POST['type']);
            $criteria->compare('producer',$_POST['producer']);

			//$criteria->condition = "type=:type and producer=:producer";
			//$criteria->params = array(':type'=>$_POST['type'],':producer'=>$_POST['producer']);
			//$criteria->distinct = True;
			$criteria->group="mark";
			$criteria->order="cou DESC";

			$model=Equipment::model()->findall($criteria);
			$this->renderPartial('markSearch', array('model'=>$model), false, false);
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{

		$model=$this->loadModel($id);
		$id_wp=$model->id_workplace;
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(array('/Workplace/view','id'=>$id_wp));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	
		if(!Yii::app()->user->checkAccess('inGroup',array('group'=>array('it'))))
			throw new CHttpException(403, 'У вас недостаточно прав');
		/*	$dataProvider=new CActiveDataProvider('Equipment');
		$this->render('index',array(
			'dataProvider'=>$dataProvider, 'modelLabelP'=>Equipment::$modelLabelP,
		)); */


		$model=new Equipment('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Equipment']))
			$model->attributes=$_GET['Equipment'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Equipment('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Equipment']))
			$model->attributes=$_GET['Equipment'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Equipment the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Equipment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	public function actionGarant(){
		$criteria=new CDbCriteria;
		$criteria->addCondition(array('condition'=>'t.mark LIKE(\'%1536%\') and t.notes not LIKE (\'%гарантия до%\')'));
		$model=Equipment::model()->find($criteria);

		if(empty($model))
			$this->redirect(array('/'));

		echo $model->id.'\\'.$model->mark;
		$html = file_get_contents('http://h10025.www1.hp.com/ewfrf/wc/weResults?tmp_weCountry=ru&tmp_weSerial='.$model->serial.'&tmp_weProduct=CE538A&cc=ru&dlc=ru&lc=ru&product=');
		$result = preg_match('/>.*(ГГГГ-ММ-ДД)/', $html,$found); 
		$result2 = preg_match('/\d{4}-\d{2}-\d{2}/', $found[0], $res); 
		echo '<br>'.$res[0];

		$model->notes=$model->notes."\n гарантия до: ".$res[0];
		$model->save();
		echo '<meta http-equiv="Refresh" content="1" />';

	}

	public function actionSuggest(){
		if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])) {
  			$models = Equipment::model()->suggestTag($_GET['term']);
  			$result = array();
  			foreach ($models as $m)
   			$result[] = array(
     			'label' => $m->idWorkplace->wpNameFull().'/'.$m->mark,
     			'value' => $m->idWorkplace->wpNameFull().'/'.$m->mark,
     			'id' => $m->id,
   			);
  			echo CJSON::encode($result);
 		}
 	}

	public function actionIpmac(){
		$dhcp=DhcpLeases::model()->findAll();
		$i=1;
		echo 'begin';
		foreach ($dhcp as $v) {
			$criteria=new CDbCriteria;

			/*
			if(!empty($v->mac)){
				$realmac=mb_strtoupper($v->mac,'UTF-8');
				echo $realmac.'<br>';
				$macarr=explode(':',$realmac);
				$criteria->addCondition(array('condition'=>"(UPPER(t.notes) LIKE ('".implode('',$macarr)."') OR UPPER(t.notes) LIKE ('".implode(':',$macarr)."') OR UPPER(t.notes) LIKE ('".implode('-',$macarr)."'))"));
			} */

			if(!empty($v->hostname)){
				$hostname=mb_strtolower($v->hostname,'UTF-8');
				$criteria->compare('LOWER(notes)',$hostname,true);
			}else{
				continue;
			}

			//echo''.$mac.'<br>';
			
			//$criteria->compare('mac',mb_strtolower($v->mac,'UTF-8'));
			//$criteria->compare('ip',$v->ip);
			//$criteria->compare('hostname',$v->hostname); /**/
			//$criteria->addCondition(array('condition'=>"UPPER(t.notes) LIKE('%".$v['ip']."%') ".($nm=(!empty($v['hostname']))?" OR UPPER(t.notes) LIKE('%".mb_strtoupper($v['hostname'])."%')":"").$mac));
			$model=Equipment::model()->find($criteria);
			if($model){
				echo $i.' '.$model->full_name()." ".$model->netInfo()." <br>";
				$model->ip=$v->ip;
				$model->mac=$v->mac;
				$model->hostname=$v->hostname;
				$model->notes=str_replace($hostname,'',mb_strtolower($model->notes,'UTF-8'));
				$i++;
				echo '<pre>';
				print_r($model->attributes);
				echo '</pre>';
				//$model->save();
			}
		}

	}

	/**
	 * Performs the AJAX validation.
	 * @param Equipment $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='equipment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
