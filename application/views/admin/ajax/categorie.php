

<?php if(count($bdd_scat)>0 || count($bdd_sscat)>0) { ?>
    
    <?php if($ref==0) { ?>
        <option value="0">Categorie 2</option><?php foreach($bdd_scat as $bdd_scat) { ?><option value="<?php echo $bdd_scat->ID_S_CATEGORIE; ?>"><?php echo $bdd_scat->CSTITRE; ?></option><?php  } ?>
    <?php } else if($ref==1) {?>
        <?php foreach($bdd_sscat as $bdd_sscat) { ?><option value="<?php echo $bdd_sscat->ID_SS_CATEGORIE; ?>"><?php echo $bdd_sscat->CSSTITRE; ?></option><?php  } ?>
    <?php } ?>
<?php } else { ?><option value="0">VIDE</option><?php } ?>
