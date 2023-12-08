<!DOCTYPE html>
<html>
    <head>
        <title>Lite Tech Info</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_menu.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_general.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_panier.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/jquery-3.3.1.slim.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fontawesome-free-5.11.2-web/css/all.css">
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/script.js"></script>
        
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
       <section id="sect_panier">
           <?php if(isset($bdd_panier) AND !empty($bdd_panier)) { ?>
           <div id="div_le_panier">
               <div id="div_vtrpanier">
                   <h3 id="h_vtrpanier">VOTRE PANIER</h3>
               </div>
               <div><!--TABLE PANIER-->
                    
                   <div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <td width="104px"></td>
                                    <td>DESIGNATION</td>
                                    <td>PRIX</td>
                                    <td>QUANTITE</td>
                                    <td>SOUS-TOTAL</td>
                                    <td>DELL</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $totalttc = 0; $iq=1; foreach($bdd_panier as $bdd_panier)  { ?>
                                
                                <tr>
                                    <th><a href="<?php echo base_url(); ?>Fiche/Produit/<?php echo $bdd_panier->ID_PRODUIT; ?>"><img class="img_ppanier" src="<?php echo base_url(); ?>uploads/produit/<?php echo $bdd_panier->ID_PRODUIT; ?>IMG1.jpg"/></a></th>
                                    <td>
                                        <div><h3 class="h_title_tab"><?php echo $bdd_panier->DESIGNATION; ?></h3></div>
                                        <div class="div_stock_tab"><a>QUANTITE: <?php echo $bdd_panier->QUANTITE_PN; ?></a></div>
                                        <!--<div class="div_stock_tab"><a>STOCK WEB:</a></div>
                                        <div class="div_enstock_tab"><a>EN STOCK</a></div>!-->
                                    </td>
                                    <td><div class="div_prix_tab tab_marg"><?php echo $bdd_panier->PRIX_VENTE; ?> Ar</div></td>
                                    <td>
                                        <form method="POST" id="form_quantite<?php echo $iq; ?>" action="<?php echo base_url(); ?>Panier/EditQuantite">
                                            <select id="slt_quanite<?php echo $iq; ?>" class="slct_qtt" name="QUANTITE_PN">
                                                <option value="<?php echo $bdd_panier->QUANTITE_PN; ?>"><?php echo $bdd_panier->QUANTITE_PN; ?></option>    
                                                <?php for($i=1;$i<=$bdd_quantitepnpd[$bdd_panier->ID_PANIER];$i++) { ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                <?php } ?>
                                            </select>
                                            <input type="hidden" name="ID_PRODUIT" value="<?php echo $bdd_panier->ID_PRODUIT; ?>"/>
                                        </form>
                                        <script>
                                            $(function() { //quand le document est pret
                                                $('#slt_quanite<?php echo $iq; ?>').change(function() {
                                                    $('#form_quantite<?php echo $iq; ?>').submit();
                                                });
                                            });
                                        </script>
                                    </td>
                                    <td><div class="div_sprix_tab tab_marg"><?php echo $bdd_panier->PRIX_VENTE*$bdd_panier->QUANTITE_PN; ?> Ar</div></td>
                                    <td><a href="<?php echo base_url(); ?>Panier/DelletPanier/<?php echo $bdd_panier->ID_PRODUIT; ?>"><i class="fas fa-trash-alt"></i></a></td>
                                </tr>
                                <?php $totalttc = $totalttc + $bdd_panier->QUANTITE_PN*$bdd_panier->PRIX_VENTE; $iq++; } ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>TOTAL TTC</td>
                                    <td><?php echo $totalttc; ?> Ar</td>
                                    <td><a href="<?php echo base_url(); ?>Commande"><button type="button" class="btn btn-success">PASSER COMMANDE</button></a></td>
                                </tr>
                            </tbody>
                        </table>
                        

                   </div>
                    
               </div>
           </div>
           <?php } else { ?>
            <div>
                <h4 class="text-danger" style="text-align: center;margin: 245px 0;">VOTRE PANIER EST VIDE</h4>
            </div>
           <?php } ?>
       </section>
       <section>
		<!--FOOTER 1-->
        <?php $this->view("include/footer.php"); ?>
		<!--FOOTER 2-->
        </section>
    </body>
</html>

