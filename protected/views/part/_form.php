<?php $form=$this->beginWidget('CActiveForm', array(
                                                                'id'=>'part-form',
                                                                'enableAjaxValidation'=>false,
                                                                'htmlOptions'=>array('class'=>'form-horizontal'),
                                                                )
                                                                );
            ?>
            <div class="well">
                <div class="control-group">
                    <?php echo $form->labelEx($model,'name',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255, 'placeholder'=>'name')); ?>
                        <?php echo $form->error($model,'name'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model,'description',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($model,'description',array('rows'=>10, 'placeholder'=>'description','style'=>'width:90%;')); ?>
                        <?php echo $form->error($model,'description'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls" style="text-align: right;margin-right: 40px;">
                        <?php echo CHtml::submitButton('Save',array('class'=>'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>