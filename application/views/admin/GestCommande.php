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
        
    </head>
    <body>
        <!--MENU 1-->
        <?php $this->view("admin/include/navmenu.php"); ?>
        <!--MENU 2-->
        <section id="sct_component"><!--component-->
            <div>
                <h3>TOUS LES COMMANDES</h3>
                <div id="dv_mcompte" class="row">
                    <div class="col-md-9">
                        <div>
                            <?php if(count($db_facture)>0) { //si facture non null ?>
                            <div>
                            <?php //var_dump($db_facture) ; 
                                foreach($db_facture as $db_facture) { //boucle facture
                            ?>
                                <table id="tab_commande">
                                    <thead>
                                        <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Nº commande</th>
                                        <th scope="col">Montant</th>
                                        <th scope="col">Paiement</th>
                                        <th scope="col">Statut</th>
                                        <th scope="col">Payer</th>
                                        <th scope="col">Autre</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $db_facture->DATE_FACTURE; ?></td>
                                            <th><?php echo $db_facture->REFERENCE; ?></th>
                                            <td><?php echo $db_facture->PRIX_TOTAL; ?> Ar TTC</td>
                                            <td><?php echo $db_facture->TYPE_PAIEMENT; ?></td>
                                            <td id="td_statut<?php echo $db_facture->ID_FACTURE; ?>">...</td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <button id="bt_payermodal<?php echo $db_facture->ID_FACTURE; ?>" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalLong">
                                                ...
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTitle">PAYEMENT: <strong><?php echo $db_facture->REFERENCE; ?></strong></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div id="dv_mdpayer_body" class="modal-body">
                                                            <?php if(count($db_paiement[$db_facture->ID_FACTURE])>0) { ?>
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">PAYER</th>
                                                                        <th style="text-align:right" scope="col">DATE PAIEMENT</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $pi=1; foreach($db_paiement[$db_facture->ID_FACTURE] as $db_rpaiement) {  ?>
                                                                    <tr class="table-light">
                                                                        <td><i id="i_dell<?php echo $db_facture->ID_FACTURE; ?>-<?php echo $pi; ?>"  style="cursor: pointer;" disabled class="fas fa-trash-alt ci_dell<?php echo $db_facture->ID_FACTURE; ?>"></i></td>
                                                                        <td><?php echo $db_rpaiement->PAYER; ?> Ar</td>
                                                                        <td style="text-align:right"><?php echo $db_rpaiement->DATE_PAIEMENT; ?></td>
                                                                    </tr>
                                                                    <script>
                                                                        $(function() { 
                                                                            $( "#i_dell<?php echo $db_facture->ID_FACTURE; ?>-<?php echo $pi; ?>" ).click(function() {
                                                                                if (confirm("Voulez vous vraiment supprimer ce paiement?")) {
                                                                                    var id_paiement = <?php echo $db_rpaiement->ID_PAIEMENT; ?>;
                                                                                    var id_facture = <?php echo $db_facture->ID_FACTURE; ?>;
                                                                                    //alert(id_paiement);
                                                                                    $('#dv_mdpayer_body').load('<?php echo base_url(); ?>adminlti1379/AjaxDellPayer',{id_paiement:id_paiement,id_facture:id_facture}, function() { //send table
                                                                                        
                                                                                        
                                                                                    });
                                                                                }
                                                                            });
                                                                        });
                                                                    </script>
                                                                    <?php $pi++; } ?>
                                                                </tbody>
                                                            </table>
                                                            <?php } else { ?>
                                                                <div style="display: block;text-align: center;margin: 74px 0;font-size: 16px;" class="invalid-feedback">
                                                                    Aucune transaction n'a été effectuée
                                                                </div>
                                                            <?php } ?>
                                                            <table  class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">RESTE A PAYER</th>
                                                                        <th scope="col" style="text-align:right">TOTAL TTC</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="table-light">
                                                                        
                                                                        <td><?php echo number_format((float)$db_facture->PRIX_TOTAL-$bd_totalpaiement[$db_facture->ID_FACTURE]->total_payer, 2, '.', ''); ?> Ar</td>
                                                                        <td style="text-align:right"><?php echo $db_facture->PRIX_TOTAL; ?> Ar TTC</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <input type="hidden" id="prix_rest<?php echo $db_facture->ID_FACTURE; ?>" name="prix_rest" value="<?php  echo number_format((float)$db_facture->PRIX_TOTAL-$bd_totalpaiement[$db_facture->ID_FACTURE]->total_payer, 2, '.', ''); ?>"/>
                                                           
                                                        </div>
                                                        <div class="modal-footer">
                                                            
                                                            <input id="input_prix<?php echo $db_facture->ID_FACTURE; ?>" class="form-control form-control-sm" type="text" placeholder="">
                                                            <label style="margin: 6px 6px 6px 2px;">Ar</label>
                                                            <button type="button" id="bt_payer<?php echo $db_facture->ID_FACTURE; ?>" class="btn btn-primary btn-sm">PAYER</button>
                                                            
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </td>
                                            <script>
                                                $(function() {
                                                        function getPrix() {
                                                            return parseFloat($("#input_prix<?php echo $db_facture->ID_FACTURE; ?>").val()).toFixed(2);
                                                        }
                                                        function getPrixres() {
                                                            return parseFloat($("#prix_rest<?php echo $db_facture->ID_FACTURE; ?>").val()).toFixed(2);
                                                        }
                                                        function facturePayer(prix_rest) {
                                                            if(prix_rest==0) { //facture payer
                                                                $( "#input_prix<?php echo $db_facture->ID_FACTURE; ?>" ).prop('disabled', 'disabled');
                                                                $( "#bt_payer<?php echo $db_facture->ID_FACTURE; ?>" ).prop('disabled', 'disabled');
                                                                $('#td_statut<?php echo $db_facture->ID_FACTURE; ?>').html('<div style="display:block; font-weight: bold;" class="valid-feedback">Payer</div>');
                                                                $( "#bt_payermodal<?php echo $db_facture->ID_FACTURE; ?>" ).text("VOIR");
                                                            } else if(prix_rest>0) { //paiement insuffisant
                                                                $( "#input_prix<?php echo $db_facture->ID_FACTURE; ?>" ).prop('disabled', false);
                                                                $( "#bt_payer<?php echo $db_facture->ID_FACTURE; ?>" ).prop('disabled', false);
                                                                $('#td_statut<?php echo $db_facture->ID_FACTURE; ?>').html('<div style="display:block;" class="invalid-feedback">En attente de paiement</div>');
                                                                $( "#bt_payermodal<?php echo $db_facture->ID_FACTURE; ?>" ).text("PAYER");
                                                            }
                                                        }
                                                        facturePayer(getPrixres(),getPrix());
                                                        if('<?php echo $db_facture->STATUT; ?>'=='Payer et livrer') {
                                                            $('#td_statut<?php echo $db_facture->ID_FACTURE; ?>').html('<div style="display:block; font-weight: bold;" class="valid-feedback">Payer et livrer</div>');
                                                        }
                                                        $( "#bt_payer<?php echo $db_facture->ID_FACTURE; ?>" ).click(function() {
                                                            var input_prix = parseFloat(getPrix());
                                                            var prix_rest = parseFloat(getPrixres());
                                                            console.log(prix_rest);
                                                            if(input_prix>0) {
                                                                
                                                                console.log(prix_rest);
                                                                console.log(input_prix);
                                                                if(input_prix<=prix_rest) {
                                                                    console.log(input_prix);
                                                                    $('#dv_mdpayer_body').load('<?php echo base_url(); ?>adminlti1379/AjaxPayer',{prix:input_prix,id_facture:<?php echo $db_facture->ID_FACTURE;?> }, function() { //send table
                                                                        //console.log(parseInt(input_prix));
                                                                        $( "#input_prix<?php echo $db_facture->ID_FACTURE; ?>" ).val("");
                                                                        $( "#input_prix<?php echo $db_facture->ID_FACTURE; ?>" ).removeClass( "is-invalid" );
                                                                        //facturePayer(prix_rest,input_prix);
                                                                    });
                                                                } else {
                                                                    $( "#input_prix<?php echo $db_facture->ID_FACTURE; ?>" ).addClass("is-invalid" );
                                                                }
                                                                //$( "#input_prix" ).removeClass( "is-invalid" ).addClass( "is-valid" );
                                                                //console.log(input_prix);
                                                            
                                                            } else {
                                                                $( "#input_prix<?php echo $db_facture->ID_FACTURE; ?>" ).addClass("is-invalid" );
                                                            }
                                                        
                                                        });
                                                    
                                                }); 
                                            </script>
                                            <td>détails</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
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
                                                                    <td id="td_textvalide<?php echo $db_facture->ID_FACTURE; ?>" <?php if($db_facture->STATUT=='En attente de paiement') { ?> style="display:none;" <?php } ?>>Valider:</td>
                                                                        <td id="td_livrer<?php echo $db_facture->ID_FACTURE; ?>" <?php if($db_facture->STATUT=='En attente de paiement') { ?> style="display:none;" <?php } ?>>
                                                                        <?php if($db_facture->STATUT=='Payer') { ?>
                                                                        <button type="button" id="bt_livrer<?php echo $db_facture->ID_FACTURE; ?>" class="btn btn-primary btn-sm">PAYER ET LIVRER</button>
                                                                        <script>
                                                                            var id_facture_livrer = <?php echo $db_facture->ID_FACTURE; ?>;
                                                                            $( "#bt_livrer<?php echo $db_facture->ID_FACTURE; ?>" ).click(function() {
                                                                                $('#td_livrer<?php echo $db_facture->ID_FACTURE; ?>').load('<?php echo base_url(); ?>adminlti1379/AjaxLivrer',{id_facture:id_facture_livrer,indice:1 }, function() { //send table
                                                                                    
                                                                                });
                                                                            });
                                                                            $(".ci_dell<?php echo $db_facture->ID_FACTURE; ?>").show();
                                                                        </script>
                                                                        <?php  } else if($db_facture->STATUT=='Payer et livrer') { ?>
                                                                            <button type="button" id="bt_livrer<?php echo $db_facture->ID_FACTURE; ?>" class="btn btn-primary btn-sm">ANULER</button>
                                                                            <script>
                                                                                var id_facture_livrer = <?php echo $db_facture->ID_FACTURE; ?>;
                                                                                $( "#bt_livrer<?php echo $db_facture->ID_FACTURE; ?>" ).click(function() {
                                                                                    $('#td_livrer<?php echo $db_facture->ID_FACTURE; ?>').load('<?php echo base_url(); ?>adminlti1379/AjaxLivrer',{id_facture:id_facture_livrer,indice:0 }, function() { //send table
                                                                                        
                                                                                    });
                                                                                });
                                                                                $(".ci_dell<?php echo $db_facture->ID_FACTURE; ?>").hide();

                                                                            </script>
                                                                        <?php } else  { ?>
                                                                            <button type="button" id="bt_livrer<?php echo $db_facture->ID_FACTURE; ?>" class="btn btn-primary btn-sm">PAYER ET LIVRER</button>
                                                                            <script>
                                                                                var id_facture_livrer = <?php echo $db_facture->ID_FACTURE; ?>;
                                                                                $( "#bt_livrer<?php echo $db_facture->ID_FACTURE; ?>" ).click(function() {
                                                                                    $('#td_livrer<?php echo $db_facture->ID_FACTURE; ?>').load('<?php echo base_url(); ?>adminlti1379/AjaxLivrer',{id_facture:id_facture_livrer,indice:1 }, function() { //send table
                                                                                        
                                                                                    });
                                                                                });
                                                                                $(".ci_dell<?php echo $db_facture->ID_FACTURE; ?>").show();
                                                                            </script>
                                                                        <?php } ?>
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
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
            <div style="height:1000px">
                   
            </div>
    </body>
</html>