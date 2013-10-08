<?php
/* @var $this PartController */
/* @var $model Part */
$node = $model->category;
$path = $node->getPath();
$breadcrumb = array();
$breadcrumb['Parts'] = array('/parts');
foreach ($path as $id => $entry) $breadcrumb[$entry] = array('/category/view','id'=>$id);
$breadcrumb[] = $model->name;

$this->breadcrumbs=$breadcrumb;

$user = User::getUser();

$item = $user->getItem($model->id);
//$tags = $model->tags;
?>
<div>
    <div class="row">
        <div class="span8">
            <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                <span class="brand" style="font-weight:bold;">
                   <?php 
                   if($model->isNewRecord) echo 'Create Project';
                   else echo 'Update Project'; 
                   ?>
                </span>
                <ul class="nav pull-right">
                    <?php if(!$model->isNewRecord): ?>
                    <li class="divider-vertical"></li>
                    <li><?php echo CHtml::link('<i class="icon-repeat"></i> Duplicate',array('project/duplicate','id'=>$model->id)); ?></li>
                    <li class="divider-vertical"></li>
                    <li><?php echo CHtml::link('<i class="icon-eye-open"></i> View',array('project/view','id'=>$model->id)); ?></li>
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
            <div id="categorySelect">
            <?php            
                $widgets = array(
                                $this->renderPartial('widgets/_category',array('model'=>$model,'edit'=>true),true),
                                );
                foreach($widgets as $widget) $this->renderPartial('widgets/_widget',array('content'=>$widget));
            ?>
            </div>
            <?php            
            $widgets = array(
//                            $this->renderPartial('widgets/_supplier',array('model'=>$model,'edit'=>true),true),
//                            $this->renderPartial('widgets/_alternative',array('model'=>$model,'edit'=>true),true),
                            $this->renderPartial('widgets/_bom',array('model'=>$model,'edit'=>true),true),
                            );
            foreach($widgets as $widget) $this->renderPartial('widgets/_widget',array('content'=>$widget));
            ?>
        </div>
        <div class="span4">
            <?php
            $widgets = array(
                                $this->renderPartial('widgets/_images',array('model'=>$model,'edit'=>true),true),
//                                $this->renderPartial('widgets/_attributes',array('model'=>$model,'edit'=>true),true),
                                $this->renderPartial('widgets/_info',array('model'=>$model,'edit'=>true),true),
                                $this->renderPartial('widgets/_tags',array('model'=>$model,'edit'=>true),true),
                                $this->renderPartial('widgets/_documents',array('model'=>$model,'edit'=>true),true),
                                );
            foreach($widgets as $widget) $this->renderPartial('widgets/_widget',array('content'=>$widget));
            ?>


        </div>
    </div>
</div>
<script type="text/javascript">
function changeCategory(id){
    jQuery.ajax({
        'type':'POST',
        'data':{'id':'<?php echo $model->id; ?>','category_id':id},
        'url':'<?php echo CHtml::normalizeUrl(array('/project/updateCategory')); ?>',
        'cache':false,
        'success':function(html){jQuery("#categorySelect").html(html)}});
};
function addCategory(){
    var name = $("#newCategoryName").val();
    if(name){
        jQuery.ajax({
            'type':'POST',
            'data':{'id':'<?php echo $model->id; ?>','name':name},
            'url':'<?php echo CHtml::normalizeUrl(array('/project/addCategory')); ?>',
            'cache':false,
            'success':function(html){jQuery("#categorySelect").html(html)}});
    }
};
</script>