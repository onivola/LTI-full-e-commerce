<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Modele_Enseignant extends CI_Model
{
	protected $table = 'enseignant';
	protected $rtable = 'r_enseignant_matiere';
	protected $tablequestion = 'question';
	protected $tableexamen = 'examen';
	public function AjouterEtudiant($civilite,$nom,$prenom,$email,$mot_de_passe,$profil)
	{
		$this->db->set('civilite',$civilite);
		$this->db->set('nom',$nom);
		$this->db->set('prenom',$prenom);
		$this->db->set('email',$email);
		$this->db->set('mot_de_passe',$mot_de_passe);
		$this->db->set('profil',$profil);
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
	public function SelectWhere($where=array()) 
	{
		return $this->db->select('*')
		->from($this->table)
		->Where($where)
		->get()
		->result();
	}
	public function Setprofil($id,$profil) 
	{
		$this->db->set('profil',$profil);
		$this->db->where('id_enseignant',(int) $id);
		return $this->db->update($this->table);
	}
	public function AffectMaitiere($id_enseignant,$id_matiere)
	{
		$this->db->set('id_enseignant',$id_enseignant);
		$this->db->set('id_matiere',$id_matiere);
		return $this->db->insert($this->rtable);
	}
	function Checkrelation($id_enseignant,$id_matiere) {
		$this->db->select('*');
		$this->db->from($this->rtable);
		$this->db->where('id_enseignant', $id_enseignant);
		$this->db->where('id_matiere', $id_matiere);
		$query = $this->db->get();
		$num = $query->num_rows();
		if ($num > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function Ajouterquestion($id_matiere,$question,$point_negatif)
	{
		$this->db->set('id_matiere',$id_matiere);
		$this->db->set('question',$question);
		$this->db->set('point_negatif',$point_negatif	);
		return $this->db->insert($this->tablequestion);
	}
	//EXAMEN
	public function AjouterExamen($matiere,$nom_examen,$date_debut,$date_fin,$duree_total,$nb_question)
	{
		$this->db->set('id_matiere',$matiere);
		$this->db->set('nom_examen',$nom_examen);
		$this->db->set('date_debut',$date_debut);
		$this->db->set('date_fin',$date_fin);
		$this->db->set('duree_total',$duree_total);
		$this->db->set('nb_question',$nb_question);
		
		return $this->db->insert($this->tableexamen);
	}
	//select * from examen join matiere on examen.id_matiere=matiere.id_matiere;
	public function Selectexamen()
	{
		$query =  $this->db->query('select * from examen join matiere on examen.id_matiere=matiere.id_matiere');
		 $nb_resultat = $query->num_rows();
		 return $query->result();
		//return 1;
	}
	//select * from examen where id_examen not in(select id_examen from resultat where id_etudiant=2);
	public function Selectexamenpaspasser($id_etudiant)
	{
		$data[1]=$id_etudiant;
		$query =  $this->db->query('select * from examen join matiere on examen.id_matiere=matiere.id_matiere where id_examen not in(select id_examen from resultat where id_etudiant=?)',$data[1]);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
		//return 1;
	}
	
	public function Selectexamenenseignant()
	{
		$query =  $this->db->query('select * from examen join matiere on examen.id_matiere=matiere.id_matiere');
		 $nb_resultat = $query->num_rows();
		 return $query->result();
		//return 1;
	}
	public function Selectexamenparenseignant($id_enseignant)
	{
		$data[1]=$id_enseignant;
		$query =  $this->db->query('select * from examen join matiere on examen.id_matiere=matiere.id_matiere where matiere.id_matiere in(select id_matiere from r_enseignant_matiere where id_enseignant=?)',$data);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
	}
	public function Selectresultat($id_examen)
	{
		$data[1]=$id_examen;
		$query =  $this->db->query('select * from resultat where id_examen=?',$data);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
	}
	public function Selectexamenwhere($id_examen)
	{
		$data[1]=$id_examen;
		$query =  $this->db->query('select * from examen join matiere on examen.id_matiere = matiere.id_matiere where id_examen=?',$data);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
	}
	public function Setexamen($id,$date_debut,$date_fin,$duree_total,$nb_question) 
	{
		$this->db->set('date_debut',$date_debut);
		$this->db->set('date_fin',$date_fin);
		$this->db->set('duree_total',$duree_total);
		$this->db->set('nb_question',$nb_question);
		$this->db->where('id_examen',(int) $id);
		return $this->db->update($this->tableexamen);
	}
	public function Supprimeexamen($id_examen)
	{
		return $this->db->where('id_examen', (int)$id_examen)->delete($this->tableexamen);
	}
	//select * from r_enseignant_matiere where id_enseignant=1;
	//select * from examen join matiere on examen.id_matiere=matiere.id_matiere;
}
?>