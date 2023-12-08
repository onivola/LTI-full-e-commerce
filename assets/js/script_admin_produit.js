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
    function checkImg(value) {
        var ext = value.slice(value.length-4,value.length); //.JPG//,PNG
        if(ext==".jpg" || ext==".JPG") {
            //alert("OK");
            return true;
        } else {
            return false;
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
    function checkPrice(value) {
        var prix = parseInt(value);
        if(value=="") { //prix vide
              return "empty";
        } else if(prix>0 && prix <=1000000000000000) { //prix valide   
            return "valide"
        } else { //prix non valide
           return "invalide";
        }
    }
    function checkInfo(value) {
        if(value=="") {
            return "empty";
        }
        else if(value.length>250) {
            return "max";
        } else {
            return "valide";
        }
    }
    function checkDsctn(value) {
        if(value=="") {
            return "empty";
        }
        else if(value.length>1000) {
            return "max";
        } else {
            return "valide";
        }
    }
    //CATEGORIE FORM
    $('#button_produit').click(function() {
        //VALUE OF INPUT && SELECT
        var ok_dstn=false;
        var input_dstn = $('#input_destn').val();
        var ok_cat=false;
        var input_cat = $('#slt_cat').val();
        var input_scat = $('#slt_scat').val();
        var input_sscat = $('#slt_sscat').val();
        var ok_pxa=false;
        var input_pxa = $('#input_pxa').val();
        var ok_pxv=false;
        var input_pxv = $('#input_pxv').val();
        var ok_qt=false;
        var input_qt = $('#input_qt').val();
        var ok_info=false;
        var input_info = $('#input_info').val();
        var ok_desc=false;
        var input_desc = $('#input_desc').val();
        var ok_stat=false;
        var input_stat= $('#slt_stat').val();

        var ok_img1 = false;
        var input_img1 = $('#input_img1').val();
        var ok_img2 = false;
        var input_img2 = $('#input_img2').val();
        var ok_img3 = false;
        var input_img3 = $('#input_img3').val();
        var ok_img4 = false;
        var input_img4 = $('#input_img4').val();
        var ok_img5 = false;
        var input_img5 = $('#input_img5').val();
        
        /**------------------DESIGNATION-------------------* */
        if(checkVal(input_dstn)=="empty") {
            $('#sm_erreur_des_max').hide();
            $('#sm_erreur_des_empty').show();
        } else if(checkVal(input_dstn)=="max") {
            $('#sm_erreur_des_empty').hide();
            $('#sm_erreur_des_max').show();
        }  else if(checkVal(input_dstn)=="valide") {
            ok_dstn=true;
            $('#sm_erreur_des_empty').hide();
            $('#sm_erreur_des_max').hide();
         }
         /**-----------------IMAGE--------------------------- */
         if(checkImg(input_img1)) {
            $('#sm_erreur_img1').hide();
            ok_img1 = true;
        } else {
            $('#sm_erreur_img1').show();
            
        }

        if(checkImg(input_img2)) {
            $('#sm_erreur_img2').hide();
            ok_img2 = true;
        } else {
            $('#sm_erreur_img2').show();
           
        }

        if(checkImg(input_img3)) {
            $('#sm_erreur_img3').hide();
            ok_img3 = true;
        } else {
            $('#sm_erreur_img3').show();
            
        }

        if(checkImg(input_img4)) {
            $('#sm_erreur_img4').hide();
            ok_img4 = true;
        } else {
            $('#sm_erreur_img4').show();
            
        }

        if(checkImg(input_img5)) {
            $('#sm_erreur_img5').hide();
            ok_img5 = true;
        } else {
            $('#sm_erreur_img5').show();
            
        }
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
          /**------------------PRIX ACHAT-------------------* */
          if(checkPrice(input_pxa)=="empty") {
            $('#sm_erreur_prxachat_max').hide();
            $('#sm_erreur_prxachat_empty').show();
        } else if(checkPrice(input_pxa)=="invalide") {
            $('#sm_erreur_prxachat_empty').hide();
            $('#sm_erreur_prxachat_max').show();
        }  else if(checkVal(input_pxa)=="valide") {
            ok_pxa=true;
            $('#sm_erreur_prxachat_empty').hide();
            $('#sm_erreur_prxachat_max').hide();
         }
           /**------------------PRIX VENTE-------------------* */
           if(checkPrice(input_pxv)=="empty") {
            $('#sm_erreur_prxvente_max').hide();
            $('#sm_erreur_prxvente_empty').show();
        } else if(checkPrice(input_pxv)=="invalide") {
            $('#sm_erreur_prxvente_empty').hide();
            $('#sm_erreur_prxvente_max').show();
        }  else if(checkVal(input_pxv)=="valide") {
            ok_pxv=true;
            $('#sm_erreur_prxvente_empty').hide();
            $('#sm_erreur_prxvente_max').hide();
         }
         /**------------------QUANTITE-------------------* */
         if(checkPrice(input_qt)=="empty") {
            $('#sm_erreur_qt_max').hide();
            $('#sm_erreur_qt_empty').show();
        } else if(checkPrice(input_qt)=="invalide") {
            $('#sm_erreur_qt_empty').hide();
            $('#sm_erreur_qt_max').show();
        }  else if(checkVal(input_qt)=="valide") {
            ok_qt=true;
            $('#sm_erreur_qt_empty').hide();
            $('#sm_erreur_qt_max').hide();
         }

           /**------------------INFO-------------------* */
        if(checkInfo(input_info)=="empty") {
            $('#sm_erreur_info_max').hide();
            $('#sm_erreur_info_empty').show();
        } else if(checkInfo(input_info)=="max") {
            $('#sm_erreur_info_empty').hide();
            $('#sm_erreur_info_max').show();
        }  else if(checkInfo(input_info)=="valide") {
            ok_info=true;
            $('#sm_erreur_info_empty').hide();
            $('#sm_erreur_info_max').hide();
         }
            /**------------------DESCRIPTION-------------------* */
        if(checkDsctn(input_desc)=="empty") {
            $('#sm_erreur_desc_max').hide();
            $('#sm_erreur_desc_empty').show();
        } else if(checkDsctn(input_desc)=="max") {
            $('#sm_erreur_desc_empty').hide();
            $('#sm_erreur_desc_max').show();
        }  else if(checkDsctn(input_desc)=="valide") {
            ok_desc=true;
            $('#sm_erreur_desc_empty').hide();
            $('#sm_erreur_desc_max').hide();
         }
             /**------------------STATUT-------------------* */
        if(checkSltVal(input_stat)=="empty") {
            $('#sm_erreur_sscat_max').hide();
            $('#sm_erreur_sscat_empty').show();
        } else if(checkSltVal(input_stat)=="max") {
            $('#sm_erreur_sscat_empty').hide();
            $('#sm_erreur_sscat_max').show();
        }  else if(checkSltVal(input_stat)=="valide") {
            ok_stat=true;
            $('#sm_erreur_sscat_empty').hide();
            $('#sm_erreur_sscat_max').hide();
         }
         /*----------------------FICHE TECHNIQUE---------------* */
         var allfchinput = $('.cinput');
         var fch_count_ok = 0;
         for ( var i = 1; i <= allfchinput.length; i++ ) {
            var temp_fcnb = $("#input_fcnb"+i);
            if(checkVal(temp_fcnb.val())=="empty" || checkVal(temp_fcnb.val())=="max") {
                temp_fcnb.css('border-color', '#dc3545'); //border rouge
            }  else if(checkVal(temp_fcnb.val())=="valide") {
                fch_count_ok++;
                temp_fcnb.css('border-color', '#28a745'); //border vert
            }
         }
         //console.log(fch_count_ok+"et"+allfchinput.length);
         //SUBMIT AJOUT PRODUIT
         if(ok_dstn==true && ok_img1 == true && ok_img2==true && ok_img3==true && ok_img4==true && ok_img5==true && ok_cat==true && ok_pxa==true && ok_pxv==true && ok_qt==true && ok_info==true && ok_desc==true && ok_stat==true && fch_count_ok==allfchinput.length) {
            $( "#form_produit" ).submit();
         }
    });
    //SOUS CATEGORIE FORM
   
    /**$('#button_upload').click(function() {
        var ok_img1 = false;
        var input_img1 = $('#input_img1').val();
        var ok_img2 = false;
        var input_img2 = $('#input_img2').val();
        var ok_img3 = false;
        var input_img3 = $('#input_img3').val();
        var ok_img4 = false;
        var input_img4 = $('#input_img4').val();
        var ok_img5 = false;
        var input_img5 = $('#input_img5').val();
        //alert(input_img1);
        if(checkImg(input_img1)) {
            $('#sm_erreur_img1').hide();
            ok_img1 = true;
        } else {
            $('#sm_erreur_img1').show();
            
        }

        if(checkImg(input_img2)) {
            $('#sm_erreur_img2').hide();
            ok_img2 = true;
        } else {
            $('#sm_erreur_img2').show();
           
        }

        if(checkImg(input_img3)) {
            $('#sm_erreur_img3').hide();
            ok_img3 = true;
        } else {
            $('#sm_erreur_img3').show();
            
        }

        if(checkImg(input_img4)) {
            $('#sm_erreur_img4').hide();
            ok_img4 = true;
        } else {
            $('#sm_erreur_img4').show();
            
        }

        if(checkImg(input_img5)) {
            $('#sm_erreur_img5').hide();
            ok_img5 = true;
        } else {
            $('#sm_erreur_img5').show();
            
        }
        if(ok_img1 == true && ok_img2==true && ok_img3==true && ok_img4==true && ok_img5==true) {
            $( "#form_upload" ).submit();
        }
        
    });**/
    
});