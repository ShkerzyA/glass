<?php
/* @var $this NewsController */
/* @var $data News */
?>

<div class="view">
	
	<?php echo '<h3>'.CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)).'</h3>'; ?>
	<div style="float: right;"><?php echo CHtml::encode($data->timestamp).'|'.CHtml::encode($data->creator0->fio_full()); ?></div><br>
	<?php echo $data->FileModel->attachInText($data->text); ?>



</div>