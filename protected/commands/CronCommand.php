<?php
class CronCommand extends CConsoleCommand
{
	public function actionMailDeadline($minb,$mina) {
		$deadline=Tasks::beforeDeadline($minb,$mina);
		foreach ($deadline as $t) {
			$t->sendMail($force=True);
		}
	}
}
?>