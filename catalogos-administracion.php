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
			Sección de edición de catálogos
    </center>
	</h3>
  <!-- Fin Titulo -->
  
	<div id="container">
    <center>
    <?php
    // cabeceras
    echo "<center><table style='text-align: center'><tr>";
    echo "<th>Id</th>
          <th>Catalogo</th>
          <th>Creador</th>
          <th>******</th>
          <th>******</th>
          <th>******</th>
          </tr>";
    $result = selectData($tableGrant);
    
    foreach ($result as $row){
      $reg = array();
      echo "<tr>";
      foreach ($row as $cell ){
        array_push($reg, $cell);
        echo "<td>".$cell."</td>";
      }
      // links
      echo "<td><a class=\"btn\" href=\"catalogos-descarga.php?table=$reg[1]\">Descargar</a></td>";
      echo "<td><a class=\"btn\" href=\"catalogos-truncamiento.php?table=$reg[1]\" onclick=\"return confirm('¿Está seguro de vaciar su catálogo?');\">Vaciar</a></td>";
      echo "<td><a class=\"btn-red\" href=\"catalogos-eliminacion.php?table=$reg[1]\" onclick=\"return confirm('¿Está seguro de eliminar su catálogo?');\">Eliminar</a></td>";
      echo "</tr>" ;
    }
    
    echo "</table></center>";
    ?>
    </center>
	</div>

	<script src="js/jquery-3.6.0.min.js"></script>
</body>
</html>