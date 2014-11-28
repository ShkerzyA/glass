<?php 
class PreFillBehavior extends CActiveRecordBehavior{

    public function afterConstruct($event){
        if ($this->owner->scenario=='insert'){
            $model_name=trim(get_class($this->owner));
            if(!empty($_GET[$model_name])){
                $this->owner->attributes=$_GET[$model_name];
            }
            if(!empty(Yii::app()->session[$model_name])){
                $this->owner->attributes=Yii::app()->session[$model_name];
            }
        }
    } 

} 

?>