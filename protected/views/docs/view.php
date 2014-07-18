<?php
/* @var $this DocsController */
/* @var $model Docs */

$this->breadcrumbs=array(
	$model->idCatalog->cat_name=>array('/Catalogs/'.$model->id_catalog),
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

<h1 style="margin: 3px"><?php  echo $model::$modelLabelS; ?>  "<?php echo $model->doc_name; ?>"</h1> 

<?php

		if(!empty($model->link)){
			$fl=explode('.', $model->link);
			$file='<a target="_blank" href='.Yii::app()->request->baseUrl.'/media/docs/'.$model->link.'><img class=s16 src="'.Yii::app()->request->baseUrl.'/images/ico/'.mb_strtolower($fl[1]).'.png"></a>';
		}else{
			$file='нет вложений';
		}

echo '<div style="border-radius: 3px; min-height: 46px; background: padding-left: 40px;">
		<div style="position: relative; float: right; text-align: right"><i>'.$model->date_begin.'<br>
		'.$model->creator0->surname.' '.$model->creator0->name.' '.$model->creator0->patr.'</i></div> '.
		'<br><span style="margin: 10px; color: #D0D0D0">вложения: </span>'.$file.'<hr>'.
		'<br><pre style="overflov: none;">'.$model->text_docs.'</pre></div>';

		?>