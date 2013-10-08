<?php $this->pageTitle=Yii::app()->name; ?>

<div class="row-fluid">
    <div class="span6">
        <div class="hero-unit">
        <h1>Parts</h1>
        <p>Browse all the bits and pieces for your projects</p>
        <p style="text-align: right;">
            <?php echo CHtml::link('View',array('category/view','id'=>1),array('class'=>'btn btn-primary btn-large')); ?>
        </p>
        </div>
    </div>
    <div class="span6">
        <div class="hero-unit">
        <h1>Projects</h1>
        <p>Browse Projects</p>
        <p style="text-align: right;">
            <?php echo CHtml::link('View',array('category/view','id'=>2),array('class'=>'btn btn-primary btn-large')); ?>
        </p>
        </div>
    </div>
</div>
<?php if(!Yii::app()->user->isGuest){ ?>
<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
            <span class="brand" style="font-weight:bold;">Your latest updates</span>

        <!-- Everything you want hidden at 940px or less, place within here -->
        <div class="nav-collapse collapse">
            <!-- .nav, .navbar-search, .navbar-form, etc -->
        </div>

        </div>
    </div>
</div>
<?php
$parts = array();
$items = Item::model()->findAll(array('condition'=>'user_id = '.Yii::app()->User->id,'limit'=>6,'order'=>'updated DESC'));
foreach ($items as $item) $parts[] = $item->part;
$this->renderPartial('/part/_card',array('parts'=>$parts,'width'=>160,'spacing'=>9));    
}
?>       
<div class="navbar">
<div class="navbar-inner">
    <div class="container">
        <span class="brand" style="font-weight:bold;">Newest Parts</span>

    <!-- Everything you want hidden at 940px or less, place within here -->
    <div class="nav-collapse collapse">
        <!-- .nav, .navbar-search, .navbar-form, etc -->
    </div>

    </div>
</div>
</div>
<div id="recent_parts" style="height: 410px;" class="clearfix">
    <?php
    $this->renderPartial('_recent',array('offset'=>0))      
    ?>       
</div>
<script type="text/javascript">
function updateRecent(offset){
        jQuery.ajax({
            'type':'POST',
            'data':{'offset':offset},
            'url':'<?php echo CHtml::normalizeUrl(array('getRecent')); ?>',
            'cache':false,
            'success':function(html){jQuery("#recent_parts").html(html)}});
};
</script>