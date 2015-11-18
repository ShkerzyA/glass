<?php 
class FileBehavior extends CActiveRecordBehavior{
    
    public function attach($owner) {
        parent::attach($owner);
                
        $owner = $this->getOwner();

        $validators = $owner->getValidatorList();
        $params = array('types'=>'jpg,jpeg,doc,docx,rar,zip,xls,xlsx,png,gif,pdf,djvu,txt,tif','allowEmpty'=>true); // etc
        $validator = CValidator::createValidator('file', $owner, 'link',$params );
        $validators->add($validator);
    }   

    public function beforeSave($event){
       if(($this->owner->scenario=='insert' || $this->owner->scenario=='update') &&
            ($document=CUploadedFile::getInstance($this->owner,'link'))){
                $sourcePath = pathinfo($document->getName());  
                $fileName = date('YmdHsi') .'.'. $sourcePath['extension'];  // имя будущего файла в базе и ФС
                $this->deleteFile(); // старый документ удалим, потому что загружаем новый
                $this->owner->link=$document;
                $this->owner->link->saveAs(
                    Yii::getPathOfAlias('webroot.media').DIRECTORY_SEPARATOR.'docs'.DIRECTORY_SEPARATOR.$fileName);
                $this->owner->link=$fileName;
            
        }else{
                unset($this->owner->link);
        }
        return true;
    }


    public function beforeDelete($event){
        $this->deleteFile(); // удалили модель? удаляем и файл
        return true;
    }
 
    public function deleteFile(){
        $filePath=Yii::getPathOfAlias('webroot.media').DIRECTORY_SEPARATOR.'docs'.DIRECTORY_SEPARATOR.$this->owner->link;
        if(is_file($filePath))
            unlink($filePath);
        return true;
    }
} 
?>