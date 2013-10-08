<?php
$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Contact',
);
?>

<div class="page-header">
    <h1>Contact Us</h1>
</div>

<div class="row-fluid">
    <div class="span6">

        <?php if(Yii::app()->user->hasFlash('contact')): ?>

        <div class="flash-success alert alert-success">
                <?php echo Yii::app()->user->getFlash('contact'); ?>
        </div>

        <?php else: ?>


        <div class="form">

        <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'contact-form',
                'htmlOptions'=>array('class'=>'form-horizontal well'),
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                ),
        )); ?>

                <p class="note">Fields with <span class="required">*</span> are required.</p>

                <?php echo $form->errorSummary($model); ?>

                        <?php echo $form->labelEx($model,'name'); ?>
                        <?php echo $form->textField($model,'name'); ?>
                        <?php echo $form->error($model,'name'); ?>

                        <?php echo $form->labelEx($model,'email'); ?>
                        <?php echo $form->textField($model,'email'); ?>
                        <?php echo $form->error($model,'email'); ?>

                        <?php echo $form->labelEx($model,'subject'); ?>
                        <?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128)); ?>
                        <?php echo $form->error($model,'subject'); ?>

                        <?php echo $form->labelEx($model,'body'); ?>
                        <?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
                        <?php echo $form->error($model,'body'); ?>

                <?php if(CCaptcha::checkRequirements()): ?>
                        <?php echo $form->labelEx($model,'verifyCode'); ?>
                        <?php $this->widget('CCaptcha'); ?>
                        <?php echo $form->textField($model,'verifyCode'); ?>
                        <div class="hint">Please enter the letters as they are shown in the image above.
                        <br/>Letters are not case-sensitive.</div>
                        <?php echo $form->error($model,'verifyCode'); ?>
                <?php endif; ?>

                <?php echo CHtml::submitButton('Submit'); ?>

        <?php $this->endWidget(); ?>

        </div><!-- form -->

        <?php endif; ?>
    </div>
    <div class="span6">
        <p>
        If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
        </p>
    </div>
    
</div>