<?php 
    $images = $item->part->images; 
    if(isset($images[0]))$image = Yii::app()->baseUrl."/".Project::getThumbURL($images[0]->id);
    else $image = Yii::app()->baseUrl."/images/no_image.png";
    $inStock = $item->inStock;
    $percentage = round($inStock / $item->quantity*100);
?>
<td><?php echo $item->quantity; ?></td>
<td><?php echo CHtml::image($image,$item->part->name,array('style'=>'min-width: 80px;min-height: '.(80/3*2).'px;width: 80px;')); ?></td>
<?php if($edit){ ?>
    <td><?php echo $item->part_id; ?></td>
<?php } ?>
<td><?php echo CHtml::link(CHtml::encode($item->part->name),array('/part/view','id'=>$item->part_id)); ?></td>
<td><?php echo $item->note; ?></td>
<td style="text-align: center;">
    <div class="progress progress-info" style="height:20px;margin-bottom: 10px;">
        <div class="bar" style="width: <?php echo $percentage; ?>%"></div>
    </div>
    <?php echo $inStock; ?> of <?php echo $item->quantity; ?>
</td>
<td><?php echo round($item->part->BestPrice,2); ?></td>
<td><?php echo round($item->part->BestBulkPrice,2); ?></td>
<?php if($edit){ ?>
    <td><a onClick="deleteBomItem('<?php echo $item->id; ?>')"><i class="icon-minus-sign"></i></a></td>
<?php } ?>
