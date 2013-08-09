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
                    //array_unique чтоб одинаковых групп кучу не вписывали  
                }
                $this->owner->groups='{'.$tmp.'}';
    }

    public function afterFind($event) {
        if((!empty($this->owner->groups)) && ($this->owner->scenario=='update')){

            $tmp=substr($this->owner->groups,1,-1);
            $mass=explode(',', $tmp);
            $tmp=implode(',',$mass);
            
            $this->owner->groups=$tmp;
        }
    }
} 
?>