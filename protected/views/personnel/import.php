<?php
/* @var $this PersonnelController */
/* @var $model Personnel */

$this->breadcrumbs=array(
	'Кадры'=>array('index'),
	'Импорт',
);

?>

<h1>Импорт кадров из .xls</h1>


<div class="form">

<?php 
	echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); 
	$model=new Xls();
	?>
	<p>excel файл должен быть подготовлен перед импортом по порядку Ф,И,О, дата рождения, дата приема, дата увольнения
	</p>
	<div class="row">
		<?php echo CHtml::activefileField($model,'xls'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Импорт'); ?>
	</div>

	<?php if (!empty($bfg)) echo $bfg;?>

<?php CHtml::endForm(); ?>
</div>