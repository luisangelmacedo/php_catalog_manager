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
  <!-- Inicio Javascript -->
  <script>
		function validaTabla() {
			var tableName = document.getElementById('nombreCatalogo').value;
			$.post("php/function.php", {functionName: 'tableExists', tableName: tableName}, function(mensaje) {
        if(mensaje=='true'){
          $("#resultadoValidacion").html('La tabla "'+tableName + '" ya existe');
        }
        else{
          $("#resultadoValidacion").html('');
        }
			 }); 
		}
  </script>
  <!-- Fin Javascript -->

  <!-- Inicio Titulo -->
  <h3>
    <center>
			Sección de creación de catálogos a partir de archivos
    </center>
	</h3>
  <!-- Fin Titulo -->

	<div id="container">
		<form method="post" enctype="multipart/form-data">
      <center>
      <table id="cargaCatalogos">
        <tr>
          <td>Nombre del catalogo: </td>
          <td><input type="text" name="nombreCatalogo" id="nombreCatalogo" placeholder="Ingrese nombre de catálogo" onkeyup="validaTabla()" required></input></td>
        </tr>
        <tr>
          <td></td>
          <td><div id="resultadoValidacion"></div></td>
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
          <td><input class="btn" type="submit" name="btnCargarCatalogo" value="Subir Catalogo"></td>
          <td><input class="btn-red" type="button" id="btnCancelar" value="Cancelar"></td>
        </tr>
      </table>
        <tr>
          <p>
        ** Se creará por defecto un campo "idrow" para hacer únicos a los registros. </br>
        ** Se asumirán para todos los campos el tipo de dato "texto".
        </p>
        </tr>
      </center>
      <?php
      if(isset($_POST["btnCargarCatalogo"])){
        $loadedRows = uploadCreate("fileCatalog",$_POST["sepFila"], $_POST["nombreCatalogo"]);
        if($loadedRows > 0){
          echo "<script type='text/javascript'>alert('Catalogo creado! Se cargaron $loadedRows filas')</script>";
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