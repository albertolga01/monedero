<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require "../PHPMailer/src/PHPMailer.php";
require "../PHPMailer/src/Exception.php";
require "../PHPMailer/src/SMTP.php";

include "SWSDK.php";
use SWServices\JSonIssuer\JsonEmisionTimbrado as JsonEmisionTimbrado;
require_once '../conexion.php';  

    // CORS
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}

$idFacturas = $_POST['idFacturas'];
$conexion = new Conexion();
$db = $conexion->getConexion();
$rows = array();
$servicios = array();

foreach ($idFacturas as $iterated) {
    $Query = "SELECT t1.folio, t1.idcliente, t1.fechagenerado, t1.importe, t1.restante, t1.cantidad,
                t2.tipocliente, t2.nombre, t2.rfc, t2.direccion, t3.*
                FROM facturas t1 
                INNER JOIN clientes t2
                ON t1.idcliente = t2.idcliente 
                INNER JOIN datosfacturacion t3
                ON t3.foliodatos='1'
                WHERE folio = '{$iterated}'";
    $consulta = $db->prepare($Query);
    $consulta->execute();
    while($filau = $consulta->fetch(PDO::FETCH_OBJ)){
        $rows[] = $filau;
    }
}

foreach ($idFacturas as $iterated) {
    $Query = "SELECT t1.*, t2.folio as foliofacserv, t2.foliofactura, t2.folioservicio, t3.claveestacion
        FROM servicios t1 
        INNER JOIN facturasservicios t2
        ON t1.folio = t2.folioservicio
        INNER JOIN estaciones t3
        ON t1.estacion = t3.idestacion
        WHERE t2.foliofactura ='{$iterated}'";
    $consulta = $db->prepare($Query);
    $consulta->execute();
    while($filau = $consulta->fetch(PDO::FETCH_OBJ)){
        $servicios[] = $filau;
    }
}

$Query1 = "SELECT * FROM productos";
$consulta = $db->prepare($Query1);
    $consulta->execute();
    while($filau = $consulta->fetch(PDO::FETCH_OBJ)){
        $productos[] = $filau;
    }


    


foreach ($rows as $factura) {
    $toSend = formatData($factura, $servicios, $productos);
    $responseTimbrado = swTimbrado($toSend, $factura->rfc, $factura->folio);
}

