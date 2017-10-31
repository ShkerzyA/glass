<?php
Yii::import('zii.widgets.CListView');
class MyListView extends CListView{
	public $template="{summary}\n{pager}\n{sorter}\n{items}\n{pager}";
	}
	?>