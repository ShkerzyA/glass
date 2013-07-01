<?php
/* @var $this PersonnelController */
/* @var $model Personnel */

$this->breadcrumbs=array(
	'Кадры'=>array('index'),
	'Импорт',
);

$this->menu=array(
	array('label'=>'List Personnel', 'url'=>array('index')),
	array('label'=>'Create Personnel', 'url'=>array('create')),
	array('label'=>'Manage Personnel', 'url'=>array('admin')),
);
?>

<h1>Импорт кадров из .xls</h1>


<div class="form">

<?php 
	echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); 
	$model=new Xls();
	?>
	<p>excel файл должен быть подготовлен перед импортом.<br>
		1. ФИО в первом столбце. Через пробел. Тип ячеек - текст<br>
		2. Дата рождения во втором столбце	Тип ячеек - дата<br>
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