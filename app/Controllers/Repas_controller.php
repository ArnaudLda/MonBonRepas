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
				
				$vide = false;
				foreach($_POST['mail'] as $invit) { 
					$check=array('mail'=>'Audit->email');
					$good=Datas::instance()->check($invit,$check);
					if(!$invit){
						$vide = true;
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
				
				$Mon_mail = F3::get('SESSION.mail');
				Repas::instance()->crea_repas($mails,$_POST['lat'],$_POST['lng'],$_POST['position'],$Mon_mail,$_POST['date']);
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
		switch(F3::get('VERB')) { // faire sauter le switch si ya pas de différence
			case 'GET':
				$Mon_mail=F3::get('SESSION.mail');
				$invit=Repas::instance()->get_liste_repas($Mon_mail);
				F3::set('repas',$invit);
				echo Views::instance()->render('Gest_Repas.html');
			break;
			case 'POST':
				$Mon_mail=F3::get('SESSION.mail');
				$invit=Repas::instance()->get_liste_repas($Mon_mail);
				F3::set('repas',$invit);
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
				$Mon_mail=F3::get('SESSION.mail');
				$id=$_GET["action"];
				$repas=Repas::instance()->get_repas($id);
				$crea=App::instance()->get_inscrit($repas->log_crea);
				F3::set('repas',$repas);
				F3::set('crea',$crea);
				echo Views::instance()->render('repas.html');
			break;
			case 'POST':
				echo Views::instance()->render('repas.html');
			break;
		}
	}
	
	/* Changement de status */
	
	function change_statut() {
		if(!F3::get('SESSION.id'))
			F3::reroute('/');
		switch(F3::get('VERB')) {
			case 'GET':
				$Mon_mail=F3::get('SESSION.mail');
				$id=$_GET["action"];
				$reponse=$_GET["rep"];
				$rep=Repas::instance()->modif_statut_repas($reponse,$id);
				$repas=Repas::instance()->get_repas($id);
				$crea=App::instance()->get_inscrit($Mon_mail);
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