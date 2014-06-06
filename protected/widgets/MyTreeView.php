<?php
Yii::import('CTreeView');
class MyTreeView extends CTreeView{
	public static function saveDataAsJson($data,$add=''){
		$data[]=array('id'=>'create','text'=>'Добавить','hasChildren'=>0,'contr'=>$data[0]['contr']);
		
		$dat=parent::saveDataAsJson($data);
		//echo $dat;
		return $dat;	
	}
	
}
	?>