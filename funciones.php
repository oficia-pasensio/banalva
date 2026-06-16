<?php
 error_reporting(0);
//CONEXION BASE DE DATOS
function Conexion() {
    include "databases.php";
    try {
        $mysql = new mysqli($datos['h'], $datos['u'], $datos['p'], $datos['d']);
        if ($mysql->connect_errno) throw new Exception("Error al conectar con la base de datos");
        // El cliente se pone en codificacion UTF-8
        $mysql->query("SET NAMES UTF8");
        if ($mysql->error) throw new Exception("Error al cambiar la codificacion");
    } catch (Exception $e) {
        die($e->getMessage());
    }
    return $mysql;
}
//BORRADO DE DIRECTORIO
 function eliminarDir($carpeta)
 {
   foreach(glob($carpeta . "/*") as $archivos_carpeta)
    {
       echo $archivos_carpeta;
       if (is_dir($archivos_carpeta))
       {
            eliminarDir($archivos_carpeta);
        }
       else
       {
            unlink($archivos_carpeta);
            echo $archivos_carpeta;
        }
    }
echo $carpeta;
   rmdir($carpeta);
 }
 //DIFERENCIA EDAD
function calcularEdad($fecha) {
    $dt = new DateTime();
    $fecha = DateTime::createFromFormat("d/m/Y", $fecha);
    $diff = $dt->diff($fecha);
    return $diff->format("%Y%");
}
function MostrarFecha(){
	// FECHA
									$ARRAYDIAS = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
											echo "<select name='arraydias'>";
											for ($i = 0; $i < 31; $i++) {
												  echo "<option value='".$ARRAYDIAS[$i]."'>".$ARRAYDIAS[$i]."</option>";
												  }
											echo "</select>";
									$ARRAYMESES = array(
									1 => "Enero"  ,
									2 => "Febrero",
									3 => "Marzo",
									4 => "Abril",
									5 => "Mayo",
									6 => "Junio",
									7 => "Julio",
									8 => "Agosto",
									9 => "Septiembre",
									10 => "Octubre",
									11 => "Noviembre",
									12 => "Diciembre",
									);
											echo "<select name='arraymeses'>";
											for ($i = 1; $i <= 12; $i++) {
												  echo "<option value='".$i."'>".$ARRAYMESES[$i]."</option>";
												  }
											echo "</select>";
											$anoactual2 = "01/01/1900";
											$anoactual = DATE("Y");
											$LONG = $anoactual - 1900;
											$prueba = CalcularEdad($anoactual2);
									$ARRAYANOS = array();
									for ($a = $anoactual; $a >= 1900; $a--){
									array_push($ARRAYANOS, $a);
									}
											echo "<select name='arrayanos'>";
											for ($i = 0; $i <= $prueba; $i++) {
												  echo "<option value='".$ARRAYANOS[$i]."'>".$ARRAYANOS[$i]."</option>";
												  }
											echo "</select>";
}
function MostrarFecha2(){
	// FECHA
									$ARRAYDIAS = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
											echo "<select name='arraydias2'>";
											for ($i = 0; $i < 31; $i++) {
												  echo "<option value='".$ARRAYDIAS[$i]."'>".$ARRAYDIAS[$i]."</option>";
												  }
											echo "</select>";
									$ARRAYMESES = array(
									1 => "Enero"  ,
									2 => "Febrero",
									3 => "Marzo",
									4 => "Abril",
									5 => "Mayo",
									6 => "Junio",
									7 => "Julio",
									8 => "Agosto",
									9 => "Septiembre",
									10 => "Octubre",
									11 => "Noviembre",
									12 => "Diciembre",
									);
											echo "<select name='arraymeses2'>";
											for ($i = 1; $i <= 12; $i++) {
												  echo "<option value='".$i."'>".$ARRAYMESES[$i]."</option>";
												  }
											echo "</select>";
											$anoactual2 = "01/01/1900";
											$anoactual = DATE("Y");
											$LONG = $anoactual - 1900;
											$prueba = CalcularEdad($anoactual2);
									$ARRAYANOS = array();
									for ($a = $anoactual; $a >= 1900; $a--){
									array_push($ARRAYANOS, $a);
									}
											echo "<select name='arrayanos2'>";
											for ($i = 0; $i <= $prueba; $i++) {
												  echo "<option value='".$ARRAYANOS[$i]."'>".$ARRAYANOS[$i]."</option>";
												  }
											echo "</select>";
}
function MostrarFecha3(){
	// FECHA
									$ARRAYDIAS = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
											echo "<select name='arraydias3'>";
											for ($i = 0; $i < 31; $i++) {
												  echo "<option value='".$ARRAYDIAS[$i]."'>".$ARRAYDIAS[$i]."</option>";
												  }
											echo "</select>";
									$ARRAYMESES = array(
									1 => "Enero"  ,
									2 => "Febrero",
									3 => "Marzo",
									4 => "Abril",
									5 => "Mayo",
									6 => "Junio",
									7 => "Julio",
									8 => "Agosto",
									9 => "Septiembre",
									10 => "Octubre",
									11 => "Noviembre",
									12 => "Diciembre",
									);
											echo "<select name='arraymeses3'>";
											for ($i = 1; $i <= 12; $i++) {
												  echo "<option value='".$i."'>".$ARRAYMESES[$i]."</option>";
												  }
											echo "</select>";
											$anoactual2 = "01/01/1900";
											$anoactual = DATE("Y");
											$LONG = $anoactual - 1900;
											$prueba = CalcularEdad($anoactual2);
									$ARRAYANOS = array();
									for ($a = $anoactual; $a >= 1900; $a--){
									array_push($ARRAYANOS, $a);
									}
											echo "<select name='arrayanos3'>";
											for ($i = 0; $i <= $prueba; $i++) {
												  echo "<option value='".$ARRAYANOS[$i]."'>".$ARRAYANOS[$i]."</option>";
												  }
											echo "</select>";
}
function MostrarFecha4(){
	// FECHA
									$ARRAYDIAS = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
											echo "<select name='arraydias4'>";
											for ($i = 0; $i < 31; $i++) {
												  echo "<option value='".$ARRAYDIAS[$i]."'>".$ARRAYDIAS[$i]."</option>";
												  }
											echo "</select>";
									$ARRAYMESES = array(
									1 => "Enero"  ,
									2 => "Febrero",
									3 => "Marzo",
									4 => "Abril",
									5 => "Mayo",
									6 => "Junio",
									7 => "Julio",
									8 => "Agosto",
									9 => "Septiembre",
									10 => "Octubre",
									11 => "Noviembre",
									12 => "Diciembre",
									);
											echo "<select name='arraymeses4'>";
											for ($i = 1; $i <= 12; $i++) {
												  echo "<option value='".$i."'>".$ARRAYMESES[$i]."</option>";
												  }
											echo "</select>";
											$anoactual2 = "01/01/1900";
											$anoactual = DATE("Y");
											$LONG = $anoactual - 1900;
											$prueba = CalcularEdad($anoactual2);
									$ARRAYANOS = array();
									for ($a = $anoactual; $a >= 1900; $a--){
									array_push($ARRAYANOS, $a);
									}
											echo "<select name='arrayanos4'>";
											for ($i = 0; $i <= $prueba; $i++) {
												  //if $ARRAYANO[$i] =
												  echo "<option value='".$ARRAYANOS[$i]."'>".$ARRAYANOS[$i]."</option>";
												  }
											echo "</select>";
}
function listarEmpresas(){
			mysqli_close($conexion);
			$conexion = Conexion();
			$consulta2 = mysqli_query($conexion,"Select * from empresa where Nombre != 'Banalva S.L'");
			while($a=mysqli_fetch_array($consulta2)){
			echo	"<option value=" .$a['CIF']. ">".$a['Nombre']."</option>";
			}
}
function remove_accent($str)
{
  $acentos = array(' ','À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
  $sustituir = array('','A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
  return str_replace($acentos, $sustituir, $str);
}
?>
