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
	<script>
		function getTableRows() {
			var selectedTable = document.getElementById('selectTable');
			var tableName = selectedTable.options[selectedTable.selectedIndex].value;
      if(tableName){
        $.post("php/function.php", {functionName: 'getTableRows', tableName: tableName}, function(mensaje) {
          $("#contenidoTabla").html(mensaje);
			 }); 
      }
		}
	</script>
  
  <!-- Inicio Titulo -->
  <h3>
    <center>
			Sección de edición de registros
    </center>
	</h3>
  <!-- Fin Titulo -->
  
	<div id="container">
    <center>
    <tr>
      <td>
      Seleccione un catalogo
      </td>
      <td>
        <select class="form-control" id="selectTable" name="selectTable">
          <option value="">...</option>
            <?php
            $result = selectMetaDataTables($generalSchema);
            
            foreach ($result as $row){
              foreach ($row as $cell){
                echo "<option value=\"".$cell."\">".$cell."</option>";
              }
            }
            ?>
        </select>
      </td>
      <td>
        <input id="btnBuscarCatalogo" type="button" class="btn" value="Mostrar tabla" onclick="getTableRows()"></input>
      </td>
    </tr>
    </center>
    <!-- Container Resultados Tabla -->
    </br>
    <div id ="contenidoTabla">
    </div>
    <!-- Fin Container Resultados Tabla -->
	</div>

	<script src="js/jquery-3.6.0.min.js"></script>
</body>
</html>