<?php
session_start();
  if(!isset($_SESSION['login']))
  {
    //header("location:index.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="">

    <title>Sistema de Administracion de Talento</title>
    <link href="css/normalize.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-custom.css">
    <link rel="stylesheet" href="css/ui/base/jquery.ui.all.css">
    <link rel="stylesheet" type="text/css" href="css/datepicker/datepicker.css">
    <link href='css/fullcalendar.css' rel='stylesheet' />
     <script src="js/jquery.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    <script src="js/pace.min.js"></script>
  <link href="css/themes/pace-theme-barber-shop.css" rel="stylesheet" />
  </head>

  <body>

    

    <div class="container-fluid">
      <div class="row">
        <div id="navBarTop" class="navbar navbar-default navbar-fixed-top col-sm-9 col-md-10 col-sm-offset-2"  role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Sistema de Administracion de Talento</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right" style="font-size:16px">
                <li><a href="#"><i class="glyphicon glyphicon-comment"></i></a></li>
                <li><a href="#"><i class="glyphicon glyphicon-cog"></i></a></li>
                <li><a href="induccion.php"><i class="glyphicon glyphicon-log-out"></i></a></li>
            </ul>
        </div>
      </div>
    </div>
        <div class="col-sm-3 col-md-2 sidebar  full-sidebar">
          <ul class="nav nav-sidebar">
            <li id="dashboard" data-service='' class="active" data-table="busquedacandidato"><a href="dashboard.php">Dashboard</a></li>         
            <li id="candidato" data-service='11' data-table="busquedacandidato"><a href="candidato.php">Candidato</a></li>         
          </ul>
        </div>
        
        
        	