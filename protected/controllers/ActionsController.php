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
		//echo $_POST['factoryObj'];
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
				$this->act=new MessageActions();
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
				'actions'=>array('index','SaveMessage','SaveStatus','SaveReport','delete'),
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

	public function actionDelete(){
		$this->act=$this->act->findByPk($_POST['id']);
		$this->act->delete();
		//echo $this->act->ttext;
		//echo'почн';
	}

	public function actionSaveReport(){

		if(Yii::app()->request->isAjaxRequest){
			if(Yii::app()->user->checkAccess('saveMessage',array('mod'=>$this->parent))){
				switch ($this->parent->type) {
					case '1':

					if(!empty($_POST['inv_cart']))
					{
						$print = Equipment::model()->findByPk($this->parent->details);
						$cart_old=Equipment::model()->with('EquipmentLog')->find(array('condition'=>"t.type=18 and t.id_workplace=$print->id_workplace and \"EquipmentLog\".details[2]='$print->id'",'order'=>'"EquipmentLog".timestamp DESC'));
						$cart = Equipment::model()->find(array('condition'=>"t.type=18 and t.id_workplace=".Equipment::$cartFull." and t.inv='$_POST[inv_cart]'"));
						if(!$cart){
							echo 'cart_undefinded';
							exit();
						}

						if($cart_old){
							$cart_old->id_workplace=Equipment::$cartStorage;
							$cart_old->save();
						}else if(!empty($_POST['inv_cart_old'])){
							$cart_old = Equipment::model()->find(array('condition'=>"t.type=18 and t.inv='$_POST[inv_cart_old]'"));
							if($cart_old){
								$cart_old->id_workplace=Equipment::$cartStorage;
								$cart_old->save();
							}else{
								echo 'old_cart_undefinded';
								exit();
							}
						}

						$cart->id_workplace=$print->id_workplace;
						$cart->save();

						$timestamp=date('Y-m-d H:i:s');


						$log=new EquipmentLog;
						$log->saveLog('cartOut',array('details'=>$cart_old->id_workplace,'object'=>$cart_old->id,'timestamp'=>$timestamp));
						
						$log=new EquipmentLog;
						$log->saveLog('cartIn',array('details'=>$print->id_workplace.','.$print->id,'object'=>$cart->id,'timestamp'=>$timestamp));

						$log=new EquipmentLog;
						$log->saveLog('printerCounter',array('details'=>($det=(!empty($_POST['num_str']))?$_POST['num_str']:'n/a'),'object'=>$print->id,'timestamp'=>$timestamp));
					}

						break;
					
					default:
						break;
				}
				$this->act->saveReport();
			}
		}


	}

	public function actionSaveStatus(){

		if(Yii::app()->request->isAjaxRequest){
			if(Yii::app()->user->checkAccess('saveStatus',array('mod'=>$this->parent))){

				$this->parent->status=$_POST['stat'];

				$parent=get_class($this->parent);
				if(in_array($_POST['stat'], $parent::$statFixEnd)){
					$this->parent->timestamp_end=date('d.m.Y H:i:s');
				}
				$this->parent->save();
				$this->act->saveStatus();
			}
		}

	}

}
