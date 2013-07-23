<?php
/* @var $this PersonnelController */
/* @var $data Personnel */
?>


<div class="view2">
	<a href="<?php echo $this->createUrl('/personnel/'.$data->id) ?>">
		<div class=avatar> <img src="<?php 
		if (!empty($data->photo)){
			echo (Yii::app()->request->baseUrl.'/media'.DIRECTORY_SEPARATOR.CHtml::encode($data->photo)); 
		}else{
			echo (Yii::app()->request->baseUrl.'/images/no_avatar.jpg');
		}

		?>"> </div>
		<p class=fio><?php echo CHtml::encode($data->surname); ?> <?php echo CHtml::encode($data->name); ?> <?php echo CHtml::encode($data->patr); ?></p>
	</a>
</div>

