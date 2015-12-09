<?php 
class DbArrayBehavior extends CActiveRecordBehavior{

    private function getField(){
        $model_name=trim(get_class($this->owner));
        $val=$model_name::$db_array;
        return $val;
    }
    
    public function beforeValidate($event){
        $fields=$this->getField();
        //print_r($fields);
        foreach ($fields as $val) {
            if(!empty($this->owner->$val)){
                if(is_array($this->owner->$val)){
                    $array_empty = array(null);
                    $this->owner->$val = array_diff($this->owner->$val, $array_empty);
                    //$this->owner->$val=array_filter($this->owner->$val);               
                    $this->owner->$val=implode(',',$this->owner->$val);
                }
                $this->owner->$val='{'.$this->owner->$val.'}';
            }
            else
                $this->owner->$val=NULL;
        }

    }


    public function afterValidate($event){
        $fields=$this->getField();
        foreach ($fields as $val) {
                if(!empty($this->owner->$val)){
                    $tmp=substr($this->owner->$val,1,-1);
                    $this->owner->$val=explode(',',$tmp);
                    //echo $val;
                }else{
                    $this->owner->$val=array();
                }
          //  }
        }
    }

    public function beforeSave($event){
        $fields=$this->getField();
        //print_r($fields);
        foreach ($fields as $val) {
            if(!empty($this->owner->$val)){
                if(is_array($this->owner->$val)){
                    $array_empty = array(null);
                    $this->owner->$val = array_diff($this->owner->$val, $array_empty);
                    //$this->owner->$val=array_filter($this->owner->$val);               
                    $this->owner->$val=implode(',',$this->owner->$val);
                }
                $this->owner->$val='{'.$this->owner->$val.'}';
            }
            else
                $this->owner->$val=NULL;
        }
    } 



    public function afterFind($event) {
        $fields=$this->getField();
        foreach ($fields as $val) {
                if(!empty($this->owner->$val)){
                    $tmp=substr($this->owner->$val,1,-1);
                    $this->owner->$val=explode(',',$tmp);
                    //echo $val;
                }else{
                    $this->owner->$val=array();
                }
          //  }
        }
    }
}