<!DOCTYPE html>
<html>
    <head>
        <title>Lite Tech Info</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_menu.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_general.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_produit.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/jquery-3.3.1.slim.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fontawesome-free-5.11.2-web/css/all.css">
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/script.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/script_connexion.js"></script>
        <!--PRICE RANGER-->
        <script src="<?php echo base_url(); ?>assets/js/pricerange/jquery-ui.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/pricerange/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/pricerange/style.css">
        
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
        <section id="sct_produit">
            <div id="div_produit">
                <!--LIEN-->
                <?php include("include/lien.php"); ?> 
                <!--LIEN-->
                <div id="div_ajxpf">
                    <div>
                    <?php if($bdd_flt_stitre!=0) { ?>
                        <div id="dv_filtre" class="d-inline-block align-top"><!--RECHERCHE AVANCER-->
                            <h6 id="h_filtre" class="text-center">FILTRER LES PRODUITS</h6>
                            <div id="dv_motcles">
                                
                                <h6 id="h_motcles">RECHERCHE PAR MOT CLES</h6>
                                <input id="in_keysearch" type="search" class="form-control form-control-sm" id="inputEmail3" placeholder="Désignation, modèle ...">
                               
                                <script>
                                $( function() {
                                    $("#in_keysearch" ).keypress(function( event ) {
                                        if(event.which==13 && $("#in_keysearch" ).val()!="") { //enter press with value
                                             var idtitre="SKEY", valeur=$("#in_keysearch" ).val();
                                            $('#div_ajxpf').load('<?php echo base_url(); ?>Produit/AjxFiltre',{'valeur[]':valeur,id_stitre:idtitre,id_categorie:<?php echo $ID_CATEGORIE ?>,id_s_categorie:<?php echo $ID_S_CATEGORIE ?>,id_ss_categorie:<?php echo $ID_SS_CATEGORIE ?> }, function() { //send table
                                            //$(this).show();
                                            });
                                        }
                                    });
                                });
                                </script>
                            </div>
                            <!--PRICE RANGER-->
                            <div>
                                <div class="bg-success dv_fltr_titre"><a href="#" class="text-white text-uppercase a_fltr_titre">PRIX</a></div>
                                <p style="margin: 10px;">
                                    <input type="text" id="amount" readonly="readonly" style="border:0; color:green; font-size: 14px; font-weight:bold;" value="$83 - $156">
                                </p>

                                <div style="margin: 0 19px 23px 19px;" id="slider-range" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                                    <span id="left_range" tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 16.6%;"></span>
                                    <span id="right_range" tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 31.2%;"></span>
                                </div>
                                <div style="display:none" id="db_price_valider" class="dv_fltr_valider"><button id="bt_price_valider"  type="button" class="btn btn-success btn-sm btt_fltr_valider">VALIDER</button></div>
                            </div>
                            <script>
                            $( function() {
                                var valueleft=<?php echo $leftprice; ?>,valueright=<?php echo $rightprice; ?>;
                                $( "#slider-range" ).slider({
                                    range: true,
                                    min: <?php echo $leftprice; ?>,
                                    max: <?php echo $rightprice; ?>,
                                    values: [ valueleft, valueright ],
                                    slide: function( event, ui ) {
                                        $( "#amount" ).val(ui.values[ 0 ] + " - " + ui.values[ 1 ]+" Ar");
                                    }
                                });
                                $( "#amount" ).val($( "#slider-range" ).slider( "values", 0 ) +
                                    " - " + $( "#slider-range" ).slider( "values", 1 )+" Ar" );

                                var rdown=false;  var ldown=false; var rgdown=false;
                                $("#left_range").mousedown(function() {
                                    ldown=true;
                                    //console.log($( "#slider-range" ).slider( "values", 0 ));
                                    //console.log(valueleft);
                                  
                                });
                                $("#right_range").mousedown(function() {
                                    rdown=true;
                                   // console.log($( "#slider-range" ).slider( "values", 1 ));
                                    //console.log(valueright);
                                  
                                });
                                $("#slider-range").mousedown(function() {
                                    rgdown=true;
                                    //console.log(valueright);
                                  
                                });
                                $("body").mouseup(function() {
                                    if(ldown==true || rdown==true ||  rgdown==true) 
                                    {  
                                        var leftvalue = $( "#slider-range" ).slider( "values", 0 ),rightvalue = $( "#slider-range" ).slider( "values", 1 );
                                        ldown=false;
                                        rdown=false;
                                        rgdown=false;
                                        if(valueleft!=leftvalue || valueright!=rightvalue) { //show button valide
                                            $("#db_price_valider" ).fadeIn(); 
                                        } else { //hide button
                                            $("#db_price_valider" ).fadeOut();
                                        }
                                    }
                                });
                                //---------valider
                                $( "#bt_price_valider" ).click(function() { //clique produit
                                    var leftvalueb = $( "#slider-range" ).slider( "values", 0 ),rightvalueb = $( "#slider-range" ).slider( "values", 1 ); //les valeur choisi
                                    var valueprice = []; var idtitre='PRICE';
                                    valueprice[0] = leftvalueb;
                                    valueprice[1] = rightvalueb;
                                    //console.log(valueprice);
                                    $('#div_ajxpf').load('<?php echo base_url(); ?>Produit/AjxFiltre',{'valeur[]': valueprice,id_stitre:idtitre,id_categorie:<?php echo $ID_CATEGORIE ?>,id_s_categorie:<?php echo $ID_S_CATEGORIE ?>,id_ss_categorie:<?php echo $ID_SS_CATEGORIE ?> }, function() { //send table
                                            //$(this).show();
                                    });
                                });
                               
                            });
                            </script>
                            <!--FILTRE-->
                            <?php $i=0; foreach($bdd_flt_stitre as $bdd_flt_stitre) { ?>
                            <div class="div_fltr_lst">
                                <div class="bg-success dv_fltr_titre"><a href="#" class="text-white text-uppercase a_fltr_titre"><?php echo $bdd_flt_stitre->FSTITRE; ?></a></div>
                                <form method="GET" id="form_fltr<?php echo $i; ?>">
                                    <input type="hidden" id="ipt_idstr<?php echo $i; ?>" name="id_stitre" value="<?php echo $bdd_flt_stitre->ID_FICHE_TQ_STITRE; ?>"/>
                                    <input type="hidden" id="ipt_idcat<?php echo $i; ?>" name="id_categorie" value="<?php echo $ID_CATEGORIE; ?>"/>
                                    <input type="hidden" id="ipt_idscat<?php echo $i; ?>" name="id_s_categorie" value="<?php echo $ID_S_CATEGORIE; ?>"/>
                                    <input type="hidden" id="ipt_idsscat<?php echo $i; ?>" name="id_ss_categorie" value="<?php echo $ID_SS_CATEGORIE; ?>"/>
                                    <ul class="ul_fltr_check">
                                        
                                        <?php 
                                         //----------------- TRI SESSION NULL------------------
                                         if(!isset($bdd_flt_nbvaleur)) {
                                        ?>
                                        <?php 
                                        $bdd_value = $bdd_flt_value[$bdd_flt_stitre->ID_FICHE_TQ_STITRE]; $ci=0; 
                                        foreach($bdd_value as $bdd_value) { 
                                        if($bdd_value->NB_VALEUR>0) {
                                        ?>
                                        <li> 
                                            
                                            <input id="flt_check<?php echo $i; ?>" class="form-check-input" type="checkbox" name="valeur<?php echo $bdd_flt_stitre->ID_FICHE_TQ_STITRE."-".$ci; ?>" value="<?php echo $bdd_value->VALEUR; ?>"  id="defaultCheck1">
                                            
                                            <label class="form-check-label label_fltr" for="defaultCheck1">
                                                <?php echo $bdd_value->VALEUR." (".$bdd_value->NB_VALEUR.")"; ?>
                                            </label>
                                        </li>
                                        <?php   $ci++; } } ?>
                                        <?php  //----------------- TRI SESSION NOT NULL------------------
                                        } else {
                                        ?>
                                        <?php
                                        $bdd_value = $bdd_flt_value[$bdd_flt_stitre->ID_FICHE_TQ_STITRE]; $ci=0; 
                                        foreach($bdd_value as $bdd_value) { ?>
                                        <li> 
                                            
                                        <input id="flt_check<?php echo $i; ?>" class="form-check-input" type="checkbox" 
                                        <?php
                                        if(isset($tbidvaleur[$bdd_flt_stitre->ID_FICHE_TQ_STITRE])) { 
                                            for($iv=0;$iv<count($tbidvaleur[$bdd_flt_stitre->ID_FICHE_TQ_STITRE]);$iv++) {
                                                if($tbidvaleur[$bdd_flt_stitre->ID_FICHE_TQ_STITRE][$iv]==$bdd_value->VALEUR) {
                                                    echo "checked";
                                                }
                                            } 
                                        }
                                        ?>
                                        name="valeur<?php echo $bdd_flt_stitre->ID_FICHE_TQ_STITRE."-".$ci; ?>" value="<?php echo $bdd_value->VALEUR; ?>"  id="defaultCheck1">
                                            
                                            <label class="form-check-label label_fltr" for="defaultCheck1">
                                                <?php echo $bdd_value->VALEUR." (".$bdd_flt_nbvaleur[$bdd_flt_stitre->ID_FICHE_TQ_STITRE][$bdd_value->VALEUR].")"; ?>
                                            </label>
                                        </li>
                                        <?php   $ci++; } ?>
                                        <?php } ?>
                                    </ul>
                                </form>
                                <div style="display:none" id="db_fltr_valider<?php echo $i; ?>" class="dv_fltr_valider"><button id="bt_fltr_valider<?php echo $i; ?>"  type="button" class="btn btn-success btn-sm btt_fltr_valider">VALIDER</button></div>
                            </div>
                            <script>
                                $(function() { 
                                    $('#flt_check<?php echo $i; ?>[type=checkbox]').click(function(){
                                        var nb = $( "#flt_check<?php echo $i; ?>:checked" ).length;
                                       
                                       
                                        if(nb>0) {
                                            $("#db_fltr_valider<?php echo $i; ?>" ).fadeIn();
                                           
                                        } else {
                                            $("#db_fltr_valider<?php echo $i; ?>" ).fadeOut();
                                        }
                                    });
                                    /*---------------BOUTON VALIDER-----------**/
                                    $( "#bt_fltr_valider<?php echo $i; ?>" ).click(function() { //clique produit
                                        var checked= $("#flt_check<?php echo $i; ?>:checked" );
                                        var tbchecked = [];
                                        for(var i=0;i<checked.length;i++) {
                                            tbchecked[i]=$(checked[i]).val(); 
                                        }
                                        $('#div_ajxpf').load('<?php echo base_url(); ?>Produit/AjxFiltre',{'valeur[]': tbchecked,id_stitre:$('#ipt_idstr<?php echo $i; ?>').val(),id_categorie:$('#ipt_idcat<?php echo $i; ?>').val(),id_s_categorie:$('#ipt_idscat<?php echo $i; ?>').val(),id_ss_categorie:$('#ipt_idsscat<?php echo $i; ?>').val() }, function() { //send table
                                            //$(this).show();
                                        });
                                    });
                                
                                });
                            </script>
                            <?php $i++; } ?>
                            <!--FILTRE-->
                        
                        </div>
                        <?php } ?>
                        <div id="dv_produitrie" class="d-inline-block align-top">
                            <?php 
                                $nb_produit = count($bdd_produit);
                               
                            ?>
                            <div class="row"><!--TRIER PRODUIT -->
                                    <div class="col-lg-3">
                                        <?php  if($nb_produit>0) { ?>
                                        <form id="fm_slt_tri">
                                            <select id="slt_tri" name="trier">
                                               <?php if(!isset($tri)) { ?>
                                                <option value="0" selected="selected">Trier</option>
                                                <option value="new" >Par nouveautés</option>
                                                <option value="priceasc">Prix: croissant</option>
                                                <option value="pricedesc">Prix: décroissant</option>
                                                <option value="stock">En stock</option>
                                               <?php } else if(isset($tri)) { ?>
                                                <option value="<?php echo $tri; ?>">
                                                <?php
                                                    if($tri=='new') { echo 'Par nouveautés'; }
                                                    if($tri=='priceasc') { echo 'Prix: croissant'; }
                                                    if($tri=='pricedesc') { echo 'Prix: décroissant'; }
                                                    if($tri=='stock') { echo 'En stock'; }
                                                ?></option>
                                                <?php if($tri!='new') { ?><option value="new" >Par nouveautés</option><?php } ?>
                                                <?php if($tri!='priceasc') { ?> <option value="priceasc">Prix: croissant</option><?php } ?>
                                                <?php if($tri!='pricedesc') { ?><option value="pricedesc">Prix: décroissant</option><?php } ?>
                                                <?php if($tri!='stock') { ?><option value="stock">En stock</option><?php } ?>
                                               <?php } ?>
                                            <select>
                                            <script>
                                                $(function() { 
                                                    $('#slt_tri').change(function() {
                                                        var value = $(this).val();
                                                        console.log('ok');
                                                        $('#div_ajxpf').load('<?php echo base_url(); ?>Produit/AjxFiltre',{'valeur[]':value,id_stitre:'TRI',id_categorie:<?php echo $ID_CATEGORIE ?>,id_s_categorie:<?php echo $ID_S_CATEGORIE ?>,id_ss_categorie:<?php echo $ID_SS_CATEGORIE ?> }, function() { //send table
                                                            //$(this).show();
                                                            
                                                        });
                                                       
                                                     });
                                                });
                                            </script>
                                        </form>
                                            <?php } ?>
                                    </div>
                                    <div class="col-lg-6"></div>
                                    <div class="col-lg-3"><p id="p_nb_result">Il y a <?php echo $nb_produit; ?> produit<?php if($nb_produit>1) { echo 's'; } ?></p></div>
                               
                            </div>
                            <div id="div_hfiltre"><!--FILTRE HISTORIQUE-->
                                <?php 
                                if(isset($stbvaleur)) { 
                                for($i=0;$i<count($stbvaleur);$i++) { ?>
                                <div class="border border-success sp_htltr"><?php echo $stbvaleur[$i]; ?><i id="i_valnb<?php echo $i; ?>" class="fas fa-times text-danger"></i></div>
                                <script>
                                    $(function() { 
                                        $('#i_valnb<?php echo $i; ?>').click(function(){
                                            var val = '<?php echo $stbvaleur[$i]; ?>';
                                            $('#div_ajxpf').load('<?php echo base_url(); ?>Produit/AjxFiltreDellet',{id_categorie:<?php echo $ID_CATEGORIE; ?>,id_s_categorie:<?php echo $ID_S_CATEGORIE; ?>,id_ss_categorie:<?php echo $ID_SS_CATEGORIE; ?>,dellvaleur:val }, function() { //send table
                                            //$(this).show();
                                            });
                                        });
                                    });
                                </script>
                                <?php } } ?>
                             </div>
                            <div> <!--LIST PRODUIT-->

                                <?php 
                                 if($bdd_produit!=null && $nb_produit>0) { 
                                foreach($bdd_produit as $bdd_produit) { ?>
                                <div class="row">
                                    <div class="col-md-2"><a href="<?php echo base_url(); ?>Fiche/Produit/<?php echo $bdd_produit->ID_PRODUIT; ?>"><img height="150px" src="<?php echo base_url(); ?>uploads/produit/<?php echo $bdd_produit->ID_PRODUIT; ?>IMG1.jpg" /></a></div>
                                    <div class="col-md-6">
                                        <h3 class="h_title_list"><a href="<?php echo base_url(); ?>Fiche/Produit/<?php echo $bdd_produit->ID_PRODUIT; ?>"><?php echo $bdd_produit->DESIGNATION; ?></a></h3>
                                        <p class="p_info"><?php echo $bdd_produit->INFO; ?></p>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="div_stock">EN STOCK</div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="div_price"><a><?php echo $bdd_produit->PRIX_VENTE; ?> Ar</a></div> <!--PRIX-->
                                <?php if($bdd_produit->QUANTITE>0) { ?><div class="div_bag"><a href="<?php echo base_url(); ?>Produit/AjoutPanier/<?php echo $bdd_produit->ID_CATEGORIE."/".$bdd_produit->ID_S_CATEGORIE."/".$bdd_produit->ID_SS_CATEGORIE."/".$bdd_produit->ID_PRODUIT."/1"; ?>"><i class="fas fa-shopping-basket fa-lg"></i></a></div><?php } ?> <!--BAG-->
                                    </div>
                                </div>
                                <?php } } else { ?>
                                <div id="dv_nullfiltre">
                                    <div class="text-secondary" id="dv_nullfiltremsg">aucun résultat ne correspond à votre filtre</div>
                                </div>
                                <?php } ?>
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