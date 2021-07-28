$(document).ready(function () {
    
    $('#calendar').evoCalendar({
        'language': 'pt', 'eventListToggler': false, 'eventDisplayDefault': false, 'todayHighlight': true, 'format': 'yyyymmdd'
    })
    $('#calendar').on('selectDate', function (event, newDate, oldDate) {
       let inputDay = document.getElementById('dia');
       inputDay.value = newDate
       dia = new Date(formatDate(inputDay.value))
       //console.log(dia.getDay())
    });

    $('#calendar').evoCalendar('selectDate', Date.now())
})

function formatDate(date){
    let diaFormato = date

    let ano = diaFormato.slice(0,4)
    let dia = diaFormato.slice(6,8)
    let mes = diaFormato.slice(4,6)
        
    diaFormato = ano + '-' + mes + '-' + dia + 'T00:00'

    return diaFormato
}

