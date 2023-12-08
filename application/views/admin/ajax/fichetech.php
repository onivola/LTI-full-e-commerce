
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
                <td><input type="text"  name="titre2" value="<?php echo $nbid; ?>" class="form-control cinput" id="input_nb<?php echo $nbid; ?>" aria-describedby="emailHelp" placeholder="Titre 2"></td>
                <?php break; } ?>
            </tr>
            <?php $i=0; foreach($tbdd_fichet2 as $tbdd_fichet2) { ?>
                <?php if($i>0) { ?>
                <tr>
                    <td><?php echo $tbdd_fichet2->FSTITRE; ?></td>
                    <td><input type="text" name="titre2" value="<?php echo $nbid; ?>" class="form-control cinput" id="input_nb<?php echo $nbid; ?>" aria-describedby="emailHelp" placeholder="Titre 2"></td>
                </tr>
                <?php } ?>
            <?php $nbid++; $i++; } ?>

        <?php } } ?>
      
     
    </table>
</div>
<?php } else { ?>
    <div class="invalid-feedback" style="display: block;">Fiche technique Vide</div>
<?php } ?>