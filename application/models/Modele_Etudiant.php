<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Modele_Etudiant extends CI_Model
{
	protected $table = 'etudiant';
	protected $tableresultat = 'resultat';
	public function AjouterEtudiant($civilite,$nom,$prenom,$email,$mot_de_passe)
	{
		$this->db->set('civilite',$civilite);
		$this->db->set('nom',$nom);
		$this->db->set('prenom',$prenom);
		$this->db->set('email',$email);
		$this->db->set('mot_de_passe',$mot_de_passe);
		$this->db->set('profil',1);
        $this->db->set('date_ajout','NOW()',false);
		
		return $this->db->insert($this->table);
	}
	public function Select() 
	{
		return $this->db->select('*')
		->from($this->table)
		->get()
		->result();
	}
	public function Setprofil($id,$profil) 
	{
		$this->db->set('profil',$profil);
		$this->db->where('id_etudiant',(int) $id);
		return $this->db->update($this->table);
	}
	public function SelectWhere($where=array()) 
	{
		return $this->db->select('*')
		->from($this->table)
		->Where($where)
		->get()
		->result();
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
	}
	
}
?>