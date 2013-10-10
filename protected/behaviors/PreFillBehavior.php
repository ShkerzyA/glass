<?php 
class PreFillBehavior extends CActiveRecordBehavior{

    public function afterConstruct($event){
        if (Yii::app()->controller->action->id=="create"){
            $model_name=trim(get_class($this->owner));
            if(!empty($_GET[$model_name])){
                $this->owner->attributes=$_GET[$model_name];
            }
        }
    }
} 

?>