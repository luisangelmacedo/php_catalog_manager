<?php
session_start();

global $generalSchema;
global $defaultIdValue;
global $defaultIdField;
global $metadataTable;
global $metadataColumns;
global $tableGrant;
global $tableSession;
global $tableUsers;
global $connUser;
global $connKey;
global $connHost;

$connUser         = "root";
$connKey          = "";
$connHost         = "localhost";

$metadataTable    = "information_schema.tables";
$metadataColumns  = "information_schema.columns";
$defaultIdValue   = "null";
$defaultIdField   = "idrow integer auto_increment primary key";
$generalSchema    = "baul";

$tableGrant       = "catalog_table_grant";
$tableSession     = "catalog_authentication";
$tableUsers       = "catalog_users";

//Artificio para comunicarse con JS a través de Ajax
if (isset($_POST['functionName'])) {
	$functionName = $_POST["functionName"];
	
	switch ($functionName) {
		case "getTableRows":
		getTableRows($_POST['tableName']);
		break;
		case "getNewRowData":
		getNewRowData($_POST['tableName']);
		break;
    case "tableExists":
		tableExists($_POST['tableName']);
		break;
	}
}
	
function executeQuery($query) {
  global $connUser;
  global $connKey;
  global $connHost;
  global $generalSchema;

  $connection = mysqli_connect($connHost, $connUser, $connKey, $generalSchema);
  $result = mysqli_query($connection, $query);
  return $result;
}

function selectData($tableName, $fields = "*") {
  $sql = "SELECT ".$fields." FROM ".$tableName;
  return executeQuery($sql);
}

function selectMetaDataColumns($tableName) {
  global $metadataColumns;
  $sql = "SELECT column_name FROM ".$metadataColumns."
           WHERE UPPER(table_name) = UPPER('".$tableName."')";
  return executeQuery($sql);
}

function selectMetaDataTables($schemaName) {
  global $metadataTable;
  global $tableSession;
  global $tableGrant;
  
  $sessionId = session_id();
  
  $sql = "SELECT t.table_name
            FROM ".$metadataTable." t
            JOIN ".$tableSession." a
              ON a.session_id = '".$sessionId."'
            JOIN ".$tableGrant." tg
              ON UPPER(t.table_name) = UPPER(tg.table_name)
           WHERE UPPER(tg.user_owner) = UPPER(a.user_name)";
  return executeQuery($sql);
}

function insertData($tableName, $values) {
  global $defaultIdValue;
  
	$sql = "INSERT INTO ".$tableName." VALUES (".$defaultIdValue.",";
	$data = array();

	foreach($values as $value){
		$data[] = "'".$value."'";
	}
	
	$sql.= implode(',',$data);
	$sql.= ")";
  
	return executeQuery($sql); 
}

function updateData($tableName, $formData, $idValue, $idField = "idrow"){
	$sql = "UPDATE ".$tableName." SET ";
	$data = array();

	foreach($formData as $column=>$value){
		$data[] =$column."="."'".$value."'";
	}
	
	$sql.= implode(',',$data);
	$sql.=" WHERE ".$idField." = '".$idValue."'";
	return executeQuery($sql);
}

function deleteData($tableName, $idValue, $idField = "idrow") {
  $sql = "DELETE FROM ".$tableName." WHERE ".$idField." = '".$idValue."'";
  return executeQuery($sql);
}

function truncateData($tableName) {
  $sql = "TRUNCATE TABLE ".$tableName;
  return executeQuery($sql);
}

function tableExists($tableName){
  global $metadataTable;
  
  $countArr = array();
  $sql = "SELECT COUNT(1) FROM ".$metadataTable."
           WHERE UPPER(table_name) = UPPER('".$tableName."')";
  $result = executeQuery($sql);
  
	foreach($result as $row):
		foreach ($row as $cell):
			array_push($countArr, $cell);
		endforeach;
	endforeach;
  
  //Se tuvo que añadir los "echo" para interacción con Ajax
  if($countArr[0] > 0){
    echo "true";
    return true;
  }
  else{
    echo "false";
    return false;
  }
}

function createTable($tableName, $fields) {
  global $defaultIdField;
  
  if(!tableExists($tableName)){
    $sql = "CREATE TABLE ".$tableName." (".$defaultIdField.",";
    $data = array();

    foreach($fields as $columnName=>$dataType){
      $data[] =$columnName." ".$dataType;
    }
    
    $sql.= implode(",",$data);
    $sql.= ")";
    
    return executeQuery($sql);
  }
  else{
    return false;
  }
}

