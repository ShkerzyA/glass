<div class="rw">
<table class="rightTable">
<tr><th>Модель</th><th>Ост.</th><th>%</th></tr>
<?php 
foreach ($model as $v) {
  echo '<tr class="'.($cl=($v['prc']<11)?'red':'').'"><td>'.$v['mark'].'</td><td>'.$v['licou'].'/'.$v['cou'].'</td><td>'.$v['prc'].'%</td></tr>';  
}
?>
</table>
</div>
