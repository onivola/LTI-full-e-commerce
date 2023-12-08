$(function() { //quand le document est pret
        //FUNCTION
        function checkVal(nom) {
            if(nom=="") {
                return "empty";
            }
            else if(nom.length>100) {
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
        $('#button_titre1').click(function() {
            var ok_cat=false;
            var input_cat = $('#slt_cat').val();
            var input_scat = $('#slt_scat').val();
            var input_sscat = $('#slt_sscat').val();
            var input_t1 = $('#input_t1').val();
            var ok_t1 = false;
            /**------------------CATEGORIE-------------------* */
            if(checkSltVal(input_cat)=="empty" || checkSltVal(input_scat)=="empty" || checkSltVal(input_sscat)=="empty") {
                $('#sm_erreur_cat_max').hide();
                $('#sm_erreur_cat_empty').show();
            } else if(checkSltVal(input_cat)=="max" || checkSltVal(input_scat)=="max" || checkSltVal(input_sscat)=="max") {
                $('#sm_erreur_cat_empty').hide();
                $('#sm_erreur_cat_max').show();
            }  else if(checkSltVal(input_cat)=="valide" && checkSltVal(input_scat)=="valide" && checkSltVal(input_sscat)=="valide") {
                ok_cat=true;
                $('#sm_erreur_cat_empty').hide();
                $('#sm_erreur_cat_max').hide();
            }
            /*-------------------TITRE  1-----------------------***/
            if(checkVal(input_t1)=="empty") {
                $('#sm_erreur_t1_max').hide();
                $('#sm_erreur_t1_empty').show();
            } else if(checkVal(input_t1)=="max") {
                $('#sm_erreur_t1_empty').hide();
                $('#sm_erreur_t1_max').show();
            }  else if(checkVal(input_t1)=="valide") {
                ok_t1=true;
                $('#sm_erreur_t1_empty').hide();
                $('#sm_erreur_t1_max').hide();
             }
             //SUBMIT AJOUT TITRE 1
            if(ok_cat==true && ok_t1==true) {
                $( "#form_titre1" ).submit();
            }
        });
        $('#button_titre2').click(function() {
            var slt_titre1 = $('#slt_titre1').val();
            var ok_t1 = false;
            var input_t2 = $('#input_t2').val();
            var ok_t2 = false;
            var slt_recherche = $('#slt_recherche').val();
            var ok_recherche = false;
            /**------------------TITRE1-------------------* */
            if(checkSltVal(slt_titre1)=="empty") {
                $('#sm_erreur_sltt1_max').hide();
                $('#sm_erreur_sltt1_empty').show();
            } else if(checkSltVal(slt_titre1)=="max") {
                $('#sm_erreur_sltt1_empty').hide();
                $('#sm_erreur_sltt1_max').show();
            }  else if(checkSltVal(slt_titre1)=="valide") {
                ok_t1=true;
                $('#sm_erreur_sltt1_empty').hide();
                $('#sm_erreur_sltt1_max').hide();
            }
            /*-------------------TITRE 2-----------------------***/
            if(checkVal(input_t2)=="empty") {
                $('#sm_erreur_t2_max').hide();
                $('#sm_erreur_t2_empty').show();
            } else if(checkVal(input_t2)=="max") {
                $('#sm_erreur_t2_empty').hide();
                $('#sm_erreur_t2_max').show();
            }  else if(checkVal(input_t2)=="valide") {
                ok_t2=true;
                $('#sm_erreur_t2_empty').hide();
                $('#sm_erreur_t2_max').hide();
            }
            /**------------------TITRE1-------------------* */
            if(checkSltVal(slt_recherche)=="empty") {
                $('#sm_erreur_sltrech_max').hide();
                $('#sm_erreur_sltrech_empty').show();
            } else if(checkSltVal(slt_recherche)=="max") {
                $('#sm_erreur_sltrech_empty').hide();
                $('#sm_erreur_sltrech_max').show();
            }  else if(checkSltVal(slt_recherche)=="valide") {
                ok_recherche=true;
                $('#sm_erreur_sltrech_empty').hide();
                $('#sm_erreur_sltrech_max').hide();
            }
             //SUBMIT AJOUT TITRE 2
             if(ok_t1==true && ok_t2==true && ok_recherche==true) {
                $( "#form_titre2" ).submit();
            }
        });
});