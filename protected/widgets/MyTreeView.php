<?php
Yii::import('CTreeView');
class MyTreeView extends CTreeView{
	public static function saveDataAsJson($data){
<<<<<<< HEAD
		//$data[]=array('id'=>'create','text'=>'Добавить','hasChildren'=>0,'contr'=>$data[0]['contr']);
		
=======


>>>>>>> 955daf8d5839e2563248ba1008e353fc73400ffd
		$dat=parent::saveDataAsJson($data);
		//echo $dat;
		return $dat;	
	}
	
}
	?>