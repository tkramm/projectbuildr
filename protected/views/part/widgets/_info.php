<?php 
$user = User::getUser();
if($user) $item = $user->getItem($model->id);

$projectCount = count($model->projects);
$projectCountString = $projectCount . ' Project';
if($projectCount == 0 || $projectCount > 1) $projectCountString = $projectCountString . 's';
if($projectCount == 0 || $projectCount > 1) $useString = 'use';
else $useString = 'uses'; 
?>
<h4>Info</h4>

    <table>
        <?php if(!empty($item)): ?>
        <tr>
            <td style="width: 120px;">Your Stock</td>
            <td colspan="2">
                <form class="navbar-search pull-left" action="#" method="post">
                    <div class="input-prepend input-append">
                        <button id="quantity_subtract" class="btn btn-small" type="button">-</button>
                        <button id="quantity_add" class="btn btn-small" type="button">+</button>
                        <input type="text" id="item_quantity" name="quantity" class="search-query" placeholder="Quantity" value="<?php echo $item->quantity; ?>" style="width:50px;height:16px;">
                        <?php echo CHtml::ajaxSubmitButton('set',array('part/updateItemQuantity','id'=>$model->id),array('type'=>'POST'),array('class'=>'btn btn-small btn-primary')); ?>
                    </div>
                </form>
            </td>
        </tr>
        <?php endif; ?>
        <tr>
            <td>Best Price</td>
            <td colspan="2"><?php echo round($model->BestPrice,4); ?> &euro;</td>
        </tr>
        <tr>
            <td>Best Bulk Price</td>
            <td colspan="2"><?php echo round($model->BestBulkPrice,4); ?> &euro;</td>
        </tr>
        <?php if(!empty($item)): ?>
        <tr>
            <td>Value</td>
            <td colspan="2"><?php echo round($item->value,2); ?> &euro;</td>
        </tr>
        <tr>
            <td>Bulk Value</td>
            <td colspan="2"><?php echo round($item->bulkValue,2); ?> &euro;</td>
        </tr>
        <?php endif; ?>
        <tr>
            <td>Friends Stock</td>
            <td colspan="2">0</td>
        </tr>
        <tr>
            <td>Overall Stock</td>
            <td colspan="2">0</td>
        </tr>
        <?php if(!empty($item)): ?>
        <tr>
            <td colspan="2">Min. Treshold</td>
            <td>
                <form class="navbar-search pull-left" action="#" method="post">
                    <div class="input-prepend input-append">
                        <button id="quantity_warning_subtract" class="btn btn-small" type="button">-</button>
                        <button id="quantity_warning_add" class="btn btn-small" type="button">+</button>
                        <input id="item_quantity_warning" name="quantity_warning" type="text" class="search-query" placeholder="Quantity" value="<?php echo $item->quantity_warning; ?>" style="width:50px;height:16px;">
                        <?php echo CHtml::ajaxSubmitButton('set',array('part/updateItemQuantityWarning','id'=>$model->id),array('type'=>'POST'),array('class'=>'btn btn-small btn-primary')); ?>
                    </div>
                </form>                        </td>
        </tr>
        <?php endif; ?>
        <?php if(!empty($item)){ ?>
        <tr>
            <td style="padding: 2px;" colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding: 2px;">Location</td>
            <td style="padding: 2px;" colspan="2">
                <button type="button" class="btn btn-small btn-primary" data-toggle="modal" data-target="#location_modal"><?php echo $item->location->location; ?> - <?php echo $item->location->assortment; ?> - <?php echo $item->location->box; ?></button>
                <?php echo CHtml::link('<i class="icon-remove icon-white"></i>',array('part/removeFromStock','id'=>$model->id),array('class'=>'btn btn-danger btn-small')); ?>
            </td>
        </tr>
        <?php } elseif(!empty($user))  { ?>
        <tr>
            <td style="padding: 2px;" colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding: 2px;text-align: center;" colspan="3">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#location_modal">Add part to my stock</button>                                                        
            </td>
        </tr>

        <?php } else { ?>
        <tr>
            <td style="padding: 2px;" colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding: 2px;text-align: center;" colspan="3">
                <span class="badge badge-warning"><?php echo CHtml::link('Login to add to stock',array('site/login'),array('style'=>'color:#ffffff;')); ?></span>
            </td>
        </tr>

        <?php } ?>
        <tr>
            <td style="padding: 2px;" colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3"><?php echo CHtml::link($projectCountString,array('#projects'),array('data-toggle'=>'tab')); ?> <?php echo $useString; ?> this part.</td>
        </tr>
        <tr>
            <td style="padding: 2px;">&nbsp;</td>
            <td></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Created:</td>
            <td colspan="2"><?php echo CHtml::encode($model->created); ?></td>
        </tr>
        <tr>
            <td style="padding-right: 10px;">Last Update:</td>
            <td colspan="2"><?php echo CHtml::encode($model->updated); ?></td>
        </tr>
        <?php if(!empty($item)): ?>
        <tr>
            <td style="padding: 2px;" colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding-right: 10px;">Added to myWorkshop:</td>
            <td colspan="2"><?php echo CHtml::encode($item->created); ?></td>
        </tr>
        <tr>
            <td style="padding: 2px;" colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding-right: 10px;">Last change in myWorkshop:</td>
            <td colspan="2"><?php echo CHtml::encode($item->updated); ?></td>
        </tr>
        <?php endif; ?>
    </table>

<script type="text/javascript">
$("#quantity_add").click(function () {$("#item_quantity").val(parseFloat($("#item_quantity").val()) + 1);});
$("#quantity_subtract").click(function () {$("#item_quantity").val(parseFloat($("#item_quantity").val()) - 1);});
$("#quantity_warning_add").click(function () {$("#item_quantity_warning").val(parseFloat($("#item_quantity_warning").val()) + 1);});
$("#quantity_warning_subtract").click(function () {$("#item_quantity_warning").val(parseFloat($("#item_quantity_warning").val()) - 1);});
</script>
