<?php
Yii::import('zii.widgets.CMenu');
class MyMenu extends CMenu{
	public $itemTemplate='<div class="inset">{menu}</div>';


	protected function renderSubmenu($submenu){
		$result=array();
		foreach ($submenu as $v) {
			if(!isset($v[2]) or $v[2]==true)
				$result[]='<div class="item">'.CHtml::link($v[0],array($v[1])).'</div>';
		}
		return '<div class="MyMenuSubmenu">'.implode('<div class="limiter"></div>',$result).'</div>';
		
	}
	protected function renderMenuItem($item)
	{
		if(isset($item['submenu'])){
			$submenu=$this->renderSubmenu($item['submenu']);
		}
		if(isset($item['url']))
		{
			$label=$this->linkLabelWrapper===null ? $item['label'] : CHtml::tag($this->linkLabelWrapper, $this->linkLabelWrapperHtmlOptions, $item['label']);
			return CHtml::link($label,$item['url'],isset($item['linkOptions']) ? $item['linkOptions'] : array()).$submenu;
		}
		else
			return CHtml::tag('span',isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label']);
	}
}
	?>