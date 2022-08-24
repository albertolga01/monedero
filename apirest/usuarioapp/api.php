<?php

class Api{
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
}