function dropTable($tableName) {
  $sql = "DROP TABLE ".$tableName;
  return executeQuery($sql);
}

function getTableRows($tableName){
	// cabeceras
	$result = selectMetaDataColumns($tableName);
	echo "<center><table style='text-align: center'><tr>";
	foreach ($result as $row){
		foreach ($row as $cell){
			echo "	<th>".$cell."</th>";
		}
	}
	echo "<th>******</th><th>******</th></tr>" ;
	//registros
	$result = selectData($tableName);
	foreach ($result as $row){
		$reg = array();
		echo "<tr>";
		foreach ($row as $cell ){
			array_push($reg, $cell);
			echo "	<td>".$cell."</td>";
		}
		//Link de edicion
		echo "<td><a class=\"btn\" href=\"registros-edicion-detalle.php?id=$reg[0]&table=$tableName\">Editar</a></td>";
		echo "<td><a class=\"btn-red\" href=\"registros-eliminacion-detalle.php?id=$reg[0]&table=$tableName\" onclick=\"return confirm('¿Está seguro de eliminar este registro?');\">Eliminar</a></td>";
		echo "</tr>" ;
	}
  
	echo "</table></center>";
}

function getSchemaTables(){
  global $generalSchema;
	// cabeceras
	echo "<center><table style='text-align: center'><tr>";
	echo "<th>Catálogo</th><th>******</th><th>******</th><th>******</th></tr>";
	$result = selectMetaDataTables($generalSchema);
	
  foreach ($result as $row){
		$reg = array();
		echo "<tr>";
		foreach ($row as $cell ){
			array_push($reg, $cell);
			echo "<td>".$cell."</td>";
		}
		// links
    echo "<td><a class=\"btn\" href=\"catalogos-descarga.php?table=$reg[0]\">Descargar</a></td>";
    echo "<td><a class=\"btn\" href=\"catalogos-truncamiento.php?table=$reg[0]\" onclick=\"return confirm('¿Está seguro de vaciar su catálogo?');\">Vaciar</a></td>";
    echo "<td><a class=\"btn-red\" href=\"catalogos-eliminacion.php?table=$reg[0]\" onclick=\"return confirm('¿Está seguro de eliminar su catálogo?');\">Eliminar</a></td>";
		echo "</tr>" ;
	}
  
	echo "</table></center>";
}

function getEditableRowData($tblname, $field_id, $field_name = "idrow"){
	$headerArray = array();
	$valuesArray = array();
  $result = selectMetaDataColumns($tblname);
	
  foreach ($result as $row){
		foreach ($row as $cell){
			array_push($headerArray, $cell);//Añadiendo cabeceras a array
		}
	}

	$sql = "SELECT * FROM ".$tblname." WHERE ".$field_name." = '".$field_id."'";
	$result = executeQuery($sql);

	foreach ($result as $row){
		foreach ($row as $cell){
			array_push($valuesArray, $cell);
		}
	}
  
	$resultArray = array_combine ($headerArray, $valuesArray);
	echo "<form method=\"post\">";
  echo "<table class=\"tbl\">";
	
  foreach ($resultArray as $key=>$value){
    if(strtoupper($key) == "IDROW"){
      echo "<tr><td>".$key."</td>";
      echo "<td><input type=\"text\" value=\"".$value."\" name=\"".$key."\" readonly></td><tr>";      
    }
    else{
      echo "<tr><td>$key</td>";
      echo "<td><input type=\"text\" value=\"".$value."\" name=\"".$key."\" required></td><tr>";
    }
	}
  
	echo "</table></br>";
  echo "<table><tr><td><input type=\"submit\" class=\"btn\" value=\"Actualizar Registro\"></td>";
  echo "<td><input type=\"button\" class=\"btn-red\" value=\"Cancelar\"></td></tr></table>";
  echo "</form>";
}

function getNewRowData($tblname){
	$headerArray = array();
	$valuesArray = array();
	$result = selectMetaDataColumns($tblname);
  
  echo "<center><h4>Rellene los siguientes campos</h4>";
	echo "<form method=\"post\">";
  echo "<table>";
	
  foreach ($result as $row){
    echo "	<tr>";
		foreach ($row as $cell){
      if(strtoupper($cell) !== "IDROW"){
        echo "<td>".$cell."</td>";
        echo "<td><input type=\"text\" placeholder=\"Ingrese ".$cell."\" name=\"campo_".$cell."\" required></td>"; 
      }
		}
    echo "	</tr>";
	}
  
  echo "</table></br>";
  echo "<table><tr><td><button type=\"submit\" name=\"".$tblname."\" class=\"btn\">Crear</button></td>";
  echo "<td><button type=\"button\" class=\"btn-red\">Cancelar</button></td></tr></table>";
	echo "</form></center>";
}

