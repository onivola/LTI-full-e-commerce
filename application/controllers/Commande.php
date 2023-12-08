<?php

    class Commande extends CI_Controller {

        public function __construct() {
			parent:: __construct();
			$this->titre_defaut = 'Mon super site';
			$this->load->helper(array('form', 'url'));
			$this->load->library('session');
		}
		public function index() {
			//$this->session->set_userdata('lti_insertfact',null);
			//$this->session->set_userdata('lti_insertdfact',null);
			//$this->session->set_userdata('lti_insertadress',null);
			if($this->session->userdata('lti_id_utilisateur')!=NULL) {
				$this->load->model('Modele_Commande','ModeleCommande');
				$this->load->model('Modele_Produit','ModeleProduit');
				$panier = $this->ModeleProduit->SelectPanierJoin($this->session->userdata('lti_id_utilisateur'));
				if(count($panier)>0) {
					$data['db_utilisateur'] = $this->ModeleCommande->SelectUtilByid($this->session->userdata('lti_id_utilisateur'));
					$data['db_villetarif'] = $this->ModeleCommande->SelectVille();
					$this->load->view('Commande',$data);
				} else {
					redirect(base_url().'Accueil');
				}
			} else {
				redirect(base_url().'Accueil');
			}
			
		}
		public function ValiderCommande(){
            $this->load->library('form_validation');
			$this->form_validation->set_rules('civilit','civilit','trim|required|min_length[1]|encode_php_tags');
			$this->form_validation->set_rules('nom','nom','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('prenom','prenom','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('ville','ville','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('adresse','adresse','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('cadresse','cadresse','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('cpostal','cpostal','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('phone','phone','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('checkpaiement','checkpaiement','trim|required|min_length[1]|encode_php_tags');
            
            if($this->form_validation->run())
			{
				$civilit['civilit'] = $this->input->post('civilit');
				$nom= $this->input->post('nom');
				$prenom= $this->input->post('prenom');
				$ville = $this->input->post('ville');
				$adresse = $this->input->post('adresse');
				$cadresse = $this->input->post('cadresse');
				$cpostal = $this->input->post('cpostal');
				$phone = $this->input->post('phone');
				$checkpaiement= $this->input->post('checkpaiement');

				if($checkpaiement=='mvola' || $checkpaiement=='paypal'|| $checkpaiement=='vbancaire') {
					$this->load->model('Modele_Commande','ModeleCommande');
					$reference = $this->ModeleCommande->GetReference($this->session->userdata('lti_id_utilisateur'));
					$prixtotal = $this->ModeleCommande->GetPrixTotal($this->session->userdata('lti_id_utilisateur'));
					if($this->session->userdata('lti_insertfact')==1) {
						$reference = $this->ModeleCommande->GetMaxIdfacture($this->session->userdata('lti_id_utilisateur'));
					}
					if($this->session->userdata('lti_insertfact')==NULL) {
						if($this->ModeleCommande->InsertFacture($this->session->userdata('lti_id_utilisateur'),$reference,$checkpaiement,$prixtotal)) { //facture inserer
							$this->session->set_userdata('lti_insertfact',1);
						}
					}
					$id_facture = $this->ModeleCommande->GetIdfacture($this->session->userdata('lti_id_utilisateur'),$reference);
					if($this->session->userdata('lti_insertdfact')==NULL) {
						if($this->ModeleCommande->InsertDetailFacture($this->session->userdata('lti_id_utilisateur'),$id_facture)) {
							$this->session->set_userdata('lti_insertdfact',1);
						}
					}
					if($this->session->userdata('lti_insertadress')==NULL) {
						if($this->ModeleCommande->InsertAdress($id_facture,$this->session->userdata('lti_id_utilisateur'),$nom,$prenom,'Madagascar',$ville,$adresse,$cadresse,$phone,$phone,$cpostal)) {
							$this->session->set_userdata('lti_insertadress',1);
						}
					}
						
					redirect(base_url().'Moncompte/Commande');	 
					
					
				} else { //paiement invalide
					redirect(base_url().'Commande');
				}
            } else {
				redirect(base_url().'Commande');
            }
        }
		public function AjaxPaiement() {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('civilit','civilit','trim|required|min_length[1]|encode_php_tags');
			$this->form_validation->set_rules('nom','nom','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('prenom','prenom','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('ville','ville','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('adresse','adresse','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('cadresse','cadresse','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('cpostal','cpostal','trim|required|min_length[1]|encode_php_tags');
            $this->form_validation->set_rules('phone','phone','trim|required|min_length[1]|encode_php_tags');
           
            if($this->form_validation->run())
			{
				$data['civilit'] = $this->input->post('civilit');
				$data['nom']= $this->input->post('nom');
				$data['prenom']= $this->input->post('prenom');
				$data['ville'] = $this->input->post('ville');
				$data['adresse'] = $this->input->post('adresse');
				$data['cadresse'] = $this->input->post('cadresse');
				$data['cpostal'] = $this->input->post('cpostal');
				$data['phone'] = $this->input->post('phone');
				$this->load->model('Modele_Commande','ModeleCommande');
				$data['db_panier'] = $this->ModeleCommande->SelectPanierJoin($this->session->userdata('lti_id_utilisateur'));
				$this->load->view('ajax/ajxpaiement',$data);
			} else {

			}
			
		}
       
	}

?>