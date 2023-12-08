
<div>
<div id="div_logo_search">
    <div id="div_umberg"><i class="fa fa-bars fa-lg"></i></div>
    <script>
        //RESPONSIVE MENU UMBERG
        var respfade = false;
        $('#div_umberg').click(function(){
            if(respfade==false) {
                $('#div_ctg_resp').fadeIn(300);
                respfade = true;
            } else {
                $('#div_ctg_resp').fadeOut(300);
                respfade = false;
            }
        });
    </script>
    <div id="div_logo">
        <a href="<?php echo base_url(); ?>">
            <img src="<?php echo base_url(); ?>img/logo/logo-v3.png" height="60px" alt="">
        </a>
    </div>
    
    <div id="div_search_up" >
        <form id="form_search_up" method="POST" action="<?php echo base_url(); ?>Produit/RechercheMenu">
            <div id="div_departement">
                <select id="slt_rayons" name="splesearch">
                    <option value="ALL">TOUS LES RAYONS</option>
                    <?php $bdd_catrn = $bdd_cat; foreach($bdd_catrn as $bdd_catrn)  { ?>
                    <option value="<?php echo $bdd_catrn->ID_CATEGORIE; ?>"><?php echo $bdd_catrn->CTITRE; ?></option>
                    <?php } ?>
                </select>
            </div>
            <input id="input_search_up" name="search"  type="text" placeholder="Search"/>	
            <button id="bt_bigsearch" style=" vertical-align: top; margin-right:-4px;color: #969696; border: 0;"><img style="height:40px;  transform: rotate(90deg);" src="<?php echo base_url(); ?>img/icon/search.png"/></button>
        </form>
    </div>
    <div id="div_compte_panier" >
        <div>
            <div id="div_conpte">
                <a id="a_icompte" href="<?php echo base_url(); ?>Connexion" class="text-dark" href="#">
                    <span style="WIDTH: 100%;text-align: center;WIDTH: 100%;" class="fas fa-user fa-3x"></span>
                    <span class="a_panier_compte" id="a_compte"  href="#">COMPTE</span>
                   
                </a>
                <?php if(isset($ssn_id_utilisateur)) { ?>
                <div class="border border-success" id="div_drop_logout">
                    <div class="form-group">
                        <h3 class="text-dark" id="h3_hello" >Bonjour <?php echo $ssn_prenom; ?></h3>
                    </div>
                    <div class="form-group">
                        <a href="<?php echo base_url(); ?>Moncompte" class="dropdown-item" style="text-align: center;" href="#">MON COMPTE</a>
                    </div>
                    <div class="form-group">
                        <a href="<?php echo base_url(); ?>Moncompte/Commande" class="dropdown-item" style="text-align: center;" href="#">MES COMMANDES</a>
                    </div>
                    <div class="form-group">
                        <a href="<?php echo base_url(); ?>Connexion/deconnection" class="dropdown-item" style="text-align: center;" href="#">DECONNEXION</a>
                    </div>
                </div>
               <?php } else { ?>
                 <!--LOGIN DROP DOWN-->
                    <div class="border border-success" id="div_drop_login">
                        <form id="form_client_menu" method="POST" action="<?php echo base_url(); ?>connexion" class="px-4 py-3">
                                <div class="form-group">
                                    <label class="text-dark" for="exampleDropdownFormEmail1">Adresse email</label>
                                    <input id="input_emailmenu" class="form-control border border-success" type="text" name="email" value="<?php if(!isset($success)) { echo set_value('email'); } ?>" placeholder="Email" autocomplete="off">
                                    <small style="font-size: 11px;" id="sm_erreur_emailmn" class="invalid-feedback form-text">Veuillez entrer un email valide.</small>
                                    <small style="font-size: 11px;" id="sm_erreur_emailmn_empty" class="invalid-feedback form-text">Vous devez indiquer votre adresse email.</small>
                                   <small style="font-size: 11px;" id="sm_erreur_emailmn_exist" style="display:block;" class="invalid-feedback form-text"> <?php if(isset($error_email)) {  echo $error_email; } ?></small>
                                </div>
                                <div class="form-group">
                                    <label  class="text-dark" for="exampleDropdownFormPassword1">Mot de passe</label>
                                    <input  id="input_mdpmenu" type="password" class="form-control  border border-success" type="password" name="mdp" placeholder="Mot de passe" autocomplete="off">
                                    <small style="font-size: 11px;" id="sm_erreur_mdpmn_nbmin" class="invalid-feedback form-text">Le mot de passe doit avoir au moins 8 caractères.</small>
                                    <small style="font-size: 11px;" id="sm_erreur_mdpmn_nbmax" class="invalid-feedback form-text">Le mot de passe doit avoir au maximum 50 caractères.</small>
                                    <small style="font-size: 11px;" id="sm_erreur_mdpmn_empty" class="invalid-feedback form-text">Vous devez indiquer un mot de passe.</small>
                                     <small style="font-size: 11px;" style="display:block;" id="sm_erreur_mdpmn_false" class="invalid-feedback form-text"><?php if(isset($error_mdp)) {  echo $error_mdp; } ?></small>
                                </div>
                                <div class="form-check">
                                <!--  <input type="checkbox" class="form-check-input" id="dropdownCheck">
                                    <label class="form-check-label" for="dropdownCheck">
                                    Remember me
                                    </label>-->
                                </div>
                                
                        </form>
                        <button type="submit" style="margin-left: 25px;" id="button_loginmenu" class="btn btn-success">CONNECTER</button>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo base_url(); ?>Registre">S'INSCRIR</a>
                        <a class="dropdown-item" href="#">Mot de passe oublier ?</a>
                    </div>
                    <script>
                        $(window).resize(function() { //navigateur redimensionner
                            if($(window).width()<1452) {  //si le width de navigateur <768
                                $('#div_drop_login').addClass("drop_login_onright");
                            } else {
                                $('#div_drop_login').removeClass("drop_login_onright");

                            }
                        });
                        if($(window).width() <1452) { //chargement page
                            $('#div_drop_login').addClass("drop_login_onright");
                        }
                         else {
                            $('#div_drop_login').removeClass("drop_login_onright");

                        }
                    </script>
                <!--LOGIN DROP DOWN-->
                <?php } ?>
            </div>
            <div id="div_panier">
                <a id="a_ipanier" class="text-dark" href="<?php echo base_url(); ?>Panier">
                    <span style="WIDTH: 100%;text-align: center;" class="fas fa-shopping-bag fa-3x"></span>
                    <span class="a_panier_compte" >PANIER</span>
                </a>
            </div>
        </div>
    </div>
