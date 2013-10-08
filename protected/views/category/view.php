<?php
?>

<h1>Category <?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'root',
		'name',
		'lft',
		'rgt',
		'level',
	),
)); ?>
