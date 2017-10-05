<table class="phonetable">
	<tr>
		<th>Дата/Время</th>
		<th>Статус</th>
		<th>Передал</th>
		<th>Принял</th>
		<th>Создал акт</th>
	</tr>
<?php 
foreach ($models as $data) {
	$this->renderPartial('_viewtable',array('data'=>$data),false,false);
}
?>
</table>