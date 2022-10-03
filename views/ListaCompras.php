<?php
session_start();
include '../clases/conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
} else {
    $id = $_SESSION['id'];
    $usuario = $_SESSION['usuario'];
}



$sql = "SELECT c.id as idCompras, u.usuario,c.fecha as fechaCompra,pro.proveedor,c.totalCompra, cd.lote,lo.vencimiento as fechaVencimiento,
p.nombre as producto,p.unidad,cd.cantidad,cd.precioUnitario as precioCompra,cd.porcentajeGanancia,l.laboratorio,pr.presentacion,lo.vencimiento FROM compras as c 
LEFT join comprasDetalle as cd on cd.idCompras = c.id 
left join usuario as u on u.id = c.idUsuario 
left join proveedor as pro on pro.id = c.idProveedor 
LEFT JOIN producto as p on p.id = cd.idProducto 
LEFT JOIN laboratorio as l on l.id = p.idLaboratorio 
LEFT JOIN presentacion as pr on pr.id = p.idPresentacion 
LEFT join lote as lo on lo.id = cd.lote 
where c.estado = 'Habilitado'";

$resultado = mysqli_query($conectar, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Listado de Compras</title>
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
<body class="hold-transition sidebar-mini layout-fixed sidebar-closed sidebar-collapse" onload="ocultarBtn()">
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
            <h1 class="m-0">Listado de Compras</h1>
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

  <section class="col-lg-12 col-md-12">
    <div class="card">
        <div class="accordion" id="accordionExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Filtros de rango de fechas
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <form role="form" method="post" >
                          <div class="box-body">
                            <div class="form-horizontal">  
                              <div class="row">
                              <div class="col-md-2">
                                  <label for="inputfecha" class="form-label">Fecha inicio</label>
                                  <div class="input-group">
                                      <input type="date" class="form-control" id ="fechaInicio">
                                  </div>                 
                              </div>   
                              <div class="col-md-2">
                                  <label for="inputfecha" class="form-label">Fecha final</label>
                                  <div class="input-group">
                                      <input type="date" class="form-control" id ="fechaFinal">
                                  </div>                 
                              </div> 
                              <div class="col-md-3">
                                <div class="d-grid gap-2 d-md-flex" style="margin-top:32px;">
                                  <button type="button" class="btn btn-primary" onclick="filtrarComprasFechas()"><i class="fas fa-filter"></i> Filtrar</button>
                                  <button type="button" id="btnMostrarTodo" class="btn btn-primary" onclick="location.reload()"><i class="far fa-eye"></i> Mostrar Todo</button>
                                </div>
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
              <!-- <div class="card-header">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                  <a href="compras.php" type="button" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Nueva Compra</a>
                </div>
              </div>

              /.card-header -->
              <div class="card-body">
                <div id="contenerdor_tabla">
                  <table id="example1" class="table table-bordered table-striped"  method="POST">
                    <thead>
                    <tr>
                      <th>N° Compra</th> 
                      <th>N° Lote</th>                  
                      <th>Fecha Compra</th>                  
                      <th>Fecha Vencimiento</th>
                      <th>Nombre Producto</th>
                      <th>Nombre Laboratorio</th>
                      <th>Tipo de Presentación</th>
                      <th>Cantidad Comprada</th>
                      <th>Precio Compra</th>
                      <th>% de Ganancia</th> 
                      <th>Total Compra</th>
                      <th>Proveedor</th>
                      <th>Usuario</th>  
                            
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                        while ($row = $resultado->fetch_assoc()) { ?>
                          <tr>
                              <td><?php echo $row['idCompras']; ?></td>   
                              <td><?php echo $row['lote']; ?></td>                        
                              <td><?php echo $row['fechaCompra']; ?></td>                                                      
                              <td><?php echo $row['fechaVencimiento']; ?></td>
                              <td><?php echo $row['producto']; ?> <?php echo $row['unidad']; ?></td>
                              <td><?php echo $row['laboratorio']; ?></td>
                              <td><?php echo $row['presentacion']; ?></td> 
                              <td><?php echo $row['cantidad']; ?></td>
                              <td><?php echo $row['precioCompra']; ?></td>
                              <td><?php echo $row['porcentajeGanancia']; ?> %</td>
                              <td><?php echo $row['totalCompra']; ?></td>  
                              <td><?php echo $row['proveedor']; ?></td>  
                              <td><?php echo $row['usuario']; ?></td>     
                              
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


  <script>

    function ocultarBtn(){
      $("#btnMostrarTodo").hide();
    }

    function filtrarComprasFechas(){
       var fechaInicio= $("#fechaInicio").val();
       var fechaFinal= $("#fechaFinal").val();

       if(fechaInicio == "" || fechaFinal == ""){
        Swal.fire("Opss..!", "Debe ingresar el rango de fechas para filtrar", "warning");    
        return false;
       }

       $.ajax({
        url: '../clases/Cl_compra.php?op=filtrarFechas',
        type: 'POST', 
        data:{
            fechaInicio:fechaInicio,
            fechaFinal:fechaFinal
        },
        success: function(data) {
                if(data == "2"){                       
                  Swal.fire("Oops..!", "Error al filtrar las compras", "warning");    
                }
                else {
                    $("#btnMostrarTodo").show();
                    $("#contenerdor_tabla").html('');
                    $('#example1').DataTable().destroy();
                    $("#contenerdor_tabla").html(data);
                    $("#example1").DataTable({
                        "responsive": true, "lengthChange": false, "autoWidth": false,
                        "buttons": ["excel", "pdf"],
                        "language": lenguaje_español
                    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                }                 
            }          
        })      
    }
           
         //funcion que pide confirmacion al usuario para desabilitar un producto
         function ConfirmarDeshabilitar(id,estado) {
        
        if(estado == "Habilitado"){

        Swal.fire({
          title: 'Esta Seguro?',
          text: "Al deshabilitar ya no aparecera en el registro de producto!",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, Deshabilitar!'
          }).then((result) => {
                  if (result.isConfirmed) {
                    DeshabilitarCategoria(id,'Deshabilitado');                      
                  }
          })
      }
        else{
          Swal.fire({
          title: 'Esta Seguro?',
          text: "Al Habilitar aparecera de nuevo en el registro de producto!",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, Habilitar!'
          }).then((result) => {
                  if (result.isConfirmed) {
                    HabilitarCategoria(id,'Habilitado');                      
                  }
          })
        }
      }

      function DeshabilitarCategoria(id1,estado) {
         
         $.ajax({
         url: '../clases/Cl_Categorias.php?op=EliminarCategoria',
         type: 'POST',
         data: {
             id: id1,
             estado: estado           
             }, 
             success: function(vs) {
                 if (vs == 2) {
                  Swal.fire("Error..!", "ha ocurrido un error al deshabilitar", "error");                     
                 }else{
                     Swal.fire(
                     'Deshabilitado!',
                     'Producto deshabilitado correctamente.',
                     'success'
                     )
                    // $('#example1').load('casas.php #example1')
                    window.location.href = "categorias.php";
                 }                  
             }
         })         
     }

     function HabilitarCategoria(id1,estado) {
         
         $.ajax({
         url: '../clases/Cl_Categorias.php?op=EliminarCategoria',
         type: 'POST',
         data: {
             id: id1,
             estado: estado           
             }, 
             success: function(vs) {
                 if (vs == 2) {
                  Swal.fire("Error..!", "ha ocurrido un error al habilitar", "error");                     
                 }else{
                     Swal.fire(
                     'Habilitado!',
                     'Producto habilitado correctamente.',
                     'success'
                     )
                    // $('#example1').load('casas.php #example1')
                    window.location.href = "categorias.php";
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
