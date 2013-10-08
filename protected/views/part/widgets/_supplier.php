    <h4>Supplier</h4>
    <div style="text-align: right;margin-bottom: 10px;">
        <?php echo CHtml::link('Add Supplier',array('searchSupplier','id'=>$model->id),array('class'=>'btn btn-small btn-primary"')); ?>
    </div>
    <table class="table">
    <tr>
        <th></th>
        <th>Supplier</th>
        <th>Prices</th>
        <th>Link</th>
    </tr>
    <?php foreach ($model->suppliers as $supplier): ?>
        <tr>
            <td>
            </td>
            <td style="vertical-align: center;">
                <?php echo CHtml::link(CHtml::encode($supplier->name),$supplier->url,array('target'=>'_BLANK')); ?>&nbsp;
                <?php echo CHtml::link('<span class="badge badge-important">remove</span>',array('part/removeSupplierRelation','id'=>$model->id,'supplier_id'=>$supplier->id)); ?>
            </td>
            <td>
                <?php 
                    $supply = $model->getSupply($supplier->id);
                    foreach($supply->prices as $price){
                        echo 'from ' . $price->quantity . ': ' . number_format($price->unit_price,4) . '&euro;<br />';
                    }
                    ?>
                <br />
                <form class="form-inline" action="<?php echo CHtml::normalizeURL(array('part/addPrice','id'=>$model->id,'supply_id'=>$supply->id)); ?>" method="post">
                    <?php echo CHtml::hiddenField('supply_id',$supply->id); ?>
                    <?php echo CHtml::textField('quantity','',array('size'=>20,'maxlength'=>255,'class'=>'input-small','placeholder'=>'quantity','style'=>'height:14px;width:55px;')); ?>
                    <?php echo CHtml::textField('price','',array('size'=>20,'maxlength'=>255,'class'=>'input-small','placeholder'=>'price','style'=>'height:14px;width:55px;')); ?>
                    <button type="submit" class="btn btn-mini">add</button>
                    </div>
                </div>
                </form>
            </td>
            <td style="vertical-align: center;">
                <?php echo CHtml::link('open',$supply->url,array('target'=>'_BLANK')); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
