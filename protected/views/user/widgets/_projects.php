<h4><?php echo $model->username; ?>s Projects</h4>
<?php
$projects = $model->projects;
$projectCount = count($projects);
?>
<?php if($projectCount == 0) { ?>
<h4>This user has no projects yet.</h4>
<?php } ?>
<table id="bomTable" class="table table-striped">
    <?php foreach ($projects as $project) { ?>
    <?php 
        $images = $project->images; 
        if(isset($images[0]))$image = Yii::app()->baseUrl."/".Project::getThumbURL($images[0]->id);
        else $image = Yii::app()->baseUrl."/images/no_image.png";
    ?>
    <tr>
        <td style="width: 180px;"><?php echo CHtml::image($image,$project->name,array('style'=>'min-width: 160px;min-height: '.(160/3*2).'px;width: 160px;')); ?></td>
        <td>
            <h4><?php echo CHtml::link(CHtml::encode('#'.$project->id.' - '.$project->name),array('/project/view','id'=>$project->id)); ?></h4>
            <p style="color:#888888;"><?php echo $project->description; ?></p>
            von <?php echo $project->creater->username; ?><br />
            am <?php echo date("d.m.Y",strtotime($project->created)); ?></td>
    </tr>
    <?php } ?>
</table>