<?php 
class MultichoiseBehavior extends CActiveRecordBehavior{

    public $own=array('DepartmentPosts'=>'groups','Tasks'=>'executors','Rooms'=>'managers','Catalogs'=>'groups');

    private function getField(){
        $model_name=trim(get_class($this->owner));
        $val=$this->own[$model_name];
        return $val;
    }

    public function beforeSave($event){
            // автоматически передаём каждое сообщение роутеру лога
//Yii::getLogger()->autoFlush = 1;
// автоматически пишем сообщения при получении логгером
//Yii::getLogger()->autoDump = true;


            
            $val=$this->getField();
            if(isset($_POST['group_anchor'])){
                   if(!empty($_POST[$val])){
                    $tmp=$_POST[$val];
                     if (is_array($tmp)){
                        $tmp=array_unique($tmp);
                        $this->owner->$val=implode(',',$tmp);
                    }
                } else {
                        $this->owner->$val='';
                }
            }      //array_unique чтоб одинаковых групп кучу не вписывали  
            $this->owner->$val='{'.$this->owner->$val.'}';
           

                    
    }

    public function afterFind($event) {
        $val=$this->getField();
        if($this->owner->scenario=='update'){
            if(!empty($this->owner->$val)){
                $tmp=substr($this->owner->$val,1,-1);
                $this->owner->$val=$tmp;
            }
        }
    }
} 
?>