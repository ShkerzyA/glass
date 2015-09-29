<?php 
class FixedOwnerBehavior extends CActiveRecordBehavior{
    
    public $own=array('EquipmentLog'=>'subject','Projects'=>'creator','Docs'=>'creator','Catalogs'=>'owner','Tasks'=>'creator','MedicalEquipment'=>'creator','Messages'=>'creator','TasksActions'=>'creator','Events'=>'creator','Eventsoper'=>'creator','EventsActions'=>'creator');

    public function beforeSave($event){
       if($this->owner->scenario=='insert'){
            $model_name=trim(get_class($this->owner));
            $val=$this->own[$model_name];
            switch ($model_name) {
                default:
                        $id_pers=(!empty(Yii::app()->user->id_pers))?Yii::app()->user->id_pers:NULL;
                        $this->owner->$val=$id_pers; 
                    break;
            }
            return true;
        }
    }
}