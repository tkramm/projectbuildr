<?php
if(!empty($model->images)){
    $images = $model->images;
    if($edit){
        foreach ($images as $image) {
            echo CHtml::image(Yii::app()->baseUrl.'/'.$image->path.'/'.$image->filename) . '<br />';
            if($edit) echo CHtml::link('<span class="badge badge-important"><i class="icon-remove-sign icon-white"></i> remove</span>',array('project/removeImage','id'=>$model->id,'image_id'=>$image->id)) . '<br /><br />'; 
        }
    } else {
        $imagePath = Yii::app()->baseUrl.'/'.$model->images[0]->path.'/'.$model->images[0]->filename;
        $thumbPath = $image = Yii::app()->baseUrl."/".Part::getThumbURL($model->images[0]->id);
        echo '<div id="bigimage" style="margin-bottom:5px;">';
        echo CHtml::link(CHtml::image($thumbPath),$imagePath) . '<br />';
        echo '</div>';
        if(count($images)>1){
            foreach ($images as $image) :
                $imagePath = Yii::app()->baseUrl.'/'.$image->path.'/'.$image->filename;
                $thumbPath = $image = Yii::app()->baseUrl."/".Part::getThumbURL($image->id);
                echo CHtml::image($thumbPath,'',array('style'=>'width:50px;margin:2px;','onClick'=>'showImage("'.$thumbPath.'","'.$imagePath.'")'));
            endforeach; 
        } 
    }
}
?>
<script type="text/javascript">
function showImage(thumb,image){
    html = "<a href=\""+image+"\"><img src=\""+thumb+"\" /></a><br />";
    jQuery('#bigimage').html(html)
};

</script>