<?php

class CatalogsController extends Controller
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
				'actions'=>array('index','view','rootFillTree','AjaxFillTree'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'roles'=>array('moderator'),
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

	   public function actionRootFillTree()
    {
        // если пробуют получить прямой доступ к экшину (не через ajax)
        // тогда обрубаем "крылья")) т.е. возвращаем белую страницу
        if (!Yii::app()->request->isAjaxRequest) {
            exit();
        }

        // с какого узла начинаем вывод дерева? 0 - с первого
        $parentId = '';
        if (isset($_GET['root']) && $_GET['root'] !== 'source') {
            $parentId = 'WHERE m1.id='.(int)$_GET['root'].' ';
        }else{
        	$parentId = 'WHERE m1.id_parent is null ';
        }

  		$onlyGroups=' false ';
        if(!empty(Yii::app()->user->groups )){
        	$onlyGroups=' AND (FALSE ';
       		foreach (Yii::app()->user->groups as $v) {
       			if(!empty($v))
       	 		$onlyGroups.="OR m1.groups @> '{".$v."}'::character varying[] ";
        	}
        	$id_posts=implode(',',Yii::app()->user->id_posts);

        	$onlyGroups.="OR m1.owner in (".$id_posts.")";

        	$onlyGroups.=' ) ';
        }
        
        $sql="SELECT m1.id, m1.cat_name AS text, m1.id_parent as parent_id, count(m2.id) AS \"hasChildren\" FROM catalogs AS m1 LEFT JOIN catalogs AS m2 ON m1.id=m2.id_parent  $parentId $onlyGroups GROUP BY m1.id  ORDER BY m1.cat_name ASC";
        //echo $sql;
        // сам запрос на получение данных детей (через обычный LEFT JOIN)
        $req = Yii::app()->db->createCommand($sql);

        $children = $req->queryAll();

        foreach ($children as &$v) {
        	$v['contr']='Catalogs';
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


	   public function actionAjaxFillTree()
    {
        // если пробуют получить прямой доступ к экшину (не через ajax)
        // тогда обрубаем "крылья")) т.е. возвращаем белую страницу
        if (!Yii::app()->request->isAjaxRequest) {
            exit();
        }

        Yii::app()->user;

        // с какого узла начинаем вывод дерева? 0 - с первого
        $parentId = '';
        if (isset($_GET['root']) && $_GET['root'] !== 'source') {
            $parentId = 'WHERE m1.id_parent='.(int)$_GET['root'].' ';
        }

        $onlyGroups=' false ';
        if(!empty(Yii::app()->user->groups )){
        	$onlyGroups=' AND (FALSE ';
       		foreach (Yii::app()->user->groups as $v) {
       			if(!empty($v))
       	 		$onlyGroups.="OR m1.groups @> '{".$v."}'::character varying[] ";
        	}
        	$id_posts=implode(',',Yii::app()->user->id_posts);

        	$onlyGroups.="OR m1.owner in (".$id_posts.")";

        	$onlyGroups.=' ) ';
        }

        // сам запрос на получение данных детей (через обычный LEFT JOIN)
        $req = Yii::app()->db->createCommand(
            //"SELECT m1.id, m1.name AS text, m1.id_parent as parent_id, count(m2.id) AS \"hasChildren\" FROM department AS m1 LEFT JOIN department AS m2 ON m1.id=m2.id_parent WHERE m1.id_parent $parentId and (m1.date_end is null  or m1.date_end>current_date) GROUP BY m1.id  ORDER BY m1.name ASC"
        	"SELECT m1.id, m1.cat_name AS text, m1.id_parent as parent_id, count(m2.id) AS \"hasChildren\" FROM catalogs AS m1 LEFT JOIN catalogs AS m2 ON m1.id=m2.id_parent  $parentId  $onlyGroups  GROUP BY m1.id  ORDER BY m1.cat_name ASC"
        );

        //!!!
        // М.б. все группы должности пользователя храняться в массиве, и делать where (элемент массива)  in groups or (следующий элемент) in groups or id_pers=owner

        $children = $req->queryAll();

        foreach ($children as &$v) {
        	$v['contr']='Catalogs';
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
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{

		$model=$this->loadModel($id);

		$docs=Docs::model()->working()->findAll(array('condition'=>"id_catalog='$model->id'",'order'=>'doc_name ASC, t.date_begin ASC'));
		$this->render('view',array(
			'model'=>$model,'docs'=>$docs,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Catalogs;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Catalogs']))
		{
			$model->attributes=$_POST['Catalogs'];
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

		if(isset($_POST['Catalogs']))
		{
			$model->attributes=$_POST['Catalogs'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('Catalogs');
		$this->render('index',array(
			'dataProvider'=>$dataProvider, 'modelLabelP'=>Catalogs::$modelLabelP,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Catalogs('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Catalogs']))
			$model->attributes=$_GET['Catalogs'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Catalogs the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Catalogs::model()->with(array(
			'owner0',
			'owner0.personnelPostsHistories'=>array('order'=>'"personnelPostsHistories".date_begin DESC'),
			))->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Catalogs $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='catalogs-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
