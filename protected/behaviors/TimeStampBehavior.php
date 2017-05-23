<?php 
class TimeStampBehavior extends CActiveRecordBehavior{



    public function actual(){

        $now=new DateTime();

        $now->format();

        $alias=$this->owner->getTableAlias();
        $this->owner->getDbCriteria()->mergeWith(
            array('condition'=>"$alias.timestamp  or $alias.timestamp_end>current_date"));
        return $this->owner;
    }



    public function beforeSave($event){

        if(!empty($this->owner->timestamp)){
            $this->owner->timestamp=date('Y-m-d H:i:s', strtotime($this->owner->timestamp));
        }else{
            $this->owner->timestamp=date('Y-m-d H:i:s'); 
        }
        if(isset($this->owner->timestamp_end)){
            if(!empty($this->owner->timestamp_end)){
                $this->owner->timestamp_end=date('Y-m-d H:i:s', strtotime($this->owner->timestamp_end));//strtotime($this->date_start);
            }else{
                $this->owner->timestamp_end=NULL;
            }  
        }

        if(isset($this->owner->deadline)){
            if(!empty($this->owner->deadline)){
                $this->owner->deadline=date('Y-m-d H:i:s', strtotime($this->owner->deadline));//strtotime($this->date_start);
            }else{
                $this->owner->deadline=NULL;
            }  
        }
        
    }

    public function afterFind($event) {

        if(!empty($this->owner->timestamp)){
            $date = date('d.m.Y H:i:s', strtotime($this->owner->timestamp));
            $this->owner->timestamp = $date;
        }

         if(!empty($this->owner->timestamp_end)){
            $date = date('d.m.Y H:i:s', strtotime($this->owner->timestamp_end));
            $this->owner->timestamp_end = $date;
        }

          if(!empty($this->owner->deadline)){
            $date = date('d.m.Y H:i:s', strtotime($this->owner->deadline));
            $this->owner->deadline = $date;
        }
    }
} 
?>