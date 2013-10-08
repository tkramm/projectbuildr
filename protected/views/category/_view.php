<?php
$menu = array();

$ancestors = $model->ancestors()->findAll();
$children = $model->children()->findAll();

if($model->isRoot()) {
    $root_id = $model->id;
} else {
    $root_id = $ancestors[0]->id;
}

if($root_id == 1){
    $items = $model->parts;
    $subcategoryItems = Part::getSubcategoryParts($model->id);
    $modelName = 'part';
} elseif($root_id == 2) {
    $items = $model->projects;
    $subcategoryItems = Project::getSubcategoryProjects($model->id);
    $modelName = 'project';
}


foreach($children as $child) {
    if($root_id == 1){
        $childSubcategoryItems = Part::getSubcategoryParts($child->id);
        $childItems = $child->parts;
    } elseif($root_id == 2) {
        $childSubcategoryItems = Project::getSubcategoryProjects($child->id);
        $childItems = $child->projects;
    }
    
    $menu[] = array('label'=>$child->name.' ('.(count($childItems)+count($childSubcategoryItems)).')', 'url'=>array('view', 'id'=>$child->id));
}
$this->breadcrumbs=array();
foreach($ancestors as $category){
    $this->breadcrumbs[$category->name] = array('category/view','id'=>$category->id);
}
$this->breadcrumbs[] = $model->name;


$this->menu=$menu;

?>

<h1><?php echo $model->name; ?></h1>
<?php $this->renderPartial('/'.$modelName.'/_card',array($modelName.'s'=>$items,'width'=>180,'spacing'=>7))?>
<hr />
<?php $this->renderPartial('/'.$modelName.'/_card',array($modelName.'s'=>$subcategoryItems,'width'=>180,'spacing'=>7))?>
    
