<h1>Отделы</h1>
<?php

$this->menu=array(
	array('label'=>'Главная', 'url'=>array('tree')),
	array('label'=>'Отделы из MU.dbf', 'url'=>array('mudbf')),
);
//Yii::app()->getClientScript()->registerScriptFile( '/glass/js/jtree.async.custom.js' );
$this->widget(
    'CTreeView',
    array('url' => array('ajaxFillTree'),'control'=>'subdiv_rn','htmlOptions'=>array('class'=>'customtree'))
); 

?>