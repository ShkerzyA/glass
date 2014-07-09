<?php

/**
 * This is the model class for table "tasks_actions".
 *
 * The followings are the available columns in table 'tasks_actions':
 * @property integer $id
 * @property string $ttext
 * @property string $date_begin
 * @property integer $type
 * @property integer $creator
 * @property integer $id_task
 *		 * The followings are the available model relations:


 * @property DepartmentPosts $creator0


 * @property Tasks $idTask
 */
class ActionsFactory 
{
	public $tasks;
	public $events;
	public $messages;

	public function __create(){

	}



	public function findMyMessages(){
		$model=new Messages();
		return $model;
	}

	public function findMyTasks(){
		$model=new TasksActions();
		return $model;
	}

	public function findMyEvents(){
		$model=new EventsAction();
		return $model;
	}

	public function findAll(){
		
	}


}


?>
