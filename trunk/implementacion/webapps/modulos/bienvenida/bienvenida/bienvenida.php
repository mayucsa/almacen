<?php
    include_once "../../superior.php";
    include_once "../../../dbconexion/conexion.php";  
?>
         <head>Bienvenida</title>

            <link rel="stylesheet" type="text/css" href="../../../includes/css/adminlte.min.css">
            <link rel="stylesheet" href="../../../includes/css/data_tables_css/jquery.dataTables.min.css">
            <link rel="stylesheet" href="../../../includes/css/data_tables_css/buttons.dataTables.min.css">


        </head>
    <main class="app-content">
        <div class="app-title">
            <div>
              <h1><i class="fas fa-boxes"></i> Bienvenida</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
              <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
              <li class="breadcrumb-item"><a href="bienvenida.php">Bienvenida</a></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="img">
                                <img class="rounded mx-auto d-block" src="../../../includes/imagenes/juntos2.png">
                            </div>
                            <div class="col-md-12 text-center mt-5 mb-5">
                                <h1> Bienvenido(a) <?php echo $nombre." ".$apellido?> a nuestra Sistema de Almacén (SAM) <h1>
                            </div>
                            <div class="col-md-12 text-center mt-5 mb-5">
                                <!-- <p> <strong>Dashboard</strong> para brindarle un mejor servicio. Si lo necesita siempre puede contactarnos de los contrario en los siguientes días podra visualizar el modulo <strong>Dashboard</strong></p> -->
                                <p>&mdash; SAM &mdash;</p>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>


        <?php include_once "../../footer.php" ?>

    </main>
<script src="../../../includes/js/adminlte.min.js"></script>

<?php include_once "../../inferior.php" ?>

    <!-- <script src="inventario.js"></script> -->

    <script src="../../../includes/js/jquery331.min.js"></script>

    <script src="../../../includes/js/sweetalert2.min.js"></script>

<!-- <script type="text/javascript">
    consultarProducto();
</script> -->

    <script src="../../../includes/bootstrap/js/bootstrap.js"></script>

    <script src="../../../includes/bootstrap/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../../../includes/css/datatables.min.css"/>

    <script type="text/javascript" src="../../../includes/js/datatables.min.js"></script>

    <script src="../../../includes/js/data_tables_js/jquery.dataTables.min.js"></script>
    <script src="../../../includes/js/data_tables_js/dataTables.buttons.min.js"></script>
    <script src="../../../includes/js/data_tables_js/jszip.min.js"></script>
    <script src="../../../includes/js/data_tables_js/pdfmake.min.js"></script>
    <script src="../../../includes/js/data_tables_js/vfs_fonts.js"></script>
    <script src="../../../includes/js/data_tables_js/buttons.html5.min.js"></script>
    <script src="../../../includes/js/data_tables_js/buttons.print.min.js"></script>