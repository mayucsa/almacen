<?php 
    include_once "../../../modulos/seguridad/login/datos_usuario.php";

    if (empty($_SESSION['usuario'])) {
        $type = "error";
        $detalle = "Sesi&oacute;n terminada.";
        $detalle .= "<ul><li>La sesi&oacute;n de usuario ha finalizado.</li>";
        $detalle .= "<li>Inicie sesi&oacute;n para acceder al sistema.</li></ul>";
        $url_continuar = "index.php";
        $br = "<br/><br/><br/><br/><br/><br/><br/><br/><br/>";
        include_once "../../../mensajes/message.php";
        exit();
    }else{
        $objeto = unserialize($_SESSION['usuario']);
        $nombre = $objeto->nombre_persona;
        $apellido = $objeto->apellido_persona;
        $puesto = $objeto->puesto_persona;
        $clave  = $objeto->rol_persona;
        $vista_mortero  = $objeto->vista_morteros;
        $captura_mortero  = $objeto->captura_morteros;
        $edit_mortero  = $objeto->edit_morteros;
        $delete_mortero  = $objeto->delete_morteros;
 ?>
<!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <!-- <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="../../../includes/imagenes/team_users.png" alt="User Image"> -->
        <!-- <div class="pull-left image"> -->
                <!-- <img src="../../../includes/imagenes/team_users.png" class="img-circle"> -->
        <!-- </div> -->
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar">
        <div>
          <p class="app-sidebar__user-name"><?php echo $nombre." ".$apellido?></p>
          <p class="app-sidebar__user-designation"><?php echo $puesto?></p>
        </div>
      </div>
    <!-- </div> -->
      <?php
        $padre = '';
        $padre .= '<ul class="app-menu">';

        $hijo = '';
        $hijo .= '</ul>';

        $dashboard = '';
        $dashboard .= '
        <li>
            <a class="app-menu__item" href="../../dashboard/dashboard/dashboard.php"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a>
        </li>';

        $inventario = '';
        $inventario .= '
          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-people-carry"></i><span class="app-menu__label">Inventario</span><i class="treeview-indicator fas fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li><a class="treeview-item" href="../../inventario/morteros/inventario_morteros.php"><i class="icon fa fa-circle-o"></i> Morteros</a></li>

              <li><a class="treeview-item" href="../../inventario/bloquera/inventario_bloquera.php"><i class="icon fa fa-circle-o"></i> Bloquera</a></li>

            </ul>
          </li>';

        $inventarioPadre = '';
        $inventarioPadre .= '
          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-people-carry"></i><span class="app-menu__label">Inventario</span><i class="treeview-indicator fas fa-angle-right"></i></a>
            <ul class="treeview-menu">';
        $inventarioM = '';
        $inventarioM .= '<li><a class="treeview-item" href="../../inventario/morteros/inventario_morteros.php"><i class="icon fa fa-circle-o"></i> Morteros</a></li>';

        $inventarioB = '';
        $inventarioB .= '<li><a class="treeview-item" href="../../inventario/bloquera/inventario_bloquera.php"><i class="icon fa fa-circle-o"></i> Bloquera</a></li>';

        $inventarioHijo = '';
        $inventarioHijo .= '
          </ul>
        </li>';


        $morteros = '';
        $morteros .= '
          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-box"></i><span class="app-menu__label">Morteros</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li><a class="treeview-item" href="../../morteros/inventario/vista_inventario.php"><i class="icon fa fa-circle-o"></i> Inventario</a></li>

              <li><a class="treeview-item" href="../../morteros/captura/vista_captura.php"><i class="icon fa fa-circle-o"></i> Producción</a></li>
            
              <li><a class="treeview-item" href="../../morteros/entradas/vista_entradas.php"><i class="icon fa fa-circle-o"></i> Entradas</a></li>
            
              <li><a class="treeview-item" href="../../morteros/salidas/vista_salidas.php"><i class="icon fa fa-circle-o"></i> Salidas</a></li>
            </ul>
          </li>';

        $laboratorio = '';
        $laboratorio .= '
          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-flask"></i><span class="app-menu__label">Laboratorio</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li><a class="treeview-item" href="../../laboratorio/captura/vista_laboratorio.php"><i class="icon fa fa-circle-o"></i> Captura</a></li>
            
              <li><a class="treeview-item" href="../../laboratorio/entradas/vista_entradas.php"><i class="icon fa fa-circle-o"></i> Entradas</a></li>
            
              <li><a class="treeview-item" href="../../laboratorio/movimientos/vista_movimientos.php"><i class="icon fa fa-circle-o"></i> Movimientos</a></li>
            
              <li><a class="treeview-item" href="../../laboratorio/produccion/vista_produccion.php"><i class="icon fa fa-circle-o"></i> Producción</a></li>
            </ul>
          </li>';

        $besser = '';
        $besser .= '
          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-cubes"></i><span class="app-menu__label">Besser</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
            <li><a class="treeview-item" href="../../besser/captura/vista_besser.php"><i class="icon fa fa-circle-o"></i> Producción</a></li>
            
              <li><a class="treeview-item" href="../../besser/curado/vista_curado.php""><i class="icon fa fa-circle-o"></i> Cuarto Curado</a></li>

              <li><a class="treeview-item" href="../../besser/entradas/vista_entradas.php"><i class="icon fa fa-circle-o"></i> Entradas</a></li>
            
              <li><a class="treeview-item" href="../../besser/desalojo/vista_desalojo.php"><i class="icon fa fa-circle-o"></i> Desalojos</a></li>
            </ul>
          </li>';

        $vibro = '';
        $vibro .= '
          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-cubes"></i><span class="app-menu__label">VibroBlock</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li><a class="treeview-item" href="../../vibro/captura/vista_vibro.php"><i class="icon fa fa-circle-o"></i> Producción</a></li>
            
              <li><a class="treeview-item" href="../../vibro/curado/vista_curado.php"><i class="icon fa fa-circle-o"></i> Cuartos Curado</a></li>

              <li><a class="treeview-item" href="../../vibro/entradas/vista_entradas.php"><i class="icon fa fa-circle-o"></i> Entradas</a></li>
            
              <li><a class="treeview-item" href="../../vibro/desalojo/vista_desalojo.php"><i class="icon fa fa-circle-o"></i> Desalojos</a></li>
            </ul>
          </li>';

        $almacenistas = '';
        $almacenistas .= '
          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-user"></i><span class="app-menu__label">Almacenistas</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li><a class="treeview-item" href="../../almacenistas/inventario/inventario_bloquera.php"><i class="icon fa fa-circle-o"></i> Inventario</a></li>

              <li><a class="treeview-item" href="../../almacenistas/confirmacion/vista_confirmacion.php"><i class="icon fa fa-circle-o"></i> Desalojos</a></li>

              <li><a class="treeview-item" href="../../almacenistas/salidas/vista_salidas.php"><i class="icon fa fa-circle-o"></i> Salidas</a></li>
            </ul>
          </li>';

        $reportes = '';
        $reportes .= '
          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-chart-pie"></i><span class="app-menu__label">Reportes</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li><a class="treeview-item" href="../../reportes/saqueria/vista_saqueria.php"><i class="icon fa fa-circle-o"></i> Sacos usados</a></li>
            </ul>
          </li>';

        $usuarios = '';
        $usuarios .= '
          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-users"></i><span class="app-menu__label">Usuarios</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li><a class="treeview-item" href="../../usuarios/usuarios/vista_usuario.php"><i class="icon fa fa-circle-o"></i> Usuarios</a></li>
            
              <li><a class="treeview-item" href="../../usuarios/roles/vista_rol.php"><i class="icon fa fa-circle-o"></i> Roles</a></li>
            
              <li><a class="treeview-item" href=""><i class="icon fa fa-circle-o"></i> Permisos</a></li>
            </ul>
          </li>';

        $misdatos = '';
        $misdatos .= '
          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-user-cog"></i><span class="app-menu__label">Mis datos</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li><a class="treeview-item" href="../../misdatos/cambiopassword/vista_password.php"><i class="icon fa fa-circle-o"></i> Cambio de contraseña</a></li>
            </ul>
          </li>';

        $cierresesion = '';
        $cierresesion .= '
          <li><a class="app-menu__item" href="../../../logout.php"><i class="app-menu__icon fas fa-sign-out-alt"></i><span class="app-menu__label">Cerrar sesi&oacute;n</span></a></li>';

      switch ($clave){
        case 1:
          echo $padre.$dashboard.$inventario.$morteros.$laboratorio.$besser.$vibro.$almacenistas.$reportes.$usuarios.$misdatos.$cierresesion.$hijo;
          break;

        case 2:
          echo $padre.$dashboard.$inventario.$morteros.$laboratorio.$besser.$vibro.$almacenistas.$reportes.$cierresesion.$hijo;
          break;

        case 3:
          echo $padre.$dashboard.$inventario.$cierresesion.$hijo;
          break;

        case 4:
          echo $padre.$dashboard.$inventario.$morteros.$laboratorio.$besser.$vibro.$almacenistas.$cierresesion.$hijo;
          break;

        case 5:
          echo $padre.$dashboard.$inventario.$morteros.$cierresesion.$hijo;
          break;

        case 6:
          echo $padre.$inventario.$morteros.$cierresesion.$hijo;
          break;

        case 7:
          echo $padre.$dashboard.$inventario.$besser.$vibro.$almacenistas.$cierresesion.$hijo;
          break;

        case 8:
          echo $padre.$inventario.$besser.$cierresesion.$hijo;
          break;
        case 9:
          echo $padre.$inventario.$vibro.$cierresesion.$hijo;
          break;

        case 10:
          echo $padre.$inventario.$almacenistas.$cierresesion.$hijo;
          break;

        case 11:
          echo $padre.$inventario.$laboratorio.$cierresesion.$hijo;
          break;

        case 12:
          echo $padre.$inventario.$laboratorio.$cierresesion.$hijo;
          break;
        case 13:
          echo $padre.$inventario.$cierresesion.$hijo;
          break;
        case 14:
          echo $padre.$reportes.$cierresesion.$hijo;
          break;
        case 15:
          echo $padre.$dashboard.$inventario.$morteros.$besser.$vibro.$almacenistas.$cierresesion.$hijo;
          break;
      }?>

    </aside>
    <?php 
  }
     ?>