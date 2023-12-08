<!DOCTYPE html>
<html>
    <head>
        <title>Lite Tech Info</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_general.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_admin.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/jquery-3.3.1.slim.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fontawesome-free-5.11.2-web/css/all.css">
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/script_admin.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/script_admin_caracteristique.js"></script>
        
    </head>
    <body>
        <!--MENU 1-->
        <?php $this->view("admin/include/navmenu.php"); ?>
        <!--MENU 2-->
        <section id="sct_component"><!--component-->
            <div>
                <h3>AJOUT Caractéristiques techniques Titre 1</h3>
                <form id="form_titre1" method="POST" action="<?php echo base_url(); ?>adminlti1379/FormFicheT1">
                    <label for="exampleFormControlInput1">CATEGORIE</label>
                    <div class="row">
                        <div class="col-md-4">
                            <select id="slt_cat" name="cat" class="form-control">                   
                                <?php if(isset($ID_CATEGORIE)) { ?><option value="<?php echo $ID_CATEGORIE; ?>"><?php echo $CTITRE; ?></option><?php } ?>
                                <option value="0">Categorie 1</option>
                                <?php foreach($bdd_cat as $bdd_cat) { ?>
                                    <option value="<?php echo $bdd_cat->ID_CATEGORIE; ?>"><?php echo $bdd_cat->CTITRE; ?></option>
                                <?php  } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                                <select  id="slt_scat" name="scat" class="form-control" <?php if(!isset($ID_S_CATEGORIE)) { ?>disabled<?php } ?>>
                            <?php if(isset($ID_S_CATEGORIE)) { ?><option value="<?php echo $ID_S_CATEGORIE; ?>"><?php echo $CSTITRE; ?></option><?php } ?>
                                <option value="0">Categorie 2</option>
                                <?php foreach($bdd_scat as $bdd_scat) { ?>
                                    <option value="<?php echo $bdd_scat->ID_S_CATEGORIE; ?>"><?php echo $bdd_scat->CSTITRE; ?></option>
                                <?php  } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select  id="slt_sscat" name="sscat" class="form-control" <?php if(!isset($ID_SS_CATEGORIE)) { ?>disabled<?php } ?>>
                            <?php if(isset($ID_SS_CATEGORIE)) { ?><option value="<?php echo $ID_SS_CATEGORIE; ?>"><?php echo $CSSTITRE; ?></option><?php } ?>
                                <option value="0">Categorie 3</option>
                                <?php foreach($bdd_sscat as $bdd_sscat) { ?>
                                    <option value="<?php echo $bdd_sscat->ID_SS_CATEGORIE; ?>"><?php echo $bdd_sscat->CSSTITRE; ?></option>
                                <?php  } ?>
                            </select>
                        </div>
                    </div>
                    <div id="sm_erreur_cat_empty" class="invalid-feedback">Vous devez indiquer les categories.</div>
                    <div id="sm_erreur_cat_max" class="invalid-feedback">Valeur trop long.</div>
                    <div>
                        <label for="exampleFormControlInput1">Caractéristiques Titre 1</label>
                        <div class="form-group">
                            <input type="text" name="titre1" class="form-control" id="input_t1" aria-describedby="emailHelp" placeholder="Titre 1"  disabled>
                            <div id="sm_erreur_t1_empty" class="invalid-feedback">Vous devez indiquer un titre.</div>
                            <div id="sm_erreur_t1_max" class="invalid-feedback">Valeur trop long.</div>
                            <div style="display:block" class="invalid-feedback"><?php echo form_error('titre1'); ?></div>
                            <div style="display:block" class="invalid-feedback"><?php if(isset($erreur_t1)) { echo $erreur_t1; } ?></div>
                        </div>
                    </div>
                    
                </form>
                <?php if(isset($ok_t1)) { ?><div id="sm_ok_t1" class="valid-feedback" style="display:block">Titre ajouter!</div><?php } ?>
                <button type="submit" id="button_titre1" class="btn btn-success">AJOUTER</button>
                <div> 
                    <h3>AJOUT Caractéristiques techniques Titre 2</h3>
                    <div>
                        <form id="form_titre2" method="POST" action="<?php echo base_url(); ?>adminlti1379/FormFicheT2">
                            <input type="hidden" id="hcat" name="hcat" value="">
                            <input type="hidden" id="hscat" name="hscat" value="">
                            <input type="hidden" id="hsscat" name="hsscat" value="">
                            <label for="exampleFormControlInput1">Caractéristiques Titre 1</label>
                            <select  id="slt_titre1" name="titre1" class="form-control" disabled>
                                <option value="0">Titre 2</option>
                            </select>
                            <div id="sm_erreur_sltt1_empty" class="invalid-feedback">Vous devez indiquer un titre 1.</div>
                            <div id="sm_erreur_sltt1_max" class="invalid-feedback">Valeur trop long.</div>
                            <div class="form-group">
                                <input type="text" name="titre2" class="form-control" id="input_t2" aria-describedby="emailHelp" placeholder="Titre 2" disabled>
                                <div id="sm_erreur_t2_empty" class="invalid-feedback">Vous devez indiquer un titre 2.</div>
                                <div id="sm_erreur_t2_max" class="invalid-feedback">Valeur trop long.</div>
                                <div style="display:block" class="invalid-feedback"><?php echo form_error('titre2'); ?></div>
                                <div style="display:block" class="invalid-feedback"><?php if(isset($erreur_t2)) { echo $erreur_t2; } ?></div>
                            </div>
                            <label for="exampleFormControlInput1">Parametre de Recherche</label>
                            <select  id="slt_recherche" name="recherche" class="form-control" disabled>
                                    <option value="false">Non</option>
                                    <option value="true">Oui</option>
                            </select>
                            <div id="sm_erreur_sltrech_empty" class="invalid-feedback">Lavaleur doit etre oui ou non.</div>
                            <div id="sm_erreur_sltrech_max" class="invalid-feedback">Valeur trop long.</div>
                          
                        </form>
                        <?php if(isset($ok_t2)) { ?><div id="sm_ok_t1" class="valid-feedback" style="display:block">Titre 2 ajouter!</div><?php } ?>
                        <button type="submit" id="button_titre2" class="btn btn-success">AJOUTER</button>
                    </div>
                  
               </div>
               <div id="fichetech"></div><!--FICHE TECHNIQUE-->
              
               <div style="text-align: center;font-size: 27px;" id="sm_erreur_ftech_empty" class="invalid-feedback">Fiche technique Vide <div id="erreur_append"></div></div>
              
               <script> ////////////////////SCRIPT SELECT CHANGE//////////////////////////////
                    $(function() {  
                        //Hidden
                        $('#hcat').val($('#slt_cat').val());
                         $('#hscat').val($('#slt_scat').val());
                         $('#hsscat').val($('#slt_sscat').val());
                        //change categorie
                        $('#slt_cat').change(function() {
                            if($(this).val()=="0") {
                                $("#slt_scat").html("<option value=\"0\">Categorie 2</option>");
                                $('#slt_scat').prop('disabled', 'disabled');
                                $("#slt_sscat").html("<option value=\"0\">Categorie 3</option>");
                                $('#slt_sscat').prop('disabled', 'disabled');
                                $('#input_t1').prop('disabled', 'disable');// input titre 1
                                 /*---TITRE 2--- */
                                 $('#slt_titre1').prop('disabled', 'disable');
                                 $('#input_t2').prop('disabled', 'disable');
                                 $('#slt_recherche').prop('disabled', 'disable');
                               
                            } else { //exist value
                                $('#slt_scat').prop('disabled', false);
                                $('#slt_scat').load('<?php echo base_url(); ?>adminlti1379/AjaxCategorie',{ ID_CATEGORIE:$(this).val(),ID_S_CATEGORIE:0, ref: 0}, function() {
                                    if($(this).val()=="0") { //si valeur == nul
                                        $("#slt_sscat").html("<option value=\"0\">VIDE</option>");
                                        $('#slt_sscat').prop('disabled', 'disabled');
                                        $('#input_t1').prop('disabled', 'disable'); // input titre 1
                                        /*---TITRE 2--- */
                                        $('#slt_titre1').prop('disabled', 'disable');
                                        $('#input_t2').prop('disabled', 'disable');
                                        $('#slt_recherche').prop('disabled', 'disable');

                                    } 
                                });
                            }
                            //HIDDEN
                            $('#hcat').val($(this).val());
                         });
                         //change sous categorie
                         //console.log($('#input_t2'));
                         $('#slt_scat').change(function() {  
                            if($(this).val()=="0") {
                                $("#slt_sscat").html("<option value=\"0\">Categorie 3</option>");
                                $('#slt_sscat').prop('disabled', 'disabled');
                                $('#input_t1').prop('disabled', 'disabled'); // input titre 1
                                 /*---TITRE 2--- */
                                 $('#slt_titre1').prop('disabled', 'disable');
                                $('#input_t2').prop('disabled', 'disable');
                                $('#slt_recherche').prop('disabled', 'disable');
                                $('#fichetech').hide()//fichetech
                            } else { //existe value
                                $('#slt_sscat').prop('disabled', false);
                                $( "#slt_sscat" ).load('<?php echo base_url(); ?>adminlti1379/AjaxCategorie',{ ID_CATEGORIE:$('#slt_cat').val(),ID_S_CATEGORIE:$(this).val(), ref: 1}, function() {
                                    if($(this).val()=="0") { //si valeur != nul
                                        $('#slt_sscat').prop('disabled', 'disabled');
                                        $('#input_t1').prop('disabled', 'disable'); // input titre 1
                                         /*---TITRE 2--- */
                                        $('#slt_titre1').prop('disabled', 'disable');
                                        $('#input_t2').prop('disabled', 'disable');
                                        $('#slt_recherche').prop('disabled', 'disable');
                                        $('#fichetech').hide()//fichetech
                                    } else {
                                        $('#input_t1').prop('disabled', false); // input titre 1
                                         /*---TITRE 2--- */ //load titre 2
                                         $('#slt_titre1').load('<?php echo base_url(); ?>adminlti1379/AjaxTitre',{ ID_SS_CATEGORIE:$('#slt_sscat').val() }, function() {
                                            if($(this).val()=="00") {
                                                $(this).prop('disabled', 'disable');
                                                $('#input_t2').prop('disabled', 'disable');
                                                $('#slt_recherche').prop('disabled', 'disable');
                                                $('#fichetech').hide()//fichetech
                                                /*---FICHE FIDE---*/
                                                $('#erreur_append').text(" pour "+$('#slt_sscat option:selected').text());
                                                $('#sm_erreur_ftech_empty').show();
                                            } else {
                                                $(this).prop('disabled', false);
                                                $('#input_t2').prop('disabled', false);
                                                $('#slt_recherche').prop('disabled', false);
                                                /****LOAD FICHE TECHNIQUE  */
                                                $('#fichetech').load('<?php echo base_url(); ?>adminlti1379/FormFicheTech',{ ID_SS_CATEGORIE:$('#slt_sscat').val() }, function() {
                                                    $('#sm_erreur_ftech_empty').hide();//FICHE FIDE
                                                    $(this).show();//fichetech
                                                    //ALL INPUT IN fichetech
                                                    var allinput = $(this).find('input');
                                                    var allinput2 = $('.cinput');
                                                    //console.log(allinput2.length); 
                                                    for ( var i = 0; i < allinput2.length; i++ ) {
                                                       // console.log(allinput[i]);
                                                        console.log($(allinput2[i]).val());
                                                    }
                                                    
                                                    
                                                });
                                            }
                                        });
                                    }
                                    $('#hsscat').val($(this).val());
                                    
                                });
                                                             
                            }

                            //HIDDEN
                            $('#hscat').val($(this).val());

                         }); 
                         //change sous sous categorie
                         $('#slt_sscat').change(function() {  
                            if($(this).val()!="0") { //si valeur != nul
                                $('#input_t1').prop('disabled', false); // input titre 1
                                /*---TITRE 2--- */
                                $('#slt_titre1').load('<?php echo base_url(); ?>adminlti1379/AjaxTitre',{ ID_SS_CATEGORIE:$('#slt_sscat').val() }, function() {
                                    if($(this).val()=="00") {
                                        $(this).prop('disabled', 'disable');
                                        $('#input_t2').prop('disabled', 'disable');
                                        $('#slt_recherche').prop('disabled', 'disable');
                                        $('#fichetech').hide()//fichetech
                                         /*---FICHE FIDE---*/
                                         $('#erreur_append').text(" pour "+$('#slt_sscat option:selected').text());
                                        $('#sm_erreur_ftech_empty').show();
                                    } else {
                                        $(this).prop('disabled', false);
                                        $('#input_t2').prop('disabled', false);
                                        $('#slt_recherche').prop('disabled', false);
                                        //FICHE TECH
                                        $('#fichetech').load('<?php echo base_url(); ?>adminlti1379/FormFicheTech',{ ID_SS_CATEGORIE:$('#slt_sscat').val() }, function() {
                                            $('#sm_erreur_ftech_empty').hide();//FICHE hide
                                            $(this).show();//fichetech
                                        });
                                    }
                                });
                            } else {
                                $('#input_t1').prop('disabled', 'disabled'); // input titre 1
                                /*---TITRE 2--- */
                                $('#slt_titre1').prop('disabled', 'disable');
                                $('#input_t2').prop('disabled', 'disable');
                                $('#slt_recherche').prop('disabled', 'disable');
                                $('#fichetech').hide()//fichetech
                            }
                            //HIDDEN
                            $('#hsscat').val($(this).val());
                         }); 
                         //hidden
                         if($('#slt_sscat').val()!="0") {
                            $('#slt_titre1').load('<?php echo base_url(); ?>adminlti1379/AjaxTitre',{ ID_SS_CATEGORIE:$('#slt_sscat').val() }, function() {
                                if($(this).val()=="00") {
                                    $(this).prop('disabled', 'disable');
                                    $('#input_t2').prop('disabled', 'disable');
                                    $('#slt_recherche').prop('disabled', 'disable');
                                    $('#fichetech').hide()//fichetech
                                     /*---FICHE FIDE---*/
                                    $('#erreur_append').text(" pour "+$('#slt_sscat option:selected').text());
                                    $('#sm_erreur_ftech_empty').show();
                                } else {
                                    $(this).prop('disabled', false);
                                    $('#input_t2').prop('disabled', false);
                                    $('#slt_recherche').prop('disabled', false);
                                     //FICHE TECH
                                     $('#fichetech').load('<?php echo base_url(); ?>adminlti1379/FormFicheTech',{ ID_SS_CATEGORIE:$('#slt_sscat').val() }, function() {
                                        $('#sm_erreur_ftech_empty').hide();//FICHE FIDE
                                        $(this).show();//fichetech
                                    });
                                }
                            });
                         }

                        
                    }); 
                </script>
            </div>
        </section>
            <div style="height:1000px">
                   
            </div>
    </body>
</html>