$(function() { //quand le document est pret
    //FUNCTION
    function checkVal(nom) {
        if(nom=="") {
            return "empty";
        }
        else if(nom.length>50) {
            return "max";
        } else {
            return "valide";
        }
    }
    function checkSltVal(nom) {
        if(nom=="") {
            return "empty";
        }
        else if(nom=="0") {
            return "empty";
        } else {
            return "valide";
        }
    }
    //CATEGORIE FORM
    $('#button_categorie').click(function() {
        var ok_cat=false;
        var input_cat = $('#input_categorie').val();
        if(checkVal(input_cat)=="empty") {
            $('#sm_erreur_scat_max').hide();
            $('#sm_erreur_cat_empty').show();
        } else if(checkVal(input_cat)=="max") {
            $('#sm_erreur_cat_empty').hide();
            $('#sm_erreur_cat_max').show();
        }  else if(checkVal(input_cat)=="valide") {
            ok_cat=true;
            $('#sm_erreur_cat_empty').hide();
            $('#sm_erreur_cat_max').hide();
         }
         if(ok_cat==true) {
            $( "#form_cat" ).submit();
         }
    });
    //SOUS CATEGORIE FORM
    $('#button_scategorie').click(function() {
        var ok_scat=false;
        var ok_slt_cat=false;
        var input_scat = $('#input_scategorie').val(); //input sous categorie
        var slt_scat = $('#slt_categorie').val(); //select
       
        if(checkVal(input_scat)=="empty") {
            $('#sm_erreur_scat_max').hide();
            $('#sm_erreur_scat_empty').show();
        } else if(checkVal(input_scat)=="max") {
            $('#sm_erreur_scat_empty').hide();
            $('#sm_erreur_scat_max').show();
        }  else if(checkVal(input_scat)=="valide") {
            ok_scat=true;
            $('#sm_erreur_scat_empty').hide();
            $('#sm_erreur_scat_max').hide();
         }
         //SELECT CATEGORIE
         if(checkSltVal(slt_scat)=="empty") {
            $('#sm_erreur_sltcat_empty').show();
        } else if(checkSltVal(slt_scat)=="valide") {
            ok_slt_cat=true;
            $('#sm_erreur_sltcat_empty').hide();
         }
         if(ok_scat==true && ok_slt_cat==true) {
            $( "#form_scat" ).submit();
         }
    });
    //SOUS SOUS CATEGORIE FORM
    $('#button_sscategorie').click(function() {
        var ok_sscat=false;
        var ok_slt_cat=false;
        var ok_slt_scat=false;
        var input_sscat = $('#input_sscategorie').val(); //input sous categorie
        var slt_scat = $('#slt_categorie2').val(); //select
        var slt_sscat = $('#slt_scategorie').val(); //select
   
         //SELECT CATEGORIE
         if(checkSltVal(slt_scat)=="empty") {
            $('#sm_erreur_sltcat2_empty').show();
        } else if(checkSltVal(slt_scat)=="valide") {
            ok_slt_cat=true;
            $('#sm_erreur_sltcat2_empty').hide();
         }
        
           //SELECT SOUS CATEGORIE
           if(checkSltVal(slt_sscat)=="empty") {
            $('#sm_erreur_sltscat_empty').show();
        } else if(checkSltVal(slt_sscat)=="valide") {
            ok_slt_scat=true;
            $('#sm_erreur_sltscat_empty').hide();
         }
         //SOUS SOUS CATEGORIE
         if(checkVal(input_sscat)=="empty") {
            $('#sm_erreur_sscat_max').hide();
            $('#sm_erreur_sscat_empty').show();
        } else if(checkVal(input_sscat)=="max") {
            $('#sm_erreur_sscat_empty').hide();
            $('#sm_erreur_sscat_max').show();
        }  else if(checkVal(input_sscat)=="valide") {
            ok_sscat=true;
            $('#sm_erreur_sscat_empty').hide();
            $('#sm_erreur_sscat_max').hide();
         }

         if(ok_sscat==true && ok_slt_cat==true && ok_slt_scat==true) {
            $( "#form_sscat" ).submit();
         }
    });
});