function formatData($factura, $servicios, $productos){


    $QueryDatosCte = "SELECT domfiscalrec, regfiscalrec, usocfdi FROM clientes where rfc = '".$factura->rfc."'";
$consulta = $db->prepare($QueryDatosCte);
    $consulta->execute();
    while($datoscte = $consulta->fetch(PDO::FETCH_OBJ)){
        $domfiscalrec = $datoscte["domfiscalrec"];
        $regfiscalrec = $datoscte["regfiscalrec"];
        $usocfdi = $datoscte["usocfdi"];
    }


    $totalImpuestos = 0; 
    $ClaveProdServ="0";
    $producto="0";
    $codigo="0";
    $sumaSubTotal = 0;
    $sumaTotal = 0;
    $cfdi["Version"] = "4.0";
    $cfdi["Serie"] = "FC";
    $cfdi["Impuestos"] = null;
    $cfdi["Folio"] = $factura->folio;
    $cfdi["Fecha"] = date('Y-m-d\TH:i:s', strtotime(date('Y-m-d\TH:i:s'). ' - 7 hour'));
    $cfdi["Sello"] = "";
    $cfdi["NoCertificado"] = "";
    $cfdi["Certificado"] = "";
    $cfdi["CondicionesDePago"] = "CondicionesDePago";//"03 Transferencia";
   
    $cfdi["MetodoPago"] = $factura->tipocliente=="0" ? "PUE" : "PPD";
    $cfdi["TipoDeComprobante"] = "I";
    $cfdi["Exportacion"] = "01";        //CAMPO 4.0
    $cfdi["FormaPago"] = $factura->tipocliente=="0" ? "03" : "99";
    $cfdi["LugarExpedicion"] = $factura->codigopostal;

        $cfdi["Emisor"]["Rfc"] = $factura->rfcemisor;        
        $cfdi["Emisor"]["Nombre"] = $factura->nombreemisor;
        $cfdi["Emisor"]["RegimenFiscal"] = $factura->RegimenFiscalemisor;

        $cfdi["Receptor"]["Rfc"] = $factura->rfc;
        $cfdi["Receptor"]["Nombre"] = $factura->nombre;
        $cfdi["Receptor"]["ResidenciaFiscalSpecified"] = false;
        $cfdi["Receptor"]["DomicilioFiscalReceptor"] = $domfiscalrec;       //CAMPO 4.0
        $cfdi["Receptor"]["RegimenFiscalReceptor"] = $regfiscalrec;                     //CAMPO 4.0
        $cfdi["Receptor"]["NumRegIdTrib"] = null;
        $cfdi["Receptor"]["UsoCFDI"] = $usocfdi; //4.0
        $conceptos = array();

        foreach($servicios as $iterated){
            foreach($productos as $prod){
            if($iterated->producto == $prod->folio){
                $ClaveProdServ = $prod->claveprod;
                $producto = $prod->nombre;
                $codigo = $prod->codigo; 

            $unitario = ($iterated->preciounitario) / 1.16;
            $importe = ($iterated->importe) / 1.16;
            }}}

            $concepto["ClaveProdServ"] = $ClaveProdServ;
            $concepto["NoIdentificacion"] = $codigo;
            $concepto["Cantidad"] = 1;
            $concepto["ClaveUnidad"] = "LTR";
            $concepto["Unidad"] = "Litros"; 
            $concepto["Descripcion"] = "SIN COMISIÓN POR ESTRATEGIA COMERCIAL";
           // $concepto["ValorUnitario"] = number_format(($iterated->importe / $iterated->litros), 2);
            $concepto["ValorUnitario"] = number_format(1, 2);
            $concepto["Importe"] = number_format(1, 2);
            $sumaTotal = 1;
            $concepto["Descuento"] = number_format(1, 2); 

             //$concepto["ObjetoImp"] = "02";      //CAMPO 4.0
                
            $trasladitosC["Base"] = number_format($importe, 2);
            $trasladitosC["Importe"] = number_format(($importe*0.16), 2);
            $sumaTotal = number_format(1, 2);
            $totalImpuestos = $totalImpuestos + ($importe ) * 0.16;
            $sumaSubTotal = $sumaSubTotal + $importe;
            $trasladitosC["Impuesto"] = "002"; //iva
            $trasladitosC["TasaOCuota"] = "0.160000";
            $trasladitosC["TipoFactor"] = "Tasa";
            

           // $concepto["Impuestos"]["Traslados"][0] = $trasladitosC; 


            $conceptos[] = $concepto;
            

        $cfdi["Conceptos"] = $conceptos;

        $ImpuestosTotales["Retenciones"] = null;
        $ImpuestosTotales["Traslados"][0]["Impuesto"] = "002";
        $ImpuestosTotales["Traslados"][0]["TipoFactor"] = "Tasa";
        $ImpuestosTotales["Traslados"][0]["TasaOCuota"] = "0.160000";
        $ImpuestosTotales["Traslados"][0]["Importe"] = number_format($totalImpuestos,2);
        $ImpuestosTotales["TotalImpuestosRetenidosSpecified"] = false;
        $ImpuestosTotales["TotalImpuestosTrasladados"] = number_format($totalImpuestos,2);
        $ImpuestosTotales["TotalImpuestosTrasladadosSpecified"] = true;
        //$cfdi["Impuestos"] = $ImpuestosTotales;

        $cfdi["Conceptos"] = $conceptos;

        $complementos = array();
        $complementos["HasElements"] = true;

        $estadodecombustible = array();
        $edoCombutibleBody = array();
        $edoCombutibleBody["Version"] = "1.2";
        $edoCombutibleBody["TipoOperacion"] = "Tarjeta";
        $edoCombutibleBody["NumeroDeCuenta"] = "12355";
        $edoCombutibleBody["SubTotal"] = number_format($sumaSubTotal, 2);//number_format(20.68, 2);
        $edoCombutibleBody["Total"] = number_format($factura->importe, 2);//number_format($sumaTotal ,2);
        $conceptos1 = array();

        foreach($servicios as $iterated){

            foreach($productos as $prod){
                if($iterated->producto == $prod->folio){
                    $tipoCombustible = $prod->tipocombustible;
                    $nomCombustible = $prod->codigo." ".$prod->nombre;
 
                    $unitario1 = ($iterated->preciounitario) * 0.84;
                    $importe1 = ($iterated->importe) / 1.16;
            $concepto1["Identificador"] = $iterated->tarjeta ;//num de tarjeta
            $concepto1["Fecha"] =  date('Y-m-d\TH:i:s', strtotime(date('Y-m-d\TH:i:s'). ' - 12 hour'));
            $concepto1["Rfc"] = $factura->rfc;//RFC del grupito al que pertenece la estacion donde se realizó el servicio
            $concepto1["ClaveEstacion"] = $iterated->claveestacion;
            $concepto1["Cantidad"] = number_format($iterated->litros, 2);
            $concepto1["TipoCombustible"] = $tipoCombustible;
            $concepto1["Unidad"] = "Litro";
            $concepto1["NombreCombustible"] = (string)$nomCombustible;
            $concepto1["FolioOperacion"] = $iterated->folio;
            $concepto1["ValorUnitario"] = number_format($unitario1, 2); //number_format($uni, 2);
            $concepto1["Importe"] = number_format(($iterated->importe)/1.16, 2);
            
           // $concepto1["ObjetoImp"] = "01";     //CAMPO 4.0
            
           // $trasladitos["Base"] = number_format(($iterated->importe / 1.16), 2);
            
            $trasladitos["Impuesto"] = "IVA";//IVA
            $trasladitos["TasaOCuota"] = "0.16";
            $trasladitos["Importe"] = number_format((($iterated->importe)/1.16) * 0.16, 2);
          //  $trasladitos["TipoFactor"] = "Tasa";

            $traslados[0] = $trasladitos;
            
            $concepto1["Traslados"] = $traslados;

            $conceptos1[] = $concepto1;
            }else{
                    $tipoCombustible = null;
                    $nomCombustible = null;
                 }}
            


            
        }
        
        $edoCombutibleBody["Conceptos"] = $conceptos1;

        $estadodecombustible["Ecc12:Estadodecuentacombustible"] = $edoCombutibleBody;
        $complementos["Any"][0] = $estadodecombustible;
        
       // $cfdi["Impuestos"] = null;
        $cfdi["Complemento"][0] = $complementos;
        $cfdi["SubTotal"] = "1.00";//number_format($sumaSubTotal,2); //number_format(($factura->importe * 0.84), 2);//number_format(20.68, 2);//number_format($factura->importe, 2);
        $cfdi["Descuento"] = "1.00";
        $cfdi["Moneda"] = "MXN";
        $cfdi["TipoCambio"] = "1";
        $cfdi["ObjetoImp"] = "01"
        $cfdi["Total"] = "0.00";//number_format($sumaTotal,2); //number_format($factura->importe, 2);
        
        // DATA TO JSON AND RESPONSE FROM LIBRARY
    $json_string = json_encode($cfdi, JSON_PRETTY_PRINT);
    
        
    //echo $json_string;
        $toSend = json_encode($cfdi);
        print_r($toSend);
    return $toSend;
}

