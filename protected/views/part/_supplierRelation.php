<div class="well">
    <h4>Add Supply for "<?php echo $model->name; ?>" @ "<?php echo $supplier->name; ?>"</h4>
    <div style="margin-top: 40px;">
        <form class="form-horizontal" action="<?php echo CHtml::normalizeURL(array('part/addSupplierRelation','id'=>$model->id,'supplier_id'=>$supplier->id)); ?>" method="POST">
        <div class="control-group">
            <label class="control-label" for="part_number">Part Number</label>
            <div class="controls">
                <?php echo CHtml::textField('part_number',$relation->part_number,array('size'=>60,'maxlength'=>255)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="url">url</label>
            <div class="controls">
                <?php echo CHtml::textField('url',$relation->url,array('size'=>60,'maxlength'=>255)); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
            <?php echo CHtml::submitButton('Add Supply',array('class'=>'btn btn-primary btn-small')); ?>
            </div>
        </div>
        </form>    
    </div>
</div>
