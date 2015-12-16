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

	.cempty{
		background: red;
	}

	.cfull{
		background: green;
	}

	.crefill{
		background: grey;
	}


</style>
<h2>Сводная информация по картриджам</h2>
<div class="rw">
<table class="phonetable">
  <tr><th rowspan="2">Модель</th><th rowspan=2>Общее количество</th><th colspan=3>%</th><th colspan=3>Количество</th></tr>
   <tr><th>Полн.</th><th>Пуст.</th><th>Запр.</th><th>Полн.</th><th>Пуст.</th><th>Запр.</th></tr>
<?php 
foreach ($model as $v) {
  echo '<tr class="'.($cl=($v['prc']<11)?'red':'').'"><td>'.$v['mark'].'</td><td>'.$v['cou'].'</td>
  <td>'.$v['prc'].'%<div class="prc cfull" style="height: '.$v['prc'].'%"></div></td>
  <td>'.$v['prc_st'].'% <div class="prc cempty" style="height: '.$v['prc_st'].'%"></div></td>
  <td>'.$v['prc_ref'].'% <div class="prc crefill" style="height: '.$v['prc_ref'].'%"></div></td>
  <td>'.$v['licou'].'</td>
  <td>'.$v['st'].'</td>
  <td>'.$v['ref'].'</td>
  
  </tr>';  
}
?>
</table>
</div>
