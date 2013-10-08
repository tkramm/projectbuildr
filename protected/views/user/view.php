<?php
$breadcrumb = array();
$breadcrumb['User'] = array('/user/index');
$breadcrumb[] = $model->username;

$this->breadcrumbs=$breadcrumb;

$user = User::getCurrentUser();
?>
<div>
    <div class="row">
        <div class="span8">
            <div class="navbar">
            <div class="navbar-inner">
                <div class="container">

                <?php echo CHtml::link(CHtml::encode($model->username),array('user/view','id'=>$model->id),array('class'=>'brand','style'=>'font-weight:bold;')); ?>
                <?php if(!empty($user) && $user->id == $model->id){ ?>
                <ul class="nav pull-right">
                    <li class="divider-vertical"></li>
                    <li><?php echo CHtml::link('<i class="icon-pencil"></i> Edit',array('project/update','id'=>$model->id)); ?></li>
                </ul>
                <?php } ?>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div class="nav-collapse collapse">
                    <!-- .nav, .navbar-search, .navbar-form, etc -->
                </div>

                </div>
            </div>
            </div>
            <div class="well">
                <?php $this->renderPartial('widgets/_projects',array('model'=>$model,'edit'=>false)); ?>
            </div>
        </div>
        <div class="span4">
            <?php
            $widgets = array(
//                                $this->renderPartial('widgets/_images',array('model'=>$model,'edit'=>false),true),
//                                $this->renderPartial('widgets/_attributes',array('model'=>$model,'edit'=>false),true),
                                $this->renderPartial('widgets/_info',array('model'=>$model,'edit'=>false),true),
//                                $this->renderPartial('widgets/_tags',array('model'=>$model,'edit'=>false),true),
//                                $this->renderPartial('widgets/_documents',array('model'=>$model,'edit'=>false),true),
                                );
            foreach($widgets as $widget) $this->renderPartial('widgets/_widget',array('content'=>$widget));
            ?>
        </div>
    </div>
    
</div>
