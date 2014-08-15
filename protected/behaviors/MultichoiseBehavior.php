<?php 
class MultichoiseBehavior extends CActiveRecordBehavior{

    private function getField(){
        $model_name=trim(get_class($this->owner));
        //echo $model_name;
        //$val=$this->own[$model_name];
        $val=$model_name::$multifield;
        return $val;
    }

    public function beforeValidate($event){
            // автоматически передаём каждое сообщение роутеру лога
//Yii::getLogger()->autoFlush = 1;
// автоматически пишем сообщения при получении логгером
//Yii::getLogger()->autoDump = true;

        $fields=$this->getField();
        if(isset($_POST['group_anchor'])){
            foreach ($fields as $val) {
                if(!empty($_POST[$val])){
                    $tmp=$_POST[$val];
                    unset($_POST['group_anchor']);
                    unset($_POST[$val]);
                    if(is_array($tmp)){
                        $tmp=array_unique($tmp);
                        $this->owner->$val=implode(',',$tmp);
                    }
                } else {
                    $this->owner->$val='';
                }
            }      //array_unique чтоб одинаковых групп кучу не вписывали  
        }
    }

    public function beforeSave($event){
        $fields=$this->getField();
        foreach ($fields as $val) {
            $this->owner->$val='{'.$this->owner->$val.'}';
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