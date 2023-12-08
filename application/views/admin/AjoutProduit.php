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
        <script src="<?php echo base_url(); ?>assets/js/script_admin_produit.js"></script>
        
    </head>
    <body>
        <!--MENU 1-->
        <?php $this->view("admin/include/navmenu.php"); ?>
        <!--MENU 2-->
        <section id="sct_component"><!--component-->
            <div>
                <h3>AJOUT PRODUIT</h3>
                <form id="form_produit" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" name="designation" class="form-control" id="input_destn" aria-describedby="emailHelp" placeholder="Designation">
                        <div id="sm_erreur_des_empty" class="invalid-feedback">Vous devez indiquer un designation.</div>
                        <div id="sm_erreur_des_max" class="invalid-feedback">Valeur trop long.</div>
                        <div style="display:block" class="invalid-feedback"><?php echo form_error('designation'); ?></div>
                    </div>
                    <label for="exampleFormControlInput1">IMAGE</label>
                    <div class="row">
                        <div class="col-md-4 custom-file">
                            <input type="file"  name="img1" class="custom-file-input" id="input_img1">
                            <label id="lb_img1" class="custom-file-label" for="customFile">Image 1</label>
                        </div>
                        <div class="col-md-2 custom-file">
                            <input type="file"  name="img2" class="custom-file-input" id="input_img2">
                            <label id="lb_img2" class="custom-file-label" for="customFile">Image 2</label>
                        </div>
                        <div class="col-md-2 custom-file">
                            <input type="file"  name="img3" class="custom-file-input" id="input_img3">
                            <label id="lb_img3" class="custom-file-label" for="customFile">Image 3</label>
                        </div>
                        <div class="col-md-2 custom-file">
                            <input type="file"  name="img4" class="custom-file-input" id="input_img4">
                            <label id="lb_img4" class="custom-file-label" for="customFile">Image 4</label>
                        </div>
                        <div class="col-md-2 custom-file">
                            <input type="file"  name="img5" class="custom-file-input" id="input_img5">
                            <label id="lb_img5" class="custom-file-label" for="customFile">Image 5</label>
                        </div>
                    </div>
                    <div id="sm_erreur_img1" class="invalid-feedback">Pour Image 1 choisissez un image valide(.jpg/.png)</div>
                    <div id="sm_erreur_img2" class="invalid-feedback">Pour Image 2 choisissez un image valide(.jpg/.png)</div>
                    <div id="sm_erreur_img3" class="invalid-feedback">Pour Image 3 choisissez un image valide(.jpg/.png)</div>
                    <div id="sm_erreur_img4" class="invalid-feedback">Pour Image 4 choisissez un image valide(.jpg/.png)</div>
                    <div id="sm_erreur_img5" class="invalid-feedback">Pour Image 5 choisissez un image valide(.jpg/.png)</div>
                    
                  
                    <label for="exampleFormControlInput1">CATEGORIE</label>
                    <div class="row">
                        <div class="col-md-4">
                            <select id="slt_cat" name="cat" class="form-control">
                                <option value="0">Categorie 1</option>
                                <?php foreach($bdd_cat as $bdd_cat) { ?>
                                    <option value="<?php echo $bdd_cat->ID_CATEGORIE; ?>"><?php echo $bdd_cat->CTITRE; ?></option>
                                <?php  } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select  id="slt_scat" name="scat" class="form-control" disabled>
                                <option value="0">Categorie 2</option>
                                <?php foreach($bdd_scat as $bdd_scat) { ?>
                                    <option value="<?php echo $bdd_scat->ID_S_CATEGORIE; ?>"><?php echo $bdd_scat->CSTITRE; ?></option>
                                <?php  } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select  id="slt_sscat" name="sscat" class="form-control" disabled>
                                <option value="0">Categorie 3</option>
                                <?php foreach($bdd_sscat as $bdd_sscat) { ?>
                                    <option value="<?php echo $bdd_sscat->ID_SS_CATEGORIE; ?>"><?php echo $bdd_sscat->CSSTITRE; ?></option>
                                <?php  } ?>
                            </select>
                        </div>
                    </div>
                    <div id="test"></div>
                    
                    <div id="sm_erreur_cat_empty" class="invalid-feedback">Vous devez indiquer les categories.</div>
                    <div id="sm_erreur_cat_max" class="invalid-feedback">Valeur trop long.</div>
                       
                    <div class="form-group">
                        <input type="text" name="prix_achat" class="form-control" id="input_pxa" aria-describedby="emailHelp" placeholder="Prix d'achat">
                        <div id="sm_erreur_prxachat_empty" class="invalid-feedback">Vous devez indiquer un prix d'achat.</div>
                        <div id="sm_erreur_prxachat_max" class="invalid-feedback">Valeur non valide.</div>
                    </div>
                    <div class="form-group">
                        <input type="text" name="prix_vente" class="form-control" id="input_pxv" aria-describedby="emailHelp" placeholder="Prix de vente">
                        <div id="sm_erreur_prxvente_empty" class="invalid-feedback">Vous devez indiquer un prix de vente.</div>
                        <div id="sm_erreur_prxvente_max" class="invalid-feedback">Valeur non valide.</div>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="quantite" class="form-control" id="input_qt" aria-describedby="emailHelp" placeholder="Quantité">
                        <div id="sm_erreur_qt_empty" class="invalid-feedback">Vous devez indiquer la quantité du produit.</div>
                        <div id="sm_erreur_qt_max" class="invalid-feedback">Valeur invalide.</div>
                    </div>
                    <div class="form-group">
                        <input type="text" name="info" class="form-control" id="input_info" aria-describedby="emailHelp" placeholder="Info">
                        <div id="sm_erreur_info_empty" class="invalid-feedback">Vous devez indiquer l'information du produit.</div>
                        <div id="sm_erreur_info_max" class="invalid-feedback">Valeur trop long.</div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <textarea class="form-control" name="description" id="input_desc" rows="3"></textarea>
                        <div id="sm_erreur_desc_empty" class="invalid-feedback">Vous devez indiquer la description du produit.</div>
                        <div id="sm_erreur_desc_max" class="invalid-feedback">Valeur trop long.</div>
                       
                    </div>
                    <div>
                         <select id="slt_stat" name="statut" class="form-control">
                            <option value="0">Statut</option>
                            <option value="1">En stock</option>
                            <option value="2">Pas en stock</option>
                        </select>
                        <div id="sm_erreur_sscat_empty" class="invalid-feedback">Vous devez indiquer le statut du produit.</div>
                        <div id="sm_erreur_sscat_max" class="invalid-feedback">Valeur trop long.</div>
                    </div>
                    <div id="fichetech"></div><!--FICHE TECHNIQUE-->
                </form>
                
            </div>
            <?php if(isset($ok_produit)) { ?><div id="sm_ok_t1" class="valid-feedback" style="display:block">Produit ajouter!</div><?php } ?>
            <button type="submit" id="button_produit" class="btn btn-success">AJOUTER PRODUIT</button>
            <script> ////////////////////SCRIPT SELECT CHANGE//////////////////////////////
                $(function() {  
                        //change categorie
                        $('#slt_cat').change(function() {
                        if($(this).val()=="0") {
                            $("#slt_scat").html("<option value=\"0\">Categorie 2</option>");
                            $('#slt_scat').prop('disabled', 'disabled');
                            $("#slt_sscat").html("<option value=\"0\">Categorie 3</option>");
                            $('#slt_sscat').prop('disabled', 'disabled');
                        } else { //exist value
                            $('#slt_scat').prop('disabled', false);
                            $('#slt_scat').load('<?php echo base_url(); ?>adminlti1379/AjaxCategorie',{ ID_CATEGORIE:$(this).val(),ID_S_CATEGORIE:0, ref: 0}, function() {
                                if($(this).val()=="0") { //si valeur == nul
                                    $("#slt_sscat").html("<option value=\"0\">VIDE</option>");
                                    $('#slt_sscat').prop('disabled', 'disabled');
                                } 
                            });
                        }
                        });
                        //change sous categorie
                        $('#slt_scat').change(function() {  
                        if($(this).val()=="0") {
                            $("#slt_sscat").html("<option value=\"0\">Categorie 3</option>");
                            $('#slt_sscat').prop('disabled', 'disabled');
                        } else { //existe value
                            $('#slt_sscat').prop('disabled', false);
                            $( "#slt_sscat" ).load('<?php echo base_url(); ?>adminlti1379/AjaxCategorie',{ ID_CATEGORIE:$('#slt_cat').val(),ID_S_CATEGORIE:$(this).val(), ref: 1}, function() {
                                if($(this).val()=="0") { //si valeur != nul
                                    $('#slt_sscat').prop('disabled', 'disabled');
                                } else {
                                     /****LOAD FICHE TECHNIQUE  */
                                     $('#fichetech').load('<?php echo base_url(); ?>adminlti1379/FormFicheTechProduit',{ ID_SS_CATEGORIE:$('#slt_sscat').val(),CSSTITRE:$('#slt_sscat option:selected').text() }, function() {
                                        $(this).show();
                                    });
                                }
                            });
                                                            
                        }
                        });
                         //change sous sous categorie
                         $('#slt_sscat').change(function() { 
                            if($(this).val()!="0") {
                                /****LOAD FICHE TECHNIQUE  */
                                $('#fichetech').load('<?php echo base_url(); ?>adminlti1379/FormFicheTechProduit',{ ID_SS_CATEGORIE:$('#slt_sscat').val(),CSSTITRE:$('#slt_sscat option:selected').text() }, function() {
                                    $(this).show();
                                });
                            }
                         });
                }); 
            </script>
        </section>
            <div style="height:1000px">
                   
            </div>
    </body>
</html>