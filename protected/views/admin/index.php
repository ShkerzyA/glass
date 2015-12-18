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
	array('title'=>'Инструменты самодиагностики','items'=>array(
		array('label'=>'Уволенные пользователи на рабочиж местах', 'url'=>array('/personnel/firedButInWp')),
		array('label'=>'Рабочие места без людей', 'url'=>array('/workplace/wpWithoutPers'))
	)),

	array('title'=>'Транспорт','items'=>array(
		array('label'=>'Транспорт', 'url'=>array('/vehicles/admin')),
		array('label'=>'Расписание вьезда', 'url'=>array('/VehicleShedule/admin')),
	)),


	array('title'=>'Персонал','items'=>array(
		array('label'=>'Пользователи', 'url'=>array('/users/admin'),'items'=>array(
		/*array('label'=>'Роли', 'url'=>array('/usersPosts/admin')),
		array('label'=>'Права', 'url'=>array('/usersRules/admin')) */
		)),
		array('label'=>'Кадры', 'url'=>array('/personnel/admin'),'items'=>array(
			array('label'=>'Должности кадров', 'url'=>array('/personnelPostsHistory/admin')),
			array('label'=>'Всех в открытый огонь', 'url'=>array('/personnel/allInOpenFire')),
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
			array('label'=>'Рабочие места/автоотдел', 'url'=>array('/workplace/AutoSetDepartment')),
		)),
	)),

	array('title'=>'Мероприятия','items'=>array(
		array('label'=>'Местоположение', 'url'=>array('/rooms/admin'),'items'=>array(
			array('label'=>'События', 'url'=>array('/events/admin')), 
			array('label'=>'Операции', 'url'=>array('/eventsoper/admin')), 
		)),
	)),

	array('title'=>'Оборудование','items'=>array(
		array('label'=>'Оборудование', 'url'=>array('/equipment/admin')), 
		array('label'=>'Об./Тип', 'url'=>array('/equipmentType/admin')), 
		array('label'=>'Об./Производитель', 'url'=>array('/equipmentProducer/admin')), 
		array('label'=>'Об./ Лог', 'url'=>array('/equipmentLog/admin')),
		array('label'=>'Мед. Оборудование', 'url'=>array('/medicalEquipment/admin')),

	)),

	array('title'=>'Знания','items'=>array(
		array('label'=>'Лог', 'url'=>array('/log/admin')), 
		array('label'=>'Каталоги', 'url'=>array('/catalogs/admin')), 
		array('label'=>'Документы', 'url'=>array('/docs/admin')), 
		array('label'=>'Проекты', 'url'=>array('/projects/admin')), 
		array('label'=>'Задачи', 'url'=>array('/tasks/admin')),
		array('label'=>'Статусы Задач', 'url'=>array('/tasksStatus/admin')),
		array('label'=>'Телефоны/Экспорт', 'url'=>array('/Cabinet/exportPhones')), 
		array('label'=>'Лог Звонков Автоматика', 'url'=>array('/callLog')), 
		array('label'=>'Лог Звонков АПУС', 'url'=>array('/callLog/indexApus')), 
		array('label'=>'Лог Звонков/импорт', 'url'=>array('/callLog/import')), 
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
