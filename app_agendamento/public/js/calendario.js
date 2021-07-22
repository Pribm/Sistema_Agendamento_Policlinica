function setDate(){
    let data = document.getElementById('cal')
}

function formatDate(){
    let diaFormato = document.getElementsByClassName('datasFormatar')
    //console.log(data.value);
    let diasNaoFormatados = Array();

    for (let i = 0; i < diaFormato.length; i++) {
        diasNaoFormatados[i] = diaFormato[i].innerHTML;
        diasNaoFormatados[i].slice(0,2);
        let ano = diasNaoFormatados[i].slice(0,4)
        let mes = diasNaoFormatados[i].slice(5,7)
        let dia = diasNaoFormatados[i].slice(8,10)
        
        diaFormato[i].innerHTML = dia + '/' + mes + '/' + ano
    }
}