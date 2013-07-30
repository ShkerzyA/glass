<h1>Здания</h1>
<?php
$this->widget(
    'CTreeView',
    array('url' => array('AjaxFillBuilding'),'control'=>'id','htmlOptions'=>array('class'=>'customtree'))
); ?>