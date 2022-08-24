<?php

class Api{

	public function getPlacaFTarjeta($numeroTarjeta){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
	
		$Query = "SELECT t2.placas as placa FROM tarjetas t1 INNER JOIN vehiculos t2 ON t1.idplaca = t2.idvehiculo WHERE t1.notarjeta = '".$numeroTarjeta."'";
	
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch()){
			//$clientes[] = $filau['idchofer'];
			$placa = $filau['placa'];
		}
	
		return $placa;
	
	}

	public function aplicacionPagosCredito($cte, $foliopago, $importe, $abono, $folios){
		$abonoserv = $abono;
		$nvorestante=0;
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$e=0;
		$pago=0;
		$importefac=0;
		$i = 0;
		foreach($folios as $f){
			$importefac=$importe[$i];
            if($importe==0){
				$importerestante=0;
				$abono=$abono;
			}else if($abono>=1){
				if($importe[$i]==$abono){
					$pago = $abono;
					$importerestante=0;
					$abono=0;
				}else if($importe[$i]>$abono){
					$pago = $abono;
					$importerestante=$importe[$i]-$abono;
					$abono=0;
				}else if($importe[$i]<$abono){
					$pago = $importe[$i];
					$abono=$abono-$importe[$i];
					$importerestante=0;
				}

			}
			
		$Query1 = "UPDATE facturas SET restante ='{$importerestante}' WHERE folio = '{$f}'";
		$Query2 = "UPDATE abonos SET importedisponibleabono ='{$abono}' WHERE IDabono = '{$foliopago}'";
		$Query3 = "INSERT INTO pagosaplicaciones(idcliente, fechacaptura, idfactura, importe, foliopago, abono, generado, inactivo,restanteabono)VALUES('{$cte}',CURRENT_TIME, '{$f}','{$importefac}', '{$foliopago}', '{$pago}', '0', '0','{$abono}')";
			
		if($db->query($Query1)==true && $db->query($Query2)==true && $db->query($Query3)==true){
			$Qidserv="SELECT folioservicio FROM facturasservicios WHERE foliofactura = '{$f}'";
			$consultad = $db->prepare($Qidserv);
			$consultad->execute();
			while($filau = $consultad->fetch()){
				$folioservicio[] = $filau["folioservicio"];
			}
			foreach($folioservicio as $fol){
				//echo "entró al ciclo sin fin";

				$Qs = "SELECT restante FROM servicios WHERE folio ='{$fol}' AND restante >='1'";
				//echo $Qs;
				$consultad = $db->prepare($Qs);
				$consultad->execute();
				$Rrestante  = $consultad->fetch();
				
		
				
				//print_r($Rrestante['restante']);
				$restante = $Rrestante['restante'];
				
				
					if($restante==$abonoserv){
						$restante = 0;
						$abonoserv = 0;
					}else if($restante>$abonoserv){
						$restante = $restante - $abonoserv;
						$abonoserv = 0;
					}else if($restante<$abonoserv){
						$abonoserv = $abonoserv - $restante;
						$restante = 0;
					}
					
				$Qs2 = "UPDATE servicios SET restante = '{$restante}' WHERE folio ='{$fol}'";
				$consultad = $db->prepare($Qs2);
				$consultad->execute();
			}

			$e ++;}
		$i++;
		}

		if($e==sizeof($folios)){
			echo "1";
		}else{
			echo $Query1;
			
			echo $Query2;
			
			echo $Query3;
		}

		//foreach folio factura abonar importe del abono 




	}
	
	public function listadesaldos(){
		$clientes = array();
		$saldo = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$tipo = "SELECT idcliente,tipocliente FROM clientes";
		$resp = $db->prepare($tipo);
		$resp->execute();
			while($obj = $resp->fetch()){
				$clientes[] = array(
					'cliente'=> $obj["idcliente"],
					'tipo' => $obj["tipocliente"]
				);
			}
			
		foreach($clientes as $cte){
			
			$id = $cte["cliente"];
			
			if($cte["tipo"]==0){
				//contado
				$Query = "SELECT SUM(t1.importedisponibleabono) as importe ,t2.rzonsocial as nombre FROM abonos t1 INNER JOIN clientes t2 on t1.iDclienteabono=t2.idcliente WHERE t1.iDclienteabono={$id}";
				$consultad = $db->prepare($Query);
				$consultad->execute();
				while($filau = $consultad->fetch()){
					$saldo[] = array(
						'importedisponible'=> $filau["importe"],
						'nombre' => $filau["nombre"]
					);
					
				}
			}else{
			/*	$Query1 = "SELECT sum(t1.restante) as restante, t2.limiteCredito as limite,t3.rzonsocial as nombre  FROM servicios t1 inner join tipopago t2 on t1.idcliente=t2.idcliente inner join clientes t3 on t1.idcliente=t3.idcliente WHERE t1.idcliente={$id} and t1.restante >= '1'";
				
				$consultad = $db->prepare($Query1);
				$consultad->execute();
				while($filau1 = $consultad->fetch()){
					$nombre = $filau1["nombre"];
					$restante = $filau1["restante"];
					$limite = $filau1["limite"];

				}
				$disponible = $limite -$restante;

				$saldo[] = array(
					'importedisponible'=> $disponible,
					'nombre' => $nombre
				);*/
			}
		}

		return $saldo;

	}


	public function cambioprecio($estacion, $fecha, $hora, $magna, $premium, $diesel, $grupo){
		//echo $grupo;
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		//print_r($estacion);
		$e = 0;
		//$correctos = 0;
		//$suma = 0;
		//$litros = 0;
		$iepsm = 0;
		$iepsp = 0;
		$iepsd = 0;
		$consulta = "SELECT * FROM impuestos";

			$resp = $db->prepare($consulta);
				$resp->execute();
			while($obj = $resp->fetch()){
				//print_r($obj);
				$iepsm =$obj["IEPSmagna"];
				$iepsp =$obj["IEPSpremium"];
				$iepsd =$obj["IEPSdiesel"];
				//print_r($iepsd);
			}

		foreach($estacion as $est) { 
			$Query1 = "INSERT INTO precio_prod (preciouni, idestacionprod, idproduc, idgrupoestprod, nombreprod, ieps, fecha) VALUES('{$magna}', '{$est}','1','{$grupo}', 'PEMEX MAGNA', '{$iepsm}', '{$fecha}')";
			$Query2 = "INSERT INTO precio_prod (preciouni, idestacionprod, idproduc, idgrupoestprod, nombreprod, ieps, fecha) VALUES('{$premium}', '{$est}','2','{$grupo}', 'PEMEX PREMIUM', '{$iepsp}', '{$fecha}')";
			$Query3 = "INSERT INTO precio_prod (preciouni, idestacionprod, idproduc, idgrupoestprod, nombreprod, ieps, fecha) VALUES('{$diesel}', '{$est}','3','{$grupo}', 'PEMEX DIESEL', '{$iepsd}', '{$fecha}')";
			
			//echo $Query1;
			//echo $Query2
			//echo $Query3;
			if($db->query($Query1)==true && $db->query($Query2)==true && $db->query($Query3)==true){
			$e ++;}
		}
		if($e==sizeof($estacion)){
			echo "1";
		}else{
			echo "0";
			 //echo $estacion[0];
			 //echo $Query2;
			 //echo $Query3;
		}

	}

	public function GuardarComplemento($folio,$nombre,$uuid){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t1.idcliente, t2.uuidfactura from pagosaplicaciones t1 inner JOIN facturas t2 on t1.idfactura = t2.folio where t1.folio_p ='".$folio."'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
			while($filau = $consultad->fetch()){
				$cliente = $filau["idcliente"];
			}
		$Query1 = "INSERT INTO reg_complementos(idcliente_complemento, foliopagoaplicacion, fechagenerado, uuid, nombrecomplemento)
		VALUES('".$cliente."','".$folio."',CURRENT_TIME,'".$uuid."','".$nombre."' )";
		$Query2 = "UPDATE pagosaplicaciones set generado = '1' where folio_p = '".$folio."'";
	
		if ($db->query($Query1) == TRUE && $db->query($Query2) == TRUE){
			echo "1";
		}else{echo "error";}
			




	}

	public function CancelarAbono($abono){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "DELETE FROM abonos WHERE IDabono = '".$abono."'";
		if ($db->query($Query) == TRUE){
			echo "1";
		}else{echo "0";}
	}
	
	public function filtrarAbonos($cte, $fini, $ffin){
		$aplicaciones = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t1.IDclienteAbono,t1.fecha,t1.importeabono,t1.IDabono,t1.formapago,t1.concepto, t2.rzonsocial FROM abonos t1 inner join clientes t2 on t1.IDclienteAbono=t2.idcliente WHERE IDcliente='{$cte}' and DATE(t1.fecha)>='{$fini}' and DATE(t1.fecha)<='{$ffin}' order by fecha DESC";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$aplicaciones[] = $filau;
		}
		return $aplicaciones;
	}
	
	public function pagosapp($cte, $fini, $ffin){
		$aplicaciones = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t1.folio_p ,t1.idcliente,t1.fechacaptura,t1.restanteabono,t2.tipocliente,t1.idfactura,t1.importe as importe_app ,t1.foliopago,t1.abono as abono_app,t1.generado,t1.inactivo, t2.rzonsocial, t2.periododepago, t3.*, t4.referencia, t4.bancodestino, t4.formapago, t4.IDabono, t4.importeabono, t4.importedisponibleabono, t4.fecha FROM pagosaplicaciones t1 inner join clientes t2 on t1.idcliente=t2.idcliente inner join facturas t3 on t1.idfactura=t3.folio inner join abonos t4 on t1.foliopago=t4.IDabono where t1.idcliente ='{$cte}' AND t1.cancelado='0' AND DATE(t1.fechacaptura)>='{$fini}' AND DATE(t1.fechacaptura)<='{$ffin}' ORDER BY fechacaptura ASC";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$aplicaciones[] = $filau;
		}
		return $aplicaciones;
	}

	public function generarFactura($idcliente, $folio, $fecha){
		$facturares = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$nofolios = 0; 
		$correctos = 0;
		$suma = 0;
		$litros = 0;
		$QTC="SELECT tipocliente FROM clientes where idcliente = '".$idcliente."";
		$consultad = $db->prepare($QTC);
		$consultad->execute();
		$TIPOC = $consultad->fetch(PDO::FETCH_OBJ);
		$TIPOC = (array)$TIPOC;
		$TIPOC = $TIPOC['tipocliente'];
		$QUF="SELECT folio FROM facturas ORDER BY folio DESC limit 1";
		$consultad = $db->prepare($QUF);
		$consultad->execute();
		$UltimaFac = $consultad->fetch(PDO::FETCH_OBJ);
		$UltimaFac = (array)$UltimaFac;
		$UltimaFac = $UltimaFac['folio'];
		$UltimaFac = $UltimaFac+1;

		foreach($folio as $fol) { //CHECAR SI SE PUEDE AHORRAR UN FOR CON "$folio[0]"
			foreach($fol as $f){
				if($TIPOC==0){
					$UpdatePA="UPDATE pagosaplicaciones SET idfactura='".$UltimaFac."' where folio_servicio ='".$f."'";
					$consultad = $db->prepare($UpdatePA);
					$consultad->execute();
				}
				
				$getImportes = "SELECT importe, litros from servicios where folio = '".$f."'";
				$consultad = $db->prepare($getImportes);
				$consultad->execute();
				$arrayTot = [];
				$arrayLts = [];
				while($filau = $consultad->fetch()){
					array_push($arrayTot, $filau["importe"]);
					$suma += $filau["importe"];
					array_push($arrayLts, $filau["litros"]);
					$litros += $filau["litros"];
				}
			}
		}

		$QPlazo = "SELECT periododepago from clientes where idcliente = '".$idcliente."'";
		//$resultPlazo = mysqli_query($db,$QPlazo); 
		$consultad = $db->prepare($QPlazo);
		$consultad->execute();
		if ($db->query($QPlazo) == TRUE) {
			while($filau = $consultad->fetch()){
				$Plazo = $filau["periododepago"];
			}
		}else{
			$Plazo = 10;
			
		}
		//if ($resultPlazo->num_rows > 0)
		/*if ($db->query($QPlazo) == TRUE) {
				while($rowPlazo = $resultPlazo->fetch_assoc()) {  
				$Plazo = $rowPlazo['periododepago'] + 1; 
		}
		}else{
			$Plazo = 10;
			
		}*/
		  
		 
		$FechaV =  date('Y-m-d', strtotime($fecha. ' + '.$Plazo.' days'));


		//insert facturas 
		$Query = "INSERT INTO facturas (idcliente, fechafacturacion, importe, restante, cantidad, fechavencimiento) values ('".$idcliente."','".$fecha."','".$suma."','".$suma."','".$litros."', '".$FechaV."')";
	 
		if ($db->query($Query) == TRUE) {
			//get last id 
			$UltimoFolio = "SELECT folio from facturas order by folio DESC limit 1";
			$consultad = $db->prepare($UltimoFolio);
			$consultad->execute();
			while($filau = $consultad->fetch()){
				$LFolio = $filau["folio"];
			}

			/// for each servicio  
			foreach($folio as $fol){
				foreach($fol  as $f){
					$nofolios ++; 

					//insert into facturasservicios 
					$insertFacServ = "INSERT INTO facturasservicios (foliofactura, folioservicio) VALUES ('".$LFolio."', '".$f."')";
					if ($db->query($insertFacServ) == TRUE) {
						//update servicios set facturado 1 
						$updateServ = "UPDATE servicios set facturado = '1' where folio = '".$f."'";
						if ($db->query($updateServ) == TRUE) { 
							$correctos = $correctos +1;
						}
					} 
				} 
			}
		}

		if($nofolios == $correctos){
				$facturares[] = array(
				"res" => '1',
			);
		}else{
				$facturares[] = array(
				"res" => '0',
			);
		}

		return $facturares; 
	}


	public function ComplementosCte($idcliente, $fechainicial, $fechafinal){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t1.abono,t1.fechacaptura,t1.folio_p,t2.rfc from pagosaplicaciones t1 inner join clientes t2 on t1.idcliente=t2.idcliente where t1.idcliente = {$idcliente} and date(t1.fechacaptura) >= '".$fechainicial."' and date(t1.fechacaptura) <= '".$fechafinal."' order by t1.fechacaptura desc";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		$i = 0;
		while($filau = $consultad->fetch()){
		//	$clientes[] = $filau; 
		$clientes[$i] = array(
			"folio"=> $filau['folio_p'], 
			"fecha"=> $filau['fechacaptura'], 
			"importe"=> $filau['abono'],
			"rfc"=> $filau['rfc']
		);
		$i++;
		}
		return $clientes;
	}
	

	
    public function LogIn($user, $pass){
		$loginres = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();

		$Query = "SELECT t1.activo,t1.usuario, t1.idusuario, t1.nombre, t1.tipo, t1.idclienteusu, t1.grupousu FROM usuarios  t1  WHERE BINARY t1.usuario = '{$user}'  AND BINARY  t1.contrasena = '".$pass."'"; 
		
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
				"tipo" => $filau['tipo'],
				"cliente" => $filau['idclienteusu'],
				"grupo" => $filau['grupousu'],
				"act" => $filau['activo']
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
	
	public function addCliente($repre,$cabono,$ccargo,$nombre, $rfc, $grupo, $contacto, $telefono, $direccion,  $colonia, $estado, $ciudad, $cp,$tipo,$periodopago, $limitecredito){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "INSERT INTO clientes ( rzonsocial, nombre, rfc, direccion, contacto, telefono, estado, colonia, cp, ciudad, grupo, tipocliente,cuentaAbono,cuentaCargo,representante) VALUES ('" . $nombre . "', '" . $nombre . "', '" . $rfc . "', '" . $direccion . "', '" . $contacto . "','" . $telefono . "','" . $estado . "','" . $colonia . "','" . $cp . "','" . $ciudad . "','" . $grupo . "','" . $tipo . "','" . $cabono . "','" . $ccargo . "','".$repre."')";
		if ($db->query($Query) == TRUE) {
			
	
				if(mkdir("../../DocsClientes/".$rfc)){
					echo "1"; 
				} else {
					echo "error al crear carpeta";
				}
	
			} else {
				echo "Error al guardar";
			}
		
		if($tipo==1){
			$SelIdCte = "SELECT idcliente FROM clientes ORDER BY idcliente DESC LIMIT 1";
			$consultad = $db->prepare($SelIdCte);
			$consultad->execute();
			while($filau = $consultad->fetch()){
				$idcliente = $filau['idcliente'];
			}

		//insert en tipo pago 
		$QueryTP = "INSERT INTO tipopago (idcliente, tipo, periodocredito, limitecredito) VALUES ('".$idcliente."', '" . $tipo . "', '" . $periodopago . "', '" . $limitecredito . "')";

		if ( $db->query($QueryTP) == TRUE) {		
			$b = "1";
		}else
			$b="2";
		}else{
			$SelIdCte = "SELECT idcliente FROM clientes ORDER BY idcliente DESC LIMIT 1";
			$consultad = $db->prepare($SelIdCte);
			$consultad->execute();
			while($filau = $consultad->fetch()){
				$idcliente = $filau['idcliente'];
			}

			$QueryTP = "INSERT INTO tipopago (idcliente, tipo, periodocredito, limitecredito) VALUES ('".$idcliente."', '" . $tipo . "', '0', '0')";

		if ( $db->query($QueryTP) == TRUE) {		
			$b = "1";
		}else
			$b="2";
		}
		//get ultimo id 
		/*$SelIdCte = "SELECT idcliente FROM clientes ORDER BY idcliente DESC LIMIT 1";
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
		 */
	}

	public function poliza($fecha){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT importe, idcliente FROM servicios where date(fecha)= '".$fecha."'";
		//echo $Query;
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$info[] = $filau;
		}
		
		
		$Query1 = "SELECT importeabono, IDclienteAbono FROM abonos where date(fecha)= '".$fecha."'";
		$consultad = $db->prepare($Query1);
		$consultad->execute();
		//echo $Query1;
		while($filau1 = $consultad->fetch(PDO::FETCH_OBJ)){
			$info[] = $filau1;
		}

		//$fecha = json_decode(json_encode($info), true);
		//print_r($info);
		return $info;

	}

	public function EditarCliente($repre,$CuentaA,$CuentaC,$cte, $contacto, $telefono, $direccion, $tipo, $metodopago, $periodopago, $limitecredito, $colonia, $estado, $ciudad, $cp){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "UPDATE clientes SET cuentaAbono='".$CuentaA."',cuentaCargo='".$CuentaC."',tipocliente = '" . $tipo . "', direccion = '" . $direccion . "', contacto = '" . $contacto . "', telefono = '" . $telefono . "', estado = '" . $estado . "', colonia = '" . $colonia . "', cp = '" . $cp . "', ciudad = '" . $ciudad . "', representante = '".$repre."' WHERE idcliente = '".$cte."'";
		if ($db->query($Query) == TRUE) {
			$a = "1"; 
		}  
	
		//insert en tipo pago 
		$QueryTP = "UPDATE tipopago SET tipo='" . $tipo . "', metodoprepago = '" . $metodopago . "', periodocredito = '" . $periodopago . "', limitecredito = '" . $limitecredito . "' WHERE idcliente = '".$cte."'";

		if ( $db->query($QueryTP) == TRUE) {		
			$b = "1";
		} 
		if(($a == "1") && ($b == "1")){	
			echo "Actualizado correctamente";


		} else {
			echo "Error al guardar";
		} 
	}
	
	public function altagrupo($nombre, $direccion, $rfc){
		$conexion = new Conexion(); 
		$db = $conexion->getConexion();
		$Query = "INSERT INTO grupo (nombre,rzonsocial,rfc) VALUE('{$nombre}','{$direccion}','{$rfc}')";
		if ($db->query($Query) == TRUE) {
			echo "1";
		} else {
			echo "0";
		}
	}

	public function altaestacion($codigo, $nombre, $direc, $clave, $grupo, $lat, $long, $calle, $colonia){
		$conexion = new Conexion(); 
		$db = $conexion->getConexion();
		$Query = "INSERT INTO estaciones(codigo, nombre, direccion, claveestacion, idgrupoest, lat, longi, calle, colonia) VALUES('".$codigo."', '".$nombre."', '".$direc."','".$clave."', '".$grupo."', '".$lat."', '".$long."', '".$calle."', '".$colonia."')";
		if ($db->query($Query) == TRUE) {
			echo "1";
		} else {
			echo $Query;
		}
	}

	public function cambioieps($mieps, $pieps, $dieps, $iva){ 
		$conexion = new Conexion(); 
		$db = $conexion->getConexion(); 
		$Query = "UPDATE impuestos SET IVA = '{$iva}', IEPSmagna = '{$mieps}', IEPSpremium = '{$pieps}', IEPSdiesel = '{$dieps}'";
		
	   
		    
		if ($db->query($Query) == TRUE) { 
			echo "1"; 
		} else { 
			echo $Query; 
		}
	}
	
	public function RRU($tarjeta){
		$conexion = new Conexion(); 
		$db = $conexion->getConexion();
		
		
		$Query = "SELECT rzonsocial, rfc FROM clientes WHERE idcliente=(SELECT idcliente FROM tarjetas WHERE folio='{$tarjeta}')";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$info[] = $filau;
		}
		//$info = $info[0];

		$Query1 = "SELECT fecha from servicios where tarjeta = (SELECT notarjeta from tarjetas where folio = '{$tarjeta}') ORDER BY fecha desc limit 1";
		$consultad = $db->prepare($Query1);
		$consultad->execute();
		while($filau1 = $consultad->fetch(PDO::FETCH_OBJ)){
			$info[] = $filau1;
		}
		
		$fecha = json_decode(json_encode($info), true);
		//print_r($fecha);
		return $fecha;

	}

	public function getVehiculosClient($cte){
		$vehiculos = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion();
		$Query = "SELECT * FROM vehiculos WHERE idcliente='{$cte}'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$vehiculos[] = $filau;
		}
		
		return $vehiculos;
	}

	public function UpDateTarjeta($tarjeta, $estado, $estacion, $combustible, $horariodia1, $horariodia2, $horariodia3,
		$horariodia4, $horariodia5, $horariodia6, $horariodia7, $horario1, $horario2, $limiteC, $limiteD, $limiteP, $limitetipo){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$e=0;
		$c=0;
		$contador=0;
		$a=0;
		$Query = "UPDATE tarjetas SET horarioinicial = '{$horario1}', horariofinal = '{$horario2}', 
		lunes = '{$horariodia1}', martes = '{$horariodia2}', miercoles = '{$horariodia3}', jueves = '{$horariodia4}', viernes = '{$horariodia5}',
		sabado = '{$horariodia6}', domingo = '{$horariodia7}', limitelitros = '{$limiteC}', limitedinero = '{$limiteD}', tipoperiodo = '{$limiteP}', tipolimite = '{$limitetipo}'
			WHERE folio='{$tarjeta}'";
		if ($db->query($Query)==TRUE){$contador=$contador+1;}else{$contador=$contador+0;}
		$Query1 = "DELETE FROM tarjeta_estacion WHERE folio_tarjeta = '".$tarjeta."';";
		if ($db->query($Query1)==TRUE){$contador=$contador+1;}else{$contador=$contador+0;}
		//echo sizeof($estacion);
		foreach($estacion as $e){
			$Query2 = "INSERT INTO tarjeta_estacion(folio_tarjeta, folio_estacion)Values('".$tarjeta."', '".$e."');";
			if($db->query($Query2)==true){
				$a=$a+1;
			};
			if($a==sizeof($estacion)){
				$contador=$contador+1;
				$a=0;
			}else{$contador=$contador+0;}
			}

			$Query3 = "DELETE FROM tarjeta_producto WHERE folio_tarjeta = '".$tarjeta."';";
			if ($db->query($Query3)==TRUE){$contador=$contador+1;}else{$contador=$contador+0;}
		foreach($combustible as $c){
			$Query4 = "INSERT INTO tarjeta_producto(folio_tarjeta, folio_producto)Values('".$tarjeta."', '".$c."');";
			if($db->query($Query4)==true){
				$a=$a+1;
			};
			if($a==sizeof($combustible)){
				$contador=$contador+1;
			}else{$contador=$contador+0;}
			}

			
		if ($contador==5){
			echo "1";
		} else {
			echo "0";
		}
	}


	public function getProductoR($cte){
		$producto = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query= "SELECT t1.folio, t3.folio_producto, t4.nombre FROM tarjetas t1 inner join clientes t2 on t1.idcliente=t2.idcliente 
		inner join tarjeta_producto t3 on t1.folio=t3.folio_tarjeta 
		inner join productos t4 on t4.folio=t3.folio_producto where t1.idcliente='".$cte."'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$producto[] = $filau;
		}
		return $producto;
	}

	public function getTarjetasCliente($cte){
		$tarjetas = array(); 
		$conexion = new Conexion(); 
		$db = $conexion->getConexion();
		$Query = "SELECT * FROM tarjetas  WHERE idcliente='{$cte}'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$tarjetas[] = $filau;
		}
		
		return $tarjetas;
	}
	
	public function getVehiculosCliente($cte){
		$estaciones = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT * from vehiculos WHERE idcliente='".$cte."'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$estaciones[] = $filau;
		}
		return $estaciones;
	}

	public function getEstacionRel($cte){
		$estaciones = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t1.* from tarjeta_estacion t1 inner join tarjetas t2 on t1.folio_tarjeta = t2.folio where t2.idcliente='".$cte."'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$estaciones[] = $filau;
		}
		return $estaciones;
	}
	
	public function getCombustibles(){
		$prod = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT * FROM productos";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$prod[] = $filau;
		}
		return $prod;
	}

	public function getProd($cte){
		$prod = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t1.folio, t3.folio_producto, t4.nombre FROM tarjetas t1 inner join clientes t2 on t1.idcliente=t2.idcliente 
		inner join tarjeta_producto t3 on t1.folio=t3.folio_tarjeta 
		inner join productos t4 on t4.folio=t3.folio_producto where t1.idcliente='".$cte."'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$prod[] = $filau;
		}
		return $prod;
	}

	public function getEsta($cte){
		$Est = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t1.folio, t3.folio_estacion, t4.nombre FROM tarjetas t1 inner join clientes t2 on t1.idcliente=t2.idcliente 
		inner join tarjeta_estacion t3 on t1.folio=t3.folio_tarjeta 
		inner join estaciones t4 on t4.idestacion=t3.folio_estacion  where t1.idcliente='".$cte."'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$Est[] = $filau;
		}
		return $Est;
	}


	public function getservR($cte){
		$grupo = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion();
		$Query = "SELECT * FROM facturas WHERE restante >=1 AND idcliente='{$cte}'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$grupo[] = $filau;
		}
		
		return $grupo;
	}


	public function getgrupo(){
		$grupo = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion();
		$Query = "SELECT * FROM grupo";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$grupo[] = $filau;
		}
		return $grupo;
	}

	public function getImpuestos(){
		$impuestos = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion();
		$Query = "SELECT * FROM impuestos";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$impuestos[] = $filau;
		}
		return $impuestos;
	}

	public function getClientes(){
		$clientes = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion();
			$Query = "SELECT t1.*,t2.Tipo , t2.periodoCredito , t2.limiteCredito as limiteC FROM clientes t1 inner join tipopago t2 on t1.idcliente = t2.idcliente";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$clientes[] = $filau;
		}
		return $clientes;
	}
	public function obtenerServicios($idcliente, $fechainicial, $fechafinal){
		$clientes = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion();
		$Query = "SELECT * FROM servicios where idcliente = '".$idcliente."' and DATE(fecha) >= '".$fechainicial."' and DATE(fecha) <= '".$fechafinal."'  and facturado = '0' and cancelado = '0'";
		$consultad = $db->prepare($Query);  
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$clientes[] = $filau;
		}
		return $clientes;
	}

	public function CancelarServicios($servicio){
		$conexion = new Conexion(); 
		$db = $conexion->getConexion();
		$contador = 0;
		$i=0;
		$abonos = 0;
		$abonoTotal=0;
		$Query = "UPDATE servicios SET cancelado = '1' where folio = '".$servicio."'";
		if ($db->query($Query) == TRUE) {
			$contador = $contador +1;
		} else {
			$contador =0;
		}
		$Query5 = "UPDATE pagosaplicaciones SET cancelado = '1' where folio_servicio = '".$servicio."'";
		if ($db->query($Query5) == TRUE) {
		$Query2 = "SELECT abono,foliopago FROM pagosaplicaciones where folio_servicio = '".$servicio."'";
		$consultad = $db->prepare($Query2);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$Servicios[] = $filau;
			
		}
		} 
		
		

		foreach ($Servicios as $value){$res[$i]['folio'] = $value->foliopago;$res[$i]['abono'] = $value->abono;$i=$i+1;}

		foreach($res as $s){
			$Query3 = "SELECT importedisponibleabono FROM abonos where IDabono = '".$s['folio']."'";
			$consultad = $db->prepare($Query3);
			$consultad->execute();
			while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$importe[] = $filau;
			}
			foreach ($importe as $value){$dis[] = $value->importedisponibleabono;}

				$abonoTotal = $dis[0]+$s['abono'];

				$Query4 = "UPDATE abonos SET importedisponibleabono='".$abonoTotal."' where IDabono = '".$s['folio']."'";
			
			if ($db->query($Query4) == TRUE) {
				$abonos=$abonos+1;
			}else{
				$abonos = 0;
			}
		
		}

		if($abonos>=1){
			$contador = $contador +1;
		}else{$contador = 0;}

		if($contador ==2){
			echo "1";
		}else{
			echo "0";
		}

	}

	public function CancelarFacturas($factura){
		$conexion = new Conexion(); 
		$db = $conexion->getConexion();
		$contador = 0;
		$folios = 0;
		$i =0;

		$Query = "UPDATE facturas SET cancelado = '1', timbrado='0'  where folio = '".$factura."'";
		if ($db->query($Query) == TRUE) {
			$contador=$contador+1;
		} else {
			$contador = 0;
		}
		
		$Query2 = "SELECT folioservicio FROM facturasservicios where foliofactura = '".$factura."'";
		
		$consultad = $db->prepare($Query2);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$Servicios[] = $filau;
			
			
		}


		foreach ($Servicios as $value){$res[] = $value->folioservicio;}

		foreach($res as $s){
			$Query3 = "UPDATE servicios SET facturado = '0' where folio = '".$s."'";
			//$i=$i+1;
			//echo $Query3;
		if ($db->query($Query3) == TRUE) {
			$folios=$folios+1;
		} else {
			$folios = 0;
		}
		}

		if($folios>=1){
			$Query4 = "UPDATE facturasservicios SET folioservicio = '0' where foliofactura = '".$factura."'";
		if ($db->query($Query4) == TRUE) {
			$contador=$contador+1;
		} else {
			$contador = 0;
		}
		}else{
			$contador = 0;
		}

		

		

		if($contador==2){
			echo "1";
		}else{
			echo "0";
		}

	}


	public function addUsuarioWeb($idcliente, $nombre, $usuario, $contrasena, $tipo){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "INSERT INTO usuariosweb (idclienteweb, nombreweb, usuario, contrasena, tipo, activo) VALUES ('".$idcliente."', '".$nombre."', '".$usuario."','".$contrasena."','".$tipo."', 1)";	 

		if ($db->query($Query) == TRUE) {
			echo "1";
		} else {
			echo "0";
		}
	}

	public function getUsuariosWeb($cte){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT * FROM usuariosweb t1 inner join clientes t2 on t1.idclienteweb = t2.idcliente where idclienteweb = {$cte}";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$clientes[] = $filau;
		}
		return $clientes;
	}

	public function getONp($chofer){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT  nip from choferes where idchofer = '".$chofer."'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$cargos[] = $filau;
		}
		return $cargos;
	}

	public function Cargos($placa){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT  t1.activo, t1.nip, t1.notarjeta, t3.choferactivo, t1.folio, t3.nombre FROM tarjetas t1 inner join vehiculos_choferes t2 on t2.idvehiculo = t1.idplaca inner join choferes t3 on t2.idchofer = t3.idchofer where t1.idplaca ={$placa} limit 1";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$cargos[] = $filau;
		}
		return $cargos;
	}

	public function getproducto(){
		$estaciones = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
			$Query = "SELECT * FROM productos";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$estaciones[] = $filau;
		}
		return $estaciones;
	}

	public function getEstaciones($grupo){
		$estaciones = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		if($grupo == "0"){
			$Query = "SELECT * FROM estaciones";
		}else{
			$Query = "SELECT * FROM estaciones where idgrupoest = '".$grupo."'";
		}
		
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$estaciones[] = $filau;
		}
		return $estaciones;
	}

	public function addUsuario($nombre, $grupo, $usuario, $contrasena, $tipo, $gpo){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		if($gpo=="0"){
			$Query = "INSERT INTO usuarios (nombre, usuario, contrasena, tipo, grupousu) VALUES ('".$nombre."','".$usuario."','".$contrasena."','".$tipo."','" .$gpo."')";
			$a="1";
		}else{
			$Query = "INSERT INTO usuarios (nombre, usuario, contrasena, tipo, grupousu) VALUES ('".$nombre."','".$usuario."','".$contrasena."','".$tipo."','" .$gpo."')";
			$a="2";
		}
		

		if ($db->query($Query) == TRUE) {
			echo $a;		
		} else {
			echo $Query;
		}
	}

	public function getUsuarios($gpo){
		$clientes = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		if($gpo==0){
			$Query = "SELECT * FROM usuarios";
		}else{
			$Query = "SELECT * FROM usuarios  where grupousu = '".$gpo."'";
		}
		
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
		
			$Query = "INSERT INTO choferes(nombre, idcliente,choferactivo) VALUES ('{$nombre}', '{$idCliente}',  '1')";
		if ($db->query($Query) == TRUE) {
			echo "1";
		} else {
			echo "Error al guardar";
		}
		
		
	}
	public function getchoferesC($cte, $placa){
		$clientes = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t1.nombre,t1.idchofer, t2.idvehiculo FROM choferes t1 inner join vehiculos_choferes t2 on t1.idchofer=t2.idchofer  WHERE t1.idcliente = '".$cte."' AND t2.idvehiculo='".$placa."'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$clientes[] = $filau;
		}
		return $clientes;
	}

	public function consiliacion(){
		$clientes = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t1.idcliente, t1.rzonsocial,t2.limiteCredito, t2.periodoCredito, SUM(t3.restante) as restante from clientes t1 inner join tipopago t2 on t1.idcliente=t2.idcliente inner join servicios t3 on t3.idcliente=t1.idcliente where t1.tipocliente = 1 group by t1.idcliente";
		$consultad = $db->prepare($Query);
		//echo $Query;
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$clientes[] = $filau;
		}
		return $clientes;
	}

	public function getChoferes($cte){
		$i = 0;
		$f = 0;
		$clientes = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		// $Query = "SELECT * FROM choferes t1 inner join clientes t2 on t1.idcliente = t2.idcliente";
		$Query = "SELECT * FROM choferes WHERE idcliente = '".$cte."'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$clientes[] = $filau;
		}
		return $clientes;
	}

	public function addTarjeta($idcliente, $notarjeta, $idplaca, $activo, $tipo, $combustible, $horarioinicial, $horariofinal, $lunes, $martes,$miercoles, $jueves,
			$viernes, $sabado, $domingo, $estacion, $limitedinero, $limitelitros, $tipoperiodo,$nip, $limitetipo){
			$i=0;
			$c=0;
			$d=0;
			$conexion = new Conexion();
			$db = $conexion->getConexion();
				$verificar = "SELECT COUNT(notarjeta) as notarjeta
				FROM tarjetas
				WHERE notarjeta = '".$notarjeta."'";
				$consultad = $db->prepare($verificar);
				$consultad->execute();
				//$filau = $consultad->fetch();
				while($filau = $consultad->fetch()){
					$res = $filau['notarjeta'];
				}
				if($res==0){
					$Query = "INSERT INTO tarjetas (idcliente, notarjeta, idplaca, activo, tipo, horarioinicial, horariofinal, lunes, martes,miercoles, jueves,
			viernes, sabado, domingo, limitedinero, limitelitros, tipoperiodo, nip,tipolimite) VALUES ('" . $idcliente . "','" . $notarjeta . "','" . $idplaca . "','" . $activo . "'
			,'" . $tipo . "','" . $horarioinicial . "','" . $horariofinal . "','" . $lunes . "','" . $martes . "','" . $miercoles . "','" . $jueves . "','" . $viernes . "','" . $sabado . "'
			,'" . $domingo . "','" . $limitedinero . "','" . $limitelitros . "','" . $tipoperiodo . "','" .$nip. "', '".$limitetipo."')";
			
			if ($db->query($Query) == TRUE) {
				$i=$i+1;
			} else {
				$i=$i+0;
			}
			
				$Query1 = "SELECT folio from tarjetas ORDER BY folio DESC LIMIT 1";
				$consultad = $db->prepare($Query1);
				$consultad->execute();
				while($filau = $consultad->fetch()){
					$usuario = $filau['folio'];
				}
			foreach($combustible as $com){
				$Query2 = "INSERT INTO tarjeta_producto(folio_tarjeta,folio_producto)VALUES('".$usuario."','".$com."') ";
			
				if ($db->query($Query2) == TRUE) {
					$c=$c+1;
				} else {
					$c=$c+0;
				}
			}
			if($c==sizeof($combustible)){
				$i=$i+1;
			} else {
				$i=$i+0;
			}

			foreach($estacion as $e){
				$Query3 = "INSERT INTO tarjeta_estacion(folio_tarjeta,folio_estacion)VALUES('".$usuario."','".$e."') ";
				if ($db->query($Query3) == TRUE) {
					$d=$d+1;
				} else {
					$d=$d+0;
				}
			}
			if($d==sizeof($estacion)){
				$i=$i+1;
			} else {
				$i=$i+0;
			}

			$Query4 = "UPDATE vehiculos set idtarjeta = '".$usuario."' WHERE idvehiculo = '".$idplaca."'";
				if ($db->query($Query4) == TRUE) {
					$i=$i;
				} else {
					$i=0;
				}
			
			if ($i==3){
				echo "1";
			} else {
				echo "0";
			}
				}else{
					echo "3";
				}

			
		}

	public function getTarjetas($cte){ 
		$clientes = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t1.*, t2.rzonsocial,t3.placas FROM tarjetas t1 inner join clientes t2 on t1.idcliente=t2.idcliente inner join vehiculos t3 on t1.idplaca=t3.idvehiculo WHERE t1.idcliente='{$cte}'";//t1 inner join clientes t2 on t1.idcliente = t2.idcliente";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$clientes[] = $filau;
		}
		return $clientes;
	}

	public function addVehiculo($idCliente, $modelo, $ano, $placas, $noEconomico, $tipoVehiculo, $controlaOdometro, $choferes,$kmmx){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Cchofer = 0;
		$cont = 0;
		

		$Query = "INSERT INTO vehiculos (idcliente, modelo, ano, placas, noeconomico, tipovehiculo,  controlaodometro, activo,kmmin) VALUES ('".$idCliente."','".$modelo."','".$ano."','".$placas."','".$noEconomico."','".$tipoVehiculo."','".$controlaOdometro."', '1','".$kmmx."')";

		if ($db->query($Query) == TRUE) {
			$cont = $cont + 1;
		} else {
			$cont = 0;
		}
		$vehiculo = "SELECT idvehiculo FROM vehiculos WHERE idcliente = '".$idCliente."' ORDER BY idvehiculo DESC limit 1";
		 
		$consultad = $db->prepare($vehiculo);
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$idvehiculo = $filau['idvehiculo'];
		}
 
		foreach($choferes as $c){
			$QdeQuery="INSERT INTO vehiculos_choferes(idvehiculo,idchofer)VALUES('".$idvehiculo."','".$c."')";
			if ($db->query($QdeQuery) == TRUE) {
				$Cchofer++;
			}else{
				$Cchofer=0;
			}
		}
		if($Cchofer==0){
			$cont =0;
		}else{
			$cont= $cont+1;
		}

		if($cont==2){
			echo "1";
		}else{
			echo "0";
		} 

	}

	public function getPrecios($estacion,$producto){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT preciouni FROM precio_prod where idestacionprod = '".$estacion."' and idprodc = '".$producto."'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		$res= array();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$res[] = $filau;
		}
		return $res;
	}

	public function addFactura($idcliente){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT folio, fechagenerado, importe, restante, factura, cantidad FROM facturas where idcliente = '".$idcliente."' and timbrado = 0 and cancelado =0";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		$res= array();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$res[] = $filau;
		}
		return $res;
	}

	public function getVehiculos($cte){ 
		$clientes = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT * FROM vehiculos  WHERE idcliente ='".$cte."' ";  //t1 inner join clientes t2 on t1.idcliente = t2.idcliente
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$clientes[] = $filau;
		}
		return $clientes;
	}
	public function getVehiculos2(){ 
		$clientes = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT * FROM vehiculos";  //t1 inner join clientes t2 on t1.idcliente = t2.idcliente
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$clientes[] = $filau;
		}
		return $clientes;
	}

	public function addAbono($idcliente, $importe, $formapago, $bancodestino, $cuentabancaria, $referencia, $concepto){
		//$cont=0;
		$importeAb = $importe;
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		/*$Qtipo = "SELECT tipocliente from clientes WHERE idcliente = '".$idcliente."'";
		$consultad = $db->prepare($Qtipo);
		$consultad->execute();
		$tipo = $consultad->fetch();
		$tipo = (array)$tipo;
		$tipo = $tipo['tipocliente'];
		if($tipo == '1'){
		$Qserv = "SELECT folio, restante from servicios where idcliente = '".$idcliente."' and facturado = '0' and restante > '0' ORDER BY fecha ASC";
		$consultad = $db->prepare($Qserv);
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$rest[] = $filau;
		}
		foreach($rest as $element){
			$restante =  $element[1];
			$folio = $element[0];
			if($importeAb == 0){
				break;
			}else if($importeAb >= $restante){
				$importeAb = $importeAb - $restante;
				$restante = 0;
				$QUPRES = "UPDATE servicios SET restante ='".$restante."', facturado = '1' WHERE folio = '".$folio."'";
				if($db->query($QUPRES)== TRUE){
					$cont = $cont + 1;
				}else{$cont = 0;}
				
			}else if($importeAb < $restante){
				
				$restante = $restante - $importeAb;
				$importeAb = 0;
				$QUPRES2 = "UPDATE servicios SET restante ='".$restante."' WHERE folio = '".$folio."'";
				if($db->query($QUPRES2)== TRUE){
					$cont = $cont + 1;
				}else{$cont = 0;}
			
			}
		}
		}else{
			$cont = $cont +1;
		}
		
		if($cont == 0){
			echo "No se actualizo restante en servicios";
		}else{*/
			$Query = "INSERT INTO abonos(IDclienteAbono, fecha, importeabono, formapago, bancodestino, cuentabancaria, referencia, concepto, importedisponibleabono) 
			VALUES('{$idcliente}', CURRENT_TIME, '{$importe}', '{$formapago}', '{$bancodestino}', '{$cuentabancaria}', '{$referencia}', '{$concepto}', '{$importe}')";
		if ($db->query($Query) == TRUE) {
			echo "1";
		} else {
			echo "0";
		}

		

		
	}

	public function getAbonos2($cte){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT * FROM abonos WHERE IDclienteAbono={$cte}";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$abonos[] = $filau;
		}
		return $abonos;
	}

	public function getAbonos($cte){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t1.IDclienteAbono,t1.fecha,t1.importeabono,t1.IDabono,t1.formapago,t1.concepto, t2.rzonsocial FROM abonos t1 inner join clientes t2 on t1.IDclienteAbono=t2.idcliente WHERE IDcliente='{$cte}' order by fecha DESC limit 15";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$abonos[] = $filau;
		}
		return $abonos;
	}

	public function addCargo($idcliente, $estacion, $fecha, $tarjeta, $importe, $producto){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "INSERT INTO cargos(idcliente, estacion, fecha, tarjeta, importe, producto) 
			VALUES('{$idcliente}', '{$estacion}', '{$fecha}', '{$tarjeta}', '{$importe}', '{$producto}')";
		if ($db->query($Query) == TRUE) {
			echo "Guardado correctamente";
		} else {
			echo "Error al guardar";
		}
	}
	function formatDate($toFormat){
        $data = explode(",", $toFormat);
        $formattedDate = $data[0]."".$data[1]; 
        return $formattedDate;
    }
	public function serviciomanual($tarjeta,$cliente,$estacion,$importe,$producto,$litros,$precio,$km,$servicio,$chofer){
		$prox=0;
		$CantImporte=$importe;
		$conexion = new Conexion();
		$servm = array();
		$preciouni = 0;
		$litros=0;
		$db = $conexion->getConexion();
		$QuerySer = "SELECT preciouni FROM precio_prod where idestacionprod = '".$estacion."' and idproduc = '".$producto."' ORDER BY fecha DESC limit 1";
		$consultad = $db->prepare($QuerySer);
		$consultad->execute();
		$res = $consultad->fetch();
		$preciouni = $res['preciouni'];
		
		$litros = $importe / $preciouni;
		
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
			$prox = $total;
		}else{
			$Querylimite = "SELECT SUM(importe) FROM servicios WHERE idcliente='".$cliente."' and facturado = '0'";
			$consultad = $db->prepare($Querylimite);
			$consultad->execute();
			$limite = $consultad->fetch(PDO::FETCH_OBJ);
			$limite = (array)$limite;
			$limite = $limite['SUM(importe)'];
			$total = $limite+$importe;
			$total = $Limitecliente['limiteCredito']-$total;
			$prox = $total;
		}
		
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
		if($total>=0){
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
			$Query = "INSERT INTO servicios(idcliente, estacion, fecha, tarjeta, importe, producto, litros, restante, preciounitario,tiposervicio,idchofer, saldoProxima,bomba) 
			VALUES('{$cliente}', '{$estacion}', CURRENT_TIME , '{$tarjeta}', '{$CantImporte}', '{$producto}', '{$litros}', '{$CantImporte}', '{$preciouni}', '{$servicio}', '{$chofer}','{$prox}','BOMBA 1 ')";
		if ($db->query($Query) == TRUE) { 
			$servm[] = array(
				"respuesta" => "1"
			);

			
		} else {
			$servm[] = array(
				"respuesta" => "0"
			);
		}			
		return $servm;

		}else{
			return "Saldo insufuciente";
		}



		
	}

	

	public function getTransacciones(){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT * FROM servicios";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$abonos[] = $filau;
		}
		return $abonos;
	}

	/**  CLIENTES  **/
	public function C_Login($user, $pass){
		$loginres = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();

		$Query = "SELECT idusuarioweb, idcliente, usuario, nombre, tipo FROM usuariosweb WHERE BINARY usuario='{$user}' AND BINARY contrasena='{$pass}'"; 
		
		session_start();
		$consultad = $db->prepare($Query);
		$consultad->execute();

		while($filau = $consultad->fetch()){
			$usuario = $filau['usuario'];
			$loginres[] = array(
				"res" => '1',
				"idusuarioweb" => $filau['idusuarioweb'],
				"idcliente" => $filau['idcliente'],
				"usuario" => $filau['usuario'],
				"nombre" => $filau['nombre'],
				"tipo" => $filau['tipo']
			);
        }  

		if(isset($usuario)){ 
			return $loginres;
		} else {
			$loginres[] = array(
				"res" => '0',
				"quedaste" => $Query
			);
			return $loginres;
		}
	}

	public function C_getVehiculos($cte){ 
		$clientes = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT * FROM vehiculos WHERE idcliente={$cte}";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$clientes[] = $filau;
		}
		return $clientes;
	}

	public function getSaldo($cte){ 
		$clientes = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT importedisponibleabono FROM abonos WHERE iDclienteabono={$cte}";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$clientes[] = $filau;
		}
		return $clientes;
	}

	public function getCredito($cte){ 
		$clientes = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT sum(t1.restante) as restante, t2.limiteCredito  FROM servicios t1 inner join tipopago t2 on t1.idcliente=t2.idcliente WHERE t1.idcliente={$cte} and t1.restante >= '1'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$clientes[] = $filau;
		}
		return $clientes;
	}

	public function getCredito2($cte){ 
		$credito= array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT limiteCredito  FROM tipopago WHERE idcliente={$cte}";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$credito[] = $filau;
		}
		return $credito;
	}


	public function getFacturaSinres($idcliente){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT folio, fechagenerado, importe, factura FROM facturas where idcliente = '".$idcliente."' and restante = '0'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		$res= array();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$res[] = $filau;
		}
		return $res;
	}
	public function UpDateTarjetas( $activo, $valor){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		

			$Query = "UPDATE tarjetas SET activo ='".$activo."' WHERE folio ='".$valor."'";

			if ($db->query($Query) == TRUE) {
				echo "1";
			} else {
				echo "0";
			}
			

	}
	public function UpDateVehiculo($activo, $id){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		

			$Query = "UPDATE vehiculos SET activo ='".$activo."' WHERE idvehiculo ='".$id."'";

			if ($db->query($Query) == TRUE) {
				echo "1";
			} else {
				echo "0";
			}
			
		

		

	}
	public function UpDateUsuarioWeb($activo, $id){
		$conexion = new Conexion();
		$db = $conexion->getConexion();

		//$i =0;
		//$num =0;
		//foreach($id as $v){

			$Query = "UPDATE usuariosweb SET activo ='".$activo."' WHERE idusuarioweb ='".$id."'";

			if ($db->query($Query) == TRUE) {
				//$num++;
				echo "1";
			} else {
				echo "0";
			}
			//$i ++;
		//}

		
	}
	public function UpDateUsuario($activo, $id){
		$conexion = new Conexion();
		$db = $conexion->getConexion();

			$Query = "UPDATE usuarios SET activo ='".$activo."' WHERE idusuario ='".$id."'";

			if ($db->query($Query) == TRUE) {
				echo "1";
			} else {
				echo "0";
			}
	}
	public function UpDateChofer($activo, $id){
		$conexion = new Conexion();
		$db = $conexion->getConexion();

			$Query = "UPDATE choferes SET choferactivo ='".$activo."' WHERE idchofer ='".$id."'";

			if ($db->query($Query) == TRUE) {
				echo "1";
			} else {
				echo "0";
			}

	}
	public function fRendimiento($cte, $fechai, $fechaf){
		$clientes = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t1.fecha, t1.tarjeta, t2.notarjeta,t2.folio, t3.placas, t3.noeconomico, t1.importe, t1.estacion, t5.nombre, t1.litros, t7.nombre as nombrep, t6.kmanterior, t6.kmnuevo from jkmpg7ol_monedero.servicios t1 inner join jkmpg7ol_monedero.productos t7 on t1.producto = t7.folio inner join jkmpg7ol_monedero.tarjetas t2 on t1.tarjeta = t2.notarjeta inner join jkmpg7ol_monedero.vehiculos t3 on t2.folio = t3.idtarjeta inner join jkmpg7ol_monedero.vehiculos_choferes t4 on t3.idvehiculo = t4.idvehiculo inner join jkmpg7ol_monedero.choferes t5 on t5.idchofer = t4.idchofer inner join jkmpg7ol_monedero.odometro t6 on t6.idservicio = t1.folio  where t3.controlaodometro = 1 and t1.idcliente = '".$cte."' and t1.fecha >= '".$fechai."' and t1.fecha <= '".$fechaf."'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		//echo $Query;
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$clientes[] = $filau;
		}
		return json_encode($clientes);
	}

	public function Filtrarfac($cte, $fechai, $fechaf){
		$clientes = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t1.folio, t1.fechagenerado, t1.importe, t1.factura, t1.cantidad, t2.rfc from facturas t1 inner join clientes t2 on t1.idcliente = t2.idcliente where t1.idcliente = '".$cte."' and date(t1.fechagenerado) >= '".$fechai."' and date(t1.fechagenerado) <= '".$fechaf."' and t1.timbrado = 1";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		//echo $Query;
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$clientes[] = $filau;
		}
		return json_encode($clientes);
	}

