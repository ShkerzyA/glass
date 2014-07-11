<?php
class Messenger extends CWidget{
	public function run(){
		
		$model=new Messages;
		$this->render('Messenger',array('model'=>$model));
	}

}
	?>