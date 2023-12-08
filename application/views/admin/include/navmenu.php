 <!--nav top-->
 <nav class="navbar sticky-top navbar-dark bg-dark">
            <a href="#" class="navbar-brand">Lite Tech Info Admin</a>
            <ul class="navbar" id="ul_admin">
              
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user"></i> COMPTE
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </ul>
        </nav>
        <section id="sct_side"><!--nav side-->
            <div class="list-group">
                <a href="<?php echo base_url(); ?>adminlti1379" class="list-group-item list-group-item-action">Dashboard</a>
                <a href="<?php echo base_url(); ?>adminlti1379/AjoutCategorie" class="list-group-item list-group-item-action">Ajout Categorie</a>
                <a href="<?php echo base_url(); ?>adminlti1379/AjoutProduit" class="list-group-item list-group-item-action">Ajout produit</a>
                <a href="<?php echo base_url(); ?>adminlti1379/AjoutCaracteristique" class="list-group-item list-group-item-action">Ajout Caractéristiques</a>
                <a href="<?php echo base_url(); ?>adminlti1379/GestCommande" class="list-group-item list-group-item-action">Gestion des commandes</a>
                <a href="#" class="list-group-item list-group-item-action">Gestion de produit</a>
            </div>

        </section>