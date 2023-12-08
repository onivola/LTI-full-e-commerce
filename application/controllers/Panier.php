<?php
    class Panier extends CI_Controller {

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
                $this->load->model('Modele_Produit','ModeleProduit');
                
                $data['bdd_panier'] = $this->ModeleProduit->SelectPanierJoin($this->session->userdata('lti_id_utilisateur'));
                $tpbdd_panier = $data['bdd_panier'];
                
                if(count($tpbdd_panier)>0) {
                   foreach($tpbdd_panier as $tpbdd_panier) {
                       $tpbdd_quantitepnpd[$tpbdd_panier->ID_PANIER] = $tpbdd_panier->QUANTITE_PN + $tpbdd_panier->QUANTITE;
                    }
                } else {
                    $tpbdd_quantitepnpd = 0;
                }
                $data['bdd_quantitepnpd'] = $tpbdd_quantitepnpd;
                $this->load->view('panier',$data);
            } else {
                redirect(base_url().'Accueil');
            }
            
        }
        public function DelletPanier($ID_PRODUIT=0) {
            if($this->session->userdata('lti_id_utilisateur')!=NULL) {
                if($ID_PRODUIT>0) {
                    $this->load->model('Modele_Produit','ModeleProduit');
                    $ID_UTILISATEUR = $this->session->userdata('lti_id_utilisateur');
                    $bdd_panier = $this->ModeleProduit->SelectPanierJoin2($ID_UTILISATEUR,$ID_PRODUIT);
                    if(count($bdd_panier)>0) {
                        foreach($bdd_panier as $bdd_panier) {
                            echo $QUANTITE_PNPD = $bdd_panier->QUANTITE_PN+$bdd_panier->QUANTITE;
                        }
                        if($this->ModeleProduit->DelletePanier($ID_UTILISATEUR,$ID_PRODUIT)) {
                            $this->ModeleProduit->SetQuantitePd($ID_PRODUIT,$QUANTITE_PNPD);
                            redirect(base_url().'Panier');
                        } else { //erreur supression
                            redirect(base_url().'Panier');
                        }
                        //redirect(base_url().'Panier');
                    } else {
                        redirect(base_url().'Panier');
                    }
                } else {
                    redirect(base_url().'Panier');
                }
            } else {
                redirect(base_url().'Connexion');
            }
        }
        public function EditQuantite() {
            if($this->session->userdata('lti_id_utilisateur')!=NULL) {

                $this->load->library('form_validation');
                $this->form_validation->set_rules('QUANTITE_PN','QUANTITE_PN','trim|required|min_length[1]|max_length[50]|encode_php_tags');
                $this->form_validation->set_rules('ID_PRODUIT','ID_PRODUIT','trim|required|min_length[1]|max_length[50]|encode_php_tags');
                if($this->form_validation->run())
                {
                    $this->load->model('Modele_Produit','ModeleProduit');
                    $QUANTITE_PN = $this->input->post('QUANTITE_PN');
                    $ID_PRODUIT = $this->input->post('ID_PRODUIT');
                    $ID_UTILISATEUR = $this->session->userdata('lti_id_utilisateur');
                    $bdd_panier = $this->ModeleProduit->SelectPanierJoin2($ID_UTILISATEUR,$ID_PRODUIT);
                    if(count($bdd_panier)>0 AND $QUANTITE_PN>0) {
                        foreach($bdd_panier as $bdd_panier) {
                            if($QUANTITE_PN<$bdd_panier->QUANTITE_PN+$bdd_panier->QUANTITE) {
                                echo 1;
                                $quantitenew = ($bdd_panier->QUANTITE_PN+$bdd_panier->QUANTITE)-$QUANTITE_PN;
                                if($this->ModeleProduit->SetQuantitePn($ID_PRODUIT,$ID_UTILISATEUR,$QUANTITE_PN)) {
                                    $this->ModeleProduit->SetQuantitePd($ID_PRODUIT,$quantitenew);
                                    redirect(base_url().'Panier');
                                }
                            } else {
                                redirect(base_url().'Panier');
                            }
                        }   
                        //$this->ModeleProduit->SetQuantitePn($ID_PRODUIT,$ID_UTILISATEUR,$QUANTITE_PN);
                        //redirect(base_url().'Panier');
                    } else {
                        redirect(base_url().'Panier');
                    }
                } else {
                    redirect(base_url().'Panier');
                }
            } else {
                redirect(base_url().'Connexion');
            }
            
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