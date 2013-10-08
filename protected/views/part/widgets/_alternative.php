<h4>Add Alternative Part</h4>
<form action="#" method="post">
    <div class="input-append">
        <input id="add_alternative_id" name="alternative_id" type="text" placeholder="Part ID" style="width:200px;height:16px;">
        <?php echo CHtml::ajaxSubmitButton('add',array('part/addAlternative','id'=>$model->id),array('type'=>'POST','update'=>'#alternativeList'),array('class'=>'btn btn-small btn-primary')); ?>
    </div>
</form>  

<div id="alternativeList">
    <?php $this->renderPartial('widgets/_alternativeList',array('model'=>$model)); ?>
</div>
