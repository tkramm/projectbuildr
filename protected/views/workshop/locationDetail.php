<?php
?>
<div class="well">
    <h4>Details for <?php echo $location.'-'.$assortment; ?></h4>
    <table class="table table-condensed">  
        <tr>
            <th>Box</th>
            <th>Content</th>
        </tr>
        <?php foreach($locations as $location): ?>
        <tr>
            <td><?php echo $location->box; ?></td>
            <td>
                <table>
                    <?php foreach($location->items as $item){ ?>
                    <tr>
                        <td style="border: 0px;width:300px;"><?php echo CHtml::link($item->part->name,array('part/view','id'=>$item->part->id)); ?></td>
                        <td style="border: 0px;"><?php echo $item->quantity; ?></td>
                    </tr>
                    
                    <?php  } ?>
                </table>
            </td>
        </tr>

        <?php endforeach; ?>
    </table>
</div>
