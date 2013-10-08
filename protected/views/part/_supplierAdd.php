<h1>Add Supplier</h1>

<div class="row">
    <div class="span6">
        <div class="well">
            <div style="margin: 15px;text-align: center;">
                <?php echo CHtml::form(array('searchSupplier','id'=>$model->id),'post',array('class'=>'form-search')); ?>
                    <div class="input-append">
                            <?php 
                        $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                            'name'=>'query',
                            'id'=>'query',
                            'source'=>Supplier::getNames(),
                            // additional javascript options for the autocomplete plugin
                            'options'=>array(
                                'minLength'=>'1',
                            ),
                            'htmlOptions'=>array(
                                'class'=>"span3",
                                'placeholder'=>"Search",
                                'style'=>'height:15px;',
                                'value'=>$supplier->name,
                                //'onChange'=>'querySupplier()',
                            ),
                        ));  

                        ?>

                    </div>
                <?php echo CHtml::endForm(); ?>
                <div id="supplierForm"></div>
            </div>
        </div>
            <div class="well">
                <h4>Suppliers:</h4>
                <div id="supplierList">
                    <?php
                    $this->renderPartial('_supplierList',array('suppliers'=>$suppliers,'model'=>$model));
                    ?>    
                </div>
            </div>
    </div>
    <div class="span6">
            <div class="well">
                <h4>Add new Supplier</h4>
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
                    <?php echo CHtml::submitButton('Add Supplier',array('class'=>'btn btn-primary')); ?>
                    </div>
                </div>
                </form>
            </div>
    </div>
</div>

<script type="text/javascript">
$("#query").keyup(function () {
    var query = $("#query").val();
    console.log("Query:", query);
    jQuery.ajax({
        'type':'POST',
        'data':{'id':'<?php echo $model->id; ?>','query':query},
        'url':'<?php echo CHtml::normalizeUrl(array('/part/supplier')); ?>',
        'cache':false,
        'success':function(html){jQuery("#supplierList").html(html)}});
    $("#name").val(query);
});
</script>