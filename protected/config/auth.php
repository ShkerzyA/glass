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
    'description' => 'Создать',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'admin' => 
  array (
    'type' => 0,
    'description' => 'Создать',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'delete' => 
  array (
    'type' => 0,
    'description' => 'Создать',
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
  'OwnUpdateEv' => 
  array (
    'type' => 1,
    'description' => 'Изменение своих событий',
    'bizRule' => 'return $params["mod"]->isOwner()',
    'data' => NULL,
    'children' => 
    array (
      0 => 'updateEv',
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
      5 => 'OwnUpdateEv',
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
      2 => 'save',
      3 => 'saveStatus',
      4 => 'saveStatusEv',
      5 => 'updateEv',
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
      2 => 'delete',
    ),
  ),
);
