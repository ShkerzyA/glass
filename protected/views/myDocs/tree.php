<h1>Знания</h1>
<?php
$this->widget(
    'CTreeView',
    array('url' => array('/Catalogs/rootFillTree'),'control'=>'id','htmlOptions'=>array('class'=>'customtree catalogs'))
); ?>