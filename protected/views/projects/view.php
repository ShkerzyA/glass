<?php
/* @var $this ProjectsController */
/* @var $model Projects */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create'),'visible'=>(Yii::app()->user->role=='administrator')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id),'visible'=>(Yii::app()->user->role=='administrator')),
	array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
);
?>

<div style="float: left"><?php echo $model->ico() ?></div><h1> <?php echo $model->name; ?></h1>

<?php $exec=$model->potentialExecutors(True); ?>
<?php $all=$model->allTaskCount(); ?>
<?php $tmp=array();
	  $allC=array();
	  $prototype=array();
?>

<table class=phonetable>
	<tr>
		<th>ФИО</th>
		<?php 
			foreach ($all as  $v) {
				$tmp[$v['status']]='<th>'.$v['label'].'</th>';
				$prototype[$v['status']]='<td></td>';
			}
			echo implode('',$tmp);
		?>
	</tr>
	<tr>
		<td>Общее</td>
		<?php 
			foreach ($all as  $v) {
				$allC[$v['status']]=$v['cou'];
			}
			echo '<td>'.implode('</td><td>',$allC).'</td>';
		?>
	</tr>
	<?php foreach ($exec as $ps): ?> 
		<tr>
			<?php 
				$fio=(in_array($ps->id,$model->executors))?$ps->fio_full():'<span style="color: grey">'.$ps->fio_full()."</span>";
			?>
			<td><?php echo $fio; ?></td>
			<?php $cc=$model->persTaskCount($ps->id);
			$tmp=$prototype;

			?>
			<?php 
				foreach ($cc as  $v) {
					$percent=round((($v['cou']/$allC[$v['status']])*100),2);
					$tmp[$v['status']]='<td><div style="background: green; heigth: 100%; display: block; width: '.$percent.'%">'.$percent.'%</div></td>';
				}
				echo implode('',$tmp);
			?>
		</tr>
	<?php endforeach; ?>
</table>

