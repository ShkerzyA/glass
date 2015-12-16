<style>
	tr{
		height: 40px;
	}
	td{
		height: 40px;
		vertical-align: bottom;
	}
	.prc{
		width: 10px;
		background: red;
		float: right;
	}
</style>
<h2>Сводная информация по картриджам</h2>
<div class="rw">
<table class="phonetable">
  <tr><th rowspan="2">Модель</th><th rowspan=2>Общее количество</th><th colspan=2>Полные</th><th colspan=2>Пустые</th><th colspan=2>На заправке</th></tr>
   <tr><th>Ост.</th><th>%</th><th>Ост.</th><th>%</th><th>Ост.</th><th>%</th></tr>
<?php 
foreach ($model as $v) {
  echo '<tr class="'.($cl=($v['prc']<11)?'red':'').'"><td>'.$v['mark'].'</td><td>'.$v['cou'].'</td><td>'.$v['licou'].'</td><td>'.$v['prc'].'%<div class=prc style="height: '.$v['prc'].'%"></div></td><td>'.$v['st'].'</td><td>'.$v['prc_st'].'% <div class=prc style="height: '.$v['prc_st'].'%"></div></td><td>'.$v['ref'].'</td><td>'.$v['prc_ref'].'% <div class=prc style="height: '.$v['prc_ref'].'%"></div></td></tr>';  
}
?>
</table>
</div>
