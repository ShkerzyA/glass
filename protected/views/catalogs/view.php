<?php
/* @var $this CatalogsController */
/* @var $model Catalogs */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('/myDocs'),
	$model->parentName()=>array('catalogs/'.$model->parentId()),
	$model->cat_name,
);

$this->menu=array(
	//array('label'=>'Список', 'url'=>array('index')),
	//array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	//array('label'=>'Управление', 'url'=>array('admin')),
);
?>
<h2 style="margin: 2px;"><?php echo $model->cat_name; ?></h2> 
<a href=/glass/docs/create?Docs[id_catalog]=<?php echo $model->id ?>><div class="add_unit">Добавить документ</div></a>
<a href=/glass/catalogs/create?Catalogs[id_parent]=<?php echo $model->id ?>><div class="add_unit">Добавить каталог</div></a>

<h6 style="text-align: right; margin: 2px"><span style='color: #D0D0D0'>владелец: </span> <?php 
//echo ($model->owner0->post);
$person=$model->owner0;

echo ('  <i>'.$person->surname.' '.mb_substr($person->name,0,1,'utf-8').'. '.mb_substr($person->patr,0,1,'utf-8').'.</i>');
?></h6> 
<hr>

<?php 
if (!empty($model->catalogs)){
	foreach ($model->catalogs as $v){
		echo '<div style="border-radius: 3px; min-height: 46px; margin: 3px; background: url(\'../images/folder_24.png\') no-repeat; padding-left: 40px;">
		<a href=/glass/catalogs/'.$v->id.'><h4 style="margin: 3px;">'.$v->cat_name.'</h4></a>
		</div><hr>';
	}
}

if (!empty($model->docs)){
	foreach ($model->docs as $doc) {
		$this->renderPartial('/docs/_item',array('doc'=>$doc),false,false);
	}
}else{
	echo '<h5 align=center>Нет документов</h5>';
}

?>
