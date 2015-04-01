<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    protected $_id;
 
    public function authenticate()
    {
        $username=strtolower($this->username);
        $user=Users::model()->find('LOWER(username)=?',array($username));
        if($user===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if(!$user->validatePassword($this->password)){
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        }
        else
        {
            $this->_id = $user->id;
            $this->username=$user->username;
            $this->setState('username', $user->username);
            $this->setState('startpage', $user->startpage);
            $this->setState('bg', $user->bg);
            if(!empty($user->personnels)){
                $this->setState('surname', $user->personnels->surname);
                $this->setState('name', $user->personnels->name);
                $this->setState('patr', $user->personnels->patr);
                $this->setState('id_pers', $user->personnels->id);
            }else{
                $this->setState('id_pers', -1);      
            }
            $this->setState('last_task','');

            $temp=array();
            $id_posts=array();
            $id_departments=array();
            $departments_rn=array();

            $islead=0;

            if(!empty($user->personnels->personnelPostsHistories)){
            $this->setState('postname', $user->personnels->personnelPostsHistories[0]->idPost->post);
            foreach ($user->personnels->personnelPostsHistories as $v){
                $temp=array_merge($temp,$v->idPost->groups);
                $id_posts[]=$v->idPost->id;
                $id_departments[]=$v->idPost->postSubdivRn->id;
                $departments_rn[]=$v->idPost->postSubdivRn->subdiv_rn;
                if($v->idPost->islead==1){
                    $islead=1;
                }
            }
            }
            $groups=array_unique($temp);

            if(!empty($groups)){
                $this->setState('groups', $groups);
            }else{
                $this->setState('groups', -1);
            }
            $this->setState('viewChat',0);
            $this->setState('id_posts',$id_posts);
            $this->setState('id_departments',$id_departments);
            $this->setState('departments_rn',$departments_rn);
            $this->setState('islead',$islead);
            $this->errorCode=self::ERROR_NONE;
            Yii::app()->request->cookies['pers'] = new CHttpCookie('pers', $user->personnels->fio());
        }
        return $this->errorCode==self::ERROR_NONE;
    }
 
    public function getId()
    {
        return $this->_id;
    }
}