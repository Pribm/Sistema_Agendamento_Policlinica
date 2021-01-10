$(document).ready(function () {
    
    $('#calendar').evoCalendar({
        'language': 'pt', 'eventListToggler': false, 'eventDisplayDefault': false, 'todayHighlight': true, 'format': 'yyyymmdd'
    })
    $('#calendar').on('selectDate', function (event, newDate, oldDate) {
       document.getElementById('dia').value = newDate;
    });

    $('#calendar').evoCalendar('selectDate', Date.now())
})

