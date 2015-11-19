<?php

class WorkplaceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $rightWidget=array();
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

	
	 public function actions()
    {
        return array(
            'ajaxFillTree'=>'application.controllers.actions.actionAjaxFillTree',
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
				'actions'=>array('index','view','rootFillTree','AjaxFillTree','suggest'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'roles'=>array('moderator'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','AutoSetDepartment'),
				'roles'=>array('administrator'),
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

	public function actionAutoSetDepartment(){
		Workplace::autoSetDepartment();
	}

	public function actionView($id)
	{
		$model=$this->loadModel($id);
		switch ($model->type) {
			case '1':
			case '2':
        		$result=$model->eqCount();
        		$info=$this->renderPartial('/equipment/storagetableview',array('equipments'=>$result),true,false); 
				break;
			default:
				$info='';
				break;
		}
		$this->render('view',array(
			'model'=>$model,
			'info'=>$info,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Workplace;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Workplace']))
		{
			$model->attributes=$_POST['Workplace'];
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
		$alt_model=clone $model;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Workplace']))
		{
			$model->attributes=$_POST['Workplace'];
			if($model->save()){
				if($alt_model->id_cabinet!=$model->id_cabinet){
					foreach($model->equipments as $v){
						//echo $v->id;
						$log=new EquipmentLog;
						$log->saveLog('moveWp',array('details'=>array($alt_model->id_cabinet,$model->id_cabinet),'object'=>$v->id));
					}
				}
				$this->redirect(array('view','id'=>$model->id));
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Workplace');
		$this->render('index',array(
			'dataProvider'=>$dataProvider, 'modelLabelP'=>Workplace::$modelLabelP,
		));
	}

	public function actionAjaxddddFillTree()
    {
        // если пробуют получить прямой доступ к экшину (не через ajax)
        // тогда обрубаем "крылья")) т.е. возвращаем белую страницу
        if (!Yii::app()->request->isAjaxRequest) {
            exit();
        }

        // с какого узла начинаем вывод дерева? 0 - с первого
      	$parentId = '';
        if (isset($_GET['root']) && $_GET['root'] !== 'source') {
            $parentId = 'WHERE m2.id='.(int)$_GET['root'].' ';
        }
        // сам запрос на получение данных детей (через обычный LEFT JOIN)
        $req = Yii::app()->db->createCommand(
            //"SELECT m1.id, m1.name AS text, m1.id_parent as parent_id, count(m2.id) AS \"hasChildren\" FROM department AS m1 LEFT JOIN department AS m2 ON m1.id=m2.id_parent WHERE m1.id_parent $parentId and (m1.date_end is null  or m1.date_end>current_date) GROUP BY m1.id  ORDER BY m1.name ASC"
        	"SELECT m1.id, m1.surname||' '||m1.name||' '||m1.patr AS text, m1.id as parent_id, 0 AS \"hasChildren\" FROM workplace as m2 left join personnel AS m1 on (m2.id_personnel=m1.id) $parentId GROUP BY m1.id  ORDER BY m1.surname ASC"
        );

        $children = $req->queryAll();

        foreach ($children as &$v) {
        	$v['contr']='Personnel';
        }
       

        //print_r($children);
        // возвращаем данные
        echo str_replace(
            '"hasChildren":"0"',
            '"hasChildren":false',
            CTreeView::saveDataAsJson($children)
        );
        exit();
    }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Workplace('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Workplace']))
			$model->attributes=$_GET['Workplace'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionSuggest(){
		if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])) {
  			$models = Workplace::model()->suggestTag($_GET['term']);
  			$result = array();
  			foreach ($models as $m)
   			$result[] = array(
     			'label' => $m->wpNameFull(false,true),
     			'value' => $m->wpNameFull(false,true),
     			'id' => $m->id,
   			);
  			echo CJSON::encode($result);
 		}
 	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Workplace the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Workplace::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		switch ($model->type) {
			case '2':
					$model=Workplace::model()->with(array(
			'equipments',
			//'equipments.EquipmentLog',
			'equipments.EquipmentLog'=>array('joinType'=>'LEFT JOIN','alias'=>"EquipmentLog",'on'=>'1<>1) OR ("EquipmentLog".type in (3) and "equipments".inv=ANY("EquipmentLog"."details")'),
			))->find(array('condition'=>'t.id='.$id,'order'=>'"EquipmentLog".timestamp DESC'));
				break;
			
			default:
				break;
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Workplace $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='workplace-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
