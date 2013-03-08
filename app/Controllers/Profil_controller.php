<?php
class Profil_controller{
 
	function __construct(){

	}
	
	function profil() {
		if(!F3::get('SESSION.id'))
			F3::reroute('/');
		switch(F3::get('VERB')) { // faire sauter le switch
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
	
	function profil_invit() {
		if(!F3::get('SESSION.id'))
			F3::reroute('/');
		switch(F3::get('VERB')) { // faire sauter le switch
			case 'GET':
				$session_id=$_GET["action"];
				$profil=Profil::instance()->get_profil($session_id);
				F3::set('profil',$profil);
				$gout = unserialize($profil->gout);
				F3::set('gout',$gout);

				$aliments=Profil::instance()->get_aliment();
				F3::set('aliments',$aliments);

				echo Views::instance()->render('Profil.html');
			break;
			case 'POST':
				$session_id=$_GET["action"];
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
	
	function profil_info() {
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
	
	
	function profil_pswd() {
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
	
	function profil_avat() {
		switch(F3::get('VERB')) {
			case 'GET':
				F3::reroute('/Profil');
			break;
			case 'POST':
				if(isset($_FILES['avatar']))
				{
					$rep='uploads/avatars/';
					$fichier=basename($_FILES['avatar']['name']);
					$taille_max=200000;
					$taille_origin=filesize($_FILES['avatar']['tmp_name']);
					$ext=array('.png','.jpg','.jpeg');
					$ext_origin=strchr($_FILES['avatar']['name'],'.');
					
					if(!in_array($ext_origin, $ext))
					{
						$erreur='Mauvais format';
					}
					if($taille_origin>$taille_max)
					{
						$erreur='Mauvaise taille';
					}
					if(!isset($erreur))
					{
						if(move_uploaded_file($_FILES['avatar']['tmp_name'],$rep . $fichier))
						{
							$img=$rep . $fichier;
						}
						else
							echo'FAIL';
					}
					if(isset($erreur))
					{
						echo $erreur;
					}
				}
				$session_id=F3::get('SESSION.id');
				$avatar=$img;
				$profil = Profil::instance()->modif_avatar($session_id,$avatar);
				F3::reroute('/Profil');
			break;
		}
	}
	
	function profil_gout() {
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
	
	function contact() {
			if(!F3::get('SESSION.id'))
			F3::reroute('/');
			switch(F3::get('VERB')) {
				case 'GET':
					$session_id=F3::get('SESSION.id');
					$contact=Profil::instance()->get_contact($session_id);
					F3::set('contact',$contact);

					echo Views::instance()->render('contact.html');
				break;
				case 'POST':
					$session_id=F3::get('SESSION.id');
					$contact=Profil::instance()->modif_contact($session_id);
					F3::set('contact',$contact);
					
					echo Views::instance()->render('contact.html');
				break;
			}
		}
	
	function __destruct(){

	} 
}

?>