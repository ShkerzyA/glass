<?php
class Customtags{
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
}
?>