<h1>КККОД</h1>
<?php
$this->widget(
    'MyTreeView',
    array('url' => array('/Building/ajaxFillTree'),'control'=>'id','htmlOptions'=>array('class'=>'customtree'))
); ?>