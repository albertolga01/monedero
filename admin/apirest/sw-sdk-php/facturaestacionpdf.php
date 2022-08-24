<?php

require_once '../conexion.php';
require_once 'crXml.php';
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
} 

$conexion = new Conexion();
$db = $conexion->getConexion();

$strtimbrado = $_POST['factEstacion'];
$nombre = $_POST['nombrefactEstacion'];
//echo $strtimbrado;
//echo $nombre;
$contacto="";
if (file_exists($strtimbrado)){
    $xml = simplexml_load_file($strtimbrado);
    $pngQR = substr($strtimbrado, 0,-4).".png";
        //CADENAS PARA ENTRAR A LOS NODOS (SE OCUPAN LOS NAMESPACE QUE ESTAN EN LOS ATRIBUTOS 'xmlns'  /  [ns = NameSpace])
    $ns_cfdi = 'http://www.sat.gob.mx/cfd/3';
    $ns_ecc12 = 'http://www.sat.gob.mx/EstadoDeCuentaCombustible12';
    $ns_tfd = 'http://www.sat.gob.mx/TimbreFiscalDigital';


    $Comprobante = array();
        //VALORES DE ATRIBUTOS EN {Comprobante}
    foreach ($xml->attributes() as $index => $item) {
        $Comprobante[$index] = (string)$item;
    }


        //ARRAY CON VALORES DE ATRIBUTOS DE {Emisor}
    $Emisor = array();
    foreach ($xml->children($ns_cfdi)->Emisor->attributes() as $key => $item){
        $Emisor[$key] = (string)$item;
    }
    $Comprobante['Emisor'] = $Emisor;


        //ARRAY CON VALORES DE ATRIBUTOS DE {Receptor}
    $Receptor = array();
    foreach ($xml->children($ns_cfdi)->Receptor->attributes() as $key => $item){
        $Receptor[$key] = (string)$item;
    }
    $Comprobante['Receptor'] = $Receptor;


        //ARRAY CON VALORES DE {Concepto}
    $Concepto = array();
    foreach ($xml->children($ns_cfdi)->Conceptos->Concepto as $item){
        $Conceptos = array();
        foreach ($item->attributes() as $key => $value) {
            $Conceptos[$key] = (string)$value;
        }
        $Concepto[] = $Conceptos;
    }
    $Comprobante['Concepto'] = $Concepto;


        //ARRAY CON VALORES DE {Complemento}
    $Complemento = array();
    $EstadoDeCuentaCombustible = array();
    foreach ($xml->children($ns_cfdi)->Complemento->children($ns_ecc12)->attributes() as $key => $value) {
        $EstadoDeCuentaCombustible[$key] = (string)$value;
    }


        //ARRAY CON VALORES DE {ecc12:Conceptos}
   /* $Conceptos_combustible = array();
    foreach ($xml->children($ns_cfdi)->Complemento->children($ns_ecc12)->EstadoDeCuentaCombustible->children($ns_ecc12)->Conceptos->children($ns_ecc12) as $key => $item){
            //ATRIBUTOS DE CADA {ecc12:Concepto}
        $Concepto_combustible = array();
        foreach ($item->attributes() as $key => $value) {
            $Concepto_combustible[$key] = (string)$value;
        }

            //NODOS DE {ecc12:Traslados}
        $Traslados = array();
        $Traslado = array();
        foreach ($item->children($ns_ecc12)->Traslados->children($ns_ecc12)->Traslado->attributes() as $key => $value) {
            $Traslado[$key] = (string)$value;
        }
        $Traslados['Traslado'] = $Traslado;
        $Concepto_combustible['Traslados'] = $Traslados;

        $Conceptos_combustible[] = $Concepto_combustible;
        $EstadoDeCuentaCombustible['Conceptos'] = $Conceptos_combustible;
    }
    $Complemento['EstadoDeCuentaCombustible'] = $EstadoDeCuentaCombustible;
    $Comprobante['Complemento'] = $Complemento;*/


        //ARRAY CON VALORES DE {tfd:timbrefiscaldigital}
    $timbreFiscalDigital = array();
    foreach ($xml->children($ns_cfdi)->Complemento->children($ns_tfd)->TimbreFiscalDigital->attributes() as $key => $item){
        $timbreFiscalDigital[$key] = (string)$item;
    }
    $Comprobante['TimbreFiscalDigital'] = $timbreFiscalDigital;


    function formatDate($toFormat){
        $data = explode("T", $toFormat)[0];
        $data = explode("-", $data);
        $formattedDate = $data[2]."/".$data[1]."/".$data[0];
        return $formattedDate;
    }

   /* $tarjetasDB = array();
    foreach ($Comprobante['Complemento']['EstadoDeCuentaCombustible']['Conceptos'] as $iterated) {
        $folio = $iterated["FolioOperacion"];
        $Query = "SELECT t1.folio, t3.placas, t3.noeconomico, t2.notarjeta
                FROM servicios t1
                INNER JOIN tarjetas t2
                ON t1.tarjeta = t2.folio
                INNER JOIN vehiculos t3
                ON t2.folio = t3.idtarjeta
                WHERE t1.folio = '{$folio}'
            ";
        $consulta = $db->prepare($Query);
        $consulta->execute();
        
        while($filau = $consulta->fetch(PDO::FETCH_OBJ)){
            $tarjetasDB[] = $filau;
        }
    }*/

    /*$estaciones = array();
    $alreadyQueried = array();
    foreach($Comprobante['Complemento']['EstadoDeCuentaCombustible']['Conceptos'] as $iterated){
        $buscando = array_search($iterated['ClaveEstacion'], $alreadyQueried);  //
        if(FALSE !== $buscando){                                                //  BUSCA EN $alreadyQueried SI YA SE TIENE ESTA ESTACION
            continue;                                                           //
        }                                                                       //
        $folio = $iterated['FolioOperacion'];
        $Query = "SELECT t1.folio, t3.codigo, t3.claveestacion, t4.rfc, t4.rzonsocial
                FROM servicios t1
                INNER JOIN estaciones t3 on 
                t1.estacion = t3.idestacion
                INNER JOIN grupo t4 on 
                t3.idgrupoest = t4.idgrupo
                WHERE t1.folio = '{$folio}'
                GROUP BY t3.idestacion
                ";
        $consulta = $db->prepare($Query);
        $consulta->execute();

        while($filau = $consulta->fetch(PDO::FETCH_OBJ)){
            $alreadyQueried[] = $iterated['ClaveEstacion'];
            $estaciones[] = array(
                "folio" => $filau->folio,
                "codigo" => $filau->codigo,
                "claveestacion" => $filau->claveestacion,
                "rfc" => $filau->rfc,
                "rzonsocial" => $filau->rzonsocial
            );
        }
    }*/


    /*$saldo = array();
    $cteRFC = $Comprobante['Receptor']['Rfc'];
    $Query = "SELECT t1.idcliente,t1.contacto, SUM(t2.importedisponibleabono) AS saldodisponible
            FROM clientes t1
            INNER JOIN abonos t2
            ON t1.idcliente = t2.IDclienteAbono
            WHERE rfc = '{$cteRFC}'";
    $consulta = $db->prepare($Query);
    $consulta->execute();
    while($filau = $consulta->fetch(PDO::FETCH_OBJ)){
        $saldo["saldodisponible"] = $filau->saldodisponible;
        $contacto = $filau->contacto;
    }

    $lts_magna = array("cantidad" => 0, "importe" => 0);
    $lts_premium = array("cantidad" => 0, "importe" => 0);
    $lts_diesel = array("cantidad" => 0, "importe" => 0);
    foreach($Comprobante['Complemento']['EstadoDeCuentaCombustible']['Conceptos'] as $iterated){
        switch($iterated["TipoCombustible"]){
            case 1:
                $lts_magna['cantidad'] += $iterated["Cantidad"];
                $lts_magna['importe'] += $iterated["Importe"];
                break;
            case 2:
                $lts_premium['cantidad'] += $iterated["Cantidad"];
                $lts_premium['importe'] += $iterated["Importe"];
                break;
            case 3:
                $lts_diesel['cantidad'] += $iterated["Cantidad"];
                $lts_diesel['importe'] += $iterated["Importe"];
                break;
        }
    }*/

    $numberFormatter = new NumberFormatter('es_MX', NumberFormatter::SPELLOUT);
    $TotalLetra = $numberFormatter->format(substr($Comprobante['Total'], 0, -3));
    $TotalLetra = strtoupper($TotalLetra) ." PESOS ". substr($Comprobante['Total'], -2). "/100 M.N.";

    $folio_doc = $Comprobante["Folio"];
    $fecha_doc = $Comprobante["Fecha"];
    $importe_doc = $Comprobante["Complemento"]["EstadoDeCuentaCombustible"]["Total"];
    // echo "<pre>";
    // print_r($Comprobante);
    // echo "</pre>";
}
$nombreC=$Comprobante["Receptor"]["Nombre"];
echo'
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../../scripts/pdfExportMethods.js"></script>

