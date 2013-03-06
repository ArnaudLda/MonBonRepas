<?php
class Repas_controller{
 
	function __construct(){

	}
	
	/* Création de repas */

	function crea_repas() {
		if(!F3::get('SESSION.id'))
			F3::reroute('/');
		switch(F3::get('VERB')) {
			case 'GET':
				$contacts = Repas::instance()->get_contact(F3::get('SESSION.id'));
				F3::set('contacts', $contacts);
				echo Views::instance()->render('Crea_Repas.html');
			break;
			case 'POST':
				$vide = true;
				foreach($_POST['mail'] as $invit) {
					$check=array('mail'=>'Audit->email','titre'=>'required','ds_calclass'=>'required');
					$good=Datas::instance()->check($invit,$check);
					if($invit == F3::get('SESSION.mail')) {
						$invit = '';
					}
					
					if($invit){
						$vide = false;
					}
				}
				if($vide && isset($_POST['contact'])){ 
					$mails = $_POST['contact'];
				}
				else if ($vide && !isset($_POST['contact'])) {
					$error="Aucun contact n'a été ajouté.";
					F3::set('error',$error);
					$contacts = Repas::instance()->get_contact(F3::get('SESSION.id'));
					F3::set('contacts', $contacts);
					echo Views::instance()->render('Crea_Repas.html');
					return;
				}
				else if(!$good) {
					$error="Adresse mail incorrecte.";
					F3::set('error',$error);
					$contacts = Repas::instance()->get_contact(F3::get('SESSION.id'));
					F3::set('contacts', $contacts);
					echo Views::instance()->render('Crea_Repas.html');
					return;
				}
				else if(!isset($_POST['contact'])){
					$mails = $_POST['mail'];
				}
				else {
					$mails = array_merge($_POST['mail'],$_POST['contact']);
				}
				
				$is_inscrit = array();
				$mail_list = array();
				
				foreach ($mails as $i => $mail) {
					$id_from_mail = Repas::instance()->mail_to_id($mail);
					
					if($id_from_mail) {
						$mail_list[$i] = $id_from_mail->id;
						$is_inscrit[$i] = 1;
					}
					else {
						$mail_list[$i] = $mail;
						$is_inscrit[$i] = 0;
					}
				}
				
				$my_id = F3::get('SESSION.id');
				Repas::instance()->crea_repas($mail_list,$_POST['lat'],$_POST['lng'],$_POST['position'],$my_id,$_POST['date'],$is_inscrit,$_POST['titre']);
				$contacts = Repas::instance()->get_contact(F3::get('SESSION.id'));
				F3::set('contacts', $contacts);
				echo Views::instance()->render('Crea_Repas.html');
			break;
		}
	}
	
	/* Gestion de repas */
 
	function gest_repas() {
		if(!F3::get('SESSION.id'))
			F3::reroute('/');
		switch(F3::get('VERB')) {
			case 'GET':
				$id=F3::get('SESSION.id');
				$invit=Repas::instance()->get_liste_repas($id);
				$crea = Repas::instance()->get_liste_repas_crea($id);
				
				$personne = array();
				foreach ($invit as $i => $item) {
					$personne[$i]=App::instance()->get_inscrit($item->log_crea);
				}
				if($personne){
					F3::set('repas',$invit);
					F3::set('contact',$personne);
				}
				F3::set('crea_repas',$crea);
				echo Views::instance()->render('Gest_Repas.html');
			break;
			case 'POST':
				echo Views::instance()->render('Gest_Repas.html');
			break;
		}
	}
	
	/* Repas */
	
