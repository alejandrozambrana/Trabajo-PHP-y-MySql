<?php
error_reporting(E_ALL ^ E_NOTICE); //no muestra error de variables indefinida
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>MilField Player</title>
    <link rel="shortcut icon" type="image/png" href="imagen/logo.png"/>
    <!--bootstrap-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS de Bootstrap -->
    <link href="bootstrap/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <!--css propio-->
    <link href="css/estilos.css" rel="stylesheet"> 
  </head>
  <body>
    <?php
      //comprueba si se establece conexion con mysql
      try {
        $conexion = new PDO("mysql:host=localhost;dbname=midfieldplayer;charset=utf8", "root", "root");
      } catch (PDOException $e) {
        echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
        die ("Error: " . $e->getMessage());   
      }
      
      if($_POST['accion'] == "crearUsuario"){
        $inserta = "INSERT INTO usuarios(nomusu, contrausu, correousu) VALUES ('$_POST[usuario]', '$_POST[contrasena]', '$_POST[email]')";
        $conexion->exec($inserta);
        header("Refresh: 0; url=index.php");//esto redirecciona a otra pagina
      }
    ?>
      <div class="tituloLogin" class="col-xs-12 col-sm-12 col-md-12">
        <img src="imagen/logoNombre.png" name="MidField Player" alt="MidField Player" width="350" >
      </div>
    
      <div id="login">
        <h1 style="color: white; margin-bottom: 30px;">Reguistrate</h1>
        <form action="registrate.php" method="POST">
          <label for="usuarioId">Nombre de usuario</label><br>
          <input type="text" name="usuario" class="form-control center-block" id="usuarioId" autofocus required="required"></br>
          <label for="contrasenaId">Contraseña</label><br>
          <input type="password" name="contrasena" class="form-control center-block" id="contrasenaId" required="required" ></br>
          <label for="email">Email</label><br>
          <input type="email" name="email" class="form-control center-block" id="email" required="required"></br>
          <input type="hidden" name="accion" value="crearUsuario" >
          <button type="submit" class="btn btn-default" name="action" style="color: black;">Crear 
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
          </button>
        </form>
      </div>
  </body>
</html>
