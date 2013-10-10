<?php 
Class ruleButton{
	public static $corps=array(	'Building'=>array('id_building'=>array('type'=>'parent','val'=>'id')),
								'Floor'=>array('id_floor'=>array('type'=>'parent','val'=>'id')),
								'Cabinet'=>array('id_cabinet'=>array('type'=>'parent','val'=>'id')),
								'Department'=>array(),
								'DepartmentPosts'=>array(),
								'Workplace'=>array(),
								'Catalogs'=>array('id_parent'=>array('type'=>'parent','val'=>'id'),),
								'Docs'=>array(),
					);

	public static function get($id,$contr,$child){

			//Тут можно по $contr и $id найти родительскую модель и получить все данные о ней.
			//А также получить id создателя, собрать все это и добавить в add_button в виде массива
			

			$v['contr']=$contr;
		if(Yii::app()->user->role=='administrator' or Yii::app()->user->role=='moderator'){

			$parent=$contr::model()->find(array("condition"=>"id='$id'"));

	
			foreach (self::$corps[$contr] as $k => $val){
				if($val['type']=='parent'){
					$attr_arg[]="".$child."[".$k."]=".$parent->$val['val'];	
				}else if ($val['type']=='user'){
					//$attr_arg[]="".$child."[".$k."]=".Yii::app()->user->personnels->PersonnelPostsHistory[0]->idPost->id;
					$attr_arg[]="".$child."[".$k."]=".Yii::app()->user->id_posts[0];
					//echo'<pre>';
					//print_r(Yii::app()->user);
				}else{
					$attr_arg[]="".$child."[".$k."]=".$val['val'];
				}
				
			}
			$attr='?'.implode('&&',$attr_arg);
			


			$v['action']="<a href=/glass/".$child."/create/".$id."".$attr."><img align=right src=/glass/images/add.png></a><a href=/glass/".$v['contr']."/update/".$id."><img align=right src=/glass/images/update.png></a>";
		}
		return $v;
	}
}
?>