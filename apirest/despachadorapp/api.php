<?php 


class Api{
	


	public function getServiciosDespachador($estacion, $fecha){
	 
		$serivicios = array();
		$conexion = new Conexion();   
		$db = $conexion->getConexion(); 
		$Query = "SELECT DATE_FORMAT(t1.fecha, '%m/%d/%Y %h:%i:%s %p') as fecha, t2.nombre as estacion, t1.folio from servicios t1 
		inner join estaciones t2 on t1.estacion = t2.idestacion where   date(fecha) =  '".$fecha."' and t1.cancelado = '0'"; 
		$consultad = $db->prepare($Query);  
		$consultad->execute(); 
		$i = 0;
		while($filau = $consultad->fetch()){
			$serivicios["Servicios"][$i] = $filau; 
			$i ++;
		}
		return $serivicios;
		 
	}




	public function getDatosServTicket($folio){

		$servicio = array();

		$conexion = new Conexion(); 

		$db = $conexion->getConexion();

		//getidcte

		$Q = "SELECT t4.claveestacion, t1.saldoProxima, t1.folio, t1.idchofer, t1.bomba, DATE_FORMAT(t1.fecha, '%m/%d/%Y %h:%i:%s %p') as fecha, t3.nombre as nombreproducto, t1.litros, 
		t1.preciounitario, t1.importe, t2.nombre as nombrecliente, t1.tarjeta  from servicios t1 
		inner join clientes t2 on t1.idcliente = t2.idcliente 
		inner join productos t3 on t1.producto = t3.tipocombustible 
		inner join estaciones t4 on t1.estacion = t4.idestacion
		where t1.folio = '".$folio."' ";

		$consulta = $db->prepare($Q);

		$consulta->execute();
		
		while($fila = $consulta->fetch()){ 
		$a = number_format($fila["importe"], 2);
		$numberFormatter = new NumberFormatter('es_MX', NumberFormatter::SPELLOUT);
		$TotalLetra = $numberFormatter->format(substr(str_replace(",","",$a), 0, -3)); 
		 
		$TotalLetra = strtoupper($TotalLetra) ." PESOS ". substr(	$a, -2). "/100 M.N.";

		//decimales sobre 100 after coma
		$idchofer = $fila['idchofer'];
			$clientes['datosservicio'][0] = array( 
				"folio" => $fila['folio'],
				"fecha" => $fila['fecha'],
				"nombreproducto" => $fila['nombreproducto'],
				"litros" => $fila['litros'],
				"preciounitario" => $fila['preciounitario'],
				"importe" => $fila['importe'],
				"nombrecliente" => $fila['nombrecliente'],
				"tarjeta" => $fila['tarjeta'],
				"bomba" => $fila['bomba'],
				"saldoProxima" => $fila['saldoProxima'],
				"importeletra" => $TotalLetra,
				"claveestacion" => $fila['claveestacion']
			);
			//$clientes["datosservicio"][0] = $fila;

			$notarjeta = $fila['tarjeta'];
		}



		$Qo = "SELECT t1.folio, t2.placas  FROM tarjetas t1 
		INNER JOIN vehiculos t2 ON t1.folio = t2.idtarjeta  
		WHERE t1.notarjeta = '".$notarjeta."'";
		
		$consulta = $db->prepare($Qo);

		$consulta->execute();

		while($filao = $consulta->fetch()){

			$clientes["otrosdatos"][0] = $filao;
 
		}


		$Qc = "SELECT nombre FROM choferes where idchofer = '".$idchofer."'";

		$consulta = $db->prepare($Qc);

		$consulta->execute();

		while($filac = $consulta->fetch()){

			$clientes["nombrechofer"][0] = $filac;
 
		}




		

		
		return $clientes;


	}



