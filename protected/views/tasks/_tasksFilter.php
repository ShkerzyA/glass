<?php

$this->beginWidget('zii.widgets.CPortlet', array(
					'title'=>'<img src="'.Yii::app()->request->baseUrl.'/images/funnel.png">Фильтры задач',
          'contentCssClass'=>'portlet-content',
				));

$this->widget('zii.widgets.CMenu', array(
        'items'=>array(
			array('label'=>'Актуальные', 'url'=>array('HelpDesk?group='.$this->group.'&&type=1')),
			array('label'=>'За сегодня', 'url'=>array('HelpDesk?group='.$this->group.'&&type=3')),
			array('label'=>'[Мои проекты]', 'url'=>array('HelpDesk?group='.$this->group.'&&type=6')),
			array('label'=>'[Мое]', 'url'=>array('HelpDesk?group='.$this->group.'&&type=2')),
		),
        'encodeLabel'=>false,
        'htmlOptions'=>array('class'=>'operations'),
      ));

$this->endWidget();






?>