</div>
<?php //variable copy bdd
    $bdd_catrs = $bdd_cat;
    $bdd_scatrs =$bdd_scat;
    $bdd_sscatrs =$bdd_sscat;

    $bdd_catns = $bdd_cat;
    $bdd_scatns =$bdd_scat;
    $bdd_sscatns =$bdd_sscat;
?>
<div id="div_ctg_resp" class="div_ctg_resp"> <!--CATEGORIE 1 RESPONSIVE-->
   
    <ul id="ul_ctg_resp" class="list-group ul_ctg_resp">
        <?php $ci = 1; $catrs_length = count($bdd_catrs);$bdd_catrs2 = $bdd_catrs; $bdd_catrs3=$bdd_catrs; foreach($bdd_catrs as $bdd_catrs) { ?>
            <li id="i_cat_<?php echo $ci; ?>" class="list-group-item list-group-item-action"><?php echo $bdd_catrs->CTITRE; ?><i  class="fas fa-arrow-right" style="float: right;"></i></li>
        <?php $ci++; } ?>
    </ul>
</div>
<script>
    $(window).resize(function() { //navigateur redimensionner
        if($(window).width()>=768) {  //si le width de navigateur <768
            $('#div_ctg_resp').hide(); //on cache le categorie
            respfade = false;
        }
    });
