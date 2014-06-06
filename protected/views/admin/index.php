<?php
/* @var $this PostsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Администратор',
);

$this->menu=array(
			array('label'=>'GII', 'url'=>array('/gii')),
			array('label'=>'КККОД дерево', 'url'=>array('/myAdmin')),
			);

$this->menu['all_menu']=array(



	array('title'=>'Персонал','items'=>array(
		array('label'=>'Пользователи', 'url'=>array('/users/admin'),'items'=>array(
		/*array('label'=>'Роли', 'url'=>array('/usersPosts/admin')),
		array('label'=>'Права', 'url'=>array('/usersRules/admin')) */
		)),
		array('label'=>'Кадры', 'url'=>array('/personnel/admin'),'items'=>array(
			array('label'=>'Должности кадров', 'url'=>array('/personnelPostsHistory/admin')),
		)),
	)),
	array('title'=>'Структура','items'=>array(
		array('label'=>'Отделы', 'url'=>array('/department/admin'),'items'=>array(
			array('label'=>'Должности', 'url'=>array('/departmentPosts/admin')),
			array('label'=>'Группы должностей', 'url'=>array('/PostsGroups/admin')),
		)),
		
	)),
	array('title'=>'Здания','items'=>array(
		array('label'=>'Здания', 'url'=>array('/building/admin'),'items'=>array(
			array('label'=>'Этажи', 'url'=>array('/floor/admin')), 
			array('label'=>'Кабинеты', 'url'=>array('/cabinet/admin')), 
			array('label'=>'Рабочие места', 'url'=>array('/workplace/admin')),
		)),
	)),

	array('title'=>'Мероприятия','items'=>array(
		array('label'=>'Местоположение', 'url'=>array('/rooms/admin'),'items'=>array(
			array('label'=>'События', 'url'=>array('/events/admin')), 
		)),
	)),

	array('title'=>'Оборудование','items'=>array(
		array('label'=>'Оборудование', 'url'=>array('/equipment/admin')), 

	)),

	array('title'=>'Знания','items'=>array(
		array('label'=>'Каталоги', 'url'=>array('/catalogs/admin')), 
		array('label'=>'Документы', 'url'=>array('/docs/admin')), 
		array('label'=>'Задачи', 'url'=>array('/tasks/admin')), 
	)),

		array('title'=>'MyDbase (нажимать нежно, сразу импорт)','items'=>array(
		array('label'=>'Список кадров', 'url'=>array('/MyDbase/ReadPerson')),
		array('label'=>'Импорт Отделов', 'url'=>array('/MyDbase/importOtdel')),
		array('label'=>'Импорт Кадров', 'url'=>array('/MyDbase/importPersonnel')),
		array('label'=>'Импорт Штатных должностей', 'url'=>array('/MyDbase/importOtdelPosts')),
		array('label'=>'Импорт Истории должностей', 'url'=>array('/MyDbase/ImportPersonnelPostsHistory')),
	)),

	array('title'=>'Тупиковая ветвь, импорт из excel','items'=>array(
			array('label'=>'Импорт кадров', 'url'=>array('/personnel/import')),
			array('label'=>'Импорт Отделов', 'url'=>array('/department/import')),
			array('label'=>'Импорт Штатной структуры', 'url'=>array('/departmentPosts/import')),
			array('label'=>'Импорт Истории должностей', 'url'=>array('/personnelPostsHistory/import')),
	)),

	
	);

//$this->menu=;

?>
