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


<div class="search-form">
<?php $this->renderPartial('_search_num',array(
	'model'=>$model,
)); ?>
</div>

<?php
	if(!empty($finded_model)){
		$this->renderPartial('shortview',array('model'=>$finded_model),false,false);
		$this->renderPartial('_carAccess',array('model'=>$finded_model),false,false);
	}
?>
<div class=result style="clear: both">

</div>