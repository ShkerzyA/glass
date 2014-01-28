<?php 
class TimeStampBehavior extends CActiveRecordBehavior{


    public function working(){
        $alias=$this->owner->getTableAlias();
        $this->owner->getDbCriteria()->mergeWith(
            array('condition'=>"$alias.date_end is null or $alias.date_end>current_date"));
        return $this->owner;
    }

    public function inactive(){
        if(empty($this->owner->date_end))
            return False;

        $d1=new DateTime($this->owner->date_end);
        $d2=new DateTime();
        if ($d1>$d2){
            return False;
        }else{
            return True;
        }
    }


    public function beforeSave($event){

        if(!empty($this->owner->timestamp)){
            $this->owner->timestamp=date('Y-m-d H:i:s', strtotime($this->owner->timestamp));
        }else{
            $this->owner->timestamp=date('Y-m-d H:i:s'); 
        }
    }

    public function afterFind($event) {

        if(!empty($this->owner->timestamp)){
            $date = date('d.m.Y H:i:s', strtotime($this->owner->timestamp));
            $this->owner->timestamp = $date;
        }
    }
} 
?>