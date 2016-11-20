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
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
    <!--css propio-->
    <link href="../css/estilosCliente.css" rel="stylesheet"> 
    <!--fuente personalizada para titulo 3D-->
    <style>
      @import url('https://fonts.googleapis.com/css?family=PT+Serif');
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
      <div id="logo">
        <a href="../menu.php"><img src="../imagen/logo.png" name="MidField Player" alt="MidField Player" width="120" ></a>
      </div>
    <?php
      //deja acceder si estas logueado
      if($_SESSION['logueado'] == true && $_SESSION['tipoUsuario'] == "cliente"){
    ?>
        <!--barra de navegacion-->
        <div class="barraNavegacion">	
          <nav>
            <!--boton menu-->
            <label for="opcionesOcultas" id="botonMenu"><span class="sprite sprite-menu"></span></label>
            <input type="checkbox" id="opcionesOcultas" class="oculto" />
            <div class="opcionesOcultas">
              <ul>
                <li><a href="../menu.php"><b><span class="sprite sprite-home"></span> MilField Player</b></a></li>
                <li id="activate"><a href="jugadores.php"><span class="sprite sprite-persona"></span> Jugadores</a></li>
                <li><a href="equipos.php"><span class="sprite sprite-equipos"></span> Equipos</a></li>
                <li><a href="posiciones.php"><span class="sprite sprite-posicion"></span> Posiciones</a></li>
                <li><a href="nacionalidad.php"><span class="sprite sprite-nacionalidad"></span> Nacionalidades</a></li>  
              </ul>
              <ul class="menuBotonDerecha">
                <li><a href="#"><span class="sprite sprite-persona"></span> <?=$_SESSION['usuario']?> <span class="sprite sprite-abajo"></span></a>
                  <ul>
                    <li><a href="../index.php">Salir<span class="sprite sprite-salir"></span></a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
        </div>
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
    ?>
      <!--crea una tabla con los datos-->
      <h1 id="titulo3D">Jugadores</h1>
      <div class="flex-container flex-row">
    <?php
    
        //saca los equipos por pagina
        $listadojugadores = "SELECT * FROM jugadores ORDER BY codjug LIMIT ".(($_SESSION['paginas'] - 1) * 5).", 5";
        $consulta = $conexion->query($listadojugadores);

        //con este while saca todos los datos de la consulta
        while ($jugadores = $consulta -> fetchObject() ) {
    ?>
            <div class="flex-item">
              <p><b>Codigo: </b> <?= $jugadores->codjug ?></p>
              <p><b>Nombre: </b><?= $jugadores->nomjug ?></p>
    <?php
            //saca los equipos
            $listadoequipos = "SELECT * FROM equipo WHERE codequi=$jugadores->equipojug";
            $consultaequipo = $conexion->query($listadoequipos);
            while ($equipo = $consultaequipo -> fetchObject() ) {
    ?>
              <p><b>Equipo: </b><?=$equipo->nomequi?></p>
    <?php                
            }
    ?>
              <p><b>Dorsal: </b><?= $jugadores->dorsaljug ?></p>
              <p><b>Edad: </b><?= $jugadores->edadjug ?> Años</p>
              <p><b>Altura: </b><?= $jugadores->alturajug ?> Cm </p>
              <p><b>Peso: </b><?= $jugadores->pesojug ?> Kg</p>
    <?php
            //saca los equipos
            $listadonacionalidad = "SELECT * FROM nacionalidad WHERE codnac=$jugadores->codnac";
            $consultaNacionalidad = $conexion->query($listadonacionalidad);
            while ($nacionalidad = $consultaNacionalidad -> fetchObject() ) {
    ?>
              <p><b>Nacionalidad: </b><?=$nacionalidad->pais?></p>
    <?php                
            }
            //saca los equipos
            $listadoPosiciones = "SELECT * FROM posicion WHERE codpos=$jugadores->codpos";
            $consultaPosiciones = $conexion->query($listadoPosiciones);
            while ($posiciones = $consultaPosiciones -> fetchObject() ) {
    ?>
              <p><b>Posicion: </b><?= $posiciones->posicion ?></p>
    <?php
            }
    ?>
            </div>
    <?php
          } //cierra while
    ?>
        </table>
      </div>
      
      <div>
        <table>
          <!-- Botones para pasar las páginas -->
          <tr>
            <td colspan="2">Página <?=$_SESSION['paginas']?> de <?=$numPaginas?></td>
          </tr>
          <!-- Anterior -->
          <tr>
            <td>
              <form action="jugadores.php" method="POST">
                <button type="submit" class="botonPasarPagina" name="paginas" value="Anterior"><span class="sprite sprite-left"></span> Anterior</button>
              </form>
            </td>
          <!-- Siguiente -->
            <td>
              <form action="jugadores.php" method="POST">
                <button type="submit" class="botonPasarPagina" name="paginas" value="Siguiente">Siguiente <span class="sprite sprite-right"></span></button>
              </form>
            </td>
          </tr>
        </table>
      </div>
      <button class="botonVolver">
        <span class="sprite sprite-volver"></span>
        <a href="../menu.php"> Volver</a>
      </button>
    <?php  
      } else {
    ?>
        <!--css propio-->
        <link href="css/estilosCliente.css" rel="stylesheet"> 
        <div id="titulo3D">logueate</div>
    <?php
      }     
    ?>
  </body>
</html>
