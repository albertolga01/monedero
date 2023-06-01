function downloadPDFWithjsPDF(fileName,folio,fecha,importe, tipocomprobante,contacto,nombreC,cteRFC) {
    var doc = new jspdf.jsPDF({
        orientation: 'p',
        unit: 'pt',
        format: 'a4'
    });
    doc.html(document.querySelector('#styledTable'), {
        callback: function (doc) {
            doc.save(fileName+".pdf");
            
            //edit para guardar en el servidor xxxxxxx
            var blob = doc.output('blob');
            var formData = new FormData();
            formData.append('pdf', blob); 
            formData.append('nombre', fileName);  
            formData.append('folio', folio); 
            formData.append('fecha', fecha); 
            formData.append('importe', importe); 
            formData.append('tipocomprobante', tipocomprobante);
            formData.append('contacto', contacto); 
            formData.append('nombreC', nombreC); 
            formData.append('cteRFC', cteRFC); 
            fetch("https://monedero.grupopetromar.com/admin/apirest/sw-sdk-php/upload.php", { 
                method: 'POST',
                mode: "cors",
                body: formData
            })
            .then(response => response.text())
            .catch(error => alert(error))
            .then((data) => {
                if(data=="1"){
                    Cerrar();
                }else{
                    console.log(data)
                }
                })
        },
        margin: [30, 30, 30, 30],
        html2canvas: {
            scale: 0.7, //this was my solution, you have to adjust to your size
        },
        
    }); 

}
function downloadPDFWithjsPDFComplementos(fileName,folio,fecha,importe, tipocomprobante,contacto,nombreC, cteRFC) {
    var doc = new jspdf.jsPDF({
        orientation: 'p',
        unit: 'pt',
        format: 'a4'
    });
    doc.html(document.querySelector('#styledTable'), {
        callback: function (doc) {
            doc.save(fileName+".pdf");
            
            //edit para guardar en el servidor xxxxxxx
            var blob = doc.output('blob');
            var formData = new FormData();
            formData.append('pdf', blob); 
            formData.append('nombre', fileName);  
            formData.append('folio', folio); 
            formData.append('fecha', fecha); 
            formData.append('importe', importe); 
            formData.append('tipocomprobante', tipocomprobante);
            formData.append('contacto', contacto); 
            formData.append('nombreC', nombreC); 
            formData.append('cteRFC', cteRFC); 
            //alert("upload");
            fetch("https://monedero.grupopetromar.com/admin/apirest/sw-sdk-php/upload.php", { 
                method: 'POST',
                mode: "cors",
                body: formData
            })
            .then(response => response.text())
            .catch(error => alert(error))
            .then((data) => {
                if(data=="1"){
                    Cerrar();
                }else{
                    console.log(data)
                }
                })
        },
        margin: [30, 30, 30, 30],
        html2canvas: {
            scale: 0.7, //this was my solution, you have to adjust to your size
        },
        
    }); 

}
function Cerrar(){
    //alert("Enviado Correctamente");
     open(location, '_self').close(); 
}

// document.querySelector('#jsPDF').addEventListener('click', downloadPDFWithjsPDF);
