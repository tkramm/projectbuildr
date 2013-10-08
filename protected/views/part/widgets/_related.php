<h4>Add Related Part</h4>
<form action="#" method="post">
    <div class="input-append">
        <input id="add_related_id" name="related_id" type="text" placeholder="Part ID" style="width:200px;height:16px;">
        <?php echo CHtml::ajaxSubmitButton('add',array('part/addRelated','id'=>$model->id),array('type'=>'POST','update'=>'#relatedList'),array('class'=>'btn btn-small btn-primary')); ?>
    </div>
</form>  

<div id="relatedList">
    <?php $this->renderPartial('widgets/_relatedList',array('model'=>$model)); ?>
</div>
