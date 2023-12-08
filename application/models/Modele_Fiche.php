<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Modele_Fiche extends CI_Model
{
	protected $tbfiche1 = 'fiche_tq_titre';
	protected $tbfiche2 = 'fiche_tq_stitre';
    protected $tbfichevaleur = 'fiche_tq_valeur';
    public function TestFiche($ID_PRODUIT) 
	{
        $where[1]=$ID_PRODUIT;
		$query =  $this->db->query("select * from fiche_tq_stitre join fiche_tq_valeur on fiche_tq_valeur.ID_FICHE_TQ_STITRE = fiche_tq_stitre.ID_FICHE_TQ_STITRE where id_produit=?  ORDER BY FSORDRE ASC",$where);
        return count($query->result());

	}
    public function SelectFicheT1($ID_PRODUIT) 
	{
        $where[1]=$ID_PRODUIT;
		$query =  $this->db->query("select * from fiche_tq_titre where ID_FICHE_TQ_TITRE in(select fiche_tq_stitre.ID_FICHE_TQ_TITRE from fiche_tq_stitre join fiche_tq_valeur on fiche_tq_valeur.ID_FICHE_TQ_STITRE = fiche_tq_stitre.ID_FICHE_TQ_STITRE where id_produit=19 group by ID_FICHE_TQ_TITRE) ORDER BY FORDRE ASC",$where);
        return $query->result();

	}
	public function SelectFicheT2($ID_PRODUIT,$ID_FICHE_TQ_TITRE) 
	{
        $where[1]=$ID_PRODUIT;
        $where[2]=$ID_FICHE_TQ_TITRE;
		$query =  $this->db->query("select * from fiche_tq_stitre join fiche_tq_valeur on fiche_tq_valeur.ID_FICHE_TQ_STITRE = fiche_tq_stitre.ID_FICHE_TQ_STITRE where ID_PRODUIT=? and fiche_tq_stitre.ID_FICHE_TQ_TITRE=? ORDER BY FSORDRE ASC",$where);
        return $query->result();
    }
    
}
?>