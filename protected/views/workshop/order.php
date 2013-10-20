<?php 
$breadcrumb = array();
$breadcrumb['myWorkshop'] = array('/workshop');
$breadcrumb[] = 'Bestellen';
$this->breadcrumbs=$breadcrumb;
?>


<div class="row">
    <div class="span6">
        <div class="well">
            <h4>Low stock</h4>
            <table class="table table-condensed">  
                <tr>
                    <th>Part</th>
                    <th>In Stock</th>
                    <th>Treshold</th>
                </tr>
            <?php 
                foreach ($items as $index => $item) {
                        ?>
                    <tr>
                        <td><?php echo CHtml::link($item->part->name,array('part/view','id'=>$item->part->id)); ?></td>
                        <td><?php echo $item->quantity; ?></td>
                        <td><?php echo $item->quantity_warning; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <ul>
                            <?php 
                                    foreach ($item->part->suppliers as $supplier) {
                                        echo '<li>' . $supplier->name . '</li>';
                                    }
                            ?>
                            </ul>
                        </td>
                    </tr>
                        <?php
                }
            ?>
            </table>    
        </div>
    </div>
    <div class="span6">
        <div class="accordion" id="accordion2">
            <?php foreach ($suppliers as $supplier_id => $itemsFromSupplier): ?>
                <?php $supplier = Supplier::model()->findByPk($supplier_id); ?>
                    <div class="accordion-group">
                      <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_<?php echo $supplier_id; ?>">
                          <?php echo $supplier->name; ?>
                        </a>
                      </div>
                      <div id="collapse_<?php echo $supplier_id; ?>" class="accordion-body collapse">
                        <div class="accordion-inner">
                            <table class="table table-condensed">  
                                <tr>
                                    <th>Part</th>
                                    <th>In Stock</th>
                                    <th>Treshold</th>
                                </tr>
                                <?php 
                                    foreach ($itemsFromSupplier as $item_index) {
                                        $item = $items[$item_index];
                                        $supply = $item->part->getSupply($supplier->id);
                                            ?>
                                        <tr>
                                            <td><?php echo CHtml::link($item->part->name,array('part/view','id'=>$item->part->id)); ?></td>
                                            <td><?php echo $item->quantity; ?></td>
                                            <td><?php echo $item->quantity_warning; ?></td>
                                            <td><?php echo CHtml::link('<i class="icon-shopping-cart"></i>',$supply->url,array('target'=>'_blank')); ?></td>
                                        </tr>
                                            <?php
                                    }
                                ?>
                            </table>    
                        </div>
                      </div>
                    </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
