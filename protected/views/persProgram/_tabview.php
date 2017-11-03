<table class=phonetable id=tablePersProg>
	<tr>
		<th>Программа</th>
		<th>Логин</th>
	</tr>
	<?php foreach($model->persPrograms as $v): ?>
	<tr>
		<td><?php echo CHtml::encode($v->idProgram->name)?></td>
		<td><?php echo CHtml::encode($v->login); ?></td>
	</tr>
	<?php endforeach; ?>
</table>