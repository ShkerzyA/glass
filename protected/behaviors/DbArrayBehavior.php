<?php 
class DbArrayBehavior extends CActiveRecordBehavior{

    private function getField(){
        $model_name=trim(get_class($this->owner));
        $val=$model_name::$db_array;
        return $val;
    }


    public function beforeSave($event){
        $fields=$this->getField();
        foreach ($fields as $val) {
            if(!empty($this->owner->$val))
                $this->owner->$val='{'.$this->owner->$val.'}';
            else
                $this->owner->$val=NULL;
        }
    }

    public function afterFind($event) {
        $fields=$this->getField();
        foreach ($fields as $val) {
           // if($this->owner->scenario=='update'){
                if(!empty($this->owner->$val)){
                    $tmp=substr($this->owner->$val,1,-1);
                    $this->owner->$val=$tmp;
                    //echo $val;
                }
          //  }
        }
    }
} 
?>