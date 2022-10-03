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
  <title>Nueva Compra</title>
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
<body class="hold-transition sidebar-mini layout-fixed sidebar-closed sidebar-collapse" onLoad="ObtenerIdCompra()">
<div class="wrapper" >

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
            <h1 class="m-0">Regitro de Compras</h1>
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


        <!-- Left col -->
        <section class="col-lg-12 col-md-12">
            <div class="card">          
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="POST" id="formEditarLote" class="row g-3">
                        <div class="col-md-12">
                           <h5><i class="fas fa-tags"></i> <b>Datos de la Compra</b></h5> 
                        </div>           
                        <div class="col-md-2">
                            <label for="inputName" class="form-label">N° de Comprobante</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-sort-amount-up-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" id ="idCompra" disabled>
                            </div>                 
                        </div>            
                        <div class="col-md-2">
                            <label for="inputName" class="form-label">Fecha de Compra</label>
                            <div class="input-group">
                                <input type="date" class="form-control" id ="fecha">
                            </div>                 
                        </div>                         
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputCasa" class="form-label"><b>Proveedor</b></label> 
                                <select class="form-control select2" id="idProveedor" style="width: 100%;" > 
                                    <option selected="selected" disabled>Seleccionar...</option>
                                    <?php
                                    $consulta1 = "SELECT * FROM proveedor where estado = 'Habilitado'";
                                    $ejecutar1 = mysqli_query($conectar, $consulta1) or die(mysqli_error($conectar));
                                ?>
                                <?php foreach ($ejecutar1 as $ocpiones1) : ?>
                                    <option value="<?php echo $ocpiones1['id'] ?>"><?php echo $ocpiones1['proveedor'] ?></option>
                                <?php endforeach ?>
                                </select>
                            </div>
                        </div>               
                        <div class="col-md-12 ">
                          <h5><i class="fas fa-cubes"></i> <b>Datos del Producto</b></h5> 
                        </div>   
 
                        <div class="col-md-2 col-10">
                          <label for="" class="form-label">Codigo</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                              </div>
                              <input type="text" class="form-control" id="codigo2" placeholder="Código" disabled>
                          </div>                 
                        </div>  
                        <div class="col-md-1 col-1" style="margin-top:48px;">
                          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#ModalBucarProducto"><i title="Buscar Producto" class="fas fa-search"></i></button>  
                        </div>
                        <div class="col-md-5">
                          <label for="" class="form-label">Producto</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                              </div>
                              <input type="text" class="form-control" id="producto2" placeholder="Nombre del Producto" disabled> 
                          </div>                 
                        </div>  
                        <div class="col-md-2">
                            <label for="inputName" class="form-label">N° Lote</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-cubes"></i></span>
                                </div>
                                <input type="text" class="form-control" id ="lote" placeholder="Ingresar Lote">
                            </div>                 
                        </div>       
                        <div class="col-md-2">
                            <label for="inputName" class="form-label">Fecha Vencimiento</label>
                            <div class="input-group">
                                <input type="date" class="form-control" id ="fechaVencimiento">
                            </div>                 
                        </div>  
                        <div class="col-md-2">
                          <label for="" class="form-label">Cantidad</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                              </div>
                              <input type="text" class="form-control" id="cantidad" placeholder="Cantidad" value="0">
                          </div>                 
                        </div>  
                        <div class="col-md-2">
                          <label for="" class="form-label">Precio Compra Unit.</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-file-medical-alt"></i></span>
                              </div>
                              <input type="text" class="form-control" id="precio" placeholder="Precio Unit." value="0" onchange="calcularTotalCompra()">
                          </div>                 
                        </div>   
                        <div class="col-md-2">
                          <label for="" class="form-label">% Ganancia</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-ruler-horizontal"></i></span>
                              </div>
                              <input type="text" class="form-control" id="ganancia" placeholder="% Ganancia" value="0" onchange="calcularGanacia()">
                          </div>                 
                        </div>  
                        <div class="col-md-2">
                          <label for="" class="form-label">Precio Venta</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                              </div>
                              <input type="text" class="form-control" id="precioVenta" value="0" disabled>
                          </div>                 
                        </div>    
                        <div class="col-md-2">
                          <label for="" class="form-label">SubTotal</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                              </div>
                              <input type="text" class="form-control" id="subtotal" value="0" disabled>
                          </div>                 
                        </div>    
                        <div class="col-md-2" style="margin-top:48px;">
                          <button type="button" class="btn btn-secondary" onclick="IngresarProducto()"><i class="fas fa-plus-square"></i> Agregar Producto</button>        
                        </div>
                      
                        <div class="col-md-12 table-responsive">
                          <table id="ejemplo1" class="table table-bordered table-striped">
                              <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>N° Lote</th>
                                    <th>Vencimiento</th>
                                    <th>Cantidad</th>
                                    <th>Precio Compra</th>
                                    <th>% Ganancia</th>
                                    <th>Precio Venta</th>                  
                                    <th>SubTotal</th>
                                    <th>Acción</th>
                                </tr>
                              </thead>
                              <tbody id="RellenarTabla">
                              
                              </tbody>
                          </table>
                        </div>
                        <div class="col-md-9"></div> 
                        <div class="col-md-3">
                          <label for="" id="lbl_totalNeto"><b>Total Compra:</b> Bs/. 0</label>
                        </div> 
                        <div class="modal-footer col-md-12">
                          <button type="button" class="btn btn-primary" onclick="RegistrarCompra()"><i class="nav-icon fas fa-shopping-cart"></i> Confirmar Compra</button>           
                        </div>
                    </form>        
                </div>
                <!-- /.card-body -->
            </div>
        </section>
        <!-- /.Left col -->      
      </div>
      <!-- /.content-wrapper -->
                


         <?php $año = date('Y'); ?>
      <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
          <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; Software Bolivia <?php echo $año ?></strong> Todos los derechos reservados.
      </footer>

       <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
         <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
      

