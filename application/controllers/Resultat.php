<?php
    class Resultat extends CI_Controller {

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
			  $this->load->view('Resulexamen.php');
			}
			
        }
    }

?>