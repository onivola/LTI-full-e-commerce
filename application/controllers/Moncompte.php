<?php
    class Moncompte extends CI_Controller {

        public function __construct() {
           parent:: __construct();
            $this->titre_defaut = 'Mon super site';
             $this->load->helper(array('form', 'url')); 
             $this->load->library('session'); 
        }
        public function index(){ //http://localhost/CodeIgnitertest/index.php/home/index ou http://localhost/CodeIgnitertest/index.php/home
           
            if($this->session->userdata('lti_id_utilisateur')!=NULL) {
                $this->load->model('Modele_Commande','ModeleCommande');
               
                $data = $this->dataMenu();
                $data['ssn_id_utilisateur'] =  $this->session->userdata('lti_id_utilisateur');
                $data['ssn_nom'] =  $this->session->userdata('lti_nom');
                $data['ssn_prenom'] =   $this->session->userdata('lti_prenom');

                $data['db_utilisateur'] = $this->ModeleCommande->SelectUtilByid($this->session->userdata('lti_id_utilisateur'));
                $this->load->view('mcompte_infopers',$data);
            } else {
                redirect(base_url().'Connexion');
			}
			
        }
        public function AnnulerCommande() {
            if($this->session->userdata('lti_id_utilisateur')!=NULL) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('mdp','mdp','trim|required|min_length[1]|encode_php_tags');
                $this->form_validation->set_rules('id_facture','id_facture','trim|required|min_length[1]|encode_php_tags');
            
                if($this->form_validation->run())
                {
                    $mdp= $this->input->post('mdp');
                    $id_facture= $this->input->post('id_facture');
                    $where = array('ID_UTILISATEUR'=> $this->session->userdata('lti_id_utilisateur'));
                    $this->load->model('Modele_Utilisateur','ModeleUtilisateur');
                    $db_util = $this->ModeleUtilisateur->SelectWhere($where);
                    //var_dump($db_util);
                    foreach($db_util as $db_util) {
                        if($db_util->MDP==$mdp) {
                            //redirect(base_url().'Moncompte/Commande');
                            $this->load->model('Modele_Commande','ModeleCommande');
                            $this->ModeleCommande->DelletFacture($id_facture);
                            $this->ModeleCommande->DelletDetlFacture($id_facture);
                            echo 1;
                        } else {
                            
                            echo 0;
                        }
                    }
                } else {
                    redirect(base_url().'Moncompte/Commande');
                }
            } else {
                redirect(base_url().'Connexion');
            }
        }
        public function Commande(){ //http://localhost/CodeIgnitertest/index.php/home/index ou http://localhost/CodeIgnitertest/index.php/home
            
             if($this->session->userdata('lti_id_utilisateur')!=NULL) {
                $this->load->model('Modele_Commande','ModeleCommande');
                $this->session->set_userdata('lti_insertfact',null);
				$this->session->set_userdata('lti_insertdfact',null);
				$this->session->set_userdata('lti_insertadress',null);
                $data = $this->dataMenu();
                $data['ssn_id_utilisateur'] =  $this->session->userdata('lti_id_utilisateur');
                $data['ssn_nom'] =  $this->session->userdata('lti_nom');
                $data['ssn_prenom'] =   $this->session->userdata('lti_prenom');
                /**LIST COMMANDE */
                $db_facture = $this->ModeleCommande->SelectFacture($this->session->userdata('lti_id_utilisateur'));
                $db_facturedata = $db_facture;
                $db_dtlfacture=null;
                $db_adresse=null;
                if(count($db_facture)>0) { //facture non null
                    foreach($db_facture as $db_facture) {
                        $db_dtlfacture[$db_facture->ID_FACTURE] = $this->ModeleCommande->SelectDtlFacture($db_facture->ID_FACTURE);
                        $db_adresse[$db_facture->ID_FACTURE] = $this->ModeleCommande->SelectAdresse($db_facture->ID_FACTURE);
                    }
                } 
                $data['db_facture'] = $db_facturedata;
                $data['db_dtlfacture'] = $db_dtlfacture;
                $data['db_adresse'] = $db_adresse;
                

                $this->load->view('mcompte_commande',$data);
             } else {
                 redirect(base_url().'Connexion');
             }
             
         }
       
         //fUNCTION
         private function dataMenu() {
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