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
	$Nomem = $_POST['NombreEmpresa'];
	$cfacturas = $_POST['cfactuas'];
  $calbaran = $_POST['calbaran'];
  $cbuzon = $_POST['cbuzon'];
	$conexion = Conexion();

	$consulta = mysqli_query($conexion,"Select * from empresa where CIF = '$Nomem'");

	$resultado = mysqli_fetch_array($consulta);
//Esta variable es para que más adelante se listen bien las facturas
	$CIF = $resultado['CIF'];
	$Ruta_albz = $resultado['Ruta_albaranes']; //ruta para comprimir
	$Ruta_facz = $resultado['Ruta_facturas']; //ruta para comprimir
	$Ruta_buzon = $resultado['Ruta_buzon']; // ruta para comprimir
?>
<!-- Tabla perfil -->
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

      <div>
        <a href="perfilbanalva.php" class="atras"> Volver atras </a>
      </div>

 <!--Contenedor-->
      <div id="container">

          <!--Pestaña 1 activa por defecto-->
          <input id="tab-1" type="radio" name="tab-group" <?php if ($cfacturas == 'cfacturas'){echo "checked=checked";}?> />
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
       <table class="Factura">
         <caption>Busqueda de facturas</caption>
         <!-- Tabla Para listar albaranes y facturas-->
         <!--Cuadros de busqueda -->
        <tr>
		        <td class="Factura">Numero de factura:</td>
		        <td class="Factura">
  			      <form action="" method="post" id="formularios">
        				<input type ="text" name="BusquedaNumero" style="width:310px;"/>
        				<input type="hidden" name="cfacturas" value="<?php echo 'cfacturas';?>"/>
        				<input type="hidden" name="NombreEmpresa" value="<?php echo $Nomem;?>" />
        				<input type="submit" value="buscar"/>
  			      </form>
		        </td>
      </tr>
      <tr>
		      <td class="Factura" colspan="2">
            <form action="" method="post" id="formularios">
            <?php
             echo "desde ";
             MostrarFecha();
             echo " hasta ";
             MostrarFecha2();
             ?>
             <input type="hidden" name="NombreEmpresa" value="<?php echo $Nomem;?>"/> <input type="hidden" name="cfacturas" value=<?php echo 'cfacturas';?>/> <input type="submit" value="Go!"/>
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
		      $consulta = mysqli_query($conexion,"Select * from facturas inner join empresa ON facturas.CIF = empresa.CIF
									Where facturas.CIF = '$CIF' and fecha BETWEEN '$fecha' and '$fecha2' ");
  				if (file_exists($Ruta_facz . '/facturas.zip')){
  					unlink($Ruta_facz . '/facturas.zip');
  					}
					else{

          };
					$zip = new ZipArchive;
					$zip->open($Ruta_facz . '/facturas.zip',ZipArchive::CREATE);
					while($a=mysqli_fetch_array($consulta)){
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
					/*$consulta = mysqli_query($conexion,"Select * from facturas inner join empresa ON facturas.CIF = empresa.CIF
												Where facturas.CIF = '$CIF' and fecha BETWEEN '$fecha' and '$fecha2' ");*/
					//echo "<form action= method=post id=formularios><input type=hidden name=cfacturas value=cfacuras /> </form>";
					echo ("<tr><td class='facturas' colspan='2'><a style='float:clear;' href='". $Ruta_facz. "/facturas.zip'> descargar</a></td></tr>");

	    }
	     else if($_POST['BusquedaNumero'] == ''){

          //else if(isset($_POST['BusquedaNumero']))
  	      $BusquedaNumero = $_POST['BusquedaNumero'];
  	      $conexion = Conexion();
          $consulta = mysqli_query($conexion,"Select * from facturas inner join empresa ON facturas.CIF = empresa.CIF
  									   Where facturas.CIF = '$CIF' and Numero_factura = '$BusquedaNumero'");
  		    if (file_exists($Ruta_facz . '/facturas.zip')){
  		        unlink($Ruta_facz . '/facturas.zip');
  		    }
          else{

          };
      		$zip = new ZipArchive;
      		$zip->open($Ruta_facz . '/facturas.zip',ZipArchive::CREATE);
  		    while($a=mysqli_fetch_array($consulta)){
  		    $zip->addFile($a['Ruta_facturas'].'/'.$a['Enlace'],$a['Enlace']);
  			  }
		      $zip->close();
      		$BusquedaNumero = $_POST['BusquedaNumero'];
      		$conexion = Conexion();
		      /*$consulta = mysqli_query($conexion,"Select * from facturas inner join empresa ON facturas.CIF = empresa.CIF
		      Where facturas.CIF = '$CIF' and Numero_factura = '$BusquedaNumero'");	*/
		      //			echo "<form action= method=post id=formularios><input type=hidden name=cfacturas value=cfacuras /> </form>";

		      echo ("<tr><td class='facturas' colspan='2'><a style='float:clear;' href='". $Ruta_facz. "/facturas.zip'> descargar </a></td></tr>");
      }
	    else{
          $consulta = mysqli_query($conexion,"Select * from facturas inner join empresa ON facturas.CIF = empresa.CIF
								Where facturas.CIF = '$CIF' ");
          if (file_exists($Ruta_facz . '/facturas.zip')){
					       unlink($Ruta_facz . '/facturas.zip');
					}
					else{

          };
					$zip = new ZipArchive;
					$zip->open($Ruta_facz . '/facturas.zip',ZipArchive::CREATE);
					while($a=mysqli_fetch_array($consulta2)){
					$zip->addFile($a['Ruta_facturas'].'/'.$a['Enlace'],$a['Enlace']);
					}
					$zip->close();
					echo ("<tr><td class='facturas' colspan='2'><a style='float:clear;' href='". $Ruta_facz. "/facturas.zip'> descargar </a></td></tr>");
	         /*$consulta2 = mysqli_query($conexion,"Select * from facturas inner join empresa ON facturas.CIF = empresa.CIF
								Where facturas.CIF = '$CIF' ");	*/
	  }

?>
      <tr>
  		    <td class="Factura" colspan="2"><input type="hidden" name="comprimirF" value="yes" /></form></td>
      </tr>
      <tr>
  	     <td class="Factura">Numero </td>
  	     <td class="Factura">Fecha</td>
      <tr>
      <tr>

<?PHP

  	  while($a=mysqli_fetch_array($consulta)){

?>

		  <td><a href="<?PHP echo $a['Ruta_facturas'].'/'.$a['Enlace']?>" target="popup" onclick="window.open('', 'popup', 'width = 650, height = 900')"><img src="./images/i_pdf.gif">   <?PHP echo $a['Numero_factura'];?></a></img></td>
		  <td><?PHP echo $a['fecha'];?></td>
	    </tr>
<?PHP
	}
?>
  </table>
  </div>
   <!--Contenido de la Pestaña 2-->
   <div id="content-2">
     <!-- Consulta y lista de albaranes -->
     <table class="albaranes">
     <caption>Busqueda de albaranes</caption>
    <!-- Tabla Para listar albaranes y facturas-->
    <!--Cuadros de busqueda -->
      <tr>
    		<td class="albaranes">Numero de albaran:</td>
    		<td class="albaranes">
    			<form action="" method="post" id="formularios">
    				<input type="hidden" name="comprimirA" value="yes" />
    					<input type ="text" name="BusquedaNumero3" style="width:310px;"  />
    					<input type="hidden" name="NombreEmpresa" value="<?php echo $Nomem;?>" />
              <input type="hidden" name="calbaran" value=<?php echo 'calbaran';?>/>
    					<input type="submit" value="buscar"/>
    			</form>
		      </td>

    </tr>
    <tr>
		    <td class="albaranes" colspan="2"><form action="" method="post" id="formularios"> <?php echo "desde "; MostrarFecha4();echo " hasta "; MostrarFecha3(); ?> <input type="submit" value="Go!"/><input type="hidden" name="NombreEmpresa" value=<?php echo $Nomem;?> /></td>
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


											echo ("<tr><td class='albaranes' colspan='2'><a style='float:clear;' href='". $Ruta_albz. "/Albaranes.zip'> descargar </a></td></tr>");

	}
	// NUMERO ALBARANES
	else if($_POST['BusquedaNumero3'] !==  ''){

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

						echo ("<tr><td class='albaranes' colspan='2'><a style='float:clear;' href=". $Ruta_albz. "/Albaranes.zip> descargar </a></td></tr>");

		$consulta2 = mysqli_query($conexion,"Select * from albaranes inner join empresa ON albaranes.CIF = empresa.CIF
		Where albaranes.CIF = '$CIF' ");



	}
?>
<tr>

		<td class="albaranes" colspan="2"><input type="hidden" name="comprimirA" value="yes" /></form></td>
</tr>
<tr>
	<td class="albaranes">Numero </td>
	<td class="albaranes">Fecha</td>
<tr>



<?PHP

	while($b=mysqli_fetch_array($consulta2)){

?>

		<td><a href="<?PHP echo $b['Ruta_albaranes'].'/'.$b['Enlace']?>" target="popup" onclick="window.open('', 'popup', 'width = 650, height = 900')"><img src="./images/i_pdf.gif">   <?PHP echo $b['Numero_albaran'];?></a></img></td>
		<td><?PHP echo $b['fecha'];?></td>
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
		<td class="albaranes">Nombre Documento:</td>
		<td class="albaranes"><form action="" method="post" id="formularios"><input type ="text" name="BusquedaNombre" style="width:310px;" required/><input type="hidden" name="NombreEmpresa" value=<?php echo $Nomem;?> <input type="submit" value="buscar"/> </form></td>
</tr>

<!-- Consulta para Documentos -->
<?PHP
	if($_POST['BusquedaNombre'] !==  ''){
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

					while($c=mysqli_fetch_array($consulta3)){
					$zip->addFile($c['Ruta_buzon'].'/'.$c['Enlace'],$c['Enlace']);
						}

					$zip->close();

					$BusquedaNombre = $_POST['BusquedaNombre'];
					$conexion = Conexion();

					/*$consulta4 = mysqli_query($conexion,"Select * from buzon inner join empresa ON buzon.CIF = empresa.CIF
					Where buzon.CIF = '$CIF' and Nombre_Buzon LIKE '$BusquedaNombre%'");	*/


					echo ("<tr><td class='albaranes' colspan='2'><a style='float:clear;' href=". $Ruta_buzon. "/Documentos.zip> descargar </a></td></tr>");

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

					while($c=mysqli_fetch_array($consulta3)){
					$zip->addFile($c['Ruta_buzon'].'/'.$c['Enlace'],$c['Enlace']);
						}

					$zip->close();

					echo ("<tr><td class='albaranes' colspan='2'><a style='float:clear;' href=". $Ruta_albz. "/Documentos.zip> descargar </a></td></tr>");

	/*$consulta4 = mysqli_query($conexion,"Select * from buzon inner join empresa ON buzon.CIF = empresa.CIF
	Where buzon.CIF = '$CIF' ");	*/
	}


?>
<tr>
	<td class="albaranes">Nombre </td>

<tr>
<tr>
<?PHP
	while($c=mysqli_fetch_array($consulta3)){

?>

		<td><a href="<?PHP echo $c['Ruta_buzon'].'/'.$c['Enlace']?>" target="popup" onclick="window.open('', 'popup', 'width = 650, height = 900')"><img src="./images/i_pdf.gif">    <?PHP echo $a['Nombre_Buzon'];?></a></img></td>
		</tr>
<?PHP
	}
?>

</table>
   </div>
  </div>
 </div>

</body>
</html>
