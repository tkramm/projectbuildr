<?php 
$user = User::getUser();
if($user) $item = $user->getItem($model->id);
?>
<h4>Info</h4>

    <table>
        <tr>
            <td colspan="3">This Project uses <?php echo CHtml::link(count($model->bom).' Parts',array('#bom'),array('data-toggle'=>'tab')); ?>.</td>
        </tr>
        <tr>
            <td>Created:</td>
            <td colspan="2"><?php echo CHtml::encode($model->created); ?></td>
        </tr>
        <tr>
            <td style="padding-right: 10px;">Last Update:</td>
            <td colspan="2"><?php echo CHtml::encode($model->updated); ?></td>
        </tr>

    </table>