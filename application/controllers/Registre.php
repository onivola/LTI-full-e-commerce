<?php

    class Registre extends CI_Controller {

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
            $this->form_validation->set_rules('email','email','trim|required|is_unique[utilisateur.email]|valid_email|encode_php_tags',array('is_unique' => 'L\'adresse email existe deja'));
            $this->form_validation->set_rules('mdp','mdp','trim|required|min_length[8]|max_length[50]|encode_php_tags');
            $this->form_validation->set_rules('mdp_same','mdp_same','trim|required|min_length[8]|max_length[50]|encode_php_tags');
            //PERSONNEL
                $this->form_validation->set_rules('civilite','Civilite','trim|required|encode_php_tags');
                $this->form_validation->set_rules('nom','nom','trim|required|max_length[50]|encode_php_tags');
                $this->form_validation->set_rules('prenom','prenom','trim|required|max_length[50]|encode_php_tags');
                $this->form_validation->set_rules('date','date','trim|required|alpha_dash|encode_php_tags');
                if($this->form_validation->run())
                {
                    $this->load->model('Modele_Utilisateur','ModeleUtilisateur');
                    $civilite = $this->input->post('civilite');
                    if($civilite!="homme" && $civilite!="femme") { //erreur
                        $this->load->view('registre',$data); 
                    } else {
                        
                        
                        $email = $this->input->post('email');
                        $mdp = $this->input->post('mdp');
                        $nom = $this->input->post('nom');
                        $prenom = $this->input->post('prenom');
                        $date = $this->input->post('date');
                        
                    $result = $this->ModeleUtilisateur->AjouterUtilisateur($civilite,$email,$mdp,$nom,$prenom,$date); //true or false
                        if($result) {
                            $this->load->view('connexion',$data);
                        } else {
                            echo "Impossible de se connecter au serveur";
                        }
                    }
                } else {
                    $this->load->view('Registre',$data);
                }
            }
           // $this->load->view('Registre');
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
?>