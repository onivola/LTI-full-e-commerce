$(function() { //quand le document est pret
    ////FUNCTION///
    function checkMail(email) { //mail validation
        if(email=="") {
            return "empty";
        }
        else if (/^([a-z0-9._-]+)@([a-z0-9._-]+)\.([a-z]{2,6})$/.test(email)) { //email valide
          return "valid";
        } else {  //email invalide
            return "notvalid";
        }
    }
    function checkMdp(mdp) { //mdp validation
        if(mdp=="") {
            return "empty";
        }
        else if(mdp.length<8) {
            return "mdp_min";
        }
        else if(mdp.length>50) {
            return "mdp_max";
        } else {
            return "valid";
        }
    }
    function checkMdpMdpsame(mdp,mdp_same) {
        if(mdp==mdp_same) {
            return true;
        } else {
            return false;
        }
    }
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
    function checkDate(date) {
        var bitsDays = date.split('-');
        var okdate= false;
        if(bitsDays.length==3) {
            var yDays = parseInt(bitsDays[0]), 
            mDays  = parseInt(bitsDays[1]),
            dDays = parseInt(bitsDays[2]);
            if(yDays>1910) {
                if(mDays<=12 && mDays >=1) {
                    if(dDays<=31 && dDays >0) {
                        //alert("ok");
                        okdate=true;
                    }
                }
            }
        }
        if(okdate==true) {
            return true;
        } else if(okdate==false) {
            return false;
        }
    }
    ////FUNCTION///
    //SINGIN AND LOGIN
    /**** INPUT EMAIL */ 
    $( "#input_email" ).keyup(function() { //for all keyup
        var email = $( "#input_email" ).val();
        if(checkMail(email)=="empty") {
            $('#sm_erreur_email').hide();
            $('#sm_erreur_email_exist').hide();//email exist
            $('#sm_erreur_email_empty').show();
        }
        else if (checkMail(email)=="valid") { //email valide
            $('#sm_erreur_email').hide(); 
            $('#sm_erreur_email_exist').hide();//email exist
        } else {  //email invalide
            $('#sm_erreur_email_empty').hide(); //email obligatoir hide
            $('#sm_erreur_email_exist').hide();//email exist
            $('#sm_erreur_email').show();  //email non valide show
        }
       
    });
    $( "#input_email" ).focusout(function() { //input email, le souri sort de input email
        var email = $( "#input_email" ).val();
        if(checkMail(email)=="empty") { // input vide
            $('#sm_erreur_email_exist').hide();//email exist
            $('#sm_erreur_email_empty').show(); //empte emil erreur
        } 
    });
    /****INPUT MOT DE PASSE */
    var mdp_empty=true;
    $( "#input_mdp" ).focusout(function() { //input email
        if($( "#input_mdp" ).val()=="") { // input vide
            $('#sm_erreur_mdp_false').hide();//mdp incorect
            $('#sm_erreur_mdp_empty').show();
        } 
    });
    $( "#input_mdp" ).keyup(function() { //for all keyup
        mdp_empty = false;
        var mdp = $( "#input_mdp" ).val();
        if(mdp=="") { //mot de passe vide
            
            $('#sm_erreur_mdp_false').hide();//mdp incorect
            $('#sm_erreur_mdp_nbmin').hide();
            $('#sm_erreur_mdp_nbmax').hide();
            $('#sm_erreur_mdp_empty').show();
            mdp_empty = true;
        } else { //nombre de caractaire
            if(mdp.length<8) { //minimum 8char
                $('#sm_erreur_mdp_false').hide();//mdp incorect
                $('#sm_erreur_mdp_empty').hide();
                $('#sm_erreur_mdp_nbmax').hide();
                $('#sm_erreur_mdp_nbmin').show();
            } else if(mdp.length>50) {  //maximum 50char
                $('#sm_erreur_mdp_false').hide();//mdp incorect
                $('#sm_erreur_mdp_empty').hide();
                $('#sm_erreur_mdp_nbmin').hide();
                $('#sm_erreur_mdp_nbmax').show();
            } else {
                $('#sm_erreur_mdp_false').hide();//mdp incorect
                $('#sm_erreur_mdp_empty').hide();
                $('#sm_erreur_mdp_nbmin').hide();
                $('#sm_erreur_mdp_nbmax').hide();
            }
        } 
    });
    //SINGIN
    //input mdp same
    $( "#input_mdp" ).keyup(function() { // keyup mdp
        if(mdp_empty==false) { //input mdp non vide
            var mdp_same = $('#input_mdp_same').val();
            var mdp = $( "#input_mdp" ).val();
            if(mdp!=mdp_same) {
                $('#sm_erreur_mdp_same').show(); 
            } else {
                $('#sm_erreur_mdp_same').hide(); 
            }
        } else { //input mdp nvide
            $('#sm_erreur_mdp_same').hide(); 
        }
    });
    $( "#input_mdp_same" ).keyup(function() { // keyup mdp same
        var mdp_same = $('#input_mdp_same').val();
        var mdp = $( "#input_mdp" ).val();
        if(mdp_empty==false) { //input mdp non vide    
            if(mdp!=mdp_same) {
                $('#sm_erreur_mdp_same').show(); 
            } else {
                $('#sm_erreur_mdp_same').hide(); 
            }
        } else { //input mdp non vide
            if(mdp!=mdp_same) {
                $('#sm_erreur_mdp_same').show(); 
            } else {
                $('#sm_erreur_mdp_same').hide(); 
            }
        }
    });

    //INPUT NOM
    $( "#input_nom" ).focusout(function() { //input nom
        var nom = $( "#input_nom" ).val();
        nomError(nom);
    });
    $( "#input_nom" ).keyup(function() { //input nom
        var nom = $( "#input_nom" ).val();
        nomError(nom);
    });
    function nomError(nom) {
        if(checkNom(nom)=="empty") { // input vide
            $('#sm_erreur_nom_nbmax').hide();
            $('#sm_erreur_nom').show();
            return false;
        } else if(checkNom(nom)=="nom_max") {
            $('#sm_erreur_nom').hide();
            $('#sm_erreur_nom_nbmax').show();
            return false;
        } else { //nom valide
           
            $('#sm_erreur_nom').hide();
            $('#sm_erreur_nom_nbmax').hide();
            return true;
        }
    }
    //INPUT PRENOM
    $( "#input_prenom" ).focusout(function() { //input nom
        var prenom = $( "#input_prenom" ).val();
        prenomError(prenom);
    });
    $( "#input_prenom" ).keyup(function() { //input prenom
        var prenom = $( "#input_prenom" ).val();
        prenomError(prenom);
    });
    function prenomError(prenom) {
        if(checkNom(prenom)=="empty") { // input vide
           
            $('#sm_erreur_prenom_nbmax').hide();
            $('#sm_erreur_prenom').show();
            return false;
        } else if(checkNom(prenom)=="nom_max") {
            $('#sm_erreur_prenom').hide();
            $('#sm_erreur_prenom_nbmax').show();
            return false;
        } else { //prenom valide
            $('#sm_erreur_prenom').hide();
            $('#sm_erreur_prenom_nbmax').hide();
            return true;
        }
    }
     //DATE
     $( "#datepicker" ).focusout(function() { //input nom
        var date = $( "#datepicker" ).val();
       
        if(checkDate(date)==false) {
            $( "#datepicker" ).val("");
        }
       
    });
    /////////////////////////////////////////S'INSCRIR////////////////////////////////////////////////
       
    $( "#button_singin" ).click(function() { //input prenom
        var ok_mail=false;  //variable test
        var ok_mdp=false;
        var ok_mdp_same=false;
        var ok_nom=false;
        var ok_prenom=false;
        var ok_date=false;
        //MAIL
        
        var email = $( "#input_email" ).val();
        if(checkMail(email)=="empty") {
            $('#sm_erreur_email_exist').hide();//email exist
            $('#sm_erreur_email').hide();
            $('#sm_erreur_email_empty').show();
        }
        else if (checkMail(email)=="valid") { //email valide
            $('#sm_erreur_email_exist').hide();//email exist
            $('#sm_erreur_email').hide(); 
            ok_mail=true;
        } else {  //email invalide
            $('#sm_erreur_email_exist').hide();//email exist
            $('#sm_erreur_email_empty').hide(); //email obligatoir hide
            $('#sm_erreur_email').show();  //email non valide show
        }
        //MDP
        mdp_empty = false;
        var mdp = $( "#input_mdp" ).val();
        if(mdp=="") { //mot de passe vide
            $('#sm_erreur_mdp_nbmin').hide();
            $('#sm_erreur_mdp_nbmax').hide();
            $('#sm_erreur_mdp_empty').show();
            mdp_empty = true;
        } else { //nombre de caractaire
            if(mdp.length<8) { //minimum 8char
                $('#sm_erreur_mdp_empty').hide();
                $('#sm_erreur_mdp_nbmax').hide();
                $('#sm_erreur_mdp_nbmin').show();
            } else if(mdp.length>50) {  //maximum 50char
                $('#sm_erreur_mdp_empty').hide();
                $('#sm_erreur_mdp_nbmin').hide();
                $('#sm_erreur_mdp_nbmax').show();
            } else {
                $('#sm_erreur_mdp_empty').hide();
                $('#sm_erreur_mdp_nbmin').hide();
                $('#sm_erreur_mdp_nbmax').hide();
                ok_mdp=true;
            }
        } 

        //MDP SAME
        if(mdp_empty==false) { //input mdp non vide
            var mdp_same = $('#input_mdp_same').val();
            var mdp = $( "#input_mdp" ).val();
            if(mdp!=mdp_same) {
                $('#sm_erreur_mdp_same').show(); 
            } else {
                $('#sm_erreur_mdp_same').hide(); 
                ok_mdp_same=true;
            }
        } else { //input mdp nvide
            $('#sm_erreur_mdp_same').hide(); 
            
        }
        //NOM PRENOM
        var nom = $( "#input_nom" ).val();
        ok_nom = nomError(nom);
        var prenom = $( "#input_prenom" ).val();
        ok_prenom = prenomError(prenom);
        //DATE
        var date =  $( "#datepicker" ).val();
        ok_date =checkDate(date);
        /**console.log(ok_mail);
        console.log(ok_mdp);
        console.log(ok_mdp_same);
        console.log(ok_nom);
        console.log(ok_prenom);
        //console.log(ok_date);
        console.log("---------------------------------");**/
        if(ok_mail==true && ok_mdp==true && ok_mdp_same==true && ok_nom==true && ok_prenom==true && ok_date==true) {
            $( "#form_singin" ).submit();
        }
       
      
    });
    ///////////////////////////////////////SE CONNECTER///////////////////////////////////////
    $( "#button_login" ).click(function() { //input prenom
        var ok_mail=false;  //variable test
        var ok_mdp=false;
       
          //MAIL
        
          var email = $( "#input_email" ).val();
          if(checkMail(email)=="empty") {
              $('#sm_erreur_email_exist').hide();//email exist
              $('#sm_erreur_email').hide();
              $('#sm_erreur_email_empty').show();
          }
          else if (checkMail(email)=="valid") { //email valide
              $('#sm_erreur_email_exist').hide();//email exist
              $('#sm_erreur_email').hide(); 
              ok_mail=true;
          } else {  //email invalide
              $('#sm_erreur_email_exist').hide();//email exist
              $('#sm_erreur_email_empty').hide(); //email obligatoir hide
              $('#sm_erreur_email').show();  //email non valide show
          }
          //MDP
          var mdp = $( "#input_mdp" ).val();
          if(mdp=="") { //mot de passe vide
            $('#sm_erreur_mdp_false').hide();//mdp incorect
              $('#sm_erreur_mdp_nbmin').hide();
              $('#sm_erreur_mdp_nbmax').hide();
              $('#sm_erreur_mdp_empty').show();
          } else { //nombre de caractaire
              if(mdp.length<8) { //minimum 8char
                $('#sm_erreur_mdp_false').hide();//mdp incorect
                  $('#sm_erreur_mdp_empty').hide();
                  $('#sm_erreur_mdp_nbmax').hide();
                  $('#sm_erreur_mdp_nbmin').show();
              } else if(mdp.length>50) {  //maximum 50char
                $('#sm_erreur_mdp_false').hide();//mdp incorect
                  $('#sm_erreur_mdp_empty').hide();
                  $('#sm_erreur_mdp_nbmin').hide();
                  $('#sm_erreur_mdp_nbmax').show();
              } else {
                $('#sm_erreur_mdp_false').hide();//mdp incorect
                  $('#sm_erreur_mdp_empty').hide();
                  $('#sm_erreur_mdp_nbmin').hide();
                  $('#sm_erreur_mdp_nbmax').hide();
                  ok_mdp=true;
              }
          } 
          if(ok_mail==true && ok_mdp==true) {
            $( "#form_client" ).submit();
        }
    });
    ///////////////////////////////////////SE CONNECTER MENU///////////////////////////////////////
    $( "#button_loginmenu" ).click(function() { //input prenom
        var ok_mailmenu=false;  //variable test
        var ok_mdpmenu=false;
       
          //MAIL
        
          var email = $( "#input_emailmenu" ).val();
          if(checkMail(email)=="empty") {
              $('#sm_erreur_emailmn_exist').hide();//email exist
              $('#sm_erreur_emailmn').hide();
              $('#sm_erreur_emailmn_empty').show();
          }
          else if (checkMail(email)=="valid") { //email valide
              $('#sm_erreur_emailmn_exist').hide();//email exist
              $('#sm_erreur_emailmn').hide(); 
              ok_mailmenu=true;
          } else {  //email invalide
              $('#sm_erreur_emailmn_exist').hide();//email exist
              $('#sm_erreur_emailmn_empty').hide(); //email obligatoir hide
              $('#sm_erreur_emailmn').show();  //email non valide show
          }
          //MDP
          var mdp = $( "#input_mdpmenu" ).val();
          if(mdp=="") { //mot de passe vide
            $('#sm_erreur_mdpmn_false').hide();//mdp incorect
              $('#sm_erreur_mdpmn_nbmin').hide();
              $('#sm_erreur_mdpmn_nbmax').hide();
              $('#sm_erreur_mdpmn_empty').show();
          } else { //nombre de caractaire
              if(mdp.length<8) { //minimum 8char
                $('#sm_erreur_mdpmn_false').hide();//mdp incorect
                  $('#sm_erreur_mdpmn_empty').hide();
                  $('#sm_erreur_mdpmn_nbmax').hide();
                  $('#sm_erreur_mdpmn_nbmin').show();
              } else if(mdp.length>50) {  //maximum 50char
                $('#sm_erreur_mdpmn_false').hide();//mdp incorect
                  $('#sm_erreur_mdpmn_empty').hide();
                  $('#sm_erreur_mdpmn_nbmin').hide();
                  $('#sm_erreur_mdpmn_nbmax').show();
              } else {
                $('#sm_erreur_mdpmn_false').hide();//mdp incorect
                  $('#sm_erreur_mdpmn_empty').hide();
                  $('#sm_erreur_mdpmn_nbmin').hide();
                  $('#sm_erreur_mdpmn_nbmax').hide();
                  ok_mdpmenu=true;
              }
          } 
          if(ok_mailmenu==true && ok_mdpmenu==true) {
            $( "#form_client_menu" ).submit();
        }
    });
});
