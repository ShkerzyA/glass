<?php

$projects=Projects::myProjects();
$projectsArr=array();
$projectsArr[]=array('label'=>'Привязать к существующей','url'=>'#','linkOptions'=>array('class'=>'bind_task bindExistingTasks','id'=>$this->id));
foreach ($projects as $pr) {
	$projectsArr[]=array('label'=>'<nobr>'.$pr->ico(True).' '.$pr->name.'</nobr>','url'=>array('tasks/create?Tasks[type]='.$pr->getType().'&&Tasks[project]='.$pr->id.'&&Tasks[bindTasks][]='.$model->id.''));
}




$this->beginWidget('zii.widgets.CPortlet', array(
					'title'=>'<img src="'.Yii::app()->request->baseUrl.'/images/chain24.png">Связанная задача',
          'contentCssClass'=>'portlet-content hide',
				));

$this->widget('zii.widgets.CMenu', array(
        'items'=>$projectsArr,
        'encodeLabel'=>false,
        'htmlOptions'=>array('class'=>'operations'),
      ));

$this->endWidget();






?>
