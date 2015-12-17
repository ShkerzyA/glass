<?php
/* @var $this VehiclesController */
/* @var $model Vehicles */


?>
<script type="text/javascript">

function init () {
	$('#Vehicles_number').live('focus',function(){$(this).select()});
}
$(document).ready(init());

</script>



<div style="float: right; width: 40%;"><?php
$log=new Log;
$this->renderPartial('/log/rightColumn',array('model'=>$log->lastVehiclesLog(10)),false,false);
?>
</div>
<div style="float: left; width: 58%;">
<?php
	$this->renderPartial('_search_num',array('model'=>$model,)); 
	if(!empty($finded_model)){
		if(!empty($finded_model->id))
			$this->renderPartial('shortView',array('model'=>$finded_model),false,false);
		$this->renderPartial('_carAccess',array('model'=>$finded_model),false,false);
	}
?>
</div>
<div class=result style="clear: both">

</div>