
<?php if($indice==0) { //payer et livrer ?>
    <button type="button" id="bt_livrer<?php echo $ID_FACTURE; ?>" class="btn btn-primary btn-sm">PAYER ET LIVRER</button>
    <script>
        var id_facture_livrer = <?php echo $ID_FACTURE; ?>;
        $( "#bt_livrer<?php echo $ID_FACTURE; ?>" ).click(function() {
            $('#td_livrer<?php echo $ID_FACTURE; ?>').load('<?php echo base_url(); ?>adminlti1379/AjaxLivrer',{id_facture:id_facture_livrer,indice:1 }, function() { //send table
                
            });
        });
        $(".ci_dell<?php echo $ID_FACTURE; ?>").show();
        $('#td_statut<?php echo $ID_FACTURE; ?>').html('<div style="display:block; font-weight: bold;" class="valid-feedback">Payer</div>');
    </script>
<?php } else { //payer ?>
    <button type="button" id="bt_livrer<?php echo $ID_FACTURE; ?>" class="btn btn-primary btn-sm">ANNULER</button>
    <script>
        var id_facture_livrer = <?php echo $ID_FACTURE; ?>;
        $( "#bt_livrer<?php echo $ID_FACTURE; ?>" ).click(function() {
            $('#td_livrer<?php echo $ID_FACTURE; ?>').load('<?php echo base_url(); ?>adminlti1379/AjaxLivrer',{id_facture:id_facture_livrer,indice:0 }, function() { //send table
            
            });
        });
        $(".ci_dell<?php echo $ID_FACTURE; ?>").hide();
        $('#td_statut<?php echo $ID_FACTURE; ?>').html('<div style="display:block; font-weight: bold;" class="valid-feedback">Payer et Livrer</div>');
    </script>
<?php } ?>