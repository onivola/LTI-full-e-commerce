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
        <script src="<?php echo base_url(); ?>assets/js/script_admin_categorie.js"></script>
        
    </head>
    <body>
        <!--MENU 1-->
        <?php $this->view("admin/include/navmenu.php"); ?>
        <!--MENU 2-->
        <section id="sct_component"><!--component-->
            <div>
                <h3>AJOUT CATEGORIE</h3>
                <form id="form_cat" method="Post"  action="<?php echo base_url(); ?>adminlti1379/FormCategorie" class="fm_all">
                    <div class="form-group">
                        <input type="text"name="categorie" class="form-control" id="input_categorie" placeholder="Categorie 1">
                        <div id="sm_erreur_cat_empty" class="in_error invalid-feedback">Vous devez indiquer un categorie 1.</div>
                        <div id="sm_erreur_cat_max" class="in_error invalid-feedback">Valeur trop long.</div>
                        <div style="display:block" class="invalid-feedback"><?php echo form_error('categorie'); ?></div>
                       
                        <?php if(isset($ok_cat)) { ?><div class="valid-feedback" style="display:block">Categorie 1 ajouter!</div><?php } ?>
                    </div>
                   
                </form>
                <button id="button_categorie" type="submit" class="btn btn-success">AJOUTER</button>
            </div>
            <div>
                <h4>AJOUT SOUS CATEGORIE</h4>
                <form id="form_scat" method="Post"  action="<?php echo base_url(); ?>adminlti1379/FormSCategorie">
                    <div class="form-group">
                        <select id="slt_categorie" class="form-control form-control-lg"  name="id_categorie">
                            <option value="0">Categorie 1</option>
                            <?php $bdd_cat2 = $bdd_cat; foreach($bdd_cat as $bdd_cat) { ?>
                            <option value="<?php echo $bdd_cat->ID_CATEGORIE; ?>"><?php echo $bdd_cat->CTITRE; ?></option>
                            <?php  } ?>
                        </select>
                        <div id="sm_erreur_sltcat_empty" class="in_error invalid-feedback">Vous devez indiquer un Categorie 1.</div>
                    </div>
                    <div class="form-group">
                        <input type="text"name="scategorie" class="form-control" id="input_scategorie" placeholder="Categorie 2">
                        <div id="sm_erreur_scat_empty" class="in_error invalid-feedback">Vous devez indiquer un Categorie 2.</div>
                        <div id="sm_erreur_scat_max" class="in_error invalid-feedback">Valeur trop long.</div>
                        <div style="display:block" class="invalid-feedback"><?php if(isset($error_scat)) { echo "Categorie 2 deja existant"; } ?></div>
                        <?php if(isset($ok_scat)) { ?><div class="valid-feedback" style="display:block">Categorie 2 ajouter!</div><?php } ?>
                    </div>
              </form>
              <button id="button_scategorie" type="submit" class="btn btn-success">AJOUTER</button>
            
            </div>
            <div>
                <h4>AJOUT SOUS SOUS CATEGORIE</h4>
                <form id="form_sscat" method="Post" action="<?php echo base_url(); ?>adminlti1379/FormSSCategorie">
                    <div class="form-group">
                        <select id="slt_categorie2" class="form-control form-control-lg" name="id_categorie">
                            <option value="0" >Categorie 1</option>
                            <?php foreach($bdd_cat2 as $bdd_cat2) { ?>
                            <option value="<?php echo $bdd_cat2->ID_CATEGORIE; ?>"><?php echo $bdd_cat2->CTITRE; ?></option>
                            <?php  } ?>
                        </select>
                        <div id="sm_erreur_sltcat2_empty" class="in_error invalid-feedback">Vous devez indiquer un Categorie 1.</div>
                
                    </div>
                    <?php //var_dump($bdd_scat); ?>
                    <div class="form-group">
                        <select id="slt_scategorie" class="form-control form-control-lg" name="id_scategorie" disabled>
                            <option value="0">Categorie 2</option>
                            <?php foreach($bdd_scat as $bdd_scat) { ?>
                            <option value="<?php echo $bdd_scat->ID_S_CATEGORIE; ?>"><?php echo $bdd_scat->CSTITRE; ?></option>
                            <?php  } ?>
                        </select>
                        <div id="sm_erreur_sltscat_empty" class="in_error invalid-feedback">Vous devez indiquer un Categorie 2.</div>
                
                    </div>
                    <script> ////////////////////SCRIPT SELECT CHANGE//////////////////////////////
                    $(function() {  
                        //change categorie
                        $('#slt_categorie2').change(function() {
                            if($(this).val()=="0") {
                                $("#slt_scategorie").html("<option value=\"0\">CATEGORIE 2</option>");
                                $('#slt_scategorie').prop('disabled', 'disabled');
                            } else {
                                $('#slt_scategorie').prop('disabled', false);
                                $('#slt_scategorie').load('<?php echo base_url(); ?>adminlti1379/AjaxCategorie',{ ID_CATEGORIE:$(this).val(),ID_S_CATEGORIE:0, ref: 0});
                            }
                         });
                    }); 
                    </script>
                    <div class="form-group">
                        <input type="text" name="sscategorie" class="form-control" id="input_sscategorie" placeholder="Categorie 3"><div id="sm_erreur_scat_empty" class="in_error invalid-feedback">Vous devez indiquer un categorie 2.</div>
                        <div id="sm_erreur_sscat_empty" class="in_error invalid-feedback">Vous devez indiquer un categorie 3.</div>
                        <div id="sm_erreur_sscat_max" class="in_error invalid-feedback">Valeur trop long.</div>
                        <div style="display:block" class="invalid-feedback"><?php if(isset($error_scat2)) { echo "Sous sous categorie deja existant"; } ?></div>
                        <?php if(isset($ok_scat2)) { ?><div class="valid-feedback" style="display:block">Categorie 3 ajouter!</div><?php } ?>
                    </div>
                 </form>
                <button id="button_sscategorie" type="submit" class="btn btn-success">AJOUTER</button>
            
            </div>
          
        </section>
            <div style="height:1000px">
                   
            </div>
    </body>
</html>