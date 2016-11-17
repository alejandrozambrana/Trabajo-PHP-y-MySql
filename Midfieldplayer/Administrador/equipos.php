<?php
error_reporting(E_ALL ^ E_NOTICE); //no muestra error de variables indefinida
session_start();// Inicia la sesión
if(!isset($_SESSION['paginas'])) {
    $_SESSION['paginas'] = 1;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>MilField Player</title>
    <link rel="shortcut icon" type="image/png" href="../imagen/logo.png"/>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/funciones.js"></script>
    <!--Estos dos enlaces son para el cuadro de dialogo-->
    <script src="../js/jquery-ui.js"></script>
    <link rel="stylesheet" href="../js/jquery-ui.css">
    <!--bootstrap-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS de Bootstrap -->
    <link href="../bootstrap/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <!--css propio-->
    <link href="../css/estilos.css" rel="stylesheet"> 
    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
    incluir archivos JavaScript individuales de los únicos
    plugins que utilices) -->
    <script src="../bootstrap/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <script>
      //funcion para eliminar 
      function eliminar(){
      var respuesta=confirm("¿Deseas borrar a este Equipo?");
      if(respuesta==true){
        return true;
      }else{
        return false;
      }
    }
    </script>
    <style>

    </style>
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
    ?>
      <div id="logo" class="col-xs-12 col-sm-12 col-md-12">
        <a href="../menu.php"><img src="../imagen/logo.png" name="MidField Player" alt="MidField Player" width="100" ></a>
      </div>
    <?php
      //deja acceder si estas logueado
      if($_SESSION['logueado'] == true && $_SESSION['tipoUsuario'] == "administrador"){
    ?>
        <!--barra de navegacion -->
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="../menu.php"><span class="glyphicon glyphicon-home"></span> MilField Player</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li><a href="jugadores.php"><span class="glyphicon glyphicon-user"></span> Jugadores</a></li>
                <li class="active"><a href="equipos.php"><span class="glyphicon glyphicon-copy"></span> Equipos</a></li>
                <li><a href="posiciones.php"><span class="glyphicon glyphicon-transfer"></span> Posiciones</a></li>
                <li><a href="nacionalidad.php"><span class="glyphicon glyphicon-list"></span> Nacionalidad</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> <?=$_SESSION['usuario']?> <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li style="text-align: center;"><a href="../index.php">Salir <span class="glyphicon glyphicon-remove"></span></a></li>
                  </ul>
                </li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
    <?php    
        //con esto se realiza una consulta
        $consulta = $conexion -> query("select * from equipo"); 

        // Determina la página que se muestra
        $numequipos = $consulta ->rowCount();
        $numPaginas = floor(abs($numequipos - 1) / 5) + 1;
        
        $paginas = $_POST['paginas'];

        //incrementa la pagina
        if ($paginas == "Siguiente" && $_SESSION['paginas'] < $numPaginas) {
          $_SESSION['paginas']++;
        }
        //decrementa la pagina
        if ($paginas == "Anterior" && $_SESSION['paginas'] > 1) {
          $_SESSION['paginas']--;
        }
        //si la session pagina tiene un nimero de pagina mayor a las que hay la pone en la pagina 1
        if($numPaginas <  $_SESSION['paginas']){
           $_SESSION['paginas'] = 1;
        }
        
        //añade un nuevo equipo
        if($_POST['accion'] == "anadirEquipo") {
            // Comprueba si existe el DNI
            $buscaCodigo = 'SELECT * FROM equipo WHERE codequi="'.$_POST[codequi].'"';
            $consulta = $conexion -> query($buscaCodigo); 

           if ($consulta ->rowCount() == 1) {
             echo '<script type="text/javascript">alert("Lo siento, ya existe un equipo con ese código en la base de datos");</script>';
           } else {
            $inserta = "INSERT INTO equipo VALUES (\"$_POST[codequi]\", \"$_POST[nomequi]\")";
            $conexion->exec($inserta);
            header("Refresh: 0; url=equipos.php");//esto redirecciona a otra pagina
          }
        }
        //modifica un equipo
        if($_POST['accion'] == "aplicarModificacion") {
          $modificacion = "UPDATE equipo SET nomequi='$_POST[nomequi]' WHERE codequi=$_POST[codequi]";
          $conexion->exec($modificacion);
          header("Refresh: 0; url=equipos.php");//esto redirecciona a otra pagina
        }
        
    ?>
      <!--crea una tabla con los datos-->
      <div class="col-xs-12 col-sm-12 col-md-12">
        <h1 id="tituloAdmin">Equipos</h1>
      </div>
      <div id="tabla" class="table-responsive">
        <table class="table table-striped">
          <tr>
            <td><b>Codigo</b></td>
            <td><b>Nombre de equipo</b></td>
            <td></td>
            <td></td>
          </tr>
      <?php

        //saca los equipos por pagina
        $listadoequipos = "SELECT * FROM equipo ORDER BY codequi LIMIT ".(($_SESSION['paginas'] - 1) * 5).", 5";
        $consulta = $conexion->query($listadoequipos);

        //con este while saca todos los datos de la consulta
        while ($equipos = $consulta -> fetchObject() ) {

          if($_POST['accion'] == "modificar" && $_POST['codigo'] == $equipos->codequi){
      ?>
            <tr> 
              <form action="equipos.php" method="POST">
                <input type="hidden" name="codequi" value="<?=$equipos->codequi?>">
                <td><?=$equipos->codequi?></td>
                <td><input type="text" class="form-control modificarInput" name="nomequi" value="<?=$equipos->nomequi?>"></td>
                <input type="hidden" name="accion" value="aplicarModificacion">
                <td></td>
                <td><button class="btn btn-info">
                    <span class="glyphicon glyphicon-send"></span> Aplicar
                  </button></td>
              </form>
            </tr>
      <?php
            } else {
      ?>
            <tr>
              <td><?= $equipos->codequi ?></td>
              <td><?= $equipos->nomequi ?></td>
              <td>
                <!--boton eliminar-->
                <form onsubmit="equipos.php" method="POST">
                  <input type="hidden" id="codigoId" name="codigo" value="<?=$equipos->codequi?>">  
                  <button class="btn btn-danger">
                    <span class="glyphicon glyphicon-trash"></span>
                    <a onclick="return eliminar()" id="botonEliminar" href="eliminar.php?codigo=<?= $equipos->codequi?>&tabla=equipo&campoTabla=codequi&pagina=equipos.php">Eliminar</a>
                  </button>
                </form>
              </td>
              <td>
                <!--boton modificar-->
                <form action="equipos.php" method="POST">
                  <input type="hidden" name="codigo" value="<?=$equipos->codequi?>">
                  <input type="hidden" name="nombre" value="<?=$equipos->nomequi?>">
                  <input type="hidden" name="accion" value="modificar">
                  <button class="btn btn-info" value="Modificar">
                    <span class="glyphicon glyphicon-pencil"></span> Modificar
                  </button>
                </form>
              </td>
            </tr>
      <?php
            } //cierra else
          } //cierra while
      ?>
        </table>
      </div>
      
      <!--boton añadir-->
      <button id="añadir" class="btn btn-info botonAnadir"><span class="glyphicon glyphicon-plus"></span></button>
      
      <!--Cuadro de dialogo añadir-->
      <div id="cuadroAñadir" title="Añadir Equipo" hidden>
        <table>
          <form action="equipos.php" method="POST">
            <div class="form-group">
              <tr><td><b><label for="codigoId">Codigo Equipo</label><br>
                <input type="number" class="form-control" name="codequi" id="codigoId" min="1" step="1" autocomplete required></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="nombreId">Nombre Equipo</label><br>
                <input type="text" class="form-control" name="nomequi" id="nombreId"></b></td></tr>
            </div>
            <tr><td><button class="btn btn-info botonCuadroAnadir" type="submit" name="accion" value="anadirEquipo">Añadir
                <span class="glyphicon glyphicon-send"></span>
                </button></td></tr>
          </form>
        </table>
      </div>
      <!--------termina cuadro de dialogo---------->
      
      <div id="botonesPaginas" class="table-responsive">
        <table class="table table-striped">
          <!-- Botones para pasar las páginas -->
          <tr>
            <td colspan="2">Página <?=$_SESSION['paginas']?> de <?=$numPaginas?></td>
          </tr>
          <!-- Anterior -->
          <tr>
            <td>
              <form action="equipos.php" method="POST">
                <button type="submit" class="btn btn-info" name="paginas" value="Anterior">
                  <span class="glyphicon glyphicon-arrow-left"></span> Anterior
                </button>
              </form>
            </td>
          <!-- Siguiente -->
            <td>
              <form action="equipos.php" method="POST">
                <button type="submit" class="btn btn-info" name="paginas" value="Siguiente">
                  Siguiente <span class="glyphicon glyphicon-arrow-right"></span>
                </button>
              </form>
            </td>
          </tr>
        </table>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
        <button class="btn btn-default">
          <span class="glyphicon glyphicon-repeat"></span>
          <a href="../menu.php" id="botonVolver"> Volver</a>
        </button>
      </div>
    <?php  
      } else {
        echo "logueate";
      }     
    ?>
  </body>
</html>
