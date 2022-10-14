<?php
// Enter your code here, enjoy!


$uno = "Se ha iniciado la sesion del usuario admin";
$dos = "Se ha cerrado la sesion del usuario admin";
$tres = "Error de conexion a internet";
$cuatro =  "Intento de ingreso no autorizado a modulo  por usuario Administrator";




generarBitacora();

    function generarBitacora(){ 
        $registros = array();
        $x = 0;
        $dias = 31; 
        $num = 108726;  
        $fanterior = "2022-01-01T01:01:01-06:00";
		$diaAnterior = 1;
        for($i = 1; $i<=$dias; $i++){
        $no = rand(4, 7);
            for($a = 0; $a < $no; $a++){

                $date1 = DateTime::createFromFormat('Y-m-d', '2022-08-'.$i);
                $tipo = rand(1, 3);
                
                if($tipo == 1){
                    $t = 1;
                    $subt = rand(1, 2);
                    if($subt == 1){
                        $evento = "Se ha iniciado la sesion del usuario admin";
                    }else if ($tipo == 2){
                        $evento = "Se ha cerrado la sesion del usuario admin";
                    }

                }else if ($tipo == 2){
                    $subt = 4;
                    $evento = "Error de conexion a internet";
                }else if ($tipo == 3){
                    $subt = 5;
                    $evento = "Intento de ingreso no autorizado a modulo  por usuario Administrator";
                }


                restart:

				if($i == $diaAnterior){
				$hora =  rand(1, 23);	
				}else{
					$hora = 6;
				}
                
                $min =  rand(1, 59);
                $seg =  rand(1, 59);

                $datetime = new DateTime('2022-08-'.$i.' '.$hora.':'.$min.':'.$seg.' -06:00'); 
                $d = $datetime->format(DATE_ATOM);
                if($d<$fanterior){
                    goto restart;
                } 


                $registros[$x]["NumeroRegistro"] = $num;
                $registros[$x]["FechaYHoraEvento"] = $d;
                $registros[$x]["UsuarioResponsable"] = "administrador";
                $registros[$x]["TipoEvento"] = $subt;
                $registros[$x]["DescripcionEvento"] = $evento;
                $x++;
                $num++;
                $fanterior = $d;
				$diaAnterior = $i;
            }

        }


        

        $json =  json_encode($registros, JSON_PRETTY_PRINT);    
        echo "<pre>"; 
        echo json_encode(json_decode($json), JSON_PRETTY_PRINT); 
        echo "</pre>";

       
}

 