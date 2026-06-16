<!Doctype HTML>
<?php
error_reporting(0);
session_start();
require "funciones.php";
?>
<html lang="es-ES">
<head>

<title> Pagina de login </title>
<link rel="stylesheet" href="css/general.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
if ($_POST) {

$random = rand(1000000000,9999999999);

$Nombre = $_POST['Nombre']; //Usuario
$CIFo = $_POST['CIF'];      //Recoger CIF
$CIF  = preg_replace('[\s+]','',$CIFo);		// Quita los espacios a CIFo
$Telefono = $_POST['Telefono'];
$mail = $_POST['mail'];
$Contacto = $_POST['Contacto'];
$Usuario = strtolower($_POST['Usuario']);
$Contrasena = sha1($_POST['Contrasena']). $random;


$serv = $_SERVER['DOCUMENT_ROOT'] . "/Empresa/"; // CAMBIAR EN HOSSTING ?

$ruta =  $serv . '/' . $Usuario;
$rutaFactura = $serv . $Usuario .'/factura';
$rutaAlbaran = $serv . $Usuario .'/albaran';
$rutaBuzon = $serv . $Usuario .'/Buzon';
$rutaFacturaL = "Empresa/" . $Usuario . '/factura';
$rutaAlbaranL = "Empresa/" . $Usuario . '/albaran';
$rutaBuzonL = "Empresa/" . $Usuario . '/Buzon';

if(!file_exists($rutaFactura))
{
    $conexion = Conexion();
  $query = mysqli_query($conexion,"Select * from empresa where CIF = '$CIF' OR Usuario = '$Usuario'");
  $arrayquery=mysqli_fetch_array($query);
  IF ($arrayquery['Usuario']  OR $arrayquery['CIF']){
  }ELSE{
  mkdir ($ruta);
  mkdir ($rutaFactura);
  mkdir ($rutaAlbaran);
  mkdir ($rutaBuzon);
  echo "Se ha creado el directorio: " . $rutaFactura;
  echo " Se ha creado el directorio: " . $rutaAlbaran;
  echo " Se ha creado el directorio: " . $rutaBuzon;
  echo "<meta http-equiv='Refresh' content='2;./perfilbanalva.php'>";
  }
} else {
echo "la ruta: " . $rutaFactura . " ya existe ";
echo "<meta http-equiv='Refresh' content='2;./perfilbanalva.php'>";
}


$conexion = Conexion();
$query = mysqli_query($conexion,"Select * from empresa where CIF = '$CIF' OR Usuario = '$Usuario'");
$arrayquery=mysqli_fetch_array($query);
IF ($arrayquery['Usuario']  OR $arrayquery['CIF']){
ECHO "EL USUARIO YA EXISTE";
echo "<a href=nuevaempresa.php class=log> Volver atras </a>";}ELSE{
mysqli_query($conexion,"INSERT INTO empresa (CIF,Nombre,Usuario,Contrasena,Telefono,mail,Contacto,Ruta_albaranes,Ruta_facturas,Ruta_buzon) VALUES ('$CIF','$Nombre','$Usuario','$Contrasena','$Telefono','$mail','$Contacto','$rutaAlbaranL','$rutaFacturaL','$rutaBuzonL')");
}
}
else{
?>
<form action="nuevaempresa.php" method="POST" id="login" OnSubmit="validacionUsuario(f)">

Nombre de Empresa:<br>
<input type="text" name="Nombre" required /><br>
CIF:<br>
<input type="text" name="CIF" required /><br>
TELEFONO:<br>
<input type="text" name="Telefono" /><br>
Correo:<br>
<input type="text" name="mail" /><br>
CONTACTO:<br>
<input type="text" name="Contacto" /><br>
Nombre de Usuario:<br>
<input type="text" name="Usuario" required /><br>
Contrase&ntilde;a:<br>
<input type="password" name="Contrasena" required /><br>

<input type="submit" value="enviar">
<a href="perfilbanalva.php"> Atras </a>
</form>
<?PHP
}
?>
</body>
</html>
