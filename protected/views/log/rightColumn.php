<div class="rw">
<table class="rightTable">
<tr><th>Действие</th><th>Детали</th><th>%</th></tr>
<?php 
foreach ($model as $v) {
  echo '<tr><td>'.$v->getType()["name"].'</td><td>'.$v->details().'</td><td>'.$x=(!empty($data->object))?$data->object->nameL():"нет связи".'</td></tr>';  
}
?>
</table>
</div>
