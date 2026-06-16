<!Doctype HTML>
<?php
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

			if( isset($_POST['empresa'])) {

					$conexion = Conexion();
					$c = $_POST['empresa'];
					$consulta2 = mysqli_query($conexion,"Select * from empresa where CIF = '$c'");

					$a=mysqli_fetch_array($consulta2);
			?>
			<form action="editarempresa.php" method="POST" id="login" OnSubmit="validacionUsuario(f)">

			Nombre de Empresa:<br>
			<input type="text" name="Nombre"  required  value="<?PHP echo $a['Nombre'];  ?>"/><br>
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
			}
			else if( isset($_POST['borrarempresa'])){

			$borrar = $_POST['borrarempresa'];

			$conexion = Conexion();

			$consulta2 = mysqli_query($conexion,"Select * from empresa where CIF = '$borrar'");

			$a=mysqli_fetch_array($consulta2);
			$user = $a['Usuario'];
			$servfacturas =  "$user";
			echo '<form id="atencion" action="" method="POST" > <input type="hidden" name="path" value="' .$a['Usuario'] .'"/> Si continua eliminara el usuario ' . $a['Usuario'] . ' y todos sus datos permanenetemente<br> <input type="hidden" value ="' . $borrar . '" name="borrar1" /> <br> <input type="submit" value="Eliminar usuario" /> <a href="perfilbanalva.php"> Cancelar </a> </form>';


			}

			else if(isset($_POST['borrar1'])){


			$borrar1 = $_POST['borrar1'];

			$conexion = Conexion();

			mysqli_query($conexion,"DELETE FROM empresa WHERE CIF = '$borrar1'");
			$user = $_POST['path'];;
			$path = "Empresa/$user/";
			eliminarDir($path);


			echo 'el usuario  ' . $borrar1 . ' ha sido eliminado permanentemente' ;
			echo "<meta http-equiv='Refresh' content='3;./perfilbanalva.php'>";
			}


			else if( isset($_POST['Usuario'])){

			$random = rand(1000000000,9999999999);

			$Nombre = $_POST['Nombre']; //Usuario
			$CIFo = $_POST['CIF'];      //Recoger CIF
			$CIF  = preg_replace('[\s+]','',$CIFo);		// Quita los espacios a CIFo
			$Telefono = $_POST['Telefono'];
			$mail = $_POST['mail'];
			$Contacto = $_POST['Contacto'];
			$Usuario = strtolower($_POST['Usuario']);
			$Contrasena =$_POST['Contrasena'];
			//echo $Contrasena;
			$conexion = Conexion();

			$consulta5 = mysqli_query($conexion,"SELECT * FROM empresa where CIF = '$CIF'");
			$ga=mysqli_fetch_array($consulta5);

				if($Contrasena == $ga['Contrasena']){


					$conexion = Conexion();

					mysqli_query($conexion,"UPDATE empresa SET Nombre='$Nombre',Usuario='$Usuario',Telefono='$Telefono',mail='$mail',Contacto='$Contacto' where CIF = '$CIF'");
				echo "usuario modificado correctamente 1 ";
				echo "<meta http-equiv='Refresh' content='3;./perfilbanalva.php'>";
				}
				else{

					$Contrasena = sha1($_POST['Contrasena']). $random;




					$conexion = Conexion();

					mysqli_query($conexion,"UPDATE empresa SET Nombre='$Nombre',Usuario='$Usuario',Contrasena='$Contrasena',Telefono='$Telefono',mail='$mail',Contacto='$Contacto' where CIF = '$CIF'");
				echo "usuario modificado correctamente  2";
					echo "<meta http-equiv='Refresh' content='3;./perfilbanalva.php'>";
				}

			}

else{
?>
<!-- Editar empresa -->
<div class="edit">
<form action="editarempresa.php" method="POST" OnSubmit="validacionUsuario(f)">
	<select name="empresa" required>
		<option value="" disabled selected>Selecciona empresa</option>
		<?PHP
			listarEmpresas();

		?>
	</select><br>
	<input type="submit" value="editar empresa" />
<!-- Borrar empresa -->
	</form>
	<br>
	<form action="editarempresa.php" method="POST" OnSubmit="validacionUsuario(f)">
	<select name="borrarempresa" required>
		<option value="" disabled selected>Selecciona empresa</option>
		<?PHP
			listarEmpresas();

		?>
	</select><br>
	<input type="submit" value="borrar empresa" />
	<br>
	<a href="perfilbanalva.php"> atras </a>
	</form>

<?PHP
}
?>

</div>


</body>
</html>
