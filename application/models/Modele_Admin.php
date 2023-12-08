<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Modele_Admin extends CI_Model
{
	protected $tbCategorie = 'categorie';
	protected $tbSCategorie = 's_categorie';
	protected $tbSSCategorie = 'ss_categorie';
	protected $tbProduit = 'produit';

	protected $tbfiche_tq_titre = 'fiche_tq_titre';
	protected $tbfiche_tq_stitre = 'fiche_tq_stitre';
	protected $tbfiche_tq_valeur = 'fiche_tq_valeur';

	protected $tbfacture = 'facture';
	protected $tbadresse_livraison = 'adresse_livraison';
	protected $tbdetailfacture = 'detail_facture';
	protected $tbpaiement = 'paiement';
	protected $tbtopvente = 'top_vente';
	/*--------------COMMNDE----------------- */
	public function AjoutTopVente($ID_PRODUIT) {
		$this->db->set('ID_PRODUIT',$ID_PRODUIT);
		$this->db->set('NOMBRE_VENTE',1);
		return $this->db->insert($this->tbtopvente);
	}
	public function SetTopVente($ID_PRODUIT) 
	{
		$where[1]=$ID_PRODUIT;
		$query =  $this->db->query("update top_vente set NOMBRE_VENTE = NOMBRE_VENTE+1 where ID_PRODUIT=?",$where);
		return true;
	}
	public function SetTopVente2($ID_PRODUIT) 
	{
		$where[1]=$ID_PRODUIT;
		$query =  $this->db->query("update top_vente set NOMBRE_VENTE = NOMBRE_VENTE-1 where ID_PRODUIT=?",$where);
		return true;
	}
	public function SelectTopVente($ID_PRODUIT) 
	{
	   return $this->db->select('*')
	   ->from($this->tbtopvente)
	   ->where('ID_PRODUIT', $ID_PRODUIT)
	   ->get()
	   ->row();
	}
	public function DelletTopVente($ID_PRODUIT) {
		
			return $this->db->where('ID_PRODUIT', $ID_PRODUIT)
			->delete($this->tbtopvente);
		
	}
	public function AddTopVente($ID_PRODUIT) 
	{
		$db_data = $this->SelectTopVente($ID_PRODUIT);
	   if($db_data==null) { //produit not in topvente
			$this->AjoutTopVente($ID_PRODUIT);
	   } else { //in top vente
			$this->SetTopVente($ID_PRODUIT);
	   }
	}
	public function AnnulTopVente($ID_PRODUIT) 
	{
		$db_data = $this->SelectTopVente($ID_PRODUIT);
	   if($db_data==null) { //produit not in topvente
			
	   } else { //in top vente
			$nb_vente = $db_data->NOMBRE_VENTE;
			if($nb_vente>1) {
				$this->SetTopVente2($ID_PRODUIT);
			} else {
				$this->DelletTopVente($ID_PRODUIT);
			}
			
	   }
	}
	public function Setstatut($ID_FACTURE,$statut) 
	{
		$this->db->set('STATUT',$statut);
		$this->db->where('ID_FACTURE',(int) $ID_FACTURE);
		return $this->db->update($this->tbfacture);
	}
	public function DelletePaiement($ID_PAIEMENT) {
		
			return $this->db->where('ID_PAIEMENT', $ID_PAIEMENT)
			->delete($this->tbpaiement);
		
	}
	public function SelectFacture() 
	{
	   return $this->db->select('*')
	   ->from($this->tbfacture)
	   ->get()
	   ->result();
	}
	public function SelectFactureByid($ID_FACTURE) 
	{
	   return $this->db->select('*')
	   ->from($this->tbfacture)
	   ->where('ID_FACTURE', $ID_FACTURE)
	   ->get()
	   ->row();
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
	public function SelectPaiement($ID_FACTURE) 
	{
	   return $this->db->select('*')
	   ->from($this->tbpaiement)
	   ->where('ID_FACTURE', $ID_FACTURE)
	   ->order_by('DATE_PAIEMENT', 'ASC')
	   ->get()
	   ->result();
	}
	public function SelectSumPaiement($ID_FACTURE) 
	{
	   return $this->db->select('sum(PAYER) as total_payer')
	   ->from($this->tbpaiement)
	   ->where('ID_FACTURE', $ID_FACTURE)
	   ->get()
	   ->row();
	}
	public function AjoutPaiement($ID_FACTURE,$PAYER) {
		$this->db->set('ID_FACTURE',$ID_FACTURE);
		$this->db->set('PAYER',$PAYER);
        $this->db->set('DATE_PAIEMENT','NOW()',false);
		return $this->db->insert($this->tbpaiement);
		
	}
	/*--------------PRODUIT-----------------*/
	public function AjouterProduit($ID_CATEGORIE,$ID_S_CATEGORIE,$ID_SS_CATEGORIE,$DESIGNATION,$PRIX_ACHAT,$PRIX_VENTE,$QUANTITE,$INFO,$DESCRIPTION,$STATUT)
	{
		$this->db->set('ID_CATEGORIE',$ID_CATEGORIE);
		$this->db->set('ID_S_CATEGORIE',$ID_S_CATEGORIE);
		$this->db->set('ID_SS_CATEGORIE',$ID_SS_CATEGORIE);
		$this->db->set('DESIGNATION',$DESIGNATION);
		$this->db->set('PRIX_ACHAT',$PRIX_ACHAT);
		$this->db->set('PRIX_VENTE',$PRIX_VENTE);
		$this->db->set('QUANTITE',$QUANTITE);
		$this->db->set('INFO',$INFO);
		$this->db->set('DESCRIPTION',$DESCRIPTION);
		$this->db->set('STATUT',$STATUT);
        $this->db->set('DATE_AJOUT_PD','NOW()',false);
		return $this->db->insert($this->tbProduit);
		
	}
	public function SelectMaxId() 
	{
		$query =  $this->db->query("select MAX(ID_PRODUIT) as MAX_ID from produit");
		foreach($query->result() as $ligne) {
			return $ligne->MAX_ID;
	   }
	}
	/******************FICHE********************** */
	public function AjouterValeur($ID_FICHE_TQ_STITRE,$ID_PRODUIT,$ID_FICHE_TQ_TITRE,$VALEUR) {
		$this->db->set('ID_FICHE_TQ_STITRE',$ID_FICHE_TQ_STITRE);
		$this->db->set('ID_PRODUIT',$ID_PRODUIT);
		$this->db->set('ID_FICHE_TQ_TITRE',$ID_FICHE_TQ_TITRE);
		$this->db->set('VALEUR',$VALEUR);
		return $this->db->insert($this->tbfiche_tq_valeur);
	}
	public function AjouterFicheT1($ID_SS_CATEGORIE,$FTITRE)
	{
		$this->db->set('ID_SS_CATEGORIE',$ID_SS_CATEGORIE);
		$this->db->set('FTITRE',$FTITRE);
		return $this->db->insert($this->tbfiche_tq_titre);
	}
	public function SelectFicheT1($ID_SS_CATEGORIE) {
		
		return $this->db->select('*')
		->from($this->tbfiche_tq_titre)
		->order_by("FORDRE","asc")
		->where('ID_SS_CATEGORIE', $ID_SS_CATEGORIE)
		->get()
		->result();
	}
	public function SelectFicheT2($ID_FICHE_TQ_TITRE) {
		
		return $this->db->select('*')
		->from($this->tbfiche_tq_stitre)
		->order_by("FSORDRE","asc")
		->where('ID_FICHE_TQ_TITRE', $ID_FICHE_TQ_TITRE)
		->get()
		->result();
	}
	public function CheckFicheT1($ID_SS_CATEGORIE,$FTITRE) {
		
		$result =  $this->db->select('*')
		->from($this->tbfiche_tq_titre)
		->where('ID_SS_CATEGORIE', $ID_SS_CATEGORIE)
		->where('FTITRE', $FTITRE)
		->get()
		->result();
		$num = count($result);
		if($num>0) {
			return false;
		} else {
			return true;
		}
	}

	public function AjouterFicheT2($ID_FICHE_TQ_TITRE,$RECHERCHE,$FSTITRE)
	{	if($RECHERCHE=="true") {
			$RECHERCHE = 1;
		} else {
			$RECHERCHE = 0;
		}
		$this->db->set('ID_FICHE_TQ_TITRE',$ID_FICHE_TQ_TITRE);
		$this->db->set('RECHERCHE',$RECHERCHE);
		$this->db->set('FSTITRE',$FSTITRE);
		return $this->db->insert($this->tbfiche_tq_stitre);
	}
	public function CheckFicheT2($ID_FICHE_TQ_TITRE,$FSTITRE) {
		
		$result =  $this->db->select('*')
		->from($this->tbfiche_tq_stitre)
		->where('ID_FICHE_TQ_TITRE', $ID_FICHE_TQ_TITRE)
		->where('FSTITRE', $FSTITRE)
		->get()
		->result();
		$num = count($result);
		if($num>0) {
			return false;
		} else {
			return true;
		}
	}
	/*--------------CATEGORIE-----------------*/
	public function AjouterCategorie($titre)
	{
		$this->db->set('CTITRE',$titre);
		return $this->db->insert($this->tbCategorie);
    }
    public function AjouterSCategorie($id_categorie,$titre)
	{
		$this->db->set('ID_CATEGORIE',$id_categorie);
		$this->db->set('CSTITRE',$titre);
		return $this->db->insert($this->tbSCategorie);
    }
    public function AjouterSSCategorie($id_categorie,$id_s_categorie,$titre)
	{
		$this->db->set('ID_CATEGORIE',$id_categorie);
		$this->db->set('ID_S_CATEGORIE',$id_s_categorie);
		$this->db->set('CSSTITRE',$titre);
		return $this->db->insert($this->tbSSCategorie);
	}
	public function SelectCat() 
	{
		return $this->db->select('*')
		->from($this->tbCategorie)
		->get()
		->result();
	}
	public function SelectWIdCat2($ID_CATEGORIE) 
	{
        $where = array('ID_CATEGORIE'=> $ID_CATEGORIE);
		$data = $this->db->select('*')
		->from($this->tbCategorie)
		->Where($where)
		->get()
        ->result();
        foreach($data as $data) {
            return $data->CTITRE;
        }
    }
    public function SelectSCat() 
	{
		return $this->db->select('*')
		->from($this->tbSCategorie)
		->get()
		->result();
	}
	public function SelectWIdSCat2($ID_S_CATEGORIE) 
	{
        $where = array('ID_S_CATEGORIE'=> $ID_S_CATEGORIE);
		$data = $this->db->select('*')
		->from($this->tbSCategorie)
		->Where($where)
		->get()
        ->result();
        foreach($data as $data) {
            return $data->CSTITRE;
        }
    }
	public function SelectSSCat() 
	{
		return $this->db->select('*')
		->from($this->tbSSCategorie)
		->get()
		->result();
	}
	public function SelectWIdSSCat2($ID_SS_CATEGORIE) 
	{
        $where = array('ID_SS_CATEGORIE'=> $ID_SS_CATEGORIE);
		$data = $this->db->select('*')
		->from($this->tbSSCategorie)
		->Where($where)
		->get()
        ->result();
        foreach($data as $data) {
            return $data->CSSTITRE;
        }
    }
	//SELECT WHERE TITRE
	public function SelectIdCat($categorie) 
	{
        $where = array('CTITRE'=> $categorie);
		$data = $this->db->select('*')
		->from($this->tbCategorie)
		->Where($where)
		->get()
        ->result();
        foreach($data as $data) {
            return $data->ID_CATEGORIE;
        }
    }
    public function SelectIdSCat($scategorie) 
	{
        $where = array('CSTITRE'=> $scategorie);
		$data = $this->db->select('*')
		->from($this->tbSCategorie)
		->Where($where)
		->get()
        ->result();
        foreach($data as $data) {
             return $data->ID_S_CATEGORIE;
        }
    
	}
	//SELECT WHERE ID
	public function SelectWidSCat($ID_CATEGORIE) 
	{
        $where = array('ID_CATEGORIE'=> $ID_CATEGORIE);
		return $this->db->select('*')
		->from($this->tbSCategorie)
		->Where($where)
		->get()
        ->result();
	}
	public function SelectWidSSCat($ID_CATEGORIE,$ID_S_CATEGORIE) 
	{
        $where = array('ID_CATEGORIE'=>$ID_CATEGORIE,'ID_S_CATEGORIE'=> $ID_S_CATEGORIE);
		return $this->db->select('*')
		->from($this->tbSSCategorie)
		->Where($where)
		->get()
        ->result();
    
    }
    public function SelectUniqueSCat($id_categorie,$categorie) 
	{
        $where = array('ID_CATEGORIE'=>$id_categorie,'CSTITRE'=> $categorie);
		return $this->db->select('*')
		->from($this->tbSCategorie)
		->Where($where)
		->get()
        ->result();
    
    }
    public function SelectUniqueSSCat($id_categorie,$id_scategorie,$sscategorie) 
	{
        $where = array('ID_CATEGORIE'=>$id_categorie,'ID_S_CATEGORIE'=>$id_scategorie,'CSSTITRE'=> $sscategorie);
		return $this->db->select('*')
		->from($this->tbSSCategorie)
		->Where($where)
		->get()
        ->result();
    
    }
    public function SelectIdSSCat($sscategorie) 
	{
        $where = array('CSSTITRE'=> $sscategorie);
		$data = $this->db->select('*')
		->from($this->tbSSCategorie)
		->Where($where)
		->get()
        ->result();
        foreach($data as $data) {
            return $data->ID_SS_CATEGORIE;
        }
    }
    
    /** 
    public function Setprofil($id,$profil) 
	{
		$this->db->set('profil',$profil);
		$this->db->where('id_etudiant',(int) $id);
		return $this->db->update($this->table);
	}
	///RESULTAT
	public function SelectWhereResultat($where=array()) 
	{
		return $this->db->select('*')
		->from($this->tableresultat)
		->Where($where)
		->get()
		->result();
	}
	public function Selectresultatmatiere($id_etudiant) 
	{
		$data[1]=$id_etudiant;
		$query =  $this->db->query('select * from resultat group by nom_matiere',$data);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
	}**/
	
}
?>