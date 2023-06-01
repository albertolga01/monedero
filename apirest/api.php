<?php

class Api{


	public function editarTarjetaApp($folio, $placas, $limitedinero, $limitelitros, $lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo, $horarioinicial, $horariofinal, $estadoestacion, $nombreestacion, $estadoproducto, $nombreproducto){ 
		$conexion = new Conexion();
		$db = $conexion->getConexion();


		$getIdTarjeta = "SELECT folio from tarjetas where notarjeta = '".$folio."'";
		$consultat = $db->prepare($getIdTarjeta);
						$consultat->execute();

						while($filat = $consultat->fetch()){
							$folio = $filat['folio'];
							
						}  

			$Update = "UPDATE tarjetas set limitedinero = '".$limitedinero."', limitelitros = '".$limitelitros."',  
			lunes = '".$lunes."', martes = '".$martes."', miercoles = '".$miercoles."', jueves = '".$jueves."', viernes = '".$viernes."', sabado = '".$sabado."', domingo = '".$domingo."',
			horarioinicial = '".$horarioinicial."', horariofinal = '".$horariofinal."'
			where folio = '".$folio."'";
   

			$estaciones = "DELETE from tarjeta_estacion where folio_tarjeta = '".$folio."'";
			$db->query($estaciones);
			$n = 0;
 

			foreach($nombreestacion as $name){
					//get folio estacion  
					if($estadoestacion[$n] == "true"){
						$selNomEstacion = "SELECT idestacion from estaciones where nombre = '".$nombreestacion[$n]."' LIMIT 1";
						$consultad = $db->prepare($selNomEstacion);
						$consultad->execute();

						while($filau = $consultad->fetch()){
							$idestacion = $filau['idestacion'];
							
						}  
						$In_estaciones = "INSERT into tarjeta_estacion (folio_tarjeta, folio_estacion) values ('".$folio."', '".$idestacion."')";
						$db->query($In_estaciones);
					}
			
			$n++;
			}

 
			$productos = "Delete from tarjeta_producto where folio_tarjeta = '".$folio."'";
		 		
			$db->query($productos);
			$u = 0;
			foreach($nombreproducto as $namep){
				//get folio estacion   
				if($estadoproducto[$u] == "true"){
					$selNomEstacion = "SELECT folio from productos where nombre = '".$nombreproducto[$u]."' LIMIT 1";
					$consultad = $db->prepare($selNomEstacion);
					$consultad->execute();

					while($filau = $consultad->fetch()){
						$folio_producto = $filau['folio'];
						
					}  
					$In_estaciones = "INSERT into tarjeta_producto (folio_tarjeta, folio_producto) values ('".$folio."', '".$folio_producto."')";
					$db->query($In_estaciones);
				}
		
			$u++;
			}
/*
			$productos = "Delete from tarjeta_producto where folio_tarjeta = '".$folio."'";
			$db->query($productos);
			//get folio prudcto
			$In_productos = "INSERT into tarjeta_producto (folio_tarjeta, folio_producto) values ()";
			
*/			
			if ($db->query($Update) == TRUE) {
				echo "1";
			} else {
				echo "0";
			}

	}
    
	public function editarVehiculoApp($idvehiculo, $placas, $noeconomico, $tarjeta, $activo){ 
		$conexion = new Conexion();
		$db = $conexion->getConexion();
			$Update = "UPDATE vehiculos set placas = '".$placas."', noeconomico = '".$noeconomico."', idtarjeta = '".$tarjeta."', activo = '".$activo."' where idvehiculo = '".$idvehiculo."'";
			
			if ($db->query($Update) == TRUE) {
				echo "1";
			} else {
				echo "0";
			}

	}
	
/*	public function Login($user, $pass){
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
		}*/
/*
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

		public function addAbono($idcliente, $fecha, $importe, $formapago, $bancodestino, $cuentabancaria, $referencia, $concepto){
			$conexion = new Conexion();
			$db = $conexion->getConexion();
			$Query = "INSERT INTO abonos(idcliente, fecha, importe, formapago, bancodestino, cuentabancaria, referencia, concepto, importedisponible) 
				VALUES('{$idcliente}', '{$fecha}', '{$importe}', '{$formapago}', '{$bancodestino}', '{$cuentabancaria}', '{$referencia}', '{$concepto}', '{$importe}')";
			if ($db->query($Query) == TRUE) {
				echo "Guardado correctamente";
			} else {
				echo "Error al guardar".$Query;
			}
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

	*/

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
	


