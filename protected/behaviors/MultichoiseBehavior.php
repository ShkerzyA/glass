<?php 
class MultichoiseBehavior extends CActiveRecordBehavior{


    public function beforeSave($event){
                if(!empty($this->owner->groups)){
                    $this->owner->groups='{'.$this->owner->groups.'}';
                }
    }

    public function afterFind($event) {

        if(!empty($this->owner->groups)){
            $this->owner->groups=substr($this->owner->groups,1,-1);
        }
    }
} 
?>