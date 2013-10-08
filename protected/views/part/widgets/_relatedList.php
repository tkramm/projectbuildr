<?php if(!empty($model->related)) : ?>
    <div class="clearfix">
    <?php
    $width = 150;
    $spacing = 8;
    ?>
    <?php foreach($model->related as $part): ?>
        <?php
        $images = $part->images; 
        if(isset($images[0]))$image = Yii::app()->baseUrl."/".Part::getThumbURL($images[0]->id);
        else $image = Yii::app()->baseUrl."/images/no_image.png";
        ?>
        <div class="polaroid" style="margin: 0px <?php echo $spacing; ?>px <?php echo $spacing*2; ?>px;">
            <div style="position:absolute;margin-left:-15px;margin-top:-18px;"><?php echo CHtml::link('<i class="icon-remove-sign"></i>','#',array('onClick'=>'removeRelated('.$part->id.')')); ?></div>
            <div class="partimage" style="width: <?php echo $width; ?>px;height: <?php echo $width/3*2; ?>px;">
                <?php echo CHtml::link(CHtml::image($image,$part->name,array('title'=>$part->name,'style'=>'min-width: '.$width.'px;min-height: '.($width/3*2).'px;width: '.$width.'px;')),array('part/view','id'=>$part->id)); ?>
            </div>
            <div style="text-align: center;width:<?php echo $width; ?>px;margin-top: 10px;height:40px;">
                <?php echo CHtml::encode($part->name); ?>
            </div>

        </div>
    <?php endforeach; ?>
    </div>
<?php endif; ?>