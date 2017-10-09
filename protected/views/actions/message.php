<div class=modal_window_back id=add_act style="display: none"></div>
<div id="add_act" class="add_unit fl_right act_button">добавить сообщение</div>
<div style="border: 1px solid grey; position: absolute; margin-top: 40px; z-index: 88; display: none; background: #F0F0F0" class="modal_window findTxArea" id=add_act>
<div class=close_this style="align: right; "></div>
	<img src="<?php echo Yii::app()->request->baseUrl ?>/images/attachFile24.png" class="simplyAttach">
	<textarea style="width: 98%;" class="putFileLink" name="message" id="message" placeholder="сохранить комментарий: ctrl+enter"></textarea><br>
	<input style="width: 98%" type=button name="put_message" id="put_message" value="сохранить комментарий">
</div>