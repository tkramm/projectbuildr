<?php
$breadcrumb = array();
$breadcrumb['Parts'] = array('index');
$breadcrumb[] = 'Create Part';

$this->breadcrumbs=$breadcrumb;
?>

<?php 
$user = User::getUser();

$item = $user->getItem($model->id);
$tags = $model->tags;
?>
<div>
    <div class="row">
        <div class="span8">
            <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                <span class="brand" style="font-weight:bold;">
                   <?php 
                   if($model->isNewRecord) echo 'Create Part';
                   else echo 'Update Part'; 
                   ?>
                </span>
                <ul class="nav pull-right">
                    <?php if(!$model->isNewRecord): ?>
                    <li class="divider-vertical"></li>
                    <li><?php echo CHtml::link('<i class="icon-eye-open"></i> View',array('part/view','id'=>$model->id)); ?></li>
                    <?php endif; ?>
                </ul>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div class="nav-collapse collapse">
                    <!-- .nav, .navbar-search, .navbar-form, etc -->
                </div>

                </div>
            </div>
            </div>
            <?php echo $this->renderPartial('_form',array('model'=>$model,'edit'=>true)); ?>
        </div>
        <div class="span4">
        </div>
    </div>
    
</div>