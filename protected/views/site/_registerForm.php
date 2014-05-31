<?php $form=$this->beginWidget('CActiveForm', array(
        'htmlOptions'=>array('class'=>'form-horizontal'),
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
)); ?>
	<?php echo $form->errorSummary($model); ?>
    <div class="control-group">
        <?php echo $form->labelEx($model,'username',array('class'=>'control-label')); ?>
        <div class="controls">
        <?php echo $form->textField($model,'username'); ?>
        <?php echo $form->error($model,'username'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model,'password',array('class'=>'control-label')); ?>
        <div class="controls">
        <?php echo $form->passwordField($model,'password'); ?>
        <?php echo $form->error($model,'password'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model,'email',array('class'=>'control-label')); ?>
        <div class="controls">
        <?php echo $form->textField($model,'email'); ?>
        <?php echo $form->error($model,'email'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model,'verifyCode',array('class'=>'control-label')); ?>
        <div class="controls">
        <?php $this->widget('CCaptcha'); ?>
        <?php echo $form->textField($model,'verifyCode'); ?>
        <?php echo $form->error($model,'verifyCode'); ?>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
        <?php echo CHtml::submitButton('Register',array('class'=>'btn')); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
