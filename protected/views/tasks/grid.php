<style>

.calendar, .calendar *{
	border: 1px solid grey;
}
</style>
<div style="widht=100%; height: 100%;">
	<table class="calendar">
		<tr>
			<th colspan=3>
				Просрочено
			</th>
			<th rowspan=2 style="width: 50%;">
				Задание
			</th>
			<th colspan=11>
				Сегодня
			</th>
			<th colspan=6>
				Неделя
			</th>
			<th rowspan=2>
				Месяц
			</th>
		</tr>
		<tr>
			<th>Месяц</th>
			<th>Неделя</th>
			<th>День</th>

			<th>08</th>
			<th>09</th>
			<th>10</th>
			<th>11</th>
			<th>12</th>
			<th>13</th>
			<th>14</th>
			<th>15</th>
			<th>16</th>
			<th>17</th>
			<th>18</th>
			<?php $d=new DateTime();
			for ($x=1;$x<7;$x++){
				$d->modify('+1 days');
				echo '<th>'.$d->format('D').'</th>';
			}
			?>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td>24.09.2015 11:33:06 Назначено Зам. карт. (01) Лечебно-диагностический корпус/ 5 эт./ 501 </td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</table>
	<div class=cont style="position: absolute; top: 0px; left: 0px; width: 100%; z-index: 20;">
	</div>
</div>