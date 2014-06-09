<?php
/* @var $this EquipmentController */
/* @var $model Equipment */

$this->breadcrumbs=array(
	'Рабочее место'=>array('/Workplace/view/'.$items[0]->id_workplace),
	'Создать',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index'),'visible'=>(Yii::app()->user->role=='administrator')),
	array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
);
?>
<div class=leaf>
<h1>Добавить оборудование</h1>

<div class="form">
<?php echo CHtml::beginForm(); ?>
<table>

<tr>
	<th><?php echo $items[0]->getAttributeLabel('serial'); ?></th>
	<th><?php echo $items[0]->getAttributeLabel('type'); ?></th>
	<th><?php echo $items[0]->getAttributeLabel('producer'); ?></th>
	<th><?php echo $items[0]->getAttributeLabel('mark'); ?></th>
	<th><?php echo $items[0]->getAttributeLabel('inv'); ?></th>
	<th><?php echo $items[0]->getAttributeLabel('status'); ?></th>
	<th><?php echo $items[0]->getAttributeLabel('notes'); ?></th>
</tr>
<?php foreach($items as $i=>$item): ?>
<tr>
<td><?php echo CHtml::activeHiddenField($item,"[$i]id_workplace",array(),$item->id_workplace); ?>
<?php echo CHtml::activeTextField($item,"[$i]serial"); ?></td>
<td><?php echo CHtml::activedropDownList($item,"[$i]type", $item->getType()); ?></td>
<?php $prod=$item->getProducer();?>
<td><?php echo CHtml::activedropDownList($item,"[$i]producer", $prod['values'],array('empty' => '','options'=>$prod['css_class'])); ?></td>

<td><?php echo CHtml::activeTextField($item,"[$i]mark"); ?></td>
<td><?php echo CHtml::activeTextField($item,"[$i]inv"); ?></td>

<td><?php echo CHtml::activedropDownList($item,"[$i]status", $item->getStatus()); ?></td>
<td><?php echo CHtml::activeTextField($item,"[$i]notes"); ?></td>
</tr>

<?php endforeach; ?>
</table>
 
<?php echo CHtml::submitButton('Сохранить'); ?>
<?php echo CHtml::endForm(); ?>
</div><!-- form --></div>