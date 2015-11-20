<?php 
class DateBeginEndBehavior extends CActiveRecordBehavior{
    public function working(){
        $alias=$this->owner->getTableAlias();
        $this->owner->getDbCriteria()->mergeWith(
            array('condition'=>'"'.$alias.'".date_end is null or "'.$alias.'".date_end>current_date'));
        return $this->owner;
    }

    public function fired(){
        $alias=$this->owner->getTableAlias();
        $this->owner->getDbCriteria()->mergeWith(
            array('condition'=>'"'.$alias.'".date_end<current_date'));
        return $this->owner;
    }


    /*
    public function scopeWorking(){
        $alias=$this->owner->getTableAlias();
        return array('criteria'=>"($alias.date_end is null or $alias.date_end>current_date)"); // возвращаем массив условий, которые должны применяться. В массиве, кроме condition, могут использоваться и другие элементы, используемые в yii-запросах: order, limit и т.д.
    } */

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

        if(!empty($this->owner->date_begin)){
            $this->owner->date_begin=date('Y-m-d', strtotime($this->owner->date_begin));
        }else{
            $this->owner->date_begin=date('Y-m-d'); 
        } 
        
        if(!empty($this->owner->date_end)){
            $this->owner->date_end = date('Y-m-d', strtotime($this->owner->date_end));//strtotime($this->date_start);
        }else{
            $this->owner->date_end=null;
        }
    }

    public function afterFind($event) {

        if(!empty($this->owner->date_begin)){
            $date = date('Y-m-d', strtotime($this->owner->date_begin));
            $this->owner->date_begin = $date;
        }

        if(!empty($this->owner->date_end)){
            $date = date('Y-m-d', strtotime($this->owner->date_end));
            $this->owner->date_end = $date;
        }
    }
} 