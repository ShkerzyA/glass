<?php
/* @var $this PersonnelController */
/* @var $model Personnel */

$this->breadcrumbs=array(
	'Отделы'=>array('index'),
	'Импорт',
);

?>

<h1>Импорт Истории должностей из .xls</h1>


<div class="form">

<?php 
	echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); 
	$model=new Xls();
	?>
	
	<div class="row">
		<?php echo CHtml::activefileField($model,'xls'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Импорт'); ?>
	</div>

	<?php if (!empty($result)) echo $result;?>

<?php CHtml::endForm(); ?>
</div>