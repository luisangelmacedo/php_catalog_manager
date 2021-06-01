<!doctype html>
<html>
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/ieduca.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
</head>
<body>
	<?php
		include("php/function.php");
	?>  
  <!-- Inicio Titulo -->
  <h3>
    <center>
			Sección de edición de usuarios
    </center>
	</h3>
  <!-- Fin Titulo -->
  
	<div id="container">
    <!-- Container Resultados Tabla -->
    <div id ="contenidoTabla">
      <center>
      <table class="tbl" style="text-align: center">
        <tr>
          <th>Id</th>
          <th>Usuario</th>
          <th>Clave</th>
          <th>Tipo</th>
          <th>******</th>
          <th>******</th>
        </tr>
    <?php
    //registros
    $result = selectData($tableUsers, "idrow, user_name, pass_key, user_type");
    foreach ($result as $row){
      $reg = array();
      echo "<tr>";
      
      foreach ($row as $cell ){
        array_push($reg, $cell);
        echo "<td>".$cell."</td>";
      }
      //Link de edicion
      echo "<td><a class=\"btn\" href=\"registros-edicion-detalle.php?id=$reg[0]&table=catalog_users\">Editar</a></td>";
      echo "<td><a class=\"btn-red\" href=\"usuarios-eliminacion-detalle.php?id=$reg[0]&table=catalog_users\" onclick=\"return confirm('¿Está seguro de eliminar este registro?');\">Eliminar</a></td>";
      echo "</tr>" ;
    }
    
    echo "</table></center>";
    ?>
    </div>
    <!-- Fin Container Resultados Tabla -->
	</div>

	<script src="js/jquery-3.6.0.min.js"></script>
</body>
</html>