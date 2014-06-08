<?php
Yii::import('CTreeView');
class MyTreeView extends CTreeView{
	public static function saveDataAsJson($data,$selfname,$parent_id,$idParent){

		$attr='';
		if(!empty($parent_id) and !empty($idParent)){
			$attr='?'.$selfname.'['.$parent_id.']='.$idParent;
		}

		$data[]=array('id'=>'create'.$attr,'text'=>'Добавить','selfname'=>$selfname,'hasChildren'=>0);
		
		$dat=parent::saveDataAsJson($data);
		//echo $dat;
		return $dat;	
	}
	
}
	?>