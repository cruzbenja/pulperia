<?php
session_start();
include '../clases/conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
} else {
  $id = $_SESSION['id'];
  $usuario = $_SESSION['usuario'];
  $tipoUsuario = $_SESSION['tipo_rol'];
  $nombre_personal=$_SESSION['personal'];
  $nombre_rol=$_SESSION['nombre_rol'];
}


$sql = "select * from personal";
$resultado = mysqli_query($conectar, $sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lista de Empleados</title>
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
            <h1 class="m-0">Listado de Empleados</h1>
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
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-ReigistrarEmpleado"><i class="fas fa-plus-circle"></i> Registrar Empleado
                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead >
                  <tr>
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Fecha.Nac</th> 
                  <th>Telefono</th> 
                  <th>Direccion</th> 
                  <th>Carnet Identidad</th>                                                   
                  <th width= 150px>Acción</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php while ($row = $resultado->fetch_assoc()) { ?>
                        <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                         <td><?php echo $row['fecha_nac']; ?></td>
                         <td><?php echo $row['telefono']; ?></td>
                          <td><?php echo $row['direccion']; ?></td>
                         <td><?php echo $row['ci']; ?></td>                       
                          
                          
                                 <td><button type='button' class='btn btn-primary btn-sm checkbox-toggle' onclick="editarEmpleadoModal('<?php echo $row['id']; ?>','<?php echo $row['nombre']; ?>','<?php echo $row['fecha_nac']; ?>','<?php echo $row['telefono']; ?>','<?php echo $row['direccion']; ?>','<?php echo $row['ci']; ?>')"><i title="Editar" class="fas fa-edit"></i></button>
                                    <button type='button' class= "btn btn-danger" onclick="ConfirmarDeshabilitar('<?php echo $row['id']; ?>')">Eliminar</button>
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



    <!-- Modal Registrar Empleado --> 
    <div class="modal fade" id="modal-ReigistrarEmpleado">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-user-md"></i>  Registrar Nuevo Empleado</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="formAlquilarCasa" class="row g-3">         
                <div class="col-md-12">
                            <label for="inputName" class="form-label"><i class="fas fa-user"></i> <b>Nombre</b></label>
                            <input type="text" class="form-control"  id="nombre" placeholder="Ingresar nombre">
                        </div> 
                        <div class="col-md-6">
                            <label for="inputDescription" class="form-label"><b>Fecha de Nacimiento</b></label>
                            <input type="date" class="form-control"   id="fecha">
                        </div> 
                        <div class="col-md-6">
                            <label for="inputDescription" class="form-label"><i class="fas fa-phone"></i>  <b>Telefono</b></label>
                            <input type="text" class="form-control"    id="tele" placeholder="Ingresar Telefono">
                        </div>  
                        <div class="col-md-12">
                            <label for="inputName" class="form-label"><i class="fas fa-road"></i>   <b>Direccion</b></label>
                            <input type="text" class="form-control"  id="direc" placeholder="Ingresar su direccion">
                            
                        </div> 
                        <div class="col-md-6">
                            <label for="inputDescription" class="form-label"><i class="fas fa-address-card"></i>    <b>Carnet identidad</b></label>
                            <input type="text" class="form-control"    id="ci" placeholder="Ingresar carnet identidad">
                        </div>          
                
                </form>
              </div>
              <div class="modal-footer col-md-12">
                        <button type="button" class="btn btn-primary" onclick="RegistrarEmpleado()">Registrar Empleado</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>            
                      </div>
           
          </div>
          <!-- /.modal-content   onchange="traerDatosCasa($(this).val())" -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->




     <!-- Modal editar Empleado --> 
    <div class="modal fade" id="modalEditarEmpleado">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-edit"></i>  Editar Empleado</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="formRegistroCasa" class="row g-3">
              <div class="col-md-12">
                            <label for="inputName" class="form-label"><i class="fas fa-user"></i>   <b>Nombre</b></label>
                            <input type="text" class="form-control"  id="name" placeholder="Ingresar nombre">
                        </div> 
                        <div class="col-md-6">
                            <label for="inputDescription" class="form-label"><b>Fecha de Nacimiento</b></label>
                            <input type="date" class="form-control"   id="fe">
                        </div> 
                        <div class="col-md-6">
                            <label for="inputDescription" class="form-label"><i class="fas fa-phone"></i>  <b>Telefono</b></label>
                            <input type="text" class="form-control"   id="te" placeholder="Ingresar Telefono">
                        </div>  
                        <div class="col-md-12">
                            <label for="inputName" class="form-label"><i class="fas fa-road"></i>   <b>Direccion</b></label>
                            <input type="text" class="form-control"   id="dir" placeholder="Ingresar su direccion">
                            
                        </div> 
                        <div class="col-md-6">
                            <label for="inputDescription" class="form-label"><i class="fas fa-address-card"></i>    <b>Carnet identidad</b></label>
                            <input type="text" class="form-control"   id="ciden" placeholder="Ingresar carnet identidad">
                        </div>                    
                        <div class="col-md-6">
                            <input type="HIDDEN" class="form-control"   id="id">
                        </div>      
              </form>
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="editarEmpleado()">Actualizar Empleado</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->

 


  <script>

    // funcion registrar empleado
      function RegistrarEmpleado(){
            
            var nombre = $('#nombre').val();
            var fecha = $('#fecha').val();
            var telefono = $('#tele').val();
            var direccion = $('#direc').val();
            var carnet = $('#ci').val();

 

            if(nombre == "" || fecha == "" || telefono == "" || direccion == "" || carnet == ""){
              Swal.fire('Campos Vacios!','Debe rellenar todos los campos obligatorio!','warning')
              return false;
            }

              $.ajax({                
                   url:'../clases/Cl_Empleados.php?op=RegistrarEmpleado',
                   type:'POST',
                   data:{
                    nomb:nombre,
                    fecha:fecha,
                    tele:telefono,
                    dir:direccion,
                    ci:carnet
                   },
                   error: function(resp){
                     alert(resp);
                   },
                   success: function(resp){
                        if(resp == 1){
                          Swal.fire('Exito..!','Empleado resgistrado correctamente!','success')
                          window.location.href = "empleado.php";
                        }
                        else{
                            if(resp == 2){
                              Swal.fire(
                                'Error!',
                                'Ha ocurrido un error al registrar el Empleado en la base de datos!',
                                'error'
                              )
                            }
                           
                        }
                   }
              });             
           
          }

             //funcion que pide confirmacion al usuario para desabilitar un Empleado
        function ConfirmarDeshabilitar(id) {
        
          Swal.fire({
            title: 'Esta Seguro?',
            text: "Al Eliminar Se Eliminara Tambien El Usuario!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Deshabilitar!'
            }).then((result) => {
                    if (result.isConfirmed) {
                      DeshabilitarEmpleado(id);                      
                    }
            })
        
          }

        function DeshabilitarEmpleado(id1) {
          var id = id1;
           
           $.ajax({
           url: '../clases/Cl_Empleados.php?op=EliminarEmpleado',
           type: 'POST',
           data: {
               id1: id,
                  
               }, 
               success: function(vs) {
                   if (vs == 2) {
                    Swal.fire("Error..!", "ha ocurrido un error al deshabilitar", "error");  
                                 
                   }else{
                       Swal.fire(
                       'Deshabilitado!',
                       'Empleado deshabilitado correctamente.',
                       'success'
                       )
                 
                      window.location.href = "empleado.php";
                   }                  
               }
           })         
       }

        
          //Llama al modal editar Empleado y le manda los campos de la fila
       function editarEmpleadoModal(id,nombre,fechanac,tele,direccion,ci) {
        
        $('#id').val(id); 
        $('#name').val(nombre);
        $('#fe').val(fechanac);
        $('#te').val(tele);
        $('#dir').val(direccion);
        $('#ciden').val(ci);

        $('#modalEditarEmpleado').modal('show');
    }

       function editarEmpleado(){
            
            var Id = $('#id').val();
            var nombre = $('#name').val();
            var fecha=$('#fe').val();
            var tel=$('#te').val();
            var dir=$('#dir').val();
            var ci=$('#ciden').val();

              if(nombre == "" || fecha == "" || tel == "" || dir == "" || ci == ""){
              Swal.fire('Campos Vacios!','Debe rellenar todos los campos obligatorio!','warning')
              return false;
            }

            $.ajax({                
                 url:'../clases/Cl_Empleados.php?op=editarEmpleado',
                 type:'POST',
                 data:{
                    id: Id ,
                    name: nombre, 
                    fec: fecha,               
                    te: tel,              
                    di: dir,              
                    cin: ci
                 },
                 error: function(resp){
                   alert(resp);
                 },
                 success: function(resp){
                      if(resp == 1){
                        Swal.fire('Exito..!','Empleado actualizado correctamente!','success')
                      //  $('#example1').load('casas.php #example1')
                       // $('#modalEditarEmpleado').modal('toggle');
                        window.location.href = "empleado.php";
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
