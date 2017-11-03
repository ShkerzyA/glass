
<?php 
	$programs=Programs3p::model()->findall(); 
?>
	<table style="display: none" id=emptyPersProgram>
	<tr >
		<td><?php echo CHtml::dropDownList("PersProgram[__prefix__][id_program]",'',CHtml::listData($programs,"id",function($programs) {return CHtml::encode($programs->name);}),array('empty' => '')); ?></td>
		<td><?php echo CHtml::textField("PersProgram[__prefix__][login]"); ?></td>
		<td><?php echo CHtml::checkBox("PersProgram[__prefix__][delme]"); ?></td>
	</tr>
	</table>