	public function getEstacionesAutorizadas($idtarjeta){
		$clientes = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion();
		$Query = "SELECT t1.*, t2.* FROM tarjeta_estacion t1 inner join estaciones t2 on t1.folio_estacion = t2.idestacion WHERE folio_tarjeta = '".$idtarjeta."'";
		 
		$consultad = $db->prepare($Query);
		$consultad->execute(); 
		$i = 0; 
		while($filau = $consultad->fetch()){
			$clientes["estaciones"][$i] = $filau;
			$i++;
		}
		$Query = "SELECT t1.*, t2.* FROM tarjeta_producto t1 inner join productos t2 on t1.folio_producto = t2.folio WHERE folio_tarjeta = '".$idtarjeta."'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		$i = 0; 
		while($filau = $consultad->fetch()){
			$clientes["productos"][$i] = $filau;
			$i++; 
		}

		$Query = "SELECT t1.*, t2.* FROM tarjetas t1 inner join vehiculos t2 on t1.idplaca = t2.idvehiculo WHERE t1.folio = '".$idtarjeta."'";
	 
		$consultad = $db->prepare($Query);
		$consultad->execute();
		$i = 0; 
		while($filau = $consultad->fetch()){
			$clientes["tarjetas"][$i] = $filau;
			$i++;
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


	public function getEstaciones(){
		$estaciones = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT * FROM estaciones";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$estaciones[] = $filau;
		}
		return $estaciones;
	}
	public function getProducto(){
		$producto = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT * FROM tarjeta_producto";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$producto[] = $filau;
		}
		return $producto;
	}

	public function getFacturas($cte){
		
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t1.timbrado, t1.folio, t1.fechagenerado, t1.importe, t1.restante, t1.factura, t1.cantidad, t2.rfc, t2.periododepago 
		from facturas t1 
		inner join clientes t2 on t1.idcliente = t2.idcliente 
		where t1.idcliente = {$cte} 
		and t1.timbrado = '1'
		order by t1.fechagenerado desc LIMIT 25  ";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		$i = 0;
		while($filau = $consultad->fetch()){
		//	$clientes[] = $filau; 
		$generado = $filau['fechagenerado']; 
		$vencimineto = date('Y-m-d', strtotime($generado. ' + '.$filau['periododepago'].' days')); 
		$hoy = date("Y-m-d");
		$days = (strtotime($hoy) - strtotime($vencimineto)) / (60 * 60 * 24);
		$clientes[$i] = array(
			"folio"=> $filau['folio'], 
			"fechagenerado"=> $filau['fechagenerado'], 
			"importe"=> $filau['importe'], 
			"restante"=> $filau['restante'],
			"factura"=> $filau['factura'], 
			"cantidad"=> $filau['cantidad'], 
			"rfc"=> $filau['rfc'], 
			"periododepago"=> $filau['periododepago'],
			"fechavencimiento"=> $vencimineto,
			"diasvencidos"=> $days
		);
		$i++;
		}
		return $clientes;
	}

	public function getComplementos($cte){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t3.nombrecomplemento as complemento, t1.abono,t1.fechacaptura,t1.folio_p,t2.rfc 
		from pagosaplicaciones t1 
		inner join clientes t2 on t1.idcliente=t2.idcliente 
		LEFT join reg_complementos t3 on t1.folio_p=t3.foliopagoaplicacion 
		where t1.idcliente = {$cte} order by t1.fechacaptura desc LIMIT 25";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		$i = 0;
		while($filau = $consultad->fetch()){
		//	$clientes[] = $filau; 
		$clientes[$i] = array(
			"folio"=> $filau['folio_p'], 
			"fecha"=> $filau['fechacaptura'], 
			"importe"=> $filau['abono'],
			"rfc"=> $filau['rfc'],
			"complemento"=> $filau['complemento']
		);
		$i++;
		}
		return $clientes;
	}

	public function getUsuariosWeb($cte){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t1.*, t2.limitecredito  FROM usuariosweb t1 INNER JOIN clientes t2 ON t1.idclienteweb=t2.idcliente WHERE t1.idclienteweb = '".$cte."'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$clientes[] = $filau;
		}
		return $clientes;
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