	public function obtenerDatos($noTarjeta, $claveestacion){

		$clientes = array();

		$conexion = new Conexion(); 

		$db = $conexion->getConexion();

		//getidcte

		$Q = "SELECT idcliente from tarjetas where notarjeta = '".$noTarjeta."'";

		$consulta = $db->prepare($Q);

		$consulta->execute();

		while($fila = $consulta->fetch()){

			$idcte = $fila["idcliente"];

		}

		
		//saldos servicios para el cte de (Crédito) 
		//saldo tarjeta para el el saldo de servicio que debe esa tarteja (Crédito)
		//saldo abono para el saldo disponible de los abonos (Contado)



		$Query = "SELECT t4.placas, t2.tipocliente, t5.limiteCredito, t1.tipoperiodo, t2.idcliente, t1.horarioinicial, t1.horariofinal, t1.lunes, t1.martes, t1.miercoles, t1.jueves, t1.viernes, t1.sabado, t1.domingo, t1.folio as foliotarjeta, t1.tipolimite,  t2.rzonsocial, t2.nombre, t2.tipocliente, t1.notarjeta, t1.nip, t1.limitedinero, t1.limitelitros, (SELECT IFNULL(sum(importedisponibleabono),0) from abonos where IDclienteAbono='".$idcte."') AS saldoabono, t4.idvehiculo, t4.modelo, 
	
		IFNULL(t4.odometro, 0) as odometro,   
		t4.controlaodometro,
		IFNULL(t4.kmmin, 1) kmmin, 
		IFNULL((Select sum(restante) from servicios where idcliente = '".$idcte."' and cancelado = '0'),0) as saldoservicios,

		(Select IFNULL(SUM(restante), 0 ) from servicios where idcliente = '".$idcte."' and tarjeta = '".$noTarjeta."' and cancelado = '0') as saldotarjeta

		 

                FROM tarjetas t1 
				
				INNER JOIN clientes t2 ON t1.idcliente = t2.idcliente 


				INNER JOIN vehiculos t4 ON t1.folio = t4.idtarjeta  

				INNER JOIN tipopago t5 ON t1.idcliente = t5.idcliente  
 

				WHERE t1.notarjeta = '".$noTarjeta."'  ";

				  
		$consultad = $db->prepare($Query);

		$consultad->execute();

		while($filau = $consultad->fetch()){
			$periodo = $filau['tipoperiodo'];
			$clientes["datoscliente"][0] = $filau;

		}


		//get saldo consumido en periodo 
		if($periodo == "1"){
			//diario

			$cargas = "SELECT 	IFNULL(sum(litros), 0) as consumidoLitros, IFNULL(sum(importe), 0) as consumidoImporte  from servicios where day(fecha)=day(now()) and tarjeta = '".$noTarjeta."' and cancelado = '0'";
		}
		if($periodo == "2"){
			//semanal
			$cargas = "SELECT IFNULL(sum(litros), 0) as consumidoLitros, IFNULL(sum(importe), 0) as consumidoImporte  from servicios where week(fecha)=week(now()) and tarjeta = '".$noTarjeta."' and cancelado = '0'";
		}
		if($periodo == "3"){
			//mensual quincenal
			$cargas = "SELECT IFNULL(sum(litros), 0) as consumidoLitros, IFNULL(sum(importe), 0) as consumidoImporte  from servicios where month(fecha)=month(now()) and tarjeta = '".$noTarjeta."' and cancelado = '0'";
		}
		if($periodo == "4"){
			//mensual
			$cargas = "SELECT IFNULL(sum(litros), 0) as consumidoLitros, IFNULL(sum(importe), 0) as consumidoImporte  from servicios where month(fecha)=month(now()) and tarjeta = '".$noTarjeta."' and cancelado = '0'";
		}
 

		$consultac = $db->prepare($cargas); 
		$consultac->execute(); 
		$i = 0; 
		while($filac = $consultac->fetch()){
			$clientes["datoscargas"][$i] = $filac;
			$i++;   
		}
 
 
		$idveh = "SELECT t1.notarjeta, t2.idvehiculo FROM tarjetas t1 
		INNER JOIN vehiculos t2 ON t1.folio = t2.idtarjeta  
		WHERE notarjeta = '".$noTarjeta."'";
		$consultad = $db->prepare($idveh);
		//echo $idveh;

		$consultad->execute();

		while($filau = $consultad->fetch()){

			$vehiculoid = $filau['idvehiculo'];

		}

		
		
		$getChoferes = "SELECT t1.idvehiculo, t2.nombre, t2.nip FROM vehiculos_choferes t1 
		INNER JOIN choferes t2 ON t1.idchofer = t2.idchofer WHERE t1.idvehiculo = '".$vehiculoid."' GROUP BY t2.idchofer";
		$consultad = $db->prepare($getChoferes);

		$consultad->execute();
		$i = 0; 
		while($filau = $consultad->fetch()){

			$clientes["datoschoferes"][$i] = $filau;
			$i++; 
		}
		
		








		$estaciones = "SELECT t2.folio_estacion, t3.nombre
		
		FROM tarjetas t1 
		INNER JOIN tarjeta_estacion t2 ON t1.folio = t2.folio_tarjeta
		
		INNER JOIN estaciones t3 ON t2.folio_estacion= t3.idestacion
		
		WHERE t1.notarjeta = '".$noTarjeta."' ";

 

			$consultad = $db->prepare($estaciones);

			$consultad->execute();
			$i = 0; 
			while($filae = $consultad->fetch()){

				$clientes["estaciones"][$i] = $filae;
				$i++;
			}




			$estacionactual = "SELECT t2.folio_estacion, t3.nombre
		
		FROM tarjetas t1 
		INNER JOIN tarjeta_estacion t2 ON t1.folio = t2.folio_tarjeta
		
		INNER JOIN estaciones t3 ON t2.folio_estacion= t3.idestacion
		
		WHERE t1.notarjeta = '".$noTarjeta."' and claveestacion = '".$claveestacion."' ";

 

			$consultad = $db->prepare($estacionactual);

			$consultad->execute();
			$i = 0; 
			while($filae = $consultad->fetch()){

				$clientes["estacionactual"][$i] = $filae;
				$i++;
			}



			$productos = "SELECT t2.folio_producto, t3.nombre
		
			FROM tarjetas t1 
			 
			INNER JOIN tarjeta_producto t2 ON t1.folio = t2.folio_tarjeta
			
			INNER JOIN productos t3 ON t2.folio_producto = t3.folio
			
			WHERE t1.notarjeta =  '".$noTarjeta."'  ";

 
			$consultad = $db->prepare($productos);

			$consultad->execute();
			$i = 0; 
			while($filap = $consultad->fetch()){

				$clientes["productos"][$i] = $filap;
				$i++;
			}

//producto de la estacion
			$productosesta = "SELECT t1.folioproduto, t3.nombre FROM estaciones_productos t1 
			INNER JOIN estaciones t2 ON t1.idestacion = t2.idestacion 
			INNER JOIN productos t3 ON t1.folioproduto = t3.folio 
			where t2.claveestacion = '".$claveestacion."'";

 
			$consultad = $db->prepare($productosesta);

			$consultad->execute();
			$i = 0; 
			while($filap = $consultad->fetch()){

				$clientes["productosestacion"][$i] = $filap;
				$i++;
			}



			////////////////////////////Facturas Vencidas//////////////////////////

			$facturas = "SELECT t1.folio, t1.fechagenerado, t2.periodoCredito FROM facturas t1 
			inner join tipopago t2 on t1.idcliente=t2.idcliente 
			where t1.idcliente=(select idcliente from tarjetas where notarjeta = '".$noTarjeta."')
			and t1.restante >=1;";


			$consultad = $db->prepare($facturas);

			$consultad->execute();
			$i = 0; 
			$ContFacVen=0;
			while($filapp = $consultad->fetch()){


			$generado = $filapp['fechagenerado']; 
			$vencimineto = date('Y-m-d', strtotime($generado. ' + '.$filapp['periodoCredito'].' days')); 
			$hoy = date("Y-m-d");
			$days = (strtotime($hoy) - strtotime($vencimineto)) / (60 * 60 * 24);
			if($days>=1){
				$ContFacVen++;
			}


			$clientes["DiasVencidas"][$i] = $days;
				$i++;
			}
			$clientes["facturasVencidas"] = $ContFacVen;

			



		return $clientes;

	}

