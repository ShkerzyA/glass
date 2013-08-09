<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
 
    public function authenticate()
    {
        $username=strtolower($this->username);
        $user=Users::model()->find('LOWER(username)=?',array($username));
        if($user===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if(!$user->validatePassword($this->password))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id=$user->id;
            $this->username=$user->username;
            $this->setState('surname', $user->personnels->surname);
            $this->setState('name', $user->personnels->name);
            $this->setState('patr', $user->personnels->patr);

            $temp='';
            $id_posts=array();
            if(!empty($user->personnels->personnelPostsHistories))
            foreach ($user->personnels->personnelPostsHistories as $v){
                $temp.=$v->idPost->groups;
                $id_posts[]=$v->idPost->id;
            }
            $temp=explode(',',$temp);
            $groups=array_unique($temp);

            $this->setState('groups', $groups);
            $this->setState('id_posts',$id_posts);
            $this->errorCode=self::ERROR_NONE;
        }
        return $this->errorCode==self::ERROR_NONE;
    }


 
    public function getId()
    {
        return $this->_id;
    }
}