</script>
    <!--SOUS CATEGORIE 1 2 3-->
    <?php $ci=1; foreach($bdd_catrs2 as $bdd_catrs2) { ?>
    <div id="div_ctg_resp_<?php echo $ci; ?>" class="div_ctg_resp"> 
        <ul id="ul_ctg_resp_<?php echo $ci; ?>" class="list-group ul_ctg_resp">
        <li id="back_<?php echo $ci; ?>"  class="list-group-item list-group-item-action list-group-item-dark">RETOUR</li>    
        <?php 
            $bdd_scatrs_array = $bdd_scatrs[$bdd_catrs2->ID_CATEGORIE];
            $sci = 1;
            foreach($bdd_scatrs_array as $bdd_scatrs_array) {  ?>
            <li id="i_cat_<?php echo $ci."".$sci ?>" class="list-group-item list-group-item-action"><a><?php echo $bdd_scatrs_array->CSTITRE; ?><i  class="fas fa-arrow-right" style="float: right;"></i></a></li>
            <?php $sci++; } ?>
        </ul>
    </div>
    <script>
        $(window).resize(function() { //navigateur redimensionner
            if($(window).width()>=768) {  //si le width de navigateur <768
                $('#div_ctg_resp_<?php echo $ci; ?>').hide(); // on affiche le sous categorie$('#div_ctg_resp_<?php echo $ci."".$sci; ?>').hide();//on cache le sous sous categorie
            }
        });
        $('#div_umberg').click(function(){
            $('#div_ctg_resp_<?php echo $ci; ?>').fadeOut();
        });
    </script>
    <?php $ci++; } ?>
    <!--SOUS CATEGORIE 1 2 3-->
    <!--SOUS CATEGORIE 11 12 13-->
    <?php $ci=1; foreach($bdd_catrs3 as $bdd_catrs3) { ?>
        <?php $sci=1;
         $bdd_scatrs_array = $bdd_scatrs[$bdd_catrs3->ID_CATEGORIE];
        foreach($bdd_scatrs_array as $bdd_scatrs_array) { ?>
        <div id="div_ctg_resp_<?php echo $ci."".$sci; ?>" class="div_ctg_resp">     
          
            <ul id="ul_ctg_resp_<?php echo $ci."".$sci; ?>" class="list-group ul_ctg_resp">
            <li id="back_<?php echo $ci."".$sci; ?>"  class="list-group-item list-group-item-action list-group-item-dark">RETOUR</li>    
                <?php $ssci=1;
                $bdd_sscatrs_array = $bdd_sscatrs[$bdd_catrs3->ID_CATEGORIE][$bdd_scatrs_array->ID_S_CATEGORIE];
                foreach($bdd_sscatrs_array as $bdd_sscatrs_array) {  ?>
                <a class="list-group-item list-group-item-action" href="<?php echo base_url(); ?>Produit/Categorie3/<?php echo $bdd_catrs3->ID_CATEGORIE."/".$bdd_scatrs_array->ID_S_CATEGORIE."/".$bdd_sscatrs_array->ID_SS_CATEGORIE; ?>"><?php echo $bdd_sscatrs_array->CSSTITRE; ?></a>
                <?php $ssci++; } ?>
            </ul>
        </div>
        <script>
            $(window).resize(function() { //navigateur redimensionner
                if($(window).width()>=768) {  //si le width de navigateur <768
                    $('#div_ctg_resp_<?php echo $ci."".$sci; ?>').hide();//on cache le sous sous categorie
                }
            });
            $('#div_umberg').click(function(){
                $('#div_ctg_resp_<?php echo $ci."".$sci; ?>').fadeOut();
            });
            </script>
        <?php $sci++; } ?>
    <?php $ci++; } ?>
