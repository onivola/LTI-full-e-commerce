
<?php 
if(count($bdd_fichet1)>0) { ?>
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
                    <td>
                        <input type="text"  name="titrenb<?php echo $nbid; ?>" value="valuenb<?php echo $nbid; ?>" class="form-control cinput" id="input_fcnb<?php echo $nbid; ?>" aria-describedby="emailHelp" placeholder="Entrer 0 pour igniorer">
                        <input type="hidden" name="id_titrenb<?php echo $nbid; ?>" value="<?php echo $bdd_fichet1->ID_FICHE_TQ_TITRE; ?>"/>
                        <input type="hidden" name="id_stitrenb<?php echo $nbid; ?>" value="<?php echo $tbdd_fichet2first->ID_FICHE_TQ_STITRE; ?>"/>
                    </td>    
                <?php break; } ?>
            </tr>
            <?php $i=0; foreach($tbdd_fichet2 as $tbdd_fichet2) { ?>
                <?php if($i>0) { ?>
                <tr>
                    <td><?php echo $tbdd_fichet2->FSTITRE; ?></td>
                    <td>
                        <input type="text" name="titrenb<?php echo $nbid; ?>" value="valuenb<?php echo $nbid; ?>" class="form-control cinput" id="input_fcnb<?php echo $nbid; ?>" aria-describedby="emailHelp" placeholder="Entrer 0 pour igniorer">
                        <input type="hidden" name="id_titrenb<?php echo $nbid; ?>" value="<?php echo $bdd_fichet1->ID_FICHE_TQ_TITRE; ?>"/>
                        <input type="hidden" name="id_stitrenb<?php echo $nbid; ?>" value="<?php echo $tbdd_fichet2->ID_FICHE_TQ_STITRE; ?>"/>  
                    </td> 
                </tr>
                <?php } ?>
            <?php $nbid++; $i++; } ?>

        <?php } } ?>
      
     
    </table>
</div>
<script>
    $('#button_produit').prop('disabled',false);
    $('#form_produit').attr('action','<?php echo base_url(); ?>adminlti1379/FormProduit/<?php echo $nbid-1; ?>');
</script>
<?php } else { ?>
    <div style="display:block;text-align: center;font-size: 27px;" id="sm_erreur_ftech_empty" class="invalid-feedback">Fiche technique vide pour <?php echo $CSSTITRE; ?></div>
    <script>
        $('#button_produit').prop('disabled', 'disabled');
    </script>
<?php } ?>