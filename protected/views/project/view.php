<?php
/* @var $this PartController */
/* @var $model Part */

$node = $model->category;
$path = $node->getPath();
$breadcrumb = array();
$breadcrumb['Projects'] = array('/site/projects');
foreach ($path as $id => $entry) $breadcrumb[$entry] = array('/category/view','id'=>$id);
$breadcrumb[] = $model->name;

$this->breadcrumbs=$breadcrumb;

$user = User::getCurrentUser();
if(!empty($user)) $item = $user->getItem($model->id);
//print_r($item->attributes);
//print_r($user->getItems());
//$tags = $model->tags;
?>
<div>
    <div class="row">
        <div class="span8">
            <div class="navbar">
            <div class="navbar-inner">
                <div class="container">

                <?php echo CHtml::link(CHtml::encode($model->name),array('project/view','id'=>$model->id),array('class'=>'brand','style'=>'font-weight:bold;')); ?>
                <?php if(!empty($user) && $user->id == $model->created_user_id){ ?>
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
                <div class="tabbable"> <!-- Only required for left/right tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><?php echo CHtml::link('Description',array('#description'),array('data-toggle'=>'tab')); ?></li>
                        <li><?php echo CHtml::link('Used Parts',array('#bom'),array('data-toggle'=>'tab')); ?></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="description" style="padding-left: 20px;">
                            <?php echo nl2br(CHtml::encode($model->description)); ?>
                        </div>
                        <div class="tab-pane" id="bom">
                            <?php echo $this->renderPartial('widgets/_bom',array('model'=>$model,'edit'=>false)); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(!Yii::app()->user->isGuest){ ?>
                <div class="well" id="comments" style="padding: 20px 20px 20px 20px;">
                    <?php //echo $this->renderPartial('_comments',array('model'=>$model)); ?>
                </div>
            <?php } ?>
        </div>
        <div class="span4">
            <?php
            $widgets = array(
                                $this->renderPartial('widgets/_images',array('model'=>$model,'edit'=>false),true),
//                                $this->renderPartial('widgets/_attributes',array('model'=>$model,'edit'=>false),true),
                                $this->renderPartial('widgets/_info',array('model'=>$model,'edit'=>false),true),
                                $this->renderPartial('widgets/_tags',array('model'=>$model,'edit'=>false),true),
                                $this->renderPartial('widgets/_documents',array('model'=>$model,'edit'=>false),true),
                                );
            foreach($widgets as $widget) $this->renderPartial('widgets/_widget',array('content'=>$widget));
            ?>
        </div>
    </div>
    
</div>
<?php //if($user) $this->renderPartial('widgets/_locationForm',array('model'=>$model)); ?>

<script type="text/javascript">
function addComment(){
    text = $('#comment_text').val();
    jQuery.ajax({
        'type':'POST',
        'data':{'id':<?php echo $model->id; ?>,
                'text':text
                },
        'url':'<?php echo CHtml::normalizeUrl(array('/part/ajaxAddComment')); ?>',
        'cache':false,
        'success':function(html){jQuery('#comments').html(html)}});
};
</script>