    <h4>Documents</h4>
    <div id="documents" style="padding-bottom: 20px;">
        <?php $this->renderPartial('widgets/_documentList',array('model'=>$model,'edit'=>$edit)); ?>
    </div>
    <?php if($edit){ ?>
    <div style="text-align: center;">
        <?php 
            $this->widget('ext.EAjaxUpload.EAjaxUpload',
                            array(
                                'id'=>'uploadDocument',
                                'config'=>array(
                                    'action'=>Yii::app()->createUrl('part/uploadDocument',array('id'=>$model->id)),
                                    'allowedExtensions'=>array("pdf","zip","stl"),//array("jpg","jpeg","gif","exe","mov" and etc...
                                    'sizeLimit'=>30*1024*1024,// maximum file size in bytes
                                    'minSizeLimit'=>1024,// minimum file size in bytes
                                    'onComplete'=>'js:function(id,filename,responseJSON){
                                                                        var html = responseJSON.html; 
                                                                        document.getElementById("documents").innerHTML = html.replace("\\\","");
                                                                        }',
                                    )
            )); 
        ?>
    </div>
    <?php } ?>