public function Addfacturaestacion($estacion, $fechainicio, $fechafin){
	$servicios = array();
	$conexion = new Conexion();
	$db = $conexion->getConexion();
	$TotalImporte=0;
	$TotalLitros=0;
	$i=0;
	$query="SELECT folio,importe,litros from servicios where estacion='".$estacion."' AND date(fecha)>='".$fechainicio."' AND date(fecha)<='".$fechafin."'";

		$consultad = $db->prepare($query);
		$consultad->execute();
		//echo $query; 
		while($filau = $consultad->fetch()){
			$servicios[] = array(
				"folio" => $filau["folio"],
				"importe" => $filau["importe"],
				"litros" => $filau["litros"]
			);
		}
		foreach($servicios as $servicio){
		 	$TotalImporte+=$servicio["importe"];
			$TotalLitros+=$servicio["litros"];
		}
	

		$insertFactura="INSERT INTO facturas(fechagenerado,importe,idestacion,restante,factura,cantidad,timbrado,cancelado)VALUES(current_time,'".$TotalImporte."','".$estacion."','".$TotalImporte."',(Select t1.rfc from grupo t1 inner join estaciones t2 on t1.idgrupo=t2.idgrupoest where t2.idestacion='".$estacion."'),'".$TotalLitros."',0,0)";
		if($db->query($insertFactura)==true){

			foreach($servicios as $servicio){
				$insert = "INSERT INTO factura_estacion(folio_factura,folio_servicio,idestacion)VALUES((SELECT folio from facturas order by folio desc limit 1),'".$servicio["folio"]."','".$estacion."')";
				if($db->query($insert)==true){
					$i++;
				}
			
			}
		}
		
		if($i==sizeof($servicios)){
			echo "1";
		}else{
			
			echo "0";
		}

}


