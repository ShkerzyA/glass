<?php

class MyDocsController extends Controller
{
	public function actionIndex($id=NULL)
	{
		$this->layout='//layouts/column1';
        $this->render('tree',array('id_cat'=>$id));
	}
}