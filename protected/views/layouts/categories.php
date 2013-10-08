<?php $this->beginContent('//layouts/main'); ?>
<div class="container-fluid" style="margin-top: 10px;">
  <div class="row-fluid">
    <div class="span3" style="padding-right: 20px;padding-top: 0px;">
      <?php  
		$this->beginWidget('zii.widgets.CPortlet', array('title'=>'<h3>Categories</h3>',));
		$this->widget('zii.widgets.CMenu', array('items'=>$this->menu,'htmlOptions'=>array('class'=>'nav nav-tabs nav-stacked'),));
		$this->endWidget();
	?>
    </div>
    <div class="span9">
      <?php echo $content; ?>
    </div>
  </div>
</div>
<?php $this->endContent(); ?>