<?php
if($model->checkAccessNow())
	echo'<div style="height: 30px; width: 96%; margin-left: 1%; background: green"><h1 style="color: white; text-align: center">Разрешено</h1></div>';
else
	echo'<div style="height: 30px; width: 96%; margin-left: 1%; background: red"><h1 style="color: white; text-align: center">Запрещено</h1></div>';

?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'itemCssClass'=>array('shortview'),
	'data'=>$model,
	'attributes'=>array(
		array(
            'name'=>'owner',
            'value'=>$model->ownerName(),
        ),
        'notes',
		array('name'=>'mark',
            'value'=>$model->markName()),
		'number',
		//array('name'=>'deactive','value'=>$model->isDeactive()),
		array('name'=>'status',
			'value'=>$model->getStatus()),

	),
)); ?>

