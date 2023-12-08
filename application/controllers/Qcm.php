<?php

    class Qcm extends CI_Controller {

        public function __construct() {
			parent:: __construct();
			$this->titre_defaut = 'Mon super site';
			$this->load->helper(array('form', 'url'));
			$this->load->library('session');
        }
		public function getheur() {
			date_default_timezone_set('UTC');
			$heursys = date("H:i:s");
			$heursys = date("H:i:s", strtotime("+3 HOUR", strtotime($heursys))); //heur exacte
			return $heursys;
		}
		public function getdate() {
			date_default_timezone_set('UTC');
			$datesys = date("Y-m-d H:i:s");
			
			
			return $datesys;
		}
        public function index(){ 
			date_default_timezone_set('UTC');
			if($this->session->userdata('id_etudiant')==NULL) {
				$this->load->view('Accueil');
				if($this->session->userdata('id_examen')==NULL) {
					$this->load->view('Etudiant');
				}
            } else {
				$this->load->library('form_validation');
				$this->load->model('Modele_Qcm','ModeleQcm');	
				$this->form_validation->set_rules('id_examen','id_examen','trim|required|alpha_dash|encode_php_tags');
				if($this->form_validation->run())
				{
					$heursys = $this->getheur();
					$id_examen = $this->input->post('id_examen');
					
					$where_id_examen = array("id_examen"=>$id_examen);
					$donnee_examen =  $this->ModeleQcm->SelectWhereExamen($where_id_examen);
					foreach($donnee_examen as $list) { 
						$id_matiere = $list->id_matiere;
						$date_debut = $list->date_debut;
						$date_fin = $list->date_fin;
					}
					$timestamp = time() + (180*60);
					$datesys = date("Y-m-d H:i:s",$timestamp);
					if(strtotime($datesys)>strtotime($date_debut) && strtotime($datesys)<strtotime($date_fin)) //si la date correspond
					{
						$this->session->set_userdata('id_examen', $id_examen); 
						$okok = "ok"; //heur de l'examen
						$donnee_question =  $this->ModeleQcm->Selectquestion($id_matiere);//prendre question au hasard de la matiere
						$point=1;
						foreach($donnee_question as $list) { 
							$id_question = $list->id_question;
							$point = $list->point_negatif;
						}
						$this->ModeleQcm->AjouterQuestion($this->session->userdata('id_etudiant'),$id_question,$id_examen,0,$heursys);//ajouter question dans passer question
						$data['passer_examen'] =$this->ModeleQcm->Selectpasserexanen($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen'));
						
						$donnee_pass =$this->ModeleQcm->Selectpasserexanen($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen'));
						foreach($donnee_pass as $list) { 
							$list->id_question;
						}
						
						$passer_examen =$data['passer_examen'];
						foreach($passer_examen as $list) { 
							$id_question = $list->id_question;
						}
						$where = array("id_question"=>$id_question);
						$data['choix_reponse'] =  $this->ModeleQcm->Selectreponse($where);
						//echo count($data['choix_reponse']);
						foreach($data['choix_reponse'] as $list) { 
							$list->reponse;
						}
						
						$data['nb_question'] = $this->getnbquestion($this->session->userdata('id_examen')); //nombre de question de l'examen
						$data['nb_reponse'] = $this->getnbreponse($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen')); //nombre de question deja poser
						
						
						//verification de l'heur
						$question =$this->ModeleQcm->Selectexamen($this->session->userdata('id_examen'));
						foreach($question as $list) { 
							$duree_total = $list->duree_total; //durree de l'examen
							$heur_total = $list->duree_total; 
						}
						$donnee_first =$this->ModeleQcm->Selectpasserexanenasc($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen'));
						foreach($donnee_first as $list) { 
							$heur_first = $list->heur_ajout; //heur apparition de la premier question
						}
						$heursys = $this->getheur(); //heur actuel
						$nowfirstmilli = strtotime($heursys) - strtotime($heur_first); ////temps passer maintenant au premier question
						
						$heur_rest = strtotime($heur_total) - $nowfirstmilli; //temps qui reste en millisecond
						$heur_rest = date("H:i:s",$heur_rest);
						$date_parse = date_parse($heur_rest);
						$data['hour'] = $date_parse['hour'];
						$data['minute'] = $date_parse['minute'];
						$data['second'] = $date_parse['second'];
						//verification de l'heur
						
						$this->load->view('Qcm',$data);
							
					} else {
						
						  //redirect(base_url().'Etudiant/Examen');
					
						  if($this->session->userdata('id_etudiant')==NULL) {
						  $this->load->view('Accueil');
						} else {
							$this->load->model('Modele_Enseignant','ModeleEnseignant');
							//les examen deja fait ne s'affiche pas
							$data['erreur_date']="l'examen n'est pas encore disponible";
							$data['examen'] =  $this->ModeleEnseignant->Selectexamenpaspasser($this->session->userdata('id_etudiant'));
							$this->load->view('Examen',$data);
						}
					}
					
				} else {
					$data['passer_examen'] =$this->ModeleQcm->Selectpasserexanen($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen'));
					$passer_examen =$data['passer_examen'];
					foreach($passer_examen as $list) { 
						$id_question = $list->id_question; //id_question de la derniere question
					}
					$where = array("id_question"=>$id_question);
					$data['choix_reponse'] =  $this->ModeleQcm->Selectreponse($where);//reponse de la derniere question
					//echo count($data['choix_reponse']);
					foreach($data['choix_reponse'] as $list) { 
						$list->reponse;
					}
					$data['nb_question'] = $this->getnbquestion($this->session->userdata('id_examen')); //nombre de question de l'examen
					$data['nb_reponse'] = $this->getnbreponse($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen')); //nombre de question deja poser
					
					//verification de l'heur
					$question =$this->ModeleQcm->Selectexamen($this->session->userdata('id_examen'));
					foreach($question as $list) { 
						$duree_total = $list->duree_total; //durree de l'examen
						$heur_total = $list->duree_total; 
					}
					$donnee_first =$this->ModeleQcm->Selectpasserexanenasc($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen'));
					foreach($donnee_first as $list) { 
						$heur_first = $list->heur_ajout; //heur apparition de la premier question
					}
					$heursys = $this->getheur(); //heur actuel
					$nowfirstmilli = strtotime($heursys) - strtotime($heur_first); ////temps passer maintenant au dernier question
					
					$heur_rest = strtotime($heur_total) - $nowfirstmilli; //temps qui reste en millisecond
					$heur_rest = date("H:i:s",$heur_rest);
					$date_parse = date_parse($heur_rest);
					$data['hour'] = $date_parse['hour'];
					$data['minute'] = $date_parse['minute'];
					$data['second'] = $date_parse['second'];
					
					$duree_total = new DateTime($duree_total);
					
					$duree_datezero = new DateTime('00:00:00');
					
					
					$duree = strtotime($duree_total->format('H:i:s'))-strtotime($duree_datezero->format('H:i:s')); //duree examen
					if($nowfirstmilli<$duree) {
					
					} else {
						//calcul de resultat
						$this->calculresultat();
					}
					//verification de l'heur
					
					$this->load->view('Qcm',$data);
				}
			}
        }
		//FONCTION
		public function getnbquestion($id_examen) { //nombre de question de l'examen
			$this->load->model('Modele_Qcm','ModeleQcm');	
			$question =$this->ModeleQcm->Selectexamen($id_examen);
			foreach($question as $list) { 
				$nb_question = $list->nb_question;
			}
			return $nb_question;
		}
		public function getnbreponse($id_etudiant,$id_examen) {//nombre de question deja posser
			$this->load->model('Modele_Qcm','id_examen');	
			$question =$this->ModeleQcm->Selectallpasserexanen($id_etudiant,$id_examen);
			$nb_reponse = count($question);
			return $nb_reponse;
		}
		//FONCTION
		 public function reponse(){ 
           date_default_timezone_set('UTC');
			if($this->session->userdata('id_etudiant')==NULL) {
				$this->load->view('Accueil');
				if($this->session->userdata('id_examen')==NULL) {
					$this->load->view('Etudiant');
				}
            } else {
				$this->load->library('form_validation');
				$this->load->model('Modele_Qcm','ModeleQcm');	
				$this->form_validation->set_rules('id_choix_reponse1','id_choix_reponse1','trim|required|alpha_dash|encode_php_tags');
				//echo 1;
				
				if($this->form_validation->run())
				{
					
					$id_choix_reponse1 = $this->input->post('id_choix_reponse1');
					$id_choix_reponse2 = $this->input->post('id_choix_reponse2');
					$id_choix_reponse3 = $this->input->post('id_choix_reponse3');
					$id_choix_reponse4 = $this->input->post('id_choix_reponse4');
					
					$checkrep1 = $this->input->post('checkrep1');
					$checkrep2 = $this->input->post('checkrep2');
					$checkrep3 = $this->input->post('checkrep3');
					$checkrep4 = $this->input->post('checkrep4');
					if(($checkrep1=="on" && $checkrep2=="on" && $checkrep3=="on" && $checkrep4=="on") or ($checkrep1=="on" && $checkrep2=="on" && $checkrep3=="on") or ($checkrep1=="on" && $checkrep2=="on" && $checkrep4=="on") or ($checkrep1=="on" && $checkrep3=="on" && $checkrep4=="on") or ($checkrep2=="on" && $checkrep3=="on" && $checkrep4=="on")) {
						//choix incorecte
						//echo "0";
					} else { //choix correcte 1 ou 2 choix
						$data['passer_examen'] =$this->ModeleQcm->Selectpasserexanen($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen'));
						foreach($data['passer_examen'] as $list) { 
							$id_question = $list->id_question;
						}
						$where = array("id_question"=>$id_question);
						$data['choix_reponse'] =  $this->ModeleQcm->Selectreponsevrai($where);
						$vrai =  count($data['choix_reponse']); //nombre de question vrais
						if($vrai==1) { //1 reponse vrai
							$where = array("id_choix_reponse"=>$id_choix_reponse1);
							$data['reponseid'] =  $this->ModeleQcm->Selectreponseid($where);
							foreach($data['reponseid'] as $list) { 
								$repvrai = $list->vrais;
								if($repvrai==1 && $checkrep1=="on") {
									///UPDATE POINT
									$passexamen =$this->ModeleQcm->Selectpasserexanen($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen')); //dernier question posser
									foreach($passexamen as $list) { 
										$id_passer_examen = $list->id_passer_examen; //id de la dernier question posser par id_etudiant
										$id_question = $list->id_question;
									}
									$question =$this->ModeleQcm->Selectquestionid($id_question);
									foreach($passexamen as $list) { 
										$pointquestion = $list->point_negatif; //point de la question
									}
									$this->ModeleQcm->Setpoint($id_passer_examen,$pointquestion);//update point de la question posser
									//UPDATE POINT
								}
							}
							$where = array("id_choix_reponse"=>$id_choix_reponse2);
							$data['reponseid'] =  $this->ModeleQcm->Selectreponseid($where);
							foreach($data['reponseid'] as $list) { 
								$repvrai = $list->vrais;
								if($repvrai==1 && $checkrep2=="on") {
									//UPDATE POINT
									$passexamen =$this->ModeleQcm->Selectpasserexanen($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen')); //dernier question posser
									foreach($passexamen as $list) { 
										$id_passer_examen = $list->id_passer_examen; //id de la dernier question posser par id_etudiant
										$id_question = $list->id_question;
									}
									$question =$this->ModeleQcm->Selectquestionid($id_question);
									foreach($passexamen as $list) { 
										$pointquestion = $list->point_negatif; //point de la question
									}
									$this->ModeleQcm->Setpoint($id_passer_examen,$pointquestion);//update point de la question posser
									//UPDATE POINT
								}
							}
							$where = array("id_choix_reponse"=>$id_choix_reponse3);
							$data['reponseid'] =  $this->ModeleQcm->Selectreponseid($where);
							foreach($data['reponseid'] as $list) { 
								$repvrai = $list->vrais;
								if($repvrai==1 && $checkrep3=="on") {
									///UPDATE POINT
									$passexamen =$this->ModeleQcm->Selectpasserexanen($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen')); //dernier question posser
									foreach($passexamen as $list) { 
										$id_passer_examen = $list->id_passer_examen; //id de la dernier question posser par id_etudiant
										$id_question = $list->id_question;
									}
									$question =$this->ModeleQcm->Selectquestionid($id_question);
									foreach($passexamen as $list) { 
										$pointquestion = $list->point_negatif; //point de la question
									}
									$this->ModeleQcm->Setpoint($id_passer_examen,$pointquestion);//update point de la question posser
									//UPDATE POINT
								}
							}
							$where = array("id_choix_reponse"=>$id_choix_reponse4);
							$data['reponseid'] =  $this->ModeleQcm->Selectreponseid($where);
							foreach($data['reponseid'] as $list) { 
								$repvrai = $list->vrais;
								if($repvrai==1 && $checkrep4=="on") {
									//echo "vrai";
									///UPDATE POINT
									$passexamen =$this->ModeleQcm->Selectpasserexanen($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen')); //dernier question posser
									foreach($passexamen as $list) { 
										$id_passer_examen = $list->id_passer_examen; //id de la dernier question posser par id_etudiant
										$id_question = $list->id_question;
									}
									$question =$this->ModeleQcm->Selectquestionid($id_question);
									foreach($passexamen as $list) { 
										$pointquestion = $list->point_negatif; //point de la question
									}
									$this->ModeleQcm->Setpoint($id_passer_examen,$pointquestion);//update point de la question posser
									//UPDATE POINT
								}
							}
						} if($vrai==2) { // 2  reponse vrais
							$where = array("id_choix_reponse"=>$id_choix_reponse1);
							$data['reponseid'] =  $this->ModeleQcm->Selectreponseid($where);
							foreach($data['reponseid'] as $list) { 
								$repvrai = $list->vrais;
								if($repvrai==1 && $checkrep1=="on") {
									///UPDATE POINT
									$passexamen =$this->ModeleQcm->Selectpasserexanen($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen')); //dernier question posser
									foreach($passexamen as $list) { 
										$id_passer_examen = $list->id_passer_examen; //id de la dernier question posser par id_etudiant
										$id_question = $list->id_question;
									}
									$question =$this->ModeleQcm->Selectquestionid($id_question);
									foreach($passexamen as $list) { 
										$pointquestion = $list->point_negatif; //point de la question
									}
									$pointquestion = $pointquestion/2;
									$this->ModeleQcm->Setpoint($id_passer_examen,$pointquestion);//update point de la question posser
									//UPDATE POINT
								}
							}
							$where = array("id_choix_reponse"=>$id_choix_reponse2);
							$data['reponseid'] =  $this->ModeleQcm->Selectreponseid($where);
							foreach($data['reponseid'] as $list) { 
								$repvrai = $list->vrais;
								if($repvrai==1 && $checkrep2=="on") {
									//UPDATE POINT
									$passexamen =$this->ModeleQcm->Selectpasserexanen($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen')); //dernier question posser
									foreach($passexamen as $list) { 
										$id_passer_examen = $list->id_passer_examen; //id de la dernier question posser par id_etudiant
										$id_question = $list->id_question;
									}
									$question =$this->ModeleQcm->Selectquestionid($id_question);
									foreach($passexamen as $list) { 
										$pointquestion = $list->point_negatif; //point de la question
									}
									$pointquestion = $pointquestion/2;
									$this->ModeleQcm->Setpoint($id_passer_examen,$pointquestion);//update point de la question posser
									//UPDATE POINT
								}
							}
							$where = array("id_choix_reponse"=>$id_choix_reponse3);
							$data['reponseid'] =  $this->ModeleQcm->Selectreponseid($where);
							foreach($data['reponseid'] as $list) { 
								$repvrai = $list->vrais;
								if($repvrai==1 && $checkrep3=="on") {
									///UPDATE POINT
									$passexamen =$this->ModeleQcm->Selectpasserexanen($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen')); //dernier question posser
									foreach($passexamen as $list) { 
										$id_passer_examen = $list->id_passer_examen; //id de la dernier question posser par id_etudiant
										$id_question = $list->id_question;
									}
									$question =$this->ModeleQcm->Selectquestionid($id_question);
									foreach($passexamen as $list) { 
										$pointquestion = $list->point_negatif; //point de la question
									}
									$pointquestion = $pointquestion/2;
									$this->ModeleQcm->Setpoint($id_passer_examen,$pointquestion);//update point de la question posser
									//UPDATE POINT
								}
							}
							$where = array("id_choix_reponse"=>$id_choix_reponse4);
							$data['reponseid'] =  $this->ModeleQcm->Selectreponseid($where);
							foreach($data['reponseid'] as $list) { 
								$repvrai = $list->vrais;
								if($repvrai==1 && $checkrep4=="on") {
									//echo "vrai";
									///UPDATE POINT
									$passexamen =$this->ModeleQcm->Selectpasserexanen($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen')); //dernier question posser
									foreach($passexamen as $list) { 
										$id_passer_examen = $list->id_passer_examen; //id de la dernier question posser par id_etudiant
										$id_question = $list->id_question;
									}
									$question =$this->ModeleQcm->Selectquestionid($id_question);
									foreach($passexamen as $list) { 
										$pointquestion = $list->point_negatif; //point de la question
									}
									$pointquestion = $pointquestion/2;
									$this->ModeleQcm->Setpoint($id_passer_examen,$pointquestion);//update point de la question posser
									//UPDATE POINT
								}
							}
						
						}
					
						
					}
					
					$this->nextquestion();
				} else {
				
					//verification de l'heur
					$question =$this->ModeleQcm->Selectexamen($this->session->userdata('id_examen'));
					foreach($question as $list) { 
						$duree_total = $list->duree_total; //durree de l'examen
						$heur_total = $list->duree_total; 
					}
					$donnee_first =$this->ModeleQcm->Selectpasserexanenasc($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen'));
					foreach($donnee_first as $list) { 
						$heur_first = $list->heur_ajout; //heur apparition de la premier question
					}
					$heursys = $this->getheur(); //heur actuel
					$nowfirstmilli = strtotime($heursys) - strtotime($heur_first); ////temps passer maintenant au dernier question
					
					$heur_rest = strtotime($heur_total) - $nowfirstmilli; //temps qui reste en millisecond
					$heur_rest = date("H:i:s",$heur_rest);
					$date_parse = date_parse($heur_rest);
					$data['hour'] = $date_parse['hour'];
					$data['minute'] = $date_parse['minute'];
					$data['second'] = $date_parse['second'];
					
					$duree_total = new DateTime($duree_total);
					
					$duree_datezero = new DateTime('00:00:00');
					
					
					$duree = strtotime($duree_total->format('H:i:s'))-strtotime($duree_datezero->format('H:i:s')); //duree examen
					if($nowfirstmilli<$duree) {
						//passer question suivant
						$donnee_last =$this->ModeleQcm->Selectpasserexanen($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen'));
						foreach($donnee_last as $list) { 
							$heur_last = $list->heur_ajout; //heur apparition de la dernier question
						}
						$heur_lastfirst = strtotime($heur_last) - strtotime($heur_first); //temps passer du premier au dernier question
						$heur_rest = strtotime($heur_total) - $heur_lastfirst; //temps qui reste en millisecond
						$heur_rest = date("H:i:s",$heur_rest); //temps qui reste en h:m:s
						
						//$date_parse = date_parse($heur_rest);
						//$data['hour'] = $date_parse['hour'];
						//$data['minute'] = $date_parse['minute'];
						//$data['second'] = $date_parse['second'];
					} else {
						//calcul de resultat
						$this->calculresultat();
					}
					//verification de l'heur
					
				
				
					$data['passer_examen'] =$this->ModeleQcm->Selectpasserexanen($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen'));
					$passer_examen =$data['passer_examen'];
					foreach($passer_examen as $list) { 
						$id_question = $list->id_question;
					}
					$where = array("id_question"=>$id_question);
					$data['choix_reponse'] =  $this->ModeleQcm->Selectreponse($where);
					//echo count($data['choix_reponse']);
					foreach($data['choix_reponse'] as $list) { 
						$list->reponse;
					}
					$data['nb_question'] = $this->getnbquestion($this->session->userdata('id_examen')); //nombre de question de l'examen
					$data['nb_reponse'] = $this->getnbreponse($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen')); //nombre de question deja poser
					
					$this->load->view('Qcm',$data);
				}
			}
		}
		public function calculresultat() { //calcul point et insertion dans resultat
			$this->load->model('Modele_Qcm','ModeleQcm');
			$this->load->model('Modele_Etudiant','ModeleEtudiant');
			$id_etudiant = $this->session->userdata('id_etudiant');//idetudiant
			$id_examen = $this->session->userdata('id_examen');//id_examen

			$data['result_total'] =  $this->ModeleQcm->Selectcountnote($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen'));
			foreach($data['result_total'] as $list) { 
				$nbquestion_pose = $list->nbquestion_pose; //nombre de question posser
				$nb_question = $list->nb_question;//nombre de question de l'examen
				$sumpoint = $list->sumpoint; //total point des question
				$sumpoint_negatif = $list->sumpoint_negatif; //total point des question repondu
			}
			
			$moyennecoef = $sumpoint_negatif/$nbquestion_pose; //moyenne point question posser
			$question_rest =$nb_question-$nbquestion_pose;//reste question non repondu
			$point_perdu = $question_rest*$moyennecoef;
			$sumpoint_negatif = $sumpoint_negatif + $point_perdu;//total point
			
			$notevinght = $sumpoint*20/$sumpoint_negatif;//notevinght
			$data['etudiant'] = $this->ModeleEtudiant->SelectWhere(array("id_etudiant"=>$id_etudiant));
			foreach($data['etudiant'] as $list) { 
				$nom_etudiant = $list->nom;
				$prenom_etudiant = $list->prenom;
			}
			
			$data['examen'] = $this->ModeleQcm->SelectWhereExamenMatiere($id_examen);
			foreach($data['examen'] as $list) { 
				$nom_examen = $list->nom_examen;//nomexamen
				$nom_matiere = $list->nom_matiere;//nommatiere
			}
			//verification si resultat existe dejat
			$data['resultat'] = $this->ModeleQcm->SelectWhereResultat(array("id_etudiant"=>$id_etudiant,"id_examen"=>$id_examen));
			$nb_resultat = count($data['resultat']);
			if($nb_resultat==0) {
				$this->ModeleQcm->AjouterResultat($id_etudiant,$id_examen,$nom_etudiant,$prenom_etudiant,$nom_examen,$nom_matiere,$notevinght); //insertion dans resultat
			}
			
			redirect(base_url().'Etudiant/Note');
		}
		public function nextquestion() {
			date_default_timezone_set('UTC');
			if($this->session->userdata('id_etudiant')==NULL) {
				$this->load->view('Accueil');
				if($this->session->userdata('id_examen')==NULL) {
					$this->load->view('Etudiant');
				}
            } else {
				$this->load->model('Modele_Qcm','ModeleQcm');
				$heursys = date("H:i:s");
				$heursys = date("H:i:s", strtotime("+3 HOUR", strtotime($heursys))); //heur exacte
				$data['nb_question'] = $this->getnbquestion($this->session->userdata('id_examen')); //nombre de question de l'examen
				$data['nb_reponse'] = $this->getnbreponse($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen')); //nombre de question deja poser
				if($data['nb_reponse']<$data['nb_question']) {
				
					//verification de l'heur
					$question =$this->ModeleQcm->Selectexamen($this->session->userdata('id_examen'));
					foreach($question as $list) { 
						$duree_total = $list->duree_total; //durree de l'examen
						$heur_total = $list->duree_total; 
					}
					$donnee_first =$this->ModeleQcm->Selectpasserexanenasc($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen'));
					foreach($donnee_first as $list) { 
						$heur_first = $list->heur_ajout; //heur apparition de la premier question
					}
					$heursys = $this->getheur(); //heur actuel
					$nowfirstmilli = strtotime($heursys) - strtotime($heur_first); ////temps passer maintenant au dernier question
					
					$heur_rest = strtotime($heur_total) - $nowfirstmilli; //temps qui reste en millisecond
					$heur_rest = date("H:i:s",$heur_rest);
					$date_parse = date_parse($heur_rest);
					$data['hour'] = $date_parse['hour'];
					$data['minute'] = $date_parse['minute'];
					$data['second'] = $date_parse['second'];
					
					$duree_total = new DateTime($duree_total);
					
					$duree_datezero = new DateTime('00:00:00');
					
					
					$duree = strtotime($duree_total->format('H:i:s'))-strtotime($duree_datezero->format('H:i:s')); //duree examen
					if($nowfirstmilli<$duree) {
					
					
							$id_examen = $this->session->userdata('id_examen');
							$where_id_examen = array("id_examen"=>$id_examen);
							$donnee_examen =  $this->ModeleQcm->SelectWhereExamen($where_id_examen);
							foreach($donnee_examen as $list) { 
								$id_matiere = $list->id_matiere; //prender l'id_matiere de l'examen
							}
							$donnee_question =  $this->ModeleQcm->Selectquestionnotin($this->session->userdata('id_etudiant'),$id_matiere);//prendre question au hasard de la matiere
							$point=1;
							foreach($donnee_question as $list) { 
								$id_question = $list->id_question;
								$point = $list->point_negatif;
							}
							//ajout question dans passe_examen
							$this->ModeleQcm->AjouterQuestion($this->session->userdata('id_etudiant'),$id_question,$id_examen,0,$heursys);//ajouter question hasard different de l'existant dans passer question
							$data['passer_examen'] =$this->ModeleQcm->Selectpasserexanen($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen')); //prendre la derniere question
							
							$donnee_pass =$this->ModeleQcm->Selectpasserexanen($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen'));
							foreach($donnee_pass as $list) { 
								$list->id_question;
							}
							//ajout question dans passe_examen
							$passer_examen =$data['passer_examen'];
							foreach($passer_examen as $list) { 
								$id_question = $list->id_question;
							}
							$where = array("id_question"=>$id_question);
							$data['choix_reponse'] =  $this->ModeleQcm->Selectreponse($where); //les reponse de la derniere question
							//echo count($data['choix_reponse']);
							foreach($data['choix_reponse'] as $list) { 
								$list->reponse;
							}
							$data['nb_question'] = $this->getnbquestion($this->session->userdata('id_examen')); //nombre de question de l'examen
							$data['nb_reponse'] = $this->getnbreponse($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen')); //nombre de question deja poser
							

						//passer question suivant
						$donnee_last =$this->ModeleQcm->Selectpasserexanen($this->session->userdata('id_etudiant'),$this->session->userdata('id_examen'));
						foreach($donnee_last as $list) { 
							$heur_last = $list->heur_ajout; //heur apparition de la dernier question
						}
						$heur_lastfirst = strtotime($heur_last) - strtotime($heur_first); //temps passer du premier au dernier question
						$heur_rest = strtotime($heur_total) - $heur_lastfirst; //temps qui reste en millisecond
						$heur_rest = date("H:i:s",$heur_rest); //temps qui reste en h:m:s
						
						$date_parse = date_parse($heur_rest);
						$data['hour'] = $date_parse['hour'];
						$data['minute'] = $date_parse['minute'];
						$data['second'] = $date_parse['second'];
						
						$this->load->view('Qcm',$data);
					} else {
						//calcul de resultat
						$this->calculresultat();
					}
					//verification de l'heur
					
					
					
				} else {
					$this->calculresultat();
				}
			}
		}
    }
?>