function generateQr($qrCode, $rfc, $folio){
    $basePath = "../../../DocsClientes/{$rfc}/";
    $fecha = date('Y-m-d');
    $filename = "LACAJAMZT-F{$folio}-{$fecha}.png";
    $filenamesf = "LACAJAMZT-F{$folio}-{$fecha}";
    
    if(!imagepng(imagecreatefromstring(base64_decode($qrCode)), $basePath.$filename)){
        echo "Error al crear";
    }

    return $filenamesf;
}

function generateXml($xml, $rfc, $folio){
    $fecha = date('Y-m-d');
    $basePath = $basePath = "../../../DocsClientes/{$rfc}/LACAJAMZT-F{$folio}-{$fecha}.xml";
    if(!file_put_contents($basePath, $xml)){
        echo "Error al generar XML";
    }

    return $basePath;
}

function updateBD($fecha, $uuid, $archivo, $folio){
    $fecha = str_replace("T", " ", $fecha);
    $archivo = explode("/", $archivo)[4];

    $conexionUpdate = new Conexion();
    $dbUpdate = $conexionUpdate->getConexion();
    $Query = "UPDATE facturas 
        SET fechafacturacion='{$fecha}', uuidfactura='{$uuid}', factura='{$archivo}', timbrado=1
        WHERE folio = {$folio} 
        ";
    $consulta = $dbUpdate->prepare($Query);
    $consulta->execute();
}
 

