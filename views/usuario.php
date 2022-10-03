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

$sql="select u.id as id,u.name as usuario,u.pass as pass,p.nombre as perso,r.nombre as rol from usuario as u left join personal as p on p.id=u.per_id left join rol as r on r.id=u.rol_id";
$resultado = mysqli_query($conectar, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lista de Roles</title>
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
            <h1 class="m-0">Listado de Roles</h1>
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
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-Rol"><i class="fas fa-plus-circle"></i> Registrar Usuario</button>
                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead class="table-dark">
                  <tr>
                  <th>#</th>
                    <th>PERSONAL</th>
                    <th>USUARIO</th> 
                    <th>CONTRASEÑA</th> 
                    <th>Rol</th>                                               
                    <th width= 150px>Acción</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $cont = 0; 
                      while ($row = $resultado->fetch_assoc()) { ?>
                        <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['perso']; ?></td>
                        <td><?php echo $row['usuario']; ?></td>
                        <td><?php echo $row['pass']; ?></td>
                        <td><?php echo $row['rol']; ?></td>
                                          
                              <td><button type='button' class='btn btn-primary btn-sm checkbox-toggle' onclick="editarRolModal('<?php echo $row['id']; ?>','<?php echo $row['perso'];?>','<?php echo $row['usuario'];?>','<?php echo $row['pass']; ?>','<?php echo $row['rol'];?>')"><i title="Editar nombre rol" class="fas fa-edit"></i></button>
 
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



    <!-- Modal Registrar usuario --> 
    <div class="modal fade" id="modal-Rol">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-file-alt"></i>  Registrar Rol</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="formRegistroCasa" class="row g-3">
              <div class="col-md-12">
                        <label for="inputEmpleado" class="form-label"><i class="fas fa-user-tie"></i>  <b>Empleado</b></label>
                        <!-- seleccionamos EL EMPLEADO -->
                        <select id="empleado" class="form-select" >
                                <?php
                                $consulta = "select * from personal order by nombre desc";
                                $ejecutar = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
                                ?>
                                <?php foreach ($ejecutar as $ocpiones) : ?>
                                    <option value="<?php echo $ocpiones['nombre'] ?>"><?php echo $ocpiones['nombre'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                        <label for="inputDescription" class="form-label"><i class="fas fa-user"></i>  <b>Usuario</b></label>
                            <input type="text" class="form-control" id="usu" placeholder="Ingresar Usuario">
                        </div> 
                        <div class="col-md-6">
                            <label for="inputDescription" class="form-label"><i class="fas fa-key"></i>  <b>Contraseña</b></label>
                            <input type="password" class="form-control" id="contra" placeholder="Ingresar Contraseña" >
                        </div>  
                        <div class="col-md-12">
                        <label for="inputRol" class="form-label"><i class="fas fa-user-cog"></i>  <b>Rol</b></label>
                        <!-- seleccionamos el empleado que se inscribieron recien -->
                        <select  id="rol" class="form-select" aria-label="Default select example">
                        <option value="1">Administrador</option>
                        <option value="2">Vendedor</option>
                        </select>    
                        </div>       
              </form>
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="registrarRol()">Crear Rol</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->




       <!-- Modal editar usuario --> 
    <div class="modal fade" id="modalEditarRol">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-edit"></i> Editar Rol</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="formRegistroCasa" class="row g-3">
              <div class="col-md-12">
                        <label for="inputEmpleado" class="form-label"><i class="fas fa-user-tie"></i>  <b>Empleado</b></label>
                        <!-- seleccionamos el rol que se inscribieron recien -->
                        <input type="text" class="form-control" id="per"  disabled>

                        <div class="col-md-6">
                        <label for="inputDescription" class="form-label"><i class="fas fa-user"></i>  <b>Usuario</b></label>
                            <input type="text" class="form-control" id="usua" placeholder="Ingresar Usuario">
                        </div> 
                        <div class="col-md-6">
                            <label for="inputDescription" class="form-label"><i class="fas fa-key"></i>  <b>Contraseña</b></label>
                            <input type="password" class="form-control" id="pas" placeholder="Ingresar Contraseña" >
                        </div>  
                        <div class="col-md-12">
                        <label for="inputRol" class="form-label"><i class="fas fa-user-cog"></i>  <b>Rol</b></label>
                        <!-- seleccionamos el empleado que se inscribieron recien -->
                        <select  id="rl" class="form-select" aria-label="Default select example">
                        <option value="1">Administrador</option>
                        <option value="2">Vendedor</option>
                        </select>    
                        </div> 
                        <div class="col-md-6">
                            <input type="HIDDEN" class="form-control" id="id">
                        </div>
              </form>
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="editarRol()">Actualizar Rol</button>
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
        function editarRolModal(id,perso,usua,pass,rl) {
        
          $('#id').val(id); 
          $('#per').val(perso);
          $('#usua').val(usua);
          $('#pas').val(pass);
          $('#rl').val(rl);
            $('#modalEditarRol').modal('show');
        }

        function editarRol(){
            
             var id = $('#id').val();
            var usuario=$('#usua').val();
            var contra=$('#pas').val();
            var persona =$('#per').val();
            var rol=$('#rl').val();
             

            if(usuario == ""||contra == ""||persona == ""||rol == ""){
              swal.fire('Campos Vacios..!','Debe ingresar el nombre del Rol','warning')
              return false;
            }

            $.ajax({                
                 url:'../clases/Cl_usuario.php?op=editarRol',
                 type:'POST',
                 data:{
                    Id: id,
                    usu: usuario,               
                    con: contra,
                    per: persona,              
                    rl: rol        
                 },
                 error: function(resp){
                   alert(resp);
                 },
                 success: function(resp){
                      if(resp == 1){
                        Swal.fire('Exito..!','Rol actualizado correctamente!','success')
                      //  $('#example1').load('casas.php #example1')
                      
                        window.location.href = "usuario.php";
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



 

          function registrarRol(){
            
            var nombre = $('#empleado').val();
            var usuario  = $('#usu').val();
            var contrasena = $('#contra').val();
            var rl = $('#rol').val();

                if(nombre == ""||usuario == ""||contrasena == ""||rl == ""){
                    swal.fire('Campos Vacios..!','Debe Rellenar todos los campos','warning')
                    return false;
                }

              $.ajax({                
                   url:'../clases/Cl_usuario.php?op=RegistrarRol',
                   type:'POST',
                   data:{
                    nomb:nombre,
                    usu:usuario,
                    contra:contrasena,
                    rol:rl      
                   },
                   error: function(resp){
                     alert(resp);
                   },
                   success: function(resp){
                        if(resp == 1){
                          Swal.fire('Exito..!','Rol resgistrado correctamente!','success')
                         // $('#example1').load('casas.php #example1')
                        // $('#modal-Casa').modal('toggle');
                          window.location.href = "usuario.php";
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
