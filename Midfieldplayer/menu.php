<?php
error_reporting(E_ALL ^ E_NOTICE); //no muestra error de variables indefinida
session_start();// Inicia la sesión
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
    
    <!-- Librería jQuery requerida por los plugins de JavaScript -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
    incluir archivos JavaScript individuales de los únicos
    plugins que utilices) -->
    <script src="bootstrap/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php
    //deja acceder si estas logueado
      if($_SESSION['logueado'] == true && $_SESSION['tipoUsuario'] == "administrador"){
    ?>  
        <!--logo-->
        <div id="logo" class="col-xs-12 col-sm-12 col-md-12">
          <a href="menu.php"><img src="imagen/logoNombre.png" name="MidField Player" alt="MidField Player" width="350" ></a>
        </div>
        
        <!--css propio-->
        <link href="css/estilos.css" rel="stylesheet"> 
        
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
              <a class="navbar-brand" href="menu.php"><span class="glyphicon glyphicon-home"></span> MilField Player</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li><a href="Administrador/jugadores.php"><span class="glyphicon glyphicon-user"></span> Jugadores</a></li>
                <li><a href="Administrador/equipos.php"><span class="glyphicon glyphicon-copy"></span> Equipos</a></li>
                <li><a href="Administrador/posiciones.php"><span class="glyphicon glyphicon-transfer"></span> Posiciones</a></li>
                <li><a href="Administrador/nacionalidad.php"><span class="glyphicon glyphicon-list"></span> Nacionalidad</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> <?=$_SESSION['usuario']?> <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li style="text-align: center;"><a href="index.php">Salir <span class="glyphicon glyphicon-remove"></span></a></li>
                  </ul>
                </li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
        
        <!-- Carousel
        ================================================== -->
       <div class="container">
          <br>
          <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
              <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
              <li data-target="#myCarousel" data-slide-to="1"></li>
              <li data-target="#myCarousel" data-slide-to="2"></li>
              <li data-target="#myCarousel" data-slide-to="3"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">

              <div class="item active">
                <img src="imagen/carousel/carousel.png" alt="MilfieldPlayer" width="160" height="345">
                <div class="carousel-caption">
                  <h3 style="color: black;">Milfield Player</h3>
                  <p style="color: black;">Es una aplicacion en la que podras formar tu propio equipo hasta llegar a ser el mejor.</p>
                </div>
              </div>

              <div class="item">
                <img src="imagen/carousel/carousel1.jpg" alt="Chania" width="460" height="345">
                <div class="carousel-caption">
                  <h3>Milfield Player</h3>
                  <p>Ficha a los mejores jugadores de la liga.</p>
                </div>
              </div>

              <div class="item">
                <img src="imagen/carousel/carousel2.jpg" alt="Flower" width="460" height="345">
                <div class="carousel-caption">
                  <h3>Milfield Player</h3>
                  <p>Gana Puntos al ganas partidos.</p>
                </div>
              </div>

              <div class="item">
                <img src="imagen/carousel/carousel3.jpg" alt="Flower" width="460" height="345">
                <div class="carousel-caption">
                  <h3>Milfield Player</h3>
                  <p>Juega con tus amigos.</p>
                </div>
              </div>

            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div><!-- /.carousel -->
    <?php
      } else if($_SESSION['logueado'] == true && $_SESSION['tipoUsuario'] == "cliente"){
    ?>
        <!--css propio-->
        <link href="css/estilosCliente.css" rel="stylesheet"> 
        <!--logo-->
        <div id="logo">
          <a href="menu.php"><img src="imagen/logoNombre.png" name="MidField Player" alt="MidField Player" width="350px" ></a>
        </div>
        <!--barra de navegacion-->
        <div class="barraNavegacion">	
          <nav>
            <!--boton menu-->
            <label for="opcionesOcultas" id="botonMenu"><span class="sprite sprite-menu"></span></label>
            <input type="checkbox" id="opcionesOcultas" class="oculto" />
            <div class="opcionesOcultas">
              <ul>
                <li><a href="menu.php"><b><span class="sprite sprite-home"></span> MilField Player</b></a></li>
                <li><a href="Cliente/jugadores.php"><span class="sprite sprite-persona"></span> Jugadores</a></li>
                <li><a href="Cliente/equipos.php"><span class="sprite sprite-equipos"></span> Equipos</a></li>
                <li><a href="Cliente/posiciones.php"><span class="sprite sprite-posicion"></span> Posiciones</a></li>
                <li><a href="Cliente/nacionalidad.php"><span class="sprite sprite-nacionalidad"></span> Nacionalidades</a></li>  
              </ul>
              <ul class="menuBotonDerecha">
                <li><a href="#"><span class="sprite sprite-persona"></span> <?=$_SESSION['usuario']?> <span class="sprite sprite-abajo"></span></a>
                  <ul>
                    <li><a href="index.php">Salir<span class="sprite sprite-salir"></span></a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
        </div>
        
        <!-------------Carousel------------>
        <div class="carousel">
          <img class="imagen" src="imagen/carousel/carousel.png" width="100%" height="100%" />
          <img class="imagen" src="imagen/carousel/carousel1.jpg" width="100%" height="100%" />
          <img class="imagen" src="imagen/carousel/carousel2.jpg" width="100%" height="100%"/>
          <img class="imagen" src="imagen/carousel/carousel3.jpg" width="100%" height="100%"/>
        </div>
        
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
