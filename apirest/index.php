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
if($method == "OPTIONS"){
    die();
}


if($method == "GET"){

    if($_GET["id"] == "getCombustibles"){
        $vector = array();
        $api = new Api();
        $vector = $api->getCombustibles();
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getClientes"){
        $vector = array();
        $api = new Api();
        $vector = $api->getClientes();
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getProd"){
        $vector = array();
        $api = new Api();
        $vector = $api->getProd($_GET["cte"]);
        $json = json_encode($vector);
        echo $json;
    }
    if($_GET["id"] == "getEsta"){
        $vector = array();
        $api = new Api();
        $vector = $api->getEsta($_GET["cte"]);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getEstacionRel"){
        $vector = array();
        $api = new Api();
        $vector = $api->getEstacionRel($_GET["cte"]);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getEstaciones"){
        $vector = array();
        $api = new Api();
        $vector = $api->getEstaciones();
        $json = json_encode($vector);
        echo $json;
    }
    if($_GET["id"] == "getProducto"){
        $vector = array();
        $api = new Api();
        $vector = $api->getProducto();
        $json = json_encode($vector);
        echo $json;
    }


    if($_GET["id"] == "getUsuarios"){
        $vector = array();
        $api = new Api();
        $vector = $api->getUsuarios();
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getFacturas"){
        $vector = array();
        $api = new Api();
        $vector = $api->getFacturas($_GET["cte"]);
        $json = json_encode($vector);
        echo $json;
    }
    if($_GET["id"] == "getComplementos"){
        $vector = array();
        $api = new Api();
        $vector = $api->getComplementos($_GET["cte"]);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getUsuariosWeb"){
        $vector = array();
        $api = new Api();
        $vector = $api->getUsuariosWeb($_GET["idcliente"]);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getRendimiento"){
        $vector = array();
        $api = new Api();
        $vector = $api->getRendimiento($_GET['idcliente']);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getChoferes"){
        $vector = array();
        $api = new Api();
        $vector = $api->getChoferes($_GET['cte']);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getVehiculos"){
        $vector = array();
        $api = new Api();
        $vector = $api->getVehiculos($_GET['idcliente']);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getTarjetas"){
        $vector = array();
        $api = new Api();
        $idcliente = $_GET["idcliente"];
        $vector = $api->getTarjetas($idcliente);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getCredito"){
        $vector = array();
        $api = new Api();
        $vector = $api->getCredito($_GET['idcliente']);
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

    if($_GET["id"] == "getTransacciones"){
        $vector = array();
        $api = new Api();
        $vector = $api->getTransacciones($_GET['idcliente']);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getBitacora"){
        $vector = array();
        $api = new Api();
        $vector = $api->getBitacora($_GET['idcliente']);
        $json = json_encode($vector);
        echo $json;
    }

    
}


if($method == "POST"){



    /*if($_POST["id"] == "login"){
        $json = null;
        $user = $_POST["user"]; 
        $pass = $_POST["pass"];
        $api = new Api();
        $json = $api->Login($user, $pass);
        echo json_encode($json);
    }

    if($_POST["id"] == "odometro"){
        $json = null;
        $idv = $_POST['idv[]']; 
        $api = new Api();
        $json = $api->Odometro($idv);
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

    if($_POST["id"] == "agregarCargo"){
        $json = null;
        $idcliente = $_POST["idcliente"]; 
        $estacion = $_POST["estacion"]; 
        $fecha = $_POST["fecha"];
        $tarjeta = $_POST["tarjeta"];
        $importe = $_POST["importe"];
        $producto = $_POST["producto"];
        $api = new Api();
        $json = $api->addCargo($idcliente, $estacion, $fecha, $tarjeta, $importe, $producto);
        echo $json;
    }*/

    /*  CLIENTES  */

    if($_POST["id"] == "editarTarjetaApp"){
        $json = null; 
        $api = new Api(); 
        $folio = $_POST["idtarjeta"];
        $placas = $_POST["placas"]; 
        $limitedinero = $_POST["limitedinero"]; 
        $limitelitros = $_POST["limitelitros"]; 
        $lunes = $_POST["lunes"]; 
        $martes = $_POST["martes"]; 
        $miercoles = $_POST["miercoles"]; 
        $jueves = $_POST["jueves"]; 
        $viernes = $_POST["viernes"]; 
        $sabado = $_POST["sabado"]; 
        $domingo = $_POST["domingo"]; 
        $horarioinicial = $_POST["horarioinicial"]; 
        $horariofinal = $_POST["horariofinal"]; 

        $estadoestacion = $_POST["estadoestacion"]; 
        $nombreestacion = $_POST["nombreestacion"]; 

        $estadoproducto = $_POST["estadoproducto"]; 
        $nombreproducto = $_POST["nombreproducto"]; 

         
        $json = $api->editarTarjetaApp($folio, $placas, $limitedinero, $limitelitros, $lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo, $horarioinicial, $horariofinal, $estadoestacion, $nombreestacion, $estadoproducto, $nombreproducto);
        echo $json;  
    }

    if($_POST["id"] == "editarVehiculoApp"){
        $json = null; 
        $api = new Api(); 
        $idvehiculo = $_POST["idvehiculo"];
        $placas = $_POST["placas"];
        $noeconomico = $_POST["noeconomico"];
        $tarjeta = $_POST["tarjeta"];
        $activo = $_POST["activo"]; 
        $json = $api->editarVehiculoApp($idvehiculo, $placas, $noeconomico, $tarjeta, $activo);
        echo $json;  
    }

    if($_POST["id"] == "getProductos"){
        $json = null; 
        $api = new Api();  
        $json = $api->getProductos();
        echo json_encode($json); /**/ 
    }

    if($_POST["id"] == "getEstacionesAutorizadas"){
        $json = null; 
        $api = new Api(); 
        $idtarjeta = $_POST["idtarjeta"];
        $json = $api->getEstacionesAutorizadas($idtarjeta);
        echo json_encode($json); /**/ 
    }

    if($_POST["id"] == "getInformacionTarjetaApp"){
        $json = null; 
        $api = new Api(); 
        $idtarjeta = $_POST["idtarjeta"];
        $json = $api->getInformacionTarjetaApp($idtarjeta);
        echo json_encode($json); /**/ 
    }


    if($_POST["id"] == "getInformacionvehiculoApp"){
        $json = null; 
        $api = new Api(); 
        $idvehiculo = $_POST["idvehiculo"];
        $json = $api->getInformacionvehiculoApp($idvehiculo);
        echo json_encode($json); /**/ 
    }


    if($_POST["id"] == "getServiciosApp"){
        $json = null; 
        $api = new Api(); 
        $idcliente = $_POST["idcliente"];
        $fecha = $_POST["fecha"];
        $json = $api->getServiciosApp($idcliente, $fecha);
        echo json_encode($json); /**/ 
    }


    if($_POST["id"] == "getVehiculosCteApp"){
        $json = null; 
        $api = new Api(); 
        $idcliente = $_POST["idcliente"];
        $json = $api->getVehiculosCteApp($idcliente);
        echo json_encode($json); /**/ 
    }


    if($_POST["id"] == "getTarjetasCteApp"){
        $json = null; 
        $api = new Api(); 
        $idcliente = $_POST["idcliente"];
        $json = $api->getTarjetasCteApp($idcliente);
        echo json_encode($json); /**/ 
    }

    if($_POST["id"] == "coordenadasEstaciones"){
        $json = null; 
        $api = new Api();  
        $json = $api->coordenadasEstaciones();
        echo json_encode($json); /**/ 
    }


    if($_POST["id"] == "tarjetasCTE"){
        $json = null;
        $idcliente = $_POST["idcliente"];   
        $api = new Api(); 
        $json = $api->tarjetasCTE($idcliente);
        echo json_encode($json); /**/
      //echo $json;
    }

    if($_POST["id"] == "C_login"){
        $json = null;
        $user = $_POST["user"]; 
        $pass = $_POST["pass"];
        $api = new Api();
        $json = $api->C_Login($user, $pass);
        echo json_encode($json);
    }

    if($_POST["id"] == "UpDateTarjeta"){
        $json = null;
        $tarjeta = $_POST["tarjeta"]; 
        $estado = $_POST["estado"];
        $estacion = $_POST["estacion"];
        $combustible = $_POST["combustible"];
        $horariodia2 = $_POST["horariodia2"];
        $horariodia3 = $_POST["horariodia3"];
        $horariodia4 = $_POST["horariodia4"];
        $horariodia5 = $_POST["horariodia5"];
        $horariodia6 = $_POST["horariodia6"];
        $horariodia7 = $_POST["horariodia7"];
        $horario1 = $_POST["horario1"];
        $horario2 = $_POST["horario2"];
        $limiteC = $_POST["limiteC"];
        //$limiteD = $_POST["limiteD"];
        $limiteP = $_POST["limiteP"];
        $api = new Api();
        $json = $api->UpDateTarjeta($tarjeta, $estado, $estacion, $combustible, $horariodia1, $horariodia2, $horariodia3,
        $horariodia4, $horariodia5, $horariodia6, $horariodia7, $horario1, $horario2, $limiteC, $limiteP);
    
        echo $json;
        
    
        }

        if($_POST["id"] == "obtenerFacturas"){
            $json = null;
            $idcliente = $_POST["idcliente"]; 
            $fechainicial = $_POST["fechainicial"]; 
            $fechafinal = $_POST["fechafinal"];
            $api = new Api();
            $json = $api->FacturasCte($idcliente, $fechainicial, $fechafinal);
            echo json_encode($json);
        }

        if($_POST["id"] == "obtenercomplementos"){
            $json = null;
            $idcliente = $_POST["idcliente"]; 
            $fechainicial = $_POST["fechainicial"]; 
            $fechafinal = $_POST["fechafinal"];
            $api = new Api();
            $json = $api->ComplementosCte($idcliente, $fechainicial, $fechafinal);
            echo json_encode($json);
        }

        if($_POST["id"] == "obtenerServicios"){
            $json = null;
            $idcliente = $_POST["idcliente"]; 
            $fechainicial = $_POST["fechainicial"]; 
            $fechafinal = $_POST["fechafinal"];
            $api = new Api();
            $json = $api->serviciosCte($idcliente, $fechainicial, $fechafinal);
            echo json_encode($json);
        }

        if($_POST["id"] == "bitacoraFiltrada"){
            $json = null;
            $idcliente = $_POST["idcliente"]; 
            $fechainicial = $_POST["fechainicial"]; 
            $fechafinal = $_POST["fechafinal"];
            $api = new Api();
            $json = $api->bitacoraFiltrada($idcliente, $fechainicial, $fechafinal);
            echo json_encode($json);
        }   

        if($_POST["id"] == "AbonosFiltrado"){
            $json = null;
            $idcliente = $_POST["idcliente"]; 
            $fechainicial = $_POST["fechainicial"]; 
            $fechafinal = $_POST["fechafinal"];
            $api = new Api();
            $json = $api->AbonosFiltrado($idcliente, $fechainicial, $fechafinal);
            echo json_encode($json);
        }
       
        if($_POST["id"] == "actualizarChofer"){
            $json = null;
            $activo = $_POST["activo"];
            $valor = $_POST["iduser"];
            $api = new Api();
            $json = $api->UpDateChofer($activo, $valor);
            echo $json;
        }   

        if($_POST["id"] == "actualizarUsuario"){
            $json = null;
            $activo = $_POST["activo"];
            $valor = $_POST["iduser"];
            $api = new Api();
            $json = $api->UpDateUsuario($activo, $valor);
            echo $json;
        }

        if($_POST["id"] == "actualizarVehi"){
            $json = null;
            $activo = $_POST["activo"];
            $valor = $_POST["iduser"];
            $api = new Api();
            $json = $api->UpDateVehi($activo, $valor);
            echo $json;
        }
        if($_POST["id"] == "actualizarTar"){
            $json = null;
            $activo = $_POST["activo"];
            $id = $_POST["iduser"];
            $api = new Api();
            $json = $api->UpDateTar($activo, $id);
            echo $json;
        }

       if($_POST["id"] == "modvehiculo"){
            $json = null;
            $placa = $_POST["placa"];
            $newplaca = $_POST["newplaca"];
            $numeco = $_POST["numeco"];
            $api = new Api();
            $json = $api->modVehiculo($placa, $newplaca, $numeco);
            echo $json;
        }
       if($_POST["id"] == "fRendimiento"){
            $json = null;
            $tarjeta = $_POST["tar"];
            $cte = $_POST["cte"];
            $fechai = $_POST["fechai"];
            $fechaf = $_POST["fechaf"];
            $api = new Api();
            $json = $api->fRendimiento($tarjeta, $cte, $fechai, $fechaf);
            echo $json;

        }
        
        
}


if($method=="DELETE"){

}

?>