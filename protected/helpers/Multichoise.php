<?php 
Class MultiChoise{
	public static function getField($model){
		Yii::app()->clientScript->registerPackage('multichoise');

		$result="<div class='multichoise'>";
			
				$tmp=explode(',',$model->groups); 
				foreach ($tmp as $v){
					if(!empty($v)){
					$group=PostsGroups::model()->find(array("condition"=>"group_key='$v'"));
					$result.="<div class='choise_unit $v'>
						<input type=hidden name='groups[$v]' value=$v>
						$group->group_name
						<div id=$v class='close_this'></div>
					</div>";
					}
				}	
		$result.="<div class='add_unit'>Добавить</div></div>";
		return $result;
	}
}
?>