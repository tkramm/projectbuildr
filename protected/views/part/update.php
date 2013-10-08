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
                    <li><?php echo CHtml::link('<i class="icon-repeat"></i> Duplicate',array('part/duplicate','id'=>$model->id)); ?></li>
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
                            $this->renderPartial('widgets/_supplier',array('model'=>$model,'edit'=>true),true),
                            $this->renderPartial('widgets/_alternative',array('model'=>$model,'edit'=>true),true),
                            $this->renderPartial('widgets/_related',array('model'=>$model,'edit'=>true),true),
                            );
            foreach($widgets as $widget) $this->renderPartial('widgets/_widget',array('content'=>$widget));
            ?>
        </div>
        <div class="span4">
            <?php
            $widgets = array(
                                $this->renderPartial('widgets/_images',array('model'=>$model,'edit'=>true),true),
                                $this->renderPartial('widgets/_attributes',array('model'=>$model,'edit'=>true),true),
                                $this->renderPartial('widgets/_info',array('model'=>$model,'edit'=>true),true),
                                $this->renderPartial('widgets/_tags',array('model'=>$model,'edit'=>true),true),
                                $this->renderPartial('widgets/_documents',array('model'=>$model,'edit'=>true),true),
                                );
            foreach($widgets as $widget) $this->renderPartial('widgets/_widget',array('content'=>$widget));
            ?>


        </div>
    </div>
    
</div>
<?php if($user) $this->renderPartial('widgets/_locationForm',array('model'=>$model)); ?>

<script type="text/javascript">
function changeCategory(id){
    jQuery.ajax({
        'type':'POST',
        'data':{'id':'<?php echo $model->id; ?>','category_id':id},
        'url':'<?php echo CHtml::normalizeUrl(array('/part/updateCategory')); ?>',
        'cache':false,
        'success':function(html){jQuery("#categorySelect").html(html)}});
};
function addCategory(){
    var name = $("#newCategoryName").val();
    if(name){
        jQuery.ajax({
            'type':'POST',
            'data':{'id':'<?php echo $model->id; ?>','name':name},
            'url':'<?php echo CHtml::normalizeUrl(array('/part/addCategory')); ?>',
            'cache':false,
            'success':function(html){jQuery("#categorySelect").html(html)}});
    }
};
function removeAlternative(alternativeId){
    if(alternativeId){
        jQuery.ajax({
            'type':'POST',
            'data':{'id':'<?php echo $model->id; ?>','alternative_id':alternativeId},
            'url':'<?php echo CHtml::normalizeUrl(array('/part/removeAlternative')); ?>',
            'cache':false,
            'success':function(html){jQuery("#alternativeList").html(html)}});
    }
};
function removeRelated(relatedId){
    if(relatedId){
        jQuery.ajax({
            'type':'POST',
            'data':{'id':'<?php echo $model->id; ?>','related_id':relatedId},
            'url':'<?php echo CHtml::normalizeUrl(array('/part/removeRelated')); ?>',
            'cache':false,
            'success':function(html){jQuery("#relatedList").html(html)}});
    }
};
</script>