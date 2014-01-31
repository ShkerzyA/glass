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
        if(property_exists($this->owner, 'timestamp_end')){
            if(!empty($this->owner->timestamp_end)){
                $this->owner->timestamp_end = date('Y-m-d H:i:s', strtotime($this->owner->timestamp_end));//strtotime($this->date_start);
            }else{
                $this->owner->timestamp_end=null;
            }  
        }
        
    }

    public function afterFind($event) {

        if(!empty($this->owner->timestamp)){
            $date = date('d.m.Y H:i:s', strtotime($this->owner->timestamp));
            $this->owner->timestamp = $date;
        }

         if(!empty($this->owner->timestamp_end)){
            $date = date('d.m.Y', strtotime($this->owner->timestamp_end));
            $this->owner->timestamp_end = $date;
        }
    }
} 
?>