	public function getBombas($estacion){
		$clientes = array();
		$conexion = new Conexion(); 

		$db = $conexion->getConexion();

		$bombas = "SELECT t1.* FROM bombaestacion t1 INNER JOIN estaciones t2 on t1.folio_estacion = t2.idestacion WHERE t2.nombre = '".$estacion."'"; 

		$consultad = $db->prepare($bombas);

			$consultad->execute();
			$i = 0; 
			while($filap = $consultad->fetch()){

				$clientes["bombas"][$i] = $filap;
				$i++;
			}
 

		return $clientes;


	}





	

	public function guardarServicio($idcliente, $idtarjeta, $importe, $litros, $producto, $estacion, $controlaodometro, $idvehiculo, $kmanterior, $kmnuevo, $bomba, $nip, $proximaCompra){
		$CantImporte=$importe;
		$clientes = array();

		$conexion = new Conexion(); 

		$db = $conexion->getConexion();

		$a = "1"; 

		$b = "1";

 


		$idest = "SELECT idestacion from estaciones where nombre = '".$estacion."'";
		$consultaest = $db->prepare($idest); 
			$consultaest->execute(); 
			while($filanse = $consultaest->fetch()){
				$idesta = $filanse['idestacion'];
			} 


			$idpro = "SELECT tipocombustible from productos where nombre = '".$producto."'";
			$consultapro = $db->prepare($idpro); 
			$consultapro->execute(); 
			while($filap = $consultapro->fetch()){
				$idproducto = $filap['tipocombustible'];
			} 


			//get idchofer from tarjeta and nip 
			$getChoferId = "SELECT t4.nombre, t4.idchofer from tarjetas t1 
			inner join vehiculos t2 on t1.idplaca = t2.idvehiculo 
			inner join vehiculos_choferes t3 on t2.idvehiculo = t3.idvehiculo 
			inner join choferes t4 on t3.idchofer = t4.idchofer
			where t1.notarjeta = '".$idtarjeta."' and t4.nip = '".$nip."'";
			$consultachofer = $db->prepare($getChoferId); 
			$consultachofer->execute(); 
			while($filac = $consultachofer->fetch()){
				$idchofer = $filac['idchofer'];
			} 
						
			//obtener preciuo unitario 
			$precio = "SELECT preciouni from precio_prod where idproduc = '".$idproducto."' order by fecha desc limit 1";
			$consultaestp = $db->prepare($precio); 
			$consultaestp->execute(); 
			while($filansep = $consultaestp->fetch()){
				$preciounitario = $filansep['preciouni'];
			} 


			//por litros 
			if($litros != "" ){
				$CantImporte = $litros * $preciounitario;
				$importe = $CantImporte;
			}else{
				$litros = $CantImporte / $preciounitario;
			}
				//idtartjeta en lugar de notarjeta
		
			//	$Query = "INSERT into servicios (idcliente, tarjeta, importe, litros, producto, estacion, restante, preciounitario, bomba, tiposervicio, idchofer, saldoProxima) values ('".$idcliente."', '".$idtarjeta."', '".$importe."', '".$litros."', '".$idproducto."', '".$idesta."', '".$importe."', '".$preciounitario."', '".$bomba."', '2', '".$idchofer."', '".$proximaCompra."')"; 

			//inicia codigo mario 
			
			//get id tarejeta 
			$SelectIdTarjeta = "SELECT folio from tarjetas where notarjeta = '".$idtarjeta."'";
			$consultaidtarjetas = $db->prepare($SelectIdTarjeta); 
			$consultaidtarjetas->execute(); 
			while($filat = $consultaidtarjetas->fetch()){
				$tarjeta = $filat['folio'];
			} 

			$cliente = $idcliente;
				



			$QueryTipocliente="SELECT tipocliente, limitecredito FROM clientes WHERE idcliente = '".$cliente."'";
			$consultad = $db->prepare($QueryTipocliente);
			$consultad->execute();
			$tipocliente = $consultad->fetch(PDO::FETCH_OBJ);	
			$tipocliente = (array)$tipocliente;
			$QueryLimitecliente="SELECT limiteCredito FROM tipopago WHERE idcliente = '".$cliente."'";
			$consultad = $db->prepare($QueryLimitecliente);
			$consultad->execute();
			$Limitecliente = $consultad->fetch(PDO::FETCH_OBJ);	
			$Limitecliente = (array)$Limitecliente;
			if($tipocliente['tipocliente']=="0"){ //contado
				$Querylimite = "SELECT SUM(importedisponibleabono) FROM abonos WHERE iDclienteAbono='".$cliente."'";
				$consultad = $db->prepare($Querylimite);
				$consultad->execute();
				$limite = $consultad->fetch(PDO::FETCH_OBJ);
				$limite = (array)$limite;
				$limite = $limite['SUM(importedisponibleabono)'];
				$total=$limite-$importe;
			}else{
				$Querylimite = "SELECT SUM(importe) FROM servicios WHERE idcliente='".$cliente."' and facturado = '0'";
				$consultad = $db->prepare($Querylimite);
				$consultad->execute();
				$limite = $consultad->fetch(PDO::FETCH_OBJ);
				$limite = (array)$limite;
				$limite = $limite['SUM(importe)'];
				$total = $limite+$importe;
				$total = $Limitecliente['limiteCredito']-$total;
			}
			
			
	
			if($total>=0){

				$ultimosserv="SELECT folio FROM servicios ORDER BY folio Desc limit 1";
				$consultad = $db->prepare($ultimosserv);
					$consultad->execute();
					$ultimoServ = $consultad->fetch(PDO::FETCH_OBJ);
					
					$ultimoServ = (array)$ultimoServ;
					//print_r($ultimoServ) ;
					$ultimoServ = $ultimoServ['folio'];
					$ultimoServ = $ultimoServ+1;
					//echo "Ultimo";
					//echo $ultimoServ;


				//contado tipocliente
				if($tipocliente['tipocliente']=="0"){
					//echo "entró";
					$QueryACTlimite = "SELECT IDabono, importedisponibleabono FROM abonos WHERE iDclienteAbono='".$cliente."' AND importedisponibleabono >'0' order by fecha asc";
					$consultad = $db->prepare($QueryACTlimite);
					$consultad->execute();
					while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
						$abonos[] = $filau;
					}
					$abonos = (array)$abonos;
					//print_r($abonos);
					foreach($abonos as $a){
						$a=(array)$a;
						$disponible = $a['importedisponibleabono'];
						$IDabono =$a['IDabono'];
						if($importe>=$disponible){
						$importe = $importe-$disponible;
						$disponible=0;
						$QPAD="INSERT INTO pagosaplicaciones(idcliente,fechacaptura,idfactura,importe,foliopago,abono,generado,inactivo,folio_servicio,restanteabono)Values('".$cliente."',CURRENT_TIME,'0','".$importe."','".$IDabono."','".$disponible."','0','0','".$ultimoServ."','".$disponible."')";
						$consultad = $db->prepare($QPAD);
						$consultad->execute();
						$QueryUPDlimite = "UPDATE abonos set importedisponibleabono = '0' WHERE IDabono = '".$IDabono."'";
							if ($db->query($QueryUPDlimite) == TRUE) {
								//echo "Todo bien";
							}else{
								return "Falló actualización de abono disponible";}
						}else if($importe<=$disponible){
						$disponible = $disponible - $importe;
						$QPAD="INSERT INTO pagosaplicaciones(idcliente,fechacaptura,idfactura,importe,foliopago,abono,generado,inactivo,folio_servicio,restanteabono)Values('".$cliente."',CURRENT_TIME,'0','".$importe."','".$IDabono."','".$importe."','0','0','".$ultimoServ."','".$disponible."')";
						$consultad = $db->prepare($QPAD);
						$consultad->execute();
						$importe = 0;
						$QueryUPDlimite = "UPDATE abonos set importedisponibleabono = '".$disponible."' WHERE IDabono = '".$IDabono."'";
							if ($db->query($QueryUPDlimite) == TRUE) {
								//echo "Todo bien2";
							}else{
								return "Falló actualización de abono disponible";}
						}
					}
				}
				/*
				$QueryidV="SELECT idvehiculo FROM vehiculos WHERE idtarjeta = '{$tarjeta}'";
				$consultad = $db->prepare($QueryidV);
				$consultad->execute();
				while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
				$idvehiculo[] = $filau;
				}
				$idVehi = $idvehiculo["idvehiculo"];
				$QKMa="SELECT kmnuevo FROM odometro WHERE idvehiculo = '{$idVehi}' ORDER BY fecha DESC limit 1;";
				$consultad = $db->prepare($QKMa);
				$consultad->execute();
				while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
				$KMant[] = $filau;
				}
				$kmAnterior=$KMant["kmnuevo"];
				if($kmAnterior==null){
					$kmAnterior = 0;
				}
	
				$QULTserv="SELECT folio FROM servicios WHERE tarjeta = '{$tarjeta}' ORDER BY fecha DESC limit 1;";
				$consultad = $db->prepare($QULTserv);
				$consultad->execute();
				while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
				$servID[] = $filau;
				}
				$servicioID=$servID["folio"];
				$Qodometro="INSERT INTO odometro (idvehiculo,fecha, kmanterior,kmnuevo,idservicio)VALUES('{$idVehi}',CURRENT_TIME,'{$kmAnterior}','{$km}','{$servicioID}'";
				$db->query($Qodometro);


				*/
			//	$Query = "INSERT INTO servicios(idcliente, estacion, fecha, tarjeta, importe, producto, litros, restante, preciounitario,tiposervicio) 
			//	VALUES('{$cliente}', '{$estacion}', CURRENT_TIME , '{$tarjeta}', '{$CantImporte}', '{$producto}', '{$litros}', '{$CantImporte}', '{$preciouni}', '{$servicio}')";
			
			$Query = "INSERT into servicios (idcliente, tarjeta, importe, litros, producto, estacion, restante, preciounitario, bomba, tiposervicio, idchofer, saldoProxima) values ('".$idcliente."', '".$idtarjeta."', '".$CantImporte."', '".$litros."', '".$idproducto."', '".$idesta."', '".$CantImporte."', '".$preciounitario."', '".$bomba."', '2', '".$idchofer."', '".$proximaCompra."')"; 
			
			if ($db->query($Query) == TRUE) { 
				$a = "1";
				$nvoserv = "SELECT folio from servicios order by fecha desc limit 1 ";
				$consultans = $db->prepare($nvoserv); 
				$consultans->execute(); 
				while($filans = $consultans->fetch()){
					$idservicio = $filans['folio'];
				} 
				//$servm[] = array(
			//		"respuesta" => "1"
			//	);
	
				
			} else {
				$a = "0";
			//	$servm[] = array(
		//			"respuesta" => "0"
			//	);
			}			
			//return $servm;
	
			}else{
				$clientes[] = array(

					"codigo" => "0",
					"estado" => "0",
					"respuesta" => "Saldo insuficiente"
	
				);
				//return "Saldo insuficiente";
			}
	