<!--        MODAL         -->

     <!-- Modal buscar producto --> 
     <div class="modal fade" id="ModalBucarProducto">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="nav-icon fas fa-plus"></i> Agregar Productos</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="col-md-12 table-responsive">
                <table id="example2" class="table table-bordered table-striped">
                  <thead class="table-dark">
                    <tr>
                        <th></th>
                        <th>Nombre</th>
                        <th>Unidad</th>
                        <th>Laboratorio</th>                        
                    </tr>
                  </thead>
                  <tbody>
                        <?php 
                        $sql = "SELECT p.id,p.nombre,p.descripcion,p.unidad,c.id as idCategoria,c.categoria,l.id as idLaboratorio,l.laboratorio,
                            pr.id as idPresentacion,pr.presentacion,p.estado FROM producto as p 
                            left join categoria as c on c.id = p.idCategoria 
                            LEFT JOIN laboratorio as l on l.id = p.idLaboratorio 
                            LEFT JOIN presentacion as pr on pr.id = p.idPresentacion";
                        $resultado = mysqli_query($conectar, $sql);
                        while ($row = $resultado->fetch_assoc()) { ?>
                            <tr>
                            <td><button type='button' class='btn btn-primary btn-sm checkbox-toggle' onclick="DatosProducto('<?php echo $row['id']; ?>','<?php echo $row['nombre']; ?>','<?php echo $row['unidad']; ?>')"><i class="fas fa-check-circle"></i></button></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['unidad']; ?></td>
                            <td><?php echo $row['laboratorio']; ?></td>
                            </tr>
                        <?php } ?>                 
                  </tbody>                 
                </table>            
              </div>
            </div>
            <div class="modal-footer col-md-12">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->


  <script>

      function RegistrarCompra(){
        let count = 0;
        $("#ejemplo1 tbody#RellenarTabla tr").each(function() {
          count++;
        })

        if(count == 0){
          swal.fire('Sin Productos..!','El detalle de productos debe tener por lo menos un producto ingresado','warning')
          return false;
        }

        var idCompra = $("#idCompra").val();
        var fecha = $("#fecha").val();
        var idProveedor = $("#idProveedor").val();
        var totalCompra = document.getElementById('lbl_totalNeto').innerHTML.substr(26);
       
        if(fecha == "" || idProveedor == ""){
          swal.fire('Campos Vacios..!','Debe rellenar todos los campos de los datos de la compra','warning')
          return false;
        }

        let arreglo_idProducto = [];
        let arreglo_lote = [];
        let arreglo_vencimiento = [];
        let arreglo_cantidad = [];
        let arreglo_precioCompra = [];
        let arreglo_ganancia = [];
        let arreglo_precioVenta = [];
        let arreglo_subTotal = [];
        
        $("#ejemplo1 tbody#RellenarTabla tr").each(function() {
          arreglo_idProducto.push($(this).find('td').eq(0).text());
          arreglo_lote.push($(this).find('td').eq(2).text());
          arreglo_vencimiento.push($(this).find('td').eq(3).text());
          arreglo_cantidad.push($(this).find('td').eq(4).text());
          arreglo_precioCompra.push($(this).find('td').eq(5).text());
          arreglo_ganancia.push($(this).find('td').eq(6).text());
          arreglo_precioVenta.push($(this).find('td').eq(7).text());
          arreglo_subTotal.push($(this).find('td').eq(8).text());
          count++;
        })

        let idProducto = arreglo_idProducto.toString();
        let cantidad = arreglo_cantidad.toString();
        let lote = arreglo_lote.toString();
        let vencimiento = arreglo_vencimiento.toString();
        let precioCompra = arreglo_precioCompra.toString();
        let ganancia = arreglo_ganancia.toString();
        let precioVenta = arreglo_precioVenta.toString();
        let subtotal = arreglo_subTotal.toString();
         
        
        $.ajax({                
                 url:'../clases/Cl_compra.php?op=RegistrarCompra',
                 type:'POST',
                 data:{
                      idCompra:idCompra,
                      lote: lote,
                      fecha: fecha,
                      idProveedor: idProveedor,
                      totalCompra: totalCompra,
                      fechaVencimiento: vencimiento,
                      
                      idProducto: idProducto,
                      cantidad: cantidad, 
                      precioCompra: precioCompra,
                      ganancia: ganancia,
                      precioVenta: precioVenta, 
                      subtotal: subtotal     
                 },
                 error: function(resp){
                   alert(resp);
                 },
                 success: function(resp){
                 
                      if(resp == 1){
                        Swal.fire('Exito..!','Compra ingresada correctamente!','success')
                      //  $('#example1').load('casas.php #example1')
                       // $('#modalEditarProducto').modal('toggle');
                        window.location.href = "compras.php";
                      }
                      else{
                          if(resp == 2){
                            Swal.fire(
                              'Error!',
                              'Ha ocurrido un error al registrar el detalle de la compra!',
                              'error'
                            ) 
                          }    
                          else{
                          if(resp == 3){
                            Swal.fire(
                              'Error!',
                              'Ha ocurrido un error al registrar la compra!',
                              'error'
                            ) 
                          }               
                      }           
                      }
                 }
            });             
         

      }
      function Remover(id){
        var td = id.parentNode;
        var tr = td.parentNode;
        var table = tr.parentNode;
        table.removeChild(tr);
        sumarColumnaTotal();
      }

      function sumarColumnaTotal(){
        let arreglo_total = [];
        let count = 0;
        let total = 0;
        $("#ejemplo1 tbody#RellenarTabla tr").each(function() {
          arreglo_total.push($(this).find('td').eq(8).text());
          count++;
        })
        for(var i = 0; i < count; i++){
          var suma = arreglo_total[i];
          total = (parseFloat(total) + parseFloat(suma)).toFixed(2);
        }
        $("#lbl_totalNeto").html("<b>Total Compra:</b> Bs/. " +total);
      }


      function calcularTotalCompra(){
        var cantidad = $('#cantidad').val();
        var precio = $('#precio').val();

        var operacion = cantidad * precio;
        $('#subtotal').val(operacion);
      }

      function calcularGanacia(){
        var precio = $('#precio').val();
        var ganancia = $('#ganancia').val();

        var operacion = precio * ganancia / 100;
        var resultado = parseFloat(operacion) + parseFloat(precio);
        $('#precioVenta').val(resultado);
      }

      function verificarId(id){
        let idProducto= document.querySelector('#ejemplo1 td[for="id"]');
        return [].filter.call(idProducto, td=> td.textContent === id).length===1;
      }

      function IngresarProducto(){

        var codigo = $('#codigo2').val();
        var producto = $('#producto2').val();
        var lote = $('#lote').val();
        var fechaVencimiento = $('#fechaVencimiento').val();
        var cantidad = $('#cantidad').val();
        var precio = $('#precio').val();
        var ganancia = $('#ganancia').val();
        var precioVenta = $('#precioVenta').val();
        var subtotal = $('#subtotal').val();

       

        if(codigo == "" || producto == "" || cantidad == "" || precio == "" || ganancia == "" || precioVenta == "" || subtotal == "" || lote == "" || fechaVencimiento == ""){
          swal.fire('Campos Vacios..!','Debe rellenar todos campos','warning')
          return false;
        }

        if( parseInt(cantidad) <= 1){
          swal.fire('Ops..!','La cantidad debe ser mayor a cero','warning')
          return false;
        }

        if( parseFloat(precio) <= 0){
          swal.fire('Ops..!','El precio debe ser mayor a cero','warning')
          return false;
        }

        if( parseFloat(lote) <= 0){
          swal.fire('Ops..!','El lote debe ser mayor a cero','warning')
          return false;
        }

        $.ajax({               
                 url:'../clases/Cl_compra.php?op=ValidarLote',
                 type:'POST',  
                 data:{lote:lote},
                 error: function(resp){
                   alert(resp);
                 },
                 success: function(resp){
                      if(resp > 0){
                        swal.fire('Ops..!','El N° de lote ya existe en la base de datos','warning')   
                        return false;     
                      }
                      else{
                          let datos_agregar = "<tr>";
                          datos_agregar+="<td for='id'>"+codigo+"</td>";
                          datos_agregar+="<td>"+producto+"</td>";
                          datos_agregar+="<td>"+lote+"</td>";
                          datos_agregar+="<td>"+fechaVencimiento+"</td>";
                          datos_agregar+="<td>"+cantidad+"</td>";
                          datos_agregar+="<td>"+precio+"</td>";
                          datos_agregar+="<td>"+ganancia+"</td>";
                          datos_agregar+="<td>"+precioVenta+"</td>";
                          datos_agregar+="<td>"+subtotal+"</td>";
                          datos_agregar+="<td><button class='btn btn-danger' onclick='Remover(this)'><i title='Eliminar' class='nav-icon fas fa-trash-alt'></button></td>";
                          $("#RellenarTabla").append(datos_agregar);
                          sumarColumnaTotal();

                          $('#codigo2').val("");
                          $('#producto2').val("");
                          $('#lote').val("");
                          $('#fechaVencimiento').val("");
                          $('#cantidad').val("0");
                          $('#precio').val("0");
                          $('#ganancia').val("0");
                          $('#precioVenta').val("0");
                          $('#subtotal').val("0");     
                      }
                    }
            });       
      
        }

      
       function DatosProducto(id,producto,unidad){
            var NombreProducto = producto+' '+unidad;
            $("#ModalBucarProducto .close").click()         
            $('#codigo2').val(id);
            $("#producto2").val(NombreProducto);            
           // $('#modalDatosProducto').modal('show');
        }

        function ObtenerIdCompra(){
          $.ajax({                
                 url:'../clases/Cl_compra.php?op=obtenerIdCompra',
                 type:'POST',              
                 error: function(resp){
                   alert(resp);
                 },
                 success: function(resp){
                      if(resp != ""){
                        $idcom= parseInt(resp) + 1;
                        $('#idCompra').val($idcom);
                      }
                      else{                          
                        $('#idCompra').val(1);
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
    $("#example2").DataTable({
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
