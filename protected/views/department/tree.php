<h1>Отделы</h1>
<?php
$this->widget(
    'CTreeView',
    array('url' => array('ajaxFillTree'),'control'=>'subdiv_rn','htmlOptions'=>array('class'=>'customtree'))
); ?>