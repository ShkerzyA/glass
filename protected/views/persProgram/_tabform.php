
<?php 
	$programs=Programs3p::model()->findall(); 
?>
<table class=phonetable id=tablePersProg>
	<tr>
		<th>Программа</th>
		<th>Логин</th>
		<th>Удалить</th>
	</tr>
	<?php foreach($items as $i=>$item): ?>
	<tr>
		<td><?php echo CHtml::activedropDownList($item,"[$i]id_program",CHtml::listData($programs,"id",function($programs) {return CHtml::encode($programs->name);}),array('empty' => '')); ?></td>
		<td><?php echo CHtml::activeTextField($item,"[$i]login"); ?><?php echo CHtml::activeHiddenField($item,"[$i]id"); ?></td>
		<td><?php echo CHtml::activeCheckBox($item,"[$i]delme"); ?></td>
	</tr>
	<?php endforeach; ?>
</table>
	<input type=button name='add' value='Добавить программу' class=addPersProgram id=<?php echo count($items)?>>
