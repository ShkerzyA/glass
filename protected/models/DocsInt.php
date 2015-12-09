<?php

/**
 * This is the model class for table "docs".
 *
 * The followings are the available columns in table 'docs':
 * @property integer $id
 * @property integer $creator
 * @property string $doc_name
 * @property string $text_docs
 * @property string $link
 * @property string $date_begin
 * @property string $date_end
 * @property integer $type
 * @property integer $id_catalog
 *		 * The followings are the available model relations:


 * @property Catalogs $idCatalog


 * @property DepartmentPosts $creator0
 */
class DocsInt extends Docs
{

}
