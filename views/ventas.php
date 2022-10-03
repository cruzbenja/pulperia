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
  <title>Nueva venta</title>
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
<body class="hold-transition sidebar-mini layout-fixed sidebar-closed sidebar-collapse" onLoad="ObtenerIdventa()">
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
            <h1 class="m-0">Regitro de ventas</h1>
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
                           <h5><i class="fas fa-tags"></i> <b>Datos de la venta</b></h5> 
                        </div>           
                        <div class="col-md-2">
                            <label for="inputName" class="form-label">N° de Recibo</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-sort-amount-up-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" id ="idventa" disabled>
                            </div>                 
                        </div>            
                        <div class="col-md-2">
                            <label for="inputfecha" class="form-label">Fecha de venta</label>
                            <div class="input-group">
                                <input type="date" class="form-control" id ="fecha">
                            </div>                 
                        </div>                         
                        <div class="col-md-4">
                            <label for="inputcliente" class="form-label">Nombre Cliente</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                </div>
                                <input type="text" class="form-control" id ="cliente" placeholder="Ingresar nombre cliente">
                            </div>                 
                        </div> 
                        <div class="col-md-3">
                            <label for="inputcatnet" class="form-label">N° Carnet</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                </div>
                                <input type="text" class="form-control" id ="carnet" placeholder ="Ingresar Carnet">
                            </div>                 
                        </div>          
                        <div class="col-md-12 ">
                          <h5><i class="fas fa-cubes"></i> <b>Datos del Producto</b></h5> 
                        </div>   
 
                        <div class="col-md-2 col-10">
                          <label for="" class="form-label">N° Lote</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                              </div>
                              <input type="text" class="form-control" id="lote" placeholder="Nro Lote" disabled>
                          </div>                 
                        </div>  
                        <div class="col-md-1 col-1" style="margin-top:48px;">
                          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#ModalBucarProducto"><i title="Buscar Producto" class="fas fa-search"></i></button>  
                        </div>
                        <div class="col-md-5">
                          <label for="" class="form-label">NombreProducto</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                              </div>
                              <input type="text" class="form-control" id="producto" placeholder="Nombre del Producto" disabled> 
                          </div>                 
                        </div>   
                        <div class="col-md-2">
                          <label for="" class="form-label">Cantidad</label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                              </div>
                              <input type="text" class="form-control" id="cantidad" placeholder="Cantidad" value="0" onchange="calcularTotalventa()">
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
                                    <th>N° Lote</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio venta</th>                
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
                          <label for="" id="lbl_totalNeto"><b>Total venta:</b> Bs/. 0</label>
                        </div> 
                        <div class="modal-footer col-md-12">
                          <button type="button" class="btn btn-primary" onclick="Registrarventa()"><i class="nav-icon fas fa-cash-register"></i> Confirmar venta</button>           
                        </div>
                    </form>        
                </div>
                <!-- /.card-body -->
            </div>
        </section>
        <!-- /.Left col -->   


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
                        <th>Lote</th>
                        <th>Producto</th>                        
                        <th>Vencimiento</th>
                        <th>Precio</th>
                        <th>Laboratorio</th>  
                        <th>Presentación</th>                   
                        
                    </tr>
                  </thead>
                  <tbody>
                        <?php 
                        $sql = "SELECT lo.id as idLote,p.nombre as producto,p.unidad,DATEDIFF(lo.vencimiento, curdate()) as vencimiento,lo.precioVenta,
                        l.laboratorio,pr.presentacion,lo.stock FROM lote as lo
                        LEFT join producto as p on p.id = lo.idProducto
                        LEFT JOIN laboratorio as l on l.id = p.idLaboratorio 
                        LEFT JOIN presentacion as pr on pr.id = p.idPresentacion
                        where lo.estado = 'Habilitado' and lo.stock > 0";
                        $resultado = mysqli_query($conectar, $sql);
                        while ($row = $resultado->fetch_assoc()) { ?>
                            <tr>
                            <td><button type='button' class='btn btn-primary btn-sm checkbox-toggle' onclick="DatosProducto('<?php echo $row['idLote']; ?>','<?php echo $row['producto']; ?>','<?php echo $row['unidad']; ?>','<?php echo $row['precioVenta']; ?>')"><i title="Editar" class="fas fa-check-circle"></i></button></td>
                            <td><?php echo $row['idLote']; ?></td>
                            <td><?php echo $row['producto']; ?> <?php echo $row['unidad']; ?></td>
                           
                            <td><?php echo $row['vencimiento']; ?> dias</td>
                            <td><?php echo $row['precioVenta']; ?></td>
                            <td><?php echo $row['laboratorio']; ?></td>
                            <td><?php echo $row['presentacion']; ?></td>
                            
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

      function Registrarventa(){

       // window.location.href = "../reportes/imprimirVenta.php";
       // const ruta = '../reportes/ImprimirVenta.php';
       // window.open(ruta);
       // return false;

        let count = 0;
        $("#ejemplo1 tbody#RellenarTabla tr").each(function() {
          count++;
        })

        if(count == 0){
          swal.fire('Sin Productos..!','El detalle de productos debe tener por lo menos un producto ingresado','warning')
          return false;
        }

        var idventa = $("#idventa").val();
        var fecha = $("#fecha").val();
        var cliente = $("#cliente").val();
        var carnet = $("#carnet").val();
        var totalventa = document.getElementById('lbl_totalNeto').innerHTML.substr(25);
       
        if(fecha == "" ){
          swal.fire('Campos Vacios..!','Debe ingresar la fecha de la venta','warning')
          return false;
        }

        if(cliente == ""){
          swal.fire('Campos Vacios..!','Debe ingresar el nombre del cliente','warning')
          return false;
        }


        let arreglo_lote = [];
        let arreglo_cantidad = [];
        let arreglo_subTotal = [];
        
        $("#ejemplo1 tbody#RellenarTabla tr").each(function() {
          arreglo_lote.push($(this).find('td').eq(0).text());
          arreglo_cantidad.push($(this).find('td').eq(2).text());
          arreglo_subTotal.push($(this).find('td').eq(4).text());
          count++;
        })


        let cantidad = arreglo_cantidad.toString();
        let lote = arreglo_lote.toString();
        let subtotal = arreglo_subTotal.toString();
         
        
        $.ajax({                
                 url:'../clases/Cl_ventas.php?op=Registrarventa',
                 type:'POST',
                 data:{
                      idventa:idventa,                   
                      fecha: fecha,
                      cliente: cliente,
                      totalventa: totalventa,
                      carnet: carnet,
                      
                      lote: lote,
                      cantidad: cantidad, 
                      subtotal: subtotal     
                 },
                 error: function(resp){
                   alert(resp);
                 },
                 success: function(resp){
                      if(resp == 1){
                        Swal.fire('Exito..!','venta ingresada correctamente!','success')
                      //  $('#example1').load('casas.php #example1')
                       // $('#modalEditarProducto').modal('toggle');
                        window.location.href = "ventas.php";
                      }
                      else{
                          if(resp == 2){
                            Swal.fire(
                              'Error!',
                              'Ha ocurrido un error al registrar el detalle de la venta!',
                              'error'
                            ) 
                          }    
                          else{
                          if(resp == 3){
                            Swal.fire(
                              'Error!',
                              'Ha ocurrido un error al registrar la venta!',
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
          arreglo_total.push($(this).find('td').eq(4).text());
          count++;
        })
        for(var i = 0; i < count; i++){
          var suma = arreglo_total[i];
          total = (parseFloat(total) + parseFloat(suma)).toFixed(2);
        }
        $("#lbl_totalNeto").html("<b>Total venta:</b> Bs/. " +total);
      }


      function calcularTotalventa(){
        var cantidad = $('#cantidad').val();
        var precio = $('#precioVenta').val();

        var operacion = cantidad * precio;
        $('#subtotal').val(operacion);
      }

    function IngresarProducto(){

        var lote = $('#lote').val();
        var producto = $('#producto').val();
        var cantidad = $('#cantidad').val();
        var precio = $('#precioVenta').val();
        var subtotal = $('#subtotal').val();

       

        if(producto == "" || cantidad == "" || precioVenta == "" || subtotal == ""){
          swal.fire('Campos Vacios..!','Debe rellenar todos campos','warning')
          return false;
        }

        if( parseInt(cantidad) < 1){
          swal.fire('Ops..!','La cantidad debe ser mayor a cero','warning')
          return false;
        }

        if( parseFloat(precio) <= 0){
          swal.fire('Ops..!','El precio debe ser mayor a cero','warning')
          return false;
        }

        $.ajax({   
                 url:'../clases/Cl_ventas.php?op=ValidarStock',
                 type:'POST',
                 data:{                    
                  cantidad: cantidad,
                  lote: lote   
                 },
                 error: function(resp){
                   alert(resp);
                 },
                 success: function(resp){
                    
                      if(resp == 2){
                        Swal.fire('Sin Stock..!','El producto indicado no tiene el stock suficiente para completar la venta','warning')
                      }
                      else{
                          if(resp == 1){
                            let datos_agregar = "<tr>";
                            datos_agregar+="<td for='id'>"+lote+"</td>";
                            datos_agregar+="<td>"+producto+"</td>";
                            datos_agregar+="<td>"+cantidad+"</td>";
                            datos_agregar+="<td>"+precio+"</td>";
                            datos_agregar+="<td>"+subtotal+"</td>";
                            datos_agregar+="<td><button class='btn btn-danger' onclick='Remover(this)'><i title='Eliminar' class='nav-icon fas fa-trash-alt'></button></td>";
                            $("#RellenarTabla").append(datos_agregar);
                            sumarColumnaTotal();

                            $('#lote').val("");
                            $('#producto').val("");
                            $('#cantidad').val("0");
                            $('#precioVenta').val("0");
                            $('#subtotal').val("0");     
                          }          
                      }
                 }
            });             
         
       
    }

      
       function DatosProducto(id,producto,unidad,precio){
            var NombreProducto = producto+' '+unidad;
            $("#ModalBucarProducto .close").click()         
            $('#lote').val(id);
            $("#producto").val(NombreProducto);   
            $("#precioVenta").val(precio);         
        }

        function ObtenerIdventa(){
 
          $.ajax({                
                 url:'../clases/Cl_ventas.php?op=obtenerIdventa',
                 type:'POST',              
                 error: function(resp){
                   alert(resp);
                 },
                 success: function(resp){
    
                      if(resp != ""){
                        $idcom= parseInt(resp) + 1;
                        $('#idventa').val($idcom);
                      }
                      else{                          
                        $('#idventa').val(1);
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
