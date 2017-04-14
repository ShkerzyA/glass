<?php Yii::app()->getClientScript()->registerCoreScript('tornado'); ?>
<?php
class DeadLine extends CWidget{
	public function run(){
		$deadline=Tasks::deadLineTasks();
		$this->render('Deadline',array('deadline'=>$deadline));
	}

}
	?>