<?php   
session_start();
set_time_limit(0); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Mayucsa - Materiales de Yucatan">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Ing. Alfredo Fidel Chan Chuc">
    <link rel="icon" href="../../../includes/imagenes/favicon.png">
    <!-- <meta name="theme-color" content="E5CA00"> -->
    <title>Almac&eacute;n</title>

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="../../../includees/css/main.css">

    <script src="../../../includes/js/jquery351.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
    <!-- <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>  -->
    <script src="../../../includes/js/popper.js"></script>
    <script src="../../../includes/js/popper.min.js"></script>
    <script src="../../../includes/bootstrap/js/bootstrap.js"></script>
    <script src="../../../includes/bootstrap/js/bootstrap.min.js"></script>
    <!-- <link rel="stylesheet" type="text/css" href="../../../includes/bootstrap/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="../../../includes/css/alertify.min.css"/>
    <link rel="stylesheet" href="../../../includes/css/default.min.css"/>
    <link rel="stylesheet" href="../../../includes/css/font.css" >
    <!-- Angular JS -->
    <script type="text/javascript" src="../../../includes/js/angular.js"></script>
    <script type="text/javascript" src="../../../includes/js/angularinit.js"></script>
    <script type="text/javascript" src="../../../includes/js/isloading.js"></script>
    <!-- fin Angular JS -->
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="../../../includes/js/fontawesome.js"></script>

      <!-- ============================================================
    =ESTILOS PARA USO DE DATATABLES JS
    ===============================================================-->
<!--     <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css"> -->

    <style>
      #WindowLoad{
        position:fixed;
        top:0px;
        left:0px;
        z-index:3200;
        filter:alpha(opacity=65);
       -moz-opacity:65;
        opacity:0.65;
        background:#999;
      }
    </style>
  </head>

<!-- MODAL CERRAR SESION -->
<!--     <div class="modal modal-danger fade in" id="simpleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: block;">
      <div class="modal-dialog" style="margin-top: undefinedpx !important">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reacomodaBody()"><span aria-hidden="true">×</span></button>
            <h5 class="modal-title"><span class="glyphicon glyphicon-floppy-remove"></span>&nbsp;&nbsp;<span class="title-modal">¡Advertencia¡</span></h5>
          </div>
          <div class="modal-body"><p>¿Estás seguro que deseas cerrar sesión?</p>
          </div>
          <div class="modal-footer bg-contenido-footer"><button type="button" class="btn btn-success btn-sm" data-dismiss="modal" onclick="setTimeout(function(){cerrarSesion()},400)"><span class="glyphicon glyphicon-saved"></span>&nbsp;Aceptar</button>
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="reacomodaBody()"><span class="glyphicon glyphicon-remove"></span>&nbsp;Cancelar</button>
          </div>
        </div>
      </div>
    </div> -->

  <body class="app sidebar-mini">
    <!-- inicio div controller de angular -->
    <div ng-app="Mayucsa" class="ng-cloak" ng-controller="AngularCtrler">
      <!-- Navbar-->
      <header class="app-header"><a class="app-header__logo" href="#">Almac&eacute;n</a>
        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
        <!-- Navbar Right Menu-->
        <ul class="app-nav">
        <!-- <div class="date">
            <span id="weekDay" class="weekDay"></span>, 
            <span id="day" class="day"></span> de
            <span id="month" class="month"></span> del
            <span id="year" class="year"></span>,
        </div>
        <div class="clock">
            <span id="hours" class="hours"></span> :
            <span id="minutes" class="minutes"></span> :
            <span id="seconds" class="seconds"></span>
        </div> -->
          <!-- User Menu-->
          <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>

            <ul class="dropdown-menu settings-menu dropdown-menu-right">
              <!-- <li><a class="dropdown-item" href="page-user.html"><i class="fa fa-cog fa-lg"></i> Settings</a></li> -->
              <!-- <li><a class="dropdown-item" href="../../password/vista_password.php"><i class="fa fa-user fa-lg" style="font-size:12px"></i>Cambiar contraseña</a></li> -->
              <li><a class="dropdown-item" href="../../logout.php">
                    <i class="fa fa-sign-out fa-lg"></i><font>Cerrar Sesi&oacute;n</font>
                  </a>
              </li>
            </ul>
          </li>
        </ul>
      </header>
      <?php include_once "navbar.php" ?>
      <script>
          app.value("BASEURL", "<?= $_SERVER["HTTP_HOST"]?>/");
          app.value("ID", "<?= $id?>");
      </script>
    