<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Modele_Qcm extends CI_Model
{
	protected $table = 'etudiant';
	protected $tablequestion = 'question';
	protected $tableexamen = 'examen';
	protected $tablepasser = 'passer_examen';
	protected $tableresultat = 'resultat';
	
	public function AjouterQuestion($id_etudiant,$id_question,$id_examen,$point,$heur_ajout)
	{
		$this->db->set('id_question',$id_question);
		$this->db->set('id_etudiant',$id_etudiant);
		$this->db->set('id_examen',$id_examen);
		$this->db->set('point',$point);
		$this->db->set('heur_ajout',$heur_ajout);
		
		return $this->db->insert($this->tablepasser);
	}
	public function Select() 
	{
		return $this->db->select('*')
		->from($this->table)
		->get()
		->result();
	}
	public function Selectquestion($where) 
	{
		$data[1]=$where;
		$query =  $this->db->query('select * from question where id_matiere=? order by rand() limit 1;',$data);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
	}
	//select * from question where id_question not in(select id_question from passer_examen) order by rand();
	public function Selectquestionnotin($id_etudiant,$id_matiere) 
	{
		$data[1]=$id_etudiant;
		$data[2]=$id_matiere;
		$query =  $this->db->query('select * from question where id_question not in(select id_question from passer_examen where id_etudiant=?) and id_matiere=? order by rand()',$data);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
	}
	public function Selectexamen($where) 
	{
		$data[1]=$where;
		$query =  $this->db->query('select * from examen where id_examen=?',$data);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
	}
	public function Selectquestionid($where) 
	{
		$data[1]=$where;
		$query =  $this->db->query('select * from question where id_question=?',$data);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
	}
	public function Selectreponse($where) 
	{
		$data[1]=$where;
		$query =  $this->db->query('select * from choix_reponse where id_question=?  order by rand()',$data);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
	}
	public function Selectreponsevrai($where) 
	{
		$data[1]=$where;
		$query =  $this->db->query('select * from choix_reponse where id_question=? and vrais=1  order by rand()',$data);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
	}
	public function Selectreponseid($where) 
	{
		$data[1]=$where;
		$query =  $this->db->query('select * from choix_reponse where id_choix_reponse = ?',$data);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
	}
	public function Selectpasserexanen($id_etudiant,$id_examen) 
	{
		$data[1]=$id_etudiant;
		$data[2]=$id_examen;
		$query =  $this->db->query('select * from passer_examen join question on passer_examen.id_question=question.id_question where id_etudiant=? and id_examen=?  order by id_passer_examen desc  limit 1',$data);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
	}
	public function Selectpasserexanenasc($id_etudiant,$id_examen) 
	{
		$data[1]=$id_etudiant;
		$data[2]=$id_examen;
		$query =  $this->db->query('select * from passer_examen join question on passer_examen.id_question=question.id_question where id_etudiant=? and id_examen=?  order by id_passer_examen asc  limit 1',$data);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
	}
	public function Selectallpasserexanen($id_etudiant,$id_examen) 
	{
		$data[1]=$id_etudiant;
		$data[2]=$id_examen;
		$query =  $this->db->query('select * from passer_examen join question on passer_examen.id_question=question.id_question where id_etudiant=? and id_examen=?',$data);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
	}
	public function Setepasseexamenpoint($where=array(),$point) 
	{
		$this->db->set('point',$point);
		$this->db->where($where);
		return $this->db->update($this->tablepasser);
	}
	public function Setpoint($id_passer_examen,$pointquestion) 
	{
		$this->db->set('point',$pointquestion);
		$this->db->where('id_passer_examen',(int) $id_passer_examen);
		return $this->db->update($this->tablepasser);
	}
	public function Setprofil($id,$profil) 
	{
		$this->db->set('profil',$profil);
		$this->db->where('id_etudiant',(int) $id);
		return $this->db->update($this->table);
	}
	public function SelectWhereExamen($where=array()) 
	{
		return $this->db->select('*')
		->from($this->tableexamen)
		->Where($where)
		->get()
		->result();
	}
	public function SelectWhereExamenMatiere($id_examen) 
	{
		$data[1]=$id_examen;
		$query =  $this->db->query('select * from examen join matiere on examen.id_matiere=matiere.id_matiere where id_examen=?',$data);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
	}	
	//RESULTAT
	public function Selectresultatnote($id_etudiant,$id_examen) 
	{
		$data[1]=$id_etudiant;
		$data[2]=$id_examen;
		$query =  $this->db->query('select sum(point) as sumpoint,sum(point_negatif) as sumpoint_negatif,id_examen from (select point,point_negatif,id_examen from passer_examen join question on passer_examen.id_question = question.id_question where id_etudiant=? and id_examen=?)AS SUBQUERY',$data);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
	}
	//select Count(id_passer_examen) as nb_question_pose,nb_question,sum(point) as total_point from passer_examen join examen on examen.id_examen = passer_examen.id_examen where id_etudiant=4 and passer_examen.id_examen=2;
	public function Selectcountnote($id_etudiant,$id_examen) 
	{
		$data[1]=$id_etudiant;
		$data[2]=$id_examen;
		$query =  $this->db->query('select nb_question,count(id_passer_examen) as nbquestion_pose,sum(point) as sumpoint,sum(point_negatif) as sumpoint_negatif from passer_examen join question on passer_examen.id_question = question.id_question join examen on examen.id_examen = passer_examen.id_examen where id_etudiant = ? and passer_examen.id_examen = ?;',$data);
		 $nb_resultat = $query->num_rows();
		 return $query->result();
	}
	
	public function AjouterResultat($id_etudiant,$id_examen,$nom_etudiant,$prenom_etudiant,$nom_examen,$nom_matiere,$note)
	{
		$this->db->set('id_etudiant',$id_etudiant);
		$this->db->set('id_examen',$id_examen);
		$this->db->set('nom_etudiant',$nom_etudiant);
		$this->db->set('prenom_etudiant',$prenom_etudiant);
		$this->db->set('nom_examen',$nom_examen);
		$this->db->set('nom_matiere',$nom_matiere);
		$this->db->set('note',$note);
		
		return $this->db->insert($this->tableresultat);
	}
	public function SelectWhereResultat($where=array()) 
	{
		return $this->db->select('*')
		->from($this->tableresultat)
		->Where($where)
		->get()
		->result();
	}
	
	
	
	
}
?>