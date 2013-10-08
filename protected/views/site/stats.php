<?php 
$this->pageTitle=Yii::app()->name; 
$this->breadcrumbs[] = 'Statistics';

?>

<div class="navbar">
<div class="navbar-inner">
    <div class="container">
        <span class="brand" style="font-weight:bold;">Statistics</span>

    <!-- Everything you want hidden at 940px or less, place within here -->
    <div class="nav-collapse collapse">
        <!-- .nav, .navbar-search, .navbar-form, etc -->
    </div>

    </div>
</div>
</div>
<div class="well">
<?php foreach($counts as $title => $count): ?>
<div class="row">
    <div class="span3" style="font-weight: bold;">
        <?php echo $title; ?>
    </div>
    <div class="span3">
        <?php echo $count; ?>
    </div>
</div>

<?php endforeach; ?>
</div>