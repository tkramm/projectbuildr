<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<div class="row-fluid">
    <div class="span6">
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <span class="brand" style="font-weight:bold;">New User</span>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div class="nav-collapse collapse">
                    <!-- .nav, .navbar-search, .navbar-form, etc -->
                </div>

                </div>
            </div>
        </div>
        <div class="alert alert-notice">
            <a class="close" data-dismiss="alert" href="#">×</a>
            Fields with <span class="required">*</span> are required.
        </div>
        <div class="well">
            <?php $this->renderPartial('_registerForm',array('model'=>$register)); ?>
        </div>
    </div>
    <div class="span6">
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <span class="brand" style="font-weight:bold;">Login</span>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div class="nav-collapse collapse">
                    <!-- .nav, .navbar-search, .navbar-form, etc -->
                </div>

                </div>
            </div>
        </div>
        <div class="alert alert-info">
            <a class="close" data-dismiss="alert" href="#">×</a>
            Please fill out the following form with your login credentials:
        </div>
        <div class="well">
            <?php $this->renderPartial('_loginForm',array('model'=>$login)); ?>
        </div>
    </div>
</div>