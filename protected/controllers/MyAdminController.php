<?php

class MyAdminController extends Controller
{

	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index'),
				'roles'=>array('administrator'),
			),
		);
	}

	public function actionIndex()
	{
		$this->layout='//layouts/column1';
        $this->render('tree');
	}
}