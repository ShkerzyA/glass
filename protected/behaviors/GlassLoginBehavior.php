<?php 
class GlassLoginBehavior extends CActiveRecordBehavior{
	
    public function validatePassword($password)
    {
        //return True;
        return ($this->hash($password)==$this->owner->password);

    }

    public function beforeSave($event)
    {
        if(0<(strlen($this->owner->password)) and (strlen($this->owner->password)<25)){
            $this->owner->password = $this->hash($this->owner->password);    
        }else{
            unset($this->owner->password);
        }
        return true;
    }

    public function hash($password)
    {
        return base64_encode(pack('H*', sha1((trim($password)))));
    } 
} 