<!Doctype HTML>
<?php
 error_reporting(0);
 session_start();
 require "funciones.php";

?>
<html lang="es-ES">
<head>

<title> Perfil </title>
<link rel="stylesheet" href="css/general.css" type="text/css" />
<meta charset="UTF-8" />

</head>
<body>
<?PHP

//Si el usuario es banalva se ejecuta esta parte
if($_SESSION['Usuario'] == 'banalva'){
	$Usuario = $_SESSION['Usuario'];
	$conexion = Conexion();

	$consulta = mysqli_query($conexion,"Select * from empresa where Usuario = '$Usuario'");

	$resultado = mysqli_fetch_array($consulta);

?>
<!--Muestra la tabla con datos de Banalva -->
<div class="tabla">
<table class="ficha">

<tr>
	<td> Empresa</td>
	<td class="resultados"> <?PHP echo $resultado['Nombre']. " ";?></td>
</tr>
<tr>
	<td>CIF </td>
	<td class="resultados"><?PHP echo $resultado['CIF']. " ";?> </td>
</tr>
<tr>
	<td>Contacto </td>
	<td class="resultados"><?PHP echo $resultado['Contacto']. " ";?> </td>
</tr>
<tr>
	<td>Telefono </td>
	<td class="resultados"><?PHP echo $resultado['Telefono']. " ";?> </td>
</tr>
<tr>
	<td>e-mail </td>
	<td class="resultados"><?PHP echo $resultado['mail']. " ";?> </td>
</tr>

</table>
</div>
<div class="topright">
<a class="log" href="./nuevaempresa.php"> añadir empresa </a><br>
<a class="log" href="./editarempresa.php"> Editar o borrar empresa </a><br>
</div>
<!--Formulario que te redirige a ver los perfiles de cada empresa-->
<form action="perfiles.php" method="POST" id="formulario" OnSubmit="validacionUsuario(f)">
	<select name="NombreEmpresa" required>
		<option value="" disabled selected>Selecciona empresa</option>
		<?PHP
			listarEmpresas();

		?>
	</select><br>
	<input type="submit" value="Ver empresa" />
</form>


<!--Formularios para enviar Albaran y factura -->

<?PHP
		//Si se ha enviado el formulario, aparece esto
				if($_POST){

					$Nomem = $_POST['NombreEmpresa'];
					$diaarray = $_POST['arraydias'];
					$mesarray = $_POST['arraymeses'];
					$anoarray = $_POST['arrayanos'];
					$fecha = "$anoarray/$mesarray/$diaarray";
					$Numero_factura = $_POST['Numero_factura'];
					$tipo = $_POST['tipo'];
					$albaran = $_FILES['Subir'];

					$conexion = Conexion();

					$consulta = mysqli_query($conexion,"Select * from empresa where CIF = '$Nomem'");

					$resultado = mysqli_fetch_array($consulta);
					$CIF = $resultado['CIF'];
//si es albaran aparece esto, y comprueba que el nombre de archivo no este en uso, y mete los datos en la BD.
							if ($tipo == "Albaran"){


								$archivoO = $_FILES['Subir']['name'];
								$archivo = remove_accent($archivoO);
								$consulfile = mysqli_query($conexion,"Select * from albaranes where CIF = '$Nomem' and Enlace = '$archivo'");
								$comprobararchivo = mysqli_fetch_array($consulfile);
								if ($archivo != $comprobararchivo['Enlace']){
									echo $comprobararchivo['Enlace'];

														if ( is_uploaded_file($_FILES['Subir']['tmp_name']) )
															{
															   echo '<meta http-equiv="Refresh" content="1;./perfilbanalva.php"><p>El albaran se ha subido con éxito</p>';


																		 $origen = $_FILES['Subir']['tmp_name'];
																		 $nombrearchivoO = $_FILES['Subir']['name'];
																		 $nombrearchivo = remove_accent($nombrearchivoO);
																		 $destino = $resultado['Ruta_albaranes'].'/'.$nombrearchivo;
																		 move_uploaded_file($origen, $destino);

																mysqli_query($conexion,"INSERT INTO albaranes (Numero_albaran,fecha,Enlace,CIF) VALUES ('$Numero_factura','$fecha','$archivo','$CIF')");
															}
								}

								else {
									echo '<meta http-equiv="Refresh" content="3;./perfilbanalva.php"><p>Este nombre de archivo ya esta en uso</p>';
								}
							}
//si es factura aparece esto, y comprueba que el nombre de archivo no este en uso, y mete los datos en la BD.
							else if($tipo == "Factura"){
								$archivoO = $_FILES['Subir']['name'];
								$archivo = remove_accent($archivoO);
								$consulfile = mysqli_query($conexion,"Select * from facturas where CIF = '$Nomem' and Enlace = '$archivo'");
								$comprobararchivo = mysqli_fetch_array($consulfile);
								if ($archivo != $comprobararchivo['Enlace']){
										echo '<meta http-equiv="Refresh" content="1;./perfilbanalva.php"><p>La factura se ha subido con éxito</p>';

																	 $origen = $_FILES['Subir']['tmp_name'];
																	 $nombrearchivoO = $_FILES['Subir']['name'];
																	 $nombrearchivo = remove_accent($nombrearchivoO);
																	 $destino = $resultado['Ruta_facturas'].'/'.$nombrearchivo;
																	 move_uploaded_file($origen, $destino);
																	 mysqli_query($conexion,"INSERT INTO facturas (Numero_factura,fecha,Enlace,CIF) VALUES ('$Numero_factura','$fecha','$archivo','$CIF')");

								}
								else {
									echo '<meta http-equiv="Refresh" content="3;./perfilbanalva.php"><p>Este nombre de archivo ya esta en uso</p>';
								}
							}
//si es Documento aparece esto, y comprueba que el nombre de archivo no este en uso, y mete los datos en la BD.
							else if($tipo == "Archivo"){
								$archivoO = $_FILES['Subir']['name'];
								$archivo = remove_accent($archivoO);
								$consulfile = mysqli_query($conexion,"Select * from buzon where CIF = '$Nomem' and Enlace = '$archivo'");
								$comprobararchivo = mysqli_fetch_array($consulfile);
								if ($archivo != $comprobararchivo['Enlace']){
										echo '<meta http-equiv="Refresh" content="1;./perfilbanalva.php"><p>El Archivo se ha subido con éxito</p>';

																	 $origen = $_FILES['Subir']['tmp_name'];
																	 $nombrearchivoO = $_FILES['Subir']['name'];
																	 $nombrearchivo = remove_accent($nombrearchivoO);
																	 $destino = $resultado['Ruta_buzon'].'/'.$nombrearchivo;
																	 move_uploaded_file($origen, $destino);
																	 mysqli_query($conexion,"INSERT INTO buzon (Nombre_Buzon,Enlace,CIF) VALUES ('$Numero_factura','$archivo','$CIF')");

								}
								else {
									echo '<meta http-equiv="Refresh" content="3;./perfilbanalva.php"><p>Este nombre de archivo ya esta en uso</p>';
								}
							}

			}
			else{
				?>
	<div id="Nuevoarchivodiv">
			<form action="" method="POST" id="NuevoArchivo" enctype="multipart/form-data">

				<table>
					<caption>Subir Albaranes y facturas:</caption>
					<tr>
					<td>Empresa: </td>
					<td class="enviararchivos"><select name="NombreEmpresa"  style="width:193px;">

						<?PHP
							listarEmpresas();

						?>

					</select></td>
					</tr>
					<!--Funcion que genera los campos de fecha -->
					<tr>
					<td>fecha:</td> <td class="enviararchivos"><?PHP	MostrarFecha(); ?></td>
					</tr>
					<tr>
					<td>Numero Albaran / Factura o</br> Nombre de Documento:</td><td class="enviararchivos"><input type="text" name="Numero_factura" style="width:190px;"/></td>
					</tr>
					<tr>
					<td>tipo:</td>
						<td class="enviararchivos"><select name="tipo" style="width:193px;">
						<option value="Albaran"> Albaran</option>
						<option value="Factura"> Factura</option>
						<option value="Archivo"> Archivo</option>
						</select></td>
					</tr>
					<tr>
						<td>Selecciona un archivo:</td>
						<td class="enviararchivos"><input type="file" name="Subir" id="archivo" /></td>
					</tr>
					<tr>
						<td></td>
						<td class="enviararchivos"><input type="submit" value="Subir archivo" /></td>
					</tr>
				</table>
			</form>
			<?php
			}
			?>
<br>
	</div>
<?PHP
}

