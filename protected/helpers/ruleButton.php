<?php 
Class ruleButton{
	$corps=array(	'Building'=>array(),
					'Floor'=>array(),
					);

	public static function get($id,$contr,$child){

			//Тут можно по $contr и $id найти родительскую модель и получить все данные о ней.
			//А также получить id создателя, собрать все это и добавить в add_button в виде массива
			

			$v['contr']=$contr;
		if(Yii::app()->user->role=='administrator' or Yii::app()->user->role=='moderator'){

			$parent=$contr::model()->find(array("condition"=>"id='$id'"));

			$attr="?".$child."[id_building]=".$parent->id;


			$v['action']="<a href=/glass/".$child."/create/".$id."".$attr."><img align=right src=/glass/images/add.png></a><a href=/glass/".$v['contr']."/update/".$id."><img align=right src=/glass/images/update.png></a>";
		}
		return $v;
	}
}
?>