	public function getRendimiento($cte){
		$clientes = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t7.nombre as producto, t1.fecha, t1.tarjeta, t2.notarjeta,t2.folio, t3.placas, t3.noeconomico, t1.importe, t1.estacion, t5.nombre, t1.litros, t7.nombre as nombrep, t6.kmanterior, t6.kmnuevo from jkmpg7ol_monedero.servicios t1 inner join jkmpg7ol_monedero.productos t7 on t1.producto = t7.folio inner join jkmpg7ol_monedero.tarjetas t2 on t1.tarjeta = t2.notarjeta inner join jkmpg7ol_monedero.vehiculos t3 on t2.folio = t3.idtarjeta inner join jkmpg7ol_monedero.vehiculos_choferes t4 on t3.idvehiculo = t4.idvehiculo inner join jkmpg7ol_monedero.choferes t5 on t5.idchofer = t4.idchofer inner join jkmpg7ol_monedero.odometro t6 on t6.idservicio = t1.folio  where t3.controlaodometro = 1 and t1.idcliente = {$cte} order by fecha desc LIMIT 40";
		//echo $Query;
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$clientes[] = $filau;
		}
		return $clientes;
	}
	public function fRendimiento($tarjeta, $cte, $fechai, $fechaf){
		$clientes = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t7.nombre as producto, t1.fecha, t1.tarjeta, t2.notarjeta,t2.folio, t3.placas, t3.noeconomico, 
		t1.importe, t1.estacion, t5.nombre, t1.litros, t7.nombre as nombrep, t6.kmanterior, t6.kmnuevo 
		from jkmpg7ol_monedero.servicios t1 
		inner join jkmpg7ol_monedero.productos t7 on t1.producto = t7.folio 
		inner join jkmpg7ol_monedero.tarjetas t2 on t1.tarjeta = t2.notarjeta 
		inner join jkmpg7ol_monedero.vehiculos t3 on t2.folio = t3.idtarjeta 
		inner join jkmpg7ol_monedero.vehiculos_choferes t4 on t3.idvehiculo = t4.idvehiculo 
		inner join jkmpg7ol_monedero.choferes t5 on t5.idchofer = t4.idchofer 
		inner join jkmpg7ol_monedero.odometro t6 on t6.idservicio = t1.folio 
		where t3.controlaodometro = 1 and t1.idcliente = '".$cte."' and DATE(t1.fecha) >= '".$fechai."' and DATE(t1.fecha) <= '".$fechaf."' and t2.folio = '".$tarjeta."'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		//echo $Query;
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$clientes[] = $filau;
		}
		return json_encode($clientes);
	}

	


	public function getChoferes($cte){
		//$clientes = array();
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

	public function getTarjetas($idcliente){ 
		$clientes = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT * FROM tarjetas t1 inner join clientes t2 on t1.idcliente = t2.idcliente  where t1.idcliente = '".$idcliente."'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$clientes[] = $filau;
		}
		return $clientes;
	}

	public function getVehiculos($idcliente){ 
		$clientes = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t1.*,t2.*,t3.notarjeta FROM vehiculos t1 inner join clientes t2 on t1.idcliente = t2.idcliente inner join tarjetas t3 on t1.idtarjeta = t3.folio where t1.idcliente = '".$idcliente."'";

		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$clientes[] = $filau;
		}
		return $clientes;
	}

	public function getCredito($idcliente){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT limiteCredito FROM tipopago WHERE idcliente='".$idcliente."'";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$abonos[] = $filau;
		}
		return $abonos;
	}

	public function getAbonos($idcliente){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT * FROM abonos WHERE IDclienteAbono='".$idcliente."' order by fecha DESC";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$abonos[] = $filau;
		}
		return $abonos;
	}

	public function getTransacciones($idcliente){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t1.*, t2.nombre, t3.nombre as nombrechofer
		FROM servicios t1 
		inner join productos t2 on t2.folio=t1.producto 
		INNER JOIN choferes t3 ON t3.idchofer = t1.idchofer
		WHERE t1.idcliente = {$idcliente} order by fecha DESC";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$abonos[] = $filau;
		}
		if($abonos==null){
			return $Query;
		}
		return $abonos;
	}

	public function getBitacora($idcliente){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT bitacora.*, bitacora_tipo.* FROM bitacora inner join bitacora_tipo on bitacora.tipo = bitacora_tipo.id WHERE idcliente = {$idcliente} order by fecha desc LIMIT 25";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
			$abonos[] = $filau;
		}
		if($abonos==null){
			return $Query;
		}
		return $abonos;
	}

	/**  CLIENTES  **/
	public function C_Login($user, $pass){
		$loginres = array();
		$conexion = new Conexion();
		$db = $conexion->getConexion();

		$Query = "SELECT t1.activo, t1.idclienteweb, t1.usuario, t1.nombreweb, t1.tipo, t2.rzonsocial, t2.tipocliente FROM usuariosweb t1 INNER JOIN clientes t2 ON t1.idclienteweb = t2.idcliente WHERE BINARY usuario='{$user}' AND BINARY contrasena='{$pass}'"; 
 
		session_start();
		$consultad = $db->prepare($Query);
		$consultad->execute();

		while($filau = $consultad->fetch()){
			$usuario = $filau['usuario'];
			$loginres[] = array(
				"res" => '1',
				"idusuarioweb" => $filau['idusuarioweb'],
				"idcliente" => $filau['idclienteweb'],
				"usuario" => $filau['usuario'],
				"nombreweb" => $filau['nombreweb'],
				"tipo" => $filau['tipo'],
				"rzonsocial" => $filau['rzonsocial'],
				"tipocliente" => $filau['tipocliente'],
				"act" => $filau['activo']
			);
        }  

		if(isset($usuario)){ 
			$Query1 = "INSERT INTO bitacora (fecha, tipo, idcliente, descripcion) values(CURRENT_TIME, '10', (Select idclienteweb from usuariosweb  WHERE BINARY usuario='{$user}' AND BINARY contrasena='{$pass}'), 'Se ha iniciado sesión: ')";
			if ($db->query($Query1)==TRUE){return $loginres;}
			
		} else {
			$loginres[] = array(
				"res" => '0',
				
			);
			return $loginres;
		}
	}

	public function UpDateTarjeta($tarjeta, $estado, $estacion, $combustible, $horariodia1, $horariodia2, $horariodia3,
		$horariodia4, $horariodia5, $horariodia6, $horariodia7, $horario1, $horario2, $limiteC,  $limiteP, $tipoLimite){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$e=0;
		$c=0;
		$contador=0;
		$a=0;
		if($tipoLimite  == "1"){
			$Query = "UPDATE tarjetas SET horarioinicial = '{$horario1}', horariofinal = '{$horario2}', 
			lunes = '{$horariodia1}', martes = '{$horariodia2}', miercoles = '{$horariodia3}', jueves = '{$horariodia4}', viernes = '{$horariodia5}',
			sabado = '{$horariodia6}', domingo = '{$horariodia7}', limitelitros = '{$limiteC}', tipoperiodo = '{$limiteP}', tipoLimite = '{$tipoLimite}'
				WHERE folio='{$tarjeta}'";
		}else if($tipoLimite == "2"){
			$Query = "UPDATE tarjetas SET horarioinicial = '{$horario1}', horariofinal = '{$horario2}', 
			lunes = '{$horariodia1}', martes = '{$horariodia2}', miercoles = '{$horariodia3}', jueves = '{$horariodia4}', viernes = '{$horariodia5}',
			sabado = '{$horariodia6}', domingo = '{$horariodia7}', limitedinero = '{$limiteC}', tipoperiodo = '{$limiteP}', tipoLimite = '{$tipoLimite}'
				WHERE folio='{$tarjeta}'";
		}
		//echo $Query; 
		
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

	public function serviciosCte($idcliente, $fechainicial, $fechafinal){
		$servicios = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion();
		$Query = "SELECT t1.*, t2.nombre, t3.nombre as nombrechofer 
		FROM servicios t1 
		inner join productos t2 on t2.folio =t1.producto 
		INNER JOIN choferes t3 ON t3.idchofer = t1.idchofer
		where t1.idcliente = '".$idcliente."' and date(t1.fecha) >= '".$fechainicial."' and date(t1.fecha) <= '".$fechafinal."' order by fecha DESC";
		  
		$consultad = $db->prepare($Query);  
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$serivicios[] = $filau;
		}
		return $serivicios;
	}
	
	public function ComplementosCte($idcliente, $fechainicial, $fechafinal){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "SELECT t3.nombrecomplemento AS complemento, t1.abono,t1.fechacaptura,t1.folio_p,t2.rfc 
		from pagosaplicaciones t1 
		inner join clientes t2 on t1.idcliente=t2.idcliente 
		left join reg_complementos t3 ON t1.folio_p=t3.foliopagoaplicacion 
		where t1.idcliente = {$idcliente} 
		and date(t1.fechacaptura) >= '".$fechainicial."' 
		and date(t1.fechacaptura) <= '".$fechafinal."' order by t1.fechacaptura desc";
		$consultad = $db->prepare($Query);
		$consultad->execute();
		$i = 0;
		while($filau = $consultad->fetch()){
		//	$clientes[] = $filau; 
		$clientes[$i] = array(
			"folio"=> $filau['folio_p'], 
			"fecha"=> $filau['fechacaptura'], 
			"importe"=> $filau['abono'],
			"rfc"=> $filau['rfc'],
			"complemento"=> $filau['complemento']
		);
		$i++;
		}
		return $clientes;
	}
	

	public function FacturasCte($idcliente, $fechainicial, $fechafinal){
		$servicios = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion();
		$Query = "SELECT t1.timbrado, t1.folio, t1.fechagenerado, t1.importe, t1.factura, t1.cantidad, t2.rfc, t2.periododepago from facturas t1 inner join clientes t2 on t1.idcliente = t2.idcliente where t1.idcliente = '".$idcliente."' and date(t1.fechagenerado) >= '".$fechainicial."' and date(t1.fechagenerado) <= '".$fechafinal."' and t1.timbrado = '1' ";
		 //echo $Query;
		$consultad = $db->prepare($Query);  
		$consultad->execute();
		$i = 0;
		while($filau = $consultad->fetch()){
		//	$serivicios[] = $filau; 
		$vencimineto = date('Y-m-d', strtotime($filau['fechagenerado']. ' + '.$filau['periododepago'].' days'));
		$hoy = date("Y-m-d");
		$days = (strtotime($hoy) - strtotime($vencimineto)) / (60 * 60 * 24);
		$serivicios[$i] = array(
			"folio"=> $filau['folio'], 
			"fechagenerado"=> $filau['fechagenerado'], 
			"importe"=> $filau['importe'], 
			"factura"=> $filau['factura'], 
			"cantidad"=> $filau['cantidad'], 
			"rfc"=> $filau['rfc'], 
			"periododepago"=> $filau['periododepago'],
			"fechavencimiento"=> $vencimineto,
			"diasvencidos"=> $days
		);
		$i++;
		}
		return $serivicios;
	}

	public function bitacoraFiltrada($idcliente, $fechainicial, $fechafinal){
		$servicios = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion();
		$Query = "SELECT * FROM bitacora where idcliente = '".$idcliente."'and date(fecha) ='".$fechafinal."'  order by fecha desc ";
		$consultad = $db->prepare($Query);  
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$serivicios[] = $filau;
		}
		//echo $Query ;
		return $serivicios;
	}

	public function AbonosFiltrado($idcliente, $fechainicial, $fechafinal){
		$servicios = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion();
		$Query = "SELECT * FROM abonos where IDclienteAbono = '".$idcliente."' and fecha >= '".$fechainicial."' and fecha <= '".$fechafinal."' order by fecha DESC";
		$consultad = $db->prepare($Query);  
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$serivicios[] = $filau;
		}
		//echo $Query;
		return $serivicios;
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

	public function UpDateVehi($activo, $id){
		$conexion = new Conexion();
		$db = $conexion->getConexion();

			$Query = "UPDATE vehiculos SET activo ='".$activo."' WHERE idvehiculo ='".$id."'";

			if ($db->query($Query) == TRUE) {
				echo "1";
			} else {
				echo "0";
			}

	}
	
	public function UpDateTar($activo, $id){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "UPDATE tarjetas SET activo ='".$activo."' WHERE folio ='".$id."'";
		if ($db->query($Query) == TRUE) {
				echo "1";
			} else {
				echo "0";
			}
	}

	public function UpDateUsuario($activo, $id){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
			$Query = "UPDATE usuariosweb SET activo ='".$activo."' WHERE idusuarioweb ='".$id."'";

			if ($db->query($Query) == TRUE) {
				echo "1";
			} else {
				echo "0";
			}
	}


	public function modVehiculo($placa, $newplaca, $numeco){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "UPDATE vehiculos SET placas = '".$newplaca."', noeconomico='".$numeco."' WHERE idvehiculo = '".$placa."'";
		
		if ($db->query($Query) == TRUE) {
			echo "1";
		} else {
			echo "0";
		}
	}
	public function addUsuarioWeb($idcliente, $nombre, $usuario, $contrasena, $tipo, $administracion, $reportes, $graficas, $seguridad){
		$conexion = new Conexion();
		$db = $conexion->getConexion();
		$Query = "INSERT INTO usuariosweb (idclienteweb, nombreweb, usuario, contrasena, tipo, administracion, reportes, graficas, seguridad,activo) VALUES ('".$idcliente."', '".$nombre."', '".$usuario."','".$contrasena."','".$tipo."','".$administracion."','".$reportes."','".$graficas."','".$seguridad."','1')";	 

		if ($db->query($Query) == TRUE) {
			echo "1";
		} else {
			echo "Error al guardar";
		}
	}  

	
	public function tarjetasCTE($idcliente){
		//AND activo = '1' tarjetas  
		$servicios = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion();
		$date = date('Y-m-d');
		$Query = "SELECT t1.rzonsocial, t1.tipocliente, t1.limitecredito,
		(SELECT  COUNT(folio) FROM tarjetas WHERE idcliente = '".$idcliente."'  ) AS tarjetas, 
		(SELECT  COUNT(importe) FROM servicios WHERE idcliente = '".$idcliente."' and date(fecha) = '".$date."') AS servicios ,
		(SELECT  SUM(importe) FROM servicios WHERE idcliente = '".$idcliente."' and date(fecha) = '".$date."') AS importedia ,
		(SELECT  sum(importedisponibleabono) FROM abonos WHERE idclienteabono = '".$idcliente."' and importedisponibleabono > 0 ) AS saldocontado ,
		(SELECT  sum(restante) FROM facturas WHERE idcliente = '".$idcliente."' and restante > 0 ) AS saldoporpagar 
		FROM clientes t1   
		WHERE t1.idcliente = '".$idcliente."' ";
		$consultad = $db->prepare($Query);  
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$serivicios[] = $filau;
		}
		return $serivicios;
		 
	}


	public function coordenadasEstaciones(){ 
		$servicios = array();
		$dates = array();
		$precios = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion(); 
		$Query = "SELECT * from estaciones ";
		$date = date('Y-m-d');
		$consultad = $db->prepare($Query);  
		$consultad->execute();
		$i = 0;
		$a = 0;
		while($filau = $consultad->fetch()){
			
			reset($precios);
			$serivicios["estaciones"][$i] = $filau;
			
			//$date = date('Y-m-d');
		/*$fecha ='2022-03-09';

			$Query1 = "SELECT fecha from precio_prod where idestacionprod = '".$filau['idestacion']."' order by fecha DESC limit 1";
			$consultad = $db->prepare($Query1);  
			$consultad->execute();
			while($filau1 = $consultad->fetch()){
			$dates[] = $filau1['fecha'];
			}
			print_r($dates);*/
			//$fecha =$dates[0];
			//echo $fecha;

			$Q = "Select t1.* from precio_prod t1
			INNER JOIN estaciones_productos t2 ON t1.idproduc = t2.folioproduto
			where t1.idestacionprod = '".$filau['idestacion']."' 
			and t1.fecha = (SELECT fecha from precio_prod where idestacionprod = '".$filau['idestacion']."' order by fecha DESC limit 1) 
			AND t2.idestacion = '".$filau['idestacion']."'
			GROUP BY t2.folioproduto";
 

			$consultax = $db->prepare($Q);  
					$consultax->execute();
					 
					while($filax = $consultax->fetch()){
						$precios[$a] = $filax;
						$a++;
						//print_r($filax);
					}
		//			$serivicios["estaciones"]["precios"][$i] = $precios;
			$i ++;	
		}
		$serivicios["precios"] = $precios;
		return $serivicios;
		 
	}


	
	public function getTarjetasCteApp($idcliente){
	 
		$servicios = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion(); 
		$Query = "SELECT t1.*, t2.placas as placas from tarjetas t1 INNER JOIN vehiculos t2 ON t1.folio = t2.idtarjeta  where t1.idcliente = '".$idcliente."' ";
		$consultad = $db->prepare($Query);  
		$consultad->execute(); 
		$i = 0;
		while($filau = $consultad->fetch()){
			$serivicios["tarjetas"][$i] = $filau; 
			$i ++;
		}
		return $serivicios;
		 
	}



	public function getVehiculosCteApp($idcliente){
	 
		$servicios = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion(); 
		$Query = "SELECT * from vehiculos where idcliente = '".$idcliente."' ";
		$consultad = $db->prepare($Query);  
		$consultad->execute(); 
		$i = 0;
		while($filau = $consultad->fetch()){
			$serivicios["vehiculos"][$i] = $filau; 
			$i ++;
		}
		return $serivicios;
		 
	}




	public function getServiciosApp($idcliente, $fecha){
	 
		$serivicios = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion(); 
		$Query = "SELECT DATE_FORMAT(t1.fecha, '%m/%d/%Y %h:%i:%s %p') AS fecha, t2.nombre AS estacion, t1.folio from servicios  t1 
		INNER JOIN estaciones t2 ON t1.estacion = t2.idestacion where idcliente = '".$idcliente."' and date(fecha) = '".$fecha."' ";
		$Query;
		$consultad = $db->prepare($Query);  
		$consultad->execute(); 
		$i = 0;
		while($filau = $consultad->fetch()){
			$serivicios["Servicios"][$i] = $filau; 
			$i ++;
		}
		return $serivicios;
		 
	}

	
	public function getInformacionvehiculoApp($idvehiculo){
	 
		$serivicios = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion(); 
		$Query = "SELECT t1.idvehiculo, t1.modelo, t1.ano, t1.placas, t1.noeconomico, t1.tipovehiculo,  
		IFNULL(t1.centrocosto, 0) as centrocosto, t1.controlaodometro, IFNULL(t1.kmmax, 0) as kmmax, IFNULL(t1.variacion, 0) as variacion, t1.odometro, IFNULL(t1.rendimiento, 0) as rendimiento, t1.activo,
		t2.notarjeta FROM vehiculos t1 INNER JOIN tarjetas t2 ON t1.idvehiculo = t2.idplaca WHERE t1.idvehiculo = '".$idvehiculo."'";
		$Query;
		$consultad = $db->prepare($Query);  
		$consultad->execute(); 
		$i = 0;
		while($filau = $consultad->fetch()){
			//$serivicios["vehiculos"][$i] = $filau; 
			$serivicios[] = $filau; 
			$i ++;
		}
		return $serivicios;
		 
	}


	public function getInformacionTarjetaApp($idtarjeta){
	 
		$serivicios = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion(); 
		$Query = "SELECT * from tarjetas where folio = '".$idtarjeta."'";
		$Query;
		$consultad = $db->prepare($Query);  
		$consultad->execute(); 
		$i = 0;
		while($filau = $consultad->fetch()){
			$serivicios["Tarjeta"][$i] = $filau; 
			$i ++;
		}
		return $serivicios;
		 
	}



	public function getProductos(){
	 
		$serivicios = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion(); 
		$Query = "SELECT * from productos where activo = '1'";
		//echo $Query;
		$consultad = $db->prepare($Query);  
		$consultad->execute(); 
		$i = 0;
		while($filau = $consultad->fetch()){
			$serivicios["productos"][$i] = $filau; 
			$i ++;
		}
		return $serivicios;
		 
	}

	public function getProductos1(){
	 
		$serivicios = array();
		$conexion = new Conexion(); 
		$db = $conexion->getConexion(); 
		$Query = "SELECT * from productos where activo = '1'";
		//echo $Query;
		$consultad = $db->prepare($Query);  
		$consultad->execute(); 
		$i = 0;
		while($filau = $consultad->fetch()){
			$serivicios[$i] = $filau; 
			$i ++;
		}
		return $serivicios;
		 
	}
	


  

}
