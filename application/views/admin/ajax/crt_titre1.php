<?php if(count($bdd_t1)>0) { ?>
    <option value="0">Titre 1</option><?php foreach($bdd_t1 as $bdd_t1) { ?><option value="<?php echo $bdd_t1->ID_FICHE_TQ_TITRE; ?>"><?php echo $bdd_t1->FTITRE; ?></option><?php  } ?>
<?php } else { ?>
    <option value="00">VIDE</option>
<?php } ?>
