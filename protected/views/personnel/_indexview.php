<?php
/* @var $this PersonnelController */
/* @var $data Personnel */
?>


<div class="perspanel">
	<a href="<?php echo $this->createUrl('/personnel/'.$data->id) ?>">
	<?php 
		$act=!empty($data->personnelPostsHistories[0]);
		if(!$act)
			echo '<div style="text-decoration: line-through; color: gray; width: 350px; display: inline-block;">';
		else
			echo '<div style=" width: 350px; display: inline-block;">';

	?>
		<?php echo CHtml::encode($data->surname.' '.$data->name.' '.$data->patr); ?> 
		</div>
		<?php 
			if($act)
				echo $data->personnelPostsHistories[0]->idPost->post.'/'.$data->personnelPostsHistories[0]->idPost->postSubdivRn->name ;
		?>
	</a>
</div>

