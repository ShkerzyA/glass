<?php 
Class MultiChoise{
	public static function getField($model){
		Yii::app()->clientScript->registerPackage('multichoise');

		$result="<div class='multichoise'>";
					echo'<input type=hidden name=group_anchor>';
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
		$result.="<div id='add_group' class='add_unit'>Добавить</div></div>";
		return $result;
	}

	public static function getFieldPosts($model){
		Yii::app()->clientScript->registerPackage('multichoise');

		$result="<div class='multichoise'>";
					echo'<input type=hidden name=group_anchor>';
				$tmp=explode(',',$model->executors); 
				foreach ($tmp as $v){
					if(!empty($v)){
					$pers=DepartmentPosts::model()->findByPk($v);
					$result.="<div class='choise_unit $v'>
						<input type=hidden name='executors[$v]' value=$v>".(CHtml::encode($pers->personnelPostsHistories[0]->idPersonnel->surname.' '.$pers->personnelPostsHistories[0]->idPersonnel->name))."
						<div id=$v class='close_this'></div>
					</div>";
					}
				}	
		$result.="<div id='add_post' class='add_unit'>Добавить</div></div>";
		return $result;
	}
}
?>