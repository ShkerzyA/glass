<script>

$(document).ready(init);

function init(){

	//$('#Events_timestamp').val()
	//$('#Events_timestamp_end').val()
	var x=$('#VehicleShedule_timestamp').val();
	var y=$('#VehicleShedule_timestamp_end').val();

	if(x){
		x=x.split(":");
		var begin=(x[0]*60)+(x[1]*1);
	}else{
		var begin=600;
	}
	if(y){
		y=y.split(":");
		var end=(y[0]*60)+(y[1]*1);
	}else{
		var end=800;
	}



	$("#slider").slider({values:[begin,end],
   min:<?php echo ($model::$beginDay*60);?>,
   max:<?php echo ($model::$endDay*60);?>,
   range:true,
   step:<?php echo ($model::$step);?>,
   slide:function(event,ui){
   		var z0 = ui.values[0]/60;
		var x0 = parseInt(z0); //Целая часть
		if(x0<10)
			x0='0'+x0;
		var y0 = (z0 - x0)*60;
		y0=Math.round(y0);
		if(y0<10)
			y0='0'+y0;

		var z1 = ui.values[1]/60;
		var x1 = parseInt(z1); //Целая часть
		if(x1<10){
			x1='0'+x1;
		}
		var y1 = (z1 - x1)*60;
		y1=Math.round(y1);
		if(y1<10){
			y1='0'+y1;
		}
			

      $("#VehicleShedule_timestamp").val(x0+':'+y0);
      $("#VehicleShedule_timestamp_end").val(x1+':'+y1);
   }});
}

</script>
<!--
<div class="indicator_slider">
		<?php 
			//$allDay=(VehicleShedule::$endDay-VehicleShedule::$beginDay)*60;
			/*foreach ($evItervals as $interv) {
				echo '<div style=" left: '.(round((($interv['b']/$allDay)*100),2)).'%; width: '.(round(((($interv['e']-$interv['b'])/$allDay)*100),2)).'%;"></div>';
			}*/

		?>		
</div> -->

