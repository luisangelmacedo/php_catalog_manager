<?php 
include("php/function.php");

if(isset($_GET)){
  $table = $_GET['table'];
  if (downloadData($table)){
    echo "<script type='text/javascript'>alert('Exportación correcta!')</script>";
    echo "<script type='text/javascript'>window.location.href='catalogos-edicion.php'</script>";
  }
}
?>