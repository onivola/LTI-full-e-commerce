<?php 
    if(isset($tb_categorie)) { 
?>
<ul id="ul_lien" style="margin: 15px 0;"><!--LIEN-->
    <li><h6><a href="<?php echo base_url(); ?>Accueil"><i class="fas fa-home fa-lg"></i></a></h6></li>
    <li class="li_sep"><a>></a></li>
    <li><h6><a href="#"><?php echo $tb_categorie[0]; ?></a></h6></li>
    <li class="li_sep"><a>></a></li>
    <li><h6><a href="#"><?php echo $tb_categorie[1]; ?></a></h6></li>
    <li class="li_sep"><a>></a></li>
    <li><h6><a href="#"><?php echo $tb_categorie[2]; ?></a></h6></li>
</ul>
    <?php } ?>