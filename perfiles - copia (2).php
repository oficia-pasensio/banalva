<!Doctype HTML>
<?php
error_reporting(1);
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
  $_SESSION['NombreEmpresa'] = $_POST['NombreEmpresa'];
  IF ($_POST['NombreEmpresa']){
	$Nomem = $_POST['NombreEmpresa'];
  }
  ELSE{
    $Nomem = $_SESSION['NombreEmpresa'];
  }
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
<a href="perfilbanalva.php" class="log"> Volver atras </a>
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
  <input id="tab-1" type="radio" name="tab-group" <?php if ($cfacturas == 'cfacturas'){echo "checked=checked";}if ($cfacturas == '' AND $calbaran == '' AND $cbuzon == ''){echo "checked=checked";}?>/>
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
                <form action="perfiles.php" method="post" id="formularios">
                  <input type ="text" name="BusquedaNumero" style="width:310px;" required/>
                  <input type="hidden" name="cfacturas" value="cfacturas"/>
                  <input type="hidden" name="NombreEmpresa" value=<?php echo "$Nomem"; ?>>
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
                    <input type="hidden" name="cfacturas" value="cfacturas"/>
                    <input type="hidden" name="NombreEmpresa" value=<?php echo "$Nomem"; ?>>
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
 </tr>

 <tr>
   <form  action="" method="post" id="formularios">
 <?PHP
 foreach($_POST['EFactura'] as $EFactura){
    $userb = $resultado['Usuario'];
    $ARCHIVO = "Empresa/$userb/factura/$EFactura.pdf";
    mysqli_query($conexion,"DELETE FROM facturas WHERE CIF = '$Nomem' AND Numero_factura = '$EFactura'");
    unlink ($ARCHIVO);
    $consulta2 = mysqli_query($conexion,"Select * from facturas inner join empresa ON facturas.CIF = empresa.CIF
                  Where facturas.CIF = '$CIF' ");
    $a=mysqli_fetch_array($consulta2);
};
  while($a=mysqli_fetch_array($consulta2)){
 ?>
    <td>
        <input type="checkbox" name="EFactura[]" value="<?PHP echo $a['Numero_factura'];?>" />
        <input type="hidden" name="NombreEmpresa" value=<?php echo "$Nomem"; ?>>
        <a href="<?PHP echo $a['Ruta_facturas'].'/'.$a['Enlace']?>" target="popup" onclick="window.open('', 'popup', 'width = 650, height = 900')">
            <img src="./images/i_pdf.gif">
              <?PHP echo $a['Numero_factura'];?>
            </img>
        </a>
    </td>
    <td>
      <?PHP echo $a['fecha'];?>
    </td>
    </tr>
 <?PHP
  }
 ?>
 </table>
 <input class="submitt" type="submit" value="Eliminar">
 </form>
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
            <form action="" method="post" id="formularios">
              <input type ="text" name="BusquedaNumero3" style="width:310px;" required/>
              <input type="hidden" name="calbaran" value="calbaran"/>
              <input type="hidden" name="NombreEmpresa" value=<?php echo "$Nomem"; ?>>
              <input type="submit" value="buscar"/>
            </form>
          </td>
      </tr>
      <tr>
          <td class="Factura" colspan="2">
            <form action="" method="post" id="formularios">
              <?php echo "desde ";
              MostrarFecha4();
              echo " hasta ";
              MostrarFecha3(); ?>
              <input type="hidden" name="calbaran" value="calbaran"/>
              <input type="hidden" name="NombreEmpresa" value=<?php echo "$Nomem"; ?>/>
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
            echo ("<tr><td class='albaranes' colspan='2'><a style='float:clear;' target=_blank href=". $Ruta_albz. "/Albaranes.zip> descargar </a></td></tr>");
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
		  $fecha_MES= date("Y") . "/" . date('m', strtotime('-1 month')) . "/" . date("d");
$fecha_ACTUAL=date ("Y") . "/" . date("m") . "/" . date("d");
	//DATOS CARGA 1 MES	  
	$consulta2 = mysqli_query($conexion,"Select * from albaranes inner join empresa ON albaranes.CIF = empresa.CIF
                Where albaranes.CIF = '$CIF' and fecha BETWEEN '$fecha_MES' and '$fecha_ACTUAL' ");
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
		  Where albaranes.CIF = '$CIF' and fecha BETWEEN '$fecha_MES' and '$fecha_ACTUAL'");
  }
 ?>
 <tr>
  <td class="albaranes">Numero </td>
  <td class="albaranes">Fecha</td>
  </tr>
 <tr>
   <form  action="" method="post" id="formularios">
  <tr>
 <?PHP
 $fecha_MES= date("Y") . "/" . date('m', strtotime('-1 month')) . "/" . date("d");
$fecha_ACTUAL=date ("Y") . "/" . date("m") . "/" . date("d");
 foreach($_POST['EAlbaran'] as $EAlbaran){
    //echo $EAlbaran."<br>";
    $userb = $resultado['Usuario'];
    $ARCHIVO = "Empresa/$userb/albaran/$EAlbaran.pdf";
    mysqli_query($conexion,"DELETE FROM albaranes WHERE CIF = '$Nomem' AND Numero_albaran = '$EAlbaran'");
    unlink ($ARCHIVO);
    $consulta2 = mysqli_query($conexion,"Select * from albaranes inner join empresa ON albaranes.CIF = empresa.CIF
                  Where albaranes.CIF = '$CIF' and fecha BETWEEN '$fecha_MES' and '$fecha_ACTUAL' ");
    $a=mysqli_fetch_array($consulta2);
};
  while($a=mysqli_fetch_array($consulta2)){
 ?>
    <td>
      <input type="checkbox" name="EAlbaran[]" value="<?PHP echo $a['Numero_albaran'];?>" />
      <input type="hidden" name="NombreEmpresa" value=<?php echo "$Nomem"; ?> />
      <input type="hidden" name="calbaran" value="calbaran"/>
      <a href="<?PHP echo $a['Ruta_albaranes'].'/'.$a['Enlace']?>" target="popup" onclick="window.open('', 'popup', 'width = 650, height = 900')">
        <img src="./images/i_pdf.gif">
        <?PHP
          echo $a['Numero_albaran'];
        ?>
        </a>
        </img>
    </td>
    <td><?PHP echo $a['fecha'];?></td>
    </tr>
 <?PHP
  }
 ?>
 </table>
  <input class="submitt" type="submit" value="Eliminar">
</form>
</tr>
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
              <form action="" method="post" id="formularios">
                <input type ="text" name="BusquedaNombre" style="width:310px;" required/>
                <input type="hidden" name="cbuzon" value="cbuzon"/>
                <input type="hidden" name="NombreEmpresa" value=<?php echo "$Nomem"; ?>>
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
          echo ("<tr><td class='Facturas' colspan='2'><a style='float:clear;' target=_blank href=". $Ruta_albz. "/Documentos.zip> descargar </a></td></tr>");
  $consulta3 = mysqli_query($conexion,"Select * from buzon inner join empresa ON buzon.CIF = empresa.CIF
  Where buzon.CIF = '$CIF' ");
  }
 ?>
 <tr>
  <td class="albaranes">Nombre </td>
<form  action="" method="post" id="formularios">
 <tr>
 <tr>
 <?PHP
 foreach($_POST['EBuzon'] as $EBuzon){
    //echo $EBuzon."<br>";
    $userb = $resultado['Usuario'];
    $ARCHIVO = "Empresa/$userb/Buzon/$EBuzon.pdf";
    mysqli_query($conexion,"DELETE FROM buzon WHERE CIF = '$Nomem' AND Nombre_Buzon = '$EBuzon'");
    unlink ($ARCHIVO);
    $consulta3 = mysqli_query($conexion,"Select * from buzon inner join empresa ON buzon.CIF = empresa.CIF
    Where buzon.CIF = '$CIF' ");
    $a=mysqli_fetch_array($consulta3);
};
  while($a=mysqli_fetch_array($consulta3)){
 ?>
    <td>
      <input type="checkbox" name="EBuzon[]" value="<?PHP echo $a['Nombre_Buzon'];?>" />
      <input type="hidden" name="cbuzon" value="cbuzon"/>
      <input type="hidden" name="NombreEmpresa" value=<?php echo "$Nomem"; ?> />
      <a href="<?PHP echo $a['Ruta_buzon'].'/'.$a['Enlace']?>" target="popup" onclick="window.open('', 'popup', 'width = 650, height = 900')">
        <img src="./images/i_pdf.gif">
           <?PHP
           echo $a['Nombre_Buzon'];
           ?>
         </a>
       </img>
     </td>
    </tr>
 <?PHP
  }
 ?>
 </table>
 <input class="submitt" type="submit" value="Eliminar">
 </form>
   </div>
  </div>
 </div>
</body>
</html>