function swTimbrado($toSend, $factura, $folio){
    // print_r(json_pretty_print($toSend));
    $params = array( 
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"desarrollo@grupopetromar.com",
        "password"=> "Petromar+SW"
    );

    JsonEmisionTimbrado::Set($params);
    $resultadoJson = JsonEmisionTimbrado::jsonEmisionTimbradoV4($toSend);
    
    if((string)$resultadoJson->status == "success"){
        // var_dump($resultadoJson);
        $nombre = generateQr($resultadoJson->data->qrCode, $factura, $folio);
        $rutaxml = generateXml($resultadoJson->data->cfdi, $factura, $folio);
        updateBD(
            $resultadoJson->data->fechaTimbrado,
            $resultadoJson->data->uuid,
            $rutaxml,
            $folio
        );
        //sendMail();
        $respuesta = array();
        $respuesta[] = array(
            "respuesta" => "1",
            "factura" => $rutaxml,
            "nombre" => $nombre
        );
        echo json_encode($respuesta);
    } else {
        var_dump($resultadoJson);
        $respuesta = array();
        $respuesta[] = array(
            "respuesta" => "0"
        );
        echo json_encode($respuesta);
    }
}


/* 
  $ver4 ='{
            "Version": "4.0",
            "Serie": "SW",
            "Folio": "123456",
            "Fecha": "2022-01-12T00:00:00",
            "Sello": "",
            "NoCertificado": "",
            "Certificado": "",
            "CondicionesDePago": "CondicionesDePago",
            "SubTotal": "10.00",
            "Descuento": "0.00",
            "Moneda": "AMD",
            "TipoCambio": "1",
            "Total": "10.00",
            "TipoDeComprobante": "I",
            "Exportacion": "01",
            "LugarExpedicion": "45610",
            "Emisor": {
            "Rfc": "CPE190207226",
            "Nombre": "ESCUELA KEMPER URGATE SA DE CV",
            "RegimenFiscal": "603"
            },
            "Receptor": {
            "Rfc": "CPE190207226",
            "Nombre": "ESCUELA KEMPER URGATE SA DE CV",
            "DomicilioFiscalReceptor": "26015",
            "RegimenFiscalReceptor": "601",
            "UsoCFDI": "P01"
            },
            "Conceptos": [
            {
                "ClaveProdServ": "50211503",
                "NoIdentificacion": "None",
                "Cantidad": "1.0",
                "ClaveUnidad": "H87",
                "Unidad": "Pieza",
                "Descripcion": "Cigarros",
                "ValorUnitario": "10.00",
                "Importe": "10.00",
                "Descuento": "0.00",
                "ObjetoImp": "02",
                "Impuestos": {
                "Traslados": [
                    {
                    "Base": "1",
                    "Importe": "1",
                    "Impuesto": "002",
                    "TasaOCuota": "0.160000",
                    "TipoFactor": "Tasa"
                    }
                ],
                "Retenciones": [
                    {
                    "Base": "1",
                    "Importe": "1",
                    "Impuesto": "002",
                    "TasaOCuota": "0.040000",
                    "TipoFactor": "Tasa"
                    }
                ]
                }
            }
            ],
            "Impuestos": {
            "TotalImpuestosTrasladados": "1.00",
            "TotalImpuestosRetenidos": "1.00",
            "Retenciones": [
                {
                "Importe": "1.00",
                "Impuesto": "002"
                }
            ],
            "Traslados": [
                {
                "Base": "1.00",
                "Importe": "1.00",
                "Impuesto": "002",
                "TasaOCuota": "0.160000",
                "TipoFactor": "Tasa"
                }
            ]
            }
            }
        ';
      
*/

?>