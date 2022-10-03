<?php
session_start();
require("clases/conexion.php");

if (!isset($_SESSION['id'])) {
    header("Location: views/login.php");
} else {
    $usuario = $_SESSION['usuario'];
    $tipoUsuario = $_SESSION['tipo_rol'];
    $nombre_personal=$_SESSION['personal'];
    $nombre_rol=$_SESSION['nombre_rol'];

}

        
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema Farmacia</title>
  <link rel="icon" type="image/jpg" href="img/logo.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-closed sidebar-collapse">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="img/logo.png" alt="Software Bolivia" height="60" width="60">
  </div>

 <!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true">
            
                <b>Cargo:</b> <?php echo $nombre_rol; ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
      <!--  <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>-->

        
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" >
            <?php echo $usuario; ?> <i class="fas fa-user fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="navbarDropdown">
                <div class="dropdown-divider"></div>
                <a href="views/datosUsuario.php" class="dropdown-item">
                    <i class="fas fa-tools"></i> Configuracion
                </a>
                <div class="dropdown-divider"></div>
                <a href="views/logout.php" class="dropdown-item">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="img/logo.png" alt="Software Bolivia" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Software Bolivia</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/empleado.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          
          <p class="text-white"> <?php echo $nombre_personal; ?></p>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="index.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                
              </p>
            </a>
          </li>
          <?php    if($tipoUsuario == 1 || $tipoUsuario==2) { ?>   
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cash-register"></i>
              <p>
                Ventas
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" style="padding-left: 10px;">
                <a href="views/ventas.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nueva Venta</p>
                </a>
              </li>
              <?php } if($tipoUsuario == 1) { ?> 
              <li class="nav-item" style="padding-left: 10px;">
                <a href="views/EliminarVentas.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Eliminar Venta</p>
                </a>
              </li>
            </ul>
          </li>  
          
              

           
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Compras
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" style="padding-left: 10px;">
                <a href="views/compras.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nueva Compra</p>
                </a>
              </li>
              <li class="nav-item" style="padding-left: 10px;">
                <a href="views/EliminarCompras.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Eliminar Compra</p>
                </a>
              </li>
            </ul>
          </li>   
          <?php }?>
              
        
          <?php   if($tipoUsuario == 1) { ?>  
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-md"></i>
              <p>
                Empleados
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" style="padding-left: 10px;">
                <a href="views/empleado.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Empleados</p>
                </a>
              </li>
              <li class="nav-item" style="padding-left: 10px;"> 
                <a href="views/roles.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rol de Usuarios</p>
                </a>
              </li>
            </ul>
          </li>     
         
               

          <?php }   if($tipoUsuario == 1) { ?>  
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-pills"></i>
              <p>
                Productos
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item" style="padding-left: 10px;">
                <a href="views/productos.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Productos</p>
                </a>
              </li>
              <li class="nav-item" style="padding-left: 10px;">
                <a href="views/categorias.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Categoria</p>
                </a>
              </li>
                  <li class="nav-item">
                <a href="views/proveedor.php" class="nav-link">
                  <i class="nav-icon fas fa-truck"></i>
                  <p>
                  Proveedor
                  </p>
                </a>
              </li>    
              <li class="nav-item" style="padding-left: 10px;">
                <a href="views/laboratorios.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laboratorio</p>
                </a>
              </li>
              <li class="nav-item" style="padding-left: 10px;">
                <a href="views/presentacion.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Presentación</p>
                </a>
              </li>
            </ul>
          </li> 
        
               
          <?php }    if($tipoUsuario == 1) { ?>      
          <li class="nav-item">
            <a href="views/lote.php" class="nav-link">
              <i class="nav-icon fas fa-cubes"></i>
              <p>
                Gestión de Lotes               
              </p>
            </a>
          </li>
          <?php } ?>
  
          <li class="nav-item">
            <a href="views/kardex.php" class="nav-link">
              <i class="nav-icon fas fa-clipboard"></i>
              <p>
                Kardex
              </p>
            </a>
          </li>  

        
              

          <?php     if($tipoUsuario == 1) { ?>  
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-truck-loading"></i>
              <p>
                Inventarios
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" style="padding-left: 10px;">
                <a href="views/inventarioGeneral.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General</p>
                </a>
              </li>
              <li class="nav-item" style="padding-left: 10px;">
                <a href="views/inventarioFechaVencimiento.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fecha Vencimiento</p>
                </a>
              </li>
            </ul>
          </li>  
          <?php } ?>   
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Reportes
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" style="padding-left: 10px;">
                <a href="views/listaVentas.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Resumen Ventas</p>
                </a>
              </li>
              <li class="nav-item" style="padding-left: 10px;">
                <a href="views/ListaCompras.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Resumen Compras</p>
                </a>
              </li>
              <li class="nav-item" style="padding-left: 10px;">
                <a href="views/topProductos.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Top productos</p>
                </a>
              </li>
              <li class="nav-item" style="padding-left: 10px;">
                <a href="roles.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Productos sin rotación</p>
                </a>
              </li>
              <li class="nav-item" style="padding-left: 10px;">
                <a href="roles.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Top Clientes</p>
                </a>
              </li>
            </ul>
          </li>  
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Panel de Administración</h1>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


        <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-lg">
              <span class="info-box-icon bg-danger"><i class="fas fa-minus-circle"></i></span>
              <div class="info-box-content">
             
                 <span class="info-box-text"><h5>Productos Vencidos</h5></span>
                <span class="info-box-number" id="productosVencidos"></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>        
          <!-- ./col -->

          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-lg">
              <span class="info-box-icon bg-warning"><i class="fas fa-exclamation-triangle"></i></span>
              <div class="info-box-content">
               
                <span class="info-box-text"><h5>Por Vencer</h5></span>
                <span class="info-box-number" id="ProductosPorVencer"></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- ./col -->



          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-lg">
              <span class="info-box-icon bg-success"><i class="fas fa-percent"></i></span>
              <div class="info-box-content">           
    
                  <span class="info-box-text"><h5>Para promocionar</h5></span>
                  <span class="info-box-number" id="ProductoPromocion"></span>
             </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- ./col -->

          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-lg">
              <span class="info-box-icon bg-info"><i class="far fa-thumbs-up"></i></span>
              <div class="info-box-content">
      
                 <span class="info-box-text"><h5>Con buena fecha</h5></span>
                  <span class="info-box-number" id="ProductosBuenaFecha"></span>
             </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

        <br>
         <!-- Main row -->
        <div class="row" sytyle="padding-top=100px;">
          <!-- Left col -->
          <section class="col-lg-8 col-md-12 connectedSortable">
            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title"><b>Alerta de lotes proximos a vencer</b> - Alertar desde los <?php  echo $dia3 ?> dias.</h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table id="ejemplo1" class="table table-striped table-valign-middle">
                  
                              
                </table>   
              </div>
            </div>
          </section>
          <!-- /.Left col -->   

           <!-- Left col -->
           <section class="col-lg-4 col-md-12 connectedSortable">
            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title"><b>Tabla Alertas de Vencimientos</b></h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table id="ejemplo" class="table table-striped table-valign-middle">
                           
                </table>   
              </div>
            </div>
          </section>
          <!-- /.Left col -->   
        </div>
        <!-- /.row (main row) -->
           
        
      </div><!-- /.container-fluid -->
    </section>
<!-- ./wrapper -->
</div>
  

   
 

       <!-- Modal editar producto --> 
       <div class="modal fade" id="modalEditarAlertas">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-edit"></i>  Editar Alerta</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="formEditarAlerta" class="row g-3">
              <div class="col-md-6">
                    <label for="inputName" class="form-label"><b>Nombre Alerta</b></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-file"></i></span>
                        </div>
                        <input type="text" class="form-control" id="nombreAlerta" placeholder="Ingresar Alerta">
                    </div>                 
                  </div>  
                  <div class="col-md-6">
                    <label for="inputName" class="form-label"><b>Dias para alertar</b></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                        </div>
                        <input type="text" class="form-control" id="diasAlerta" placeholder="Ingresar Dias">
                    </div>                 
                  </div>  
                  <div class="col-md-6">
                    <input type="hidden" id="id">
                  </div>
              </form>
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="editarAlerta()">Actualizar Alerta</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->



<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>

<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
