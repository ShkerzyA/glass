<?php 
Class Gear{
	public static function getModelname(){
		$path=(Yii::app()->request->pathInfo);
    	$path=split('/', $path);
		return $path[0];
	}
}
?>