<div id="styledTable"> 
    <div class=WordSection1>
        <style>
            body{
                font-family: sans-serif;
            }

            #wrapper{
                width: 755;
                display: grid;
                gap: 4px;
            }

            #header1{
                grid-row: 1;
                grid-column: 1;
            }
            
            #header2{
                grid-row: 1;
                grid-column: 2;
                font-size: 12px;
                text-align: center;
            }
            
            #header3{
                grid-row: 1;
                grid-column: 3;
                font-size: 14px;
            }
            
            #header4{
                grid-row: 2;
                grid-column: 2;
                font-size: 14px;
                text-align: center;
            }

            #header5{
                grid-row: 2;
                grid-column: 3;
                font-size: 12px;
            }

            #content1{
                grid-row: 3;
                grid-column: 1/4;
            }

            #content2{
                grid-row: 4;
                grid-column: 1/4;
            }

            #footer{
                grid-row: 5;
                grid-column: 1/4;
                word-break: break-all;
                display: flex;
                font-size: 12px;
            }

            table{
                border-collapse: collapse;
            }

            #header1 img{
                height: 100px;
                width: 100px;
            }

            #header3 td{
                font-size: 14px;
                left: 0px;
            }

            #content1 td{
                text-align: center;
            }

            #representacioncfdi{
                font-size: 10px;
            }

            #header5 td{
                font-size: 14px;
            }

            #qrdetails-tbl{
                font-size: 12px;
            }

            #totales-tbl{
                height: fit-content;
                font-size: 14px;
            }

            #totales-tbl .fixed-td{
                font-size: 12px;
                text-align: center;
                padding: 2px 6px;
                background-color: #d9d9d9;
                color: black;
            }

            .detailstable{
                width: 100%;
            }

            .detailstable th{
                border: 1px solid black;
                font-size: 10px;
                text-align: center;
                background-color: #d9d9d9;
                color: black;
                padding: 2 4px;
            }

            .separator-td label{
                font-size: 10px;
                margin: 0;
            }

            .separator-td{
                background-color: #ddd;
                /*display: flex;
                flex-direction: row;
                justify-content: space-between;*/
            }

            .detailtbl-productos td{
                border: 1px solid black;
            }

            .detailstbl-totales td{
                border: none;
            }

            #detailstbl-productostotales .fixed-td{
                font-size: 12px;
                background-color: #d9d9d9;
                color:black;
                text-align: center;
                padding: 2px 6px;
                border: 1px solid black;
            }

            #saldos-tbl .fixed-td{
                font-size: 12px;
                text-align: right;
                padding: 2px 6px;
                background-color: #d9d9d9;
                color:black;
            }

            #factdetails-tbl .fixed-td{
                font-size: 12px;
                text-align: right;
                padding: 2px 6px;
                background-color: #d9d9d9;
                color: black;
                width: 110px;
            }
            #factdetails-tbl {
                font-size: 12px;
                padding: 2px 6px;
                color: black;
                width: 100%;
            }

            .qrdetails{
                font-size: 12px;
                text-align: center;
                padding: 2px 6px;
                background-color: #d9d9d9;
                color: black;
            }

            #footer-qr{
                display: flex;
                align-items: center;
            }

            #cliente-tbl{
                font-size: 12px;
                width: 100%;
            }

            .value-td{
                text-align: right;
            }
        </style>
        
        <div id="wrapper">
            <div id="header1">
                <img src="../../imagenes/LaCaja-logo.png" alt="La Caja" /> 
            </div>
            
            <div id="header2" style="width: 330px;">
                <label><center>'.$Comprobante["Emisor"]["Nombre"].'</center></label>
                        <label><center>RFC:'.$Comprobante["Emisor"]["Rfc"].'</center></label>
                        <label>Tipo de comprobante: '.$Comprobante["TipoDeComprobante"].'</label>
                        <label>Lugar de Expedición: 82110</label>
                        <label>Régimen Fiscal: 601 - General de Ley Personas Morales</label>
            </div>
            
            <div id="header3">
                <table id="factdetails-tbl">
                    <tr>
                        <td class="fixed-td">FORMA DE PAGO</td>
                        <td>'.$Comprobante["FormaPago"].'</td>
                    </tr>
                    <tr>
                        <td class="fixed-td">METODO DE PAGO</td>
                        <td>'.$Comprobante["MetodoPago"].'</td>
                    </tr>
                    <tr>
                        <td class="fixed-td">MONEDA</td>
                        <td>'.$Comprobante["Moneda"].'</td>
                    </tr>
                    <tr>
                        <td class="fixed-td">FOLIO</td>
                        <td>'.$Comprobante["Folio"].'</td>
                    </tr>
                    <tr>
                        <td class="fixed-td">FECHA</td>
                        <td>'.formatDate($Comprobante["Fecha"]).'</td>
                    </tr>
                </table>
            </div>
            
            <div id="header4">
                <table id="cliente-tbl">
                    <tr>
                        <th colspan=2>Datos del cliente</th>
                    </tr>
                    <tr>
                        <td>Cliente:</td>
                        <td>'.$Comprobante["Receptor"]["Nombre"] .'</td>
                    </tr>
                    <tr>
                        <td>RFC:</td>
                        <td>'.$Comprobante["Receptor"]["Rfc"].'</td>
                    </tr>
                    <tr>
                        <td>Uso CFDI:</td>
                        <td>'.$Comprobante["Receptor"]["UsoCFDI"].' - Adquisición de mercancias</td>
                    </tr>
                    <tr>
                        <td>Domicilio:</td>
                        <td></td>
                    </tr>
                </table>
            </div>

            <div id="header5">
                <table id="saldos-tbl">
                    <tr>
                        <td class="fixed-td">PERIODO</td>
                        <td id="h5-periodo"></td>
                    </tr>
                    <tr>
                        <td class="fixed-td">SALDO ANTERIOR</td>
                        <td id="h5-saldoanterior"></td>
                    </tr>
                    <tr>
                        <td class="fixed-td">PAGOS</td>
                        <td id="h5-pagos"></td>
                    </tr>
                    <tr>
                        <td class="fixed-td">CARGAS</td>
                        <td id="h5-cargas">'.$Comprobante["Total"].'</td>
                    </tr>
                    <tr>
                        <td class="fixed-td">SALDO AL CORTE</td>
                        <td id="h5-saldocorte">'.$saldo["saldodisponible"].'</td>
                    </tr>
                    <tr>
                        <td class="fixed-td">SALDO DISPONIBLE</td>
                        <td id="h5-saldodisponible">'.$saldo["saldodisponible"].'</td>
                    </tr>
                </table>
            </div>

            <div id="content1">
                <table id="ignore" class="detailstable" class="color_blanco">
                    <tr style="background-color: #d9d9d9;">
                        <th class="dt1">CANTIDAD</th>
                        <th class="dt1">UNIDAD</th>
                        <th class="dt1">DESCRIPCIÓN</th>
                        <th class="dt1">VALOR UNITARIO</th>
                        <th class="dt1">IMPORTE</th>
                    </tr>
                    
                    <tr class="detailtbl-productos">
                        <td class="dt2"><label>1</label></td>
                        <td class="dt2"><label>E48 - Unidad de servicio</label></td>
                        <td class="dt2"><label>SIN COMISIÓN POR ESTRATEGIA COMERCIAL</label></td>
                        <td class="dt2"><label>1.00</label></td>
                        <td class="dt2"><label>1.00</label></td>
                        
                    </tr>
                ';
                                
                            

                    echo'
                </table>
            </div>

            <div id="content2">
            <div style="display: flex; flex-direction: row; margin-left: auto; justify-content: space-between;">
            
                <div style="display: flex; flex-direction: column;">
                    <label style="color: #0082b7;"><b>Importe con letra:</b></label>
                    <label style="display: inline-block; width: 520px;">'.$TotalLetra.'</label>
                </div>
                <table id="totales-tbl">
                        <tr>
                            <td class="fixed-td">SUBTOTAL</td>
                            <td style="width: 55px; text-align: center;">$1.00</td>
                        </tr>
                        
                            <tr>
                            <td class="fixed-td">IMPUESTOS</td>
                            <td style="width: 55px; text-align: center;">$0.00</td>
                            </tr>
                        
                        <tr>
                            
                            <td class="fixed-td">DESCUENTO</td>
                                <td style="width: 55px; text-align: center;">$1.00</td>
                        </tr>
                        <!--
                            <tr>
                                <td>I.V.A. Retención Flete</td>
                                <td>PENDIENTE</td>
                            </tr>
                        -->
                        <tr>
                            <td class="fixed-td">TOTAL</td>
                            <td style="width: 55px; text-align: center;">$'.number_format($Comprobante["Total"], 2, '.', ',').'</td>
                        </tr>
                    </table>

                
                    

                    
                </div> <br>

                <div id="content1">
                <table id="ignore" class="detailstable" class="color_blanco">
                    <tr style="background-color: #d9d9d9;">
                        <th class="dt1">ID</th>
                        <th class="dt1">DESCRIPCION</th>
                        <th class="dt1">CANTIDAD</th>
                        <th class="dt1">UNIDAD</th>
                        <th class="dt1">SUBTOTAL</th>
                        <th class="dt1">IVA</th>
                        <th class="dt1">TOTAL</th>
                    </tr>
                    

                    '; 

                        /*//FOREACH ESTACION 
                        $i = 0;
                    foreach ($estaciones as $estacion){
                        echo'
                            <tr>
                                <td colspan="11" class="separator-td">
                                    <label>'.$estacion['rzonsocial'].' </label>
                                    <label><b>'.$estacion['codigo'].'</b></label> 
                                    <label>'.$estacion['claveestacion'].'</label> 
                                    <label>'.$estacion['rfc'].'</label>
                                </td>
                            </tr>
                        ';*/
                        foreach ($Comprobante['Concepto'] as $producto){
                            //echo $producto;
                            $iva= $producto["Importe"]*0.16;
                            $totalproducto= $producto["Importe"]*1.16;
                                echo '
                                    <tr class="detailtbl-productos">
                                        <td class="dt2"><label>'.$producto["NoIdentificacion"].'</label></td>
                                        <td class="dt2"><label>'.$producto["Descripcion"].'</label></td>
                                        <td class="dt2"><label>'.$producto["Cantidad"].'</label></td>
                                        <td class="dt2"><label>'.$producto["Unidad"].'</label></td>
                                        <td class="dt2"><label>'.$producto["Importe"].'</label></td>
                                        <td class="dt2"><label>'.$iva.'</label></td>
                                        <td class="dt2"><label>'.$totalproducto.'</label></td>
                                    </tr>
                                ';
                                $t_cantidad += $producto['Cantidad'];
                                $t_importe += $producto['Importe'];
                                $t_iva += $producto["Traslados"]['Traslado']['Importe'];
                                $t_total += ($producto["Importe"] + $producto["Traslados"]['Traslado']['Importe']);
                                $i ++;

                                if($producto["Descripcion"]=="32011 PEMEX MAGNA"){
                                    $lts_magna+=$producto["Cantidad"];
                                    $imp_magna+=$totalproducto;
                                }
                                if($producto["Descripcion"]=="32012 PEMEX PREMIUM"){
                                    $lts_premium+=$producto["Cantidad"];
                                    $imp_premium+=$totalproducto;
                                }
                                if($producto["Descripcion"]=="32011 PEMEX DIESEL"){
                                    $lts_diesel+=$producto["Cantidad"];
                                    $imp_diesel+=$totalproducto;
                                }
                            
                        }
                        echo'
                        <tr class="detailstbl-totales">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        ';
                    

                    echo'
                </table>
                <br>
                <table id="detailstbl-productostotales">
                        <tr>
                            <th class="fixed-td">PRODUCTO</th>
                            <th class="fixed-td">LITROS</th>
                            <th class="fixed-td">IMPORTE</th>
                        </tr>
                        <tr>
                            <td class="fixed-td">MAGNA</td>
                            <td class="value-td">'.$lts_magna.'</td>
                            <td class="value-td">'.$imp_magna.'</td>
                        </tr>
                        <tr>
                            <td class="fixed-td">PREMIUM</td>
                            <td class="value-td">'.$lts_premium.'</td>
                            <td class="value-td">'.$imp_premium.'</td>
                        </tr>
                        <tr>
                            <td class="fixed-td">DIESEL</td>
                            <td class="value-td">'.$lts_diesel.'</td>
                            <td class="value-td">'.$imp_diesel.'</td>
                        </tr
                        <tr>
                            <td class="fixed-td">TOTAL</td>
                            <td class="value-td">'.($lts_magna + $lts_premium + $lts_diesel).'</td>
                            <td class="value-td">'.($imp_magna + $imp_premium + $imp_diesel).'</td>
                        </tr>
                    </table>
            </div>
            <br>

                <table id="qrdetails-tbl">
                    <tr>
                        <td class="qrdetails">Serie del Certificado del emisor</td>
                        <td class="qrdetails2">'.$Comprobante["NoCertificado"].'</td>
                    </tr>
                    <tr>
                        <td class="qrdetails">Folio fiscal</td>
                        <td class="qrdetails2">'.$Comprobante['TimbreFiscalDigital']['UUID'].'</td>
                    </tr>
                    <tr>
                        <td class="qrdetails">No. de Serie del Certificado de SAT</td>
                        <td class="qrdetails2">'.$Comprobante['TimbreFiscalDigital']['NoCertificadoSAT'].'</td>
                    </tr>
                    <tr>
                        <td class="qrdetails">Fecha y hora de certificación</td>
                        <td class="qrdetails2">'.$Comprobante["Fecha"].'</td>
                    </tr>
                </table>

                <label id="representacioncfdi">Este documento es una representación impresa de un CFDI</label>
            </div>

            <div id="footer">
                <div style="display: flex; flex-direction: column;">
                    <label style="color: #0082b7; background-color: #d9d9d9;">Sello digital del CFDI</label>
                    <label style="font-size: 10px; word-wrap: break-word;">'.$Comprobante['TimbreFiscalDigital']['SelloCFD'].'</label>
                    <label style="color: #0082b7; background-color: #d9d9d9;">Sello del SAT</label>
                    <label style="font-size: 10px; word-wrap: break-word;">'.$Comprobante['TimbreFiscalDigital']['SelloSAT'].'</label>
                    <label style="color: #0082b7; background-color: #d9d9d9;">Cadena original del complemento de certificación digital del SAT</label>
                    <label style="font-size: 10px; word-wrap: break-word;">||'.
                        $Comprobante['TimbreFiscalDigital']['Version']."|".
                        $Comprobante['TimbreFiscalDigital']['UUID']."|".
                        $Comprobante['TimbreFiscalDigital']['FechaTimbrado']."|".
                        $Comprobante['TimbreFiscalDigital']['RfcProvCertif']."|".
                        $Comprobante['TimbreFiscalDigital']['SelloCFDI']."|".
                        $Comprobante['TimbreFiscalDigital']['SelloSAT']."|".
                        $Comprobante['TimbreFiscalDigital']['NoCertificadoSAT'].'||
                    </label>
                </div>
                
                <div id="footer-qr">
                    <img src="'.$pngQR.'"></img>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function(){
        
        downloadPDFWithjsPDF("'.$nombre.'","'.$folio_doc.'","'.$fecha_doc.'","'.$importe_doc.'", "Estado de cuenta","'.$contacto.'","'.$nombreC.'");
    }
</script>
';
//echo $contacto;
?>
