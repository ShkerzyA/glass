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
		$fObj=(!empty($_POST['factoryObj']))?$_POST['factoryObj']:'';
		switch ($fObj) {
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
				$this->act=new Messages();
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
				'actions'=>array('index','ChatSaveMessage','SaveMessage','SaveStatus','SaveReport','delete','globalSearch'),
				'roles'=>array('user'),
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
	public function actionChatSaveMessage(){

		if(Yii::app()->request->isAjaxRequest){
			Yii::app()->Tornado->updateChat();
			$this->act->attributes=$_POST['Messages'];
			$this->act->save();
		}
	}

	public function actionSaveMessage(){

		if(Yii::app()->request->isAjaxRequest){
			Yii::app()->Tornado->updateTaskMessage($this->act->id_task);
			$this->act->ttext=$_POST['mess'];
			$this->act->type=1;
			$this->act->save();
		}
	}

	public function actionDelete(){
		$this->act=$this->act->findByPk($_POST['id']);
		$this->act->delete();
	}

	public function actionGlobalSearch($term){
		$$term=mb_strtolower($term,'UTF-8');
		$wrds=explode(' ',$term);
		if(in_array('*з',$wrds)){
			$term=str_replace('*з ','',$term);
			$tasks=Tasks::model()->actual_today()->suggestTag($term);
		}

		$docs=Docs::model()->suggestTag($term);
		$models = Cabinet::model()->with('workplaces.idPersonnel','idFloor.idBuilding')->suggestTag($term);

  			$result = array();
  			
  			$result[]=array('label'=>'<b>Кабинеты и места</b>');
  			foreach ($models as $c){
  					$cn=$c->cabNameFull(false,true);
  					$result[] = array(
     						'label' => '<a href=/glass/cabinet/'.$c->id.'>'.$cn.'</a>',
   						);
  					foreach ($c->workplaces as $m) {
  						$wn=$m->wpNameFull(false,false,'fio',true);
   						$result[] = array(
     						'label' => '<a href=/glass/workplace/'.$m->id.'>-------'.$wn.'</a>',
   						);
  				}
  				
   			}
   			$result[]=array('label'=>'<b>Документы</b>');
  			foreach ($docs as $m){
   				$result[] = array(
     				'label' => '<a href=/glass/docs/'.$m->id.'>'.$m->nameL().'</a>',
   				);
   			}

   			if(!empty($tasks)){
   				$result[]=array('label'=>'<b>Задачи</b>');
   				foreach ($tasks as $m) {
   					$result[] = array(
     					'label' => '<a href=/glass/tasks/'.$m->id.'>'.$m->nameL().'</a>',
     				);
   				}
   			}
   			echo CJSON::encode($result);
	}

	public function actionSaveReport(){

		if(Yii::app()->request->isAjaxRequest){
			if(Yii::app()->user->checkAccess('saveMessage',array('mod'=>$this->parent))){
				$moreinfo=array();
				switch ($this->parent->type) {
					case '1':
						
						if(!empty($_POST['inv_cart'])){
							$cart = Equipment::model()->find(array('condition'=>"t.type=18 and t.id_workplace=".Equipment::$cartFull." and t.inv='$_POST[inv_cart]'"));
							if(empty($cart)){
								echo 'cart_undefinded';
								exit();
							}
						}
						
						$print = Equipment::model()->findByPk($this->parent->details);

						if(!empty($_POST['inv_cart_old'])){
							$cart_old = Equipment::model()->find(array('condition'=>"t.type=18 and t.inv='$_POST[inv_cart_old]'"));
							if(empty($cart_old)){
								echo 'old_cart_undefinded';
								exit();
							}else{
								switch ($_POST['return_place']) {
									case '2':
										$cart_old->id_workplace=Equipment::$cartRepair;
										break;
									case '1':
										$cart_old->id_workplace=Equipment::$cartFull;
										break;
									case '0':
									default:
										$cart_old->id_workplace=Equipment::$cartStorage;
										break;
								}
								$cart_old->save();
							}
						}

				
						$timestamp=date('Y-m-d H:i:s');

						$moreinfo['num_str']=$_POST['num_str'];
						$log=new EquipmentLog;
						$log->saveLog('printerCounter',array('details'=>array(($det=(!empty($_POST['num_str']))?$_POST['num_str']:'n/a')),'object'=>$print->id,'timestamp'=>$timestamp));
						//$log->fnSubsNum();
						$log=EquipmentLog::model()->findByPk($log->id);
						$moreinfo['subs_num']=$log->subsNum;

						if(!empty($cart_old)){
							$moreinfo['cart_old']=$cart_old->inv;
							//Убираем из связанного оборудования изымаемый картридж
							$print->removeChildRel($cart_old->id);
							$log=new EquipmentLog;
							$log->saveLog('cartOut',array('details'=>array($cart_old->id_workplace),'object'=>$cart_old->id,'timestamp'=>$timestamp));
							$log=new EquipmentLog;
							$log->saveLog('cartCounter',array('details'=>array($moreinfo['subs_num']),'object'=>$cart_old->id,'timestamp'=>$timestamp));
						}

						if(!empty($cart)){
							$moreinfo['cart']=$cart->inv;
							$cart->id_workplace=$print->id_workplace;
							$cart->save();
							$log=new EquipmentLog;
							$log->saveLog('cartIn',array('details'=>array($print->id_workplace,$print->id),'object'=>$cart->id,'timestamp'=>$timestamp));
						}
						
						
						break;
					
					default:
						break;
				}
				$this->act->saveReport($moreinfo);
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

				if(get_class($this->parent)=="Tasks"){
					if(in_array($_POST['stat'], $parent::$statJoin)){
						$this->parent->join(Yii::app()->user->id_pers);
					}
				}

				$this->parent->save();

				$sModel=Tasks::model()->findByPk($this->parent->id);
				$sModel->sendMail();

				$this->act->saveStatus();
				Yii::app()->Tornado->updateTasks();
				if($this->parent->status==2 and Yii::app()->user->id_pers==9)
					Yii::app()->Tornado->sergGood();
			}
		}

	}

}
