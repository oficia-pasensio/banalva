<?PHP 
 error_reporting(0);
function calcularEdad($fecha) {
    $dt = new DateTime();
    $fecha = DateTime::createFromFormat("d/m/Y", $fecha);
    $diff = $dt->diff($fecha);
    
    return $diff->format("%Y%");
    
    
}

function pruebaG(){
	
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
?>