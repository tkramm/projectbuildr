<?php
/* @var $this PartController */
/* @var $model Part */

$node = $model->category;
$path = $node->getPath();
$breadcrumb = array();
$breadcrumb['Parts'] = array('/site/parts');
foreach ($path as $id => $entry) $breadcrumb[$entry] = array('/category/view','id'=>$id);
$breadcrumb[] = $model->name;

$this->breadcrumbs=$breadcrumb;

$user = User::getUser();
?>
<div>
    <div class="row">
        <div class="span8">
            <div class="navbar">
            <div class="navbar-inner">
                <div class="container">

                <?php echo CHtml::link(CHtml::encode($model->name),array('part/view','id'=>$model->id),array('class'=>'brand','style'=>'font-weight:bold;')); ?>
                <ul class="nav pull-right">
                    <li class="divider-vertical"></li>
                    <li><?php echo CHtml::link('<i class="icon-pencil"></i> Edit',array('part/update','id'=>$model->id)); ?></li>
                </ul>

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
                        <li><?php echo CHtml::link('Related Parts',array('#related'),array('data-toggle'=>'tab')); ?></li>
                        <li><?php echo CHtml::link('Alternative Parts',array('#alternative'),array('data-toggle'=>'tab')); ?></li>
                        <li><?php echo CHtml::link('Projects',array('#projects'),array('data-toggle'=>'tab')); ?></li>
                        <li><?php echo CHtml::link('Suppliers',array('#suppliers'),array('data-toggle'=>'tab')); ?></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="description" style="padding-left: 20px;">
                            <?php echo nl2br(CHtml::encode($model->description)); ?>
                        </div>
                        <div class="tab-pane" id="related">
                            <?php echo $this->renderPartial('widgets/_relatedTab',array('model'=>$model,'edit'=>false)); ?>
                        </div>
                        <div class="tab-pane" id="alternative">
                            <?php echo $this->renderPartial('widgets/_alternativeTab',array('model'=>$model,'edit'=>false)); ?>
                        </div>
                        <div class="tab-pane" id="projects">
                            <?php echo $this->renderPartial('widgets/_projects',array('model'=>$model,'edit'=>false)); ?>
                        </div>
                        <div class="tab-pane" id="suppliers">
                            <?php echo $this->renderPartial('widgets/_supplierTab',array('model'=>$model,'edit'=>false)); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(!Yii::app()->user->isGuest){ ?>
                <div class="well" id="comments" style="padding: 20px 20px 20px 20px;">
                    <?php echo $this->renderPartial('_comments',array('model'=>$model)); ?>
                </div>
            <?php } ?>
        </div>
        <div class="span4">
            <?php
            $widgets = array(
                                $this->renderPartial('widgets/_images',array('model'=>$model,'edit'=>false),true),
                                $this->renderPartial('widgets/_attributes',array('model'=>$model,'edit'=>false),true),
                                $this->renderPartial('widgets/_info',array('model'=>$model,'edit'=>false),true),
                                $this->renderPartial('widgets/_tags',array('model'=>$model,'edit'=>false),true),
                                $this->renderPartial('widgets/_documents',array('model'=>$model,'edit'=>false),true),
                                );
            foreach($widgets as $widget) $this->renderPartial('widgets/_widget',array('content'=>$widget));
            ?>
        </div>
    </div>
    
</div>
<?php if($user) $this->renderPartial('widgets/_locationForm',array('model'=>$model)); ?>

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