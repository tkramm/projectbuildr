<?php
$this->breadcrumbs=array(
	'Search Results',
);
?>
<div class="page-header">
    <h3>Search Results for "<?php echo $search['query']; ?>"</h3>
    <?php $this->renderPartial('_searchForm',array('search'=>$search)); ?>
</div>
<div class="row">
    <div class="span8">
        <?php $this->renderPartial('_searchResults',array('parts'=>$parts)); ?>
    </div>
    <div class="span4">
        <div class="well" style="text-align: center;">
            <div style="font-size: 18px;margin: 10px 0px 20px;">The part you search for is not in the list?</div>
            <?php echo CHtml::form(array('part/create'),'post'); ?>
                <?php echo CHtml::hiddenField('name',$search['query']); ?>
                <?php echo CHtml::linkButton('<i class="icon-plus-sign icon-white"></i> Create this Part',array('class'=>'btn btn-primary','type'=>'button')); ?>
            <?php echo CHtml::endForm(); ?>
        </div>
    </div>
</div>
