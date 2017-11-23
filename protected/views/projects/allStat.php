<?php
/* @var $this ProjectsController */
/* @var $model Projects */

$this->breadcrumbs=array(
	
);

?>

<h1>Общая статистика по проектам</h1>
<div>
 <?php 
 	foreach ($personnel as $ps) {
 		echo '<div style="margin: 3px; float: left; background: '.$ps->color().'">'.$ps->fio().'</div>';
 	}
 ?>
</div>

<table class=phonetable>
	<tr>
		<th>Проект</th>
		<th>Статистика</th>
	</tr>
	<?php foreach ($projects as $pj):?>
		<tr>
			<td><?php echo $pj->ico().$pj->name ?></td>
			<td>
				<?php foreach ($personnel as $ps): ?>
				<?php 
					$percent=0;
					if(!empty($commonStat[$pj->id]) and !empty($commonStat[$pj->id][2]) and !empty($persStat[$pj->id]) and !empty($persStat[$pj->id]) and !empty($persStat[$pj->id][$ps->id]) and !empty($persStat[$pj->id][$ps->id][2]))
						$percent=($persStat[$pj->id][$ps->id][2]/$commonStat[$pj->id][2])*90;
				?>
				<div style="width: <?php echo $percent ?>%; display: inline-block; background: <?php echo $ps->color()?>">&nbsp;</div>
				<?php endforeach; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>

