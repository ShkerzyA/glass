<?php 
class FixedOwnerBehavior extends CActiveRecordBehavior{
    
    public $own=array('Docs'=>'creator','Catalogs'=>'owner','Tasks'=>'creator','TasksActions'=>'creator','Events'=>'creator','Eventsoper'=>'creator','EventsActions'=>'creator');

    public function beforeSave($event){
       if($this->owner->scenario=='insert'){
            $model_name=trim(get_class($this->owner));
            $val=$this->own[$model_name];
            switch ($model_name) {
                default:
                        $this->owner->$val=Yii::app()->user->id_pers; 
                    break;
            }

            return true;
        }
    }

} 
?>