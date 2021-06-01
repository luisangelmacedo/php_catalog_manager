<!doctype html>
<html>
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/ieduca.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">

</head>
<style>
body{
  background-color: rgb(232,49,77);
  color: #fff;
}
</style>
<body>
	<?php
		include("php/function.php");
    //Si existe una sesion iniciada, redigir a pagina inicio
    if(validateSession()){
      $host = $_SERVER['HTTP_HOST'];
      $path = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
      header("location:http://$host/$path/inicio-regular.php");
    };
	?>
	<div class="login">
  
    <!-- Inicio Titulo -->
    <h3>
      <center>
        Sistema de gestión de catálogos
      </center>
    </h3>
    <!-- Fin Titulo -->
    
    <center>
      <form method="post">
        <table>
          <tr>
            <td>Usuario</td>
            <td><input type="text" name="userName" placeholder="Ingrese su usuario" required autofocus></input></td>
          </tr>
          <tr>
            <td>Contraseña</td>
            <td><input type="password" name="password" placeholder="Ingrese su contraseña" required></input></td>
          </tr>
          <tr>
            <td>Tipo Usuario</td>
            <td>
              <select name="tipoUsuario" required>
                <option value="regular">Usuario Regular</option>
                <option value="admin">Usuario Administrador</option>
              </select>
            </td>
          </tr>
        </table>
        </br>
        <table>
          <tr>
            <td><button type="submit" name="login" class="btn">Ingresar</button></td>
            <td><button type="button" class="btn">Recuperar</button></td>
          </tr>
        </table>
        <?php
        if(isset($_POST)){
          if(isset($_POST["login"])){
            if(loginSystem($_POST["userName"], $_POST["password"], $_POST["tipoUsuario"])){
              $host = $_SERVER['HTTP_HOST'];
              $path = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
              
              if($_POST["tipoUsuario"] == "regular"){
                header( "refresh:1;url=http://$host/$path/inicio-regular.php" );
              }
              else if($_POST["tipoUsuario"] == "admin"){
                header( "refresh:1;url=http://$host/$path/inicio-admin.php" );
              }
              
              echo "</br>Acceso correcto, redireccionando...";
            }
            else{
              echo "</br>Usuario y/o contraseña incorrectos.";
            }
          }          
        }
        ?>
      </form>
    </center>
	</div>

	<script src="js/jquery-3.6.0.min.js"></script>
</body>
</html>