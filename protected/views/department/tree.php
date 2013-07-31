<h1>Отделы</h1>
<?php
//Yii::app()->getClientScript()->registerScriptFile( '/glass/js/jtree.async.custom.js' );
$this->widget(
    'CTreeView',
    array('url' => array('ajaxFillTree'),'control'=>'subdiv_rn','htmlOptions'=>array('class'=>'customtree'))
); 

?>