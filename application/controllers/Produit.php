<?php
    class Produit extends CI_Controller {

        public function __construct() {
           parent:: __construct();
            $this->titre_defaut = 'Mon super site';
             $this->load->helper(array('form', 'url')); 
             $this->load->library('session'); 
        }
        public function Categorie1($ID_CATEGORIE=0){ //http://localhost/CodeIgnitertest/index.php/home/index ou http://localhost/CodeIgnitertest/index.php/home      
           
            $data = $this->dataProduit($ID_CATEGORIE,0,0);
            $data = $this->dataMenu();
            $this->load->view('produit',$data);
        }
        public function Categorie2($ID_CATEGORIE=0,$ID_S_SATEGORIE=0){ //http://localhost/CodeIgnitertest/index.php/home/index ou http://localhost/CodeIgnitertest/index.php/home      
            $data = $this->dataProduit($ID_CATEGORIE,$ID_S_SATEGORIE,0);
            $data = $this->dataMenu();
            $this->load->view('produit',$data);
        }
        public function Categorie3($ID_CATEGORIE=0,$ID_S_CATEGORIE=0,$ID_SS_CATEGORIE=0){ //http://localhost/CodeIgnitertest/index.php/home/index ou http://localhost/CodeIgnitertest/index.php/home      
            $data = $this->dataMenu();
            $this->load->model('Modele_Produit','ModeleProduit');
            
           // $this->session->sess_destroy();
            //$this->session->set_userdata('stbvaleur',null);
            //$this->session->set_userdata('stbidstitre',null);
            if($this->session->userdata('lti_id_utilisateur')!=NULL) {//SESSION UTILISATEUR NULL
                
                $data['ssn_id_utilisateur'] =  $this->session->userdata('lti_id_utilisateur');
                $data['ssn_nom'] =  $this->session->userdata('lti_nom');
                $data['ssn_prenom'] =   $this->session->userdata('lti_prenom');
            }
            $data['tb_categorie'] = $this->ModeleProduit->SelectProduitLien($ID_CATEGORIE,$ID_S_CATEGORIE,$ID_SS_CATEGORIE);
            $data["ID_CATEGORIE"] = $ID_CATEGORIE;
            $data["ID_S_CATEGORIE"] = $ID_S_CATEGORIE;
            $data["ID_SS_CATEGORIE"] = $ID_SS_CATEGORIE;
            if($this->session->userdata('stbvaleur')==NULL && $this->session->userdata('stbidstitre')==NULL && $this->session->userdata('id_ss_categorie')==NULL) { //filtre session null
               
                $datafiltre = $this->FiltreData($ID_SS_CATEGORIE);
                if(count($datafiltre[0])>0) {
                    $data['bdd_flt_stitre'] = $datafiltre[0];
                    $data['bdd_flt_value'] = $datafiltre[1];
                }
                //$this->session->set_userdata('id_ss_categorie', $ID_SS_CATEGORIE);//session id_ss_categorie
                $data["ID_SS_CATEGORIE"] = $ID_SS_CATEGORIE;
               
                $data['leftprice'] = 0;
                $data = $this->ModeleProduit->SelectProduit($ID_CATEGORIE,$ID_S_CATEGORIE,$ID_SS_CATEGORIE,$data);
                
                $this->load->view('produit',$data);
            } else { //filtre session non null
                if($this->session->userdata('id_ss_categorie')==$ID_SS_CATEGORIE) {
                    $stbvaleur = $this->session->userdata('stbvaleur'); //session valeur
                    $stbidstitre = $this->session->userdata('stbidstitre'); //session titre
                    //var_dump($stbvaleur);
                   // var_dump($stbidstitre);
                    $tbidvaleur = array();
                    $tballvaleur = array();
                    $data['leftprice']=0;
                    for($i=0;$i<count($stbidstitre);$i++) {
                        $tbidvaleur[$stbidstitre[$i]] = $stbvaleur[$i];
                    }
                    $iall=0;
                    for($i=0;$i<count($stbvaleur);$i++) {
                        if($stbidstitre[$i]=='PRICE') {
                            $tballvaleur[$iall] = 'Entre '.$stbvaleur[$i][0].' et '.$stbvaleur[$i][1];
                            $data['leftprice'] = $stbvaleur[$i][0];
                            $data['rightprice'] = $stbvaleur[$i][1];
                            $iall++;
                        } else if($stbidstitre[$i]=='TRI') {
                        } else {
                            for($j=0;$j<count($stbvaleur[$i]);$j++) {
                                $tballvaleur[$iall] = $stbvaleur[$i][$j];
                                $iall++;
                            }
                        }
                    }
                    $result[0] =$tbidvaleur; // ex $tbidvaleur[4] == VALEUR 
                    $result[1] =$tballvaleur;//list all valeur
                    $result[2] =$stbvaleur; //list valeur
                    $result[3] =$stbidstitre; //list id_titre
                    $data = $this->ModeleProduit->SelectFiltreProduit($ID_SS_CATEGORIE,1,$data,$result[0],$result[3]);
                    
                    //var_dump($data);
                    $datafiltre = $this->FiltreDataFiltre($ID_SS_CATEGORIE,$result[3],$result[2]); //left filtre titre,valeur,nb_valeur
                    if(count($datafiltre[0])>0) {
                        $data['bdd_flt_stitre'] = $datafiltre[0];
                        $data['bdd_flt_value'] = $datafiltre[1];
                        $data['bdd_flt_nbvaleur'] = $datafiltre[2];
                    }
                    $data['valeur'] = $result[1];
                    $data['tbidvaleur'] = $result[0];
                    $data['stbvaleur'] = $result[1];
                    $data['ID_SS_CATEGORIE'] = $ID_SS_CATEGORIE;
                    $this->load->view('produit',$data);
                } else {
                    echo 'tsy mtovy';
                    $this->session->set_userdata('id_ss_categorie',null);//session id_ss_categorie
                    $this->session->set_userdata('stbvaleur',null);
                    $this->session->set_userdata('stbidstitre',null);
                    $datafiltre = $this->FiltreData($ID_SS_CATEGORIE);
                    if(count($datafiltre[0])>0) {
                        $data['bdd_flt_stitre'] = $datafiltre[0];
                        $data['bdd_flt_value'] = $datafiltre[1];
                    }
                   
                    $data["ID_SS_CATEGORIE"] = $ID_SS_CATEGORIE;
                    $data['tb_categorie'] = $this->ModeleProduit->SelectProduitLien($ID_CATEGORIE,$ID_S_CATEGORIE,$ID_SS_CATEGORIE);
                    $data = $this->ModeleProduit->SelectProduit($ID_CATEGORIE,$ID_S_CATEGORIE,$ID_SS_CATEGORIE,$data);
                    $this->load->view('produit',$data);
                }
                
            }
           
        }
        private function DelletTbidvaleur($tbidvaleur,$dellvaleur){
            $tbftitre = $tbidvaleur[0]; 
            $tbfvaleur = $tbidvaleur[1];
        
            for($i=0;$i<count($tbftitre);$i++) { //change dell value to null
                if($tbftitre[$i]=='PRICE' && substr($dellvaleur, 0, 5)=="Entre") {
                    $tbfvaleur[$i][0]=null;
                    unset($tbfvaleur[$i][1]);
                }
                else {
                    for($j=0;$j<count($tbfvaleur[$i]);$j++) {
                        
                        if (($key = array_search($dellvaleur,$tbfvaleur[$i])) !== false) {
                            $tbfvaleur[$i][$key]=null;
                        }
                    }
                }
            }
            //var_dump($tbfvaleur);
            $NWi=0;
            $NWtbidvaleur=null; $ikey=-1;
            for($i=0;$i<count($tbftitre);$i++) {
                $NWj=0;
                for($j=0;$j<count($tbfvaleur[$i]);$j++) {
                    if($tbfvaleur[$i][$j]==null) {
                        if(count($tbfvaleur[$i])==1) {
                            $NWi--;
                            $ikey = $i;
                        }
                    } else {
                        $NWtbidvaleur[$NWi][$NWj] = $tbfvaleur[$i][$j];
                        $NWj++;
                    }
                }
                $NWi++;
            }
            //var_dump($NWtbidvaleur);
            $NWtbftitre=null;
            
            if($ikey>=0) { // tbftitre indice $ikey vide
                
                $tbftitre[$ikey]=null;
                $NWi=0;
                for($i=0;$i<count($tbftitre);$i++) {
                    if($tbftitre[$i]==null) {

                    } else {
                        $NWtbftitre[$NWi]=$tbftitre[$i];
                        $NWi++;
                    }
                }
            } else { 
                $NWtbftitre=$tbftitre;
            }
            //var_dump($NWtbftitre);
            //var_dump($NWtbidvaleur);
            if($NWtbftitre!=null && $NWtbidvaleur!=null) {
                $tbidvaleur2 = array();
                $tballvaleur = array();
                for($i=0;$i<count($NWtbftitre);$i++) {
                    $tbidvaleur2[$NWtbftitre[$i]] = $NWtbidvaleur[$i];
                }
                $iall=0;
                for($i=0;$i<count($NWtbidvaleur);$i++) {
                    if($NWtbftitre[$i]=='PRICE') {
                        $tballvaleur[$iall] = 'Entre '.$NWtbidvaleur[$i][0].' et '.$NWtbidvaleur[$i][1];
                        $iall++;
                    } else if($NWtbftitre[$i]=='TRI') {
                    } else {
                        for($j=0;$j<count($NWtbidvaleur[$i]);$j++) {
                            $tballvaleur[$iall] = $NWtbidvaleur[$i][$j];
                            $iall++;
                        }
                    }
                }
                $result[0] =$tbidvaleur2; // ex $tbidvaleur[4] == VALEUR 
                $result[1] =$tballvaleur;//list all valeur
                $result[2] =$NWtbidvaleur; //list valeur
                
                $result[3] =$NWtbftitre; //list id_titre
                return $result;
            } else {
                return null;
            }
            
        }
        //FILTRE
        public function AjxFiltreDellet() {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id_categorie','id_categorie','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('id_s_categorie','id_s_categorie','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('id_ss_categorie','id_ss_categorie','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('dellvaleur','id_stdellvaleuritre','trim|required|min_length[1]|encode_php_tags');
            if($this->form_validation->run())
			{
                $id_categorie= $this->input->post('id_categorie');
                $id_s_categorie= $this->input->post('id_s_categorie');
                $id_ss_categorie= $this->input->post('id_ss_categorie');
                $dellvaleur= $this->input->post('dellvaleur');
                $tbidvaleur =  $this->FiltreGetSession();
                if($tbidvaleur[0]!=null &&  $tbidvaleur[1]!=null && $dellvaleur!='0')
                {
                    $this->load->model('Modele_Produit','ModeleProduit');
                    //var_dump($tbidvaleur);
                    //var_dump($dellvaleur);
                    //dellet dellvaleur in tbidvaleur
                    $tbidvaleur =  $this->DelletTbidvaleur($tbidvaleur,$dellvaleur);
                    //var_dump($tbidvaleur[2]);
                    //var_dump($tbidvaleur[3]);
                    if($tbidvaleur!=null) {
                        $this->session->set_userdata('stbidstitre', $tbidvaleur[3]);
                        $this->session->set_userdata('stbvaleur', $tbidvaleur[2]); //session
                        $this->session->set_userdata('id_ss_categorie', $id_ss_categorie);
                        //var_dump($tbidvaleur);
                        $data['ID_CATEGORIE'] = $id_categorie;
                        $data = $this->ModeleProduit->SelectFiltreProduit($id_ss_categorie,2,$data,$tbidvaleur[0],$tbidvaleur[3]);
                        $datafiltre = $this->FiltreDataFiltre($id_ss_categorie,$tbidvaleur[3],$tbidvaleur[2]);
        
                        if(count($datafiltre[0])>0) {
                            $data['bdd_flt_stitre'] = $datafiltre[0];
                            $data['bdd_flt_value'] = $datafiltre[1];
                            $data['bdd_flt_nbvaleur'] = $datafiltre[2];
                        }
                    
                    //var_dump($valeur);
                    //var_dump($tbidvaleur[1]);
                        $data['valeur'] = $tbidvaleur[1];
                        $data['tbidvaleur'] = $tbidvaleur[0];
                        $data['stbvaleur'] = $tbidvaleur[1];
                        $data['ID_CATEGORIE'] = $id_categorie;
                        $data['ID_S_CATEGORIE'] = $id_s_categorie;
                        $data['ID_SS_CATEGORIE'] = $id_ss_categorie;
                        $this->load->view('ajax/ajxftrproduit',$data);
                    } else { //filtre historiaue vide
                        $this->session->set_userdata('stbidstitre', null);
                        $this->session->set_userdata('stbvaleur',null); //session
                        $this->session->set_userdata('id_ss_categorie',null);
                        $data["ID_CATEGORIE"] = $id_categorie;
                        $data["ID_S_CATEGORIE"] = $id_s_categorie;
                        $data["ID_SS_CATEGORIE"] = $id_ss_categorie;
                        $datafiltre = $this->FiltreData($id_ss_categorie);
                        if(count($datafiltre[0])>0) {
                            $data['bdd_flt_stitre'] = $datafiltre[0];
                            $data['bdd_flt_value'] = $datafiltre[1];
                        }
                        $data["ID_SS_CATEGORIE"] = $id_ss_categorie;
                        $data = $this->ModeleProduit->SelectProduit($id_categorie,$id_s_categorie,$id_ss_categorie,$data);
                        $this->load->view('ajax/ajxftrproduit',$data);
                    }
               
                } else {
                    //redirect(base_url().'Accueil');
                }
            } else {
                 redirect(base_url().'Accueil');
            }
        }
        public function AjxFiltre($valeur=null,$id_categorie=null,$id_s_categorie=null,$id_ss_categorie=null,$id_stitre=null) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('valeur[]','valeur[]','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('id_categorie','id_ss_categorie','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('id_s_categorie','id_ss_categorie','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('id_ss_categorie','id_ss_categorie','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('id_stitre','id_stitre','trim|required|min_length[1]|encode_php_tags');
           
            if($this->form_validation->run() || ($valeur!=null && $id_categorie!=null && $id_s_categorie!=null && $id_ss_categorie!=null && $id_stitre!=null))
			{
                if($valeur==null && $id_categorie==null && $id_s_categorie==null && $id_ss_categorie==null && $id_stitre==null) {
                    //FORMULAIRE POST
                    $valeur= $this->input->post('valeur[]');
                    $id_categorie= $this->input->post('id_categorie');
                    $id_s_categorie= $this->input->post('id_s_categorie');
                    $id_ss_categorie= $this->input->post('id_ss_categorie');
                    $id_stitre= $this->input->post('id_stitre');
                   
                } else { } //VARIABLE GET
                
                $data['ID_CATEGORIE'] = $id_categorie;
                $this->load->model('Modele_Produit','ModeleProduit');
                $tbidvaleur = $this->FiltreDataSession($valeur,$id_stitre);
                
                $this->session->set_userdata('id_ss_categorie', $id_ss_categorie); //session de sous categorie
                $data = $this->ModeleProduit->SelectFiltreProduit($id_ss_categorie,$id_stitre,$data,$tbidvaleur[0],$tbidvaleur[3]);
                //var_dump($data['bdd_produit']);
                $data = $this->dataProduit($id_categorie,$id_s_categorie,$id_ss_categorie,$data);
                $datafiltre = $this->FiltreDataFiltre($id_ss_categorie,$tbidvaleur[3],$tbidvaleur[2]);//left filtre titre,valeur,nb_valeur
                //$svf = $this->ModeleProduit->SelectValueFiltre(21,'4','Lenovo',$tbidvaleur[3],$tbidvaleur[2]);
                
                
                if(count($datafiltre[0])>0) {
                    $data['bdd_flt_stitre'] = $datafiltre[0];
                    $data['bdd_flt_value'] = $datafiltre[1];
                    $data['bdd_flt_nbvaleur'] = $datafiltre[2];
                }
              
               //var_dump($valeur);
               //var_dump($tbidvaleur[1]);
                $data['valeur'] = $tbidvaleur[1];
                $data['tbidvaleur'] = $tbidvaleur[0];
                $data['stbvaleur'] = $tbidvaleur[1];
                $data['ID_S_CATEGORIE'] = $id_s_categorie;
                $data['ID_SS_CATEGORIE'] = $id_ss_categorie;
                $this->load->view('ajax/ajxftrproduit',$data);
            } else {
                redirect(base_url().'Accueil');
            }
        }
        public function FiltreDataFiltre($ID_SS_CATEGORIE,$stbidstitre,$stbvaleur) {

            $this->load->model('Modele_Produit','ModeleProduit');
            $bdd_stitre = $this->ModeleProduit->SelectFiltre($ID_SS_CATEGORIE);
            if(count($bdd_stitre)>0) {
                $data['bdd_flt_stitre'] =  $bdd_stitre;
                foreach($bdd_stitre as $bdd_stitre) { //boucle FTITRE
                    $bdd_value = $this->ModeleProduit->SelectValue($bdd_stitre->ID_FICHE_TQ_STITRE);
                    if(count($bdd_value)>0) {
                        $data2[$bdd_stitre->ID_FICHE_TQ_STITRE] = $bdd_value; //FVALEUR
                        foreach($bdd_value as $bdd_value) {
                            $datanbvaleur[$bdd_stitre->ID_FICHE_TQ_STITRE][$bdd_value->VALEUR] = $this->ModeleProduit->SelectValueFiltre($ID_SS_CATEGORIE,$bdd_stitre->ID_FICHE_TQ_STITRE,$bdd_value->VALEUR,$stbidstitre,$stbvaleur); //nombre de valeur
                        }        
                    }
                    
                    //var_dump($data[$bdd_stitre->ID_FICHE_TQ_STITRE]);
                }
                $result[0] = $data['bdd_flt_stitre']; //ftitre
                $result[1] = $data2; //fvaleur
                $result[2] = $datanbvaleur; //nombre de fvaleur
            } else {
                $result[0] = 0;
                $result[1] = 0;
                $result[2] = 0; 
            }
           
           
            return $result;
        }
        //RECHERCHE
        public function Recherche($splesearch=-1,$search=-1) {
            $this->load->model('Modele_Produit','ModeleProduit');
            $data = $this->dataMenu();
            if($splesearch=="ALL") {
                $data['bdd_produit'] =  $this->ModeleProduit->findProduitAll($search);
                $this->load->view('produit',$data);
            } else if($splesearch>0) {
                $data['bdd_produit'] =  $this->ModeleProduit->findProduitRn($search,$splesearch);
                $this->load->view('produit',$data);

            } else { //malin
                redirect(base_url().'Accueil');
            }
        }
        public function RechercheNull($valeur="vous") {
           
            if($valeur!="vous") {
                $data = $this->dataMenu();
                $data['valeur'] = $valeur;
                $this->load->view('produitnullsearch',$data);

            } else { //Malin lien modifier
                redirect(base_url().'Accueil');
                //$this->load->view('produitnullsearch');
            }
        }
        public function RechercheMenu() {
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('splesearch','splesearch','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('search','search','trim|required|min_length[1]|encode_php_tags');
            
            if($this->form_validation->run())
			{
                $splesearch= $this->input->post('splesearch');
                $search= $this->input->post('search');
                $this->load->model('Modele_Produit','ModeleProduit');
                if($splesearch=="ALL") {
                    $bdd_produit =  $this->ModeleProduit->findProduitAll($search);
                     //var_dump($bdd_produit);
                     if($bdd_produit->ID_CATEGORIE==null) { //aucun resultat
                        redirect(base_url().'Produit/RechercheNull/'.$search);
                        
                     } else {//resultat
                         $valeur[0] = $search;
                         //echo '</br>';
                         $id_categorie=$bdd_produit->ID_CATEGORIE;
                         //echo '</br>';
                        $id_s_categorie=$bdd_produit->ID_S_CATEGORIE;
                         //echo '</br>';
                        $id_ss_categorie=$bdd_produit->ID_SS_CATEGORIE;
                         //echo '</br>';
                         $id_stitre="SKEY";
                         $tbidvaleur = $this->FiltreDataSession($valeur,$id_stitre);
                         
                         $this->session->set_userdata('id_ss_categorie', $id_ss_categorie); //session de sous categorie
                         //$this->AjxFiltre($valeur,$id_categorie,$id_s_categorie,$id_ss_categorie,$id_stitre);
                         redirect(base_url().'Produit/Categorie3/'.$id_categorie.'/'.$id_s_categorie.'/'.$id_ss_categorie);
                     }
                } else if($splesearch>0) {
                    $bdd_produit =  $this->ModeleProduit->findProduitRn($search,$splesearch);
                   
                   // var_dump($bdd_produit);
                    if($bdd_produit->ID_CATEGORIE==null) { //aucun resultat
                        redirect(base_url().'Produit/RechercheNull/'.$search);
                    } else {//resultat
                        $valeur[0] = $search;
                      ///  echo '</br>';
                        $id_categorie=$bdd_produit->ID_CATEGORIE;
                       // echo '</br>';
                        $id_s_categorie=$bdd_produit->ID_S_CATEGORIE;
                       // echo '</br>';
                        $id_ss_categorie=$bdd_produit->ID_SS_CATEGORIE;
                       // echo '</br>';
                        $id_stitre="SKEY";
                        $tbidvaleur = $this->FiltreDataSession($valeur,$id_stitre);
                        
                        $this->session->set_userdata('id_ss_categorie', $id_ss_categorie); //session de sous categorie
                        $this->AjxFiltre($valeur,$id_categorie,$id_s_categorie,$id_ss_categorie,$id_stitre);
                        redirect(base_url().'Produit/Categorie3/'.$id_categorie.'/'.$id_s_categorie.'/'.$id_ss_categorie);
                        
                    }
                   
                    //$this->testform()
    
                } else { //malin
                    redirect(base_url().'Accueil');
                }
            } else { //malin
                
            }
           
        }
        //FUNCTION
        private function FiltreGetSession() {
            if($this->session->userdata('stbvaleur')!=NULL && $this->session->userdata('stbidstitre')!=NULL) { 
                $stbidvaleur[0] = $this->session->userdata('stbidstitre');
                $stbidvaleur[1] = $this->session->userdata('stbvaleur');
                return  $stbidvaleur;
            } else {
                $stbidvaleur[0] = null;
                $stbidvaleur[1] = null;
                return  $stbidvaleur;
            }
        }
        private function FiltreDataSession($valeur,$id_stitre) {
            if($this->session->userdata('stbvaleur')!=NULL && $this->session->userdata('stbidstitre')!=NULL) {
                $stbvaleur = $this->session->userdata('stbvaleur');
                $stbidstitre = $this->session->userdata('stbidstitre');
                
                $tempcount=0;
                for($i=0;$i<count($stbidstitre);$i++) {
                    if($stbidstitre[$i]==$id_stitre) {
                        $stbvaleur[$i] = $valeur; //change value
                        $tempcount++;
                    }
                }
                if($tempcount==0){ //new valeu
                    $in = count($stbvaleur);
                    $stbvaleur[$in] = $valeur;
                    $stbidstitre[$in] = $id_stitre;
                    $this->session->set_userdata('stbvaleur', $stbvaleur); //session
                    $this->session->set_userdata('stbidstitre', $stbidstitre);
                } else {
                    $this->session->set_userdata('stbvaleur', $stbvaleur);
                }
                //var_dump($stbvaleur);
            } else {
                $stbvaleur[0] = $valeur;
                $stbidstitre[0] = $id_stitre;
                $this->session->set_userdata('stbvaleur', $stbvaleur); //session
                $this->session->set_userdata('stbidstitre', $stbidstitre);
                //var_dump($stbvaleur);
                //var_dump($stbidstitre);
            }
            
            
            $tbidvaleur = array();
            $tballvaleur = array();
            for($i=0;$i<count($stbidstitre);$i++) {
                $tbidvaleur[$stbidstitre[$i]] = $stbvaleur[$i];
            }
            $iall=0;
            for($i=0;$i<count($stbvaleur);$i++) {
                if($stbidstitre[$i]=='PRICE') {
                    $tballvaleur[$iall] = 'Entre '.$stbvaleur[$i][0].' et '.$stbvaleur[$i][1];
                    $iall++;
                } else if($stbidstitre[$i]=='TRI') {
                    
                } else {
                    for($j=0;$j<count($stbvaleur[$i]);$j++) {
                        $tballvaleur[$iall] = $stbvaleur[$i][$j];
                        $iall++;
                    }
                }
            }
            //var_dump($tbidvaleur);
            //var_dump($tballvaleur);
            //var_dump($stbvaleur);
            //var_dump($stbidstitre);
            $result[0] =$tbidvaleur; // ex $tbidvaleur[4] == VALEUR 
            $result[1] =$tballvaleur;//list all valeur
            $result[2] =$stbvaleur; //list valeur
            
            $result[3] =$stbidstitre; //list id_titre

            //echo "----------------FILTRE SESSION------------------";
            //var_dump($result);
            return $result;
        }
        private function FiltreData($ID_SS_CATEGORIE) {
            $this->load->model('Modele_Produit','ModeleProduit');
            $bdd_stitre = $this->ModeleProduit->SelectFiltre($ID_SS_CATEGORIE);
            
            if(count($bdd_stitre)>0) {
                $data['bdd_flt_stitre'] =  $bdd_stitre;
                foreach($bdd_stitre as $bdd_stitre) {
                    $bdd_value = $this->ModeleProduit->SelectValue($bdd_stitre->ID_FICHE_TQ_STITRE);
                    if(count($bdd_value)>0) {
                        $data2[$bdd_stitre->ID_FICHE_TQ_STITRE] = $bdd_value;
                        
                    }
                    
                    //var_dump($data[$bdd_stitre->ID_FICHE_TQ_STITRE]);
                }
                $result[0] = $data['bdd_flt_stitre'];
                $result[1] = $data2;
            } else {
                $result[0] = 0;
                $result[1] = 0;
            }
           
           
            return $result;
        }
        public function AjoutPanier($ID_CATEGORIE=0,$ID_S_SATEGORIE=0,$ID_SS_CATEGORIE=0,$ID_PRODUIT=0,$QUANTITE=0){ //http://localhost/CodeIgnitertest/index.php/home/index ou http://localhost/CodeIgnitertest/index.php/home      
            $data = $this->dataMenu();
            if($this->session->userdata('lti_id_utilisateur')==NULL) {//SESSION UTILISATEUR NULL
				redirect(base_url().'connexion');
			} else {
                $this->load->model('Modele_Produit','ModeleProduit');
               
                if($ID_CATEGORIE==0 || $ID_S_SATEGORIE==0 || $ID_SS_CATEGORIE==0 || $ID_PRODUIT==0 || $QUANTITE==0) { //erreur de l'utilisateur
                    redirect(base_url().'Produit/Categorie3/'.$ID_CATEGORIE.'/'.$ID_S_SATEGORIE.'/'.$ID_SS_CATEGORIE);
                } else { //OK variable
                   
                
                    $data = $this->dataProduit($ID_CATEGORIE,$ID_S_SATEGORIE,$ID_SS_CATEGORIE,$data);
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
                            redirect(base_url().'Produit/Categorie3/'.$ID_CATEGORIE.'/'.$ID_S_SATEGORIE.'/'.$ID_SS_CATEGORIE);
                          } else { //produit pas dans le panier
                            if($this->ModeleProduit->AjoutPanier($this->session->userdata('lti_id_utilisateur'),$ID_PRODUIT,$QUANTITE)) {
                                $this->ModeleProduit->SetQuantitePd($ID_PRODUIT,$quantienew);// QUANTITE DIMINUER
                                redirect(base_url().'Produit/Categorie3/'.$ID_CATEGORIE.'/'.$ID_S_SATEGORIE.'/'.$ID_SS_CATEGORIE);
                            } else {
                               redirect(base_url().'Produit/Categorie3/'.$ID_CATEGORIE.'/'.$ID_S_SATEGORIE.'/'.$ID_SS_CATEGORIE);
                            }
                        }
                    } else {
                        redirect(base_url().'Produit/Categorie3/'.$ID_CATEGORIE.'/'.$ID_S_SATEGORIE.'/'.$ID_SS_CATEGORIE);
                    }
                }
            }
            
        }
        private function dataProduit($ID_CATEGORIE=0,$ID_S_SATEGORIE=0,$ID_SS_CATEGORIE=0,$data) {
            $this->load->model('Modele_Produit','ModeleProduit');
            $data["ID_CATEGORIE"] = $ID_CATEGORIE;
            $data["ID_S_CATEGORIE"] = $ID_S_SATEGORIE;
            $data["ID_SS_CATEGORIE"] = $ID_SS_CATEGORIE;
            //$data['categorie']
            //$data['scategorie']
            //$data['sscategorie']
            $data['tb_categorie'] = $this->ModeleProduit->SelectProduitLien($ID_CATEGORIE,$ID_S_SATEGORIE,$ID_SS_CATEGORIE);
            //$data['bdd_produit'] = $this->ModeleProduit->SelectProduit($ID_CATEGORIE,$ID_S_SATEGORIE,$ID_SS_CATEGORIE);
            //$this->session->set_userdata('lti_id_utilisateur', $id_etudiant);
            
            return $data;
        }
        private function dataMenu() { //data for menu drop down
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