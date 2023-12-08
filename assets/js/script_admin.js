$(function() { //quand le document est pret
    //NAVIGATEUR WIDTH
    var sct_comptdx = 279;
    if($(window).width() <768) {//navigateur charger
        $('#sct_side').hide();
        $('#sct_component').width("93%");
    } else {
        $('#sct_side').show();
        $('#sct_component').width(($(window).width()-sct_comptdx));
       
        if($(window).width() >=3723) {//navigateur charger
            $('#sct_component').width(($(window).width()-sct_comptdx-10));
        } 
    }
    $(window).resize(function() { 
        if($(window).width() <768) {//navigateur charger
            $('#sct_side').hide();
            $('#sct_component').width("93%");
        } else {
            $('#sct_side').show();
            $('#sct_component').width(($(window).width()-sct_comptdx));
          
            if($(window).width() >=3723) {//navigateur charger
                $('#sct_component').width(($(window).width()-sct_comptdx-10));
            } 
        }
    });
});