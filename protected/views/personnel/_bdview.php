<?php
/* @var $this PersonnelController */
/* @var $model Personnel */
?>


<div class="perspanel">
	<!-- <a href="<?php echo $this->createUrl('/personnel/'.$model->id) ?>"> -->
	<?php 
		$act=!empty($model->personnelPostsHistories[0]);
	?>
		<?php echo $model->wrapFio('fio_full'; ?> 
 <!--	</a> -->
</div>

