<?php
    class Accueil extends CI_Controller {

        public function __construct() {
           parent:: __construct();
            $this->titre_defaut = 'Mon super site';
             $this->load->helper(array('form', 'url')); 
             $this->load->library('session'); 
        }
        public function index(){ //http://localhost/CodeIgnitertest/index.php/home/index ou http://localhost/CodeIgnitertest/index.php/home 
           
                $data = $this->dataMenu();
                if($this->session->userdata('lti_id_utilisateur')!=NULL) {//SESSION UTILISATEUR NULL
                    
                    $data['ssn_id_utilisateur'] =  $this->session->userdata('lti_id_utilisateur');
                    $data['ssn_nom'] =  $this->session->userdata('lti_nom');
                    $data['ssn_prenom'] =   $this->session->userdata('lti_prenom');
                }
				$this->load->view('Accueil',$data);
            
        }
        public function dataMenu() {
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
            
        
		public function connexion() {
			 $this->load->view('Accueil');
		}
    }

?>