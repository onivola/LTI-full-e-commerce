<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Modele_Matiere extends CI_Model
{
	protected $table = 'matiere';
	protected $rtable = 'r_enseignant_matiere';
	protected $tablequestion = 'question';
	protected $choixreponse = 'choix_reponse';
	public function AjouterMatiere($nom_matiere)
	{
		$this->db->set('nom_matiere',$nom_matiere);
		
		return $this->db->insert($this->table);
	}
	public function Select() 
	{
		return $this->db->select('*')
		->from($this->table)
		->get()
		->result();
	}
	
	public function Selectrelation($where)
	{
		
		$data[1]=$where;
		$query =  $this->db->query('select * from r_enseignant_matiere join matiere on r_enseignant_matiere.id_matiere=matiere.id_matiere where id_enseignant=?',$data);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
		//return 1;
	}
	public function Selectquestionmatiere($where)
	{
		
		$data[1]=$where;
		$query =  $this->db->query('select * from matiere join question on matiere.id_matiere = question.id_matiere where matiere.id_matiere=?',$data);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
		//return 1;
	}
	public function SelectWhere($where=array()) 
	{
		return $this->db->select('*')
		->from($this->table)
		->Where($where)
		->get()
		->result();
	}
	//r_enseignant_matiere
	public function Supprimeraffect($id_enseignant)
	{
		return $this->db->where('id_enseignant', (int)$id_enseignant)->delete($this->rtable);
	}
	///QUESTION
	public function Selectmaxidquestion() 
	{
		return $this->db->select('max(id_question) as maxid')
		->from($this->tablequestion)
		->get()
		->result();
	}
	//Choix_reponse
	public function Ajouterreponse($id_question,$reponse,$vrais)
	{
		$this->db->set('id_question',$id_question);
		$this->db->set('reponse',$reponse);
		$this->db->set('vrais',$vrais);
		
		return $this->db->insert($this->choixreponse);
	}
	//select * from r_enseignant_matiere join matiere on r_enseignant_matiere.id_matiere = matiere.id_matiere where id_enseignant=1;
	
}
?>