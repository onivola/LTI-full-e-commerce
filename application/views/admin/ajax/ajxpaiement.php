<?php if(count($db_paiement)>0) { ?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">PAYER</th>
            <th style="text-align:right" scope="col">DATE PAIEMENT</th>
        </tr>
    </thead>
    <tbody>
        <?php $pi=1; foreach($db_paiement as $db_rpaiement) {  ?>
        <tr class="table-light">
            <td><i id="i_dell<?php echo $id_facture; ?>-<?php echo $pi; ?>"  style="cursor: pointer;" class="fas fa-trash-alt ci_dell<?php echo $id_facture; ?>"></i></td>
            <td><?php echo $db_rpaiement->PAYER; ?> Ar</td>
            <td style="text-align:right"><?php echo $db_rpaiement->DATE_PAIEMENT; ?></td>
        </tr>
        <script>
            $(function() { 
                $( "#i_dell<?php echo $id_facture; ?>-<?php echo $pi; ?>" ).click(function() {
                    if (confirm("Voulez vous vraiment supprimer ce paiement?")) {
                        var id_paiement = <?php echo $db_rpaiement->ID_PAIEMENT; ?>;
                        var id_facture = <?php echo $id_facture; ?>;
                        //alert(id_paiement);
                        $('#dv_mdpayer_body').load('<?php echo base_url(); ?>adminlti1379/AjaxDellPayer',{id_paiement:id_paiement,id_facture:id_facture}, function() { //send table
                            //facturePayer(getPrixres(),getPrix());
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
            
            <td><?php echo number_format((float)$rest_payer, 2, '.', ''); ?> Ar</td>
            <td style="text-align:right"><?php echo $prix_total; ?> Ar TTC</td>
        </tr>
    </tbody>
</table>
<input type="hidden" id="prix_rest<?php echo $id_facture; ?>" name="prix_rest" value="<?php  echo number_format((float)$rest_payer, 2, '.', ''); ?>"/>
<script>
    $(function() {
        
        facturePayerAX(getPrixresAX());
       
        function getPrixresAX() {
            return parseFloat($("#prix_rest<?php echo $id_facture; ?>").val()).toFixed(2);
        }
        function facturePayerAX(prix_rest) {
            if(prix_rest==0) { //facture payer
                $( "#input_prix<?php echo $id_facture; ?>" ).prop('disabled', 'disabled');
                $( "#bt_payer<?php echo $id_facture; ?>" ).prop('disabled', 'disabled');
                $('#td_statut<?php echo $id_facture; ?>').html('<div style="display:block; font-weight: bold;" class="valid-feedback">Payer</div>');
                $( "#bt_payermodal<?php echo $id_facture; ?>" ).text("VOIR"); 
                $('#td_livrer<?php echo $id_facture; ?>').show();
                $('#td_textvalide<?php echo $id_facture; ?>').show();
            } else if(prix_rest>0) { //paiement insuffisant
                $( "#input_prix<?php echo $id_facture; ?>" ).prop('disabled', false);
                $( "#bt_payer<?php echo $id_facture; ?>" ).prop('disabled', false);
                $('#td_statut<?php echo $id_facture; ?>').html('<div style="display:block;" class="invalid-feedback">En attente de paiement</div>');
                $( "#bt_payermodal<?php echo $id_facture; ?>" ).text("PAYER");
                $('#td_livrer<?php echo $id_facture; ?>').hide();
                $('#td_textvalide<?php echo $id_facture; ?>').hide();
            }
        }
    });
</script>                                       