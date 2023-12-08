<?php
    class Adminlti1379 extends CI_Controller {

        public function __construct() {
           parent:: __construct();
            $this->titre_defaut = 'Mon super site';
             $this->load->helper(array('form', 'url')); 
             $this->load->library('session'); 
        }
        public function index(){ //http://localhost/CodeIgnitertest/index.php/home/index ou http://localhost/CodeIgnitertest/index.php/home 
				 $this->load->view('Admin/Accueil'); 
        }
        public function AjoutCategorie() {
            
            $data = $this->GetData();//All categorie
            $this->load->view('Admin/AjoutCategorie',$data);
        }
		public function AjoutProduit() {
            $data = $this->GetData();//All categorie
            $this->load->view('Admin/AjoutProduit',$data);
        }
        public function AjoutCaracteristique() {
            $data = $this->GetData();//All categorie
            $this->load->view('Admin/AjoutCaracteristique',$data);
        }
		public function connexion() {
			 $this->load->view('Accueil');
        }
        /*----------------GESTION DES COMMANDES-----------------**/
        public function GestCommande() {
            $this->load->model('Modele_Admin','ModeleAdmin');
            /**LIST COMMANDE */
            $db_facture = $this->ModeleAdmin->SelectFacture();
            $db_facturedata = $db_facture;
            $db_dtlfacture=null;
            $db_adresse=null;
            $db_paiement=null;
            $bd_totalpaiement=null;
            if(count($db_facture)>0) { //facture non null
                foreach($db_facture as $db_facture) {
                    $db_dtlfacture[$db_facture->ID_FACTURE] = $this->ModeleAdmin->SelectDtlFacture($db_facture->ID_FACTURE);
                    $db_adresse[$db_facture->ID_FACTURE] = $this->ModeleAdmin->SelectAdresse($db_facture->ID_FACTURE);
                    $db_paiement[$db_facture->ID_FACTURE] = $this->ModeleAdmin->SelectPaiement($db_facture->ID_FACTURE);
                    $bd_totalpaiement[$db_facture->ID_FACTURE]=$this->ModeleAdmin->SelectSumPaiement($db_facture->ID_FACTURE);
                }
            } 
            $data['db_facture'] = $db_facturedata;
            $data['db_dtlfacture'] = $db_dtlfacture;
            $data['db_adresse'] = $db_adresse;
            $data['db_paiement'] = $db_paiement;
            $data['bd_totalpaiement'] = $bd_totalpaiement;
            
            $this->load->view('Admin/GestCommande',$data);
        }
        /*----------------AJOUT FICHE TECHNIQUE-----------------**/
        public function FormFicheT1() {
            $this->load->model('Modele_Admin','ModeleAdmin');
            $data = $this->GetData();//All categorie
            $this->load->library('form_validation');
            $this->form_validation->set_rules('titre1','titre1','trim|required|min_length[1]|max_length[100]|encode_php_tags');
            $this->form_validation->set_rules('sscat','sscat','trim|required|min_length[1]|max_length[100]|encode_php_tags');

            if($this->form_validation->run())
			{
                //htmlentities insert ' in bdd
                $ID_SS_CATEGORIE= mysql_escape_string($this->input->post('sscat'));
                $FTITRE=$this->input->post('titre1');
                if($this->ModeleAdmin->CheckFicheT1($ID_SS_CATEGORIE,$FTITRE)) {
                    if($this->ModeleAdmin->AjouterFicheT1($ID_SS_CATEGORIE,$FTITRE)) {
                        $data['ok_t1'] = "Titre ajouter";
                        $this->load->view('Admin/AjoutCaracteristique',$data);
                    } else {
                        echo "erreur de connexion";
                    }
                } else {
                    $data['erreur_t1'] = "Titre deja existant";
                    $this->load->view('Admin/AjoutCaracteristique',$data);
                }
            } else {
                $this->load->view('Admin/AjoutCaracteristique',$data);
            }
        }
        public function FormFicheT2() {
            $this->load->model('Modele_Admin','ModeleAdmin');
            $data = $this->GetData();//All categorie
            $this->load->library('form_validation');
            $this->form_validation->set_rules('titre1','titre1','trim|required|min_length[1]|max_length[100]|encode_php_tags');
            $this->form_validation->set_rules('titre2','titre2','trim|required|min_length[1]|max_length[100]|encode_php_tags');
            $this->form_validation->set_rules('recherche','recherche','trim|required|min_length[1]|max_length[100]|encode_php_tags');
            //HIDDEN
            $this->form_validation->set_rules('hcat','hcat','trim|required|min_length[1]|max_length[100]|encode_php_tags');
            $this->form_validation->set_rules('hscat','hscat','trim|required|min_length[1]|max_length[100]|encode_php_tags');
            $this->form_validation->set_rules('hsscat','hsscat','trim|required|min_length[1]|max_length[100]|encode_php_tags');

            if($this->form_validation->run())
			{
                //htmlentities insert ' in bdd
                $ID_FICHE_TQ_TITRE= $this->input->post('titre1');
                $FSTITRE= $this->input->post('titre2');
                $RECHERCHE= $this->input->post('recherche');
                //HIDDEN
                $data['ID_CATEGORIE'] = $this->input->post('hcat');
                $data['ID_S_CATEGORIE'] = $this->input->post('hscat');
                $data['ID_SS_CATEGORIE'] = $this->input->post('hsscat');

                $data['CTITRE'] = $this->ModeleAdmin->SelectWIdCat2($this->input->post('hcat'));
                $data['CSTITRE'] = $this->ModeleAdmin->SelectWIdSCat2($this->input->post('hscat'));
                $data['CSSTITRE'] = $this->ModeleAdmin->SelectWIdSSCat2($this->input->post('hsscat'));
                if($this->ModeleAdmin->CheckFicheT2($ID_FICHE_TQ_TITRE,$FSTITRE)) {
                    if($this->ModeleAdmin->AjouterFicheT2($ID_FICHE_TQ_TITRE,$RECHERCHE,$FSTITRE)) {
                        $data['ok_t2'] = "Titre 2 ajouter";
                        $this->load->view('Admin/AjoutCaracteristique',$data);
                    } else {
                        echo "erreur de connexion";
                    }
                    
                } else {
                    $data['erreur_t2'] = "Titre 2 deja existant";
                    $this->load->view('Admin/AjoutCaracteristique',$data);
                }
            } else {
                $this->load->view('Admin/AjoutCaracteristique',$data);
            }
        }
        //function
        public function GetData() {
            $this->load->model('Modele_Admin','ModeleAdmin');
            $data['bdd_cat'] = $this->ModeleAdmin->SelectCat();//All categorie
            $data['bdd_scat'] = $this->ModeleAdmin->SelectSCat();//All sous categorie
            $data['bdd_sscat'] = $this->ModeleAdmin->SelectSSCat();//All sous categorie
          
            return $data;    
        }
        public function do_uploadImg($input,$name)
        {
            //echo $_FILES['img1']['name'];
            //echo $_FILES['img2']['name'];
            //echo $_FILES['img1']['name'][1];

            $config['upload_path']          = './uploads/produit';
            $config['allowed_types']        = 'jpg';
            $config['max_size']             = 1000; //ko
            $config['max_width']            = 2000; //px
            $config['max_height']           = 2000; //px
            $this->load->library('upload', $config);
            $config['file_name'] = $name;
            $this->upload->initialize($config);
            if ($this->upload->do_upload($input))//fle not upload
            {
                return true;
            }
            else //file upload
            {  
                $error = array('error' => $this->upload->display_errors());
                return false;
            }
        }
        /*******************AJOUT PROUDUIT******************** */
        public function FormProduit($nbinput=0) {
            $this->load->model('Modele_Admin','ModeleAdmin');
            $data = $this->GetData();//All categorie
            $this->load->library('form_validation');
            $this->form_validation->set_rules('designation','designation','trim|required|min_length[1]|max_length[50]|is_unique[produit.designation]|encode_php_tags',array('is_unique' => 'Produit deja existant'));
            for($i=1;$i<=$nbinput;$i++) {
                $this->form_validation->set_rules('titrenb'.$i,'titrenb'.$i,'trim|required|min_length[1]|max_length[50]|encode_php_tags');
                $this->form_validation->set_rules('id_titrenb'.$i,'id_titrenb'.$i,'trim|required|min_length[1]|max_length[50]|encode_php_tags');
                $this->form_validation->set_rules('id_stitrenb'.$i,'id_stitrenb'.$i,'trim|required|min_length[1]|max_length[50]|encode_php_tags');
               
            }
           
            if($this->form_validation->run())
			{
               
                $ID_CATEGORIE= ($this->input->post('cat'));
                $ID_S_CATEGORIE=($this->input->post('scat'));
                $ID_SS_CATEGORIE=($this->input->post('sscat'));
                $DESIGNATION=($this->input->post('designation'));
                $PRIX_ACHAT=($this->input->post('prix_achat'));
                $PRIX_VENTE=($this->input->post('prix_vente'));
                $QUANTITE=($this->input->post('quantite'));
                $INFO=($this->input->post('info'));
                $DESCRIPTION=($this->input->post('description'));
                $STATUT=($this->input->post('statut'));

                if(isset($_FILES['img1']['name']) && isset($_FILES['img2']['name']) && isset($_FILES['img3']['name']) && isset($_FILES['img4']['name']) && isset($_FILES['img5']['name'])) {
                    if($this->ModeleAdmin->AjouterProduit($ID_CATEGORIE,$ID_S_CATEGORIE,$ID_SS_CATEGORIE,$DESIGNATION,$PRIX_ACHAT,$PRIX_VENTE,$QUANTITE,$INFO,$DESCRIPTION,$STATUT)) {
                        $maxId = $this->ModeleAdmin->SelectMaxId();
                   
                        if($this->do_uploadImg('img1',$maxId.'IMG'.'1') && $this->do_uploadImg('img2',$maxId.'IMG'.'2') && $this->do_uploadImg('img3',$maxId.'IMG'.'3') && $this->do_uploadImg('img4',$maxId.'IMG'.'4') && $this->do_uploadImg('img5',$maxId.'IMG'.'5')) {
                       
                            for($i=1;$i<=$nbinput;$i++) { //insert fiche value
                                $this->ModeleAdmin->AjouterValeur($this->input->post('id_stitrenb'.$i),$maxId,$this->input->post('id_titrenb'.$i), $this->input->post('titrenb'.$i));
                            }
                            $data['ok_produit'] = true; //insert success
                            $this->load->view('Admin/AjoutProduit',$data);
                        }else{
                            echo "erreur uploading file...";
                        }
                   } else {
                        echo "erreur de connexion...";
                    }
                } else {
                    echo "erreur file not find";
                }
            } else {
                $this->load->view('Admin/AjoutProduit',$data);
            }
        }
        /******************LOAD AJAX************************ */
        public function AjaxDellPayer() {
            $this->load->model('Modele_Admin','ModeleAdmin');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id_paiement','id_paiement','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('id_facture','id_facture','trim|required|min_length[1]|encode_php_tags');
            if($this->form_validation->run())
			{
                $ID_PAIEMENT =  (int)$this->input->post('id_paiement');
                $ID_FACTURE =  (int)$this->input->post('id_facture');
                if($this->ModeleAdmin->DelletePaiement($ID_PAIEMENT)) {
                    if($this->ModeleAdmin->Setstatut($ID_FACTURE,'En attente de paiement')) {
                        $data['db_paiement'] = $this->ModeleAdmin->SelectPaiement($ID_FACTURE);
                        $bd_totalfacture= $this->ModeleAdmin->SelectFactureByid($ID_FACTURE);
                        $data['prix_total'] = $bd_totalfacture->PRIX_TOTAL;
                        $data['id_facture'] = $ID_FACTURE;
                        $bd_totalpaiement = $this->ModeleAdmin->SelectSumPaiement($ID_FACTURE);
                        $data['rest_payer'] = $bd_totalfacture->PRIX_TOTAL-$bd_totalpaiement->total_payer;
                        $this->load->view('Admin/ajax/ajxpaiement',$data);
                    }
                }
            } else {

            }
        }
        public function AjaxPayer() {
            $this->load->model('Modele_Admin','ModeleAdmin');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('prix','prix','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('id_facture','id_facture','trim|required|min_length[1]|encode_php_tags');
            if($this->form_validation->run())
			{
                $PAYER =  $this->input->post('prix');
                $ID_FACTURE =  $this->input->post('id_facture');
                $prix_total =  $this->input->post('prix_total');
                $bd_totalfacture=$this->ModeleAdmin->SelectFactureByid($ID_FACTURE);
                $bd_totalpaiement=$this->ModeleAdmin->SelectSumPaiement($ID_FACTURE);
                
                $totalfacture = $bd_totalfacture->PRIX_TOTAL;
                $totalpaiement = 0;
                if($bd_totalpaiement!=null) {
                    $totalpaiement=$bd_totalpaiement->total_payer;
                }
                $rest = $totalfacture-$totalpaiement;
                if($PAYER<=$rest) {
                    if($this->ModeleAdmin->AjoutPaiement($ID_FACTURE,$PAYER)) {
                        $statut = 'En attente de paiement';
                        if($PAYER==$rest) {
                            $statut = 'Payer';
                        }
                        if($this->ModeleAdmin->Setstatut($ID_FACTURE,$statut)) {
                            $data['db_paiement'] = $this->ModeleAdmin->SelectPaiement($ID_FACTURE);
                            $data['prix_total'] = $totalfacture;
                            $data['id_facture'] = $ID_FACTURE;
                            $bd_totalpaiement = $this->ModeleAdmin->SelectSumPaiement($ID_FACTURE);
                            $data['rest_payer'] = $totalfacture-$bd_totalpaiement->total_payer;
                            $this->load->view('Admin/ajax/ajxpaiement',$data);
                        }
                       
                    }
                } else { //prix superieur a rest a payer
                    //$data['db_paiement'] =null;
                    //  $this->load->view('Admin/ajax/ajxpaiement',$data);
                }
               
              
            } else {
                echo "erreur";
            }
        }
        public function AjaxLivrer() {
            $this->load->model('Modele_Admin','ModeleAdmin');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id_facture','id_facture','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('indice','indice','trim|required|min_length[1]|encode_php_tags');
            if($this->form_validation->run())
			{
                $indice =  $this->input->post('indice');
                $ID_FACTURE =  $this->input->post('id_facture');
                $bd_dtlfact = $this->ModeleAdmin->SelectDtlFacture($ID_FACTURE);
                if($indice==1) {
                    foreach($bd_dtlfact as $bd_dtlfact) {
                        $this->ModeleAdmin->AddTopVente($bd_dtlfact->ID_PRODUIT);
                    }
                    if($this->ModeleAdmin->Setstatut($ID_FACTURE,'Payer et livrer')) {
                        $data['ID_FACTURE'] = $ID_FACTURE;
                        $data['indice'] = $indice;
                        $this->load->view('Admin/ajax/ajxlivrer',$data);
                    } 
                } else {
                    foreach($bd_dtlfact as $bd_dtlfact) {
                        $this->ModeleAdmin->AnnulTopVente($bd_dtlfact->ID_PRODUIT);
                    }
                    if($this->ModeleAdmin->Setstatut($ID_FACTURE,'Payer')) {
                        $data['ID_FACTURE'] = $ID_FACTURE;
                        $data['indice'] = $indice;
                        $this->load->view('Admin/ajax/ajxlivrer',$data);
                    } 
                }
               
            } else {
                echo "erreur";
            }
        }
        public function FormFicheTechProduit() {
            $this->load->model('Modele_Admin','ModeleAdmin');
            $data = $this->GetData();//All categorie
            $this->load->library('form_validation');
            $this->form_validation->set_rules('ID_SS_CATEGORIE','ID_SS_CATEGORIE','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('CSSTITRE','CSSTITRE','trim|required|min_length[1]|encode_php_tags');
            if($this->form_validation->run())
			{
                $ID_SS_CATEGORIE =  $this->input->post('ID_SS_CATEGORIE');
                $CSSTITRE =  $this->input->post('CSSTITRE');
                $bdd_fichet1 = $this->ModeleAdmin->SelectFicheT1($ID_SS_CATEGORIE);
                $tempfichet1 =  $bdd_fichet1;
                if(count($tempfichet1)>0) {
                    foreach($bdd_fichet1 as $bdd_fichet1) { 
                        $tempfichet2[$bdd_fichet1->ID_FICHE_TQ_TITRE] = $this->ModeleAdmin->SelectFicheT2($bdd_fichet1->ID_FICHE_TQ_TITRE);
                    }
                }
                else {
                    $tempfichet2=0;
                }
                $data['bdd_fichet1'] = $tempfichet1;
                $data['bdd_fichet2'] = $tempfichet2;
                $data['CSSTITRE'] = $CSSTITRE;
              
                $this->load->view('Admin/ajax/fichetechproduit',$data);
            } else {
                echo 1;
            }
        }
        public function FormFicheTech() {
            $this->load->model('Modele_Admin','ModeleAdmin');
            $data = $this->GetData();//All categorie
            $this->load->library('form_validation');
            $this->form_validation->set_rules('ID_SS_CATEGORIE','ID_SS_CATEGORIE','trim|required|min_length[1]|encode_php_tags');
            if($this->form_validation->run())
			{
                $ID_SS_CATEGORIE =  $this->input->post('ID_SS_CATEGORIE');
                $bdd_fichet1 = $this->ModeleAdmin->SelectFicheT1($ID_SS_CATEGORIE);
                $tempfichet1 =  $bdd_fichet1;
                foreach($bdd_fichet1 as $bdd_fichet1) { 
                    $tempfichet2[$bdd_fichet1->ID_FICHE_TQ_TITRE] = $this->ModeleAdmin->SelectFicheT2($bdd_fichet1->ID_FICHE_TQ_TITRE);
                }
                $data['bdd_fichet1'] = $tempfichet1;
                $data['bdd_fichet2'] = $tempfichet2;
                $this->load->view('Admin/ajax/fichetech',$data);
            } else {
                echo 1;
            }
        }
        public function AjaxTitre() {
            $this->load->model('Modele_Admin','ModeleAdmin');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('ID_SS_CATEGORIE','ID_SS_CATEGORIE','trim|required|min_length[1]|encode_php_tags');
			if($this->form_validation->run())
			{
                $ID_SS_CATEGORIE= mysql_escape_string($this->input->post('ID_SS_CATEGORIE'));
                $data['bdd_t1'] = $this->ModeleAdmin->SelectFicheT1($ID_SS_CATEGORIE);
                $this->load->view('Admin/ajax/crt_titre1',$data);
            } else {
                echo 1;
            }
        }
        public function AjaxCategorie() {
            $this->load->model('Modele_Admin','ModeleAdmin');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('ID_CATEGORIE','ID_CATEGORIE','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('ID_S_CATEGORIE','ID_S_CATEGORIE','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('ref','ref','trim|required|min_length[1]|encode_php_tags');
			if($this->form_validation->run())
			{
                if($this->input->post('ID_CATEGORIE')>0 && $this->input->post('ID_S_CATEGORIE')==0 && $this->input->post('ref')==0) { //si id_categorie >0
                    $ID_CATEGORIE = $this->input->post('ID_CATEGORIE');
                    $data['bdd_scat'] = $this->ModeleAdmin->SelectWidSCat($ID_CATEGORIE);//All sous categorie
                    $data['ref'] = 0;
                    $data['bdd_sscat'] = array();
                    $this->load->view('Admin/ajax/categorie',$data);
                } else if($this->input->post('ID_CATEGORIE')>0 && $this->input->post('ID_S_CATEGORIE')>0 &&  $this->input->post('ref')==1) {
                    $ID_CATEGORIE = $this->input->post('ID_CATEGORIE');
                    $ID_S_CATEGORIE = $this->input->post('ID_S_CATEGORIE');
                    $data['bdd_sscat'] = $this->ModeleAdmin->SelectWidSSCat($ID_CATEGORIE,$ID_S_CATEGORIE);//All sous categorie
                    $data['ref'] = 1;
                    $data['bdd_scat'] = array();
                    $this->load->view('Admin/ajax/categorie',$data);
                }
             } else {
                echo 1;
            }
            
        }
        /*******************AJOUT CATEGORIE***************** */
        //form submit
        public function FormCategorie() {
            $this->load->model('Modele_Admin','ModeleAdmin');
            $data = $this->GetData();//All categorie
            $this->load->library('form_validation');
            $this->form_validation->set_rules('categorie','categorie','trim|required|min_length[2]|max_length[50]|is_unique[categorie.CTITRE]|encode_php_tags',array('is_unique' => 'Categorie deja existant'));
			if($this->form_validation->run())
			{
                $categorie = mysql_escape_string($this->input->post('categorie'));
                if($this->ModeleAdmin->AjouterCategorie($categorie)) {
                    $data['ok_cat'] = true; //insert success
                    $this->load->view('Admin/AjoutCategorie',$data);
                }
               
            } else {
                $this->load->view('Admin/AjoutCategorie',$data);
            }
        }
        public function FormSCategorie() {
            $this->load->model('Modele_Admin','ModeleAdmin');
            $data = $this->GetData(); //data for view
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id_categorie','categorie','trim|required|min_length[1]|max_length[50]|encode_php_tags');
            $this->form_validation->set_rules('scategorie','scategorie','trim|required|min_length[2]|max_length[50]|encode_php_tags');
			if($this->form_validation->run())
			{
                $id_categorie = mysql_escape_string($this->input->post('id_categorie'));
                $scategorie = mysql_escape_string($this->input->post('scategorie'));
                $verif = $this->ModeleAdmin->SelectUniqueSCat($id_categorie,$scategorie);
               if(!empty($verif)) { //IS UNIQUE
                    $data['error_scat'] = true; //insert success
                    $this->load->view('Admin/AjoutCategorie',$data);
               } else {
                    if($this->ModeleAdmin->AjouterSCategorie($id_categorie,$scategorie)) {
                        $data['ok_scat'] = true; //insert success
                        $this->load->view('Admin/AjoutCategorie',$data);
                    }
               }
                
              
            } else {
                //var_dump($data);
                $this->load->view('Admin/AjoutCategorie',$data);
            }
        }
        public function FormSSCategorie() {
            $this->load->model('Modele_Admin','ModeleAdmin');
            $data = $this->GetData();//All categorie
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id_categorie','id_categorie','trim|required|min_length[1]|max_length[50]|encode_php_tags');
            $this->form_validation->set_rules('id_scategorie','id_scategorie','trim|required|min_length[1]|max_length[50]|encode_php_tags');
            $this->form_validation->set_rules('sscategorie','scategorie','trim|required|min_length[2]|max_length[50]|encode_php_tags');
			if($this->form_validation->run())
			{
                $id_categorie = mysql_escape_string($this->input->post('id_categorie'));
                $id_scategorie = mysql_escape_string($this->input->post('id_scategorie'));
                $sscategorie = mysql_escape_string($this->input->post('sscategorie'));
                $verifScat = $this->ModeleAdmin->SelectUniqueSSCat($id_categorie,$id_scategorie,$sscategorie);
                if(!empty($verifScat)) { //IS UNIQUE
                     $data['error_scat2'] = true; 
                     $this->load->view('Admin/AjoutCategorie',$data);
                } else {
                     if($this->ModeleAdmin->AjouterSSCategorie($id_categorie,$id_scategorie,$sscategorie)) {
                         $data['ok_scat2'] = true; //insert success
                         $this->load->view('Admin/AjoutCategorie',$data);
                     }
                }
            } else {
                $this->load->view('Admin/AjoutCategorie',$data);
            }
        }
    }

?>