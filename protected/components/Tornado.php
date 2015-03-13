<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Tornado extends CApplicationComponent
{
	 public function init()

     {
          parent::init();

     }

    private function message($message='fooo'){
     	$tmp=file_get_contents("http://localhost:8888/?message=".$message."");
    }


	public function updateChat(){
		$this->message("updateChat");
	}

	public function updateMon(){
		$this->message("updateMon");
	}

	public function updateTasks(){
		$this->message("updateTasks");
	}
}