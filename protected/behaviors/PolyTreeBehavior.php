<?php 
class PreFillBehavior extends CControllerBehavior{

    public $own=array(
        'DepartmentPosts'=>'groups',
        'Tasks'=>'executors',
        'Rooms'=>'managers',
        'Catalogs'=>'groups');

    private function getField(){
        $model_name=trim(get_class($this->owner));
        $val=$this->own[$model_name];
        return $val;
    }

       public function actionRootFillTree()
    {
        // если пробуют получить прямой доступ к экшину (не через ajax)
        // тогда обрубаем "крылья")) т.е. возвращаем белую страницу
        if (!Yii::app()->request->isAjaxRequest) {
            exit();
        }

        $so=new Building;

        //print_r($so);

        echo Building::$modelLabelS;

        // с какого узла начинаем вывод дерева? 0 - с первого
        $parentId = '';
        if (isset($_GET['root']) && $_GET['root'] !== 'source') {
            $parentId = 'WHERE m1.id='.(int)$_GET['root'].' ';
        }
        // сам запрос на получение данных детей (через обычный LEFT JOIN)
        $req = Yii::app()->db->createCommand(
            //"SELECT m1.id, m1.name AS text, m1.id_parent as parent_id, count(m2.id) AS \"hasChildren\" FROM department AS m1 LEFT JOIN department AS m2 ON m1.id=m2.id_parent WHERE m1.id_parent $parentId and (m1.date_end is null  or m1.date_end>current_date) GROUP BY m1.id  ORDER BY m1.name ASC"
            "SELECT m1.id, m1.bname AS text, m1.id as parent_id, count(m2.id) AS \"hasChildren\" FROM building AS m1 LEFT JOIN floor AS m2 ON m1.id=m2.id_building  $parentId GROUP BY m1.id  ORDER BY m1.bname ASC"
        );

        $children = $req->queryAll();

        if(Yii::app()->user->checkAccess('changeObjects')){
            foreach ($children as &$v) {
                $v=array_merge($v,ruleButton::get($v[id],'Building','Floor'));
            }
        }

        //print_r($children);
        // возвращаем данные
        echo str_replace(
            '"hasChildren":"0"',
            '"hasChildren":false',
            MyTreeView::saveDataAsJson($children)
        );
        exit();
    }

           public function actionAjaxFillTree()
    {
        // если пробуют получить прямой доступ к экшину (не через ajax)
        // тогда обрубаем "крылья")) т.е. возвращаем белую страницу
        if (!Yii::app()->request->isAjaxRequest) {
            exit();
        }

        // с какого узла начинаем вывод дерева? 0 - с первого
        $parentId = '';
        if (isset($_GET['root']) && $_GET['root'] !== 'source') {
            $parentId = 'WHERE m1.id_building='.(int)$_GET['root'].' ';
        }
        // сам запрос на получение данных детей (через обычный LEFT JOIN)
        $req = Yii::app()->db->createCommand(
            //"SELECT m1.id, m1.name AS text, m1.id_parent as parent_id, count(m2.id) AS \"hasChildren\" FROM department AS m1 LEFT JOIN department AS m2 ON m1.id=m2.id_parent WHERE m1.id_parent $parentId and (m1.date_end is null  or m1.date_end>current_date) GROUP BY m1.id  ORDER BY m1.name ASC"
            "SELECT m1.id, m1.fname AS text, m1.id as parent_id, count(m2.id) AS \"hasChildren\" FROM floor AS m1 LEFT JOIN cabinet AS m2 ON m1.id=m2.id_floor $parentId GROUP BY m1.id  ORDER BY m1.fnum ASC"
        );

        $children = $req->queryAll();

        foreach ($children as &$v) {
            $v=array_merge($v,ruleButton::get($v[id],'Floor','Cabinet'));
        }

       
        //print_r($children);
        // возвращаем данные
        echo str_replace(
            '"hasChildren":"0"',
            '"hasChildren":false',
            MyTreeView::saveDataAsJson($children)
        );
        exit();
    }

} 

?>