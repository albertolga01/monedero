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

$strtimbrado = $_POST['complemento'];
$nombre = $_POST['nombrec'];

$conexion = new Conexion();

$db = $conexion->getConexion();

 

//echo $strtimbrado;

 

if (file_exists($strtimbrado)){

    $xml = simplexml_load_file($strtimbrado);

    $crxml=new crXml(); 
    $data = file_get_contents($strtimbrado); 
    $crxml->loadXML($data); 

    $pngQR = substr($strtimbrado, 0,-4).".png";

        //CADENAS PARA ENTRAR A LOS NODOS (SE OCUPAN LOS NAMESPACE QUE ESTAN EN LOS ATRIBUTOS 'xmlns'  /  [ns = NameSpace])

    $ns_cfdi = 'http://www.sat.gob.mx/cfd/3';

    $ns_ecc12 = 'http://www.sat.gob.mx/Pagos';

    $ns_tfd = 'http://www.sat.gob.mx/TimbreFiscalDigital';

    //http://www.sat.gob.mx/sitio_internet/cfd/Pagos10



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

    





    

    



        //ARRAY CON VALORES DE {ecc12:Conceptos}

    $Conceptos_combustible = array();

    foreach ($xml->children($ns_cfdi)->Complemento->children($ns_ecc12)->Pagos->children($ns_ecc12) as $key => $item){

            //ATRIBUTOS DE CADA {ecc12:Concepto}

        $Concepto_combustible = array();

        foreach ($item->attributes() as $key => $value) {

            $Concepto_combustible[$key] = (string)$value;

        }



         

    }





    $Complemento['Pagos'] = $Concepto_combustible;

    $Comprobante['Complemento'] = $Complemento;



        //ARRAY CON VALORES DE {ecc12:DoctoRelacionados}

        $Conceptos_Relacionados = array();

        foreach ($xml->children($ns_cfdi)->Complemento->children($ns_ecc12)->Pagos->children($ns_ecc12)->Pago->children($ns_ecc12) as $key => $item){

                //ATRIBUTOS DE CADA {ecc12:Concepto}

            $Concepto_docrelacionados = array();

            foreach ($item->attributes() as $key => $value) {

                $Concepto_docrelacionados[$key] = (string)$value;

            }

    

             

        }

        $Complemento['Relacionado'] = $Concepto_docrelacionados;

         $Comprobante['Complemento'] = $Complemento;



            //ARRAY CON VALORES DE {tdf:TimbreDigital}

       
 
            $Comprobantee = 'cfdi:Comprobante';
            $Complemento = 'cfdi:Complemento';
            $timbreFiscalDigital = 'tfd:TimbreFiscalDigital';
  
                 
  
  
          $TimbreFiscalDigital = $crxml->$Comprobantee->$Complemento->$timbreFiscalDigital;

          $CadenaCompCertSAT = "||".$TimbreFiscalDigital['Version']."|".$TimbreFiscalDigital['UUID']."|".$TimbreFiscalDigital['FechaTimbrado']."|".
          $TimbreFiscalDigital['RfcProvCertif']."|".$TimbreFiscalDigital['SelloCFD']."|".$TimbreFiscalDigital['NoCertificadoSAT']."||" ;

         // echo $CadenaCompCertSAT;
  






    function formatDate($toFormat){

        $data = explode("T", $toFormat)[0];

        $data = explode("-", $data);

        $formattedDate = $data[2]."/".$data[1]."/".$data[0];

        return $formattedDate;

    }

      $ImporteT = number_format($Comprobante["Complemento"]["Pagos"]["Monto"], 2);
  
      $numberFormatter = new NumberFormatter('es_MX', NumberFormatter::SPELLOUT);

    $TotalLetra = $numberFormatter->format(substr($ImporteT, 0, -3));

    $TotalLetra = strtoupper($TotalLetra) ." PESOS ". substr($ImporteT, -2). "/100 M.N.";


    $folio_doc = $Comprobante["Folio"];
    $fecha_doc = $Comprobante["Fecha"];
    $importe_doc = $Comprobante["Complemento"]["Pagos"]["Monto"];
   //print_r($Comprobante);
 

    // echo "<pre>";

    // print_r($Comprobante);

    // echo "</pre>";

}





 

