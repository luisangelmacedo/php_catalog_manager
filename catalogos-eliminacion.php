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

	<div id="container">
		<center>
		<?php 
		include("php/function.php");
		
		if(isset($_GET)){
			$table = $_GET['table'];
			if (dropTable($table)){
        if(deleteData($tableGrant, $table, "table_name")){
          echo "<script type='text/javascript'>alert('Catalogo eliminado!')</script>";
          echo "<script type='text/javascript'>window.location.href='catalogos-edicion.php'</script>";
        }
      }
		}
		?>
		</center>
	</div>
  
	<script src="js/jquery-3.6.0.min.js"></script>
</body>
</html>