<div class="mess_unit" >
	<div class="rightinfo"> 
		<?php echo $model->timestamp; ?> 
		<?php if(!empty($model->creator0)){
			
			echo "<img height=100% src='";
			echo $ava=$model->creator0->ava();
			echo "'  title='".$model->creator0->fio()."'>";
		} ?> 
	</div>
<?php echo '<div class="mtext">'.$model->ttext.'</div>'; ?>
</div>