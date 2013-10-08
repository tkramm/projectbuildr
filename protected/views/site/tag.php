<?php
$this->breadcrumbs=array(
	'Tag:'.$name,
);
?>

<div class="page-header">
    <h3>Parts tagged with "<?php echo $name; ?>"</h3>
</div>

<?php $this->renderPartial('/part/_card',array('parts'=>$parts,'width'=>160,'spacing'=>8,))?>