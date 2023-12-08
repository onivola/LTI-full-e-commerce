<!DOCTYPE html>
<html>
    <head>
        <title>Lite Tech Info</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_menu.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_general.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_fiche.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/jquery-3.3.1.slim.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fontawesome-free-5.11.2-web/css/all.css">
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/script.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/script_fiche.js"></script>
        
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
        <section id="sect_fiche">
            <div id="div_fiche">
                  <!--LIEN-->
                <?php include("include/lien.php"); ?> 
                <!--LIEN-->
                <?php foreach($bdd_produit as $bdd_produit) {  ?>
                <div> <!--FICHE-->
                    <div><!--NOM INFO-->
                        <h3 class="h_titre_fiche"><?php echo $bdd_produit->DESIGNATION; ?></h3>
                        <p class="p_info_fiche"><?php echo $bdd_produit->INFO; ?></p>
                    </div>
                    <div class="row"><!--IMAGE PRIX BAG-->
                        <div class="col-md-4"><!--image-->
                            <div><img id="larg_img" class="img_fiche" src="<?php echo base_url(); ?>uploads/produit/<?php echo $bdd_produit->ID_PRODUIT; ?>IMG1.jpg"/></div>
                            <div>
                                <ul id="ul_image">
                                    <li><a href="#"><img class="smal_img" src="<?php echo base_url(); ?>uploads/produit/<?php echo $bdd_produit->ID_PRODUIT; ?>IMG1.jpg"/></a></li>
                                    <li><a href="#"><img class="smal_img" src="<?php echo base_url(); ?>uploads/produit/<?php echo $bdd_produit->ID_PRODUIT; ?>IMG2.jpg"/></a></li>
                                    <li><a href="#"><img class="smal_img" src="<?php echo base_url(); ?>uploads/produit/<?php echo $bdd_produit->ID_PRODUIT; ?>IMG3.jpg"/></a></li>
                                    <li><a href="#"><img class="smal_img" src="<?php echo base_url(); ?>uploads/produit/<?php echo $bdd_produit->ID_PRODUIT; ?>IMG4.jpg"/></a></li>
                                    <li><a href="#"><img class="smal_img" src="<?php echo base_url(); ?>uploads/produit/<?php echo $bdd_produit->ID_PRODUIT; ?>IMG5.jpg"/></a></li>
                                </ul>
                                
                            </div>
                            <script>
                            $(function() { //quand le document est pret
                                var smallimg = $('.smal_img');
                                console.log(smallimg[0]);
                                for(var i=0;i<smallimg.length;i++) {
                                    (function(i){
                                        $(smallimg[i]).mouseenter(function(){ //evenement click
                                            $('#larg_img').attr('src','<?php echo base_url(); ?>uploads/produit/<?php echo $bdd_produit->ID_PRODUIT; ?>IMG'+(i+1)+'.jpg');
                                        })
                                    })(i);
                                }
                            });
                            </script>
                        </div>
                        <div class="col-md-5"> <!--DESCRIPTION-->
                            <p class="p_dscp"><?php echo $bdd_produit->DESCRIPTION; ?></p>
                        </div>
                        <div class="col-md-3"><!--PRIX QUANTITE BAG-->
                            <div>    
                                <div class="div_price_fiche"><?php echo $bdd_produit->PRIX_VENTE; ?> Ar</div>
                                <div id="div_quantit">
                                    <?php if($bdd_produit->QUANTITE>0) { ?>
                                    <form id="form_quantit" name="form_quantite" method="POST" action="<?php echo base_url(); ?>Fiche/AjoutPanier">  
                                        <span>Quantite</span>
                                            <select name="QUANTITE">
                                                <?php for($i=1;$i<=$bdd_produit->QUANTITE;$i++) { ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                <?php } ?>
                                            </select>
                                            <input type="hidden" name="ID_PRODUIT" value="<?php echo $bdd_produit->ID_PRODUIT; ?>"/>
                                            <input type="hidden" name="ID_CATEGORIE" value="<?php echo $bdd_produit->ID_CATEGORIE; ?>"/>
                                            <input type="hidden" name="ID_S_CATEGORIE" value="<?php echo $bdd_produit->ID_S_CATEGORIE; ?>"/>
                                            <input type="hidden" name="ID_SS_CATEGORIE" value="<?php echo $bdd_produit->ID_SS_CATEGORIE; ?>"/>
                                    </form>
                                    <?php } ?>
                                </div>
                                <div id="div_add"><button onClick=form_quantite.submit() type="button" class="btn btn-success">AJOUTER AU PANIER</button></div>
                                <div id="div_dsp_stk">
                                    <div id="div_dispo"><a>DISPONIBILITE SITE:</a></div>
                                    <?php if($bdd_produit->QUANTITE>0) { ?><div id="div_stock"><a>EN STOCK</a></div><?php } else { ?>
                                    <div style="color:#dc3545" id="div_stock"><a>EPUISE</a></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <div>
                <?php } ?>
            </div>
           <div> <!--FICHE TECHNIQUE-->
               
                <?php 
                if($bdd_count>0) { ?>
                <div id="div_title_ft"><h3> Caractéristiques techniques</h3></div>
                <div>
                    <table class="table table-bordered">
                        <?php $nbid=1; foreach($bdd_fichet1 as $bdd_fichet1) { 
                            $tbdd_fichet2 = $bdd_fichet2[$bdd_fichet1->ID_FICHE_TQ_TITRE];
                            $tbdd_fichet2first = $bdd_fichet2[$bdd_fichet1->ID_FICHE_TQ_TITRE];
                            $nbrow = count($tbdd_fichet2);
                            if($nbrow>0) {
                        ?>
                            <tr>
                                <td rowspan="<?php echo $nbrow; ?>"><?php echo $bdd_fichet1->FTITRE; ?></td>
                                <?php foreach($tbdd_fichet2first as $tbdd_fichet2first) { ?>
                                    <td><?php echo $tbdd_fichet2first->FSTITRE; ?></td>
                                    <td><?php echo $tbdd_fichet2first->VALEUR; ?></td>    
                                <?php break; } ?>
                            </tr>
                            <?php $i=0; foreach($tbdd_fichet2 as $tbdd_fichet2) { ?>
                                <?php if($i>0) { ?>
                                <tr>
                                    <td><?php echo $tbdd_fichet2->FSTITRE; ?></td>
                                    <td><?php echo $tbdd_fichet2->VALEUR; ?></td>
                                </tr>
                                <?php } ?>
                            <?php $nbid++; $i++; } ?>

                        <?php } } ?>
                    
                    
                    </table>
                </div>
                <?php } else { ?>
                <?php } ?>
           </div>
        </section>
        <section>
		<!--FOOTER 1-->
        <?php $this->view("include/footer.php"); ?>
		<!--FOOTER 2-->
        </section>
    </body>
</html>