			//fin codigo de mario 









	/*	if ($db->query($Query) == TRUE) {

			$a = "1";
			$nvoserv = "SELECT folio from servicios order by fecha desc limit 1 ";
			$consultans = $db->prepare($nvoserv); 
			$consultans->execute(); 
			while($filans = $consultans->fetch()){
				$idservicio = $filans['folio'];
			} 
		} else {

			$a = "0";

		} 
*/
 

		if($controlaodometro == "1"){

			$insertOdometro =  "INSERT into odometro (idvehiculo, kmanterior, kmnuevo, idservicio) VALUES ('".$idvehiculo."', '".$kmanterior."', '".$kmnuevo."', '".$idservicio."')";

			if ($db->query($insertOdometro) == TRUE) {

				$b = "1";

				//update vehiculo odometro

				$UpdateOdometro = "UPDATE vehiculos set odometro = '".$kmnuevo."' where idvehiculo = '".$idvehiculo."'";

				if ($db->query($UpdateOdometro) == TRUE) {

					$b = "1";

				}else{

					$b = "0";	

				}

			} else {

				$b = "0";

			} 

		}


		//obtener folio del servicio recien ingresado 
		$lastFolio = "SELECT folio from servicios where idcliente = '".$idcliente."' order by fecha desc limit 1";
		$consultauf = $db->prepare($lastFolio); 
		$consultauf->execute(); 
		while($filauf = $consultauf->fetch()){
			$ultimofolio = $filauf['folio'];
		} 




