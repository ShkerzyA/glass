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

Yii::app()->clientScript->registerPackage('customfields');

?>

<script>

	function init(){
		var i=0;
		while($("#Equipment_"+i+"_type").length) {
	
		//for (i=0; i<8; i++) {
			$('#Equipment_'+i+'_type').live('change',function(){ 
				var id=$(this).attr('id');
				var val=$(this).val();
				id=id.split('_');
				filter(id[1],val);
			
			});
			i++;
		}
	}

	function filter(i,val){
		$('#Equipment_'+i+'_producer option:first').attr('selected', 'selected');
		$('#Equipment_'+i+'_producer .c0, #Equipment_'+i+'_producer .c1,#Equipment_'+i+'_producer .c2,#Equipment_'+i+'_producer .c3,#Equipment_'+i+'_producer .c4,#Equipment_'+i+'_producer .c5').hide();
		$('#Equipment_'+i+'_producer .c'+val).show();
	}
	$(document).ready(init);
</script>

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

<td><?php echo CHtml::activeTextField($item,"[$i]mark",array('maxlength'=>200,'class'=>'marksearch')); ?></td>
<td><?php echo CHtml::activeTextField($item,"[$i]inv"); ?></td>

<td><?php echo CHtml::activedropDownList($item,"[$i]status", $item->getStatus()); ?></td>
<td><?php echo CHtml::activeTextField($item,"[$i]notes"); ?></td>
</tr>

<?php endforeach; ?>
</table>
 
<?php echo CHtml::submitButton('Сохранить'); ?>
<?php echo CHtml::endForm(); ?>
</div><!-- form --></div>