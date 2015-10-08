<?php
/* @var $this DocsController */
/* @var $model Docs */

$this->breadcrumbs=array(
	$model->idCatalog->cat_name=>array('/Catalogs/'.$model->id_catalog),
	$model->id,
);

$this->menu=array(
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id),'visible'=>Yii::app()->user->checkAccess('isOwner',array('mod'=>$model))),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'params'=>array('returnUrl'=>Yii::app()->request->baseUrl.'/catalogs/'.$model->id_catalog),'confirm'=>'Уверены?'),'visible'=>Yii::app()->user->checkAccess('isOwner',array('mod'=>$model))),
);
?>

<h1 style="margin: 3px"><?php  echo $model::$modelLabelS; ?>  "<?php echo $model->doc_name; ?>"</h1> 

<?php

		if(!empty($model->link)){
			$file='<a target="_blank" href='.Yii::app()->request->baseUrl.'/media/docs/'.$model->link.'><img class=s16 src="'.$model->getIco().'"></a>';
		}else{
			$file='нет вложений';
		}

echo '<div style="border-radius: 3px; min-height: 46px; background: padding-left: 40px;">
		<div style="position: relative; float: right; text-align: right"><i>'.$model->date_begin.'<br>
		'.$model->creator0->fio_full().'</i></div> '.
		'<br><span style="margin: 10px; color: #D0D0D0">вложения: </span>'.$file.'<hr>'.
		'<br><pre style="overflov: none;">'.$model->text_docs.'</pre></div>';

		?>