	function repas() {
		if(!F3::get('SESSION.id'))
			F3::reroute('/');
		switch(F3::get('VERB')) {
			case 'GET':
				$id=$_GET["action"];
				$invit_list=Repas::instance()->get_full_repas($id);
				$my_id=F3::get('SESSION.id');
				$im_creator = false;
				$im_invited = false;
				foreach ($invit_list as $item) {
					if ($my_id == $item->log_invit) {
						$im_invited = true;
					}
					else if($my_id == $item->log_crea) {
						$im_creator = true;
					}
				}
				if ($im_creator) {
					$invit_gouts = array();
					$invit_infos = array();
					foreach ($invit_list as $i => $item) {
						if($item->is_inscrit) {
							$invit_infos[$i] = App::instance()->get_inscrit($item->log_invit);
							if ($item->statut == "accepter") {
								$invit_gouts[$i] = Repas::instance()->get_invit_gout($item->log_invit);
							}
						}
					}
					$invit_gouts = array_values($invit_gouts);
					
					$gouts_finaux = array();
					foreach ($invit_gouts as $invit_gout) {
						foreach ($invit_gout as $i => $gout) {
							$gouts_finaux[$i] = 'on';
						}
					}
					
					F3::set('invit_list', $invit_list);
					F3::set('invit_infos',$invit_infos);
					F3::set('gout',$gouts_finaux);
					$aliments=Profil::instance()->get_aliment();
					F3::set('aliments',$aliments);
					echo Views::instance()->render('repas_crea.html');
				}
				else if($im_invited) {
					$crea=App::instance()->get_inscrit($invit_list[0]->log_crea);
					F3::set('repas',$invit_list[0]);
					F3::set('crea',$crea);
					echo Views::instance()->render('repas_invit.html');
				}
				else {
					F3::reroute('/gest_repas');
				}
			break;
			case 'POST':
				$modif_repas = Repas::instance()->modif_repas($_POST['lat'], $_POST['lng'], $_POST['Lib_lieu'], $_POST['date'], $_POST['id_repas'] );
				$invit_list=Repas::instance()->get_full_repas($_POST['id_repas']);
				// Affichage
				$invit_gouts = array();
				$invit_infos = array();
				foreach ($invit_list as $i => $item) {
					if($item->is_inscrit) {
						$invit_infos[$i] = App::instance()->get_inscrit($item->log_invit);
						if ($item->statut == "accepter") {
							$invit_gouts[$i] = Repas::instance()->get_invit_gout($item->log_invit);
						}
					}
				}
				$invit_gouts = array_values($invit_gouts);
				
				$gouts_finaux = array();
				foreach ($invit_gouts as $invit_gout) {
					foreach ($invit_gout as $i => $gout) {
						$gouts_finaux[$i] = 'on';
					}
				}
				
				F3::set('invit_list', $invit_list);
				F3::set('invit_infos',$invit_infos);
				F3::set('gout',$gouts_finaux);
				$aliments=Profil::instance()->get_aliment();
				F3::set('aliments',$aliments);
				echo Views::instance()->render('repas_crea.html');
			break;
		}
	}
	
	/* Supprimer une invitation */
	
	function supp_invit(){
		if(!F3::get('SESSION.id'))
			F3::reroute('/');
			
		$id_repas=$_GET["id_repas"];
		$id_invit=$_GET["id_invit"];
		
		Repas::instance()->supp_invit($id_repas, $id_invit);
		F3::reroute("/repas?action=$id_repas");
	}
	
	/* Supprimer un repas */
	
	function supp_repas(){
		if(!F3::get('SESSION.id'))
			F3::reroute('/');
			
		$id_repas=$_GET["id_repas"];
		
		$repas = Repas::instance()->get_full_repas($id_repas);
		foreach($repas as $item){
			Repas::instance()->supp_invit($id_repas, $item->log_invit);
		}
		F3::reroute("/gest_repas");
	}
	
	/* Changement de status */
	
	function change_statut() {
		if(!F3::get('SESSION.id'))
			F3::reroute('/');
		switch(F3::get('VERB')) {
			case 'GET':
				$My_id=F3::get('SESSION.id');
				$id=$_GET["action"];
				$reponse=$_GET["rep"];
				$rep=Repas::instance()->modif_statut_repas($reponse,$id);
				$repas=Repas::instance()->get_repas($id);
				$crea=App::instance()->get_inscrit($My_id);
				F3::set('repas',$repas);
				F3::set('crea',$crea);
				echo Views::instance()->render('repas.html');
			break;
			case 'POST':
				echo Views::instance()->render('repas.html');
			break;
		}
	}
	
	function __destruct(){

	} 
}
?>