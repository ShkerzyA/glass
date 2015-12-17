<div class="rw">
<style>
.rightTable{
	border-collapse: collapse;
	margin: 3px;
}
.rw tr td{
	border-left,border-right: 1px solid grey;
	border-top,border-bottom: 1px solid black;
}
</style>
<table class="rightTable">
<tr><th>Время</th><th>Событие</th><th>Детали</th><th>Авто</th></tr>
<?php 
foreach ($model as $v) {
  echo '<tr><td>'.$v->timestamp.'</td><td><nobr>'.$v->getType()["name"].'</nobr></td><td>'.$v->details().'</td><td>'.$x=(!empty($v->object))?$v->object->nameL():"-//-".'</td></tr>';  
}
?>
</table>
</div>
