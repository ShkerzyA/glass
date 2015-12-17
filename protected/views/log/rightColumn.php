<div class="rw">
<style>
.rw tr td{
	border-bottom: 1px solid black;
}
</style>
<table class="rightTable">
<tr><th>Время</th><th>Действие</th><th>Детали</th><th>Авто</th></tr>
<?php 
foreach ($model as $v) {
  echo '<tr><td>'.$v->timestamp.'</td><td>'.$v->getType()["name"].'</td><td>'.$v->details().'</td><td>'.$x=(!empty($v->object))?$v->object->nameL():"-//-".'</td></tr>';  
}
?>
</table>
</div>
