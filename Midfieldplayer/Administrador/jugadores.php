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
      var respuesta=confirm("¿Deseas borrar a este Jugador?");
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
                <li class="active"><a href="jugadores.php"><span class="glyphicon glyphicon-user"></span> Jugadores</a></li>
                <li><a href="equipos.php"><span class="glyphicon glyphicon-copy"></span> Equipos</a></li>
                <li><a href="posiciones.php"><span class="glyphicon glyphicon-transfer"></span> Posiciones</a></li>
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
        $consulta = $conexion -> query("select * from jugadores"); 

        // Determina la página que se muestra
        $numjugadores = $consulta ->rowCount();
        $numPaginas = floor(abs($numjugadores - 1) / 5) + 1;
        
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
        
        //añade un nuevo jugador
        if($_POST['accion'] == "anadirJugador") {
            $inserta = "INSERT INTO jugadores (nomjug, equipojug, dorsaljug, edadjug, alturajug, pesojug, codnac, codpos) VALUES (\"$_POST[nomjug]\", \"$_POST[equipojug]\", \"$_POST[dorsaljug]\", \"$_POST[edadjug]\", \"$_POST[alturajug]\", \"$_POST[pesojug]\", \"$_POST[codnac]\", \"$_POST[codpos]\")";
            $conexion->exec($inserta);
            header("Refresh: 0; url=jugadores.php");//esto redirecciona a otra pagina
        }
        //modifica un jugador
        if($_POST['accion'] == "aplicarModificacion") {
          $modificacion = "UPDATE jugadores SET nomjug='$_POST[nomjug]', equipojug='$_POST[equipojug]', dorsaljug='$_POST[dorsaljug]', edadjug='$_POST[edadjug]', alturajug='$_POST[alturajug]', pesojug='$_POST[pesojug]', codnac='$_POST[codnac]', codpos='$_POST[codpos]' WHERE codjug='$_POST[codjug]'";
          $conexion->exec($modificacion);
          header("Refresh: 0; url=jugadores.php");//esto redirecciona a otra pagina
        }
        
    ?>
      <!--crea una tabla con los datos-->
      <div class="col-xs-12 col-sm-12 col-md-12">
        <h1 id="tituloAdmin">Jugadores</h1>
      </div>
      <div id="tabla" class="table-responsive">
        <table class="table table-striped">
          <tr>
            <td><b>Codigo</b></td>
            <td><b>Nombre</b></td>
            <td><b>Equipo</b></td>
            <td><b>Dorsal</b></td>
            <td><b>Edad</b></td>
            <td><b>Altura</b></td>
            <td><b>Peso</b></td>
            <td><b>Nacionalidad</b></td>
            <td><b>Posicion</b></td>
            <td></td>
            <td></td>
          </tr>
    <?php
    
      //saca los equipos por pagina
      $listadojugadores = "SELECT * FROM jugadores ORDER BY codjug LIMIT ".(($_SESSION['paginas'] - 1) * 5).", 5";
      $consulta = $conexion->query($listadojugadores);

      //con este while saca todos los datos de la consulta
      while ($jugadores = $consulta -> fetchObject() ) {
        
        if($_POST['accion'] == "modificar" && $_POST['codigo'] == $jugadores->codjug){
    ?>
          <tr> 
            <form action="jugadores.php" method="POST">
              <input type="hidden" name="codjug" value="<?=$jugadores->codjug?>">
              <td><?=$jugadores->codjug?></td>
              <td><input type="text" class="form-control modificarInput" size="10" name="nomjug" value="<?=$jugadores->nomjug?>"></td>
              <td><select name="equipojug" class="form-control tamañoSelect" id="equipoId" required>
    <?php
                //saca los equipos
                $listadoequipos = "SELECT * FROM equipo";
                $consultaequipo = $conexion->query($listadoequipos);
                while ($equipo = $consultaequipo -> fetchObject() ) {
                  //si el codigo de equipo es igual al que tiene el jugador lo seleciona
                  if($equipo->codequi == $jugadores->equipojug){
    ?>
                    <option value="<?=$equipo->codequi?>" selected><?=$equipo->nomequi?></option>
    <?php                
                  }else{
    ?>
                    <option value="<?=$equipo->codequi?>"><?=$equipo->nomequi?></option>
    <?php 
                  }
                }
    ?>
              </select></b></td>
              <td><input type="text" class="form-control" id="modificarInputJugadores" name="dorsaljug" value="<?=$jugadores->dorsaljug?>"></td>
              <td><input type="text" class="form-control" id="modificarInputJugadores" name="edadjug" value="<?=$jugadores->edadjug?>"></td>
              <td><input type="text" class="form-control" id="modificarInputJugadores" name="alturajug" value="<?=$jugadores->alturajug?>"></td>
              <td><input type="text" class="form-control" id="modificarInputJugadores" name="pesojug" value="<?=$jugadores->pesojug?>"></td>
              <td><select name="codnac" class="form-control tamañoSelectNacPos" id="nacionalidadId" required>
    <?php
              //saca la nacionalidad
              $listadoNacionalidad = "SELECT * FROM nacionalidad";
              $consultanacionalidad = $conexion->query($listadoNacionalidad);
              while ($nacionalidad = $consultanacionalidad -> fetchObject() ) {
                //si el codigo de la nacionalidad es igual al que tiene el jugador lo seleciona
                if($nacionalidad->codnac == $jugadores->codnac){
    ?>
                  <option value="<?=$nacionalidad->codnac?>" selected><?=$nacionalidad->pais?></option>
    <?php                
                }else{
    ?>
                  <option value="<?=$nacionalidad->codnac?>"><?=$nacionalidad->pais?></option>
    <?php 
                }
              }
    ?>
              </select></b></td>
              <td><select name="codpos" class="form-control tamañoSelectNacPos" id="posicionId" required>
    <?php
              //saca las posiciones
              $listadoPosiciones = "SELECT * FROM posicion";
              $consultaposicion = $conexion->query($listadoPosiciones);
              while ($posicion = $consultaposicion -> fetchObject() ) {
                //si el codigo de la posicion es igual al que tiene el jugador lo seleciona
                if($posicion->codpos == $jugadores->codpos){
    ?>
                  <option value="<?=$posicion->codpos?>" selected><?=$posicion->posicion?></option>
    <?php                
                }else{
    ?>
                  <option value="<?=$posicion->codpos?>"><?=$posicion->posicion?></option>
    <?php 
                }
              }
    ?>
              </select></b></td>
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
            <td><?= $jugadores->codjug ?></td>
            <td><?= $jugadores->nomjug ?></td>
    <?php
            //saca los equipos
            $listadoequipos = "SELECT * FROM equipo WHERE codequi=$jugadores->equipojug";
            $consultaequipo = $conexion->query($listadoequipos);
            while ($equipo = $consultaequipo -> fetchObject() ) {
    ?>
              <td><?=$equipo->nomequi?></td>
    <?php                
            }
    ?>
            
            <td><?= $jugadores->dorsaljug ?></td>
            <td><?= $jugadores->edadjug ?> Años</td>
            <td><?= $jugadores->alturajug ?> Cm </td>
            <td><?= $jugadores->pesojug ?> Kg</td>
    <?php
            //saca los equipos
            $listadonacionalidad = "SELECT * FROM nacionalidad WHERE codnac=$jugadores->codnac";
            $consultaNacionalidad = $conexion->query($listadonacionalidad);
            while ($nacionalidad = $consultaNacionalidad -> fetchObject() ) {
    ?>
              <td><?=$nacionalidad->pais?></td>
    <?php                
            }
            //saca los equipos
            $listadoPosiciones = "SELECT * FROM posicion WHERE codpos=$jugadores->codpos";
            $consultaPosiciones = $conexion->query($listadoPosiciones);
            while ($posiciones = $consultaPosiciones -> fetchObject() ) {
    ?>
              <td><?= $posiciones->posicion ?></td>
    <?php
            }
    ?>
            <td>
              <!--boton eliminar-->
              <form onsubmit="jugadores.php" method="POST">
                <input type="hidden" id="codigoId" name="codigo" value="<?=$jugadores->codjug?>">  
                <button class="btn btn-danger">
                  <span class="glyphicon glyphicon-trash"></span>
                  <a onclick="return eliminar()" id="botonEliminar" href="eliminar.php?codigo=<?= $jugadores->codjug?>&tabla=jugadores&campoTabla=codjug&pagina=jugadores.php">Eliminar</a>
                </button>
              </form>
            </td>
            <td>
              <!--boton modificar-->
              <form action="jugadores.php" method="POST">
                <input type="hidden" name="codigo" value="<?=$jugadores->codjug?>">
                <input type="hidden" name="nombre" value="<?=$jugadores->nomjug?>">
                <input type="hidden" name="equipo" value="<?=$jugadores->equipojug?>">
                <input type="hidden" name="dorsal" value="<?=$jugadores->dorsaljug?>">
                <input type="hidden" name="edad" value="<?=$jugadores->edadjug?>">
                <input type="hidden" name="altura" value="<?=$jugadores->alturajug?>">
                <input type="hidden" name="peso" value="<?=$jugadores->pesojug?>">
                <input type="hidden" name="nacionalidad" value="<?=$jugadores->codnac?>">
                <input type="hidden" name="posicion" value="<?=$jugadores->codpos?>">
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
      <div id="cuadroAñadir" title="Añadir Jugador" hidden>
        <table>
          <form action="jugadores.php" method="POST">
            <div class="form-group">
              <tr><td><b><label for="nombreId">Nombre jugador</label><br>
                <input type="text" class="form-control" name="nomjug" id="nombreId" autocomplete required></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="equipoId">Equipo</label><br>
                  <select name="equipojug" class="form-control" id="equipoId" required>
    <?php
              //saca los equipos
              $listadoequipos = "SELECT * FROM equipo";
              $consulta = $conexion->query($listadoequipos);
              while ($equipo = $consulta -> fetchObject() ) {
    ?>
                <option value="<?=$equipo->codequi?>"><?=$equipo->nomequi?></option>
    <?php                
              }
    ?>
                  </select></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="dorsalId">Dorsal</label><br>
                  <input type="number" class="form-control" name="dorsaljug" maxlength="2" min="1" step="1" id="dorsalId"></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="edadId">Edad</label><br>
                  <input type="number" class="form-control" name="edadjug" maxlength="2" min="10" step="1" id="edadId"></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="alturaId">Altura</label><br>
                  <input type="number" class="form-control" name="alturajug" maxlength="3" min="140" step="1" id="alturaId"></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="pesoId">Peso</label><br>
                  <input type="number" class="form-control" name="pesojug" maxlength="2" min="50" step="1" id="pesoId"></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="nacionalidadId">Nacionalidad</label><br>
                  <select name="codnac" class="form-control" id="nacionalidadId" required>
    <?php
              //saca la nacionalidad
              $listadoNacionalidad = "SELECT * FROM nacionalidad";
              $consulta = $conexion->query($listadoNacionalidad);
              while ($nacionalidad = $consulta -> fetchObject() ) {
    ?>
                <option value="<?=$nacionalidad->codnac?>"><?=$nacionalidad->pais?></option>
    <?php                
              }
    ?>
                  </select></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="posicionId">Posicion</label><br>
                  <select name="codpos" class="form-control" id="posicionId" required>
    <?php
              //saca las posiciones
              $listadoPosiciones = "SELECT * FROM posicion";
              $consulta = $conexion->query($listadoPosiciones);
              while ($posicion = $consulta -> fetchObject() ) {
    ?>
                <option value="<?=$posicion->codpos?>"><?=$posicion->posicion?></option>
    <?php                
              }
    ?>
                  </select></b></td></tr>
            </div>
            <tr><td><button class="btn btn-info botonCuadroAnadir" type="submit" name="accion" value="anadirJugador">Añadir
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
              <form action="jugadores.php" method="POST">
                <button type="submit" class="btn btn-info" name="paginas" value="Anterior">
                  <span class="glyphicon glyphicon-arrow-left"></span> Anterior
                </button>
              </form>
            </td>
          <!-- Siguiente -->
            <td>
              <form action="jugadores.php" method="POST">
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
