<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
  <head>
    <meta charset="UTF-8">
    <title>MilField Player</title>
    <link rel="shortcut icon" type="image/png" href="imagen/logo.png"/>
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
    
      $codigo = $_GET['codigo'];
      $tabla = $_GET['tabla'];
      $campoTabla = $_GET['campoTabla'];
      $pagina = $_GET['pagina'];

      $borra = "DELETE FROM $tabla WHERE $campoTabla=$codigo";
      $conexion->exec($borra);
      header("Refresh: 0; url='$pagina'");//esto redirecciona a otra pagina
    ?>
  </body>
</html>
