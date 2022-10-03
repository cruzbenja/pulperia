<?php
session_start();
include '../clases/conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
} else {
    $id = $_SESSION['id'];
    $usuario = $_SESSION['usuario'];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inventario General</title>
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
   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-closed sidebar-collapse" onload="BuscarInventarioAperturado()">
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
            <h1 class="m-0">Inventario General</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Inventario General</li>
            </ol>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
 
    <section class="col-lg-12 col-md-12">
    <div class="card">
        <div class="accordion" id="accordionExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button id="lblInventarioGeneral" class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Apertura de inventario general
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <form role="form" method="post" >
                          <div class="box-body">
                            <div class="form-horizontal">  
                              <div class="row">
                              <div class="col-md-3">
                                  <label id="lblFecha" for="inputfecha" class="form-label">Fecha inicio de inventario</label>
                                  <div class="input-group">
                                      <input type="date" class="form-control" id ="fechaInicio">
                                  </div>                 
                              </div>                              
                           
                              <div class="col-md-2">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end" style="margin-top:32px;">
                                  <div id="btnFiltro"></div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                      <input type="hidden" id ="idProducto">                
                              </div>
                            </div>  
                          </div>                     
                  </form>
              </div>
            </div>
          </div>   
        </div>
    </div>
  </section>

<section class="col-lg-12 col-md-12">
  <div class="card">
            <div class="card-header">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="HistorialInventarioGeneral.php" type="button" class="btn btn-secondary"><i class="fas fa-search"></i> Ver Historial de Inventarios</a> 
                </div>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div id="contenerdor_tabla">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Unidad</th>
                        <th>Stock Sistema</th>
                        <th>Stock Fisico</th>
                        <th>Diferencia</th>
                        <th width="140px">Accion</th>
                    </tr>
                    </thead>
                    <tbody>
                   
                    </tbody>
                    </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>

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
</section>



<!--        MODAL         -->

   

       <!-- Modal ingresar stock --> 
    <div class="modal fade" id="modalIngresarStock">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-edit"></i> Ingresar Stock</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="formEditarLote" class="row g-3">                      
                <div class="col-md-12">
                  <label for="inputName" class="form-label"><b>Stock Físico</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-sort-amount-up-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" id ="stock" placeholder="Ingresar Stock Fisico">
                  </div>                 
                </div>  
                <div class="col-md-6">
                  <input type="hidden" class="form-control" id="id1">
                </div>     
              </form>
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="IngresarStock()">Ingresar Stock</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->


  <script>

  


    function IngresarStock(){
       var id= $("#id1").val();
       var stock= $("#stock").val();

       $.ajax({
        url: '../clases/Cl_inventarioGeneral.php?op=ingresarStock',
        type: 'POST', 
        data:{
            id:id,
            stock:stock
        },
        success: function(data) {
                if(data == "1"){     
                    Swal.fire("Exito..!", "Stock fisico ingresado correctamente", "success");  
                    $('#example1').load('inventarioGeneral.php #example1')
                    $("#modalIngresarStock").modal("toggle"); 
                    $("#stock").val("");     
                    BuscarInventarioAperturado();
                }
                else {
                    Swal.fire("Oops..!", "Error inesperado al ingresar el stock fisico", "warning");     
                    }                 
            }          
        })      
    }


    function modalIngresarStock(id){

        $("#id1").val(id);

        $("#modalIngresarStock").modal("show");
    }


    function BuscarInventarioAperturado(){
        
        $.ajax({
        url: '../clases/Cl_inventarioGeneral.php?op=BuscarApertura',
        type: 'POST', 
        success: function(data) {
                if(data == "vacio"){      
                    $("#btnFiltro").html('<button type="button" class="btn btn-primary" onclick="filtrarProductos()" id="btnFiltro"> Aperturar Inventario</button>');
                }
                else {
                    $("#contenerdor_tabla").html('');
                    $('#example1').DataTable().destroy();
                    $("#contenerdor_tabla").html(data);
                    $("#example1").DataTable({
                        "responsive": true, "lengthChange": false, "autoWidth": false,
                        "buttons": ["excel", "pdf"],
                        "language": lenguaje_español
                    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                    $("#btnFiltro").html('<button type="button" class="btn btn-danger" onclick="filtrarProductos()" id="btnFiltro"> Cerrar Inventario</button>');
                    $("#lblInventarioGeneral").html('Cierre de inventario general');
                    $("#lblFecha").html('Fecha cierre de inventario');
                    }   
                   
            }          
        })         
    }
    function filtrarProductos(){

        var fechaInicio = $("#fechaInicio").val();

        if(fechaInicio == ""){
        Swal.fire("Campos Vacios..!", "Debe ingresar la fecha inicial del inventario", "warning");     
        return false;
        }

        $.ajax({
        url: '../clases/Cl_inventarioGeneral.php?op=filtrarProductos',
        type: 'POST',
        data: {
                fechaInicio: fechaInicio     
            }, 
            success: function(data) {
                if(data == "error"){
                    swal.fire('Ops..!!','Error al obtener el id del ultimo inventario','error')
                }
                else {
                    if(data == "falla"){
                        swal.fire('Ops..!!','Error al hacer el cierre de inventario','error')
                    }
                    else{
                        if(data == "ok"){
                            swal.fire('Exito..!!','Felicidades has cerrado tu inventario correctamente','success')
                            location.reload();
                        }
                        else{
                            swal.fire('Exito..!!','Inventario abierto correctamente','success');
                            $("#contenerdor_tabla").html('');
                            $('#example1').DataTable().destroy();
                            $("#contenerdor_tabla").html(data);
                            $("#example1").DataTable({
                                "responsive": true, "lengthChange": false, "autoWidth": false,
                                "buttons": ["excel", "pdf"],
                                "language": lenguaje_español
                            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                            $("#btnFiltro").html('<button type="button" class="btn btn-danger" onclick="filtrarProductos()" id="btnFiltro"> Cerrar Inventario</button>');
                            $("#lblInventarioGeneral").html('Cierre de inventario general');
                            $("#lblFecha").html('Fecha cierre de inventario');
                        }
                    }
                   
                }   
                    
            }            
        })         
    }

    </script>



<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
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
      "buttons": ["excel", "pdf"],
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
