<?php

class ActionsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	private $parent;
	private $act;

	/**
	 * @return array action filters
	 */


	public function init(){ 
		switch ($_POST['factoryObj']) {
			case 'events':
				$this->parent=Events::model()->findByPk($_POST['id']);
				$this->act=new EventsActions();
				$this->act->id_event=$_POST['id'];
				break;
			case 'tasks':
				$this->parent=Tasks::model()->findByPk($_POST['id']);
				$this->act=new TasksActions();
				$this->act->id_task=$_POST['id'];
				break;
			default:
				$this->act=new MessageActions($_POST['id']);
				break;
		}

	} 

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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','SaveMessage','SaveStatus'),
				'users'=>array('*'),
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

	public function actionSaveMessage(){

		if(Yii::app()->request->isAjaxRequest){
			if(Yii::app()->user->checkAccess('saveMessage',array('mod'=>$this->parent))){
				$this->act->saveMessage();
			}
		}

	}

	public function actionSaveStatus(){

		if(Yii::app()->request->isAjaxRequest){
			if(Yii::app()->user->checkAccess('saveStatus',array('mod'=>$this->parent))){

				$this->parent->status=$_POST['stat'];
				if($_POST['stat']==1 or $_POST['stat']==2){
					$this->parent->timestamp_end=date('d.m.Y H:i:s');
				}
				$this->parent->save();
				$this->act->saveStatus();
			}
		}

	}

}
