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
        $id  = $objeto->clave_usuario;

        $vista_dashboardalma  = $objeto->vista_dashboardalma;

        $vista_catalogo  = $objeto->vista_catalogo;

        $vista_movimiento  = $objeto->vista_movimiento;

        $vista_autorizacion  = $objeto->vista_autorizacion;

        $vista_seguridad  = $objeto->vista_seguridad;
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

        $catalogo = '';
        $catalogo .= '
          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-folder-open"></i><span class="app-menu__label">Catalogos</span><i class="treeview-indicator fas fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li><a class="treeview-item" href="../../catalogo/categorias/vista_categorias.php"><i class="icon fa fa-circle-o"></i> Almacenes</a></li>

              <li><a class="treeview-item" href="../../catalogo/grupos/vista_grupos.php"><i class="icon fa fa-circle-o"></i> Grupos</a></li>

              <li><a class="treeview-item" href="../../catalogo/articulos/vista_articulos.php"><i class="icon fa fa-circle-o"></i> Articulos</a></li>

              <li><a class="treeview-item" href="../../catalogo/proveedores/vista_proveedores.php"><i class="icon fa fa-circle-o"></i> Proveedores</a></li>

              <li><a class="treeview-item" href="../../catalogo/areas/vista_areas.php"><i class="icon fa fa-circle-o"></i> Áreas</a></li>

              <li><a class="treeview-item" href="../../catalogo/departamentos/vista_departamentos.php"><i class="icon fa fa-circle-o"></i> Departamentos</a></li>

              <li><a class="treeview-item" href="../../catalogo/maquinas/vista_maquinas.php"><i class="icon fa fa-circle-o"></i> Máquinas</a></li>

              <li><a class="treeview-item" href="../../catalogo/centrocostos/vista_centrocostos.php"><i class="icon fa fa-circle-o"></i> Centro de costos</a></li>
            </ul>
          </li>';


        $movimientos = '';
        $movimientos .= '
          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-pen-square"></i><span class="app-menu__label">Movimientos</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li><a class="treeview-item" href="../../movimientos/requisicion/vista_requisicion.php"><i class="icon fa fa-circle-o"></i> Requisiciones</a></li>

              <li><a class="treeview-item" href="../../movimientos/cotizacion/vista_cotizacion.php"><i class="icon fa fa-circle-o"></i> Cotización</a></li>
            
              <li><a class="treeview-item" href="../../morteros/entradas/vista_entradas.php"><i class="icon fa fa-circle-o"></i> Orden de compra</a></li>
            
              <li><a class="treeview-item" href="../../morteros/salidas/vista_salidas.php"><i class="icon fa fa-circle-o"></i> Entradas</a></li>

              <li><a class="treeview-item" href="../../morteros/seguridad/vista_seguridad.php"><i class="icon fa fa-circle-o"></i> Salidas</a></li>
            </ul>
          </li>';

        $autorizacion = '';
        $autorizacion .= '
          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-check-circle"></i><span class="app-menu__label">Autorización</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li><a class="treeview-item" href="../../laboratorio/captura/vista_laboratorio.php"><i class="icon fa fa-circle-o"></i> Requisiciones</a></li>
            
              <li><a class="treeview-item" href="../../laboratorio/entradas/vista_entradas.php"><i class="icon fa fa-circle-o"></i> Servicios</a></li>
            </ul>
          </li>';

        $seguridad = '';
        $seguridad .= '
          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-key"></i><span class="app-menu__label">Seguridad</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
            <li><a class="treeview-item" href="../../besser/captura/vista_besser.php"><i class="icon fa fa-circle-o"></i> Producción</a></li>
            
              <li><a class="treeview-item" href="../../besser/curado/vista_curado.php""><i class="icon fa fa-circle-o"></i> Cuarto Curado</a></li>

              <li><a class="treeview-item" href="../../besser/entradas/vista_entradas.php"><i class="icon fa fa-circle-o"></i> Entradas</a></li>
            
              <li><a class="treeview-item" href="../../besser/desalojo/vista_desalojo.php"><i class="icon fa fa-circle-o"></i> Desalojos</a></li>
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
          <li><a class="app-menu__item" href="../../../logout.php"><i class="app-menu__icon fas fa-sign-out-alt"></i><span class="app-menu__label">Cerrar sesi&oacute;n</span></a>
          </li>';

          echo $padre;

          if ($vista_dashboardalma == 1) {
            echo $dashboard;
          }
          if ($vista_catalogo == 1) {
            echo $catalogo;
          }
          if ($vista_movimiento == 1) {
            echo $movimientos;
          }
          if ($vista_autorizacion == 1) {
            echo $autorizacion;
          }
          if ($vista_seguridad == 1) {
            echo $seguridad;
          }


          echo $misdatos.$cierresesion.$hijo;

      // switch ($clave){
      //   case 1:
      //     echo $padre.$dashboard.$inventario.$morteros.$laboratorio.$besser.$vibro.$almacenistas.$reportes.$usuarios.$misdatos.$cierresesion.$hijo;
      //     break;

      //   case 2:
      //     echo $padre.$dashboard.$inventario.$morteros.$laboratorio.$besser.$vibro.$almacenistas.$reportes.$cierresesion.$hijo;
      //     break;

      //   case 3:
      //     echo $padre.$dashboard.$inventario.$cierresesion.$hijo;
      //     break;

      //   case 4:
      //     echo $padre.$dashboard.$inventario.$morteros.$laboratorio.$besser.$vibro.$almacenistas.$cierresesion.$hijo;
      //     break;

      //   case 5:
      //     echo $padre.$dashboard.$inventario.$morteros.$cierresesion.$hijo;
      //     break;

      //   case 6:
      //     echo $padre.$inventario.$morteros.$cierresesion.$hijo;
      //     break;

      //   case 7:
      //     echo $padre.$dashboard.$inventario.$besser.$vibro.$almacenistas.$cierresesion.$hijo;
      //     break;

      //   case 8:
      //     echo $padre.$inventario.$besser.$cierresesion.$hijo;
      //     break;
      //   case 9:
      //     echo $padre.$inventario.$vibro.$cierresesion.$hijo;
      //     break;

      //   case 10:
      //     echo $padre.$inventario.$almacenistas.$cierresesion.$hijo;
      //     break;

      //   case 11:
      //     echo $padre.$inventario.$laboratorio.$cierresesion.$hijo;
      //     break;

      //   case 12:
      //     echo $padre.$inventario.$laboratorio.$cierresesion.$hijo;
      //     break;
      //   case 13:
      //     echo $padre.$inventario.$cierresesion.$hijo;
      //     break;
      //   case 14:
      //     echo $padre.$reportes.$cierresesion.$hijo;
      //     break;
      //   case 15:
      //     echo $padre.$dashboard.$inventario.$morteros.$besser.$vibro.$almacenistas.$cierresesion.$hijo;
      //     break;
      // }
      ?>

    </aside>
    <?php 
  }
     ?>