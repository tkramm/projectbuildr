<div class="clearfix">
<?php foreach($projects as $project): ?>
    <?php
    $images = $project->images; 
    if(isset($images[0]))$image = Yii::app()->baseUrl."/".Project::getThumbURL($images[0]->id);
    else $image = Yii::app()->baseUrl."/images/no_image.png";
    ?>
    <div class="polaroid" style="margin: 0px <?php echo $spacing; ?>px <?php echo $spacing*2; ?>px;">
        <div class="partimage" style="width: <?php echo $width; ?>px;height: <?php echo $width/3*2; ?>px;">
            <?php echo CHtml::link(CHtml::image($image,$project->name,array('title'=>$project->name,'style'=>'min-width: '.$width.'px;min-height: '.($width/3*2).'px;width: '.$width.'px;')),array('project/view','id'=>$project->id)); ?>
        </div>
        <div style="text-align: center;width:<?php echo $width; ?>px;margin-top: 10px;height:40px;">
            <?php echo CHtml::encode($project->name); ?>
        </div>
        
    </div>
<?php endforeach; ?>
</div>