</div>
<script>
 //RESPONSIVE CATEGORIE
 //var nbchildcat = $('#ul_ctg_resp').children().length; //UL CETEGORIE
 //var nbchildcat = $('#ul_ctg_resp').children().length; //UL CETEGORIE
 var nbchildcat = <?php echo $catrs_length; ?>; //UL CETEGORIE
 console.log(nbchildcat);
    for(var i=1;i<=nbchildcat;i++) { //list all li of ul
        (function(i) { //function pour boucler les evenement
            $("#i_cat_"+i).click(function() { //event pour la categorie
                console.log($("#i_cat_"+i.toString()).html());
                $('#div_ctg_resp').hide(); //on cache le categorie
                $('#div_ctg_resp_'+i).show();//on affiche le sous categorie
               
                var nbchildscat = $('#ul_ctg_resp_'+i).children().length; //UL SOUS CATEGORIE
                //console.log(nbchildscat+"i="+i);
                for(var ii=1;ii<=nbchildscat;ii++) {
                    (function(ii){
                        $("#i_cat_"+i+""+ii).click(function() { //event pour le sous categorie
                            $('#div_ctg_resp').hide(); //on cache le categorie
                            $('#div_ctg_resp_'+i).hide();
                            $('#div_ctg_resp_'+i+""+ii).show();
                        });
                          //RETOUR SOUS CATEGORIE
                         
    
                     $("#back_"+i+""+ii).click(function() {
                            $('#div_ctg_resp').hide(); //on cache le categorie
                            $('#div_ctg_resp_'+i).show(); // on affiche le sous categorie
                            $('#div_ctg_resp_'+i+""+ii).hide();//on cache le sous sous categorie
                        });
                     })(ii);
                }
            });
             //RETOUR CATEGORIE
            $('#back_'+i).click(function() {
                $('#div_ctg_resp').show(); //on affiche le categorie
                $('#div_ctg_resp_'+i).hide();//on cache le sous categorie
            });
        })(i);
    }
</script>
    <!--SOUS CATEGORIE 11 12 13-->
<div class="div_search_down" id="div_search_down">
        <form id="form_search_down"  method="POST" action="<?php echo base_url(); ?>Produit/RechercheMenu" class="form-inline my-2 my-lg-0">
            <input  class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">	
        </form>
</div>
<div id="div_ctg_simple">
    <ul class="ul_categorie">
   
        <?php $ci=0; $catLength = count($bdd_catns);$bdd_catns2 = $bdd_catns; foreach($bdd_catns as $bdd_catns) { ?>
        <li id="li_categorie<?php echo $ci; ?>">              
            <a class="nav-link active" href="#" ><?php echo $bdd_catns->CTITRE; ?></a>
        </li>
        <?php $ci++; } ?>
    </ul>
    <?php $sci = 0; foreach($bdd_catns2 as $bdd_catns2) { ?>
    <div class="div_centercat" id="div_centercat<?php echo $sci; ?>">
        <div id="div_sous_categorie">
            <ul class="ul_scategorie">
                <?php 
                $bdd_scatns_array = $bdd_scatns[$bdd_catns2->ID_CATEGORIE];
                foreach($bdd_scatns_array as $bdd_scatns_array) { ?>
                <li>
                    <h5><a class="text-body"><?php echo $bdd_scatns_array->CSTITRE; ?></a></h5>
                    <ul class="ul_sscategorie">
                        <?php 
                        $bdd_sscatns_array = $bdd_sscatns[$bdd_catns2->ID_CATEGORIE][$bdd_scatns_array->ID_S_CATEGORIE];
                        foreach($bdd_sscatns_array as $bdd_sscatns_array) { ?>
                        <li><a href="<?php echo base_url(); ?>Produit/Categorie3/<?php echo $bdd_catns2->ID_CATEGORIE."/".$bdd_scatns_array->ID_S_CATEGORIE."/".$bdd_sscatns_array->ID_SS_CATEGORIE; ?>" class="text-body"><?php echo $bdd_sscatns_array->CSSTITRE; ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <?php $sci++; } ?>
</div>

<script>
     //MENU SIMPLE
    var catLength = <?php echo $catLength; ?>;
    for(var i=0;i<catLength;i++) {
        (function(i){
            $('#li_categorie'+i).mouseenter(function(){ //evenement click
                $('#div_centercat'+i).show();
            }).mouseleave(function(){ //evenement click
                $('#div_centercat'+i).hide();
            });
            $('#div_centercat'+i).mouseenter(function(){ //evenement click
                $('#div_centercat'+i).show();
            }).mouseleave(function(){ //evenement click
                $('#div_centercat'+i).hide();
            });
        })(i);
    }
</script>

