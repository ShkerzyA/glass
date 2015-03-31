<?php Yii::app()->getClientScript()->registerCoreScript('tornado'); ?>
<?php
class Messenger extends CWidget{
	public function run(){
		
		$model=Messages::model()->findAll(array('condition'=>'timestamp::date=\''.date('Y-m-d').'\'','order'=>'timestamp ASC'));
		$this->render('Messenger',array('model'=>$model));
	}

}
	?>