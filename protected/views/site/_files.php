<?php
$files = array();
if ($handle = opendir('upload')) {
    while (false !== ($file = readdir($handle))) {
        if($file != '.' && $file != '..')$files[] = $file;
    }

    closedir($handle);
}

?>

<table class="table table-condensed">
    <tr>
        <th>#</th>
        <th>filename</th>
        <th>functions</th>
    </tr>
    <?php foreach($files as $index=>$file): ?>
    <tr>
        <td><?=$index+1;?></td>
        <td><?=$file;?></td>
        <td>
            <?php echo CHtml::link('Create Project',array('project/create','filename'=>$file),array('class'=>'btn btn-mini')); ?>
            <?php echo CHtml::link('Delete',array('index','action'=>'delete','filename'=>$file),array('class'=>'btn btn-mini btn-danger')); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>