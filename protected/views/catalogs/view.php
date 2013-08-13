<?php
/* @var $this CatalogsController */
/* @var $model Catalogs */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	$model->cat_name,
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1><?php  echo $model::$modelLabelS; ?>: <?php echo $model->cat_name; ?></h1> 

<h3>Владелец: <?php 
echo ($model->owner0->post);
$person=$model->owner0->personnelPostsHistories[0]->idPersonnel;

echo ('  <i>'.$person->surname.' '.$person->name.' '.$person->patr.'</i>');
?></h3> 

<?php 
if (!empty($docs)){
	foreach ($docs as $v){
		echo '<div style="border-radius: 3px; min-height: 46px; border-bottom: 2px solid #444; margin: 3px; background: url(\'../images/doc.png\') no-repeat; padding-left: 40px;">
		'.$v->doc_name.'
		('.$v->date_begin.')
		'.$v->creator0->personnelPostsHistories[0]->idPersonnel->surname.' '.$v->creator0->personnelPostsHistories[0]->idPersonnel->name.' '.$v->creator0->personnelPostsHistories[0]->idPersonnel->patr.
		'<br>'.($link=(!empty($v->link))?'<a target="_blank" href=/glass/media/docs/'.$v->link.'>Вложение</a>':'').
		'<br>'.substr($v->text_docs,0,300).'...'.
		'</div>';
	}
}else{
	echo '<h3>Нет документов</h3>';
}

?>
