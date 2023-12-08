<!DOCTYPE html>
<html>
    <head>
        <title>Lite Tech Info</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_menu.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_general.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_connexion.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/jquery-3.3.1.slim.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fontawesome-free-5.11.2-web/css/all.css">
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/script.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/script_connexion.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
        
    </head>
    <body>
        <header>
            <section>
            <!--MENU 1-->
            <?php $this->view("include/menu-1.php"); ?>
            <!--MENU 2-->
            </section>
            <section>
                <?php $this->view("include/menu-2.php"); ?>
            </section>
        </header>
       
       <section id="sect_registre">
            <div id="div_registre">
                <div id="div_form">
                    <h3 id="h_crcompte">CREATION DU COMPTE</h3>
                    <div>
                        <form method="POST" id="form_singin" name="form_singin" id="form_singin">
                            <h4 class="h_identifiants">IDENTIFIANTS:</h4>
                            <div class="div_listinput">
                                <div>
                                    <input id="input_email" class="form-control" type="text" name="email" value="<?php if(!isset($success)) { echo set_value('email'); } ?>" placeholder="Email" autocomplete="off"/>
                                    <small id="sm_erreur_email" class="sm_error form-text">Veuillez entrer un email valide.</small>
                                    <small id="sm_erreur_email_empty" class="sm_error form-text">Vous devez indiquer votre adresse email.</small>
                                    <small id="sm_erreur_email_exist" class="sm_error form-text"><?php echo form_error('email'); ?></small> 
                                </div>
                                <div>
                                    <input id="input_mdp"class="form-control" type="password" name="mdp" placeholder="Mot de passe" autocomplete="off"/>
                                    <small id="sm_erreur_mdp_nbmin" class="sm_error form-text">Le mot de passe doit avoir au moins 8 caractères.</small>
                                    <small id="sm_erreur_mdp_nbmax" class="sm_error form-text">Le mot de passe doit avoir au maximum 50 caractères.</small>
                                    <small id="sm_erreur_mdp_empty" class="sm_error form-text">Vous devez indiquer un mot de passe.</small>
                                </div>
                                <div>
                                    <input id="input_mdp_same" class="form-control" type="password" name="mdp_same" placeholder="Mot de passe" autocomplete="off"/>
                                    <small id="sm_erreur_mdp_same" class="sm_error form-text">Les mots de passe saisis doivent être identiques.</small>
                                </div>
                            </div>
                            <h4 class="h_identifiants">INFORMATIONS PERSONNELLES:</h4>
                            <div class="div_listinput">
                                <div id="div_civilit">
                                    <div id="div_m"> <div id="div_m_input"><input class="form-check-input" type="radio" name="civilite" id="exampleRadios1" value="homme" checked></div><div id="div_m_title">M.</div></div>
                                    <div id="div_mme"> <div id="div_mme_input"><input class="form-check-input" type="radio" name="civilite" id="exampleRadios1" value="femme"></div><div id="div_mme_title">Mme</div></div>
                                </div>
                                <div>
                                    <input id="input_nom" class="form-control" type="text" name="nom" value="<?php if(!isset($success)) { echo set_value('nom'); } ?>" placeholder="Nom de famille" autocomplete="off"/>
                                    <small id="sm_erreur_nom" class="sm_error form-text">Vous devez indiquer votre nom.</small>
                                    <small id="sm_erreur_nom_nbmax" class="sm_error form-text">Le nom ne doit pas dépasser 50 caractères.</small>
                                </div>
                                <div>
                                    <input id="input_prenom" class="form-control" type="text" name="prenom" placeholder="Prenom" value="<?php if(!isset($success)) { echo set_value('prenom'); } ?>" autocomplete="off"/>
                                    <small id="sm_erreur_prenom" class="sm_error form-text">Vous devez indiquer votre prenom.</small>
                                    <small id="sm_erreur_prenom_nbmax" class="sm_error form-text">Le prenom ne doit pas dépasser 50 caractères.</small>
                               </div>
                                <div>
                                    <input id="datepicker" class="form-control" type="text" name="date" value="<?php if(!isset($success)) { echo set_value('date'); } ?>" placeholder="Date de naissance ( yy-mm-jj )"/>
                                    <small id="sm_erreur_date" class="sm_error form-text">We'll never share your email with anyone else.</small>
                                </div>
                                <script>
                                    $( function() { //configuration jquery-ui.js > this._defaults
                                        $( "#datepicker" ).datepicker({
                                            changeMonth: true,
                                            changeYear: true
                                          });
                                        $( "#datepicker" ).datepicker( "option", "dateFormat","yy-mm-dd");
                                    });
                                </script>
                            </div>
                            <?php /** echo form_error('mdp'); ?>
                            <?php echo form_error('mdp_same'); ?>
                            <?php echo form_error('nom'); ?>
                            <?php echo form_error('prenom'); */ ?>
                            <div id="div_button_sing"><button type="button" id="button_singin" class="btn btn-success">VALIDER</button></div>
                        </form>
                    </div>
                </div>
            </div>
           </div>
       </section>
       <section>
		<!--FOOTER 1-->
        <?php $this->view("include/footer.php"); ?>
		<!--FOOTER 2-->
        </section>
    </body>
</html>

