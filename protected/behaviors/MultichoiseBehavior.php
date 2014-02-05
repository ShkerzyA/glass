<?php 
class MultichoiseBehavior extends CActiveRecordBehavior{


    public function beforeSave($event){

            if(isset($this->owner->groups)){
                if(!empty($_POST['groups'])){
                    $tmp=$_POST['groups'];
                    if (is_array($tmp)){
                        $tmp=array_unique($tmp);
                        $this->owner->groups=implode(',',$tmp);
                     }
                }
                $this->owner->groups='{'.$this->owner->groups.'}';
                    //array_unique чтоб одинаковых групп кучу не вписывали  
            } 

            if(isset($this->owner->executors)){
                if(!empty($_POST['executors'])){
                    $tmp=$_POST['executors'];
                    if (is_array($tmp)){
                        $tmp=array_unique($tmp);
                        $this->owner->executors=implode(',',$tmp);
                    }
                } 
                $this->owner->executors='{'.$this->owner->executors.'}';       //array_unique чтоб одинаковых групп кучу не вписывали  
            }
                
    }

    public function afterFind($event) {
        if($this->owner->scenario=='update'){
            if(!empty($this->owner->groups)){
                $tmp=substr($this->owner->groups,1,-1);
                $this->owner->groups=$tmp;
            }
            if(!empty($this->owner->executors)){
                $tmp=substr($this->owner->executors,1,-1);
                $this->owner->executors=$tmp;
            }
            
        }
    }
} 
?>