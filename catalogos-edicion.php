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
    getSchemaTables();
    ?>
    </center>
	</div>

	<script src="js/jquery-3.6.0.min.js"></script>
</body>
</html>