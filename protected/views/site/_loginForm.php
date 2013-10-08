<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'htmlOptions'=>array('class'=>'form-horizontal'),
        'enableClientValidation'=>true,
        'clientOptions'=>array(
                'validateOnSubmit'=>true,
        ),
)); ?>
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
        <?php echo $form->labelEx($model,'rememberMe',array('class'=>'control-label')); ?>
        <div class="controls">
        <?php echo $form->checkBox($model,'rememberMe'); ?> 
        <?php echo $form->error($model,'rememberMe'); ?>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
        <?php echo CHtml::submitButton('Login',array('class'=>'btn')); ?>
        </div>
    </div>


<?php $this->endWidget(); ?>
