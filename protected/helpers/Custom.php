<?php
class Custom{
	public static function deadclockwrap($v){
		if(!empty($v->deadline)){
			$interval=$v->deadKlok();
			if(!empty($interval[0])){
				$color='red';
			}else{
				$color='#040404';
			}
			
			return '<span style="float: left; color: '.$color.'">'.$interval[0].($days=($interval[1]!=0)?$interval[1].'д. ':'').($hours=($interval[2]!=0)?$interval[2].'ч.':'').($min=(($interval[1]+$interval[2])==0)?$interval[3].'мин.':'').'</span>';
		}
	}

	public static function attachFileField($model){
		return'
		<div class="row findTxArea" model="'.trim(get_class($model)).'" style="position: relative"><img src="'.Yii::app()->request->baseUrl.'/images/attachFile24.png" class="simplyAttach">'.$model->FileModel->attachedFilesFormView().'</div>';
	}

	public static function short_date($value){
        if(!empty($value)){
            return date('d.m.y H:i', strtotime($value));
        }
    }
}