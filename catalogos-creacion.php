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
    function añadirCampo(){
      var tIndex = document.getElementById("camposCatalogo").rows.length;
      var campo = "<td><input type=\"text\" placeholder=\"Ingrese nombre de campo\" name=\"campo" +tIndex+ "\" required></td>";
      var tDato1 = "<td><select name=\"tipoDato" +tIndex+ "\">";
      var tDato2 = "<option value='varchar(300)'>Texto</option>";
      var tDato3 = "<option value=\"integer\">Numero entero</option>";
      var tDato4 = "<option value=\"float\">Numero decimal</option>";
      var tDato5 = "<option value=\"varchar(19)\">Fecha</option>";
      var tDato6 = "</select></td>";
      var tDato7 = "<td><button class=\"btn-red\" type=\"button\" onclick=\"quitarCampo(this)\">Quitar</button></td>";
      var tipoDato = tDato1 + tDato2 + tDato3 + tDato4 + tDato5 + tDato6 + tDato7;
      document.getElementById("camposCatalogo").insertRow(-1).innerHTML = campo + tipoDato;
    }
    
    function quitarCampo(row){
      var d = row.parentNode.parentNode.rowIndex;
      document.getElementById("camposCatalogo").deleteRow(d);
   }
   
		function validaTabla() {
			var tableName = document.getElementById('nombreCat').value;
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
			Sección de creación de catálogos
    </center>
	</h3>
  <!-- Fin Titulo -->
  
	<div id="container">
    <center>
		<form method="post">
      <table id="camposCatalogo">
        <tr><td>Nombre del catalogo</td></tr>
        <tr><td><input type="text" placeholder="Ingrese un nombre" name="nombreCat" id="nombreCat" onkeyup="validaTabla()" required autofocus></td></tr>
        <tr><td><div id="resultadoValidacion"></div></td></td>
        <tr><td></td></tr>
        <tr>
          <td>Campos</td>
          <td><button class="btn" type="button" id="btnAgregarCampo" onclick="añadirCampo()">Añadir</button></td>
        </tr>
      </table>
      </br>
      <tr>
        <td><button class="btn" type="submit" id="btnCrearCatalogo">Crear</button></td>
        <td><button class="btn-red" type="button" id="btnCancelar">Cancelar</button></td>
      </tr>
      <tr>
        <p>
        ** Se creará por defecto un campo "idrow" para hacer únicos a los registros.
        </p>
      </tr>
      <?php
      if(isset($_POST)) {
        $fields = array();
        $dataTypes = array();
        $tableStructure = array();
        
        foreach($_POST as $key=>$value){
          if(substr($key, 0, 5) == "campo"){
            array_push($fields, $value);
          }
          elseif(substr($key, 0, 4) == "tipo"){
            array_push($dataTypes, $value);
          }
        }
        
        $tableStructure = array_combine($fields, $dataTypes);
        
        if(isset($_POST["nombreCat"])){
          if(createTable($_POST["nombreCat"], $tableStructure)){
            $tableName = $_POST["nombreCat"];
            $sessionId = session_id();
            $sql = "INSERT INTO ".$tableGrant." 
                    SELECT $defaultIdValue, '$tableName', user_name 
                      FROM ".$tableSession."
                     WHERE session_id = '$sessionId'";
            if(executeQuery($sql)){
              echo "<script type='text/javascript'>alert('Catalogo creado!')</script>";
              echo "<script type='text/javascript'>window.location.href='catalogos-creacion.php'</script>";
            }
          }
          else{
            echo "<script type='text/javascript'>alert('Error. Catalogo ya existe!')</script>";
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