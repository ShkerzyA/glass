<?php Yii::app()->clientScript->registerPackage('userjs'); ?>
<?php $this->controller->renderPartial('/actions/awesome_window_wrap',array('view'=>'/tasks/deadline','model'=>$deadline)); ?>
