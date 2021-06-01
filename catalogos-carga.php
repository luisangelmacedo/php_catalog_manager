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
    include('php/function.php');
  ?>

  <!-- Inicio Titulo -->
  <h3>
    <center>
			Sección de carga de catálogos
    </center>
	</h3>
  <!-- Fin Titulo -->

	<div id="container">
		<form method="post" enctype="multipart/form-data">
      <center>
      <table id="cargaCatalogos">
        <tr>
          <td>Seleccione catálogo: </td>
          <td>
            <select id="selectTable" name="selectTable">
              <option>...</option>
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
        </tr>
        <tr>
          <td>Seleccione archivo: </td>
          <td><input name="fileCatalog" id="fileCatalog" type="file" required></input></td>
        </tr>
        <tr>
          <td>Indique separador: </td>
          <td><input type="text" name="sepFila" placeholder="Ingrese separador" required></input></td>
        </tr>
        <tr>
          <td>Tiene cabeceras: </td>
          <td>
            <select id="selectHeader" name="selectHeader">
              <option value="yes">Si</option>
              <option value="no">No</option>
            </select>
          </td>
        </tr>
      </table>
      </br>
      <table>
        <tr>
          <td><button class="btn" type="submit" name="btnCargarCatalogo">Cargar</button></td>
          <td><button class="btn-red" type="button" id="btnCancelar">Cancelar</button></td>
        </tr>
      </table>
      </center>
      <?php
      if(isset($_POST["btnCargarCatalogo"])){
        $loadedRows = uploadData("fileCatalog",$_POST["sepFila"], $_POST["selectTable"]);
        if($loadedRows > 0){
          echo "<script type='text/javascript'>alert('Se cargaron $loadedRows filas!')</script>";
          echo "<script type='text/javascript'>window.location.href='catalogos-carga.php'</script>";
        }
        else{
          echo "<script type='text/javascript'>alert('Error. No se cargaron filas!')</script>";
          echo "<script type='text/javascript'>window.location.href='catalogos-carga.php'</script>";          
        }
      }
      ?>
		</form>
	</div>
  
	<script src="js/jquery-3.6.0.min.js"></script>
</body>
</html>