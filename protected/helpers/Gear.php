<?php 
Class Gear{
	public static function getModelname(){
		$path=(Yii::app()->request->pathInfo);
    	$path=explode('/', $path);
		return $path[0];
	}
}
?>