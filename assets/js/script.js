/**$(function() {
    $("#categorie").click(function(){
        
    });
});**/
$(function() { //quand le document est pret
   //NAVIGATEUR WIDTH
   var search =700;  //input origin width
   var search_dx =510; //input dx
    if($(window).width() <768) {//navigateur charger
        $('#div_search_down').show();
        $('#div_search_up').hide();
        $('#div_umberg').show();
        $('#div_ctg_simple').hide();
       
    } else if($(window).width() >=768) {
        $('#div_search_down').hide();
        $('#div_search_up').show();
        $('#div_umberg').hide();
        $('#div_ctg_simple').show();
        if($(window).width() <1210) { //resize input search
            $('#input_search_up').width(($(window).width()-search_dx));
        } else if($(window).width()>=1210) {
            $('#input_search_up').width(search);
            if($(window).width()>=3957) { //input large window width
                $('#input_search_up').width(search-40);
            }
        }
    }
    $(window).resize(function() { //navigateur redimensionner
        if($(window).width() <768) { //si le width de navigateur <768
            $('#div_search_down').show(); //on replace le formilaire de recherche en bas
            $('#div_search_up').hide(); //on cache le formilaire de recherche
            $('#div_umberg').show();
            $('#div_ctg_simple').hide(); //on cache le div categorie
        } else if($(window).width() >=768) {
            $('#div_search_down').hide();
            $('#div_search_up').show();
            $('#div_umberg').hide();
            $('#div_ctg_simple').show();
            if($(window).width() <1210) { //resize input search
                $('#input_search_up').width(($(window).width()-search_dx));
            } else if($(window).width()>=1210) {
                $('#input_search_up').width(search);
                if($(window).width()>=3957) { //input large window width
                    $('#input_search_up').width(search-40);
                }
            }
        }
        //console.log($(window).width());
    });
    
    
   
 
   //NON CONNECTER
    $('#a_icompte').mouseenter(function(){ //evenement click
        $('#div_drop_login').show();
        $('#div_drop_logout').show();
    }).mouseleave(function(){ //evenement click
        $('#div_drop_login').hide();
        $('#div_drop_logout').hide();
    });
    $('#div_drop_login').mouseenter(function(){ //evenement click
        $('#div_drop_login').show();
    }).mouseleave(function(){ //evenement click
        $('#div_drop_login').hide();
    });
  
    $('#div_drop_logout').mouseenter(function(){ //evenement click
        $('#div_drop_logout').show();
    }).mouseleave(function(){ //evenement click
        $('#div_drop_logout').hide();
    });
});