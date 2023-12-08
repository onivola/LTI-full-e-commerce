<?php
    class Enseignant extends CI_Controller {

        public function __construct() {
           parent:: __construct();
            $this->titre_defaut = 'Mon super site';
             $this->load->helper(array('form', 'url')); 
             $this->load->library('session'); 
        }
        public function index(){ //http://localhost/CodeIgnitertest/index.php/home/index ou http://localhost/CodeIgnitertest/index.php/home
           
            if($this->session->userdata('id_enseignant')==NULL) {
              $this->load->view('Accueil');
            } else {
				$this->load->view('Enseignant');
			}
        }
		//function
		public function Setdate($setdate) {
			$date=$setdate;
			$char = array("/");
			$replace   = array("-");
			$newphrase = str_replace($char, $replace, $date);
			//$morceau = substr($newphrase,11,15);
			//echo $morceau;
			$date_array = explode(" ",$newphrase,3); //Scinde une charactaire
			$date = $date_array[0];
			//change format date
			$date_array2 = explode("-",$date,3);
			$date = $date_array2[2]."-".$date_array2[0]."-".$date_array2[1];
			//change format date
			$time = $date_array[1];
			$ampm = $date_array[2];
			$time_array = explode(":",$time,2);
			$hour=(int)$time_array[0];
			$minute=$time_array[1];
			if($ampm=="AM") {
				$hour = (String)($hour);
				$newtime = $hour.":".$minute.":"."00";
			} else if($ampm=="PM") {
				$hour = (String)($hour+12);
				$newtime = $hour.":".$minute.":"."00";
			}
			 $newdate = $date." ".$newtime;
			 return $newdate;
		}
		public function Settime($settime) {
			$time = $settime;
			$time_array = explode(" ",$time,2);
			$time = $time_array[0];
			$ampm = $time_array[1];
			
			$time_array = explode(":",$time,2);
			$hour=(int)$time_array[0];
			$minute=$time_array[1];
			if($ampm=="AM") {
				$hour = (String)($hour);
				$newtime = $hour.":".$minute.":"."00";
			} else if($ampm=="PM") {
				$hour = (String)($hour+12);
				$newtime = $hour.":".$minute.":"."00";
			}
			return $newtime;
		}
		//function
		 public function Poulquestion(){
          
           /** if($this->session->userdata('id_utilisateur')!=NULL) {
                $id_utilisateur = $this->session->userdata('id_utilisateur');
                echo $id_utilisateur;
            }**/
		
			
			if($this->session->userdata('id_enseignant')==NULL) {
              $this->load->view('Accueil');
            } else {
				$this->load->model('Modele_Enseignant','ModeleEnseignant');
				$this->load->library('form_validation');
				$this->load->model('Modele_Matiere','ModeleMatiere');
				
				$data['matiere'] =  $this->ModeleMatiere->Selectrelation($this->session->userdata('id_enseignant'));
				
				//$this->ModeleMatiere->Ajouterreponse(1,"no",1);
				
				$this->form_validation->set_rules('matiere','matiere','trim|required|alpha_dash|encode_php_tags');
				$this->form_validation->set_rules('question','question','trim|required|alpha_dash|encode_php_tags');
				$this->form_validation->set_rules('pointneg','point negatif','trim|required|alpha_dash|encode_php_tags');
				$this->form_validation->set_rules('rep1','reponse 1','trim|required|alpha_dash|encode_php_tags');
				$this->form_validation->set_rules('rep2','reponse 2','trim|required|alpha_dash|encode_php_tags');
				$this->form_validation->set_rules('rep3','reponse 3','trim|required|alpha_dash|encode_php_tags');
				$this->form_validation->set_rules('rep4','reponse 4','trim|required|alpha_dash|encode_php_tags');
				
				
				if($this->form_validation->run())
				{
					$matiere = $this->input->post('matiere');
					$question = $this->input->post('question');
					$pointneg = (int)$this->input->post('pointneg');
					if($pointneg<=0) {
						$pointneg=1;
					}
					$rep1 = $this->input->post('rep1');
					$rep2 = $this->input->post('rep2');
					$rep3 = $this->input->post('rep3');
					$rep4 = $this->input->post('rep4');
					
					$checkrep1 = $this->input->post('checkrep1');
					$checkrep2 = $this->input->post('checkrep2');
					$checkrep3 = $this->input->post('checkrep3');
					$checkrep4 = $this->input->post('checkrep4');
					if($checkrep1=="on" or $checkrep2=="on" or $checkrep3=="on" or $checkrep4=="on" ) 
					{
						 $this->ModeleEnseignant->Ajouterquestion($matiere,$question,$pointneg);
						 $dataid = $this->ModeleMatiere->Selectmaxidquestion();
						
						foreach($dataid as $list) { 
							$max_id_question = $list->maxid;//id de l'utilisateur inscrit
						}
						
						if($checkrep1=="on") { $vrai = 1;  } else { $vrai = 0;  }
						 $this->ModeleMatiere->Ajouterreponse($max_id_question,$rep1, $vrai);
						 if($checkrep2=="on") { $vrai = 1;  } else { $vrai = 0;  }
						 $this->ModeleMatiere->Ajouterreponse($max_id_question,$rep2, $vrai);
						 if($checkrep3=="on") { $vrai = 1;  } else { $vrai = 0;  }
						 $this->ModeleMatiere->Ajouterreponse($max_id_question,$rep3, $vrai);
						 if($checkrep4=="on") { $vrai = 1;  } else { $vrai = 0;  }
						 $this->ModeleMatiere->Ajouterreponse($max_id_question,$rep4, $vrai);
					} else { //sans reponse vrais
						$data['erreur_check'] = "Cocher les vrais reponse";
						$this->load->view('Poulquestion',$data);
					}
					$this->load->view('Poulquestion',$data);
				} else {
					$this->load->view('Poulquestion',$data);
				}
			
			
			}
        }
		 public function ListPoulquestion(){
			$this->load->library('form_validation');
			$this->load->model('Modele_Matiere','ModeleMatiere');
			$data['matiere'] =  $this->ModeleMatiere->Selectrelation($this->session->userdata('id_enseignant'));
			
			
			$this->form_validation->set_rules('matiere','matiere','trim|required|alpha_dash|encode_php_tags');
			if($this->form_validation->run())
			{
				$matiere = $this->input->post('matiere');
				$data['listquestion'] =  $this->ModeleMatiere->Selectquestionmatiere($matiere);
				$this->load->view('Poulquestion',$data);
			} else {
				$this->load->view('Poulquestion',$data);
			}
		 }
		 public function Paramexamen(){  
            date_default_timezone_set('UTC');
           if($this->session->userdata('id_enseignant')==NULL) {
              $this->load->view('Accueil');
            } else {
				$this->load->library('form_validation');
				$this->load->model('Modele_Enseignant','ModeleEnseignant');
				$this->load->model('Modele_Matiere','ModeleMatiere');
				
				
				
				$this->form_validation->set_rules('nom_examen','nom examen','trim|required|alpha_dash|encode_php_tags');
				$this->form_validation->set_rules('nom_examen','nom examen','trim|required|is_unique[examen.nom_examen]|encode_php_tags',array('is_unique' => 'l\'examen existe deja'));
				$this->form_validation->set_rules('matiere','matiere','trim|required|alpha_dash|encode_php_tags');
				$this->form_validation->set_rules('date_debut','date debut','trim|required|encode_php_tags');
				$this->form_validation->set_rules('date_fin','date fin','trim|required|encode_php_tags');
				$this->form_validation->set_rules('duree_total','duree total','trim|required|encode_php_tags');
				$this->form_validation->set_rules('nb_question','nombre de question','trim|required|alpha_dash|encode_php_tags');
				
				
				if($this->form_validation->run())
				{
					$nom_examen = $this->input->post('nom_examen');
					$matiere = $this->input->post('matiere');
					$date_debut = $this->Setdate($this->input->post('date_debut')); //transformation de date
					$date_fin = $this->Setdate($this->input->post('date_fin')); //transformation de date
					$duree_total = $this->Settime($this->input->post('duree_total')); //transformation de date
					$nb_question = (int)$this->input->post('nb_question');
					
					if($nb_question==0) { //si nb question = 0
						$nb_question =1;
					}
					
					if(strtotime($date_debut)>=strtotime($date_fin)) { //si date debut inferieur ou egual a date fin
						echo $data['erreur'] = "date invalide";
					} else {
						$this->ModeleEnseignant->AjouterExamen($matiere,$nom_examen,$date_debut,$date_fin,$duree_total,$nb_question);
					}
					$data['matiere'] =  $this->ModeleMatiere->Selectrelation($this->session->userdata('id_enseignant'));
					$data['examen'] =  $this->ModeleEnseignant->Selectexamen();
					$this->load->view('Paramexamen',$data);
				} else {
					$data['matiere'] =  $this->ModeleMatiere->Selectrelation($this->session->userdata('id_enseignant'));
					$data['examen'] =  $this->ModeleEnseignant->Selectexamen();
					$this->load->view('Paramexamen',$data);
				}
				
			}
        }
		public function Modifsupr(){  
          
            if($this->session->userdata('id_enseignant')==NULL) {
              $this->load->view('Accueil');
            } else {
				
				$this->load->library('form_validation');
				$this->load->model('Modele_Enseignant','ModeleEnseignant');
				$this->load->model('Modele_Matiere','ModeleMatiere');
				$data['matiere'] =  $this->ModeleMatiere->Selectrelation($this->session->userdata('id_enseignant'));
				


				$this->form_validation->set_rules('id_examen','id_examen','trim|required|alpha_dash|encode_php_tags');
				$this->form_validation->set_rules('date_debut','date debut','trim|required|encode_php_tags');
				$this->form_validation->set_rules('date_fin','date fin','trim|required|encode_php_tags');
				$this->form_validation->set_rules('duree_total','duree total','trim|required|encode_php_tags');
				$this->form_validation->set_rules('nb_question','nombre de question','trim|required|alpha_dash|encode_php_tags');
				$this->form_validation->set_rules('btn','btn','trim|required|alpha_dash|encode_php_tags');
				if($this->form_validation->run())
				{
					$id_examen = $this->input->post('id_examen');
					$date_debut = $this->input->post('date_debut');
					$date_fin = $this->input->post('date_fin');
					$duree_total = $this->input->post('duree_total');
					$nb_question = $this->input->post('nb_question');
					$btn = $this->input->post('btn');
					if($btn=="modif")
					{
						$this->ModeleEnseignant->Setexamen($id_examen,$date_debut,$date_fin,$duree_total,$nb_question);
						
					}
					if($btn=="supr")
					{
						$this->ModeleEnseignant->Supprimeexamen($id_examen);
						
					}
					$data['examen'] =  $this->ModeleEnseignant->Selectexamen();
					$this->load->view('Paramexamen',$data);
				} else {
					$data['examen'] =  $this->ModeleEnseignant->Selectexamen();
					$this->load->view('Paramexamen',$data);
				}
			}
        }
		public function Resulexamen(){  
		
            if($this->session->userdata('id_enseignant')==NULL) {
              $this->load->view('Accueil');
            } else {
				$this->load->library('form_validation');
				$this->load->model('Modele_Enseignant','ModeleEnseignant');
				$data['examen'] =  $this->ModeleEnseignant->Selectexamenparenseignant($this->session->userdata('id_enseignant'));
				//echo count($data['examen']);
				
				
				$this->form_validation->set_rules('id_examen','id_examen','trim|required|alpha_dash|encode_php_tags');
				if($this->form_validation->run())
				{
					$id_examen = $this->input->post('id_examen');
					$data['exameninfo'] =  $this->ModeleEnseignant->Selectexamenwhere($id_examen);
					$data['resultat'] =  $this->ModeleEnseignant->Selectresultat($id_examen);
				
					$this->load->view('Resulexamen',$data);
				} else {
					$this->load->view('Resulexamen',$data);
				}
			}
        }
		
		public function Deconnexion() {
			 $this->session->sess_destroy();
			 $this->load->view('Accueil');
		}
    }

?>