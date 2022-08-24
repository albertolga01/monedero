<?php
    
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="scripts/pdfExportMethods.js"></script>

<div id="styledTable"> 
    <div class=WordSection1>
        <head>
            <style>
                label {
                    font-size: 14px;
                    font-family: Arial, Helvetica, sans-serif;
                }

                img {
                    width: 250px;
                    padding-left: 50px;
                }

                .detpago {
                    display: inline-block;
                    width: 130px;
                    background-color: #d9d9d9;
                    color: #0082b7;
                }

                .toptable {
                    border-left: 1px solid;
                    border-right: 1px solid;
                    border-top: 1px solid;
                }

                .toptable div {
                    border-bottom: 1px solid;
                    border-width: 1px;
                }

                .tt2, .tt3, .tt4, .tt5 {
                    border-right: 1px solid;
                    display: inline-block;
                    width: 70px;
                    background-color: lightgray;
                }

                .rfcvalue {
                    display: inline-block;
                    width: 200px;
                }

                .detailstable {
                    width: 100%;
                    font-size: 14px;
                    font-family: Arial, Helvetica, sans-serif;
                    border: 1px solid black;
                    border-collapse: collapse;
                }

                #idignore {
                    padding: 0px;
                }

                th {
                    border: 1px solid black;
                }
                
                .dt1 {
                    white-space: nowrap;
                    border: 1px solid black;
                    color: #0082b7;
                    text-align: center;
                }

                .dt2 {
                    border: 1px solid black;
                    font-weight: 300;
                    text-align: center;
                }

                .total1 {
                    display: inline-block;
                    width: 140px;
                    background-color: #d9d9d9;
                    color: #0082b7;
                }

                .qrdetails {
                    display: inline-block;
                    width: 225px;
                    background-color: #d9d9d9;
                    color: #0082b7;
                }

                .bottomtable {
                    border-collapse: collapse;
                    width: 100%;
                }

                .bottomtable td {
                    border: 1px solid black;
                }

                .bt3 {
                    width: auto;
                }
            </style>
        </head>
        <div style="width: 755px;">
            <div style="display: flex; flex-direction: row;">
                <div  style="display: flex; flex-direction: column; padding: 10px 10px 10px;" >
                <img src="../../imagenes/LaCaja-logo.png" alt="La Caja"/> 
                </div>

                <div style="display: flex; flex-direction: column; margin-left: auto; background-color: #d9d9d9; color: #0082b7;">
                    <label><center>COMERCIALIZADORA PETROMAR SA DE CV</center></label>
                    <label><center>RFC: CPE190207226</center></label>
                    <label>Tipo de comprobante: </label>
                    <label>Lugar de Expedición: 82110</label>
                    <label>Régimen Fiscal:601 - General de Ley Personas Morales</label>
                </div>            
            </div>
            <br>

            <div style="display: flex; flex-direction: row; ">
                <div style="margin-right: 10px;">
                    <div>
                        <label class="detpago">Forma de pago</label>
                        <label></label>
                    </div>
                    <div>
                        <label class="detpago">Método de pago</label>
                        <label></label>
                    </div>
                    <div>
                        <label class="detpago">Moneda</label>
                        <label></label>
                    </div>
                </div>

                <div style="margin-left: auto;">
                    <div>
                        <label class="detpago">Folio:</label>
                        <label></label>
                    </div>
                    <div>
                        <label class="detpago">Fecha:</label>
                        <label></label>
                    </div>
                </div>

            </div>

            <label style="font-size: 11px;">
                NÚMERO DE PERMISO DE COMERCIALIZACIÓN OTORGADO POR LA COMISIÓN REGULADORA DE ENERGÍA H/22957/COM/2019
            </label>  

            <div class="toptable" style="display: flex; flex-direction: column;">
                <label style="background-color: #d9d9d9; color: #0082b7;">Datos del cliente</label>

                <div style="flex-direction: row;">
                <label class="tt2">Cliente:</label>
                <label></label>
                </div>

                <div style="flex-direction: row;">
                <label class="tt3">R.F.C:</label>
                <label class="rfcvalue"></label>
                <label class="tt3" style="border-left: 1px solid;">Uso CFDI:</label>
                <label>- Adquisición de mercancias</label>
                </div>

                <div style="flex-direction: row;">
                <label class="tt4">Domicilio:</label>
                <label></label>
                </div>

                <div style="flex-direction: row;">
                <label class="tt5">Lugar de entrega:</label>
                <label></label>
                </div>          
            </div>
            <br>

            <div class="detailsdiv">
                <table id="ignore" class="detailstable" class="color_blanco">
                    <tr style="background-color: #ffffff;">
                        <td class="dt1">Cantidad</td>
                        <td class="dt1">Unidad</td>
                        <td class="dt1">Clave<br>Unidad SAT</td>
                        <td class="dt1">Clave Producto<br>/Servicio</td>
                        <td class="dt1">Concepto<br>/Descripcion</td>
                        <td class="dt1">Valor<br>Unitario</td>
                        <td class="dt1">Descuentos</td> 
                        <td class="dt1">Impuestos</td>
                        <td class="dt1">Importe</td>
                    </tr>

                    <tr>
                        <td class="dt2"><label for="cantidad1"></label></td>
                        <td class="dt2"><label for="unidad11"></label></td>
                        <td class="dt2"><label for="cusat1"></label></td>
                        <td class="dt2"><label for="cps1"></label></td>
                        <td class="dt2" style="text-align: left;"><label for="condes1"></label></td>
                        <td class="dt2"><label for="vunitario1"></label></td> 
                        <td class="dt2"><label for="descuentos1"></label></td>
                        <td class="dt2"><label for="impuestos1"></label></td>
                        <td class="dt2"><label for="importe1"></label></td>
                    </tr>
                </table>
            </div>
        <br>

            <div style="display: flex;">
                <div style="display: flex; flex-direction: column;">
                    <label style="color: #0082b7;">Importe con letra:</label>
                    <label style="display: inline-block; width: 520px;"> PESOS /100 M.N.</label>
                </div>

                <div style="display: flex; flex-direction: column; margin-left: auto;">
                    <div>
                    <label class="total1">Subtotal</label>
                    <label class="total2"></label>
                    </div>

                    <div>
                    <label class="total1">Descuentos</label>
                    <label class="total2"></label>
                    </div>

                    <div>
                    <label class="total1">Impuestos Translados</label>
                    <label class="total2"></label>
                    </div>

                    <div>
                    <label class="total1">I.V.A. Retención Flete</label>
                    <label class="total2"></label>
                    </div>

                    <div>
                    <label class="total1">Total</label>
                    <label class="total2"></label>
                    </div>
                </div>
            </div>
            <br>

            <div style="display: flex; flex-direction: column;">
                <label style="color: #0082b7;">CFDI Relacionado: -</label>
                <label>Tipo Relación: -</label>
                <label>CFDI Relacionado: -</label>
            </div>
            <br>

            <div style="display: flex;">
                <div>
                

                </div>

                <div style="display: flex; flex-direction: column; margin-left: auto;">
                    <div style="display: flex; flex-direction: column;">
                        <div>
                            <label class="qrdetails">Serie del Certificado del emisor</label>
                            <label class="qrdetails2"></label>
                        </div>
                        <div>
                            <label class="qrdetails">Folio fiscal</label>
                            <label class="qrdetails2"></label>
                        </div>
                        <div>
                            <label class="qrdetails">No. de Serie del Certificado de SAT</label>
                            <label class="qrdetails2"></label>
                        </div>
                        <div>
                            <label class="qrdetails">Fecha y hora de certificación</label>
                            <label class="qrdetails2"></label>
                        </div>
                    </div>
                </div>
            </div>
            <label>Este documento es una representación impresa de un CFDI</label>
            <br>
            <div>
                <label>Cantidad al natural: </label>
                <label name="datosextra"></label>
            </div>
            <div>
                <label>Cantidad a 20°: </label>
                <label name="datosextra"></label>
            </div>
            <br>

        
            <br><br><br><br>

            <div style="display: flex; flex-direction: column;">
                <label style="color: #0082b7; background-color: #d9d9d9;">Sello digital del CFDI</label>
                <label style="font-size: 10px; word-wrap: break-word;"></label>
                <label style="color: #0082b7; background-color: #d9d9d9;">Sello del SAT</label>
                <label style="font-size: 10px; word-wrap: break-word;"></label>
                <label style="color: #0082b7; background-color: #d9d9d9;">Cadena original del complemento de certificación digital del SAT</label>
                <label style="font-size: 10px; word-wrap: break-word;"></label>
            </div>
        </div>
    </div>
</div>  
<!-- 
<script>
    window.onload = function(){
        downloadPDFWithjsPDF();
    }
</script>
 -->
