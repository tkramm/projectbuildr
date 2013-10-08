<?php 
$breadcrumb = array();
$breadcrumb['myWorkshop'] = array('workshop');
$breadcrumb[] = 'Locations';
$this->breadcrumbs=$breadcrumb;
?>


<div class="row">
    <div class="span6">
        <div class="well">
            <h4>My Locations</h4>
            <table class="table">  
                <tr>
                    <th>Location</th>
                    <th>Assortment</th>
                    <th>Boxes</th>
                    <th></th>
                </tr>
            <?php 
                foreach ($list as $location => $assortments) {
                    foreach($assortments as $assortment => $boxes){
                        ?>
                    <tr>
                        <td><?php echo $location; ?></td>
                        <td><?php echo $assortment; ?></td>
                        <td><?php echo count($boxes); ?></td>
                        <td><?php echo CHtml::ajaxLink(
                                                        'show',
                                                        $this->createUrl('locationDetail'),
                                                        array(
                                                            'update'=>'#detail',
                                                            'type'=>'POST',
                                                            'data'=> array('location'=>$location,
                                                                           'assortment'=>$assortment,
                                                                           ),
                                                        )
                                                    ); ?></td>
                    </tr>
                        <?php
                    } 
                }
            ?>
            </table>    
        </div>
    </div>
    <div class="span6">
        <div id="detail">
        </div>
        <div class="well">
            <h4>Add Location</h4>
            <form class="form-inline" action="<?php echo CHtml::normalizeUrl(array('workshop/locations')); ?>" method="post">
                    <input type="text" id="location" name="new_location[location]" placeholder="Location" style="width:80px;height:16px;">
                    /
                    <input type="text" id="assortment" name="new_location[assortment]" placeholder="Assortment" style="width:80px;height:16px;">
                    /
                    <input type="text" id="boxes" name="new_location[boxes]" placeholder="Boxes" style="width:80px;height:16px;">
                    <input name="set_quantity" class="btn btn-small btn-primary" type="submit" value="add"/>
            </form>
            
        </div>
    </div>
</div>
