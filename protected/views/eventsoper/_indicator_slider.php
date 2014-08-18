<div class="indicator_slider">
		<?php 
			$evItervals=$model->freeDay(); 
			$allDay=($model::$endDay-$model::$beginDay)*60;
			foreach ($evItervals as $interv) {
				echo '<div style=" left: '.(round((($interv['b']/$allDay)*100),2)).'%; width: '.(round(((($interv['e']-$interv['b'])/$allDay)*100),2)).'%;"></div>';
			}

		?>		
</div>

