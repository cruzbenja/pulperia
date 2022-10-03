<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href = "https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap "rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/css/all.css">
     <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
     <!-- SweetAlert2 -->
     <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <title>Inicio Sesion</title>
</head>
<body>
    <img class="wave" src="../img/wave.png" alt="">
    <div class="contenedor">
        <div class="img">
            <img src="../img/tienda.svg" alt="" >
        </div>
        <div class="contenido-login">
            <form method="POST">
                <img src="../img/carrito.png" alt="">
                <h2>Tienda Online</h2>
                <div class="input-div dni">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Usuario</h5>
                        <input type="text" id="usuario" class="input"> 
                    </div>
                </div> 
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Contraseña</h5>
                        <input type="password" id="contra" class="input"> 
                    </div>
                </div> 
                <br>
              
                <button type="button" class="btn"  onclick="autenticacion()">INICIAR SESION</button>
               
            </form>
           
        </div>
    </div>


    <script>

    function autenticacion(){

      var usuario = $("#usuario").val();
      var password = $("#contra").val();
               if(usuario == "" || password == ""){
                   return swal.fire("Datos incompletos","Debe ingresar el usuario y la contraseña","warning");
               }
                
               $.ajax({                
                   url:'../clases/Cl_inicioSesion.php',
                   type:'POST',
                   data:{
                       user: usuario,
                       pass: password                    
                   },
                   success: function(resp){
                        if(resp == 1){
                            window.location.href = "../index.php";
                        }
                        else{
                            if(resp == 2){
                                swal.fire('Ops..!','Usuario y/o contraseña incorrectos','error');
                            }
                            else{
                              if(resp == 3){
                                swal.fire('Error..!','Usuario ingresado no existe o la cuenta a sido suspendida','error');
                              }
                            }
                        }
                   }
              });                   
    }


</script>
</body>
<script src="../js/login.js"></script>
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</html>