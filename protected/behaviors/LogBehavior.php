<?php 
class LogBehavior extends CActiveRecordBehavior{
    public $old_model;
    public $model_name;
    public $ignore=array('photo');

    private function anyway($x){
        if(is_array($x)){
            return implode(',',$x);
        }else{
            return $x;
        }
    }

    public function beforeSave($event){
        $model_name=trim(get_class($this->owner));
        $this->model_name=$model_name;
        if($this->owner->scenario!='insert'){
            $this->old_model=$model_name::model()->findByPk($this->owner->id);
            $this->old_model->beforeSave(True);
        }
    }

    public function afterSave($event){
        if($this->owner->scenario!='insert'){
            if (empty($this->old_model))
                return false;
            $chanded=array();
            foreach ($this->owner->attributes as $k => $v) {
                if(in_array($k,$this->ignore))
                    continue;
                if($v!=$this->old_model->$k){
                    switch ($k) {
                        default:
                            $a=str_replace(array('{','}'),'',$this->old_model->$k);
                            $a=str_replace(array(','),'|',$a);
                            $b=str_replace(array('{','}'),'',$v);
                            $b=str_replace(array(','),'|',$b);
                            $chanded[]=$this->owner->getAttributeLabel($k).": ".$a."/".$b."\n";   
                            break;
                    }
 
                }
            }
            if(!empty($chanded)){
                $log=new Log;
                $log->saveLog('change',array('details'=>$chanded,'object_model'=>$this->model_name,'object_id'=>$this->owner->id));
            }
            
        }else if($this->owner->scenario=='insert'){
                $log=new Log;
                $log->saveLog('add',array('details'=>array(),'object_model'=>$this->model_name,'object_id'=>$this->owner->id));
        }
        
    }
}