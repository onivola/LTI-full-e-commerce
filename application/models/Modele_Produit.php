<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Modele_Produit extends CI_Model
{
	protected $tbProduit = 'produit';
	protected $tbPanier = 'panier';
	/*--------------PRODUIT-----------------*/

	public function SelectProduit($ID_CATEGORIE,$ID_S_CATEGORIE,$ID_SS_CATEGORIE,$data) 
	{
        $desc = 'order by DATE_AJOUT_PD desc';
        $where[1]=$ID_CATEGORIE;
        $where[2]=$ID_S_CATEGORIE;
        $where[3]=$ID_SS_CATEGORIE;
		$query =  $this->db->query("select * from produit where ID_CATEGORIE=? && ID_S_CATEGORIE = ? && ID_SS_CATEGORIE = ? ".$desc."",$where);
		$queryprice =  $this->db->query("select max(PRIX_VENTE) as rightprice from produit where ID_CATEGORIE=? && ID_S_CATEGORIE = ? && ID_SS_CATEGORIE = ? ".$desc."",$where);
		
		$bdprice = $queryprice->row();
		$data['leftprice'] = 0;
		$data['rightprice'] = $bdprice->rightprice;
		$data['bdd_produit'] = $query->result();
		return $data;
        /**foreach($query->result() as $ligne) {
			return $ligne->MAX_ID;
	   }**/
	}


	/***----------------LIEN---------------------------** */
	public function SelectProduitLien($ID_CATEGORIE,$ID_S_CATEGORIE,$ID_SS_CATEGORIE) 
	{
		$tbcategorie = array();
		$data_categorie = $this->db->select('*')->from('categorie')->where('ID_CATEGORIE', $ID_CATEGORIE)->get()->result();
		foreach($data_categorie as $data_categorie) {
			$tbctegorie[0] = $data_categorie->CTITRE;
	   }
		$data_scategorie = $this->db->select('*')->from('s_categorie')->where('ID_S_CATEGORIE', $ID_S_CATEGORIE)->get()->result();
		foreach($data_scategorie as $data_scategorie) {
			$tbctegorie[1] = $data_scategorie->CSTITRE;
	   }
		$data_sscategorie = $this->db->select('*')->from('ss_categorie')->where('ID_SS_CATEGORIE', $ID_SS_CATEGORIE)->get()->result();
		foreach($data_sscategorie as $data_sscategorie) {
			$tbctegorie[2] = $data_sscategorie->CSSTITRE;
	   }
	   return $tbctegorie;
	}
	public function SelectProduitById($ID_PRODUIT) 
	{
		
			return $this->db->select('*')
			->from($this->tbProduit)
			->where('ID_PRODUIT', $ID_PRODUIT)
			->get()
			->result();
	}
	/********************RECHERCHE ****************** */
	public function findProduitAll($find) //tout rechercher
	{
		$find = '%'.$find.'%';
		$dataw[1] = $find;
		$dataw[2] = $find;
		$dataw[3] = $find;
		$query =  $this->db->query("select *,max(nb_produit) as produit_max from(select *,count(ID_SS_CATEGORIE) as nb_produit From Produit where (DESIGNATION LIKE ? OR INFO LIKE ? OR DESCRIPTION LIKE ?) group by ID_SS_CATEGORIE)as subquery",$dataw);
		$bdd_produit = $query->row();
	   	return $bdd_produit;
	}
	public function findProduitRn($find,$ID_CATEGORIE) //recherche avec rayon
	{
		$dataw[1] = $ID_CATEGORIE;
		$find = '%'.$find.'%';
		$dataw[2] = $find;
		$dataw[3] = $find;
		$dataw[4] = $find;
		$query =  $this->db->query("select *,max(nb_produit) as produit_max from(select *,count(ID_SS_CATEGORIE) as nb_produit From Produit where ID_CATEGORIE=? AND (DESIGNATION LIKE ? OR INFO LIKE ? OR DESCRIPTION LIKE ?) group by ID_SS_CATEGORIE)as subquery",$dataw);
		$bdd_produit = $query->row();
	   	return $bdd_produit;
	
		
	}
	/*********************RECHERCHE FILTRE***************** */
	public function SelectFiltreProduit($ID_SS_CATEGORIE,$id_stitre, $data,$stbidvaleur,$stbidstitre) {
		$dataw[1] = $ID_SS_CATEGORIE;
		

		
		//var_dump($stbidvaleur);
		//var_dump($stbidstitre);
		//var_dump($id_stitre);
		/**
		 * array (size=1)
			'PRICE' => 
				array (size=2)
				0 => string '1798' (length=4)
				1 => string '7999' (length=4)

			array (size=1)
			0 => string 'PRICE' (length=5)

		 * 
		 */
		$sql = "select produit.*,ID_SS_CATEGORIE,fiche_tq_stitre.ID_FICHE_TQ_STITRE, FSTITRE,ID_FICHE_TQ_VALEUR, VALEUR from fiche_tq_valeur join produit on fiche_tq_valeur.ID_PRODUIT = produit.ID_PRODUIT join fiche_tq_stitre on fiche_tq_stitre.ID_FICHE_TQ_STITRE = fiche_tq_valeur.ID_FICHE_TQ_STITRE where ID_SS_CATEGORIE=?";
		$query =  $this->db->query($sql,$dataw); // OR DESCRIPTION like ? OR PRIX LIKE ?
		
		

		$nbvaleur = 0; $nbrow = 0; $countftitre = count($stbidstitre); $vprice=false; $vskey = false; $vtri = false;
		for($i=0;$i<count($stbidstitre);$i++) { //verif price value
			if($stbidstitre[$i]=='PRICE') {
				$vprice=true;
			} else if($stbidstitre[$i]=='SKEY'){
				$vskey=true;
			} else if($stbidstitre[$i]=='TRI'){
				$vtri=true;
				$data['tri']=$stbidvaleur['TRI'][0];
			}
		}
		if($vprice==true) { $countftitre--; }
		if($vskey==true) { $countftitre--; }
		if($vtri==true) { $countftitre--; }
		$idi=0; $tbid_produit=null;
		$datafirst = $query->row();
		
		//echo "FIRST ROW|".$datafirst->ID_PRODUIT."|".$datafirst->DESIGNATION."|".$datafirst->ID_FICHE_TQ_STITRE."|".$datafirst->FSTITRE."|".$datafirst->VALEUR."|</br>";
		$tempID_PRODUIT = $datafirst->ID_PRODUIT;
		$datapjoin = $query->result();
		foreach($datapjoin as $datapjoin) { //boucle produit
			if($nbrow>0) {
				//echo $nbvaleur."|".$datapjoin->DESIGNATION."|".$datapjoin->ID_FICHE_TQ_STITRE."|".$datapjoin->FSTITRE."|".$datapjoin->VALEUR."|</br>";
				if($tempID_PRODUIT!=$datapjoin->ID_PRODUIT) {
					$tempID_PRODUIT=$datapjoin->ID_PRODUIT;
					$nbvaleur=0;
				}	
				for($i=0;$i<count($stbidstitre);$i++) { //boucle FSTITRE
					if($stbidstitre[$i]==$datapjoin->ID_FICHE_TQ_STITRE) { //si BSTITRE in FSTITRE
						for($j=0;$j<count($stbidvaleur[$stbidstitre[$i]]);$j++) {// boucle FVALEUR
							if($stbidvaleur[$stbidstitre[$i]][$j]==$datapjoin->VALEUR) { //FVALEUR = BVALEUR
								$nbvaleur++; 
								//echo $nbvaleur."|".$datapjoin->ID_PRODUIT."|".$datapjoin->DESIGNATION."|".$datapjoin->ID_FICHE_TQ_STITRE."|".$datapjoin->FSTITRE."|".$datapjoin->VALEUR."|</br>";
								if($nbvaleur==$countftitre) {
									$tbid_produit[$idi] = $datapjoin->ID_PRODUIT; //list id produit trier
									$idi++;
								}
							}
						} 
					}
				}
			}
			$nbrow++;
		}
		
		if($tbid_produit!=null) { //resultat existe
			$wherein = ""; $where=""; $wheretri="";
			for($i=0;$i<count($tbid_produit);$i++) {
				if($i==0) {
					$wherein = "'".$tbid_produit[$i]."'";
				} else {
					$wherein = $wherein.",'".$tbid_produit[$i]."'";
				}
			}
			if($vskey==true) {
				$wdesignation ='\'%'.$stbidvaleur['SKEY'][0].'%\''; $winfo='\'%'.$stbidvaleur['SKEY'][0].'%\''; $wdescription = '\'%'.$stbidvaleur['SKEY'][0].'%\'';
				
				$where = "AND (DESIGNATION LIKE ".$wdesignation." OR INFO LIKE ".$winfo." OR DESCRIPTION LIKE ".$wdescription.")";
			}
			if($vtri==true) {
				if($stbidvaleur['TRI'][0]=='new') {
					$wheretri = $wheretri." order by DATE_AJOUT_PD desc";
				}
				else if($stbidvaleur['TRI'][0]=='priceasc') {
					$wheretri = $wheretri." order by PRIX_VENTE asc";
				} else if($stbidvaleur['TRI'][0]=='pricedesc') {
					$wheretri = $wheretri." order by PRIX_VENTE desc";
				} else if($stbidvaleur['TRI'][0]=='stock') {
					$where = $where." AND QUANTITE>0 AND STATUT=1";
				}
				
			}
			if($vprice==true) {
				$where = $where." AND PRIX_VENTE>=".$stbidvaleur['PRICE'][0]." AND PRIX_VENTE<=".$stbidvaleur['PRICE'][1]."";
				$data['leftprice'] = $stbidvaleur['PRICE'][0];
				$data['rightprice'] = $stbidvaleur['PRICE'][1];
			} else if($vprice==false) { // select max price
		
				$sql1 = "select max(PRIX_VENTE) as rightprice from produit where ID_PRODUIT in(".$wherein.")".$where.$wheretri.""; 
				$query1 =  $this->db->query($sql1); // OR DESCRIPTION like ? OR PRIX LIKE ?
				$dataprice = $query1->row();
				//var_dump($dataprice);
				$data['leftprice'] = 0;
				$data['rightprice'] = $dataprice->rightprice;
				if($data['rightprice']==null) {
					$data['rightprice']=0;
				}
			}
		
			$sql = "select * from produit where ID_PRODUIT in(".$wherein.")".$where.$wheretri.""; 
			$query =  $this->db->query($sql); // OR DESCRIPTION like ? OR PRIX LIKE ?
			$data['bdd_produit']=  $query->result(); //list produit trier
			return $data;
		} else { // aucun resultat
			$where2=""; $wheretri="";
			if($vskey==true) {
				$wdesignation ='\'%'.$stbidvaleur['SKEY'][0].'%\''; $winfo='\'%'.$stbidvaleur['SKEY'][0].'%\''; $wdescription = '\'%'.$stbidvaleur['SKEY'][0].'%\'';
				$where2 = " AND (DESIGNATION LIKE ".$wdesignation." OR INFO LIKE ".$winfo." OR DESCRIPTION LIKE ".$wdescription.")";
			}
			if($vtri==true) {
				if($stbidvaleur['TRI'][0]=='new') {
					$wheretri = $wheretri." order by DATE_AJOUT_PD desc";
				}
				else if($stbidvaleur['TRI'][0]=='priceasc') {
					$wheretri = $wheretri." order by PRIX_VENTE asc";
				} else if($stbidvaleur['TRI'][0]=='pricedesc') {
					$wheretri = $wheretri." order by PRIX_VENTE desc";
				} else if($stbidvaleur['TRI'][0]=='stock') {
					$where2 = $where2." AND QUANTITE>0 AND STATUT=1";
				}
				
			}
			if($vprice==true) { //no resultat but onli price
				$sql = "select produit.*,ID_SS_CATEGORIE,fiche_tq_stitre.ID_FICHE_TQ_STITRE, FSTITRE,ID_FICHE_TQ_VALEUR, VALEUR from fiche_tq_valeur join produit on fiche_tq_valeur.ID_PRODUIT = produit.ID_PRODUIT join fiche_tq_stitre on fiche_tq_stitre.ID_FICHE_TQ_STITRE = fiche_tq_valeur.ID_FICHE_TQ_STITRE where ID_SS_CATEGORIE = ".$ID_SS_CATEGORIE." AND PRIX_VENTE>=".$stbidvaleur['PRICE'][0]." AND PRIX_VENTE<=".$stbidvaleur['PRICE'][1].$where2." group by ID_PRODUIT".$wheretri.""; 
				$query =  $this->db->query($sql); // OR DESCRIPTION like ? OR PRIX LIKE ?
				$data['bdd_produit'] =   $query->result(); //list produit trier
				$data['leftprice'] = $stbidvaleur['PRICE'][0];
				$data['rightprice'] = $stbidvaleur['PRICE'][1];
				return $data;
			} else if($vprice==false) { // no resultat, all value but no price
				
				$sql1 = "select MAX(PRIX_VENTE) AS rightprice, produit.*,ID_SS_CATEGORIE,fiche_tq_stitre.ID_FICHE_TQ_STITRE, FSTITRE,ID_FICHE_TQ_VALEUR, VALEUR from fiche_tq_valeur join produit on fiche_tq_valeur.ID_PRODUIT = produit.ID_PRODUIT join fiche_tq_stitre on fiche_tq_stitre.ID_FICHE_TQ_STITRE = fiche_tq_valeur.ID_FICHE_TQ_STITRE where ID_SS_CATEGORIE = ".$ID_SS_CATEGORIE.$where2.$wheretri.""; 
				$query1 =  $this->db->query($sql1); // OR DESCRIPTION like ? OR PRIX LIKE ?
				$dataprice = $query1->row();
				$data['leftprice'] = 0;
				$data['rightprice'] = $dataprice->rightprice;
				$data['bdd_produit']=null;
				if($data['rightprice']==null) {
					$data['rightprice']=0;
				} else {
					$sql = "select produit.*,ID_SS_CATEGORIE,fiche_tq_stitre.ID_FICHE_TQ_STITRE, FSTITRE,ID_FICHE_TQ_VALEUR, VALEUR from fiche_tq_valeur join produit on fiche_tq_valeur.ID_PRODUIT = produit.ID_PRODUIT join fiche_tq_stitre on fiche_tq_stitre.ID_FICHE_TQ_STITRE = fiche_tq_valeur.ID_FICHE_TQ_STITRE where ID_SS_CATEGORIE = ".$ID_SS_CATEGORIE.$where2." group by ID_PRODUIT".$wheretri."" ; 
					$query =  $this->db->query($sql); // OR DESCRIPTION like ? OR PRIX LIKE ?
					$data['bdd_produit'] =   $query->result(); //list produit trier
				}
				//$data['leftprice'] = 0;
				//$data['rightprice'] = 10;
				//$data['bdd_produit']=null;
				return $data;
			}
			
		}
	
	}
	
	public function SelectValueFiltre($ID_SS_CATEGORIE,$fidtitre,$fvaleur,$stbidstitre,$stbvaleur) {

		$wherein = "";
		$verifval = 0; $veriftitre=0; $itr = 0;
		for($i=0;$i<count($stbidstitre);$i++) {
			if($stbidstitre[$i]==$fidtitre) { //
				$veriftitre++;
				$itr = $i; // prendre i
				for($j=0;$j<count($stbvaleur[$i]);$j++) {
					if($stbvaleur[$i][$j]==$fvaleur) { //si fvaleur existe dans $stbvaleur
						$verifval++;
					}
				}
			}
		}
		//echo $veriftitre;
		//echo $verifval;
		//var_dump($tbidvaleur[3]);
		//var_dump($tbidvaleur[2]);
		if($veriftitre==0 && $verifval==0) { //fvaleur et ftitre n'existe pas
			//echo count($stbidstitre);
			$stbidstitre[count($stbidstitre)] = $fidtitre; //ajout titre
			$i = count($stbvaleur);
			$stbvaleur[$i][0]=$fvaleur; //ajout valeur
		} else if($veriftitre>0 && $verifval==0) { //fvaleur n'existe pas
			unset($stbvaleur[$itr]);
			$stbvaleur[$itr][0]=$fvaleur;
		} else if($veriftitre>0 && $verifval>0) {
			unset($stbvaleur[$itr]);
			$stbvaleur[$itr][0]=$fvaleur;
		}
		//all valeur in one tab
		$tballvaleur = array(); $iall=0;
		for($i=0;$i<count($stbvaleur);$i++) {
			for($j=0;$j<count($stbvaleur[$i]);$j++) {
				$tballvaleur[$iall] = $stbvaleur[$i][$j];
				$iall++;
			}
		}
		//tab fvaleur avec indice ftitre
		$stbidvaleur = array();
		for($i=0;$i<count($stbidstitre);$i++) {
			$stbidvaleur[$stbidstitre[$i]] = $stbvaleur[$i];
		}
		//where and where in
		$wherein = ""; $nbwin = 0;
		for($i=0;$i<count($tballvaleur);$i++) {
			if($i==0) {
				$wherein = "'".$tballvaleur[$i]."'";
				$nbwin++;
			} else {
				$wherein = $wherein.",'".$tballvaleur[$i]."'";
				$nbwin++;
			}
		}
		
		//var_dump($stbidstitre);
		//var_dump($stbidvaleur);
		//echo $wherein;
		//echo $nbwin."</br>";

		$dataw[1] = $ID_SS_CATEGORIE; $where=""; $vprice=false; $vskey=false; $vtri = false; $countftitre = count($stbidstitre); 
		for($i=0;$i<count($stbidstitre);$i++) { //verif price value
			if($stbidstitre[$i]=='PRICE') {
				$vprice=true;
			} else if($stbidstitre[$i]=='TRI'){
				$vtri=true;
			}
		}
		if($vskey==true) {
			$wdesignation ='\'%'.$stbidvaleur['SKEY'][0].'%\''; $winfo='\'%'.$stbidvaleur['SKEY'][0].'%\''; $wdescription = '\'%'.$stbidvaleur['SKEY'][0].'%\'';
			
			$where = " AND (DESIGNATION LIKE ".$wdesignation." OR INFO LIKE ".$winfo." OR DESCRIPTION LIKE ".$wdescription.")";
			$countftitre--; 
		}
		if($vprice==true) {
			$where = $where." AND PRIX_VENTE>=".$stbidvaleur['PRICE'][0]." AND PRIX_VENTE<=".$stbidvaleur['PRICE'][1]."";
			$countftitre--; 
		}
		if($vtri==true) { 
			if($stbidvaleur['TRI'][0]=='stock') {
				$where = $where." AND QUANTITE>0 AND STATUT=1";
			}
			$countftitre--; 
		}
		$sql = "select produit.*,ID_SS_CATEGORIE,fiche_tq_stitre.ID_FICHE_TQ_STITRE, FSTITRE,ID_FICHE_TQ_VALEUR, VALEUR from fiche_tq_valeur join produit on fiche_tq_valeur.ID_PRODUIT = produit.ID_PRODUIT join fiche_tq_stitre on fiche_tq_stitre.ID_FICHE_TQ_STITRE = fiche_tq_valeur.ID_FICHE_TQ_STITRE where ID_SS_CATEGORIE=?".$where."";
		$query =  $this->db->query($sql,$dataw); // OR DESCRIPTION like ? OR PRIX LIKE ?

		$nbvaleur = 0; $nbrow = 0; 
		
		$countvaleur = 0;
		
		$datafirst = $query->row();
		if($datafirst==null) {
			return 0;
		} else {
			//echo "FIRST ROW|".$datafirst->ID_PRODUIT."|".$datafirst->DESIGNATION."|".$datafirst->ID_FICHE_TQ_STITRE."|".$datafirst->FSTITRE."|".$datafirst->VALEUR."|</br>";
			$tempID_PRODUIT = $datafirst->ID_PRODUIT;
			$data = $query->result();
			
			foreach($data as $data) { //boucle produit
				if($nbrow>0) {
					//echo $nbvaleur."|".$data->DESIGNATION."|".$data->ID_FICHE_TQ_STITRE."|".$data->FSTITRE."|".$data->VALEUR."|</br>";
					if($tempID_PRODUIT!=$data->ID_PRODUIT) {
						$tempID_PRODUIT=$data->ID_PRODUIT;
						$nbvaleur=0;
					}	
					for($i=0;$i<count($stbidstitre);$i++) { //boucle FSTITRE
						if($stbidstitre[$i]==$data->ID_FICHE_TQ_STITRE) { //si BSTITRE in FSTITRE
							for($j=0;$j<count($stbidvaleur[$stbidstitre[$i]]);$j++) {// boucle FVALEUR
								if($stbidvaleur[$stbidstitre[$i]][$j]==$data->VALEUR) {
									$nbvaleur++; 
									//echo $nbvaleur."|".$data->ID_PRODUIT."|".$data->DESIGNATION."|".$data->ID_FICHE_TQ_STITRE."|".$data->FSTITRE."|".$data->VALEUR."|</br>";
									if($nbvaleur==$countftitre) { $countvaleur++; } //compter le nombre de produit du filtre
								}
							} 
						}
					}
				}
				$nbrow++;
			}
			return $countvaleur;
		}

		
	}
	public function SelectValue($ID_FICHE_TQ_STITRE) {
		$data[1] = $ID_FICHE_TQ_STITRE;
		$query =  $this->db->query('select *, count(VALEUR) as NB_VALEUR from fiche_tq_valeur where ID_FICHE_TQ_STITRE=? group by VALEUR ORDER BY VORDRE ASC',$data);// OR DESCRIPTION like ? OR PRIX LIKE ?
		return $query->result();
	}
	public function SelectFiltre($ID_SS_CATEGORIE)
	{
		$data[1] = $ID_SS_CATEGORIE;
		$query =  $this->db->query('SELECT * FROM fiche_tq_stitre WHERE ID_FICHE_TQ_TITRE in (select ID_FICHE_TQ_TITRE from fiche_tq_titre where ID_SS_CATEGORIE=?) AND RECHERCHE !=0 order by RECHERCHE asc',$data);// OR DESCRIPTION like ? OR PRIX LIKE ?
		return $query->result();	
	}
	/********************PANIER********************* */
	public function DelletePanier($ID_UTILISATEUR,$ID_PRODUIT) {
		
			return $this->db->where('ID_UTILISATEUR', $ID_UTILISATEUR)
			->where('ID_PRODUIT', $ID_PRODUIT)
			->delete($this->tbPanier);
		
	}
	public function SelectPanierJoin($ID_UTILISATEUR) 
	{
        $order = 'order by DATE_AJOUT_PN asc';
        $where[1]=$ID_UTILISATEUR;
		$query =  $this->db->query("select * from panier join produit on panier.ID_PRODUIT = produit.ID_PRODUIT where ID_UTILISATEUR = ? ".$order,$where);
        return $query->result();
        /**foreach($query->result() as $ligne) {
			return $ligne->MAX_ID;
	   }**/
	}
	public function SelectPanierJoin2($ID_UTILISATEUR,$ID_PRODUIT) 
	{
        $order = 'order by DATE_AJOUT_PN asc';
        $where[1]=$ID_UTILISATEUR;
        $where[2]=$ID_PRODUIT;
		$query =  $this->db->query("select * from panier join produit on panier.ID_PRODUIT = produit.ID_PRODUIT where ID_UTILISATEUR = ? AND panier.ID_PRODUIT = ? ".$order,$where);
        return $query->result();
	}
	public function AjoutPanier($ID_UTILISATEUR,$ID_PRODUIT,$QUANTITE_PN) 
	{
		$this->db->set('ID_UTILISATEUR',$ID_UTILISATEUR);
		$this->db->set('ID_PRODUIT',$ID_PRODUIT);
		$this->db->set('QUANTITE_PN',$QUANTITE_PN	);
		$this->db->set('DATE_AJOUT_PN','NOW()',false);
		return $this->db->insert($this->tbPanier);
	}
	public function SetQuantitePd($ID_PRODUIT,$QUANTITE_PN) 
	{
		$this->db->set('QUANTITE',(int)$QUANTITE_PN);
		$this->db->where('ID_PRODUIT',(int)$ID_PRODUIT);
		return $this->db->update($this->tbProduit);
	}
	public function SelectPanier($ID_UTILISATEUR,$ID_PRODUIT) 
	{
		return $this->db->select('*')
		->from($this->tbPanier)
		->where('ID_UTILISATEUR', $ID_UTILISATEUR)
		->where('ID_PRODUIT', $ID_PRODUIT)
		->get()
		->result();
	}
	public function SelectPanierUts($ID_UTILISATEUR) 
	{
		return $this->db->select('*')
		->from($this->tbPanier)
		->where('ID_UTILISATEUR', $ID_UTILISATEUR)
		->get()
		->result();
	}
	public function SetQuantitePn($ID_PRODUIT,$ID_UTILISATEUR,$QUANTITE_PN) 
	{
		$this->db->set('QUANTITE_PN',(int)$QUANTITE_PN);
		$this->db->where('ID_PRODUIT', $ID_PRODUIT);
		$this->db->where('ID_UTILISATEUR', $ID_UTILISATEUR);
		return $this->db->update($this->tbPanier);
	}
	
	/**public function AddTab($tab,$tabadd) {
		$tabtemp=array();
		for($i=0;$i<count($tbadd);$i++) {

		}
	}**/
}
?>