<?php
/* @var $this PersonnelController */
/* @var $data Personnel */
?>


<div class="perspanel">
	<a href="<?php echo $this->createUrl('/personnel/'.$data->id) ?>">
	<?php 
		$act=!empty($data->personnelPostsHistories[0]);

		//print_r($data->personnelPostsHistories);

		if(!$act)
			echo '<div style="text-decoration: line-through; color: gray; width: 350px; display: inline-block;">';
		else
			echo '<div style=" width: 350px; display: inline-block; float: left;">';

	?>
		<?php echo CHtml::encode($data->surname.' '.$data->name.' '.$data->patr); ?> 
		</div>
		<?php 
			if($act){
				echo '<div style="width: 500px; display: inline-block; float: left">'.$data->personnelPostsHistories[0]->postInfo().'</div>';
			}
		?>
	</a>
</div>

