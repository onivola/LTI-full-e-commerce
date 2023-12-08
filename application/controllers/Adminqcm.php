<?php

    class Adminqcm extends CI_Controller {

        public function __construct() {
			parent:: __construct();
			$this->titre_defaut = 'Mon super site';
			$this->load->helper(array('form', 'url'));
			$this->load->library('session');
        }
        public function index(){ 
			$this->load->model('Modele_Enseignant','ModeleEnseignant');
			
            $this->load->library('form_validation');
			$this->form_validation->set_rules('civilite','Civilite','trim|required|alpha_dash|encode_php_tags');
		    $this->form_validation->set_rules('nom','nom','trim|required|alpha_dash|encode_php_tags');
            $this->form_validation->set_rules('prenom','prenom','trim|required|alpha_dash|encode_php_tags');
			$this->form_validation->set_rules('email','email','trim|required|is_unique[etudiant.email]|valid_email|encode_php_tags',array('is_unique' => 'l\'adresse email existe deja'));
            $this->form_validation->set_rules('mot_de_passe','mot de passe','trim|required|min_length[4]|max_length[12]|encode_php_tags');
             $this->form_validation->set_rules('profil','profil','trim|required|alpha_dash|encode_php_tags');
			if($this->form_validation->run())
            {
               
                $civilite = $this->input->post('civilite');
				 $nom = $this->input->post('nom');
                $prenom = $this->input->post('prenom');
                $email = $this->input->post('email');
                $mot_de_passe = $this->input->post('mot_de_passe');
				$profil = $this->input->post('profil');
                $this->ModeleEnseignant->AjouterEtudiant($civilite,$nom,$prenom,$email,$mot_de_passe,$profil);
                //redirect(base_url());
				echo "1";
            } else {
               
				$data['enseignant'] = $this->ModeleEnseignant->Select();
				 $this->load->view('Profilenseignant',$data);
            }
        }
		 public function Profilenseignant()
        {
			 $this->load->library('form_validation');
			 $this->load->model('Modele_Enseignant','ModeleEnseignant');
			$this->form_validation->set_rules('id_enseignant','id_enseignant','trim|required|alpha_dash|encode_php_tags');
			$this->form_validation->set_rules('profil','profil','trim|required|alpha_dash|encode_php_tags');
			if($this->form_validation->run())
            {
				$id_enseignant = $this->input->post('id_enseignant');
				$profil = $this->input->post('profil');
				$new_profil=1;
				if($profil ==0) 
				{
					$new_profil=1;
				} else if($profil ==1) {
					$new_profil=0;
				}
				$new_profil;
				$this->ModeleEnseignant->Setprofil($id_enseignant,$new_profil);
			} 
			$data['enseignant'] = $this->ModeleEnseignant->Select();
			$this->load->view('Profilenseignant',$data);
			
        }
		 public function Profiletudiant()
        {
			 $this->load->library('form_validation');
			 $this->load->model('Modele_Etudiant','ModeleEtudiant');
			$this->form_validation->set_rules('id_etudiant','id_etudiant','trim|required|alpha_dash|encode_php_tags');
			$this->form_validation->set_rules('profil','profil','trim|required|alpha_dash|encode_php_tags');
			if($this->form_validation->run())
            {
				$id_etudiant = $this->input->post('id_etudiant');
				$profil = $this->input->post('profil');
				$new_profil=1;
				if($profil ==0) 
				{
					$new_profil=1;
				} else if($profil ==1) {
					$new_profil=0;
				}
				
				$this->ModeleEtudiant->Setprofil($id_etudiant,$new_profil);
			}
			$data['etudiant'] = $this->ModeleEtudiant->Select();
			$this->load->view('Profiletudiant',$data);
        }
		 public function Creationmatiere()
        {
			$this->load->library('form_validation');
			$this->load->model('Modele_Matiere','ModeleMatiere');
			$this->form_validation->set_rules('matiere','matiere','trim|required|is_unique[matiere.nom_matiere]|alpha_dash|encode_php_tags',array('is_unique' => 'la matiere existe deja'));
			if($this->form_validation->run())
			{
				$matiere = $this->input->post('matiere');
				$this->ModeleMatiere->AjouterMatiere($matiere);
			}
			$data['matiere'] = $this->ModeleMatiere->Select();
			$this->load->view('Creationmatiere',$data);
        }
		 public function Affectmatiere()
        {
			$this->load->library('form_validation');
			$this->load->model('Modele_Enseignant','ModeleEnseignant');
			$this->load->model('Modele_Matiere','ModeleMatiere');
			$this->form_validation->set_rules('id_enseignant','id_enseignant','trim|required|alpha_dash|encode_php_tags');
			$this->form_validation->set_rules('id_matiere','id_matiere','trim|required|alpha_dash|encode_php_tags');
			$this->form_validation->set_rules('btn','btn','trim|required|alpha_dash|encode_php_tags');
			if($this->form_validation->run())
            {
				$id_enseignant = $this->input->post('id_enseignant');
				$id_matiere = $this->input->post('id_matiere');
				$btn = $this->input->post('btn');
				if($btn=="ajout") {
					if($this->ModeleEnseignant->Checkrelation($id_enseignant,$id_matiere)==false) {
						$this->ModeleEnseignant->AffectMaitiere($id_enseignant,$id_matiere);
					}
				} else if($btn=="suprimer") {
					$this->ModeleMatiere->Supprimeraffect($id_enseignant);
				}
			}
			$where = array('profil'=> 1);
			$data['enseignant'] = $this->ModeleEnseignant->Selectwhere($where);
			$data['matiere'] = $this->ModeleMatiere->Select();
			$this->load->view('Affectmatiere',$data);
			
			
			
			
			
        }
		
    }
?>