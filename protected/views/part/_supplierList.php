<?php
    foreach ($suppliers as $supplier) {
        echo '<div class="row" style="margin-bottom:5px;">';
            echo '<div class="span2">';
            echo CHtml::link($supplier->name,$supplier->url,array('target'=>'_BLANK'));;
            echo '</div>';
            echo '<div class="span2">';
            echo CHtml::link('select',array('part/addSupplierRelation','id'=>$model->id,'supplier_id'=>$supplier->id),array('class'=>'btn btn-small btn-primary'));
            echo '</div>';        
        echo '</div>';        
    }
?>