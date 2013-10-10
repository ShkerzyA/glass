<?php 
class FixedOwnerBehavior extends CActiveRecordBehavior{
    
    public $own=array('Docs'=>'creator','Catalogs'=>'owner');

    public function beforeSave($event){
    	echo 'кукуцаполь';
       if($this->owner->scenario=='insert'){
            $model_name=trim(get_class($this->owner));
            $val=$this->own[$model_name];
            $this->owner->$val=Yii::app()->user->id_posts[0];  

            return true;
        }
    }

} 
?>