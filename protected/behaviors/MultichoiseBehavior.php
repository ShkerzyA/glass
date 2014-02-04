<?php 
class MultichoiseBehavior extends CActiveRecordBehavior{


    public function beforeSave($event){
                if(!empty($_POST['groups'])){
                    $tmp=$_POST['groups'];
                    if (is_array($tmp)){
                        $tmp=array_unique($tmp);
                        $tmp=implode(',',$tmp);
                    }else{
                        $tmp='';
                    }
                    $this->owner->groups='{'.$tmp.'}';
                    //array_unique чтоб одинаковых групп кучу не вписывали  
                }

                if(!empty($_POST['executors'])){
                    $tmp=$_POST['executors'];
                    if (is_array($tmp)){
                        $tmp=array_unique($tmp);
                        $tmp=implode(',',$tmp);
                    }else{
                        $tmp='';
                    }
                    $this->owner->executors='{'.$tmp.'}';
                    //array_unique чтоб одинаковых групп кучу не вписывали  
                }
    }

    public function afterFind($event) {
        if($this->owner->scenario=='update'){
            if(!empty($this->owner->groups)){
                $tmp=substr($this->owner->groups,1,-1);
                $mass=explode(',', $tmp);
                $tmp=implode(',',$mass);
                $this->owner->groups=$tmp;
            }
            if(!empty($this->owner->executors)){
                $tmp=substr($this->owner->executors,1,-1);
                $mass=explode(',', $tmp);
                $tmp=implode(',',$mass);
                $this->owner->executors=$tmp;
            }
            
        }
    }
} 
?>