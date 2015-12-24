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
     	$tmp=file_get_contents("http://".Yii::app()->params['tornado']."/?message=".$message."");
    }


	public function updateChat(){
		$this->message('{"type":"action","id":"updateChat"}');
	}

	public function updateTaskMessage($id_task){
		$this->message('{"type":"action","id":"updateTaskMessage","task":"'.$id_task.'"}');
	}

	public function updateMon(){
		$this->message('{"type":"action","id":"updateMon"}');
	}

	public function updateTasks(){
		$this->message('{"type":"action","id":"updateTasks"}');
	}
}