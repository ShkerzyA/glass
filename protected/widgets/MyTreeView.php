<?php
Yii::import('CTreeView');
class MyTreeView extends CTreeView{
	public static function saveDataAsJson($data){
		$dat=parent::saveDataAsJson($data);
		//echo $dat;
		return $dat;	
	}
	
}
	?>