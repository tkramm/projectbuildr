<hr />
<h4>New</h4>
<form class="form-horizontal" action="<?php echo CHtml::normalizeURL(array('part/addSupplier','id'=>$model->id)); ?>" method="post">
  <div class="control-group">
    <label class="control-label" for="name">Name</label>
    <div class="controls">
      <?php echo CHtml::textField('name',$supplier->name,array('size'=>60,'maxlength'=>255)); ?>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="description">Description</label>
    <div class="controls">
      <?php echo CHtml::textArea('description',$supplier->description,array('rows'=>6, 'cols'=>50)); ?>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="url">url</label>
    <div class="controls">
        <?php echo CHtml::textField('url',$supplier->url,array('size'=>60,'maxlength'=>255)); ?>
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <?php echo CHtml::ajaxSubmitButton('Add Supplier',array('part/addSupplier','id'=>$model->id),array(
                                                                                            'update'=>'#supplierForm',
                                                                                                    'type'=>'POST',
                                                                                                    'data'=>array(  'id'=>$model->id,
                                                                                                                    'name'=>'js:jQuery("#name").val()',
                                                                                                                    'description'=>'js:jQuery("#description").val()',
                                                                                                                    'url'=>'js:jQuery("#url").val()'
                                                                                                            )
                                                                                                    ),
                                                                                                    array('class'=>'btn btn-primary btn-small')
                    ); ?>
    </div>
  </div>
</form>