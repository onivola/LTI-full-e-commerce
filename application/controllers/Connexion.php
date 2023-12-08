<?php

    class Connexion extends CI_Controller {

        public function __construct() {
			parent:: __construct();
			$this->titre_defaut = 'Mon super site';
			$this->load->helper(array('form', 'url'));
			$this->load->library('session');
        }
        public function index(){      
			$data = $this->dataMenu();
			if($this->session->userdata('lti_id_utilisateur')!=NULL) {
				
				$this->load->view('Accueil',$data);
				
			} else {
				$this->load->library('form_validation');
				//IDENTIFIANT
				$this->form_validation->set_rules('email','email','trim|required|valid_email|encode_php_tags');
				$this->form_validation->set_rules('mdp','mdp','trim|required|min_length[8]|max_length[50]|encode_php_tags');
				if($this->form_validation->run())
				{
					$this->load->model('Modele_Utilisateur','ModeleUtilisateur');
					$email = $this->input->post('email');
					$mdp = $this->input->post('mdp');
					
					$where_email = array("EMAIL"=>$email);
					$donnee_email =  $this->ModeleUtilisateur->SelectWhere($where_email); //verification email dans la base
					
					if($donnee_email==false) {// si l'email n'existe pas
						$data['error_email'] = 'Adresse email inexistant';
						$this->load->view('Connexion',$data);
					} else if ($donnee_email!=false) { //si l'email existe
						$where_email_mdp = array("EMAIL"=>$email,"MDP"=> $mdp); //where argument
						$donnee_email_mdp =  $this->ModeleUtilisateur->SelectWhere($where_email_mdp);//verification email et mot de passe
						if($donnee_email_mdp==false) {// si email et mot de passe ne sont pas valide
							$data['error_mdp'] = 'mot de passe non valide';
							$this->load->view('Connexion',$data);							
						} else if ($donnee_email_mdp!=false) { // si email et mot de passe sont valide
							foreach($donnee_email as $list) { 
								$id_etudiant = $list->ID_UTILISATEUR;//id de l'utilisateur inscrit
								$this->session->set_userdata('lti_id_utilisateur', $list->ID_UTILISATEUR); //ajouter des donnees dans les session
								$this->session->set_userdata('lti_nom', $list->NOM);
								$this->session->set_userdata('lti_prenom', $list->PRENOM);
							}
							redirect(base_url().'Accueil');
						}
					}
				} else {
					$this->load->view('Connexion',$data);
				}
			}
		}
		public function deconnection()
        {
            $this->session->sess_destroy();
            redirect(base_url());
        }
		public function dataMenu() { //data for menu drop down
            $this->load->model('Modele_Menudrop','ModeleMenudrop');
            $data['bdd_cat'] = $this->ModeleMenudrop->SelectCat();//All categorie
            $bdd_cat =  $data['bdd_cat'];
            $data['bdd_scat']=0;
            foreach($bdd_cat as $bdd_cat) { 
                
                $tempscat[$bdd_cat->ID_CATEGORIE] = $this->ModeleMenudrop->SelectScIdWhere($bdd_cat->ID_CATEGORIE);
                $bdd_scat = $tempscat[$bdd_cat->ID_CATEGORIE];
                foreach($bdd_scat as $bdd_scat) { 
                    $tempsscat[$bdd_cat->ID_CATEGORIE][$bdd_scat->ID_S_CATEGORIE] = $this->ModeleMenudrop->SelectSscIdWhere($bdd_cat->ID_CATEGORIE,$bdd_scat->ID_S_CATEGORIE); 
                }
            } 
            $data['bdd_scat'] =  $tempscat;
            $data['bdd_sscat'] = $tempsscat;
            return $data;    
        }
	}
	












	/**
 if($this->form_validation->run())
            {
				$civilite = $this->input->post('civilite');
                $email = $this->input->post('email');
                $mot_de_passe = $this->input->post('mot_de_passe');
			
				if($civilite=="Etudiant") 
				{
					$this->load->model('Modele_Etudiant','ModeleEtudiant');
					 $where_email = array("email"=>$email);
					$donnee_email =  $this->ModeleEtudiant->SelectWhere($where_email); //verification email dans la base
					
					if($donnee_email==false) {// si l'email n'existe pas
						$data['error_email'] = 'Adresse email inexistant';
						$this->load->view('Connexion',$data);
					} else if ($donnee_email!=false) { //si l'email existe
						 $where_email_mdp = array("email"=>$email,"mot_de_passe"=> $mot_de_passe); //where argument
						$donnee_email_mdp =  $this->ModeleEtudiant->SelectWhere($where_email_mdp);//verification email et mot de passe
						if($donnee_email_mdp==false) {// si email et mot de passe ne sont pas valide
							$data['error_mot_de_passe'] = 'mot de passe non valide';
							$this->load->view('Connexion',$data);							
						} else if ($donnee_email_mdp!=false) { // si email et mot de passe sont valide
							foreach($donnee_email as $list) { 
								$id_etudiant = $list->id_etudiant;//id de l'utilisateur inscrit
								$this->session->set_userdata('id_etudiant', $id_etudiant); //ajouter des donnees dans les session
								$this->session->set_userdata('et_nomprenom', $list->nom." ".$list->prenom);
							}
							redirect(base_url().'Etudiant');
						}
					}
				} else if($civilite=="Enseignant") {
					$this->load->model('Modele_Enseignant','ModeleEnseignant');
					 $where_email = array("email"=>$email);
					$donnee_email =  $this->ModeleEnseignant->SelectWhere($where_email); //verification email dans la base
					
					if($donnee_email==false) {// si l'email n'existe pas
						$data['error_email'] = 'Adresse email inexistant';
						 $this->load->view('Connexion',$data);
					} else if ($donnee_email!=false) { //si l'email existe
						 $where_email_mdp = array("email"=>$email,"mot_de_passe"=> $mot_de_passe); //where argument
						$donnee_email_mdp =  $this->ModeleEnseignant->SelectWhere($where_email_mdp);//verification email et mot de passe
						if($donnee_email_mdp==false) {// si email et mot de passe ne sont pas valide
							$data['error_mot_de_passe'] = 'mot de passe non valide';	
							 $this->load->view('Connexion',$data);
						} else if ($donnee_email_mdp!=false) { // si email et mot de passe sont valide
							foreach($donnee_email as $list) { 
								$id_enseignant = $list->id_enseignant;//id de l'utilisateur inscrit
								$this->session->set_userdata('id_enseignant', $id_enseignant); //ajouter des donnees dans les session
								$this->session->set_userdata('ens_nomprenom', $list->nom." ".$list->prenom); //ajouter des donnees dans les session
							}
							redirect(base_url().'Enseignant');
						}
					}
				}
				
            } else {
                $this->load->view('Connexion');
            }


	 */
?>