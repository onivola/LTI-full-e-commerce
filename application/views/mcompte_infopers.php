
<!DOCTYPE html>
<html>
<head>
	<title>Lite Tech Info</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_menu.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_general.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_index.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_mcompte.css">
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
<section>
    <div id="dv_mcompte" class="row">
        <div class="col-md-3">
            <div id="div_profilmenu">
                <div id="div_profil">
                    <h5>Bonjour</h5>
                    <h5>Henry Justin</h5>
                    <h5>Nº client : IFRAJUSTHE000</h5>
                    <div><a href="<?php echo base_url(); ?>Connexion/deconnection"><button type="button" class="btn btn-outline-success">DECONNECTER</button></a></div>
                </div>
                <div class="list-group">
                <a href="<?php echo base_url()."Moncompte"; ?>" class="list-group-item list-group-item-action">Mes informations</a>
                <a href="<?php echo base_url()."Moncompte/Commande"; ?>" class="list-group-item list-group-item-action">Mes commandes</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div>
                <h3 id="h_coord" class="h_titre">COORDONNÉES</h3>
                <div>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="dv_nomprenom">
                                <div style="width: 41%;margin: 0 auto;">
                                    <input type="radio" id="input_m" name="checkcivilite" value="Homme" disabled <?php if($db_utilisateur->CIVILITE=="Homme") { ?>checked<?php } ?>>
                                    <label style="margin: 0px 20px 0 8px;">M.</label>
                                    <input type="radio" id="input_mme" name="checkcivilite" value="Femme" disabled <?php if($db_utilisateur->CIVILITE=="Femme") { ?>checked<?php } ?>>
                                    <label style="margin: 0px 0px 0 8px;">Mme.</label>
                                </div>       
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Nom:</label>
                                    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="" value="<?php echo $db_utilisateur->NOM; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Prénom:</label>
                                    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="" value="<?php echo $db_utilisateur->PRENOM; ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="dv_emaildate">
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Email:</label>
                                    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="" value="<?php echo $db_utilisateur->EMAIL; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Date de naissance:</label>
                                    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="" value="<?php echo $db_utilisateur->DATE_DE_NAISSANCE; ?>" disabled>	
                                </div>
                            </div>
                        </div>
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