public function getFaturaEstacion(){
	$conexion = new Conexion();
	$db = $conexion->getConexion();

	$Query="SELECT * FROM facturas where cancelado !='1' and idestacion !='0' and timbrado ='0'";

	$consultad = $db->prepare($Query);
	$consultad->execute();
	while($filau = $consultad->fetch()){
		$clientes[] = $filau;
	}

	return $clientes;

}

public function cancelarFaturaEstacionn($folio){
	$conexion = new Conexion();
	$db = $conexion->getConexion();

	$query="UPDATE facturas SET cancelado = '1' where folio='".$folio."'";

	if($db->query($query)==true){
		echo "1";
	}else{
		echo "0";
	}
}

public function GetChoferSinNip(){
	$conexion = new Conexion();
	$db = $conexion->getConexion();

	$Query = "SELECT idchofer From choferes where nip ='SinN'";

	$consultad = $db->prepare($Query);
	$consultad->execute();
	while($filau = $consultad->fetch()){
		$clientes[] = $filau['idchofer'];
	}

	return $clientes;

}
public function lastCardNumber(){
	$conexion = new Conexion();
	$db = $conexion->getConexion();

	$Query = "SELECT max(notarjeta) as notarjeta from tarjetas order by folio desc";
	$tarjeta = "";
	$consultad = $db->prepare($Query);
	$consultad->execute();
	while($filau = $consultad->fetch()){
		$tarjeta = $filau['notarjeta'];
	}

	return $tarjeta;

}



