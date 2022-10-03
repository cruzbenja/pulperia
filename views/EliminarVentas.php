<?php
session_start();
include '../clases/conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
} else {
    $id = $_SESSION['id'];
    $usuario = $_SESSION['usuario'];
}



$sql = "SELECT v.id,v.fecha,v.cliente,v.total,count(vp.cantidad) as cantidadProductos,u.usuario FROM venta as v 
LEFT join ventaproducto as vp on vp.idVenta = v.id
left join usuario as u on u.id = v.idUsuario
where v.estado = 'Habilitado'
GROUP by v.id,v.fecha,v.cliente,v.total,u.usuario";

$resultado = mysqli_query($conectar, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Eliminar ventas</title>
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
            <h1 class="m-0">Eliminar Venta</h1>
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
 

<section class="col-lg-12 col-md-12" style="margin-top:30px;"> 
    <div class="card">    
            <div class="card-header">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="verVentasEliminadas.php" type="button" class="btn btn-secondary"><i class="fas fa-search"></i> Ver ventas eliminadas</a> 
                </div>
            </div>
              <div class="card-body">
                <div id="contenerdor_tabla2">
                  <table id="example1" class="table table-bordered table-striped"  method="POST">
                    <thead>
                    <tr>
                      <th>Nro Venta</th> 
                      <th>Fecha Venta</th>   
                      <th>Cliente</th>                                       
                      <th>Total</th>
                      <th>Cant. Productos</th>   
                      <th>Usuario</th>  
                      <th>Accion</th>  
                    </tr>
                    </thead>
                    <tbody id="rellenarTabla">
                    <?php 
                
                        while ($row = $resultado->fetch_assoc()) { ?>
                          <tr>
                           
                              <td><?php echo $row['id']; ?></td>                                                     
                              <td><?php echo $row['fecha']; ?></td>
                              <td><?php echo $row['cliente']; ?></td> 
                              <td><?php echo $row['total']; ?></td>  
                              <td><?php echo $row['cantidadProductos']; ?></td>     
                              <td><?php echo $row['usuario']; ?></td>  
                              <td><button type='button' class= "btn btn-success btn-sm checkbox-toggle" onclick="detalleVenta('<?php echo $row['id']; ?>')">Ver Detalle</button>
                                  <button type='button' class= "btn btn-danger btn-sm checkbox-toggle" onclick="ConfirmarEliminar('<?php echo $row['id']; ?>')">Eliminar</button>
                              </td>                           
                          </tr>
                      <?php } ?>   
                    </tfooter>
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


<!--MODALS    -->

        <!-- Modal Ver DETALLE VENTA --> 
    <div class="modal fade" id="modalDetalleVenta">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="nav-icon fas fa-file-alt"></i>  Detalle de la Venta</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-md-4 col-form-label">Nro de Venta: </label>
                        <div class="col-md-6">
                            <input type="text" readonly class="form-control-plaintext" id="idVenta">
                        </div>
                    </div>
                    <div id="contenerdor_tabla" class="col-md-12 table-responsive">
                        <table id="example2" class="table table-bordered table-striped"  method="POST">
                            <thead>
                            <tr>
                                <th>Lote</th>                  
                                <th>Producto</th>
                                <th>Laboratorio</th>
                                <th>Cant.</th>
                                <th>Precio</th>
                                <th>SubTotal</th> 
                            </tr>
                            </thead>
                            <tbody>
                            </tfooter>
                        </table>
                    </div> 
                    <div class="modal-footer col-md-12">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>            
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->


    <!-- Modal eliminar venta --> 
    <div class="modal fade" id="modalEliminarVenta">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-trash-alt"></i> Eliminar Venta</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="formRegistroCasa" class="row g-3">
                <div class="col-md-6">
                  <input type="HIDDEN" class="form-control" id="idVenta1">
                </div>
                <div class="col-md-12">
                  <label for="inputName" class="form-label"><b>Motivo de la eliminación</b></label>
                  <textarea id="motivo" class="form-control" placeholder="Breve explicación de la eliminación"></textarea>
       
                </div>  
              </form>
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="EliminarVenta()">Eliminar</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->

  <script>

    function detalleVenta(idVenta){
        
        $('#idVenta').val(idVenta);

        $.ajax({
         url: '../clases/Cl_EliminarVentas.php?op=DetalleVenta',
         type: 'POST',
         data: {
            idVenta: idVenta
             }, 
             success: function(vs) {
                 if (vs == 2) {
                  Swal.fire("Error..!", "ha ocurrido un error al obtener el detalle de la venta", "error");                     
                 }else{
                   
                    $("#contenerdor_tabla").html('');
                    $('#example2').DataTable().destroy();
                    $("#contenerdor_tabla").html(vs);  
                    $('#modalDetalleVenta').modal('show');
                 }                  
             }
         })         
      
    }

       
    function ConfirmarEliminar(idVenta){
        $('#idVenta1').val(idVenta);
        $('#modalEliminarVenta').modal('show');
           
    }

      function EliminarVenta() {
         
        var idVenta = $('#idVenta1').val();
        var motivo = $('#motivo').val();

        if(motivo == "" || motivo == null){
          swal.fire("Ops..!","Debe ingresar el motivo de la eliminación","warning");
          return false;
        }

         $.ajax({
         url: '../clases/Cl_EliminarVentas.php?op=EliminarVentas',
         type: 'POST',
         data: {
            idVenta: idVenta,
            motivo: motivo
             }, 
             success: function(vs) {
                 if (vs == 2) {
                    Swal.fire("Error..!", "ha ocurrido un error al eliminar la venta", "error");                     
                 }else{
                  if (vs == 3) {
                    Swal.fire("Error..!", "error al actualizar el estado de la venta", "error");   
                  }
                    else{
                      Swal.fire('Eliminado!','Venta eliminada correctamente','success');                 
                      location.reload();
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
