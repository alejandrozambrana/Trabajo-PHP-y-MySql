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
      var respuesta=confirm("¿Deseas borrar esta Posicion?");
      if(respuesta==true){
        return true;
      }else{
        return false;
      }
    }
    </script>
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
                <li><a href="equipos.php"><span class="glyphicon glyphicon-copy"></span> Equipos</a></li>
                <li class="active"><a href="posiciones.php"><span class="glyphicon glyphicon-transfer"></span> Posiciones</a></li>
                <li><a href="nacionalidad.php"><span class="glyphicon glyphicon-list"></span> Nacionalidades</a></li>
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
        $consulta = $conexion -> query("select * from posicion"); 

        // Determina la página que se muestra
        $numposiciones = $consulta ->rowCount();
        $numPaginas = floor(abs($numposiciones - 1) / 5) + 1;
        
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
        if($_POST['accion'] == "anadirPosicion") {
            // Comprueba si existe el DNI
            $buscaCodigo = 'SELECT * FROM posicion WHERE codpos="'.$_POST[codpos].'"';
            $consulta = $conexion -> query($buscaCodigo); 

           if ($consulta ->rowCount() == 1) {
             echo '<script type="text/javascript">alert("Lo siento, ya existe una poscion con ese código en la base de datos");</script>';
           } else {
            $inserta = "INSERT INTO posicion VALUES (\"$_POST[codpos]\", \"$_POST[posicion]\")";
            $conexion->exec($inserta);
            header("Refresh: 0; url=posiciones.php");//esto redirecciona a otra pagina
          }
        }
        //modifica un equipo
        if($_POST['accion'] == "aplicarModificacion") {
          $modificacion = "UPDATE posicion SET posicion='$_POST[posicion]' WHERE codpos=$_POST[codpos]";
          $conexion->exec($modificacion);
          header("Refresh: 0; url=posiciones.php");//esto redirecciona a otra pagina
        }
        
    ?>
      <!--crea una tabla con los datos-->
      <div class="col-xs-12 col-sm-12 col-md-12">
        <h1 id="tituloAdmin">Posiciones</h1>
      </div>
      <div id="tabla" class="table-responsive">
        <table class="table table-striped">
          <tr>
            <td><b>Codigo</b></td>
            <td><b>Posicion</b></td>
            <td></td>
            <td></td>
          </tr>
    <?php
    
      //saca las posiciones por pagina
      $listadoNacionalidad = "SELECT * FROM posicion ORDER BY codpos LIMIT ".(($_SESSION['paginas'] - 1) * 5).", 5";
      $consulta = $conexion->query($listadoNacionalidad);

      //con este while saca todos los datos de la consulta
      while ($posicion = $consulta -> fetchObject() ) {
        
        if($_POST['accion'] == "modificar" && $_POST['codigo'] == $posicion->codpos){
    ?>
          <tr> 
            <form action="posiciones.php" method="POST">
              <input type="hidden" name="codpos" value="<?=$posicion->codpos?>">
              <td><?=$posicion->codpos?></td>
              <td><input type="text" class="form-control modificarInput" name="posicion" value="<?=$posicion->posicion?>"></td>
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
            <td><?= $posicion->codpos ?></td>
            <td><?= $posicion->posicion ?></td>
            <td>
              <!--boton eliminar-->
              <form onsubmit="posiciones.php" method="POST">
                <input type="hidden" id="codigoId" name="codigo" value="<?=$posicion->codpos?>">  
                <button class="btn btn-danger">
                  <span class="glyphicon glyphicon-trash"></span>
                  <a onclick="return eliminar()" id="botonEliminar" href="eliminar.php?codigo=<?= $posicion->codpos?>&tabla=posicion&campoTabla=codpos&pagina=posiciones.php">Eliminar</a>
                </button>
              </form>
            </td>
            <td>
              <!--boton modificar-->
              <form action="posiciones.php" method="POST">
                <input type="hidden" name="codigo" value="<?=$posicion->codpos?>">
                <input type="hidden" name="nombre" value="<?=$posicion->posicion?>">
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
      <div id="cuadroAñadir" title="Añadir Posicion" hidden>
        <table>
          <form action="posiciones.php" method="POST">
            <div class="form-group">
              <tr><td><b><label for="codigoId">Codigo Posicion</label><br>
                <input type="number" name="codpos" id="codigoId" min="1" step="1" autocomplete required></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="nombreId">Posicion</label><br>
                 <input type="text" name="posicion" id="nombreId"></b></td></tr>
            </div>
            <tr><td><button class="btn btn-info botonCuadroAnadir" type="submit" name="accion" value="anadirPosicion">Añadir
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
              <form action="posiciones.php" method="POST">
                <button type="submit" class="btn btn-info" name="paginas" value="Anterior">
                  <span class="glyphicon glyphicon-arrow-left"></span> Anterior
                </button>
              </form>
            </td>
          <!-- Siguiente -->
            <td>
              <form action="posiciones.php" method="POST">
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
