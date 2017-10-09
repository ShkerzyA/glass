<?php 
class FileModelBehavior extends CActiveRecordBehavior{
    
	public function attachedFilesFormView(){
		$model_name=trim(get_class($this->owner));
		$res='';
		if(!empty($this->owner->files))
			foreach ($this->owner->files as $v) {
				$res.='<div class="icowithdel"><div class="remove_this"></div><input type=hidden name='.$model_name.'[files][] value='.$v->id.'>'.$v->getFile(true,false,true).'</div>';
			}
			return $res;
	}

	public function attachedFilesView(){
		$model_name=trim(get_class($this->owner));
		$res='';
		if(!empty($this->owner->files))
			foreach ($this->owner->files as $v) {
				$res.='<div class="icowithdel"><input type=hidden name='.$model_name.'[files][] value='.$v->id.'>'.$v->getFile(true,true,true).'</div>';
			}
			return $res;
	}

	public function attachInText($text){
		if(!empty($this->owner->files))
		foreach ($this->owner->files as $k => $v) {
			$text=str_replace('['.($k+1).']',$v->getFile(true,true,false), $text);	
		}
		return $text;

	}
   
} 
?>