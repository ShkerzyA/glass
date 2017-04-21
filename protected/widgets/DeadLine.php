<?php
class DeadLine extends CWidget{
	public function run(){
		$deadline=Tasks::deadLineTasks();
		if(!empty($deadline))
			$this->render('Deadline',array('deadline'=>$deadline));
	}

}
	?>