<?php 
Class ActionHelper{
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

	public static function message(){
		return '<div class=modal_window_back style="display: none"></div>
		<div id="add_act" class="add_unit fl_right">добавить сообщение</div>
		<div style="border: 1px solid grey; position: absolute; margin-top: 40px; z-index: 88; display: none; background: #F0F0F0" class=modal_window>
		<div class=close_this style="align: right; "></div>
			<textarea style="width: 98%;" name="message" id="message" placeholder="сохранить комментарий: ctrl+enter"></textarea><br>
			<input type=button name="put_message" id="put_message" value="сохранить комментарий">
		</div>
		<div style="position: relative; clear: both;"></div>';
	}

	public static function info($model){
		return '<input type=hidden name=idmodel id=idmodel value="'.$model->id.'">
		<input type=hidden name=factoryObj id=factoryObj value="'.$model->tableName().'">';
	}
}
?>