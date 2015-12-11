<div class=modal_window_back id='add_rep' style="display: none"></div>
<div id="add_rep" class="add_unit fl_right act_button">добавить отчет</div>
<div style="border: 1px solid grey; position: absolute; margin-top: 40px; z-index: 88; display: none; background: #F0F0F0" class=modal_window id='add_rep'>
<div class=close_this style="align: right; "></div>
<div class=w98>
	<input type=text name=taskname id=taskname value="<?php echo $model->tname.' '.$model->detailsShow(true,false) ?>" placeholder='Имя задачи'>
	<?php 
		if($model->type==1) 
			$this->renderPartial('/actions/report_cart',array('model'=>$model));
	?>
	<select name=taskstat id=taskstat>
		<option value="выполнено">выполнено</option>
		<option value="в процессе">в процессе</option>
		<option value="не выполнено">не выполнено</option>
	</select>
	<textarea style="width: 98%;" name="message_rep" id="message_rep" placeholder="Описание"><?php echo $model->ttext.' '.$model->detailsShow(false,false) ?></textarea><br>
	<textarea style="width: 98%;" name="message_note" id="message_note" placeholder="Примечания"></textarea><br>

	
	<input type=button name="put_report" id="put_report" value="сохранить отчет">
</div>
</div>