public function addNip($folios, $nips){
	$conexion = new Conexion();
	$db = $conexion->getConexion();
	
	$i=0;
	foreach($folios as $folio){
		$checar1 ="SELECT idchofer from choferes where idchofer='".$folio."'";
	$consultad = $db->prepare($checar1);
	$consultad->execute();
	while($filau = $consultad->fetch()){
		$res1 = $filau['idchofer'];
	}

	$checar2 ="SELECT idchofer from choferes where nip='".$nips[$i]."'";
	$consultad = $db->prepare($checar2);
	$consultad->execute();
	while($filau = $consultad->fetch()){
		$res2 = $filau['idchofer'];
	}

	if($res1==$res2){

	}else{
		$insert="UPDATE choferes SET nip = '".$nips[$i]."' where idchofer = '".$folio."'";
		if($db->query($insert)==true){
			$c[]=array(
				'folio' => $folio
			);
		}

	}
	$i++;

	}

	foreach($c as $f){
		$Query= "SELECT t1.nombre, t1.nip, t2.nombre as cliente from choferes t1 inner join clientes t2 on t1.idcliente=t2.idcliente where t1.idchofer='".$f['folio']."'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch()){
				$respuesta[]=array(
					'nombre' => $filau['nombre'],
				'nip' => $filau['nip'],
				'cliente' => $filau['cliente']
				);
				
	}
	}
	


	return $respuesta;




	}
	

	






}
