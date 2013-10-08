    <h4>Category</h4>
        <?php
        $category = $model->category;
        if(!$category->isRoot()) {
            $parent = $category->getParent();
            $sameLevel = $parent->children()->findAll();
        }
        if(!$category->isLeaf()){
            $children = $category->children()->findAll();
        }
        ?>
        <div class="row">
            <div class="span2">
                <ul class="nav nav-pills nav-stacked">
                    <li>
                    <?php
                        if(isset($parent)) echo '<a onClick="changeCategory('.$parent->id.')">'.CHtml::encode($parent->name).'</a>';
                    ?>
                    </li>
            </ul>
            </div>
            <div class="span3">
                <ul class="nav nav-pills nav-stacked">
                <?php
                    if(isset($sameLevel)) {
                        foreach($sameLevel as $cat){
                            if($cat->id == $category->id){
                                $highlight = ' class="active"';
                            } else $highlight = "";
                            ?>
                                <?php echo '<li'.$highlight.'><a onClick="changeCategory('.$cat->id.')">'.CHtml::encode($cat->name).'</a></li>'; ?>
                            <?php
                        }
                    } else echo '<li>'.CHtml::link($category->name).'</li>';
                ?>
            </ul>
            </div>
            <div class="span2">
                <?php if(isset($children)) { ?>
                    <ul class="nav nav-pills nav-stacked">
                    <?php foreach($children as $cat){ ?>
                            <?php echo '<li><a onClick="changeCategory('.$cat->id.')">'.CHtml::encode($cat->name).'</a></li>'; ?>
                    <?php } ?>
                    </ul>
                <?php } ?>
                <ul>
                    <div class="input-append" style="margin-left: -13px;padding-left: 0px;">
                        <input type="text" name="newCategoryName" id="newCategoryName" placeholder="New Subcategory" style="height:16px;width:120px;"/>
                        <?php echo CHtml::link('Add','#',array('class'=>'btn btn-primary btn-small','onClick'=>'addCategory()')); ?>

                    </div>
                </ul>
            </div>
        </div>
