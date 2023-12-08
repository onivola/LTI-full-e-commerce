<!DOCTYPE html>
<html>
    <head>
        <title>Lite Tech Info</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_menu.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_general.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_connexion.css">
       
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/jquery-3.3.1.slim.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fontawesome-free-5.11.2-web/css/all.css">
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
     
        <script src="<?php echo base_url(); ?>assets/js/script.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/script_connexion.js"></script>
        
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
       <section id="sect_connexion">
            <div id="div_connexion">
                <div id="div_form_login">
                    <h3 id="h_identifier">CREATION DU COMPTE</h3>
                    <div>
                        <h4 id="h_client">DEJA CLIENT ?</h4>
                        <div id="div_client">
                            <form id="form_client" method="POST" action="<?php echo base_url(); ?>connexion">
                                <div>
                                    <input  id="input_email"  class="form-control"  type="text" name="email" value="<?php if(!isset($success)) { echo set_value('email'); } ?>" placeholder="Email" autocomplete="off"/>
                                    <small id="sm_erreur_email" class="sm_error form-text">Veuillez entrer un email valide.</small>
                                    <small id="sm_erreur_email_empty" class="sm_error form-text">Vous devez indiquer votre adresse email.</small>
                                   <small id="sm_erreur_email_exist" style="display:block;" class="sm_error form-text"> <?php if(isset($error_email)) {  echo $error_email; } ?></small>
                                </div>
                               
                                <div>
                                    <input  id="input_mdp" class="form-control" type="password" name="mdp" placeholder="Mot de passe" autocomplete="off"/>
                                    <small id="sm_erreur_mdp_nbmin" class="sm_error form-text">Le mot de passe doit avoir au moins 8 caractères.</small>
                                    <small id="sm_erreur_mdp_nbmax" class="sm_error form-text">Le mot de passe doit avoir au maximum 50 caractères.</small>
                                    <small id="sm_erreur_mdp_empty" class="sm_error form-text">Vous devez indiquer un mot de passe.</small>
                                     <small style="display:block;" id="sm_erreur_mdp_false" class="sm_error form-text"><?php if(isset($error_mdp)) {  echo $error_mdp; } ?></small>
                                    
                                </div>
                               
                                <div class="div_button"><button  id="button_login" type="button" class="btn btn-success">CONNEXION</button></div>
                                <p id="p_forget_mdp"><a href="#">Vous avez oublie votre mot de passe</a></p>
                            </form>
                        </div>
                        
                        <div>
                            <h4 id="h_nclient">NOUVEAU CLIENT ?</h4>
                            <div class="div_button"><a href="<?php echo base_url(); ?>registre"><button type="button"  class="btn btn-success">CREER UN COMPTE</button></a></div>
                        </div>
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

