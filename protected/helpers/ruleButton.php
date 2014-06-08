<?php 
Class ruleButton{

	public static function get($id,$selfname,$contr){

			$v['action']="<a href=/glass/".$selfname."/update/".$id."><img align=right src=/glass/images/update.png></a>";
			$v['contr']=$contr;
			$v['selfname']=$selfname;
			return $v;
	}


	public static function add($id,$contr){
		$parent=$contr::model()->find(array("condition"=>"id='$id'"));

	}
}
?>