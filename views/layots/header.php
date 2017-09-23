<?php
/**
 * Created by PhpStorm.
 * User: kholmatov
 * Date: 11/09/2017
 * Time: 17:33
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?=$this->title?></title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">

<link href="<?=$this->widgetURL()?>assets/them/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=$this->widgetURL()?>assets/them/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="<?=$this->widgetURL()?>assets/them/css/font-awesome.css" rel="stylesheet">
<link href="<?=$this->widgetURL()?>assets/them/css/style.css" rel="stylesheet">
<link href="<?=$this->widgetURL()?>assets/them/css/pages/dashboard.css" rel="stylesheet">
<script src="<?=$this->widgetURL()?>assets/them/js/jquery-1.7.2.min.js"></script>
<script src="<?=$this->widgetURL()?>assets/them/js/bootstrap.js"></script>
<script src="<?=$this->widgetURL()?>assets/them/js/bootbox.min.js"></script>
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>

<body>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a>
            <a class="brand" href="<?=$this->widgetURL()?>">Tasks</a>
            <div class="nav-collapse">
                <ul class="nav pull-right">
                    <li class="dropdown">
                       <?= $this->loginUrl() ?>
                    </li>
                </ul>
                <!--                    <form class="navbar-search pull-right">-->
                <!--                        <input type="text" class="search-query" placeholder="Search">-->
                <!--                    </form>-->
            </div>
            <!--/.nav-collapse -->
        </div>
        <!-- /container -->
    </div>
    <!-- /navbar-inner -->
</div>
<!-- /navbar -->




<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container">

            <?php


            ?>
        </div>
        <!-- /container -->
    </div>
    <!-- /subnavbar-inner -->
</div>
<!-- /subnavbar -->


<div class="main">
    <div class="main-inner">
        <div class="container">

