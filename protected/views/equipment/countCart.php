<div class="rw">
<table class="rightTable">
  <th>Модель</th><th>Ост.</th><th>%</th>
<?php 
foreach ($model as $v) {
  $prc=round(($v['licou']/$v['cou'])*100);
  echo '<tr class="'.($cl=($prc<11)?'red':'').'"><td>'.$v['mark'].'</td><td>'.$v['licou'].'/'.$v['cou'].'</td><td>'.$prc.'%</td></tr>';  
}
?>
</table>
</div>
