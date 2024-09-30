function loader(active = false){
    if(active === true){
        $('#loader').html('');
        $('#loader').remove();
        let loader = '<div id="loader">'
        loader+= '<div class="position-fixed d-flex justify-content-center align-items-center top-0 left-0" style="z-index: 500; width:100%; height:100%; overflow-y:scroll;background-color: rgba(0,0,0,.50)">'
        loader += '<div class="d-flex justify-content-between align-items-center" style="z-index: 600; border-radius:10px; background-color: white;">'
        loader+='<div class="mx-4 my-2">'
        loader += 'Carregando...'
        loader += '<div class=" ml-2 spinner-border spinner-border-sm text-primary" role="status">'
        loader+= '<span class="sr-only">Loading...</span>'
        loader+='</div>'
        loader+='</div>'
        loader+='</div>'
        loader+='</div>'
        loader+='</div>'
        document.getElementsByTagName('body').style =' '
        $('body').prepend(loader);
    }else{
        $('#loader').html('');
        $('#loader').remove();
    }
}

