<?php 
class DateBeginEndBehavior extends CActiveRecordBehavior{


    public function working(){
        $alias=$this->owner->getTableAlias();
        $this->owner->getDbCriteria()->mergeWith(
            array('condition'=>"$alias.date_end is null or $alias.date_end>current_date"));
        return $this->owner;
    }

    public function beforeSave($event){
                if(!empty($this->owner->date_begin)){
                    $this->owner->date_begin = date('Y-m-d', strtotime($this->owner->date_begin));//strtotime($this->date_start);
                }else{
                    $this->owner->date_begin=null;
                }

                if(!empty($this->owner->date_end)){
                    $this->owner->date_end = date('Y-m-d', strtotime($this->owner->date_end));//strtotime($this->date_start);
                }else{
                    $this->owner->date_end=null;
                }
    }

    public function afterFind($event) {

        if(!empty($this->owner->date_begin)){
            $date = date('d.m.Y', strtotime($this->owner->date_begin));
            $this->owner->date_begin = $date;
        }

        if(!empty($this->owner->date_end)){
            $date = date('d.m.Y', strtotime($this->owner->date_end));
            $this->owner->date_end = $date;
        }
    }
} 
?>