<?php
class WebUser extends CWebUser {
    private $_model = null;
    
   public function getRole() {
        if($user = $this->getModel()){
            // в таблице User есть поле role
            return $user->idPost->role;
        }
    }

    public function checkAccess($operation,$params=array(),$allowCaching=true)
    {
        if ($this->isGuest) //защита от дохлых аттрибутов у гостя. Если передаются параметры - значит task
            return false;
        return parent::checkAccess($operation,$params,$allowCaching);
    }
 
    private function getModel(){
        if (!$this->isGuest && $this->_model === null){
            $this->_model = Users::model()->findByPk($this->id);
        }
        return $this->_model;
    }
} ?>