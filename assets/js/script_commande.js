$(function() { //quand le document est pret
    //PAIEMENT
    
    ////FUNCTION///
    function checkNom(nom) {
        if(nom=="") {
            return "empty";
        }
        else if(nom.length>50) {
            return "nom_max";
        } else {
            return "valid";
        }
    }
    function checkAdress(nom) {
        if(nom=="") {
            return "empty";
        }
        else if(nom.length>200) {
            return "nom_max";
        } else {
            return "valid";
        }
    }
    ////FUNCTION///

    //////////////////ADRESSE////////////////
    $( "#button_livrado" ).click(function() { //input prenom
        var civilit = $("#dv_checkcivilit input:checked").val();
        var ok_civilit=false;
        var ok_nom=false;  //variable test
        var nom= $('#input_nom').val();
        var prenom=$('#input_prenom').val();;
        var ok_prenom=false;
        var phone=$('#input_tel').val();;
        var ok_phone=false;
        var ville=$('#select_ville').val();;
        var ok_ville=false;
        var adresse=$('#input_adresse').val();;
        var ok_adresse=false;
        var cadresse=$('#input_cadresse').val();;
        var ok_cadresse=false;
        var cpostal=$('#input_cpostal').val();;
        var ok_cpostal=false;
       
        //civilit
        if(civilit=="Homme" || civilit=="Femme") {
            ok_civilit=true;
        }
        //NOM
        if(checkNom(nom)=="empty") { // input vide
            $('#sm_erreur_nom_nbmax').hide();
            $('#sm_erreur_nom').show();
        } else if(checkNom(nom)=="nom_max") {
            $('#sm_erreur_nom').hide();
            $('#sm_erreur_nom_nbmax').show();
        } else { //nom valide
            $('#sm_erreur_nom').hide();
            $('#sm_erreur_nom_nbmax').hide();
            ok_nom=true;
        }
        //PRENOM
        if(checkNom(prenom)=="empty") { // input vide
            $('#sm_erreur_prenom_nbmax').hide();
            $('#sm_erreur_prenom').show();
        } else if(checkNom(prenom)=="nom_max") {
            $('#sm_erreur_prenom').hide();
            $('#sm_erreur_prenom_nbmax').show();
        } else { //nom valide
            $('#sm_erreur_prenom').hide();
            $('#sm_erreur_prenom_nbmax').hide();
            ok_prenom=true;
        }
        if(ville!="") {
            ok_ville=true;
        }
         //ADRESSE
         if(checkAdress(adresse)=="empty") { // input vide
            $('#sm_erreur_adress_nbmax').hide();
            $('#sm_erreur_adress').show();
        } else if(checkAdress(adresse)=="nom_max") {
            $('#sm_erreur_adress').hide();
            $('#sm_erreur_adress_nbmax').show();
        } else { //nom valide
            $('#sm_erreur_adress').hide();
            $('#sm_erreur_adress_nbmax').hide();
            ok_adresse=true;
        }
         //C ADRESSE
         if(checkAdress(cadresse)=="empty") { // input vide
            $('#sm_erreur_cadress_nbmax').hide();
            $('#sm_erreur_cadress').show();
        } else if(checkAdress(cadresse)=="nom_max") {
            $('#sm_erreur_cadress').hide();
            $('#sm_erreur_cadress_nbmax').show();
        } else { //nom valide
            $('#sm_erreur_cadress').hide();
            $('#sm_erreur_cadress_nbmax').hide();
            ok_cadresse=true;
        }
          //Code postal
          if(checkNom(cpostal)=="empty") { // input vide
            $('#sm_erreur_cpost_nbmax').hide();
            $('#sm_erreur_cpost').show();
        } else if(checkNom(cpostal)=="nom_max") {
            $('#sm_erreur_cpost').hide();
            $('#sm_erreur_cpost_nbmax').show();
        } else { //nom valide
            $('#sm_erreur_cpost').hide();
            $('#sm_erreur_cpost_nbmax').hide();
            ok_cpostal=true;
        }
         //Téléphone
         if(checkNom(phone)=="empty") { // input vide
            $('#sm_erreur_tel_nbmax').hide();
            $('#sm_erreur_tel').show();
        } else if(checkNom(phone)=="nom_max") {
            $('#sm_erreur_tel').hide();
            $('#sm_erreur_tel_nbmax').show();
        } else { //nom valide
            $('#sm_erreur_tel').hide();
            $('#sm_erreur_tel_nbmax').hide();
            ok_phone=true;
        }
        if(ok_civilit ==true && ok_nom==true && ok_prenom==true && ok_phone==true && ok_ville==true && ok_adresse==true && ok_cadresse==true && ok_cpostal==true) {
           // $( "#form_client_menu" ).submit();
            $('#input_m').prop('disabled', 'disable'); //disable input
            $('#input_mme').prop('disabled', 'disable');
            $('#input_nom').prop('disabled', 'disable');
            $('#input_prenom').prop('disabled', 'disable');
            $('#input_tel').prop('disabled', 'disable');
            $('#select_ville').prop('disabled', 'disable');
            $('#input_adresse').prop('disabled', 'disable');
            $('#input_cadresse').prop('disabled', 'disable');
            $('#input_cpostal').prop('disabled', 'disable');
            $('#dv_dtipvalid').hide(); //hide button valid
            $('#dv_btipedit').show(); //show button edit
            var url = $('#input_url').val();
           $('#ajaxpaiement').load(url+'Commande/AjaxPaiement',{civilit:civilit,nom:nom,prenom:prenom,ville:ville,adresse:adresse,cadresse:cadresse,cpostal:cpostal,phone:phone }, function() { //send table
                //$(this).show();
                $( "#li_mvola" ).click(function() {
                    $('#checkmvola').prop('checked', 'checked');
                    $('#dv_paypal').hide();
                    $('#dv_vbancaire').hide();
                    $('#dv_mvola').show();
                });
                $( "#li_paypal" ).click(function() {
                    $('#checkpaypal').prop('checked', 'checked');
                    $('#dv_mvola').hide();
                    $('#dv_vbancaire').hide();
                    $('#dv_paypal').show();
                });
                $( "#li_vbanc" ).click(function() {
                    $('#checkvbancaire').prop('checked', 'checked');
                    $('#dv_mvola').hide();
                    $('#dv_paypal').hide();
                    $('#dv_vbancaire').show();
                });
                /*********VALIDATION COMMANDE******** */
                $( "#bt_banc" ).click(function() {
                    $('#form_validcommande').submit();
                });
                $( "#bt_mvola" ).click(function() {
                    $('#form_validcommande').submit();
                });
                $( "#bt_paypal" ).click(function() {
                    $('#form_validcommande').submit();
                });
           });
        }
    });
    $( "#button_livradoedit" ).click(function() {
        $('#dv_dtipvalid').show(); //show button valid
        $('#dv_btipedit').hide(); //hide button edit
        $('#input_m').prop('disabled', false); //disable input
        $('#input_mme').prop('disabled', false);
        $('#input_nom').prop('disabled', false);
        $('#input_prenom').prop('disabled', false);
        $('#input_tel').prop('disabled', false);
        $('#select_ville').prop('disabled', false);
        $('#input_adresse').prop('disabled', false);
        $('#input_cadresse').prop('disabled', false);
        $('#input_cpostal').prop('disabled', false);

        $('#ajaxpaiement').text(""); //dellet paiement
        
    });
    
});
