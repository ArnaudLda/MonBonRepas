<?php
class App_controller{

	function __construct(){

	}
	
	/* Déconnexion */
	
	function logout() {
		session_start();
		session_destroy();
		F3::reroute('/');
	}
	
	/* Direction vers la homepage */
	
	function home() {
		echo Views::instance()->render('home.html');
	}
	
	/* Connexion */
  
	function connexion() {
		switch(F3::get('VERB')) {
			case 'GET':
				echo Views::instance()->render('connexion.html');
			break;
			case 'POST':
				$check=array('mail'=>'required,Audit->email','passwd'=>'required');
				$error=Datas::instance()->check(F3::get('POST'),$check);
				if($error) {
					F3::set('errorMsg',$error);
					echo Views::instance()->render('connexion.html');
					return;
				}
				$connect=App::instance()->connect($_POST['mail'],$_POST['passwd']);
				if(!$connect) {
					F3::set('errorMsg',$error);
					echo Views::instance()->render('connexion.html');
					return;
				}
				F3::set('SESSION.mail',$_POST['mail']);
				F3::set('SESSION.id', $connect->id);
				F3::reroute('/dashboard');
			break;
		}
	}
	
	/* Inscription */
	
	function inscription() {
		switch(F3::get('VERB')) {
			case 'GET':
				echo Views::instance()->render('inscription.html');
			break;
			case 'POST':
				$check=array('prenom'=>'required','nom'=>'required','mail'=>'required,Audit->email','passwd'=>'required');
				$error=Datas::instance()->check(F3::get('POST'),$check);
				if($error) {
					F3::set('errorMsg',$error);
					echo Views::instance()->render('inscription.html');
					return;
				}
				$test=App::instance()->create($_POST['mail']);
				if($test) {
					$error="error";
					F3::set('errorMsg["mail"]',$error);
					echo Views::instance()->render('inscription.html');
					return;
				}
				else {
					// modifier la table repas ici
					F3::reroute('/connexion');
				}
			break;
		}
	}
	
	/* Dashboard */
	
	function dashboard() {
		if(!F3::get('SESSION.id'))
			F3::reroute('/');
		switch(F3::get('VERB')) {
			case 'GET':
				$id=F3::get('SESSION.id'); // USE ID
				$flux=Repas::instance()->flux_repas($id); // USE ID
				if($flux) {
					foreach($flux as $i => $fluxx)
					{
						$infos[$i]=App::instance()->get_inscrit($fluxx->log_invit);
					}
					
					F3::set('flux',$flux);
					F3::set('infos',$infos);
					echo Views::instance()->render('Dashboard.html');
				}
				else {
					echo Views::instance()->render('Dashboard.html');
				}
			break;
			case 'POST':
					echo Views::instance()->render('Dashboard.html');
			break;
		}  
	}
	
	function __destruct(){

	} 
}
?>