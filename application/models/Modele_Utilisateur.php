<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Modele_Utilisateur extends CI_Model
{
	protected $table = 'utilisateur';
	protected $tableresultat = 'resultat';
	public function AjouterUtilisateur($civilite,$email,$mdp,$nom,$prenom,$date)
	{
		$this->db->set('CIVILITE',$civilite);
		$this->db->set('EMAIL',$email);
		$this->db->set('MDP',$mdp);
		$this->db->set('NOM',$nom);
		$this->db->set('PRENOM',$prenom);
		$this->db->set('DATE_DE_NAISSANCE',$date);
        $this->db->set('DATE_INSCRIPTION','NOW()',false);
		
		return $this->db->insert($this->table);
	}
	public function Select() 
	{
		return $this->db->select('*')
		->from($this->table)
		->get()
		->result();
	}
	
	public function SelectWhere($where=array()) 
	{
		return $this->db->select('*')
		->from($this->table)
		->Where($where)
		->get()
		->result();
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