		if(($a == "1") && ($b == "1")){

			$clientes[] = array(

					"codigo" => "1",
					"folio" => $ultimofolio,
					"query" => $Query,
					"bomba" => $bomba,
					"respuesta" => ""

				);

			

		}else{

			$clientes[] = array(

				"codigo" => "0",
				"estado" => "0",
				"respuesta" => ""

			);

		}



		return $clientes;

	}





    public function Login($user, $pass){

		$loginres = array();

		$conexion = new Conexion();

		$db = $conexion->getConexion();



		$Query = "SELECT t1.usuario, t1.idusuario, t1.nombre, t1.tipo FROM usuarios  t1  WHERE BINARY t1.usuario = '{$user}'  AND BINARY  t1.contrasena = '".$pass."'"; 

		

		session_start();

		$consultad = $db->prepare($Query);

		$consultad->execute();



		while($filau = $consultad->fetch()){

			$usuario = $filau['usuario'];

			$loginres[] = array(

				"usuario" => $filau['usuario'],

				"res" => '1', 

				"idusuario" => $filau['idusuario'], 

				"nombre" => $filau['nombre'], 

				"tipo" => $filau['tipo']

			);

        }  



		if(isset($usuario)){ 

			return $loginres;

		} else {

			$loginres[] = array(

				"res" => '0' 

			);

			return $loginres;

		}

	}



	public function addCliente($nombre, $rfc, $contacto, $telefono, $tipo, $metodopago, $periodopago, $limitecredito){

		$conexion = new Conexion();

		$db = $conexion->getConexion();

		$Query = "INSERT INTO clientes (rzonsocial, nombre, rfc, contacto, telefono) VALUES ('" . $nombre . "', '" . $nombre . "', '" . $rfc . "', '" . $contacto . "','" . $telefono . "')";

		if ($db->query($Query) == TRUE) {

			$a = "1"; 

		}  

		//get ultimo id 

		$SelIdCte = "Select idcliente from clientes order by idcliente desc limit 1";

		$consultad = $db->prepare($SelIdCte);

		$consultad->execute();

		while($filau = $consultad->fetch()){

			$idcliente = $filau['idcliente'];

		}



		//insert en tipo pago 

		$QueryTP = "INSERT INTO tipopago (idcliente, tipo, metodoprepago, periodocredito, limitecredito) VALUES ('".$idcliente."', '" . $tipo . "', '" . $metodopago . "', '" . $periodopago . "', '" . $limitecredito . "')";



		if ( $db->query($QueryTP) == TRUE) {		

			$b = "1";

		} 

		if(($a == "1") && ($b == "1")){	

			echo "Guardado correctamente";

		} else {

			echo "Error al guardar";

		} 

	}
	

	public function getDatosEstTicket($noEstacion){

		$clientes = array(); 
		$conexion = new Conexion();  
		$db = $conexion->getConexion();

		$Query = "SELECT t1.claveestacion AS siic, t1.calle, t1.colonia, t1.nombre, t2.rfc, t2.rzonsocial
		FROM estaciones t1 INNER JOIN grupo t2 ON t1.idgrupoest = t2.idgrupo WHERE claveestacion = '".$noEstacion."'
		";
 

		$consultad = $db->prepare($Query);

		$consultad->execute();

		while($filau = $consultad->fetch()){

			$clientes[] = $filau;

		}

		return $clientes;

	}

	public function getClientes(){

		$clientes = array();

		$conexion = new Conexion(); 

		$db = $conexion->getConexion();

		$Query = "SELECT * FROM clientes";

		$consultad = $db->prepare($Query);

		$consultad->execute();

		while($filau = $consultad->fetch()){

			$clientes[] = $filau;

		}

		return $clientes;

	}



	public function addUsuarioWeb($idcliente, $nombre, $usuario, $contrasena, $tipo, $administracion, $reportes, $graficas, $seguridad){

		$conexion = new Conexion();

		$db = $conexion->getConexion();

		$Query = "INSERT INTO usuariosweb (idcliente, nombre, usuario, contrasena, tipo, administracion, reportes, graficas, seguridad) VALUES ('".$idcliente."', '".$nombre."', '".$usuario."','".$contrasena."','".$tipo."','".$administracion."','".$reportes."','".$graficas."','".$seguridad."')";	 



		if ($db->query($Query) == TRUE) {

			echo "Guardado correctamente";

		} else {

			echo "Error al guardar";

		}

	}



	public function getUsuariosWeb(){

		$conexion = new Conexion();

		$db = $conexion->getConexion();

		$Query = "SELECT * FROM usuariosweb t1 inner join clientes t2 on t1.idcliente = t2.idcliente";

		$consultad = $db->prepare($Query);

		$consultad->execute();

		while($filau = $consultad->fetch()){

			$clientes[] = $filau;

		}

		return $clientes;

	}



	public function addUsuario($nombre, $usuario, $contrasena, $tipo, $idcliente){

		$conexion = new Conexion();

		$db = $conexion->getConexion();

		$Query = "INSERT INTO usuarios (nombre, usuario, contrasena, tipo, idcliente) VALUES ('".$nombre."','".$usuario."','".$contrasena."','".$tipo."','" .$idcliente."')";



		if ($db->query($Query) == TRUE) {

			echo "Guardado correctamente";		

		} else {

			echo "Error al guardar";

		}

	}



	public function getUsuarios(){

		$clientes = array();

		$conexion = new Conexion();

		$db = $conexion->getConexion();

		$Query = "SELECT * FROM usuarios t1 inner join clientes t2 on t1.idcliente = t2.idcliente";

		$consultad = $db->prepare($Query);

		$consultad->execute();

		while($filau = $consultad->fetch()){

			$clientes[] = $filau;

		}

		return $clientes;

	}



	public function addChofer($nombre, $idCliente){

		$conexion = new Conexion();

		$db = $conexion->getConexion();

		$Query = "INSERT INTO choferes(nombre, idcliente) VALUES ('{$nombre}', '{$idCliente}')";

		if ($db->query($Query) == TRUE) {

			echo "Guardado correctamente";

		} else {

			echo "Error al guardar";

		}

	}



	public function getChoferes(){

		$clientes = array();

		$conexion = new Conexion();

		$db = $conexion->getConexion();

		// $Query = "SELECT * FROM choferes t1 inner join clientes t2 on t1.idcliente = t2.idcliente";

		$Query = "SELECT * FROM choferes";

		$consultad = $db->prepare($Query);

		$consultad->execute();

		while($filau = $consultad->fetch()){

			$clientes[] = $filau;

		}

		return $clientes;

	}



	public function addTarjeta($idcliente, $notarjeta, $idplaca, $activo, $tipo, $magna, $premium, $diesel, $horarioinicial, $horariofinal, $lunes, $martes,$miercoles, $jueves,

	$viernes, $sabado, $domingo, $santafe, $ley, $insurgentes, $munich, $libramiento, $lopez, $rio, $limitedinero, $limitelitros, $tipoperiodo){

		$conexion = new Conexion();

		$db = $conexion->getConexion();

		$Query = "INSERT INTO tarjetas (idcliente, notarjeta, idplaca, activo, tipo, magna, premium, diesel, horarioinicial, horariofinal, lunes, martes,miercoles, jueves,

		viernes, sabado, domingo, santafe, ley, insurgentes, munich, libramiento, lopez, rio, limitedinero, limitelitros, tipoperiodo) VALUES ('" . $idcliente . "','" . $notarjeta . "','" . $idplaca . "','" . $activo . "'

		,'" . $tipo . "','" . $magna . "','" . $premium . "','" . $diesel . "','" . $horarioinicial . "','" . $horariofinal . "','" . $lunes . "','" . $martes . "','" . $miercoles . "','" . $jueves . "','" . $viernes . "','" . $sabado . "'

		,'" . $domingo . "','" . $santafe . "','" . $ley . "','" . $insurgentes . "','" . $munich . "','" . $libramiento . "','" . $lopez . "','" . $rio . "','" . $limitedinero . "','" . $limitelitros . "','" . $tipoperiodo . "')";

		echo $Query;  

		if ($db->query($Query) == TRUE) {

			echo "Guardado correctamente";

		} else {

			echo "Error al guardar";

		}

	}



	public function getTarjetas(){ 

		$clientes = array();

		$conexion = new Conexion();

		$db = $conexion->getConexion();

		$Query = "SELECT * FROM tarjetas t1 inner join clientes t2 on t1.idcliente = t2.idcliente";

		$consultad = $db->prepare($Query);

		$consultad->execute();

		while($filau = $consultad->fetch()){

			$clientes[] = $filau;

		}

		return $clientes;

	}



	public function addVehiculo($idCliente, $modelo, $ano, $placas, $noEconomico, $tipoVehiculo, $idTarjeta, $centroCosto, $controlaOdometro, $kmMax, $variacion, $odometro, $rendimiento){

		$conexion = new Conexion();

		$db = $conexion->getConexion();

		$Query = "INSERT INTO vehiculos (idcliente, modelo, ano, placas, noeconomico, tipovehiculo, idtarjeta, centrocosto, controlaodometro, kmmax, variacion, odometro, rendimiento) VALUES ('".$idCliente."','".$modelo."','".$ano."','".$placas."','".$noEconomico."','".$tipoVehiculo."','".$idTarjeta."','".$centroCosto."','".$controlaOdometro."','".$kmMax."','".$variacion."','".$odometro."','".$rendimiento."')";



		if ($db->query($Query) == TRUE) {

			echo "Guardado correctamente";

		} else {

			echo "Error al guardar";

		}

	}



	public function getVehiculos(){ 

		$clientes = array();

		$conexion = new Conexion();

		$db = $conexion->getConexion();

		$Query = "SELECT * FROM vehiculos t1 inner join clientes t2 on t1.idcliente = t2.idcliente";

		$consultad = $db->prepare($Query);

		$consultad->execute();

		while($filau = $consultad->fetch()){

			$clientes[] = $filau;

		}

		return $clientes;

	}



	public function addAbono($idcliente, $fecha, $importe, $formapago, $bancodestino, $cuentabancaria, $referencia, $concepto){

		$conexion = new Conexion();

		$db = $conexion->getConexion();

		$Query = "INSERT INTO abonos(idcliente, fecha, importe, formapago, bancodestino, cuentabancaria, referencia, concepto) 

			VALUES('{$idcliente}', '{$fecha}', '{$importe}', '{$formapago}', '{$bancodestino}', '{$cuentabancaria}', '{$referencia}', '{$concepto}')";

		if ($db->query($Query) == TRUE) {

			echo "Guardado correctamente";

		} else {

			echo "Error al guardar";

		}

	}
 


	public function obtenerEstadoTarjeta($tarjeta){
		$servicio = array();
		$conexion = new Conexion();

		$db = $conexion->getConexion();

		$Query = "SELECT activo FROM tarjetas WHERE notarjeta='".$tarjeta."'"; 

		$consultad = $db->prepare($Query);

		$consultad->execute();

		while($filau = $consultad->fetch()){

			$servicio["estadotarjeta"][0]  = $filau;

		}
		//$servicio  = (array)$servicio[0];

		 


		return $servicio;

	}



	public function getAbonos($cte){
		

		$conexion = new Conexion();

		$db = $conexion->getConexion();

		$Query = "SELECT * FROM abonos WHERE idcliente={$cte}";

		$consultad = $db->prepare($Query);

		$consultad->execute();

		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){

			$abonos[] = $filau;

		}

		return $abonos;

	}



 
 


   function autorizacionNip($tipo, $idcliente, $tarjeta){

		$conexion = new Conexion();
		 

		if($tipo == "8"){
			$descripcion = "Autorizacion por NIP realizada correctamente";
		}
		if($tipo == "9"){
			$descripcion = "Autorizacion por NIP fallida";
		}

		$db = $conexion->getConexion();
		$Q = "Insert into bitacora (fecha, tipo, idcliente, descripcion, tarjeta) values (CURRENT_TIME(),'".$tipo."', '".$idcliente."', '".$descripcion."', '".$tarjeta."')";
		if ($db->query($Q) == TRUE) {
		//	echo "Registrado correctamente";
		} else {
		//	echo "Error al registrar";
		} 

		$SelectFallidos = "SELECT COUNT(id) as intentosfallidos, CURRENT_DATE as fecha FROM bitacora WHERE idcliente = '".$idcliente."' AND tipo = '9' AND DATE(fecha) = CURRENT_DATE;";
		$consultad = $db->prepare($SelectFallidos);

		$consultad->execute();

		while($filau = $consultad->fetch()){

			$intentos = $filau['intentosfallidos'];

		}
		//continua
		if($tipo == "8"){
			$respuesta["respuesta"][0] = array(

				"codigo" => "1" 

			);
			//no continua muestra los intentos fallidos en el dia 
		}
		
		if($tipo == "9"){
			
			if($intentos >= 3){
				//bloquear la tarjeta 
				$Desactivartarjeta = "UPDATE tarjetas set activo = '0' where notarjeta = '".$tarjeta."'";
				if ($db->query($Desactivartarjeta) == TRUE) {
					$respuesta["respuesta"][0] = array(

						"codigo" => "3",
						"intentosfallidos" => $intentos,
						"tarjeta" => "Tarjeta desactivada correctamente"
		
					);
		
				}
			}else{
				$respuesta["respuesta"][0] = array(

					"codigo" => "2",
					"intentosfallidos" => $intentos
	
				);
	

			}
		}


		return $respuesta;





   }

 

}