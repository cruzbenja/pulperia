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



$sql = "select pro.id as id, cate.nombre as categoria, prove.empre as proveedor,prove.telefono as tele,pro.codigo_pro as codigo, pro.nombre as nombre, pro.cantidad as cantidad, presen.nombre as presentacion, pro.precio as precio from produco as pro left join categoria as cate on cate.id = pro.categoria_id left join proveedor as prove on prove.id =pro.prove_id left join presentacion as presen on presen.id =pro.presenta_id";

$resultado = mysqli_query($conectar, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lista de Productos</title>
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
            <h1 class="m-0">Listado de Productos</h1>
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
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-ReigistrarProducto"><i class="fas fa-plus-circle"></i> Registrar Producto
                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table  id="example1" class="table table-bordered table-striped">
                  <thead >
                  <tr>
                  <th>#</th>
                  <th>CATEGORIA</th>
                  <th>PROVEEDOR</th>
                  <th>CODIGO</th>
                  <th>PRODUCTO</th> 
                  <th>CANTIDAD</th> 
                  <th>PRESENTACION</th>    
                  <th>PRECIO</th>                                            
                  <th width= 160px>Acción</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $cont= 0;
                    while ($row = $resultado->fetch_assoc()) { ?>
                        <tr>
                        <?php if ($row['cantidad']<=3){?>
                            <td style="background-color: yellow;"><?php echo $row['id']; ?></td>      
                            <td style="background-color: yellow;"><?php echo $row['categoria']; ?></td>
                            <td style="background-color: yellow;"><?php echo $row['proveedor']; ?></td>
                            <td style="background-color: yellow;"><?php echo $row['codigo']; ?></td>
                            <td style="background-color: yellow;"><?php echo $row['nombre'];?><strong>-pedir</strong><a href="https://wa.me/591<?php echo $row['tele'];?>"><img src="../img/logo-whatsapp.png" width="25" height="25"></a></td>                     
                            <td style="background-color: yellow;"><?php echo $row['cantidad']; ?></td>
                            <td style="background-color: yellow;"><?php echo $row['presentacion']; ?></td>
                            <td style="background-color: yellow;"><?php echo $row['precio']; ?></td>
                                
                            <td><button type='button' class='btn btn-primary btn-sm checkbox-toggle' onclick="editarProductoModal('<?php echo $row['id']; ?>','<?php echo $row['categoria']; ?>','<?php echo $row['proveedor']; ?>','<?php echo $row['codigo']; ?>','<?php echo $row['nombre']; ?>','<?php echo $row['cantidad']; ?>','<?php echo $row['presentacion']; ?>','<?php echo $row['precio']; ?>')"><i title="Editar" class="fas fa-edit"></i></button>
                            <button type='button' class= "btn btn-danger" onclick="ConfirmarDeshabilitar('<?php echo $row['id']; ?>')">Eliminar</button>
                            </td>
                            <?php }else{?>
                            <td><?php echo $row['id']; ?></td>      
                            <td><?php echo $row['categoria']; ?></td>
                            <td><?php echo $row['proveedor']; ?></td>
                            <td><?php echo $row['codigo']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>                     
                            <td><?php echo $row['cantidad']; ?></td>
                            <td><?php echo $row['presentacion']; ?></td>
                            <td><?php echo $row['precio']; ?></td>
                                
                            <td><button type='button' class='btn btn-primary btn-sm checkbox-toggle' onclick="editarProductoModal('<?php echo $row['id']; ?>','<?php echo $row['categoria']; ?>','<?php echo $row['proveedor']; ?>','<?php echo $row['codigo']; ?>','<?php echo $row['nombre']; ?>','<?php echo $row['cantidad']; ?>','<?php echo $row['presentacion']; ?>','<?php echo $row['precio']; ?>')"><i title="Editar" class="fas fa-edit"></i></button>
                            <button type='button' class= "btn btn-danger" onclick="ConfirmarDeshabilitar('<?php echo $row['id']; ?>')">Eliminar</button>
                            </td>
                            <?php }?>
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



    <!-- Modal Registrar Producto --> 
    <div class="modal fade" id="modal-ReigistrarProducto">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-pills"></i>  Registrar Nuevo Producto</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form method="POST"  class="row g-3">
                <div class="col-md-6">
                      <div class="form-group">
                          <label for="inputCasa" class="form-label"><b>Categoria</b></label> 
                          <select class="form-control select2" id="cate" style="width: 80%;" > 
                          <?php
                                $consulta = "select * from  categoria order by nombre desc";
                                $ejecutar = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
                                ?>
                                <?php foreach ($ejecutar as $opciones) : ?>
                                    <option value="<?php echo $opciones['id'] ?>"><?php echo $opciones['nombre'] ?></option>
                                <?php endforeach ?>
                          </select>
                          
                      </div>
                  </div>  
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="inputCasa" class="form-label"><b>Proveedor</b></label> 
                          <select class="form-control select2" id="prove" style="width: 80%;" > 
                          <?php
                                $consulta = "select * from  proveedor order by empre desc";
                                $ejecutar = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
                                ?>
                                <?php foreach ($ejecutar as $opciones) : ?>
                                    <option value="<?php echo $opciones['id'] ?>"><?php echo $opciones['empre'] ?></option>
                                <?php endforeach ?>
                          </select>
                          
                      </div>
                  </div>  
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="inputCasa" class="form-label"><b>Presentacion</b></label> 
                          <select class="form-control select2" id="prese" style="width: 80%;" > 
                          <?php
                                $consulta = "select * from  presentacion order by nombre desc";
                                $ejecutar = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
                                ?>
                                <?php foreach ($ejecutar as $opciones) : ?>
                                    <option value="<?php echo $opciones['id'] ?>"><?php echo $opciones['nombre'] ?></option>
                                <?php endforeach ?>
                          </select>
                          
                      </div>
                  </div> 
                  <div class="col-md-6">
                            <label for="inputDescription" class="form-label"><i class="fas fa-wine-bottle"></i>    <b>Codigo De Producto</b></label>
                            <input type="text" class="form-control"    id="codi" placeholder="Ingresar Codigo">
                        </div>     
                  
                  

                        <div class="col-md-12">
                            <label for="inputName" class="form-label"><i class="fas fa-wine-bottle"></i>   <b>Nombre</b></label>
                            <input type="text" class="form-control"  id="nom" placeholder="Ingresar cantidad">


​                        </div>  

                        <div class="col-md-6">
                            <label for="inputName" class="form-label"><i class="fas fa-wine-bottle"></i>   <b>Cantidad (stock)</b></label>
                            <input type="text" class="form-control"  id="canti" placeholder="Ingresar Cantidad">
​                        </div>
                        <div class="col-md-6">
                            <label for="inputName" class="form-label"><i class="fas fa-dollar-sign"></i>   <b>Precio</b></label>
                            <input type="text" class="form-control"  id="pre" placeholder="Ingresar Precio">
​                        </div>        
                </form>
              </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="RegistrarProducto()">Registrar Producto</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content   onchange="traerDatosCasa($(this).val())" -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->




     <!-- Modal editar producto --> 
    <div class="modal fade" id="modalEditarProducto">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-edit"></i>  Editar Producto</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="formRegistroCasa" class="row g-3">
              <div class="col-md-6">
                      <div class="form-group">
                          <label for="inputCasa" class="form-label"><b>Categoria</b></label> 
                          <select class="form-control select2" id="categ" style="width: 80%;" > 
                          <?php
                                $consulta = "select * from  categoria ";
                                $ejecutar = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
                                ?>
                                <?php foreach ($ejecutar as $opciones) : ?>
                                    <option value="<?php echo $opciones['nombre'] ?>"><?php echo $opciones['nombre'] ?></option>
                                <?php endforeach ?>
                          </select>
                          
                      </div>

         

                  </div>  
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="inputCasa" class="form-label"><b>Proveedor</b></label> 
                          <select class="form-control select2" id="proveed" style="width: 80%;" > 
                          <?php
                                $consulta = "select * from  proveedor";
                                $ejecutar = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
                                ?>
                                <?php foreach ($ejecutar as $opciones) : ?>
                                    <option value="<?php echo $opciones['empre'] ?>"><?php echo $opciones['empre'] ?></option>
                                <?php endforeach ?>
                          </select>
                          
                      </div>
                  </div>  
       
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="inputCasa" class="form-label"><b>Presentacion</b></label> 
                          <select class="form-control select2" id="present" style="width: 80%;" > 
                          <?php
                                $consulta = "select * from  presentacion ";
                                $ejecutar = mysqli_query($conectar, $consulta) or die(mysqli_error($conectar));
                                ?>
                                <?php foreach ($ejecutar as $opciones) : ?>
                                    <option value="<?php echo $opciones['nombre'] ?>" ><?php echo $opciones['nombre'] ?></option>
                                <?php endforeach ?>
                          </select>
                          
                      </div>
                  </div> 
          
                  <div class="col-md-6">
                            <label for="inputDescription" class="form-label"><i class="fas fa-wine-bottle"></i>    <b>Codigo De Producto</b></label>
                            <input type="text" class="form-control"    id="cod" placeholder="Ingresar Codigo">
                        </div>     
                  
                  

                        <div class="col-md-12">
                            <label for="inputName" class="form-label"><i class="fas fa-wine-bottle"></i>   <b>Nombre</b></label>
                            <input type="text" class="form-control"  id="nme" placeholder="Ingresar cantidad">


​                        </div> 
 

                        <div class="col-md-6">
                            <label for="inputName" class="form-label"><i class="fas fa-wine-bottle"></i>   <b>Cantidad (stock)</b></label>
                            <input type="text" class="form-control"  id="can" placeholder="Ingresar Cantidad">
​                        </div>
                        <div class="col-md-6">
                            <label for="inputName" class="form-label"><i class="fas fa-dollar-sign"></i>   <b>Precio</b></label>
                            <input type="text" class="form-control"  id="preci" placeholder="Ingresar Precio">
​                        </div>      
                  <div class="col-md-6">
                    <input type="hidden" id="id1">
                  </div>
              </form>
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-primary" onclick="editarProducto()">Actualizar Producto</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->

 
  <script>
     function RegistrarProducto(){
            
          var categoria = $('#cate').val();
          var provee = $('#prove').val();
          var presenta = $('#prese').val();
          var codigoP= $('#codi').val();
          var nombre = $('#nom').val();
          var cantid = $('#canti').val();
          var precio= $('#pre').val();


          


          if(categoria == "" || provee == "" || presenta == "" || codigoP == "" || nombre == "" || cantid == ""|| precio == "" ){
            Swal.fire('Campos Vacios!','Debe rellenar todos los campos!','warning')
            return false;
          }

            $.ajax({                
                 url:'../clases/Cl_productos.php?op=RegistrarProducto',
                 type:'POST',
                 data:{
                  cate:categoria,
                  pro:provee,
                  prese:presenta,
                  codi:codigoP,
                  nom:nombre,
                  cant:cantid,
                  pre:precio
                 },
                 error: function(resp){
                   alert(resp);
                 },
                 success: function(resp){
                      if(resp == 1){
                        Swal.fire('Exito..!','Producto resgistrado correctamente!','success')
                        window.location.href = "productos.php";
                      }
                      else{
                          if(resp == 2){
                            Swal.fire(
                              'Error!',
                              'Ha ocurrido un error al registrar el producto en la base de datos!',
                              'error'
                            )
                          }
                         
                      }
                 }
            });             
         
        }

          //Llama al modal editar producto y le manda los campos de la fila
       function editarProductoModal(id,catego,prove,codigo,nombr,canti,presen,precio) {
        
        $('#id1').val(id); 
        $('#categ').val(catego);
        $('#proveed').val(prove);
        $('#cod').val(codigo);
        $('#nme').val(nombr);
        $('#can').val(canti); 
        $('#present').val(presen);
        $('#preci').val(precio);

        $('#modalEditarProducto').modal('show');
    }



       function editarProducto(){
            
            var Id = $('#id1').val();
            var catego = $('#categ').val();
            var provee=$('#proveed').val();
            var cod=$('#cod').val();
            var nombre=$('#nme').val();
            var canti = $('#can').val();
            var prese = $('#present').val();
            var prec=$('#preci').val();
            
        

              if(catego == "" || provee == ""|| cod == ""|| nombre == ""|| canti == ""|| prese == ""|| prec == ""){
              Swal.fire('Campos Vacios!','Debe rellenar todos los campos!','warning')
              return false;
            }

            $.ajax({                
                 url:'../clases/Cl_productos.php?op=editarProducto',
                 type:'POST',
                 data:{
                  id: Id,
                  cate: catego, 
                  prove: provee,               
                  codi: cod,              
                  name: nombre,  
                  cantid: canti,               
                  presen: prese,              
                  preci: prec    
                 },
                 error: function(resp){
                   alert(resp);
                 },
                 success: function(resp){
                      if(resp == 1){
                        Swal.fire('Exito..!','Producto actualizado correctamente!','success')
                  
                        window.location.href = "productos.php";
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
