<h1>Географическое местоположение</h1>
<?php
$this->widget(
    'CTreeView',
    array('url' => array('/Building/rootFillTree'),'control'=>'id','htmlOptions'=>array('class'=>'customtree'))
); ?>