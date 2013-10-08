    <h4>Tags</h4>
    <div style="margin-bottom: 10px;">
        <?php if($edit){ ?>
            <?php echo CHtml::form(array('project/addTag','id'=>$model->id)); ?>
                <div class="input-append" style="width:100%;">
                    <?php 
                    $names = Tag::getNames();
                    $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                        'name'=>'newTag',
                        'source'=>$names,
                        // additional javascript options for the autocomplete plugin
                        'options'=>array(
                            'minLength'=>'1',
                        ),
                        'htmlOptions'=>array(
                            'placeholder'=>"Add Tag...",
                            'style'=>'height:16px;',
                        ),
                    ));   
                    ?>
                    <input name="add_tag_button" class="btn btn-small btn-primary" type="submit" value="add"/>
                </div>
            <?php echo CHtml::endForm(); ?>
            <?php foreach($model->tags as $tag): ?>
                <span class="badge badge-important"><?php echo CHtml::link($tag->name,array('project/removeTag','id'=>$model->id,'tag_id'=>$tag->id),array('style'=>'color:#ffffff;')); ?></span>
            <?php endforeach; ?>
        <?php } else { ?>
            <?php foreach($model->tags as $tag): ?>
                <span class="badge badge-info"><?php echo CHtml::link($tag->name,array('tag/'.$tag->name),array('style'=>'color:#ffffff')); ?></span>
            <?php endforeach; ?>
        <?php } ?>
    </div>
