
<!DOCTYPE html>
<html>
    <head>
        <title>Lite Tech Info</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_menu.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_general.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_index.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_commande.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/jquery-3.3.1.slim.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fontawesome-free-5.11.2-web/css/all.css">
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/script_commande.js"></script>
        
    </head>
    <body>
        <header>
            <section>
            <!--MENU 1-->
            <?php $this->view("include/menu-1.php"); ?>
            <!--MENU 2-->
            </section>
            <section>
                <div id="div_logo_search">
                    <div id="div_logo">
                    <a href="<?php echo base_url(); ?>">
                        <img src="<?php echo base_url(); ?>img/logo/logo-v3.png" height="60px" alt="">
                    </a>
                    </div>
                </div>
            </section>
        </header>
        <section id="sct_commande">
            <div> <!--LIVRAISON-->
                <div class="div_titre">
                   <h3 class="h_titre">LIVRAISON A DOMICILE</h3>
               </div>
               <div>
                    <form>
                        <input id="input_url" type="hidden" value="<?php echo base_url(); ?>"/>
                        <table  id="tb_infopers">
                            <tr>
                                <td></td>
                                <td class="td_ipinput">
                                    <div id="dv_checkcivilit" style="width: 36%;margin: 0 auto;">
                                        <input  type="radio" id="input_m" name="checkcivilite" id="exampleRadios2" value="Homme" <?php if($db_utilisateur->CIVILITE=="Homme") { ?> checked <?php } ?>>
                                        <label style="margin: 0px 20px 0 8px;">M.</label>
                                        <input  type="radio" id="input_mme" name="checkcivilite" id="exampleRadios2" value="Femme" <?php if($db_utilisateur->CIVILITE=="Femme") { ?> checked <?php } ?>>
                                        <label style="margin: 0px 0px 0 8px;">Mme.</label>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Nom</td>
                                <td class="td_ipinput"><input id="input_nom" value="<?php echo $db_utilisateur->NOM; ?>" class="form-control form-control-sm" type="text" placeholder=""></td>
                                <td>
                                    <div id="sm_erreur_nom" class="invalid-feedback">Vous devez indiquer votre nom.</div>
                                    <div id="sm_erreur_nom_nbmax" class="invalid-feedback">Le nom ne doit pas dépasser 50 caractères.</div>
                                </td>
                            </tr>
                            <tr>
                                <td>Prénom</td>
                                <td class="td_ipinput"><input id="input_prenom" value="<?php echo $db_utilisateur->PRENOM; ?>" class="form-control form-control-sm" type="text" placeholder=""></td>
                                <td>
                                    <div id="sm_erreur_prenom" class="invalid-feedback">Vous devez indiquer votre nom.</div>
                                    <div id="sm_erreur_prenom_nbmax" class="invalid-feedback">Le nom ne doit pas dépasser 50 caractères.</div>
                                </td>
                            </tr>
                            <tr>
                                <td>Ville du destination</td>
                                <td class="td_ipinput">
                                    <select id="select_ville" class="form-control form-control-sm">
                                        <?php foreach($db_villetarif as $db_villetarif) { ?>
                                        <option><?php echo $db_villetarif->ville;  ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>frais: à partir de 4000 Ar</td>
                            </tr>
                            <tr>
                                <td>Adresse</td>
                                <td class="td_ipinput"><input id="input_adresse" class="form-control form-control-sm" type="text" placeholder=""></td>
                                <td>
                                    <div id="sm_erreur_adress" class="invalid-feedback">Vous devez indiquer votre adresse.</div>
                                    <div id="sm_erreur_adress_nbmax" class="invalid-feedback">Le champ ne doit pas dépasser 200 caractères.</div>
                                </td>
                            </tr>
                            <tr>
                                <td>Complément d'adresse</td>
                                <td class="td_ipinput"><input id="input_cadresse" class="form-control form-control-sm" type="text" placeholder=""></td>
                                <td>
                                    <div id="sm_erreur_cadress" class="invalid-feedback">Le champ est obligatoire.</div>
                                    <div id="sm_erreur_cadress_nbmax" class="invalid-feedback">Le champ ne doit pas dépasser 200 caractères.</div>
                                </td>
                            </tr>
                            <tr>
                                <td>Code postal</td>
                                <td class="td_ipinput"><input id="input_cpostal" class="form-control form-control-sm" type="text" placeholder=""></td>
                                <td>
                                    <div id="sm_erreur_cpost" class="invalid-feedback">Le champ est obligatoire.</div>
                                    <div id="sm_erreur_cpost_nbmax" class="invalid-feedback">Le champ ne doit pas dépasser 50 caractères.</div>
                                </td>
                            </tr>
                            <tr>
                                <td>Téléphone</td>
                                <td class="td_ipinput"><input id="input_tel" class="form-control form-control-sm" type="text" placeholder=""></td>
                                <td>
                                    <div id="sm_erreur_tel" class="invalid-feedback">Vous devez indiquer votre numero téléphone.</div>
                                    <div id="sm_erreur_tel_nbmax" class="invalid-feedback">Le champ ne doit pas dépasser 50 caractères.</div>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <div class="dv_btip" id="dv_dtipvalid"><button id="button_livrado" type="button" class="btn btn-success btn-sm">VALIDER</button></div>
                    <div style="display:none;" id="dv_btipedit" class="dv_btip"><button id="button_livradoedit" type="button" class="btn btn-success btn-sm">MODIFIER</button></div>
               </div>
            </div>
            <div id="ajaxpaiement"><!--PAYEMENT-->
            </div>
        </section>
        <section>
            <!--FOOTER 1-->
            <?php $this->view("include/footer.php"); ?>
            <!--FOOTER 2-->
        </section>
    </body> 
</html>