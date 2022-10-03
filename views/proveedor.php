<?php
session_start();
include '../clases/conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
} else {
  $usuario = $_SESSION['usuario'];
  $tipoUsuario = $_SESSION['tipo_rol'];
  $nombre_personal=$_SESSION['personal'];
  $nombre_rol=$_SESSION['nombre_rol'];
}


$sql = "select * from proveedor";
$resultado = mysqli_query($conectar, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lista de Proveedor</title>
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
            <h1 class="m-0">Listado de Proveedores</h1>
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
              <div class="card-header">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-proveedor"><i class="fas fa-plus-circle"></i> Agregar Proveedor
                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead class="table-dark">
                  <tr>
                  <th>#</th>
                  <th>EMPRESA</th>
                  <th>TELEFONO</th> 
                  <th></th> 
                  <th>CORREO</th> 
                  <th>DIRECCION</th>                                               
                  <th width= 150px>Acción</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $cont = 0; 
                      while ($row = $resultado->fetch_assoc()) { ?>
                        <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['empre']; ?></td>
                        <td><?php echo $row['telefono']; ?></td>
                        <td><a href="https://wa.me/591<?php echo $row['telefono'];?>"><img src="../img/logo-whatsapp.png" width="40" height="40"></a></td>
                        <td><a href="mailto:<?php echo $row['correo'];?>?Subject=Aquí%20el%20asunto%20del%20mail"><?php echo $row['correo'];?></a></td>
                        <td><?php echo $row['direccion']; ?></td>                 
                        <td><button type='button' class='btn btn-primary btn-sm checkbox-toggle' onclick="editarproveedorModal('<?php echo $row['id']; ?>','<?php echo $row['empre']; ?>','<?php echo $row['telefono']; ?>','<?php echo $row['correo']; ?>','<?php echo $row['direccion']; ?>')"><i title="Editar" class="fas fa-edit"></i></button>
                               
                        </td>
                        </tr>
                    <?php } ?>                 
                  </tfooter>
                </table>
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





<!--        MODAL         -->



    <!-- Modal Registrar proveedor --> 
    <div class="modal fade" id="modal-proveedor">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-file-alt"></i>  Registrar proveedor</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="formRegistroCasa" class="row g-3">
                <div class="col-md-12">
                  <label for="inputName" class="form-label"><b>Empresa</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" id ="nombre" placeholder="Ingresar nombre proveedor">
                  </div>                 
                </div>  
                <div class="col-md-5">
                  <label for="inputName" class="form-label"><b>Telefono</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" id ="telefono" placeholder="Ingresar telefono">
                  </div>                 
                </div>
                <div class="col-md-7">
                  <label for="inputName" class="form-label"><b>Correo</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="text" class="form-control" id ="correo" placeholder="Ingresar correo">
                  </div>                 
                </div>
                <div class="col-md-12">
                  <label for="inputName" class="form-label"><b>Direccion Empresa</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-road"></i></span>
                    </div>
                    <input type="text" class="form-control" id ="direccion" placeholder="Ingresar direccion">
                  </div>                 
                </div>                             
              </form>
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="registrarproveedor()">Crear proveedor</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->




       <!-- Modal editar Casa --> 
    <div class="modal fade" id="modalEditarproveedor">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-edit"></i> Editar proveedor</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="formRegistroCasa" class="row g-3">
               
              <div class="col-md-12">
                  <label for="inputName" class="form-label"><b>Empresa</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" id ="nombre1" placeholder="Ingresar nombre proveedor">
                  </div>                 
                </div>
                <div class="col-md-5">
                  <label for="inputName" class="form-label"><b>Telefono</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" id ="telefono1" placeholder="Ingresar telefono">
                  </div>                 
                </div>
                <div class="col-md-7">
                  <label for="inputName" class="form-label"><b>Correo</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="text" class="form-control" id ="correo1" placeholder="Ingresar correo">
                  </div>                 
                </div>
                <div class="col-md-12">
                  <label for="inputName" class="form-label"><b>Direccion Empresa</b></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-road"></i></span>
                    </div>
                    <input type="text" class="form-control" id ="direccion1" placeholder="Ingresar direccion">
                  </div>                 
                </div>  
                <div class="col-md-6">
                  <input type="HIDDEN" class="form-control" id="id1">
                </div>
              </form>
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="editarproveedor()">Actualizar proveedor</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->


  <script>

        //Llama al modal editar casa y le manda los campos de la fila
        function editarproveedorModal(id,nombre,telefono,correo,direccion) {
        
            $('#id1').val(id);  
            $('#nombre1').val(nombre);
            $('#telefono1').val(telefono);  
            $('#correo1').val(correo);
            $('#direccion1').val(direccion);

            $('#modalEditarproveedor').modal('show');
        }

            
    
       function editarproveedor(){
            
            var id = $("#id1").val();
            var nombre = $("#nombre1").val();
              var telefono = $("#telefono1").val();
              var correo = $("#correo1").val();
              var direccion = $("#direccion1").val();

            if(nombre == ""){
              swal.fire('Campos Vacios..!','Debe ingresar el nombre de la proveedor','warning')
              return false;
            }

            $.ajax({                
                 url:'../clases/Cl_proveedor.php?op=editarProveedor',
                 type:'POST',
                 data:{
                    id:id,
                    nombre: nombre,
                      telefono: telefono,  
                      correo: correo,
                      direccion: direccion  
                 },
                 error: function(resp){
                   alert(resp);
                 },
                 success: function(resp){
                      if(resp == 1){
                        Swal.fire('Exito..!','Proveedor actualizado correctamente!','success')
                      //  $('#example1').load('casas.php #example1')
                        $('#modalEditarproveedor').modal('toggle');
                        window.location.href = "proveedor.php";
                      }
                      else{
                          if(resp == 2){
                            Swal.fire(
                              'Error!',
                              'Ha ocurrido un error al guardar la información a la base de datos!',
                              'error'
                            ) 
                          }                 
                      }
                 }
            });             
         
        }



          function registrarproveedor(){
            
              var nombre = $("#nombre").val();
              var telefono = $("#telefono").val();
              var correo = $("#correo").val();
              var direccion = $("#direccion").val();

                if(nombre == ""){
                    swal.fire('Campos Vacios..!','Debe ingresar el nombre de la proveedor','warning')
                    return false;
                }

                if(telefono == ""){
                    swal.fire('Campos Vacios..!','Debe ingresar el telefono del proveedor','warning')
                    return false;
                }


              $.ajax({                
                   url:'../clases/Cl_proveedor.php?op=RegistrarProveedor',
                   type:'POST',
                   data:{
                      nombre: nombre,
                      telefono: telefono,  
                      correo: correo,
                      direccion: direccion   
                   },
                   error: function(resp){
                     alert(resp);
                   },
                   success: function(resp){
                        if(resp == 1){
                          Swal.fire('Exito..!','Proveedor resgistrado correctamente!','success')
                         // $('#example1').load('casas.php #example1')
                         $('#modal-proveedor').modal('toggle');
                          window.location.href = "proveedor.php";
                        }
                        else{
                            if(resp == 2){
                              Swal.fire(
                                'Error!',
                                'Ha ocurrido un error al guardar la información a la base de datos!',
                                'error'
                              )
                            }
                           
                        }
                   }
              });             
           
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
