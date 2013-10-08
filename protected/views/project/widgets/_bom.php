<?php
$bestPrice = 0;
$bestBulkPrice = 0;
?>
<table id="bomTable" class="table table-bordered">
    <tr>
        <th>Qty</th>
        <th></th>
        <?php if($edit){ ?>
            <th>Part #</th>
        <?php } ?>
        <th>Name</th>
        <th>Notes</th>
        <th>In Stock</th>
        <th>Price</th>
        <th>Bulkprice</th>
        <?php if($edit){ ?>
            <th></th>
        <?php } ?>
    </tr>
    <?php foreach($model->bom as $item){ ?>
        <tr id="bom_item_<?php echo $item->id; ?>">
            <?php 
                $bestPrice += $item->part->BestPrice;
                $bestBulkPrice += $item->part->BestBulkPrice;
            ?>
            <?php $this->renderPartial('widgets/_bomRow',array('item'=>$item,'edit'=>$edit)); ?>
        </tr>
    <?php } ?>
    <tr id="sum">
        <td colspan="5"></td>
        <td><?php echo $bestPrice; ?></td>
        <td><?php echo $bestBulkPrice; ?></td>
    </tr>        
</table>

<?php if($edit) $this->renderPartial('widgets/_bomForm',array('model'=>$model,'edit'=>true)); ?>
<?php if($edit){ ?>
<script type="text/javascript">
function addToBOM(){
    var project_id = <?php echo $model->id; ?>;  
    var qty = $('input#qty').val();  
    var part_id = $('input#partId').val();  
    var note = $('input#note').val();  
    jQuery.ajax({
        'type':'POST',
        'data':{'id':project_id,
                'qty':qty,
                'part_id':part_id,
                'note':note+" ",
                },
        'url':'<?php echo CHtml::normalizeUrl(array('/project/addBom')); ?>',
        'cache':false,
        'success':function(id){
            $('#bomTable tr:last').after('<tr id="bom_item_'+id+'"></tr>');
            jQuery.ajax({
                'type':'POST',
                'data':{
                    'id':id,
                    'edit':<?php echo ($edit)?'true':'false'; ?>
                    },
                'url':'<?php echo CHtml::normalizeUrl(array('/project/getRow')); ?>',
                'cache':false,
                'success':function(html){jQuery('#bom_item_'+id).html(html)}
            });            
        }
    });
};
function deleteBomItem(id){
    jQuery.ajax({
        'type':'POST',
        'data':{'id':id},
        'url':'<?php echo CHtml::normalizeUrl(array('/project/deleteBomItem')); ?>',
        'cache':false
    });
    jQuery('#bom_item_'+id).hide(200);
};
</script>
<?php } ?>
