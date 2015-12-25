<?php
/* @var $this PersonnelController */
/* @var $model Personnel */
?>


<div class="perspanel">
	<a href="<?php echo $this->createUrl('/personnel/'.$model->id) ?>">
	<?php 
		$act=!empty($model->personnelPostsHistories[0]);

		//print_r($model->personnelPostsHistories);

		if(!$act)
			echo '<div style="text-decoration: line-through; color: gray; width: 250px; display: inline-block;">';
		else
			echo '<div style=" width: 250px; display: inline-block; float: left;">';

	?>
		<?php echo CHtml::encode($model->fio_full()); ?> 
		</div>
		<?php 
			if($act){
				echo '<div style="width: 420px; display: inline-block; float: left">'.$model->birthday.'</div>';
			}
		?>
	</a>
</div>

