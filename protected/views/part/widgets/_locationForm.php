<?php
$locations = Location::getLocations();
$locations = array_merge(array('please select'),$locations);
?>

<div class="modal hide fade" id="location_modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Set location</h3>
        </div>
        <div class="modal-body" id="location_modal_form">
        <?php echo CHtml::form(array('updateLocation'),'post'); ?>
            <?php echo CHtml::dropDownList('location','', $locations,array('class'=>'input-medium','ajax' => array('type'=>'POST','url'=>CController::createUrl('part/dynamicAssortments'),'update'=>'#assortment',))); ?>
            -
            <?php echo CHtml::dropDownList('assortment','', array(),array('class'=>'input-medium','ajax' => array('type'=>'POST','url'=>CController::createUrl('part/dynamicBoxes'),'update'=>'#box',))); ?>
            -
            <?php echo CHtml::dropDownList('box','', array(),array('class'=>'input-medium')); ?>
            <?php echo CHtml::hiddenField('part_id',$model->id); ?>
        </div>
        <div class="modal-footer">
            <input type="submit" class="btn btn-primary" value="Save changes" />
            <?php CHtml::endForm(); ?>
        </div>
</div>