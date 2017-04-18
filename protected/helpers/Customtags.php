<?php
class Customtags{
	public static function deadclockwrap($v){
		if(!empty($v->deadline)){
			$interval=$v->deadKlok();
			if($interval[0]<0){
				$color='red';
				$minus='-';
			}else{
				$color='#040404';
				$minus='';	
			}
			
			return '<span style="float: left; color: '.$color.'">'.($days=($interval[0]!=0)?$interval[0].'д. ':$minus).$interval[1].'ч.</span>';
		}
	}
}
?>