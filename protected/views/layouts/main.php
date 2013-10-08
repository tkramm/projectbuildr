<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/css/bootstrap.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/css/bootstrap-responsive.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css" media="screen, projection" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
</head>

<body>
    <div class="navbar navbar-fixed-top navbar-inverse">
        <div class="navbar-inner">
            <div class="container">
                <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div id="mainmenu">
                    <?php echo CHtml::link(CHtml::encode(Yii::app()->name),array('/site/index'),array('class'=>'brand'));; ?>
                    <div class="nav-collapse collapse">
                        <?php $this->widget('zii.widgets.CMenu',array(
                                'items'=>array(
                                        array('label'=>'Home', 'url'=>array('/site/index')),
//                                        array('label'=>'Stock', 'url'=>array('/item')),
                                        array('label'=>'Parts', 'url'=>array('/parts')),
                                        array('label'=>'Projects', 'url'=>array('/projects')),
                                        array('label'=>'myWorkshop', 'url'=>array('/workshop'), 'visible'=>!Yii::app()->user->isGuest),
                                        array('label'=>'Search', 'url'=>array('/site/search')),
                                        array('label'=>'Login/Register', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                                        array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
                                ),
                                'htmlOptions'=>array(
        //                            'class'=>'nav nav-pills'
        //                            'class'=>'nav nav-tabs'
                                    'class'=>'nav'
                                ),
                        )); ?>
                        <form class="navbar-search pull-right" action="<?php echo CHtml::normalizeUrl(array('site/search')); ?>" method="post">
                                <?php 
                                $names = Part::getNames();
                                $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                    'name'=>'query',
                                    'id'=>'siteSearch',
                                    'source'=>$names,
                                    // additional javascript options for the autocomplete plugin
                                    'options'=>array(
                                        'minLength'=>'1',
                                    ),
                                    'htmlOptions'=>array(
                                        'class'=>'search-query',
                                        'placeholder'=>"Search",
                                        'autocomplete'=>'off',
                                    ),
                                ));   
                                ?>
                        </form>
                    </div>
                </div><!-- mainmenu -->
            </div>
        </div>
    </div>
<div class="container" style="padding-top: 50px;">

    <?php if(isset($this->breadcrumbs)):?>
        <ul class="breadcrumb">
        <?php 
            echo '<li>'.CHtml::link('Home',array('/site/index')) . '</li>';
            foreach($this->breadcrumbs as $index=>$crumbs){
                if($index=='0') echo '<span class="divider">/</span><li class="active">'.CHtml::encode($crumbs) . '</li>';
                else echo '<span class="divider">/</span><li>'.CHtml::link($index,$crumbs) . '</li>';
            }
        ?>
        </ul>
    <?php endif?>
    <?php echo $content; ?>
    <hr />      
    <div style="text-align: right;padding-right: 25px;">
        <?php echo CHtml::link('Stats',array('site/stats')); ?> | <?php echo CHtml::link('Documentation (wiki)','http://www.projectbuildr.de/wiki',array('target'=>'_BLANK')); ?> | <?php echo CHtml::link('imprint',array('site/imprint')); ?><br/>
    </div><!-- footer -->
</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/js/bootstrap.js"></script>
<?php $this->renderPartial('/layouts/analytics'); ?>
</body>
</html>
