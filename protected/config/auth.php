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
  'inGroup' => 
  array (
    'type' => 0,
    'description' => 'Принадлежность группе',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'inGroupAndOwner' => 
  array (
    'type' => 0,
    'description' => 'Принадлежность группе и владелец объекта манипуляции',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'medicalEquipment' => 
  array (
    'type' => 0,
    'description' => 'Мониторинг мед. оборудования',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'taskReport' => 
  array (
    'type' => 0,
    'description' => 'Формирование отчета из задач',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'otdReport' => 
  array (
    'type' => 0,
    'description' => 'Формирование отчета из задач',
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
  'inGroupAndOwnerUser' => 
  array (
    'type' => 1,
    'description' => 'Принадлежность группе',
    'bizRule' => 'return (in_array($params["group"],Yii::app()->user->groups) and $params["mod"]->isOwner());',
    'data' => NULL,
    'children' => 
    array (
      0 => 'inGroupAndOwner',
    ),
  ),
  'inGroupUser' => 
  array (
    'type' => 1,
    'description' => 'Принадлежность группе',
    'bizRule' => 'return array_intersect($params["group"],Yii::app()->user->groups);',
    'data' => NULL,
    'children' => 
    array (
      0 => 'inGroup',
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
  'taskReportUser' => 
  array (
    'type' => 1,
    'description' => 'Право на мониторинг операции в конкретной операционной',
    'bizRule' => 'return (in_array(1011,Yii::app()->user->id_departments));',
    'data' => NULL,
    'children' => 
    array (
      0 => 'taskReport',
    ),
  ),
  'otdReportUser' => 
  array (
    'type' => 1,
    'description' => 'Право на мониторинг операции в конкретной операционной',
    'bizRule' => 'return ((in_array(1011,Yii::app()->user->id_departments)) and Yii::app()->user->islead);',
    'data' => NULL,
    'children' => 
    array (
      0 => 'otdReport',
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
  'changeObjectsUser' => 
  array (
    'type' => 1,
    'description' => 'Управление операциями',
    'bizRule' => 'return in_array("changeobjects",Yii::app()->user->groups);',
    'data' => NULL,
    'children' => 
    array (
      0 => 'changeObjects',
    ),
  ),
  'ownMedicalEquipment' => 
  array (
    'type' => 1,
    'description' => 'Мониторинг мед. оборудования, свои записи',
    'bizRule' => 'return $params["mod"]->isOwner();',
    'data' => NULL,
    'children' => 
    array (
      0 => 'medicalEquipment',
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
      5 => 'inGroupUser',
      6 => 'inGroupAndOwnerUser',
      7 => 'taskReportUser',
      8 => 'otdReportUser',
      9 => 'monitoringOperUser',
      10 => 'changeObjectsUser',
      11 => 'OwnUpdateEv',
      12 => 'OwnUpdateTs',
      13 => 'ownMedicalEquipment',
    ),
  ),
  'observer' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'user',
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
      0 => 'observer',
      1 => 'medicalEquipment',
      2 => 'update',
      3 => 'delete',
      4 => 'save',
      5 => 'changeObjects',
      6 => 'ruleWorkplaces',
      7 => 'monitoringOper',
      8 => 'saveStatus',
      9 => 'saveStatusEv',
      10 => 'updateEv',
      11 => 'updateTs',
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
      1 => 'taskReport',
      2 => 'otdReport',
      3 => 'inGroup',
      4 => 'inGroupAndOwner',
      5 => 'admin',
    ),
  ),
);
