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
  <tr><th>Модель</th><th>Общее количество</th><th>Полные</th><th>Пустые</th><th>На заправке</th><th>На восстановление</th></tr>
<?php 
foreach ($model as $v) {
  echo '<tr class="'.($cl=($v['prc']<11)?'red':'').'"><td>'.$v['mark'].'</td><td>'.$v['cou'].'</td>
  <td>'.$v['licou'].'('.$v['prc'].'%)<div class="prc cfull" style="height: '.$v['prc'].'%"></div></td>
  <td>'.$v['st'].'('.$v['prc_st'].'%) <div class="prc cempty" style="height: '.$v['prc_st'].'%"></div></td>
  <td>'.$v['ref'].'('.$v['prc_ref'].'%) <div class="prc crefill" style="height: '.$v['prc_ref'].'%"></div></td>
  <td>'.$v['rep'].'('.$v['prc_rep'].'%) <div class="prc crefill" style="height: '.$v['prc_rep'].'%"></div></td>
  
  </tr>';  
}
?>
</table>
</div>
