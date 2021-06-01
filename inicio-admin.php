<!doctype html>
<html>
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>BI & Analytics - IEDUCA </title>
  <link rel="stylesheet" href="css/ieduca.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
</head>
<body>
  <?php
  include("php/function.php");
  //Si no existe una sesion iniciada, redigir a login
  if(!validateSession()){
    $host = $_SERVER['HTTP_HOST'];
    $path = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
    header("location:http://$host/$path/");
  }
  ?>
  <!-- Inicio Javascript -->
  <script>
    function muestraPagina(url){
      document.getElementById("framePaginas").src = url;
    }
  </script>
  <!-- Fin Javascript -->

  <!-- Inicio Cabecera -->
	<div class="header" id="CabeceraMenu">
    <center>
    <form method="post">
      <button type="button" id="btnInicio" class="btnHeader" onclick="location.href='inicio-admin.php';">Inicio</button>
      <button type="button" id="btnEditarUsuarios" class="btnHeader" onclick="muestraPagina('usuarios-edicion.php')">Usuarios</button>
      <button type="button" id="btnAdminCatalogos" class="btnHeader" onclick="muestraPagina('catalogos-administracion.php')">Catalogos</button>
      <button type="submit" name="btnSalir" class="btnHeader" onclick="return confirm('¿Está seguro de cerrar su sesión?');">Salir</button>
    <?php
    if(isset($_POST["btnSalir"])){
      if(logoutSystem()){
        $host = $_SERVER['HTTP_HOST'];
        $path = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
        header("location:http://$host/$path/");
      }
    }
    ?>
    </form>
    </center>
  </div>
  <!-- Fin Cabecera -->

  <!-- Inicio iFrame -->  
  <div id="containerFrame">
    <iframe id="framePaginas" style="display:block; border:none; height:100vh; width:100%;">
    </iframe>
  </div>
  <!-- Fin iFrame -->  

	<script src="js/jquery-3.6.0.min.js"></script>
</body>
</html>