<?php 
$breadcrumb = array();
$breadcrumb[] = 'myWorkshop';
$this->breadcrumbs=$breadcrumb;
?>

<div class="page-header">
    <h1>myWorkshop</h1>
</div>
    
<div class="row myWorkshop">
    <div class="span4">
        <div class="well">
            <h4>Parts</h4>
            <ul>
                <li><?php echo CHtml::link('Part locations',array('workshop/locations')); ?></li>
            </ul>
            
        </div>
    </div>
    <div class="span4">
        <div class="well">
            <h4>My Projects</h4>
            
        </div>
    </div>
    <div class="span4">
        <div class="well">
            <h4>Me</h4>
        </div>
    </div>
</div>
