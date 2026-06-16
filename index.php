<?php
 error_reporting(1);
 session_start();
 require "funciones.php";?>
<!Doctype HTML>
<html lang="es-ES">
<head>
<title> loggin </title>
<link rel="stylesheet" type="text/css" href="css/general.css">
<meta charset="UTF-8">
</head>
<body>
<?php
if (isset($_POST['Usuario'])){
$Usuario = $_POST['Usuario'];
$Contrasena =sha1($_POST['Contrasena']); 
$conexion = Conexion();
$Conslogin = mysqli_query($conexion,"SELECT Usuario FROM empresa WHERE Usuario = '$Usuario' and (`Contrasena` like '$Contrasena%')");
$arraylogin = mysqli_fetch_array($Conslogin);
// CONSULTA BBDD
//var_dump($conexion);
//var_dump($consulta); 
$Contrasena2 =sha1(banalva); 
//Comprobar el usuario
if ( $Usuario == $arraylogin[0]){
$_SESSION['Usuario'] = $_POST['Usuario'];		
echo 'Bienvenido ' . $_SESSION['Usuario'];
?>
<meta http-equiv="Refresh" content="2;./perfilbanalva.php">
<?php
}
else if ( $Usuario == $arraylogin[0]){
$_SESSION['Usuario'] = $_POST['Usuario'];
echo 'Bienvenido ' . $_SESSION['Usuario'];
?>
<meta http-equiv="Refresh" content="2;./perfilbanalva.php">
<?php
}
else{
echo 'Login incorrecto';
?>
<meta http-equiv="Refresh" content="4;./index.php">
<?php
}
}
//Empieza el formulario
else{
?>
<?php
// CONSULTA BBDD
//var_dump($conexion);
//var_dump($consulta); 
$Contrasena2 =sha1(banalva); 
//
?>
<form action="./index.php" method="post" id="login">
Usuario:<br>
<input type="text" name="Usuario" /><br>
Clave de acceso:<br>
<input type="password" name="Contrasena" /><br>
<br>
<input type="submit" value="enviar" />
</form>
<?php
}
?>
</body>
</html>