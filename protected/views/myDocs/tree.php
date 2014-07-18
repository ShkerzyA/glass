<h1>Документы</h1>
<?php

$this->widget(
    'CTreeView',
    array('url' => array('/Catalogs/ajaxFillTree/'),'control'=>'id','htmlOptions'=>array('class'=>'customtree catalogs'))
); ?>