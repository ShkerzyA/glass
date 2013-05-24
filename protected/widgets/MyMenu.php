<?php
Yii::import('zii.widgets.CMenu');
class MyMenu extends CMenu{
	public $itemTemplate='<div class="inset">{menu}</div>';
}
	?>