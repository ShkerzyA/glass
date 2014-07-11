<?php
return array (
  'index' => 
  array (
    'type' => 0,
    'description' => 'Просмотр',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'view' => 
  array (
    'type' => 0,
    'description' => 'Просмотр',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'create' => 
  array (
    'type' => 0,
    'description' => 'Создать',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'update' => 
  array (
    'type' => 0,
    'description' => 'Изменить',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'admin' => 
  array (
    'type' => 0,
    'description' => 'Управление',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'delete' => 
  array (
    'type' => 0,
    'description' => 'Удалить',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'save' => 
  array (
    'type' => 0,
    'description' => 'Сохранить',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'saveMessage' => 
  array (
    'type' => 0,
    'description' => 'Сохранить Сообщение',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'changeObjects' => 
  array (
    'type' => 0,
    'description' => 'Создавать и изменять Здания, Этажи, Кабинеты, Рабочие места, Оборудование',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'saveStatus' => 
  array (
    'type' => 0,
    'description' => 'Изменить статус Задачи',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'saveStatusEv' => 
  array (
    'type' => 0,
    'description' => 'Изменить статус События',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateEv' => 
  array (
    'type' => 0,
    'description' => 'Редактировать событие',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateTs' => 
  array (
    'type' => 0,
    'description' => 'Редактировать задачу',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'operationSV' => 
  array (
    'type' => 0,
    'description' => 'Управление планом операций',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'monitoringOper' => 
  array (
    'type' => 0,
    'description' => 'Право на мониторинг операций',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'ruleWorkplaces' => 
  array (
    'type' => 0,
    'description' => 'Управление рабочими местами',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'OwnSaveStatus' => 
  array (
    'type' => 1,
    'description' => 'Изменение статуса задач своего отдела',
    'bizRule' => 'return $params["mod"]->isChangeStatus();',
    'data' => NULL,
    'children' => 
    array (
      0 => 'saveStatus',
    ),
  ),
  'ManagerSaveStatusEv' => 
  array (
    'type' => 1,
    'description' => 'Изменение подконтрольных событий',
    'bizRule' => 'return $params["mod"]->isChangeStatus();',
    'data' => NULL,
    'children' => 
    array (
      0 => 'saveStatusEv',
    ),
  ),
  'monitoringOperUser' => 
  array (
    'type' => 1,
    'description' => 'Право на мониторинг операции в конкретной операционной',
    'bizRule' => 'return $params["mod"]->isManagerUser()',
    'data' => NULL,
    'children' => 
    array (
      0 => 'monitoringOper',
    ),
  ),
  'OwnUpdateEv' => 
  array (
    'type' => 1,
    'description' => 'Изменение своих событий',
    'bizRule' => 'return $params["mod"]->isOwner();',
    'data' => NULL,
    'children' => 
    array (
      0 => 'updateEv',
    ),
  ),
  'OwnUpdateTs' => 
  array (
    'type' => 1,
    'description' => 'Изменение своих событий',
    'bizRule' => 'return $params["mod"]->mayUserUpd();',
    'data' => NULL,
    'children' => 
    array (
      0 => 'updateTs',
    ),
  ),
  'userOperationSV' => 
  array (
    'type' => 1,
    'description' => 'Управление операциями',
    'bizRule' => '
    if(!Yii::app()->user->isGuest){
    	return in_array("operationsv",Yii::app()->user->groups);
    }else{
    	return false;
    }
    ',
    'data' => NULL,
    'children' => 
    array (
      0 => 'operationSV',
    ),
  ),
  'guest' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'index',
      1 => 'view',
    ),
  ),
  'user' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'guest',
      1 => 'create',
      2 => 'saveMessage',
      3 => 'OwnSaveStatus',
      4 => 'ManagerSaveStatusEv',
      5 => 'userOperationSV',
      6 => 'monitoringOperUser',
      7 => 'OwnUpdateEv',
      8 => 'OwnUpdateTs',
    ),
  ),
  'moderator' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'user',
      1 => 'update',
      2 => 'delete',
      3 => 'save',
      4 => 'changeObjects',
      5 => 'ruleWorkplaces',
      6 => 'monitoringOper',
      7 => 'saveStatus',
      8 => 'saveStatusEv',
      9 => 'updateEv',
      10 => 'updateTs',
      11 => 'operationSV',
    ),
  ),
  'administrator' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'moderator',
      1 => 'admin',
    ),
  ),
);
