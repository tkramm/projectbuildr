<div style="text-align: center;">
    <div id="images" style="text-align: center;">
        <?php $this->renderPartial('widgets/_imageList',array('model'=>$model,'edit'=>$edit)); ?>
    </div>
    <?php if($edit) { ?>
    <h4>Image Upload</h4>
        <?php 
        $this->widget('ext.EAjaxUpload.EAjaxUpload',
                        array(
                            'id'=>'uploadFile',
                            'config'=>array(
                                'action'=>Yii::app()->createUrl('part/uploadImage',array('id'=>$model->id)),
                                'allowedExtensions'=>array("jpg","jpeg","png","gif"),//array("jpg","jpeg","gif","exe","mov" and etc...
                                'sizeLimit'=>2*1024*1024,// maximum file size in bytes
                                'minSizeLimit'=>1024,// minimum file size in bytes
                                'onComplete'=>'js:function(id,filename,responseJSON){
                                                                    var html = responseJSON.html; 
                                                                    document.getElementById("images").innerHTML = html.replace("\\\","");
                                                                    }',
                                )
        )); 
        ?>
    <?php } ?>
</div>
