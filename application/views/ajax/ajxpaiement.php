<div class="div_titre">
    <h3 class="h_titre">PAYEMENT</h3>
</div>
<div>
    <div class="border-bottom">
        <p>Facturation RAZAFIMANDIMBY Onintsoa Antananarivo </p>
    </div>
    <table id="tb_paiement">
        <tr>
            <td style="padding-bottom: 10px;">Votre panier (<?php echo count($db_panier); ?> Article<?php if(count($db_panier)>1) { echo 's'; } ?>)</td>
            <td style="padding-bottom: 10px; text-align: right;">Voir le detail</td>
        </tr>
        <?php $stotal = 0; foreach($db_panier as $db_panier) { ?>
        <tr class="border-bottom">
            <td><?php echo $db_panier->QUANTITE_PN; ?>x <?php echo $db_panier->DESIGNATION; ?></td>
            <td style="text-align: right;"><?php echo $db_panier->QUANTITE_PN*$db_panier->PRIX_VENTE; ?> Ar</td>
        </tr>
        <?php  $stotal=  $stotal+($db_panier->QUANTITE_PN*$db_panier->PRIX_VENTE); } ?>
        <tr>
            <td style="padding-top: 13px;">Sous-total panier:</td>
            <td style="padding-top: 13px; text-align: right;"><?php echo $stotal; ?> Ar</td>
        </tr>
        <tr>
            <td>Livraison a Domicile pour 10kg</td>
            <td style="text-align: right;">0 Ar</td>
        </tr>
        <tr>
            <td>TOTAL TTC</td>
            <td style="text-align: right;"><?php echo $stotal; ?> Ar</td>
        </tr>
    </table>
</div>
<div>
    <form method="POST" action="<?php echo base_url(); ?>Commande/ValiderCommande" id="form_validcommande">
    <input type="hidden" name="civilit" value="<?php echo $civilit; ?>"/>
    <input type="hidden" name="nom" value="<?php echo $nom; ?>"/>
    <input type="hidden" name="prenom" value="<?php echo $prenom; ?>"/>
    <input type="hidden" name="ville" value="<?php echo $ville; ?>"/>
    <input type="hidden" name="adresse" value="<?php echo $adresse; ?>"/>
    <input type="hidden" name="cadresse" value="<?php echo $cadresse; ?>"/>
    <input type="hidden" name="cpostal" value="<?php echo $cpostal; ?>"/>
    <input type="hidden" name="phone" value="<?php echo $phone; ?>"/>
    <ul id="ul_typepment">
        <li id="li_mvola">
            <h5>MVOLA</h5>
            <div class="dv_pcheck">
                <input  type="radio" name="checkpaiement" id="checkmvola" value="mvola">
            </div>
        </li>
        <li id="li_paypal">
            <h5>PAYPAL</h5>
            <div class="dv_pcheck">
                <input  type="radio" name="checkpaiement" id="checkpaypal" value="paypal">
            </div>
        </li>
        <li id="li_vbanc">
            <h5>VIREMENT BANCAIRE</h5>
            <div class="dv_pcheck">
                <input  type="radio" name="checkpaiement" id="checkvbancaire" value="vbancaire">
            </div>
        </li>
    </ul>
    </form>
   
</div>
<div class="dv_paiement" id="dv_vbancaire"> <!--VIREMENT BANCAIRE-->
    <div class="dv_pvirmbttvald border border-success">
        <p class="p_virmbanc">Les instructions concernant le virement bancaire à réaliser vous seront presenter après validation de votre commande. Votre commande ne sera définitivement validée par nos services qu'après réception du virement sur notre compte bancaire.</p>
        <div class="div_validcommnd"><button id="bt_banc" type="button" class="btn btn-success btn-sm">VALIDER LA COMMANDE</button></div>
    </div>
</div>
<div class="dv_paiement" id="dv_mvola"> <!--M Vola-->
    <div class="dv_pvirmbttvald border border-success">
        <p class="p_virmbanc">Les instructions concernant la transaction par MVola à réaliser vous seront presenter après validation de votre commande. Votre commande ne sera définitivement validée par nos services qu'après réception du virement sur notre compte MVola.</p>
        <div class="div_validcommnd"><button id="bt_mvola" type="button" class="btn btn-success btn-sm">VALIDER LA COMMANDE</button></div>
    </div>
</div>
<div class="dv_paiement" id="dv_paypal"> <!--M PAYPL-->
    <div class="dv_pvirmbttvald border border-success">
        <p class="p_virmbanc">Vous serez redirigé vers le site Paypal afin de valider votre paiement</p>
        <div class="div_validcommnd"><button id="bt_paypal" type="button" class="btn btn-success btn-sm">VALIDER LA COMMANDE</button></div>
    </div>
</div>