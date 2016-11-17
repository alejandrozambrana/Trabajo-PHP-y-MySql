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
    <!--css propio-->
    <link href="../css/estilosCliente.css" rel="stylesheet"> 
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
        <img src="../imagen/logo.png" name="MidField Player" alt="MidField Player" width="120" >
      </div>
    <?php
      //deja acceder si estas logueado
      if($_SESSION['logueado'] == true && $_SESSION['tipoUsuario'] == "cliente"){
    ?>
        <div class="barraNavegacion">	
          <nav>
            <ul>
              <li><a href="../menu.php"><b><span class="sprite sprite-home"></span> MilField Player</b></a></li>
              <li><a href="jugadores.php"><span class="sprite sprite-persona"></span> Jugadores</a></li>
              <li><a href="equipos.php"><span class="sprite sprite-equipos"></span> Equipo</a></li>
              <li><a href="posiciones.php"><span class="sprite sprite-posicion"></span> Posiciones</a></li>
              <li><a href="nacionalidad.php"><span class="sprite sprite-nacionalidad"></span> Nacionalidad</a></li>  
            </ul>
            <ul class="menuBotonDerecha">
              <li><a href="#"><span class="sprite sprite-persona"></span> <?=$_SESSION['usuario']?> <span class="sprite sprite-abajo"></span></a>
                <ul>
                  <li><a href="../index.php">Salir<span class="sprite sprite-salir"></span></a></li>
                </ul>
              </li>
            </ul>
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
      <h1 style="text-align: center;">Jugadores</h1>
      <table>
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
        } //cierra while
    ?>
      </table>
      
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
                <button type="submit" name="paginas" value="Anterior">Anterior</button>
              </form>
            </td>
          <!-- Siguiente -->
            <td>
              <form action="jugadores.php" method="POST">
                <button type="submit" name="paginas" value="Siguiente">Siguiente</button>
              </form>
            </td>
          </tr>
        </table>
      </div>
      <a href="../menu.php">ir al menu</a>
    <?php  
      } else {
        echo "logueate";
      }     
    ?>
  </body>
</html>
