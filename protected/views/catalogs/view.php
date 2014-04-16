<?php
/* @var $this CatalogsController */
/* @var $model Catalogs */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
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

<h6 style="text-align: right; margin: 2px"><span style='color: #D0D0D0'>владелец: </span> <?php 
//echo ($model->owner0->post);
$person=$model->owner0;

echo ('  <i>'.$person->surname.' '.mb_substr($person->name,0,1,'utf-8').'. '.mb_substr($person->patr,0,1,'utf-8').'.</i>');
?></h6> 
<hr>

<?php 
if (!empty($docs)){
	foreach ($docs as $v){

		
		if(!empty($v->link)){
			$fl=explode('.', $v->link);
			$file='<a target="_blank" href='.Yii::app()->request->baseUrl.'/media/docs/'.$v->link.'><img class=s16 src="'.Yii::app()->request->baseUrl.'/images/ico/'.mb_strtolower($fl[1]).'.png"></a>';
		}else{
			$file='нет вложений';
		}


		echo '<div style="border-radius: 3px; min-height: 46px; margin: 3px; background: url(\'../images/doc.png\') no-repeat; padding-left: 40px;">
		<a href=/glass/docs/'.$v->id.'><h4 style="margin: 3px;">'.$v->doc_name.'</h4></a>
		<div style="position: relative; float: right; text-align: right"><i>'.$v->date_begin.'<br>'.$v->creator0->personnelPostsHistories[0]->idPersonnel->surname.' '.mb_substr($v->creator0->personnelPostsHistories[0]->idPersonnel->name,0,1,'utf-8').'. '.mb_substr($v->creator0->personnelPostsHistories[0]->idPersonnel->patr,0,1,'utf-8').'.</i></div>'.
		$file.
		'<br>'.substr($v->text_docs,0,300).'...'.
		'</div><hr>';
	}
}else{
	echo '<h5 align=center>Нет документов</h5>';
}

?>
