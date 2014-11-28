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
		if(!empty($result))
			return '<div class="MyMenuSubmenu">'.implode('<div class="limiter"></div>',$result).'</div>';
		
	}
	protected function renderMenuItem($item)
	{
		if(isset($item['submenu'])){
			$submenu=$this->renderSubmenu($item['submenu']);
		}else{
			$submenu='';
		}
		if(isset($item['url']))
		{
			$label=$this->linkLabelWrapper===null ? $item['label'] : CHtml::tag($this->linkLabelWrapper, $this->linkLabelWrapperHtmlOptions, $item['label']);
			return array(CHtml::link($label,$item['url'],isset($item['linkOptions']) ? $item['linkOptions'] : array()),$submenu);
		}
		else
			return array(CHtml::tag('span',isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label']),$submenu);
	}


	protected function renderMenuRecursive($items)
	{
		$count=0;
		$n=count($items);
		foreach($items as $item)
		{
			$count++;
			$options=isset($item['itemOptions']) ? $item['itemOptions'] : array();
			$class=array();
			if($item['active'] && $this->activeCssClass!='')
				$class[]=$this->activeCssClass;
			if($count===1 && $this->firstItemCssClass!==null)
				$class[]=$this->firstItemCssClass;
			if($count===$n && $this->lastItemCssClass!==null)
				$class[]=$this->lastItemCssClass;
			if($this->itemCssClass!==null)
				$class[]=$this->itemCssClass;
			if($class!==array())
			{
				if(empty($options['class']))
					$options['class']=implode(' ',$class);
				else
					$options['class'].=' '.implode(' ',$class);
			}

			echo CHtml::openTag('li', $options);

			$res=$this->renderMenuItem($item);
			$menu=$res[0];
			$subm=$res[1];
			if(isset($this->itemTemplate) || isset($item['template']))
			{
				$template=isset($item['template']) ? $item['template'] : $this->itemTemplate;
				echo strtr($template,array('{menu}'=>$menu));
			}
			else
				echo $menu;

			if(isset($item['items']) && count($item['items']))
			{
				echo "\n".CHtml::openTag('ul',isset($item['submenuOptions']) ? $item['submenuOptions'] : $this->submenuHtmlOptions)."\n";
				$this->renderMenuRecursive($item['items']);
				echo CHtml::closeTag('ul')."\n";
			}

			echo CHtml::closeTag('li')."\n";
			echo $subm;
		}
	}
}
	?>