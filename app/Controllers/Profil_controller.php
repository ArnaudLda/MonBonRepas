<?php
class Profil_controller{
 
	function __construct(){

	}
	
	function profil() {
		switch(F3::get('VERB')) {
			case 'GET':
				$session_id=F3::get('SESSION.id');
				$profil=Profil::instance()->get_profil($session_id);
				F3::set('profil',$profil);
				$gout = unserialize($profil->gout);
				F3::set('gout',$gout);

				$aliments=Profil::instance()->get_aliment();
				F3::set('aliments',$aliments);

				echo Views::instance()->render('Profil.html');
			break;
			case 'POST':
				$session_id=F3::get('SESSION.id');
				$profil=Profil::instance()->get_profil($session_id);
				F3::set('profil',$profil);
				$gout = unserialize($profil->gout);
				F3::set('gout',$gout);

				$aliments=Profil::instance()->get_aliment();
				F3::set('aliments',$aliments);

				echo Views::instance()->render('Profil.html');
			break;
		}
	}
	
	function info() {
		switch(F3::get('VERB')) {
			case 'GET':
				F3::reroute('/Profil');
			break;
			case 'POST':
				$check=array('nom'=>'required','prenom'=>'required','mail'=>'required,Audit->email');
				$error=Datas::instance()->check(F3::get('POST'),$check);
				if($error) {
					F3::set('errorInfo',$error);
					F3::reroute('/Profil');
					return;
				}
				$session_id=F3::get('SESSION.id');
				$profil = Profil::instance()->modif_info($session_id,$_POST['nom'],$_POST['prenom'],$_POST['mail']);
				if (!$profil) {
					F3::set('errorInfo',$error);
				}
				F3::reroute('/Profil');
			break;
		}
	}
	
	function pswd() {
		switch(F3::get('VERB')) {
			case 'GET':
				F3::reroute('/Profil');
			break;
			case 'POST':
				$check=array('old_pswd'=>'required','new_pswd'=>'required','new_pswd_bis'=>'required');
				$error=Datas::instance()->check(F3::get('POST'),$check);
				if($error) {
					F3::set('errorInfo',$error);
					F3::reroute('/Profil');
					return;
				}
				$session_id=F3::get('SESSION.id');
				$profil = Profil::instance()->modif_pswd($session_id,$_POST['old_pswd'],$_POST['new_pswd'],$_POST['new_pswd_bis']);
				if (!$profil) {
					F3::set('errorInfo',$error);
				}
				F3::reroute('/Profil');
			break;
		}
	}
	
	function gout() {
		switch(F3::get('VERB')) {
			case 'GET':
				F3::reroute('/Profil');
			break;
			case 'POST':
				$session_id=F3::get('SESSION.id');
				$profil = Profil::instance()->modif_gout($session_id);
				if (!$profil) {
					F3::set('errorInfo',$error);
				}
				F3::reroute('/Profil');
			break;
		}
	}
	
	function __destruct(){

	} 
}
?>