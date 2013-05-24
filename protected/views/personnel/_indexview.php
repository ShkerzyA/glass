<?php
/* @var $this PersonnelController */
/* @var $data Personnel */
?>


<div class="view2">
	<a href="<?php echo $this->createUrl('/personnel/'.$data->id) ?>">
		<div class=avatar> <img src="<?php echo (Yii::app()->request->baseUrl.'/media'.DIRECTORY_SEPARATOR.CHtml::encode($data->photo)); ?>"> </div>
		<p class=fio><?php echo CHtml::encode($data->surname); ?> <?php echo CHtml::encode($data->name); ?> <?php echo CHtml::encode($data->patr); ?></p>
	</a>
</div>

