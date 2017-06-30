<?php
/* @var $this CallLogController */

$this->breadcrumbs=array(
	'Лог звонков. Импорт',
);

$this->menu=array(
	array('label'=>'Лог Звонков Автоматика', 'url'=>array('/callLog')), 
	array('label'=>'Лог Звонков АПУС', 'url'=>array('/callLog/indexApus')), 
	array('label'=>'Лог Звонков/импорт', 'url'=>array('/callLog/import')), 
);

?>
<h1>Лог звонков. Импорт</h1>

<form enctype="multipart/form-data" method="post">
   <p><input type="file" name="f">
   <input type="submit" value="Обработать"></p>
</form> 

<?php 
	echo $result;
?>
