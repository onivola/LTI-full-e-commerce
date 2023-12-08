<?php
    class Fiche extends CI_Controller {

        public function __construct() {
           parent:: __construct();
            $this->titre_defaut = 'Mon super site';
             $this->load->helper(array('form', 'url')); 
             $this->load->library('session'); 
        }
        public function index($ID_PRODUIT=0){ //http://localhost/CodeIgnitertest/index.php/home/index ou http://localhost/CodeIgnitertest/index.php/home      
            $data = $this->dataMenu();
            if($this->session->userdata('lti_id_utilisateur')!=NULL) {//SESSION UTILISATEUR NULL
                
                $data['ssn_id_utilisateur'] =  $this->session->userdata('lti_id_utilisateur');
                $data['ssn_nom'] =  $this->session->userdata('lti_nom');
                $data['ssn_prenom'] =   $this->session->userdata('lti_prenom');
            }
			$this->load->view('Fiche',$data);
        }
        public function Produit($ID_PRODUIT=1) {
            $data = $this->dataMenu();
            if($this->session->userdata('lti_id_utilisateur')!=NULL) {//SESSION UTILISATEUR NULL
                
                $data['ssn_id_utilisateur'] =  $this->session->userdata('lti_id_utilisateur');
                $data['ssn_nom'] =  $this->session->userdata('lti_nom');
                $data['ssn_prenom'] =   $this->session->userdata('lti_prenom');
            }
            $data = $this->FicheTechProduit($ID_PRODUIT,$data);
           
            $this->load->model('Modele_Produit','ModeleProduit');
            $data['bdd_produit'] = $this->ModeleProduit->SelectProduitById($ID_PRODUIT);
			$this->load->view('Fiche',$data);
        }
        /******************AJOUT PANIER******************** */
        public function AjoutPanier(){ //http://localhost/CodeIgnitertest/index.php/home/index ou http://localhost/CodeIgnitertest/index.php/home      
            $data = $this->dataMenu();
            if($this->session->userdata('lti_id_utilisateur')==NULL) {//SESSION UTILISATEUR NULL
				redirect(base_url().'connexion');
			} else {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('ID_CATEGORIE','ID_CATEGORIE','trim|required|min_length[1]|encode_php_tags');
                $this->form_validation->set_rules('ID_S_CATEGORIE','ID_S_CATEGORIE','trim|required|min_length[1]|encode_php_tags');
                $this->form_validation->set_rules('ID_SS_CATEGORIE','ID_SS_CATEGORIE','trim|required|min_length[1]|encode_php_tags');
                $this->form_validation->set_rules('ID_PRODUIT','ID_PRODUIT','trim|required|min_length[1]|encode_php_tags');
                $this->form_validation->set_rules('QUANTITE','QUANTITE','trim|required|min_length[1]|encode_php_tags');
    
                if($this->form_validation->run())
                {
                   
                        $data['ssn_id_utilisateur'] =  $this->session->userdata('lti_id_utilisateur');
                        $data['ssn_nom'] =  $this->session->userdata('lti_nom');
                        $data['ssn_prenom'] =   $this->session->userdata('lti_prenom');
                    
                    //htmlentities insert ' in bdd
                    echo $ID_CATEGORIE= mysql_escape_string($this->input->post('ID_CATEGORIE'));
                    echo $ID_S_CATEGORIE= mysql_escape_string($this->input->post('ID_S_CATEGORIE'));
                    $ID_SS_CATEGORIE= mysql_escape_string($this->input->post('ID_SS_CATEGORIE'));
                    $ID_PRODUIT= mysql_escape_string($this->input->post('ID_PRODUIT'));
                    $QUANTITE= mysql_escape_string($this->input->post('QUANTITE'));
                      
                    $this->load->model('Modele_Produit','ModeleProduit');
                
                    if($ID_CATEGORIE==0 || $ID_S_CATEGORIE==0 || $ID_SS_CATEGORIE==0 || $ID_PRODUIT==0 || $QUANTITE==0) { //erreur de l'utilisateur
                        redirect(base_url().'Fiche/Produit/'.$ID_PRODUIT);
                    
                    } else { //OK variable
                        $data = $this->dataProduit($ID_CATEGORIE,$ID_S_CATEGORIE,$ID_SS_CATEGORIE,$data);
                        $bdd_produit = $this->ModeleProduit->SelectProduitById($ID_PRODUIT);
                        foreach($bdd_produit as $bdd_produit) {
                            $quantitebdd = $bdd_produit->QUANTITE; //quantite dans la BDD
                        }
                        if($quantitebdd>=$QUANTITE) { //ok ajout produit
                            $quantienew = $quantitebdd-$QUANTITE;
                            $bdd_panierpd = $this->ModeleProduit->SelectPanier($this->session->userdata('lti_id_utilisateur'),$ID_PRODUIT);
                            if(count($bdd_panierpd)>0) { //produit deja dans le panier
                            foreach($bdd_panierpd as $bdd_panierpd) {
                                    $quantitepn = $bdd_panierpd->QUANTITE_PN; //quantite dans la BDD
                                }
                                $quantitenewpn =  $quantitepn+$QUANTITE;
                                $this->ModeleProduit->SetQuantitePn($ID_PRODUIT,$this->session->userdata('lti_id_utilisateur'),$quantitenewpn);
                                $this->ModeleProduit->SetQuantitePd($ID_PRODUIT,$quantienew);// QUANTITE DIMINUER
                                redirect(base_url().'Fiche/Produit/'.$ID_PRODUIT);
                            } else { //produit pas dans le panier
                                if($this->ModeleProduit->AjoutPanier($this->session->userdata('lti_id_utilisateur'),$ID_PRODUIT,$QUANTITE)) {
                                    $this->ModeleProduit->SetQuantitePd($ID_PRODUIT,$quantienew);// QUANTITE DIMINUER
                                    redirect(base_url().'Fiche/Produit/'.$ID_PRODUIT);
                                } else {
                                    redirect(base_url().'Fiche/Produit/'.$ID_PRODUIT);
                                }
                            }
                        } else {
                            redirect(base_url().'Fiche/Produit/'.$ID_PRODUIT);
                        }
                    }
                } else {
                    echo 0;
                }
            }
            
        }
         /******************FONCTION************************ */
         public function dataProduit($ID_CATEGORIE=0,$ID_S_SATEGORIE=0,$ID_SS_CATEGORIE=0,$data) {
            $this->load->model('Modele_Produit','ModeleProduit');
            $data["ID_CATEGORIE"] = $ID_CATEGORIE;
            $data["ID_S_SATEGORIE"] = $ID_S_SATEGORIE;
            $data["ID_SS_CATEGORIE"] = $ID_SS_CATEGORIE;
            $data['bdd_produit'] = $this->ModeleProduit->SelectProduit($ID_CATEGORIE,$ID_S_SATEGORIE,$ID_SS_CATEGORIE);
            //$this->session->set_userdata('lti_id_utilisateur', $id_etudiant);
            return $data;
        }
         public function FicheTechProduit($ID_PRODUIT=0,$data) {
           $this->load->model('Modele_Fiche','ModeleFiche');
    
           if($this->ModeleFiche->TestFiche($ID_PRODUIT)>0) {
                $bdd_fichet1 = $this->ModeleFiche->SelectFicheT1($ID_PRODUIT);
                $tempfichet1 =  $bdd_fichet1;
                foreach($bdd_fichet1 as $bdd_fichet1) { 
                    $tempfichet2[$bdd_fichet1->ID_FICHE_TQ_TITRE] = $this->ModeleFiche->SelectFicheT2($ID_PRODUIT,$bdd_fichet1->ID_FICHE_TQ_TITRE);
                }
                $data['bdd_fichet1'] = $tempfichet1;
                $data['bdd_fichet2'] = $tempfichet2;
                $data['bdd_count'] = 1;
            } else{
                $data['bdd_count'] =0;
            }
            return $data;
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