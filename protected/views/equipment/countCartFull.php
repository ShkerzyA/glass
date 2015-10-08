<h2>Сводная информация по картриджам</h2>
<div class="rw">
<table class="phonetable">
  <tr><th rowspan="2">Модель</th><th rowspan=2>Общее количество</th><th colspan=2>Полные</th><th colspan=2>Пустые</th><th colspan=2>На заправке</th></tr>
   <tr><th>Ост.</th><th>%</th><th>Ост.</th><th>%</th><th>Ост.</th><th>%</th></tr>
<?php 
foreach ($model as $v) {
  echo '<tr class="'.($cl=($v['prc']<11)?'red':'').'"><td>'.$v['mark'].'</td><td>'.$v['cou'].'</td><td>'.$v['licou'].'</td><td>'.$v['prc'].'%</td><td>'.$v['st'].'</td><td>'.$v['prc_st'].'%</td><td>'.$v['ref'].'</td><td>'.$v['prc_ref'].'%</td></tr>';  
}
?>
</table>
</div>
