<?php
session_start();
include '../clases/conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
} else {
    $id = $_SESSION['id'];
    $usuario = $_SESSION['usuario'];
}


$sql = "SELECT p.nombre,p.unidad,sum(vp.cantidad) as cantidad,sum(vp.subtotal) as total FROM ventaproducto as vp 
        left join lote as l on l.id = vp.idLote
        LEFT join producto as p on p.id = l.idProducto
        left join venta as v on v.id = vp.idVenta     
        where v.estado = 'Habilitado'
        group by p.nombre,p.unidad
         order by cantidad desc ";
$resultado = mysqli_query($conectar, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Productos mas vendidos</title>
  <link rel="icon" type="image/jpg" href="../img/logo.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
   <!-- DataTables -->
   <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
   <!-- SweetAlert2 -->
   <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-closed sidebar-collapse">
<div class="wrapper">

    <?php  
        require "Navegador.php";
    ?>

    <?php  
        require "Menus.php";
    ?>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Resumen de productos mas vendidos</h1>
            </div><!-- /.col
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div> /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        </div>

        
        <section class="content">
          <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
              <div class="info-box shadow-lg">
                <span class="info-box-icon bg-success"><i class="fas fa-capsules"></i></span>
                <div class="info-box-content">
                
                  <span class="info-box-text"><h5>Producto Vendidos</h5></span>
                  <span class="info-box-number" id="ProductosVendidos"></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- ./col -->

            <div class="col-md-4 col-sm-6 col-12">
              <div class="info-box shadow-lg">
                <span class="info-box-icon bg-info"><i class="fas fa-cash-register"></i></span>
                <div class="info-box-content">
                
                  <span class="info-box-text"><h5>Total Ingresos en Bs</h5></span>
                  <span class="info-box-number" id="TotalIngresos"></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- ./col -->

            <div class="col-md-4 col-sm-6 col-12">
              <div class="info-box shadow-lg">
                <span class="info-box-icon bg-secondary"><i class="fas fa-user-alt"></i></span>
                <div class="info-box-content">
                
                  <span class="info-box-text"><h5>Total Ventas Usuario</h5></span>
                  <span class="info-box-number" id="VentasUsuario"></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- ./col -->
          </div>  
        </section>

    
        <section class="col-lg-12 col-md-12"> 
            <div class="card">
              <div class="card-body">
                <div role="tabpanel">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a href="#" class="nav-link" onclick="mostrarDiv('seccion1')">Resumen General</a>
                        </li>
                        <li class="nav-item">
                            <a href="#"  class="nav-link" onclick="mostrarDiv('seccion2')">Resumen por Mes</a>
                        </li>                 
                    </ul>
                </div>
               
                    <div  class="tab-pane" style="margin-top:15px;" id="seccion1">
                        <form role="form" method="post">
                          <div class="col-md-12 text-center">
                            <label for=""><h4><b>Resumen General</b></h4></label>
                          </div>                         
                        </form>
                        <div class="table-responsive">
                          <table id="example1" class="table table-bordered table-striped">
                              <thead >
                              <tr>
                                  <th>#</th>
                                  <th>Nombre Producto</th>
                                  <th>Medida</th>
                                  <th>Cantidad Vendida</th>
                                  <th>Total Vendido</th>
                              </tr>
                              </thead>
                              <tbody>
                                  <?php $cont = 0; 
                                  while ($row = $resultado->fetch_assoc()) { ?>
                                      <tr>
                                          <?php  $cont++?>
                                      <td><?php echo $cont; ?></td>
                                      <td><?php echo $row['nombre']; ?></td>
                                      <td><?php echo $row['unidad']; ?></td>
                                      <td><?php echo $row['cantidad']; ?></td>   
                                      <td>Bs. <?php echo $row['total']; ?></td>                          
                                      </tr>
                                  <?php } ?>                 
                              </tfooter>
                          </table>
                        </div>
                  </div>

                    <div class="tab-pane" style="margin-top:15px;" id="seccion2">
                      <form role="form" method="post">
                          <div class="box-body">
                            <div class="form-horizontal">  
                              <div class="row text-center">
                                <div class="col-md-12">
                                  <label for=""><h4><b>Resumen por Mes - Top 10 de producto</b></h4></label>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group">                             
                                    <select class="form-control select2" id="Mes" style="width: 100%;">
                                        <option selected="selected" disabled>Seleccionar Mes...</option>
                                        <option value="1">Enero</option>
                                        <option value="2">Febrero</option>
                                        <option value="3">Marzo</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Mayo</option>
                                        <option value="6">Junio</option>
                                        <option value="7">Julio</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Noviembre</option>
                                        <option value="12">Diciembre</option>
                                    </select>
                                  </div>
                                </div>      
                                <div class="col-md-5">
                                  <div class="d-grid gap-2 d-md-flex">
                                    <button type="button" class="btn btn-primary" onclick="MostrarTopProductos()"><i class="fas fa-filter"></i> Mostrar</button>                               
                                  </div>
                                </div>                            
                              </div>  
                            </div>   
                          </div>         
                      </form>
                        <div id="contenerdor_tabla" class="table-responsive" style="padding-top: 20px;">
                          <table id="example2" class="table table-bordered table-striped">
                              <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Producto</th>
                                  <th>Medida</th>
                                  <th>Cantidad</th>
                                  <th>Total</th>
                              </tr>
                              </thead>
                              <tbody>
                                          
                              </tfooter>
                          </table>
                        </div>
                    </div>
                
              </div>
              <!-- /.card-body -->
            </div>
        </section>
   
   
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <?php $año = date('Y'); ?>
                        <div><h6><strong>Copyright &copy; Software Bolivia <?php echo $año ?></strong> 
                          Todos los derechos reservados.</h6>
                        </div>
                        <div class="float-right d-none d-sm-inline-block">
                          <h6><b>Version</b> 1.0</h6> 
                        </div>
                    </div>
                </div>
            </footer> 
   

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
</div>
<!-- ./wrapper -->



  <script>



      function totalIngresos(mes){
        $.ajax({
        url: '../clases/Cl_TopProductos.php?op=TotalIngresos',
        type: 'POST', 
        data: {
          mes: mes
        },
        success: function(data) {
                if(data == "error"){                       
                  Swal.fire("Oops..!", "Error al cargar el total de ingresos", "warning");    
                }
                else {
                  if(data == ""){
                    $("#TotalIngresos").html("<h4> Bs. 0.00</h4>");        
                  }
                  else{
                    $("#TotalIngresos").html("<h4> Bs. "+data+"</h4>");        
                  }
                                      
                }                 
            }          
        })    
      }

      function ventasUsuario(mes){
      
        $.ajax({
        url: '../clases/Cl_TopProductos.php?op=VentasPorUsuario',
        type: 'POST', 
        data: {
          mes:mes
        },
        success: function(data) {
                if(data == "error"){                       
                  Swal.fire("Oops..!", "Error al cargar las ventas por usuario", "warning");    
                }
                else {
                  if(data == ""){
                        $("#VentasUsuario").html("<h4> 0</h4>");
                  }
                  else{
                    $("#VentasUsuario").html("<h4>"+data+"</h4>");
                  }
                        
                }                 
            }          
        })    
      }

      function ProductosVendidos(mes){

        $.ajax({
        url: '../clases/Cl_TopProductos.php?op=ProductoVendidos',
        type: 'POST', 
        data: {
          mes:mes
        },
        success: function(data) {
                if(data == "error"){                       
                  Swal.fire("Oops..!", "Error al cargar los productos vendidos", "warning");    
                }
                else {
                  if(data == ""){
                        $("#ProductosVendidos").html("<h4> 0</h4>");                      
                  }
                  else{
                    $("#ProductosVendidos").html("<h4>"+data+"</h4>");      
                  }
                }                 
            }          
        })    
      }

      function MostrarTopProductos(){

       var mes= $("#Mes").val();

       if(mes == ""){
        Swal.fire("Opss..!", "Debe seleccionar un mes", "warning");    
        return false;
       }

       $.ajax({
        url: '../clases/Cl_TopProductos.php?op=topProductos',
        type: 'POST', 
        data:{
          mes:mes
        },
        success: function(data) {
                if(data == "2"){                       
                  Swal.fire("Oops..!", "Error al mostrar los datos del mes indicado", "warning");    
                }
                else {
                    $("#contenerdor_tabla").html('');
                    $('#example2').DataTable().destroy();
                    $("#contenerdor_tabla").html(data);
                    $("#example2").DataTable({
                        "responsive": true, "lengthChange": false, "autoWidth": false,
                        "buttons": ["excel", "pdf"],
                        "language": lenguaje_español
                    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                    totalIngresos(mes);
                    ProductosVendidos(mes);
                    ventasUsuario(mes);
                    }                 
            }          
        })      
    }


        function cargarDiv(){
              $("#seccion2").hide();
        }

        function mostrarDiv(estado){
          ProductosVendidos();
          totalIngresos();
          ventasUsuario();
  
            if(estado == "seccion1"){
              $("#seccion1").show();
              $("#seccion2").hide();
            }
            else{
              if(estado == "seccion2"){
                $("#seccion1").hide();
                $("#seccion2").show();
              }
            }      
        }
      

        window.onload = function(){/*hace que se cargue la función lo que predetermina que div estará oculto hasta llamar a la función nuevamente*/
          cargarDiv();/* "contenido_a_mostrar" es el nombre que le dimos al DIV */
          ProductosVendidos();
          totalIngresos();
          ventasUsuario();
        }
   
      </script>




<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="../plugins/toastr/toastr.min.js"></script>
<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../plugins/jszip/jszip.min.js"></script>
<script src="../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "language": lenguaje_español
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  })


  var lenguaje_español = 
    {
    "processing": "Procesando...",
    "lengthMenu": "Mostrar _MENU_ registros",
    "zeroRecords": "No se encontraron resultados",
    "emptyTable": "Ningún dato disponible en esta tabla", 
    "info":  "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",   
    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
    "search": "Buscar:",
    "infoThousands": ",",
    "loadingRecords": "Cargando...",
    "paginate": {       
        "first": "Primero",
        "last": "Último",
        "next": "Siguiente",
        "previous": "Anterior"
    },
    "aria": {
        "sortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sortDescending": ": Activar para ordenar la columna de manera descendente"
    }
  }
   
</script>
</body>
</html>
