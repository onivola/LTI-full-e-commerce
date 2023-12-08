<?php
    class Etudiant extends CI_Controller {

        public function __construct() {
           parent:: __construct();
            $this->titre_defaut = 'Mon super site';
             $this->load->helper(array('form', 'url')); 
             $this->load->library('session'); 
        }
        public function index(){ //http://localhost/CodeIgnitertest/index.php/home/index ou http://localhost/CodeIgnitertest/index.php/home
           
			if($this->session->userdata('id_etudiant')==NULL) {
              $this->load->view('Accueil');
            } else {
			  $this->load->view('Etudiant');
			}
			
        }
		 public function Examen(){
           
		   
           if($this->session->userdata('id_etudiant')==NULL) {
              $this->load->view('Accueil');
            } else {
				$this->load->model('Modele_Enseignant','ModeleEnseignant');
				//les examen deja fait ne s'affiche pas
				$data['examen'] =  $this->ModeleEnseignant->Selectexamenpaspasser($this->session->userdata('id_etudiant'));
				$this->load->view('Examen',$data);
			}
        }
		 public function Note(){  
            
            if($this->session->userdata('id_etudiant')==NULL) {
              $this->load->view('Accueil');
			  
            } else {
				$this->load->library('form_validation');
				$this->load->model('Modele_Etudiant','ModeleEtudiant');
				//$where = array("id_etudiant"=>$id_etudiant,"id_examen"=>$id_examen;
				$where = array("id_etudiant"=>$this->session->userdata('id_etudiant'));
				$data['matiere'] =  $this->ModeleEtudiant->Selectresultatmatiere($where); //matiere
				$data['resultat'] =  $this->ModeleEtudiant->SelectWhereResultat($where); //resultat de l'etudiant
				
				
				
				
				$this->session->unset_userdata(array('id_examen'=>''));
				
				$this->session->userdata('id_examen');
				
				$this->form_validation->set_rules('matiere','matiere','trim|required|alpha_dash|encode_php_tags');
				if($this->form_validation->run())
				{
					$nom_matiere = $this->input->post('matiere');
					if($nom_matiere!="tout") {
						$where = array("id_etudiant"=>$this->session->userdata('id_etudiant'),"nom_matiere"=>$nom_matiere);
						$data['resultat'] =  $this->ModeleEtudiant->SelectWhereResultat($where);
					}
					$this->load->view('Note',$data);
				} else {
					
					
					$this->load->view('Note',$data);
				}
				
			}
        }
		public function Deconnexion() {
			 $this->session->sess_destroy();
			 $this->load->view('Accueil');
		}
    }

?>