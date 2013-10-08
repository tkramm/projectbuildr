<?php 
$existingAttributes = Attribute::model()->findAll(array(
                                                            'select'=>'name',
                                                            'distinct'=>true,
                                                        ));
$existingAttributeValues = Attribute::model()->findAll(array(
                                                            'select'=>'value',
                                                            'distinct'=>true,
                                                        ));
$autocomplete = array();
$autocomplete_value = array();
foreach ($existingAttributes as $attribute) $autocomplete[] = $attribute->name;
foreach ($existingAttributeValues as $attribute) $autocomplete_value[] = $attribute->value;
?>
<?php if($edit || !empty($model->attribs)): ?>
    <h4>Attributes</h4>
    <?php if(!empty($model->attribs)): ?>
            <table>
                
            <?php foreach($model->attribs as $attribute): ?>
            <tr>
                <td>
                    <?php echo $attribute->name; ?>:
                </td>
                <td style="width:10px;">
                </td>
                <td>
                    <?php echo $attribute->value; ?>
                </td>
                <?php if($edit): ?>
                <td style="width:30px;">
                    <?php echo CHtml::link('<i class="icon-remove-sign"></i>',array('part/removeAttribute','id'=>$model->id,'attribute_id'=>$attribute->id)); ?>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </table>
    <br />
    <?php endif; ?>
<?php if($edit): ?>
        <?php echo CHtml::form(array('part/addAttribute','id'=>$model->id)); ?>
            <div class="input-append" style="width:100%;margin-bottom: 15px;">
                <?php 
                $names = Tag::getNames();
                $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                    'name'=>'name',
                    'source'=>$autocomplete,
                    'options'=>array(
                        'minLength'=>'1',
                    ),
                    'htmlOptions'=>array(
                        'placeholder'=>"Add Attribute...",
                        'style'=>'height:16px;width:160px;',
                    ),
                ));   
                ?>
                <?php 
                $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                    'name'=>'value',
                    'source'=>$autocomplete_value,
                    'options'=>array(
                        'minLength'=>'1',
                    ),
                    'htmlOptions'=>array(
                        'placeholder'=>"Value...",
                        'style'=>'height:16px;width:100px;',
                    ),
                ));   
                ?>
                <input name="add_sttribute_button" class="btn btn-small btn-primary" type="submit" value="add"/>
            </div>
        <?php echo CHtml::endForm(); ?>        
<?php endif; ?>
<?php endif; ?>
