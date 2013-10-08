<?php 
$breadcrumb = array();
$breadcrumb[] = 'myWorkshop';
$this->breadcrumbs=$breadcrumb;
?>

<div class="page-header">
    <h1>myWorkshop</h1>
</div>
    
<div class="row">
    <div class="span4">
        <div class="well">
            <h4>My Parts</h4>
            
        </div>
    </div>
    <div class="span4">
        <div class="well">
            <h4>My Projects</h4>
            
        </div>
    </div>
    <div class="span4">
        <div class="well">
            <h4>My Locations</h4>
            <?php echo CHtml::link('Manage my locations',array('workshop/locations')); ?>
        </div>
    </div>
</div>
