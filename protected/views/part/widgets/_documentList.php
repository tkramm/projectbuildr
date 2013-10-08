<?php 
    if(!empty($model->documents)){
        $documents = $model->documents;
        foreach ($documents as $document) {
            echo CHtml::link($document->name,Yii::app()->baseUrl.'/'.$document->path.'/'.$document->filename);
            if($edit) echo CHtml::link('&nbsp;<span class="badge badge-important"><i class="icon-remove-sign icon-white"></i></span>',array('part/removeDocument','id'=>$model->id,'document_id'=>$document->id)); 
            echo "<br />";
        }
    }
?>