<div class="rw">
<style>
.rightTable{
	border-collapse: collapse;
	margin: 3px;
}

.rightTable th{
	text-align: center;
}
.rw tr td{
	padding: 2px;
	border-left: 1px solid #eaeaea;
	border-right: 1px solid #eaeaea;
	border-top: 1px solid grey;
	border-bottom: 1px solid grey;
}
</style>
<table class="rightTable">
<tr><th>Время</th><th>Событие</th><th>Детали</th><th>Объект</th></tr>
<?php 
foreach ($model as $v) {
  echo '<tr><td>'.$v->timestamp.'</td><td><nobr>'.$v->getType()["name"].'</nobr></td><td>'.$v->details().'</td><td>'.$x=(!empty($v->object))?$v->object->nameL():$v->altName().'</td></tr>';  
}
?>
</table>
</div>
