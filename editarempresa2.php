<!Doctype HTML>
<?php
  error_reporting(0);
 session_start();
 require "funciones.php";

  
?>
<html lang="es-ES">
<head>

<title> Editar y Eliminar </title>
<link rel="stylesheet" href="css/general.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

</head>
<body>

	<?PHP									
			if( isset($_POST['Usuario'])){

			$random = rand(1000000000,9999999999);

			$Nombre = $_POST['Nombre']; //Usuario
			$CIFo = $_POST['CIF'];      //Recoger CIF
			$CIF  = preg_replace('[\s+]','',$CIFo);		// Quita los espacios a CIFo
			$Telefono = $_POST['Telefono'];
			$mail = $_POST['mail'];
			$Contacto = $_POST['Contacto'];
			$Usuario =$_POST['Usuario'];
			$Contrasena = $_POST['Contrasena'];
			
			$conexion = Conexion();
			
			$consulta5 = mysqli_query($conexion,"SELECT * FROM empresa WHERE CIF = '$CIF'");
			$g=mysqli_fetch_array($consulta5);

				if($Contrasena == $g['Contrasena']){
				
 

					echo "usuario modificado correctamente 1 ";
					echo "<meta http-equiv='Refresh' content='3;./perfilbanalva.php'>";

					$conexion = Conexion();

					mysqli_query($conexion,"UPDATE empresa SET CIF='$CIF',Nombre='$Nombre',Usuario='$Usuario',Telefono='$Telefono',mail='$mail',Contacto='$Contacto' where CIF = '$CIF'");
				
				}
				else{
					
					$Contrasena = sha1($_POST['Contrasena']). $random;
					echo "usuario modificado correctamente  2";
					echo "<meta http-equiv='Refresh' content='3;./perfilbanalva.php'>";



					$conexion = Conexion();

					mysqli_query($conexion,"UPDATE empresa SET CIF='$CIF',Nombre='$Nombre',Usuario='$Usuario',Contrasena='$Contrasena',Telefono='$Telefono',mail='$mail',Contacto='$Contacto' where CIF = '$CIF'");
				}

			}
			else{
				$conexion = Conexion();
				$c = $_SESSION['Usuario'];
				$consulta2 = mysqli_query($conexion,"Select * from empresa where Usuario = '$c'");
					
				$a=mysqli_fetch_array($consulta2);
	?>
			<form action="editarempresa2.php" method="POST" id="login" OnSubmit="validacionUsuario(f)">

			Nombre de Empresa:<br>
			<input type="text" name="Nombre"  required  value="<?PHP echo $a['Nombre'];?>"/><br>
			CIF:<?PHP echo $a['CIF'];?>
			<input type="hidden" name="CIF"  required  value="<?PHP echo $a['CIF'];?>"/><br>
			TELEFONO:<br>
			<input type="text" name="Telefono" value="<?PHP echo $a['Telefono'];?>" /><br>
			Correo:<br>
			<input type="text" name="mail" value="<?PHP echo $a['mail'];?>"/><br>
			CONTACTO:<br>
			<input type="text" name="Contacto" value="<?PHP echo $a['Contacto'];?>"/><br>
			Nombre de Usuario:<br>
			<input type="text" name="Usuario"  required value="<?PHP echo $a['Usuario'];?>"/><br>
			Contrase&ntilde;a:<br>
			<input type="password" name="Contrasena"  required  value="<?PHP echo $a['Contrasena'];?>"/><br>
		
			<input type="submit" value="enviar">
			<a href="perfilbanalva.php"> Atras </a>
			</form>
	<?PHP
			};
	?>





</body>
</html>