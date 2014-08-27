<?php

class EventsoperController extends Controller
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
				'actions'=>array('index','view','monupdate','agree','confirm','suggest','plan', 'plan2','freeDay','operSearch'),
				'roles'=>array('user'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'roles'=>array('user'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'roles'=>array('administrator'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

public function actionSuggest(){
		if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])) {
  		$models = ListOperations::model()->suggestTag($_GET['term']);
  		$result = array();
  		foreach ($models as $m)
   		$result[] = array(
     		'label' => $m->name,
     		'value' => $m->name,
     		'id' => $m->id,
   		);
  		echo CJSON::encode($result);
 	}
}

	public function actionOperSearch(){
		if(Yii::app()->request->isAjaxRequest){
			if(!empty($_POST['search'])){
				$name=$_POST['search'];
			}else{
				$name='';
			}


			if(!empty($name)){

				$words=explode(' ', $name);
				$criteria=new CDbCriteria;
				foreach ($words as $w) {
					$criteria->addCondition(array('condition'=>'LOWER("t".name) LIKE (\'%'.mb_strtolower($w,'UTF-8').'%\')'));
				}
				$model=ListOperations::model()->findall($criteria);				
			}else{
				$model=NULL;
			}
			
			$this->renderPartial('operSearch', array('name'=>$name,'model'=>$model, 'field'=>$_POST['field'], 'modelN'=>$_POST['modelN']), false, true);
		}else{
			exit();
		}
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if (!((Yii::app()->user->checkAccess('inGroup',array('group'=>'operationsv'))) or (Yii::app()->user->checkAccess('inGroup',array('group'=>'operations')))  ))
            throw new CHttpException(403, 'У вас недостаточно прав');
		$model=new Eventsoper;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Eventsoper']))
		{
			$model->attributes=$_POST['Eventsoper'];
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
		if (!((Yii::app()->user->checkAccess('inGroup',array('group'=>'operationsv'))) or (Yii::app()->user->checkAccess('inGroup',array('group'=>'operations'))) or (Yii::app()->user->checkAccess('inGroup',array('group'=>'anestesiologist'))) ))
            throw new CHttpException(403, 'У вас недостаточно прав');
		$model=$this->loadModel($id);


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Eventsoper']))
		{
			$model->attributes=$_POST['Eventsoper'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionFreeDay(){
		$model=new Eventsoper;
		if(isset($_POST['Eventsoper']))
		{
			$model->attributes=$_POST['Eventsoper'];
		}
		$evItervals=$model->freeDay(); 
		$this->renderPartial('_indicator_slider',array('evItervals'=>$evItervals),false,false);

	}

	public function actionAgree($id){
		$model=$this->loadModel($id);
		$model->status=1;
		if($model->save())
				$this->redirect(array('/rooms/show'));
	}

	public function actionConfirm($id,$cansel=false){
		$model=$this->loadModel($id);
		if($cansel)
			$model->status=0;
		else
			$model->status=4;
		if($model->save())
				$this->redirect(array('/rooms/show'));
	}

		public function actionMonUpdate($id)
	{
		if (!((Yii::app()->user->checkAccess('inGroup',array('group'=>'operationsv'))) or (Yii::app()->user->checkAccess('inGroup',array('group'=>'operations'))) ))
            throw new CHttpException(403, 'У вас недостаточно прав');
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Eventsoper']))
		{
			if(!($model_new=Eventsoper::model()->find(array('condition'=>'t.id_eventsoper='.$id)))){
				$model_new=new Eventsoper;
			}
			$model_new->attributes=$_POST['Eventsoper'];
			unset($_POST['Eventsoper']);
			$model_new->id_eventsoper=$id;
			$model_new->status=3;
			//print_r($_POST);
			if($model_new->save()){
				$model->status=2;

				//print_r($model_new->attributes);
				//print_r($model->attributes);
				$model->save();
				$this->redirect(array('/rooms/show'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/rooms/show?Event_type=eventsOpPl'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Eventsoper');
		$this->render('index',array(
			'dataProvider'=>$dataProvider, 'modelLabelP'=>Eventsoper::$modelLabelP,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Eventsoper('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Eventsoper']))
			$model->attributes=$_GET['Eventsoper'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

		public function actionPlan()
	{
		$this->layout='//layouts/leaf';
		$model=new Eventsoper('search');
		$model->unsetAttributes();
		$model->status='0,1,2';  // clear any default values
		$model->date=date('d.m.Y');
		if(isset($_GET['Eventsoper']))
			$model->attributes=$_GET['Eventsoper'];

		$this->render('plan',array(
			'model'=>$model,
		));
	}

		public function actionPlan2()
	{
		$this->layout='//layouts/leaf';
		
		$model=new Eventsoper('search');
		$model->unsetAttributes();
		  // clear any default values
		
		if(isset($_GET['Eventsoper']))
				$model->attributes=$_GET['Eventsoper'];	
		if(empty($model->date)){
			$model->date=date('d.m.Y');
		}
		if(empty($model->status)){
			$model->status='0,1,2,4';
		}

		$room_where=(!empty($model->id_room))?" and t.id=$model->id_room ":"";
		
		$rooms=Rooms::model()->with(array('eventsoper'=>array(
			'alias'=>'eventsoper', 'joinType'=>'LEFT JOIN','order'=>'eventsoper.timestamp','on'=>"eventsoper.date='$model->date' and eventsoper.status in ($model->status)"),'idCabinet'=>array('alias'=>'cabinet')))->findAll(array('condition'=>"t.type=1 $room_where",'order'=>'cabinet.cname'));

		$this->render('plan2',array(
			'rooms'=>$rooms,'model'=>$model
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Eventsoper the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Eventsoper::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Eventsoper $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='eventsoper-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