//Si el usuario es cualquier otro que no sea BANALVA se ejecuta a partir de aqui
else{
	$Usuario = $_SESSION['Usuario'];
	$conexion = Conexion();

	$consulta = mysqli_query($conexion,"Select * from empresa where Usuario = '$Usuario'");

	$resultado = mysqli_fetch_array($consulta);
	$CIF = $resultado['CIF'];
	$Ruta_albz = $resultado['Ruta_albaranes']; //ruta para comprimir
	$Ruta_facz = $resultado['Ruta_facturas'];//ruta para comprimir
	$Ruta_buzon = $resultado['Ruta_buzon']; 	//ruta para comprimir
?>
<!--Muestra la tabla con datos de otras empresas -->
<!--<a class="log" href="./editarempresa2.php"> Editar empresa </a> -->
<div class="tabla3">
<table class="ficha">


<tr>
	<td> Empresa</td>
	<td class="resultados"> <?PHP echo $resultado['Nombre']. " ";?></td>
</tr>
<tr>
	<td>CIF </td>
	<td class="resultados"><?PHP echo $resultado['CIF']. " ";?> </td>
</tr>
<tr>
	<td>Contacto </td>
	<td class="resultados"><?PHP echo $resultado['Contacto']. " ";?> </td>
</tr>
<tr>
	<td>Telefono </td>
	<td class="resultados"><?PHP echo $resultado['Telefono']. " ";?> </td>
</tr>
<tr>
	<td>e-mail </td>
	<td class="resultados"><?PHP echo $resultado['mail']. " ";?> </td>
</tr>

</table>

</div>

 <!--Contenedor-->
 <div id="vacio">&nbsp;</div>
 <div id="container">
   <?php
   $cfacturas = $_POST['cfacturas'];
   $calbaran = $_POST['calbaran'];
   $cbuzon = $_POST['cbuzon'];
   ?>
  <!--Pestaña 1 activa por defecto-->
  <input id="tab-1" type="radio" name="tab-group"
  <?php
  if ($cfacturas == 'cfacturas'){
    echo "checked=checked";
  }
  if ($cfacturas == '' AND $calbaran == '' AND $cbuzon == ''){
    echo "checked=checked";
  }
  ?>
  />
  <label for="tab-1">Facturas </label>
  <!--Pestaña 2 inactiva por defecto-->
  <input id="tab-2" type="radio" name="tab-group" <?php if ($calbaran == 'calbaran'){echo "checked=checked";}?>/>
  <label for="tab-2">Albaranes</label>
  <!--Pestaña 3 inactiva por defecto-->
  <input id="tab-3" type="radio" name="tab-group" <?php if ($cbuzon == 'cbuzon'){echo "checked=checked";}?>/>
  <label for="tab-3">Buzón</label>
  <!--Contenido a mostrar/ocultar-->
  <div id="content">
   <!--Contenido de la Pestaña 1-->
   <div id="content-1">

<table class="albaranes">
<caption>Busqueda de  Factura </caption>
<!-- Tabla Para listar factura-->

<!--Cuadros de busqueda -->
<tr>
		<td class="Factura">Numero de factura:</td>
		<td class="Factura">
      <form action="perfilbanalva.php" method="post" id="formularios">
        <input type ="text" name="BusquedaNumero" style="width:310px;" required/>
        <input type="hidden" name="cfacturas" value="cfacturas"/>
        <input type="submit" value="buscar"/>
      </form>
    </td>

</tr>
<tr>
		<td class="Factura" colspan="2">
      <form action="perfilbanalva.php" method="post" id="formularios">
         <?php echo "desde ";
         MostrarFecha();
         echo " hasta ";
         MostrarFecha2();
         ?>
         <input type="hidden" name="cfacturas" value="cfacturas"/>
         <input type="submit" value="Go!"/>
       </form>
     </td>
</tr>
<!-- Consulta y lista de facturas -->
<?PHP



	if( isset($_POST['arraydias2'])){


		$diaarray = $_POST['arraydias'];
		$mesarray = $_POST['arraymeses'];
		$anoarray = $_POST['arrayanos'];
		$fecha = "$anoarray/$mesarray/$diaarray";
		$diaarray2 = $_POST['arraydias2'];
		$mesarray2 = $_POST['arraymeses2'];
		$anoarray2 = $_POST['arrayanos2'];
		$fecha2 = "$anoarray2/$mesarray2/$diaarray2";

		$conexion = Conexion();

		$consulta2 = mysqli_query($conexion,"Select * from facturas inner join empresa ON facturas.CIF = empresa.CIF
									Where facturas.CIF = '$CIF' and fecha BETWEEN '$fecha' and '$fecha2' ");


					if (file_exists($Ruta_facz . '/facturas.zip')){
					unlink($Ruta_facz . '/facturas.zip');
					}
					else{};
					$zip = new ZipArchive;
					$zip->open($Ruta_facz . '/facturas.zip',ZipArchive::CREATE);

					while($a=mysqli_fetch_array($consulta2)){
					$zip->addFile($a['Ruta_facturas'].'/'.$a['Enlace'],$a['Enlace']);
						}

					$zip->close();

					$diaarray = $_POST['arraydias'];
					$mesarray = $_POST['arraymeses'];
					$anoarray = $_POST['arrayanos'];
					$fecha = "$anoarray/$mesarray/$diaarray";
					$diaarray2 = $_POST['arraydias2'];
					$mesarray2 = $_POST['arraymeses2'];
					$anoarray2 = $_POST['arrayanos2'];
					$fecha2 = "$anoarray2/$mesarray2/$diaarray2";

					$conexion = Conexion();

					$consulta2 = mysqli_query($conexion,"Select * from facturas inner join empresa ON facturas.CIF = empresa.CIF
												Where facturas.CIF = '$CIF' and fecha BETWEEN '$fecha' and '$fecha2' ");


					echo ("<tr><td class='facturas' colspan='2'><a style='float:clear;' href='". $Ruta_facz. "/facturas.zip'> descargar </a></td></tr>");

	}
	else if(isset($_POST['BusquedaNumero'])){
		$BusquedaNumero = $_POST['BusquedaNumero'];
		$conexion = Conexion();

		$consulta2 = mysqli_query($conexion,"Select * from facturas inner join empresa ON facturas.CIF = empresa.CIF
									Where facturas.CIF = '$CIF' and Numero_factura LIKE '$BusquedaNumero%'");
					if (file_exists($Ruta_facz . '/facturas.zip')){
					unlink($Ruta_facz . '/facturas.zip');
					}
					else{};
		$zip = new ZipArchive;
		$zip->open($Ruta_albz . '/facturas.zip',ZipArchive::CREATE);

		while($a=mysqli_fetch_array($consulta2)){
		$zip->addFile($a['Ruta_facturas'].'/'.$a['Enlace'],$a['Enlace']);
			}

		$zip->close();

		$BusquedaNumero = $_POST['BusquedaNumero'];
		$conexion = Conexion();

		$consulta2 = mysqli_query($conexion,"Select * from facturas inner join empresa ON facturas.CIF = empresa.CIF
		Where facturas.CIF = '$CIF' and Numero_factura LIKE '$BusquedaNumero%'");


		echo ("<tr><td class='facturas' colspan='2'><a style='float:clear;' href=". $Ruta_facz. "/facturas.zip> descargar </a></td></tr>");


	}
	else{

	$consulta2 = mysqli_query($conexion,"Select * from facturas inner join empresa ON facturas.CIF = empresa.CIF
								Where facturas.CIF = '$CIF' ");
						if (file_exists($Ruta_facz . '/facturas.zip')){
						unlink($Ruta_facz . '/facturas.zip');
						}
						else{};
						$zip = new ZipArchive;
						$zip->open($Ruta_facz . '/facturas.zip',ZipArchive::CREATE);

						while($a=mysqli_fetch_array($consulta2)){
						$zip->addFile($a['Ruta_facturas'].'/'.$a['Enlace'],$a['Enlace']);
							}

						$zip->close();

						echo ("<tr><td class='facturas' colspan='2'><a style='float:clear;' href=". $Ruta_facz. "/facturas.zip> descargar </a></td></tr>");

	$consulta2 = mysqli_query($conexion,"Select * from facturas inner join empresa ON facturas.CIF = empresa.CIF
								Where facturas.CIF = '$CIF' ");



	}

?>

<tr>
	<td class="Factura">Numero </td>
	<td class="Factura">Fecha</td>
<tr>

<tr>
<?PHP
	while($a=mysqli_fetch_array($consulta2)){

?>

		<td><a href="<?PHP echo $a['Ruta_facturas'].'/'.$a['Enlace']?>" target="popup" onclick="window.open('', 'popup', 'width = 650, height = 900')"><img src="./images/i_pdf.gif">   <?PHP echo $a['Numero_factura'];?></img></a></td>
		<td><?PHP echo $a['fecha'];?></td>
		</tr>
<?PHP
	}
?>
</table>

</div>
       <!--Contenido de la Pestaña 2-->
  <div id="content-2">
    <table class="albaranes">
    <caption>Busqueda de Albaranes</caption>
    <!-- Tabla Para listar albaranes y facturas-->
    <!--Cuadros de busqueda -->
      <tr>
      		<td>Numero de albaran:</td>
      		<td class="">
            <form action="perfilbanalva.php" method="post" id="formularios">
              <input type ="text" name="BusquedaNumero3" style="width:310px;" required/>
              <input type="hidden" name="calbaran" value="calbaran"/>
              <input type="submit" value="buscar"/>
            </form>
          </td>
      </tr>
      <tr>
      		<td class="Factura" colspan="2">
            <form action="perfilbanalva.php" method="post" id="formularios">
              <?php echo "desde ";
              MostrarFecha4();
              echo " hasta ";
              MostrarFecha3(); ?>
              <input type="hidden" name="calbaran" value="calbaran"/>
              <input type="submit" value="Go!"/>
            </form>
          </td>
      </tr>
<!-- Consulta para albaranes -->
<?PHP
	if( isset($_POST['arraydias3'])){
		$diaarray4 = $_POST['arraydias4'];
		$mesarray4 = $_POST['arraymeses4'];
		$anoarray4 = $_POST['arrayanos4'];
		$fecha = "$anoarray4/$mesarray4/$diaarray4";
		$diaarray3 = $_POST['arraydias3'];
		$mesarray3 = $_POST['arraymeses3'];
		$anoarray3 = $_POST['arrayanos3'];
		$fecha2 = "$anoarray3/$mesarray3/$diaarray3";

		$conexion = Conexion();

				$consulta2 = mysqli_query($conexion,"Select * from albaranes inner join empresa ON albaranes.CIF = empresa.CIF
							Where albaranes.CIF = '$CIF' and fecha BETWEEN '$fecha' and '$fecha2' ");

					if (file_exists($Ruta_albz . '/Albaranes.zip')){
					unlink($Ruta_albz . '/Albaranes.zip');
					}
					else{};
						$zip = new ZipArchive;
						$zip->open($Ruta_albz . '/Albaranes.zip',ZipArchive::CREATE);

						while($a=mysqli_fetch_array($consulta2)){
						$zip->addFile($a['Ruta_albaranes'].'/'.$a['Enlace'],$a['Enlace']);
							}

						$zip->close();

							$diaarray4 = $_POST['arraydias4'];
							$mesarray4 = $_POST['arraymeses4'];
							$anoarray4 = $_POST['arrayanos4'];
							$fecha = "$anoarray4/$mesarray4/$diaarray4";
							$diaarray3 = $_POST['arraydias3'];
							$mesarray3 = $_POST['arraymeses3'];
							$anoarray3 = $_POST['arrayanos3'];
							$fecha2 = "$anoarray3/$mesarray3/$diaarray3";

						$conexion = Conexion();

						$consulta2 = mysqli_query($conexion,"Select * from albaranes inner join empresa ON albaranes.CIF = empresa.CIF
													Where albaranes.CIF = '$CIF' and fecha BETWEEN '$fecha' and '$fecha2' ");


						echo ("<tr><td class='albaranes' colspan='2'><a style='float:clear;' href=". $Ruta_albz. "/Albaranes.zip> descargar </a></td></tr>");

	}
	else if(isset($_POST['BusquedaNumero3'])){
		$BusquedaNumero3 = $_POST['BusquedaNumero3'];
		$conexion = Conexion();

		$consulta2 = mysqli_query($conexion,"Select * from albaranes inner join empresa ON albaranes.CIF = empresa.CIF
									Where albaranes.CIF = '$CIF' and Numero_albaran LIKE '$BusquedaNumero3%'");

				if (file_exists($Ruta_albz . '/Albaranes.zip')){
				unlink($Ruta_albz . '/Albaranes.zip');
				}
				else{};
					$zip = new ZipArchive;
					$zip->open($Ruta_albz . '/Albaranes.zip',ZipArchive::CREATE);

					while($a=mysqli_fetch_array($consulta2)){
					$zip->addFile($a['Ruta_albaranes'].'/'.$a['Enlace'],$a['Enlace']);
						}

					$zip->close();

					$BusquedaNumero3 = $_POST['BusquedaNumero3'];
					$conexion = Conexion();

					$consulta2 = mysqli_query($conexion,"Select * from albaranes inner join empresa ON albaranes.CIF = empresa.CIF
					Where albaranes.CIF = '$CIF' and Numero_albaran LIKE '$BusquedaNumero3%'");


					echo ("<tr><td class='albaranes' colspan='2'><a style='float:clear;' href=". $Ruta_albz. "/Albaranes.zip> descargar </a></td></tr>");

}
	else{

	$consulta2 = mysqli_query($conexion,"Select * from albaranes inner join empresa ON albaranes.CIF = empresa.CIF
								Where albaranes.CIF = '$CIF' ");

				if (file_exists($Ruta_albz . '/Albaranes.zip')){
				unlink($Ruta_albz . '/Albaranes.zip');
				}
				else{};
					$zip = new ZipArchive;
					$zip->open($Ruta_albz . '/Albaranes.zip',ZipArchive::CREATE);

					while($a=mysqli_fetch_array($consulta2)){
					$zip->addFile($a['Ruta_albaranes'].'/'.$a['Enlace'],$a['Enlace']);
						}

					$zip->close();

					echo ("<tr><td class='Facturas' colspan='2'><a style='float:clear;' href=". $Ruta_albz. "/Albaranes.zip> descargar </a></td></tr>");

	$consulta2 = mysqli_query($conexion,"Select * from albaranes inner join empresa ON albaranes.CIF = empresa.CIF
	Where albaranes.CIF = '$CIF' ");


	}
?>
<tr>
	<td class="albaranes">Numero </td>
	<td class="albaranes">Fecha</td>
<tr>
<tr>
<?PHP
	while($a=mysqli_fetch_array($consulta2)){

?>

		<td><a href="<?PHP echo $a['Ruta_albaranes'].'/'.$a['Enlace']?>" target="popup" onclick="window.open('', 'popup', 'width = 650, height = 900')"><img src="./images/i_pdf.gif">    <?PHP echo $a['Numero_albaran'];?></a></img></td>
		<td><?PHP echo $a['fecha'];?></td>
		</tr>
<?PHP
	}
?>

</table>
   </div>
   <!--Contenido de la Pestaña 3-->
   <div id="content-3">
    <table class="albaranes">
    <caption>Busqueda de Documentos</caption>
    <!-- Tabla Para listar Documentos -->
    <!--Cuadros de busqueda -->
        <tr>
        		<td class="">Nombre Documento:</td>
        		<td class="">
              <form action="perfilbanalva.php" method="post" id="formularios">
                <input type ="text" name="BusquedaNombre" style="width:310px;" required/>
                <input type="hidden" name="cbuzon" value="cbuzon"/>
                <input type="submit" value="buscar"/>
              </form>
            </td>
        </tr>

<!-- Consulta para Documentos -->
<?PHP

	if(isset($_POST['BusquedaNombre'])){
		$BusquedaNombre = $_POST['BusquedaNombre'];
		$conexion = Conexion();

		$consulta3 = mysqli_query($conexion,"Select * from buzon inner join empresa ON buzon.CIF = empresa.CIF
									Where buzon.CIF = '$CIF' and Nombre_Buzon LIKE '$BusquedaNombre%'");

				if (file_exists($Ruta_buzon . '/Documentos.zip')){
				unlink($Ruta_buzon . '/Documentos.zip');
				}
				else{};
					$zip = new ZipArchive;
					$zip->open($Ruta_buzon . '/Documentos.zip',ZipArchive::CREATE);

					while($a=mysqli_fetch_array($consulta3)){
					$zip->addFile($a['Ruta_buzon'].'/'.$a['Enlace'],$a['Enlace']);
						}

					$zip->close();

					$BusquedaNombre = $_POST['BusquedaNombre'];
					$conexion = Conexion();

					$consulta3 = mysqli_query($conexion,"Select * from buzon inner join empresa ON buzon.CIF = empresa.CIF
					Where buzon.CIF = '$CIF' and Nombre_Buzon LIKE '$BusquedaNombre%'");


					echo ("<tr><td class='Facturas' colspan='2'><a style='float:clear;' href=". $Ruta_buzon. "/Documentos.zip> descargar </a></td></tr>");

}
	else{

	$consulta3 = mysqli_query($conexion,"Select * from buzon inner join empresa ON buzon.CIF = empresa.CIF
								Where buzon.CIF = '$CIF' ");

				if (file_exists($Ruta_albz . '/Documentos.zip')){
				unlink($Ruta_albz . '/Documentos.zip');
				}
				else{};
					$zip = new ZipArchive;
					$zip->open($Ruta_albz . '/Documentos.zip',ZipArchive::CREATE);

					while($a=mysqli_fetch_array($consulta3)){
					$zip->addFile($a['Ruta_buzon'].'/'.$a['Enlace'],$a['Enlace']);
						}

					$zip->close();

					echo ("<tr><td class='Facturas' colspan='2'><a style='float:clear;' href=". $Ruta_albz. "/Documentos.zip> descargar </a></td></tr>");

	$consulta3 = mysqli_query($conexion,"Select * from buzon inner join empresa ON buzon.CIF = empresa.CIF
	Where buzon.CIF = '$CIF' ");


	}
?>
<tr>
	<td class="albaranes">Nombre </td>

<tr>
<tr>
<?PHP
	while($a=mysqli_fetch_array($consulta3)){

?>

		<td><a href="<?PHP echo $a['Ruta_buzon'].'/'.$a['Enlace']?>" target="popup" onclick="window.open('', 'popup', 'width = 650, height = 900')"><img src="./images/i_pdf.gif">    <?PHP echo $a['Nombre_Buzon'];?></a></img></td>
		</tr>
<?PHP
	}
?>

</table>
   </div>
  </div>
 </div>
 <?PHP
}
?>
</body>
</html>
