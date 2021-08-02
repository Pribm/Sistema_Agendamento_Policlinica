$(document).ready(function () {
    $('#calendar').evoCalendar({
        'language': 'pt', 'eventListToggler': false, 'eventDisplayDefault': false, 'todayHighlight': true, 'format': 'yyyymmdd'
    })
    $('#calendar').on('selectDate', function (event, newDate, oldDate) {
       let inputDay = document.getElementById('dia');
       inputDay.value = newDate

       document.querySelector('#dia_semana').value = formatDate(inputDay.value).getDay();
       $('#dias_disponiveis').html('')
       let medicoSelecionado = document.querySelector('#medico').value
   
       let horarioOption = document.querySelector('#horario').selectedIndex
   
       lista_medicos.forEach(function (medico) {
           if(medico.id === medicoSelecionado){
              let horarioSelecionado = medico.turnos[horarioOption]
              if(horarioSelecionado.horario_id === document.querySelector('#horario').value){

                   horarioSelecionado.dias.map(function(dia, index) {
                       if(dia_semana.value === dia.dia){

                            //pega a contagem de atendimentos por dia do backend via método get
                            $.get("contar_agendamentos", {dia:newDate, medico_id: medicoSelecionado}, function (response, textStatus, jqXHR) {
                                let atendimentosTotais = (parseInt(dia.atendimentos) - parseInt(response[0]))
                                $('#dias_disponiveis').append(`<p>${dia.label_dia}-feira, ${atendimentosTotais} atendimentos</p>`)

                                //Aqui muda a cor do Alerta dos horários, caso os atendimentos totais sejam menores que 0
                                atendimentosTotais <= 0 ? $('#alert-dias').addClass('alert-danger') : $('#alert-dias').removeClass('alert-danger');
                            },"json");
                       }
                   })
              }
           }
       })
    });

    $('#calendar').evoCalendar('selectDate', Date.now())
    
})


function formatDate(date){
    let diaFormato = date

    let ano = diaFormato.slice(0,4)
    let dia = diaFormato.slice(6,8)
    let mes = diaFormato.slice(4,6)
        
    diaFormato = ano + '-' + mes + '-' + dia + 'T00:00'

    let d = new Date(diaFormato)

    return d
}

