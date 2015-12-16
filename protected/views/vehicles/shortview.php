
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
            'name'=>'owner',
            'value'=>$model->owner0->fio_full(),
        ),
		'mark',
		'number',
		array('name'=>'deactive',
			'value'=>$model->isDeactive()),
		array('name'=>'status',
			'value'=>$model->getStatus()),

	),
)); ?>
