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
  
  <!-- Inicio Javascript -->
  <script>
		function crearRegistro() {
			var selectedTable = document.getElementById("comboTabla");
			var tableName = selectedTable.options[selectedTable.selectedIndex].value;
      
      if(tableName){      
        $.post("php/function.php", {functionName: 'getNewRowData', tableName: tableName}, function(mensaje) {
            $("#containerCreacion").html(mensaje);
         });
      }
		}
  </script>
  <!-- Fin Javascript -->
  
  <!-- Inicio Titulo -->
  <h3>
    <center>
			Sección de creación de registros
    </center>
	</h3>
  <!-- Fin Titulo -->
  
	<div id="container">
		<form method="post">
			<tr>
        <center>
        <td>
        Seleccione un catalogo
        </td>
				<td>
					<select name="cmbTabla" id="comboTabla">
            <option value="">...</option>
            <?php
              $result = selectMetaDataTables($generalSchema);
              foreach ($result as $row):
                foreach ($row as $cell):
                  echo "<option value=\"$cell\">$cell</option>";
                endforeach;
              endforeach;
            ?>
					</select>
				</td>
				<td>
          <input id="btnCrearRegistro" type="button" class="btn" value="Mostrar campos" onclick="crearRegistro()"></input>
				</td>
        </center>
			</tr>
		</form>
	</div>
  
  <!-- Inicio Container Creacion -->
	<div id="containerCreacion">
	</div>
  <!-- Fin Container Creacion -->
  
		<?php 
		if(isset($_POST)){
      $field = array();
      $tableName = "";
			foreach ($_POST as $key=>$value){
        if(substr($key, 0, 5) == "campo"){
          $field[$key] = $value;
        }
        else{
          $tableName = $key;
        }
      }
      
      if($tableName){
        if(insertData($tableName, $field)){
          echo "<script type='text/javascript'>alert('Registro creado!')</script>";
          echo "<script type='text/javascript'>window.location.href='registros-creacion.php'</script>";
        } 
      }
		}
		?>
  
	<script src="js/jquery-3.6.0.min.js"></script>
</body>
</html>