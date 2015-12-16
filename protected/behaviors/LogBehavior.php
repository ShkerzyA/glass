<?php 
class LogBehavior extends CActiveRecordBehavior{
    public $old_model;
    public $model_name;
    public $ignore=array('photo');

    private function anyway($x){
        if(is_array($x)){
            $x=implode('|',$x);
            
        }
        $x=str_replace(array('{','}'),'',$x);
        $x=str_replace(array(','),'|',$x);
        return $x;
    }

    public function active(){
        $alias=$this->owner->getTableAlias(false,false);
        $this->owner->getDbCriteria()->mergeWith(array(
            'condition'=>"(\"$alias\".deactive <> 1 or \"$alias\".deactive is null)"
        ));
        return $this->owner;
    }
    
    public function beforeSave($event){
        $model_name=trim(get_class($this->owner));
        $this->model_name=$model_name;
        if($this->owner->scenario!='insert'){
            $this->old_model=$model_name::model()->findByPk($this->owner->id);
        }
    }

    public function afterSave($event){
        switch ($this->owner->scenario) {
            case 'insert':
                    $log=new Log;
                    $log->saveLog('add',array('details'=>array(),'object_model'=>$this->model_name,'object_id'=>$this->owner->id));
                break;

             case 'accountingCar':
                    $log=new Log;
                    $log->saveLog('accountingCar',array('details'=>array($this->owner->status),'object_model'=>$this->model_name,'object_id'=>$this->owner->id));
                break;
            
            default:
                if (empty($this->old_model))
                    return false;
                $chanded=array();
                foreach ($this->owner->attributes as $k => $v) {
                    if(in_array($k,$this->ignore))
                        continue;
                    if(trim($this->anyway($v))!=trim($this->anyway($this->old_model->$k))){
                        switch ($k) {
                            default:
                                $a=$this->anyway($this->old_model->$k);
                                $b=$this->anyway($v);
                                $chanded[]=$this->owner->getAttributeLabel($k).": ".$a."/".$b."\n";   
                                break;
                        }
 
                    }
                }
                if(!empty($chanded)){
                    $log=new Log;
                    $log->saveLog('change',array('details'=>$chanded,'object_model'=>$this->model_name,'object_id'=>$this->owner->id));
                }
                break;
        }
        
    }
}