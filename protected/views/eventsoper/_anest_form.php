	<div class="row">
		<?php echo $form->labelEx($model,'anesthesiologists'); ?>

		<?php echo Customfields::multiPersonnel($model,'anesthesiologists'); ?>

		<?php echo $form->error($model,'anesthesiologists'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'anesthesiologist_w'); ?>

		<?php echo Customfields::searchPersonnel($model,'anesthesiologist_w'); ?>
		<?php echo $form->error($model,'anesthesiologist_w'); ?>
	</div>
