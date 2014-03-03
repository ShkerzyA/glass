<?php 
class FixedOwnerBehavior extends CActiveRecordBehavior{
    
    public $own=array('Docs'=>'creator','Catalogs'=>'owner','Tasks'=>'creator','TasksActions'=>'creator','Events'=>'creator','EventsActions'=>'creator');

    public function beforeSave($event){
       if($this->owner->scenario=='insert'){
            $model_name=trim(get_class($this->owner));
            $val=$this->own[$model_name];
            switch ($model_name) {
                case 'TasksActions':
                case 'EventsActions':
                        $this->owner->$val=Yii::app()->user->id_pers;  
                    break;
                default:
                        $this->owner->$val=Yii::app()->user->id_posts[0];  
                    break;
            }

            return true;
        }
    }

} 
?>