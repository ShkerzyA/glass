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

    public function short_date($field){
        if(!empty($this->owner->$field)){
            return date('d.m.y H:i', strtotime($this->owner->timestamp));
        }
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

        if(isset($this->owner->timestamp_start)){
            if(!empty($this->owner->timestamp_start)){
                $this->owner->timestamp_start=date('Y-m-d H:i:s', strtotime($this->owner->timestamp_start));//strtotime($this->date_start);
            }else{
                $this->owner->timestamp_start=NULL;
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

        if(!empty($this->owner->timestamp_start)){
            $date = date('d.m.Y H:i:s', strtotime($this->owner->timestamp_start));
            $this->owner->timestamp_start = $date;
        }
    }
} 
?>