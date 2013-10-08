    <div style="width:32px;height: 404px;float:left;text-align: center;">
        <?php if($offset>0): ?>
        <i class="icon-chevron-left" style="position:relative;top:192px;" onClick="updateRecent(<?php echo ($offset-10); ?>)"></i>
        <?php endif; ?>
    </div>
    <div style="float: left;width: 1105px;">
        <?php
        $parts = Part::model()->findAll(array('limit'=>10,'offset'=>$offset,'order'=>'created DESC'));
        $this->renderPartial('/part/_card',array('parts'=>$parts,'width'=>185,'spacing'=>10))      
        ?>       
    </div>
    <div style="width:32px;height: 404px;float:left;text-align: center;">
        <i class="icon-chevron-right" style="position:relative;top:192px;" onClick="updateRecent(<?php echo ($offset+10); ?>)"></i>
    </div>