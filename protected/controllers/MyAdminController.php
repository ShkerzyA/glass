<?php

class MyAdminController extends Controller
{
	public function actionIndex()
	{
		$this->layout='//layouts/column1';
        $this->render('tree');
	}


    public function actionAjaxFillBuilding()
    {
        // если пробуют получить прямой доступ к экшину (не через ajax)
        // тогда обрубаем "крылья")) т.е. возвращаем белую страницу
        if (!Yii::app()->request->isAjaxRequest) {
            exit();
        }

        // с какого узла начинаем вывод дерева? 0 - с первого
        $parentId = 'is null';
        if (isset($_GET['root']) && $_GET['root'] !== 'source') {

        	$parent=Department::model()->findByPk($_GET['root']);

            $parentId = '=\''.(string) $parent->subdiv_rn.'\'' ;
        }
        // сам запрос на получение данных детей (через обычный LEFT JOIN)
        $req = Yii::app()->db->createCommand(
            //"SELECT m1.id, m1.name AS text, m1.id_parent as parent_id, count(m2.id) AS \"hasChildren\" FROM department AS m1 LEFT JOIN department AS m2 ON m1.id=m2.id_parent WHERE m1.id_parent $parentId and (m1.date_end is null  or m1.date_end>current_date) GROUP BY m1.id  ORDER BY m1.name ASC"
        	"SELECT m1.adress, m1.id, m1.bname AS text, m1.parent_subdiv_rn as parent_id, count(m2.id) AS \"hasChildren\" FROM department AS m1 LEFT JOIN department AS m2 ON m1.subdiv_rn=m2.parent_subdiv_rn WHERE m1.parent_subdiv_rn $parentId and (m1.date_end is null  or m1.date_end>current_date) GROUP BY m1.id  ORDER BY m1.name ASC"
        );

        $children = $req->queryAll();


        //print_r($children);
        // возвращаем данные
        echo str_replace(
            '"hasChildren":"0"',
            '"hasChildren":false',
            CTreeView::saveDataAsJson($children)
        );
        exit();
    }
}