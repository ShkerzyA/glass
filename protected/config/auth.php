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
  'inGroupUser' => 
  array (
    'type' => 1,
    'description' => 'Изменение статуса задач своего отдела',
    'bizRule' => 'return in_array($params["group"],Yii::app()->user->groups);',
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
  'userOperationSV' => 
  array (
    'type' => 1,
    'description' => 'Управление операциями',
    'bizRule' => 'return in_array("operationsv",Yii::app()->user->groups);',
    'data' => NULL,
    'children' => 
    array (
      0 => 'operationSV',
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
      6 => 'taskReportUser',
      7 => 'otdReportUser',
      8 => 'userOperationSV',
      9 => 'monitoringOperUser',
      10 => 'changeObjectsUser',
      11 => 'OwnUpdateEv',
      12 => 'OwnUpdateTs',
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
      9 => 'otdReport',
      10 => 'updateEv',
      11 => 'updateTs',
      12 => 'operationSV',
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
      4 => 'admin',
    ),
  ),
);