function validateSession(){
  $sessionId = session_id();
  $countArr = array();
  $sql = "SELECT validaSesion('".$sessionId."')";
  $result = executeQuery($sql);
  
	foreach ($result as $row){
		foreach ($row as $cell){
			array_push($countArr, $cell);
		}
	}
  
  if($countArr[0] > 0){
    return true;
  }
  else{
    return false;
  }
}

function loginSystem($userName, $password, $userType){
  global $tableSession;
  
  $sysdate = date('d/m/Y H:i:s');
  $countArr = array();
  $sessionValues = array();

  $sql = "SELECT validaUsuario('".$userName."','".$password."','".$userType."')";
  $result = executeQuery($sql);    
  
	foreach ($result as $row){
		foreach ($row as $cell){
			array_push($countArr, $cell);
		}
	}
  
  if($countArr[0] > 0){
    session_regenerate_id();
    $sessionId = session_id();
    $sysdate = date('d/m/Y H:i:s');
    
    array_push($sessionValues, $sessionId, $userName, $sysdate, null, 1);
    if(insertData($tableSession, $sessionValues)){
      return true;
    }
  }
  else{
    return false;
  };
}

function logoutSystem(){
  global $tableSession;
  
  $sessionId = session_id();
  $sysdate = date('d/m/Y H:i:s');
  $sql = "UPDATE ".$tableSession." 
             SET flg_active = 0, 
                 end_date = '".$sysdate."' 
           WHERE session_id = '".$sessionId."'";
           
  if(executeQuery($sql)){
    return true;
  }
  else{
    return false;
  };
}

function uploadData($fileInput, $delimiter, $tableName){
  $loadedFile = $_FILES["$fileInput"]['tmp_name'];
  $file = file($loadedFile);
  $data = array();
  $cont = 0;

  foreach ($file as $numLinea => $linea){
    if($numLinea != 0){
      $data = explode($delimiter, str_replace('"', "", $linea));
      if(insertData($tableName, $data)){
        $cont++; 
      }
    }
  }
  
  return $cont;
}

function uploadCreate($fileInput, $delimiter, $tableName){
  global $defaultIdValue;
  global $tableGrant;
  global $tableSession;
  
  $loadedFile = $_FILES["$fileInput"]['tmp_name'];
  $file = file($loadedFile);
  $data = array();
  $fieldNames = array();
  $dataTypes = array();
  $headers = array();
  $cont = 0;

  foreach ($file as $numLinea => $linea){
    if($numLinea == 0){
      $fieldNames = explode($delimiter, str_replace('"', "", $linea));
      
      foreach ($fieldNames as $field){
        array_push($dataTypes, "varchar(400)");
      }
      
      $headers = array_combine($fieldNames, $dataTypes);
      
      if(createTable($tableName, $headers)){
        $sessionId = session_id();
        $sql = "INSERT INTO ".$tableGrant." 
                SELECT ".$defaultIdValue.", '".$tableName."', user_name 
                  FROM ".$tableSession."
                 WHERE session_id = '".$sessionId."'";
        executeQuery($sql);
      }
      else{
        break;
      }
    }
    else{
      $data = explode($delimiter, str_replace('"', "", $linea));
      if(insertData($tableName, $data)){
        $cont++; 
      }
    }
  }
  
  return $cont;
}

function downloadData($tableName){
  $delimiter = ";";
  $filename = $tableName."_".date('d-m-Y').".csv";
  $file = fopen('php://memory', 'w');
  
  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="'.$filename.'";');
  
  $fields = array();
	$result = selectMetaDataColumns($tableName);
  
  foreach ($result as $row){
		foreach ($row as $cell){
      array_push($fields, trim($cell));
		}
	}
  
  fputcsv($file, $fields, $delimiter);
  $result = selectData($tableName);
  
	foreach ($result as $row){
		$lineData = array();
		foreach ($row as $cell ){
			array_push($lineData, trim($cell));
		}
    fputcsv($file, $lineData, $delimiter);
  }
  
  fseek($file, 0);
  fpassthru($file);
}
?>
