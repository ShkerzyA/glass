<?php
/* @var $this DocsController */
/* @var $model Docs */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Отобразить <?php  echo $model::$modelLabelS; ?>  "<?php echo $model->doc_name; ?>"</h1> 

<?php
echo '<div style="border-radius: 3px; min-height: 46px; border-bottom: 2px solid #444; margin: 3px; background: url(\'../images/doc.png\') no-repeat; padding-left: 40px;">

		('.$model->date_begin.')
		'.$model->creator0->personnelPostsHistories[0]->idPersonnel->surname.' '.$model->creator0->personnelPostsHistories[0]->idPersonnel->name.' '.$model->creator0->personnelPostsHistories[0]->idPersonnel->patr.
		'<br>'.($link=(!empty($model->link))?'<a target="_blank" href=/glass/media/docs/'.$model->link.'>Вложение</a>':'').
		'<br>'.$model->text_docs.
		'</div>';

		?>