	<div class="row">
		<?php echo $form->labelEx($model,'id_room'); ?>

		<?php $tmp=Rooms::model()->getRooms('eventsOpPl');
echo $form->dropDownList($model,"id_room",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->idCabinet->cname);}),array('empty' => '',)); ?>
		<?php echo $form->error($model,'id_room'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>

		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'date',
   'model' => $model,
   'attribute' => 'date',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
   ),
   'htmlOptions' => array(
       'style' => 'height:20px;'
   ),
	));?>



		<?php echo $form->error($model,'date'); ?>
	</div>

	<table style="width: 97%;"> 
		<tr>
			<td>
	<div class="row">
		<?php echo $form->labelEx($model,'timestamp'); ?>

		<?php echo $form->textField($model,'timestamp',array('readonly'=>true)); ?>

		<?php echo $form->error($model,'timestamp'); ?>
	</div>
			</td>
			<td>
	<div class="row">
		<?php echo $form->labelEx($model,'timestamp_end'); ?>

		<?php echo $form->textField($model,'timestamp_end',array('readonly'=>true)); ?>

		<?php echo $form->error($model,'timestamp_end'); ?>
	</div>

			</td>
		</tr>
	</table>

	
	<?php 
	$evItervals=$model->freeDay(); 
	$this->renderPartial('_indicator_slider',array('evItervals'=>$evItervals),false,false); ?>
	<div id="slider" style="width: 93%;"></div>

	<div class="row">
		<?php echo $form->labelEx($model,'fio_pac'); ?>

		<?php echo $form->textField($model,'fio_pac',array('size'=>60,'maxlength'=>250)); ?>

		<?php echo $form->error($model,'fio_pac'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_gosp'); ?>

		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'date_gosp',
   'model' => $model,
   'attribute' => 'date_gosp',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
   ),
   'htmlOptions' => array(
       'style' => 'height:20px;'
   ),
	));?>

		<?php echo $form->error($model,'date_gosp'); ?>
	</div>


<!--
	<div class="row">

		<?php echo $form->labelEx($model,'creator'); ?>
		<?php echo Customfields::searchPersonnel($model,'creator'); ?>
		<?php echo $form->error($model,'creator'); ?>
	</div> -->

	<div class="row">
		<?php echo $form->labelEx($model,'operator'); ?>
		<?php echo Customfields::searchPersonnel($model,'operator'); ?>
		<?php echo $form->error($model,'operator'); ?>
	</div>



	<div class="row">
		<?php echo $form->labelEx($model,'scrub_nurse'); ?>

		<?php echo Customfields::searchPersonnel($model,'scrub_nurse'); ?>
		<?php echo $form->error($model,'scrub_nurse'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'brigade'); ?>

		<?php echo Customfields::multiPersonnel($model,'brigade'); ?>

		<?php echo $form->error($model,'brigade'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'operations'); ?>

		<?php echo Customfields::multiOperations($model,'operations'); ?>

		<?php echo $form->error($model,'operations'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type_operation'); ?>

		<?php echo $form->dropDownList($model,'type_operation',$model->getTypeOper(),
              array('empty' =>'')); ?>

		<?php echo $form->error($model,'type_operation'); ?>
	</div>