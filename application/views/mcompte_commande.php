
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
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
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
                <?php if(count($db_facture)>0) { //si facture non null ?>
                <h3 id="h_coord" class="h_titre">HISTORIQUE DE VOS COMMANDES</h3>
                <div>
                <?php //var_dump($db_facture) ; 
                    foreach($db_facture as $db_facture) { //boucle facture
                ?>
                    <table class="tab_commande">
                        <thead>
                            <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Nº commande</th>
                            <th scope="col">Montant</th>
                            <th scope="col">Paiement</th>
                            <th scope="col">Statut</th>
                            <th scope="col">Autre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $db_facture->DATE_FACTURE; ?></td>
                                <th><?php echo $db_facture->REFERENCE; ?></th>
                                <td><?php echo $db_facture->PRIX_TOTAL; ?> Ar TTC</td>
                                <td><?php echo $db_facture->TYPE_PAIEMENT; ?></td>
                                <td><?php echo $db_facture->STATUT; ?></td>
                                <td>détails</td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <table style="width: 100%;">
                                        <?php $frais = 0; $totalttc=0; foreach($db_dtlfacture[$db_facture->ID_FACTURE] as $db_dtlfacture) { ?>
                                        <tr>
                                            <td style="width: 179px; text-align: center;"><img height="80px" src="<?php echo base_url(); ?>uploads/produit/<?php echo $db_dtlfacture->ID_PRODUIT; ?>IMG1.jpg"/></td>
                                            <td style="width: 412px;"><?php echo $db_dtlfacture->DESIGNATION_DF; ?></td>
                                            <th style="width: 100px;" scope="col">x<?php echo $db_dtlfacture->QUANTITE_DF; ?></th>
                                            <th scope="col"><?php echo $db_dtlfacture->QUANTITE_DF*$db_dtlfacture->PRIX_DF; ?> Ar</th>
                                        </tr>
                                        <?php 
                                        $totalttc= $totalttc + ($db_dtlfacture->QUANTITE_DF*$db_dtlfacture->PRIX_DF);
                                        $frais=$db_dtlfacture->FRAIS_DF; } ?>
                                    </table>
                                    <table style="width: 100%;">
                                        <tr> 
                                            <td style="width: 438px;">
                                                <table style="width: 100%;">
                                                    <tr>
                                                        <td width= "166px">Mode de livraison :</td>
                                                        <th>Livraison à domicile</th>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            <?php if($db_adresse[$db_facture->ID_FACTURE]->CIVILITE_LV=='Homme') { echo 'M. '; } else { echo 'Mme. '; } ?><?php echo $db_adresse[$db_facture->ID_FACTURE]->NOM_LV." ".$db_adresse[$db_facture->ID_FACTURE]->PRENOM_LV; ?>
                                                            <?php echo $db_adresse[$db_facture->ID_FACTURE]->ADRESSE." ".$db_adresse[$db_facture->ID_FACTURE]->VILLE." ".$db_adresse[$db_facture->ID_FACTURE]->CODE_POSTAL; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            <a style="font-size: 13px" class="text-danger a_annul" id="asdf" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" >Annuler la commande</a>
                                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Annuler la facture: <?php echo $db_facture->REFERENCE; ?></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <form method="POST" action="<?php echo base_url(); ?>Moncompte/AnnulerCommande" id="fm_annuler<?php echo $db_facture->ID_FACTURE; ?>">
                                                                                <label for="exampleInputPassword1">Mot de passe</label>
                                                                                <input id="input_mdp<?php echo $db_facture->ID_FACTURE; ?>" name="mdp" type="password" class="form-control" id="exampleInputPassword1">
                                                                                <div id="dv_change<?php echo $db_facture->ID_FACTURE; ?>">
                                                                                    <div id="dv_error<?php echo $db_facture->ID_FACTURE; ?>" class="invalid-feedback">
                                                                                        Entrer votre mot de passe
                                                                                    </div>
                                                                                    <div id="dv_errormdp<?php echo $db_facture->ID_FACTURE; ?>" class="invalid-feedback">
                                                                                        Mot de passe incorrect
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div id="dv_indice<?php echo $db_facture->ID_FACTURE; ?>" style="display:none"></div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button id="bt_annuler<?php echo $db_facture->ID_FACTURE; ?>" type="button" class="btn btn-primary">VALIDER</button>
                                                                    </div>
                                                                    <script>
                                                                        $(function() {  
                                                                            $('#bt_annuler<?php echo $db_facture->ID_FACTURE; ?>').click(function() {
                                                                                if($('#input_mdp<?php echo $db_facture->ID_FACTURE; ?>').val()=="") {
                                                                                    $('#dv_error<?php echo $db_facture->ID_FACTURE; ?>').show();
                                                                                    $('#dv_errormdp<?php echo $db_facture->ID_FACTURE; ?>').hide();
                                                                                } else {
                                                                                    $('#dv_error<?php echo $db_facture->ID_FACTURE; ?>').hide();
                                                                                    $('#dv_indice<?php echo $db_facture->ID_FACTURE; ?>').load('<?php echo base_url(); ?>Moncompte/AnnulerCommande',{mdp:$('#input_mdp<?php echo $db_facture->ID_FACTURE; ?>').val(),id_facture:<?php echo $db_facture->ID_FACTURE; ?>}, function() { //send table
                                                                                        var indice = $('#dv_indice<?php echo $db_facture->ID_FACTURE; ?>').text();
                                                                                        indice = parseInt(indice);
                                                                                        console.log(indice);
                                                                                        if(indice==0) {
                                                                                            $('#dv_errormdp<?php echo $db_facture->ID_FACTURE; ?>').show();
                                                                                        } else {
                                                                                            $('#dv_errormdp<?php echo $db_facture->ID_FACTURE; ?>').hide();
                                                                                            window.location.replace("<?php echo base_url(); ?>Moncompte/Commande");
                                                                                        }
                                                                                    });
                                                                                    //$('#exampleModal').modal('hide');
                                                                                }
                                                                            });
                                                                        }); 
                                                                    </script>
                                                                </div>
                                                                </div>
                                                          </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                <table style="width: 100%;">
                                                    <tr>
                                                        <td style="width: 240px;">Frais de port :</td>
                                                        <th scope="col"><?php echo $frais; ?> Ar</th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="col">TOTAL DE LA COMMANDE :</th>
                                                        <th scope="col"><?php echo $totalttc+$frais; ?></th>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
                <?php } else { ?>
                <div class="text-secondary" id="dv_messagevide">Votre commande est vide</div>
                <?php } ?>
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