<?php
$this->pageTitle=Yii::app()->name . ' - Registration Successful';
$this->breadcrumbs=array(
	'Success',
);

?>
<div class="well" style="text-align: center;">
    <h1 style="margin-bottom: 30px;">Registration Successful!</h1>    
    <div style="margin: 20px;">
        <?php echo CHtml::link('Continue to Login',array('site/login'),array('class'=>'btn btn-primary btn-large')); ?>
    </div>
</div>