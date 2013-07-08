<?php
/* @var $this PostsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Администратор',
);



$this->menu=array(
      array('label'=>'GII', 'url'=>array('/gii')),
	array('label'=>'Пользователи', 'url'=>array('/users/admin'),'items'=>array(
		/*array('label'=>'Роли', 'url'=>array('/usersPosts/admin')),
		array('label'=>'Права', 'url'=>array('/usersRules/admin')) */
		)),
	array('label'=>'Кадры', 'url'=>array('/personnel/admin'),'items'=>array(
		array('label'=>'Импорт кадров', 'url'=>array('/personnel/import')),
		array('label'=>'Должности кадров', 'url'=>array('/personnelPostsHistory/admin')),
		)),
	array('label'=>'Отделы', 'url'=>array('/department/admin'),'items'=>array(
		array('label'=>'Должности', 'url'=>array('/departmentPosts/admin')),
		)),
	array('label'=>'Здания', 'url'=>array('/building/admin'),'items'=>array(
		array('label'=>'Этажи', 'url'=>array('/floor/admin')), 
		array('label'=>'Кабинеты', 'url'=>array('/cabinet/admin')), 
		)),
);

?>
