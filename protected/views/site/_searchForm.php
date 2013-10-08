<form class="form-inline" action="<?php echo CHtml::normalizeURL(array('search')); ?>" method="post">
    <?php echo CHtml::textField('query',$search['query'],array('class'=>'input-medium','placeholder'=>'Search')); ?>
    &nbsp;
    &nbsp;
    <label class="checkbox">
        <?php echo CHtml::checkbox('stock',$search['stock']); ?> My Stock
    </label>
    &nbsp;
    &nbsp;
    <?php echo CHtml::submitButton('Search',array('class'=>'btn btn-primary')); ?>
</form>