echo'<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js"></script>

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

                height: 100px;

                width: 100px;



            }

            

            #header2{

                grid-row: 1;

                grid-column: 2;

                font-size: 12px;

                margin-top: 20px

                width: 50%;

                

            }

            

            #header3{

                grid-row: 1;

                grid-column: 3;

                font-size: 14px;

            }

            

            #header4{

                grid-row: 1;

                grid-column: 2;

                font-size: 14px;

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

                height: 100%;

                width: 100%;

                margin-rigth: 20px;

            }



            #header3 td{

                font-size: 14px;

            }



            #content1 td{

                text-align: left;

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

                background-color: #0071ce;

                color: white;

            }



            .detailstable{

                width: 100%;

            }



            .detailstable th{

                border: 1px solid black;

                font-size: 10px;

                text-align: left;

                color: Black;

                padding: 0 4px;

            }

            .detailstable1{

                width: 100%;

            }

            .detailstable1 th{

                border: 1px solid black;

                font-size: 10px;

                text-align: left;

                color: Black;

                padding: 0 4px;

                border-top-color: #ffffff;

            }



            



            .separator-td label{

                font-size: 10px;

                margin: 0;

            }



            .separator-td{

                background-color: #ddd;

                

            }



            .detailtbl-productos td{

                border: 1px solid black;

            }



            .detailstbl-totales td{

                border: none;

            }



            #detailstbl-productostotales .fixed-td{

                font-size: 12px;

                background-color: #0071ce;

                color: white;

                text-align: center;

                padding: 2px 6px;

                border: 1px solid black;

            }



            #saldos-tbl .fixed-td{

                font-size: 12px;

                text-align: center;

                padding: 2px 6px;

                background-color: #0071ce;

                color: white;

            }



            #factdetails-tbl .fixed-td{

                font-size: 12px;

                text-align: center;

                padding: 2px 6px;

                background-color: #0071ce;

                color: white;

            }



            .qrdetails{

                font-size: 12px;

                text-align: center;

                padding: 2px 6px;

                background-color: #0071ce;

                color: white;

            }



            #footer-qr{

                display: flex;

                align-items: center;

            }



            #cliente-tbl{

                font-size: 12px;

            }



            .value-td{

                text-align: right;

            }



            #lineastop{

                text-align: center;

                width: 100%;

                top: 10px;

            }

        </style>

        <div id="header2" style="width: 755px; margin-top: 20px;">



        <center>

        <label style="text-align: center;">'.$Comprobante["Emisor"]["Nombre"].'</label>

        <br>

        <label style="text-align: center;">'.$Comprobante["Emisor"]["Rfc"].'</label>

        <br>

        <label style="text-align: center;">'.$Comprobante["Emisor"]["RegimenFiscal"].' REGIMEN GENERAL DE LEY PERSONAS MORALES</label>

        </center>

        <hr>

        </div>

        

        <div id="wrapper">

        

        

            <div id="header1">

            

            <br>

                <img src="../../imagenes/LaCaja-logo.png" alt="La Caja" /> 

            </div>

            

            <div id="header4" style="margin-top: 17px;margin-left: 145px; width:370px;">

                <table id="cliente-tbl">

                    <tr>

                        <th colspan=2>Datos Generales del Comprobante</th>

                    </tr>

                    <tr>

                        <td>Folio SAT:</td>

                        <td>'.$TimbreFiscalDigital['UUID'].'</td>

                    </tr>

                    <tr>

                        <td>Serie:</td>

                        <td>'.$Comprobante["Serie"].'</td>

                    </tr>

                    <tr>

                        <td>Folio:</td>

                        <td>'.$Comprobante["Folio"].'</td>

                    </tr>

                    <tr>

                        <td>Fecha:</td>

                        <td>'.$Comprobante["Fecha"].'</td>

                    </tr>

                    <tr>

                        <td>Tipo de Comprobante:</td>

                        <td>'.$Comprobante["TipoDeComprobante"].'</td>

                    </tr>

                    <tr>

                        <td>LUGAR DE EXPEDICIÓN:</td>

                        <td>'.$Comprobante["LugarExpedicion"].'</td>

                    </tr>

                </table>

            </div>



            



            <div id="content1">

                <table id="ignore" class="detailstable" class="color_blanco">

                    <tr style="background-color: #d9d9d9;height: 20px">

                        <th class="dt1">DATOS DEL RECEPTOR</th>

                        

                    </tr>

                    <tr style="background-color: #ffffff;height: 20px">

                    <th class="dt1">Razón social: '.$Comprobante["Receptor"]["Nombre"].'</th>

                    </tr>

                    <tr style="background-color: #ffffff;height: 20px">

                    <th class="dt1">RFC: '.$Comprobante["Receptor"]["Rfc"].'</th>

                    </tr>

                    

                </table>

                <table id="ignore" class="detailstable1" class="color_blanco">

                <tr style="background-color: #ffffff;height: 20px">

                <th>Uso CFDI: '.$Comprobante["Receptor"]["UsoCFDI"].' </th>

                <th>Moneda: '.$Comprobante["Moneda"].' </th>

                </tr>

                </table>

                <table id="ignore" class="detailstable1" class="color_blanco" >

                    <tr style="background-color: #d9d9d9;height: 20px; ">

                        <th class="dt1">DATOS DEL COMPLEMENTO DE PAGO</th>

                    

                    </tr>

                </table>

                

                <table id="ignore" class="detailstable1" class="color_blanco">

                    <tr style="background-color: #ffffff;height: 20px">

                    <th>NomBancoExt: </th>

                    <th>RFC Emisor: '.$Comprobante["Emisor"]["Rfc"].'  </th>

                </table>

                <table id="ignore" class="detailstable1" class="color_blanco" >

                    <tr style="background-color: #d9d9d9;height: 20px; ">

                        <th class="dt1">ClaveProdServ</th>

                        <th class="dt1">Cantidad</th>

                        <th class="dt1">ClaveUnidad</th>

                        <th class="dt1">Descripcion</th>

                        <th class="dt1">Valor Unitario</th>

                        <th class="dt1">Importe</th>

                    </tr>

                    <tr style="background-color: #white;height: 20px; ">

                        <th class="dt1">'.$Comprobante['Concepto']["0"]["ClaveProdServ"].'</th>

                        <th class="dt1">'.$Comprobante['Concepto']["0"]["Cantidad"].'</th>

                        <th class="dt1">'.$Comprobante['Concepto']["0"]["ClaveUnidad"].'</th>

                        <th class="dt1">'.$Comprobante['Concepto']["0"]["Descripcion"].'</th>

                        <th class="dt1">'.$Comprobante['Concepto']["0"]["ValorUnitario"].'</th>

                        <th class="dt1">'.$Comprobante['Concepto']["0"]["Importe"].'</th>

                    </tr>

                    </table>

                    <table id="ignore" class="detailstable1" class="color_blanco">

                    <tr style="background-color: #d9d9d9;height: 20px">

                        <th class="dt1">Fecha y hora de pago</th>

                        <th class="dt1">Forma de Pago</th>

                        <th class="dt1">Total del Pago</th>

                    </tr>

                    <tr style="background-color: #white;height: 20px; ">

                        <th class="dt1">'.$Comprobante["Complemento"]["Pagos"]["FechaPago"].'</th>

                        <th class="dt1">'.$Comprobante["Complemento"]["Pagos"]["FormaDePagoP"].'</th>

                        <th class="dt1">'.$Comprobante["Complemento"]["Pagos"]["Monto"].'</th>

                    </tr>

                </table>

                <table id="ignore" class="detailstable1" class="color_blanco">

                    <tr style="height: 20px;">

                        <th class="dt1" style="background-color: #d9d9d9; width: 22%">Cantidad con letras</th>

                        <th class="dt1" style="background-color: #white;">'.$TotalLetra.'</th>

                    </tr>

                </table>

                <table id="ignore" class="detailstable1" class="color_blanco">

                    <tr style="background-color: #d9d9d9;height: 20px">

                        <th class="dt1">CFDI Relacionados</th>

                    </tr>

                    

                </table>

                <table id="ignore" class="detailstable1" class="color_blanco">

                    <tr style="background-color: #d9d9d9;height: 20px">

                        <th class="dt1" style="width: 30%">UUID</th>

                        <th class="dt1" style="width: 12%">Folio</th>

                        <th class="dt1">MetodoPago</th>

                        <th class="dt1" style="width: 12%">Total</th>

                        <th class="dt1">Saldo Anterior</th>

                        <th class="dt1">Saldo Pendiente</th>

                        <th class="dt1">Monto Pagado</th>

                    </tr>

                    <tr style="background-color: #white;height: 20px">

                        <th class="dt1" style="width: 30%">'.$Comprobante["Complemento"]["Relacionado"]["IdDocumento"].'</th>

                        <th class="dt1">'.$Comprobante["Complemento"]["Relacionado"]["Folio"].'</th>

                        <th class="dt1">'.$Comprobante["Complemento"]["Relacionado"]["MetodoDePagoDR"].'</th>

                        <th class="dt1">$'.number_format($Comprobante["Complemento"]["Relacionado"]["ImpPagado"], 2, '.', ',').'</th>

                        <th class="dt1">$'.number_format($Comprobante["Complemento"]["Relacionado"]["ImpSaldoAnt"], 2, '.', ',').'</th>

                        <th class="dt1">$'.number_format($Comprobante["Complemento"]["Relacionado"]["ImpSaldoInsoluto"], 2, '.', ',').'</th>

                        <th class="dt1">$'.number_format($Comprobante["Complemento"]["Pagos"]["Monto"]).'</th>

                    </tr>

                    

                </table>

                <center><label style="font-size: 10px;">Este documento es una representación impresa de un CFDI:</label></center>

                <label style="font-size: 10px;">Observaciones:</label>

                <hr>

            </div>

        

            <div id="footer">

                <div style="display: flex; flex-direction: column;">

                    <label style="color: #0082b7; background-color: #d9d9d9;">Sello digital del CFDI:</label>

                    <label style="font-size: 10px;color: #0082b7; background-color: white;">'.$Comprobante['Sello'].'</label>

                    

                    <label style="color: #0082b7; background-color: #d9d9d9;">Sello del SAT:</label>

                    <label style="font-size: 10px;color: #0082b7; background-color: white;">'.$TimbreFiscalDigital['SelloSAT'].'</label>
                    
                    <label style="color: #0082b7; background-color: #d9d9d9;">Cadena original del complemento de certificación digital del SAT: </label>

                    <label style="font-size: 10px;color: #0082b7; background-color: white;">'.$CadenaCompCertSAT.'</label>

                    <label style="color: #0082b7; background-color: #d9d9d9;">No. serie del certificado del SAT:</label>

                    <label style="font-size: 10px;color: #0082b7; background-color: white;">'.$TimbreFiscalDigital['NoCertificadoSAT'].'</label>

                    

                    </div>

                

                <div id="footer-qr">

                    <img style="width: 160px;" src="../../../DocsClientes/CPE190207226/LACAJAMZT-COMPLEMENTO-50-2022-03-11.png"></img>

                </div>

                

                </div>

                

        </div>



        

    </div>

    

</div>



<script>

    window.onload = function(){ 
        downloadPDFWithjsPDF("'.$nombre.'","'.$folio_doc.'","'.$fecha_doc.'","'.$importe_doc.'", "Complemento");

    }

</script>';

?>