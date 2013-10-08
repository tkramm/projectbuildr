<table class="table">
    <tr>
        <th>Supplier</th>
        <th>Prices</th>
        <th>Link</th>
    </tr>
<?php foreach ($model->suppliers as $supplier): ?>
    <tr>
        <td style="vertical-align: center;">
            <?php echo CHtml::link(CHtml::encode($supplier->name),$supplier->url,array('target'=>'_BLANK')); ?>
        </td>
        <td>
            <?php 
                $supply = $model->getSupply($supplier->id);
                foreach($supply->prices as $price){
                    echo 'from ' . $price->quantity . ': ' . number_format($price->unit_price,3) . '&euro;<br />';
                }
                ?>
        </td>
        <td style="vertical-align: center;">
            <?php echo CHtml::link('open',$supply->url,array('target'=>'_BLANK')); ?>
        </td>
    </tr>
<?php endforeach; ?>
</table>
