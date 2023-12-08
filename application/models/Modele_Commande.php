<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Modele_Commande extends CI_Model
{
	protected $tbutilisateur = 'utilisateur';
	protected $tbvilletarif = 'ville_tarif';
	protected $tbfacture = 'facture';
	protected $tbadresse_livraison = 'adresse_livraison';
	protected $tbdetailfacture = 'detail_facture';
	protected $tbpanier = 'panier';
    public function SelectUtilByid($ID_UTILISATEUR) 
	{
        return $this->db->select('*')
        ->from($this->tbutilisateur)
        ->where('ID_UTILISATEUR', $ID_UTILISATEUR)
        ->get()
        ->row();
    }
    public function SelectVille() 
	{
        return $this->db->select('*')
        ->from($this->tbvilletarif)
        ->get()
        ->result();
    }
    public function GetIdfacture($ID_UTILISATEUR,$REFERENCE) {
       $bd_facture = $this->db->select('ID_FACTURE')
        ->from($this->tbfacture)
        ->where('ID_UTILISATEUR', $ID_UTILISATEUR)
        ->where('REFERENCE', $REFERENCE)
        ->get()
        ->row();
        return $bd_facture->ID_FACTURE;
    }
    public function GetMaxIdfacture($ID_UTILISATEUR) {
        $bd_facture = $this->db->select('Max(ID_FACTURE) as id,REFERENCE')
         ->from($this->tbfacture)
         ->where('ID_UTILISATEUR', $ID_UTILISATEUR)
         ->get()
         ->row();
         return $bd_facture->REFERENCE;
     }
     /*******ANNULER COMMANDE */
     public function DelletFacture($ID_FACTURE) {
		
			return $this->db->where('ID_FACTURE', $ID_FACTURE)
			->delete($this->tbfacture);
		
    }
    public function DelletDetlFacture($ID_FACTURE) {
		
			return $this->db->where('ID_FACTURE', $ID_FACTURE)
			->delete($this->tbdetailfacture);
		
	}
     /******MES COMMANDE************** */
     public function SelectFacture($ID_UTILISATEUR) 
     {
        return $this->db->select('*')
        ->from($this->tbfacture)
        ->where('ID_UTILISATEUR', $ID_UTILISATEUR)
        ->get()
        ->result();
     }
     public function SelectDtlFacture($ID_FACTURE) 
     {
        return $this->db->select('*')
        ->from($this->tbdetailfacture)
        ->where('ID_FACTURE', $ID_FACTURE)
        ->get()
        ->result();
     }
     public function SelectAdresse($ID_FACTURE) 
     {
        return $this->db->select('*')
        ->from($this->tbadresse_livraison)
        ->where('ID_FACTURE', $ID_FACTURE)
        ->get()
        ->row();
     }
     /*** VALIDER COMMANDE***/
    public function SelectPanierJoin($ID_UTILISATEUR) 
	{
        $order = 'order by DATE_AJOUT_PN asc';
        $where[1]=$ID_UTILISATEUR;
		$query =  $this->db->query("select * from panier join produit on panier.ID_PRODUIT = produit.ID_PRODUIT where ID_UTILISATEUR = ? ".$order,$where);
        return $query->result();
    }
    //update produit set QUANTITE = QUANTITE-2 where id_produit=20;
    public function UpdateProduit($ID_PRODUIT,$QUANTITE) 
	{
        $where[1]=$ID_PRODUIT;
		$query =  $this->db->query("update produit set QUANTITE = QUANTITE-".$QUANTITE." where id_produit=?",$where);
        return true;
    }
    public function DeletePanier($wherein)
	{
        if($wherein!="") {
            $query =  $this->db->query("DELETE FROM panier WHERE ID_PANIER in(".$wherein.")");
            return true;
        } else {
            return false;
        }
	}
    public function InsertAdress($ID_FACTURE,$ID_UTILISATEUR,$NOM_LV,$PRENOM_LV,$PAYS,$VILLE,$ADRESSE,$CADRESSE,$N_TELEPHONE1,$N_TELEPHONE2,$CODE_POSTAL) 
	{
        $this->db->set('ID_FACTURE',$ID_FACTURE);
		$this->db->set('ID_UTILISATEUR',$ID_UTILISATEUR);
		$this->db->set('NOM_LV',$NOM_LV);
		$this->db->set('PRENOM_LV',$PRENOM_LV);
		$this->db->set('PAYS',$PAYS);
		$this->db->set('VILLE',$VILLE);
		$this->db->set('ADRESSE',$ADRESSE);
		$this->db->set('CADRESSE',$CADRESSE);
		$this->db->set('N_TELEPHONE1',$N_TELEPHONE1);
		$this->db->set('N_TELEPHONE2',$N_TELEPHONE2);
		$this->db->set('CODE_POSTAL',$CODE_POSTAL);
        $this->db->set('DATE_AJOUT_AL','NOW()',false);
		
		return $this->db->insert($this->tbadresse_livraison);
    }
    public function InsertDetailFacture($ID_UTILISATEUR,$ID_FACTURE) 
	{
        $bd_panier = $this->SelectPanierJoin($ID_UTILISATEUR); $i=0; $wherein="";
        foreach($bd_panier as $bd_panier) {
            $this->db->set('ID_FACTURE',$ID_FACTURE);
            $this->db->set('ID_PRODUIT',$bd_panier->ID_PRODUIT);
            $this->db->set('DESIGNATION_DF',$bd_panier->DESIGNATION);
            $this->db->set('QUANTITE_DF',$bd_panier->QUANTITE_PN);
            $this->db->set('PRIX_DF',$bd_panier->PRIX_VENTE);
            $this->db->set('FRAIS_DF',0);
            $this->db->insert($this->tbdetailfacture);
            $this->UpdateProduit($bd_panier->ID_PRODUIT,$bd_panier->QUANTITE_PN);
            if($i==0) {
                $wherein = "'".$bd_panier->ID_PANIER."'";
            } else {
                $wherein = $wherein.",'".$bd_panier->ID_PANIER."'";
            }
            $i++;
        }
        $this->DeletePanier($wherein);
        return true;
    }
    public function InsertFacture($ID_UTILISATEUR,$REFERENCE,$TYPE_PAIEMENT,$PRIX_TOTAL) 
	{
        $this->db->set('ID_UTILISATEUR',$ID_UTILISATEUR);
		$this->db->set('REFERENCE',$REFERENCE);
		$this->db->set('TYPE_PAIEMENT',$TYPE_PAIEMENT);
		$this->db->set('STATUT','En attente de paiement');
		$this->db->set('PRIX_TOTAL',$PRIX_TOTAL);
        $this->db->set('DATE_FACTURE','NOW()',false);
		
		return $this->db->insert($this->tbfacture);
    }
    public function GetPrixTotal($ID_UTILISATEUR) 
	{
        $bd_panier = $this->SelectPanierJoin($ID_UTILISATEUR);
        $total=0;
        foreach($bd_panier as $bd_panier) {
            $total = $total + ($bd_panier->PRIX_VENTE*$bd_panier->QUANTITE_PN); 
        }
        return $total;
    }
    public function GetReference($ID_UTILISATEUR) {
        $bd_idfacture=$this->db->select('COUNT(*) as nb_facture')
        ->from($this->tbfacture)
        ->where('ID_UTILISATEUR', $ID_UTILISATEUR)
        ->get()
        ->row();
        $input = array("Q","W","E","R","T","Y","U","I","O","P","A","S","D","F","G","H","J","K","L","Z","X","C","V","B","N","M");
        $rand_keys1 = array_rand($input, 1);
        $rand_keys2 = array_rand($input, 1);
        if($bd_idfacture->nb_facture==0) { //commande null
            return $ID_UTILISATEUR."C1".$input[$rand_keys1].$input[$rand_keys2];
        } else {
            $nbfactureplus = $bd_idfacture->nb_facture+1;
            return $ID_UTILISATEUR."C".$nbfactureplus.$input[$rand_keys1].$input[$rand_keys2];
        }
        return 1;
    }
    
}
?>