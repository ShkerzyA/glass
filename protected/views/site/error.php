<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Ошибка',
);
?>

<h2>Ошибка: <?php if(!empty($code)) echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>