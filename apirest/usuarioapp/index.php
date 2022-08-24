<?php 

require_once('conexion.php'); 

require_once('api.php');

require_once('cors.php');

$method = $_SERVER['REQUEST_METHOD'];

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}

if($method == "GET"){
    if($_GET["id"] == "getClientes"){
        $vector = array();
        $api = new Api();
        $vector = $api->getClientes();
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getCliente"){
        echo 'alivianesepadrino';    
    }

    if($_GET["id"] == "getUsuarios"){
        $vector = array();
        $api = new Api();
        $vector = $api->getUsuarios();
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getUsuariosWeb"){
        $vector = array();
        $api = new Api();
        $vector = $api->getUsuariosWeb();
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getChoferes"){
        $vector = array();
        $api = new Api();
        $vector = $api->getChoferes();
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getVehiculos"){
        $vector = array();
        $api = new Api();
        $vector = $api->getVehiculos();
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getTarjetas"){
        $vector = array();
        $api = new Api();
        $vector = $api->getTarjetas();
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getAbonos"){
        $vector = array();
        $api = new Api();
        $vector = $api->getAbonos($_GET['cte']);
        $json = json_encode($vector);
        echo $json;
    }
}


if($method == "POST"){
    if($_POST["id"] == "login"){
        $json = null;
        $user = $_POST["user"]; 
        $pass = $_POST["pass"];
        $api = new Api();
        $json = $api->Login($user, $pass);
        echo json_encode($json);
    }

    if($_POST["id"] == "agregarCliente"){
        $json = null;
        $nombre = $_POST["nombre"]; 
        $rfc = $_POST["rfc"];
        $contacto = $_POST["contacto"];
        $telefono = $_POST["telefono"];
        $tipo = $_POST["tipo"];
        $metodopago = $_POST["metodopago"];
        $periodopago = $_POST["periodopago"];
        $limitecredito = $_POST["limitecredito"];
        $api = new Api();
        $json = $api->addCliente($nombre, $rfc, $contacto, $telefono, $tipo, $metodopago, $periodopago, $limitecredito);
        echo $json;
    }

    if($_POST["id"] == "agregarUsuarioWeb"){
        $json = null;
        $idcliente = $_POST["idcliente"]; 
        $nombre = $_POST["nombre"]; 
        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];
        $tipo = $_POST["tipo"];
        $administracion = $_POST["administracion"];
        $reportes = $_POST["reportes"];
        $graficas = $_POST["graficas"];
        $seguridad = $_POST["seguridad"];
        $api = new Api();
        $json = $api->addUsuarioWeb($idcliente, $nombre, $usuario, $contrasena, $tipo, $administracion, $reportes, $graficas, $seguridad);
        echo $json;
    }

    if($_POST["id"] == "agregarUsuario"){
        $json = null;
        $nombre = $_POST["nombre"]; 
        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];
        $tipo = $_POST["tipo"];
        $idcliente = $_POST["idcliente"];
        //$sistema = $_POST["sistema"];
        $api = new Api();
        $json = $api->addUsuario($nombre, $usuario, $contrasena, $tipo, $idcliente);
        echo $json;
    }

    if($_POST["id"] == "agregarChofer"){
        $json = null;
        $nombre = $_POST["nombre"]; 
        $idCliente = $_POST["idCliente"];
        $api = new Api();
        $json = $api->addChofer($nombre, $idCliente);
        echo $json;
    }

    if($_POST["id"] == "agregarVehiculo"){
        $json = null;
        $idCliente = $_POST["idCliente"]; 
        $modelo = $_POST["modelo"]; 
        $ano = $_POST["ano"]; 
        $placas = $_POST["placas"]; 
        $noEconomico = $_POST["noEconomico"]; 
        $tipoVehiculo = $_POST["tipoVehiculo"]; 
        $idTarjeta = $_POST["idTarjeta"]; 
        $centroCosto = $_POST["centroCosto"]; 
        $controlaOdometro = $_POST["controlaOdometro"]; 
        $kmMax = $_POST["kmMax"]; 
        $variacion = $_POST["variacion"]; 
        $odometro = $_POST["odometro"]; 
        $rendimiento = $_POST["rendimiento"]; 
        $api = new Api();
        $json = $api->addVehiculo($idCliente, $modelo, $ano, $placas, $noEconomico, $tipoVehiculo, $idTarjeta, $centroCosto, $controlaOdometro, $kmMax, $variacion, $odometro, $rendimiento);
        echo $json;
    }

    if($_POST["id"] == "AgregarTarjetas"){
        $json = null;
        $idcliente = $_POST["idcliente"]; 
        $notarjeta = $_POST["notarjeta"]; 
        $idplaca = $_POST["idplaca"]; 
        $activo = $_POST["activo"]; 
        $tipo = $_POST["tipo"]; 
        $magna = $_POST["magna"];
        $premium = $_POST["premium"];
        $diesel  = $_POST["diesel"];
        $horarioinicial = $_POST["horarioinicial"];
        $horariofinal = $_POST["horariofinal"];
        $lunes = $_POST["lunes"];
        $martes = $_POST["martes"];
        $miercoles = $_POST["miercoles"];
        $jueves = $_POST["jueves"];
        $viernes = $_POST["viernes"];
        $sabado = $_POST["sabado"];
        $domingo = $_POST["domingo"];
        $santafe = $_POST["santafe"];
        $ley = $_POST["ley"];
        $insurgentes = $_POST["insurgentes"];
        $munich = $_POST["munich"];
        $libramiento = $_POST["libramiento"];
        $lopez = $_POST["lopez"];
        $rio = $_POST["rio"];
        $limitedinero = $_POST["limitedinero"];
        $limitelitros = $_POST["limitelitros"];
        $tipoperiodo = $_POST["tipoperiodo"];
        $api = new Api();
        $json = $api->addTarjeta($idcliente, $notarjeta, $idplaca, $activo, $tipo, $magna, $premium, $diesel, $horarioinicial, $horariofinal, $lunes, $martes,$miercoles, $jueves,
            $viernes, $sabado, $domingo, $santafe, $ley, $insurgentes, $munich, $libramiento, $lopez, $rio, $limitedinero, $limitelitros, $tipoperiodo);
        echo $json;
    }

    if($_POST["id"] == "agregarAbono"){
        $json = null;
        $idcliente = $_POST["idcliente"]; 
        $fecha = $_POST["fecha"];
        $importe = $_POST["importe"];
        $formapago = $_POST["formapago"];
        $bancodestino = $_POST["bancodestino"];
        $cuentabancaria = $_POST["cuentabancaria"];
        $referencia = $_POST["referencia"];
        $concepto = $_POST["concepto"];
        $api = new Api();
        $json = $api->addAbono($idcliente, $fecha, $importe, $formapago, $bancodestino, $cuentabancaria, $referencia, $concepto);
        echo $json;
    }
}

if($method=="DELETE"){

}

?>