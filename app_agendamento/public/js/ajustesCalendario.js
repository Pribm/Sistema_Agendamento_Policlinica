$(document).ready(function () {
    
    $('#calendar').evoCalendar({
        'language': 'pt', 'eventListToggler': false, 'eventDisplayDefault': false, 'todayHighlight': true, 'format': 'yyyymmdd'
    })
    $('#calendar').on('selectDate', function (event, newDate, oldDate) {
       let inputDay = document.getElementById('dia');
       inputDay.value = newDate
       console.log(event.target)
    });

    $('#calendar').evoCalendar('selectDate', Date.now())
})

