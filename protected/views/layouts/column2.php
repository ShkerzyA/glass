<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span-19">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="span-5 last">
	<div id="sidebar">
	<?php
		if (!empty($this->menu)){
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Действия',
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'operations'),
			));
			$this->endWidget();

		}



		if (!empty($this->menu['details'])){
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Детали',
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu['details'],
				'htmlOptions'=>array('class'=>'operations'),
			));
			$this->endWidget();
		}

		if(!empty($this->menu['all_menu'])){
			foreach ($this->menu['all_menu'] as $menu){
				$this->beginWidget('zii.widgets.CPortlet', array(
					'title'=>$menu['title'],
				));
				$this->widget('zii.widgets.CMenu', array(
					'items'=>$menu['items'],
					'htmlOptions'=>array('class'=>'operations'),
				));
				$this->endWidget();
			}
		}

		if(!empty($this->rightWidget)){
			foreach ($this->rightWidget as $r) {
				echo $r;
			}
		}

	?>
	</div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>