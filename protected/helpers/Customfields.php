<?php 
Class Customfields{
	public static function multigroup($model){
		Yii::app()->clientScript->registerPackage('customfields');

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
		Yii::app()->clientScript->registerPackage('customfields');

		$result="<div class='multichoise'>";
					echo'<input type=hidden name=group_anchor>';
				$tmp=explode(',',$model->executors); 
				foreach ($tmp as $v){
					if(!empty($v)){
					$pers=Personnel::model()->findByPk($v);
					$result.="<div class='choise_unit $v'>
						<input type=hidden name='executors[$v]' value=$v>".(CHtml::encode($pers->surname.' '.$pers->name))."
						<div id=$v class='close_this'></div>
					</div>";
					}
				}	
		$result.="<div id='add_post' class='add_unit'>Добавить</div></div>";
		return $result;
	}


	public static function multiPersonnel($model,$field){
		Yii::app()->clientScript->registerPackage('customfields');

		$result="<div class='multichoise'>";
				echo'<input type=hidden name=group_anchor>';
				echo'<input type=hidden name=field id=field value='.$field.'>';
					$tmp=explode(',',$model->$field); 
					foreach ($tmp as $v){
						if(!empty($v)){
							$pers=Personnel::model()->findByPk($v);
							$result.="<div class='choise_unit $v'>
								<input type=hidden name='".$field."[$v]' value=$v>".(CHtml::encode($pers->surname.' '.$pers->name))."
								<div id=$v class='close_this'></div>
							</div>";
						}
					}	
				
		$result.="<div id='add_personnel' class='add_unit'>Изменить</div></div>";
		return $result;
	}

	public static function searchPersonnel($model,$field)
	{
		Yii::app()->clientScript->registerPackage('customfields');
			$result="<div class='multichoise'>";
				echo'<input type=hidden name=field id=field value='.$field.'>';
				echo'<input type=hidden name=modelN id=modelN value='.get_class($model).'>';
					$tmp=$model->$field; 
						if(!empty($tmp)){
							$pers=Personnel::model()->findByPk($tmp);
							$result.="<div class='choise_unit $v'>
								<input type=hidden name='".get_class($model)."[".$field."]' value=$tmp>".(CHtml::encode($pers->surname.' '.$pers->name.' '.$pers->patr))."
								<div id=$tmp class='close_this'></div>
							</div>";
						}
				
				
		$result.="<div id='add_personnel' class='add_unit'>Изменить</div></div>";
		return $result;
		# code...
	}
}

?>