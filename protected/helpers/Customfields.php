<?php 
Class Customfields{
	public static function multigroup($model,$field='groups'){
		Yii::app()->clientScript->registerPackage('customfields');
		$mn=get_class($model);
		$result="<div id='".$field."' class='multichoise'><div id='$field' class='add_group add_unit'>Добавить</div>";
				echo'<input type=hidden name=field class=field id='.$field.' value='.$field.'>';
				echo'<input type=hidden name=modelN class=modelN id='.$field.' value='.$mn.'>';
				echo"<input type=hidden name='".$mn."[$field][]' value=''>";
				if(!empty($model->$field)){
					foreach ($model->$field as $v){
						if(!empty($v)){
						$group=PostsGroups::model()->find(array("condition"=>"group_key='$v'"));
						$result.="<div class='choise_unit $field$v'>
							<input type=hidden name='".$mn."[$field][$v]' value=$v>
							$group->group_name
							<div id=$field$v class='close_this'></div>
						</div>";
						}
					}	
				}
		$result.="</div>";
		return $result;
	}

	/*
	public static function getFieldPosts($model){
		Yii::app()->clientScript->registerPackage('customfields');

		$result="<div class='multichoise'>";
					echo'<input type=hidden name=group_anchor>';
			if(!empty($model->executors)){
				foreach ($model->executors as $v){
					if(!empty($v)){
					$pers=Personnel::model()->findByPk($v);
					$result.="<div class='choise_unit $v'>
						<input type=hidden name='executors[$v]' value=$v>".(CHtml::encode($pers->surname.' '.$pers->name))."
						<div id=$v class='close_this'></div>
					</div>";
					}
				}
			}	
		$result.="<div class='add_post add_unit'>Добавить</div></div>";
		return $result;
	} */

	public static function multiOperations($model,$field){
		Yii::app()->clientScript->registerPackage('customfields');
		$mn=get_class($model);
		$result="<div class='multichoise' id='".$field."'><div id='".$field."' class='add_unit add_oper'>Изменить</div>";
				echo'<input type=hidden name=field class=field id='.$field.' value='.$field.'>';
				echo'<input type=hidden name=modelN class=modelN id='.$field.' value='.$mn.'>';
				echo'<input type=hidden name=action class=action id='.$field.' value="join">';
				echo"<input type=hidden name='".$mn."[".$field."][]' value=''>";
				if(!empty($model->$field)){
					foreach ($model->$field as $v){
						if(!empty($v)){
							$oper=ListOperations::model()->findByPk($v);
							$result.="<div class='choise_unit $field$v'>
								<input type=hidden name='".$mn."[".$field."][$v]' value=$v>".(CHtml::encode($oper->name))."
								<div id=$field$v class='close_this'></div>
							</div>";
						}
					}
				}	
				
		$result.="</div>";
		return $result;
	}


	public static function multiPersonnel($model,$field,$action='add_person'){
		Yii::app()->clientScript->registerPackage('customfields');
		$mn=get_class($model);
		$result="<div class='multichoise' id='".$field."'><div id='".$field."' class='add_unit ".$action."'>Изменить</div>";
				echo'<input type=hidden name=field class=field id='.$field.' value='.$field.'>';
				echo'<input type=hidden name=modelN class=modelN id='.$field.' value='.$mn.'>';
				echo'<input type=hidden name=action class=action id='.$field.' value="join">';
				echo"<input type=hidden name='".$mn."[".$field."][]' value=''>";
				if(!empty($model->$field)){
					foreach ($model->$field as $v){
						if(!empty($v)){
							$pers=Personnel::model()->findByPk($v);
							$result.="<div class='choise_unit $field$v'>
								<input type=hidden name='".$mn."[".$field."][$v]' value=$v>".(CHtml::encode($pers->fio()))."
								<div id=$field$v class='close_this'></div>
							</div>";
						}
					}
				}	
				
		$result.="</div>";
		return $result;
	}

	public static function searchPersonnel($model,$field)
	{
		Yii::app()->clientScript->registerPackage('customfields');
			$mn=get_class($model);
			$result="<div class='multichoise' id='".$field."'><div id='".$field."' class='add_unit add_person'>Изменить</div>";
				echo"<input type=hidden name='".$mn."[".$field."]' value=''>"; //Это чтоб было пустое значение
				echo'<input type=hidden name=field class=field id='.$field.' value='.$field.'>';
				echo'<input type=hidden name=modelN class=modelN id='.$field.' value='.$mn.'>';
				echo'<input type=hidden name=action class=action id='.$field.' value="replace">';
					$tmp=$model->$field; 
						if(!empty($tmp)){
							$pers=Personnel::model()->findByPk($tmp);
							$result.="<div class='choise_unit $field$tmp'>
								<input type=hidden name='".$mn."[".$field."]' value=$tmp>".(CHtml::encode($pers->fio()))."
								<div id=$field$tmp class='close_this'></div>
							</div>";
						}
				
				
		$result.="</div>";
		return $result;
		# code...
	}
}

?>