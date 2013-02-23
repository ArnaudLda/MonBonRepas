<?php
class App extends Prefab{
  
  function __construct(){
      F3::set('dB',new DB\SQL(
        'mysql:host='.F3::get('db_host').';port=3306;dbname='.F3::get('db_server'),
        F3::get('db_user'),
        F3::get('db_pw')));
  }
  
  function locationDetails($id=null){
    //return F3::get('dB')->exec('select * from location limit 1');
    $location=new DB\SQL\Mapper(F3::get('dB'),'location');
    if(!$id){
      return $location->load();
    }
    return $location->load(array('id=?',$id));
  }
  function crea_repas($mail, $Mon_mail)
  {
	
	foreach ($mail as $invit)
	{
		$repas=new DB\SQL\Mapper(F3::get('dB'),'repas');
		/*$cle=md5(microtime(TRUE)*100000);
		$dest=$invit;
		$sujet = "Invitation à mon repas" ;
		$entete = "From: MonBonRepas@votresite.com" ;
		$message = 'Vous êtes invité à un repas,

		Pour valider votre venue, veuillez cliquer sur le lien ci dessous
		ou copier/coller dans votre navigateur internet.

		http://localhost/GitHub/MonBonRepas/connexion


		---------------
		Ceci est un mail automatique, Merci de ne pas y répondre.';
		mail($dest, $sujet, $message, $entete) ; // Envoi du mail*/
		
		$repas->log_crea=$Mon_mail;
		$repas->log_invit=$invit;
		$repas->save();
	}
  }
    function create($mail)
  {
    $inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');
	$exist=false;
	if($inscrit->find(array('mail=?',$mail)))
	{
		$exist=true;
		return $exist;
	}
	else
	{
		$inscrit->copyFrom('POST');
		$inscrit->save();
	}
  }
  
 function modif_profil($mail) {
    $inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');
	
	$mail = "utar@hotmail.fr"; // test
	
	/*if(false//le post des infos) {
		$info = F3::get('POST');
		// Update des champs info
	}
	else if(false// le post du mdp) {
		$info = F3::get('POST');
		$in_db = $inscrit->load(array('mail=?', $mail);
		
		if($info->old_pswd == $in_db->passwd && $info->new_pswd == $info->new_pswd_bis) {
			// Update du champ passwd
		}
	}
	else if(true//si c'est le post des gouts) {
		$serial = serialize(F3::get('POST'));
		// Update du champ gout
	}*/
	return $inscrit->load(array('mail=?',$mail));
  }
  
  function connect($mail, $passwd) {
	$connect=new DB\SQL\Mapper(F3::get('dB'),'inscrit');
	return $connect->load(array('mail=? and passwd=?',$mail,$passwd));
  }
  function get_liste_repas($Mon_mail) {
	$repas=new DB\SQL\Mapper(F3::get('dB'),'repas');
	return $repas->find(array('log_invit=?',$Mon_mail));
  }
  function get_repas($id)
  {
	$repas=new DB\SQL\Mapper(F3::get('dB'),'repas');
	return $repas->load(array('id=?',$id));
  }
  function locationPictures($idLocation){
    $pictures=new DB\SQL\Mapper(F3::get('dB'),'pictures');
    return $pictures->find(array('idLocation=?',$idLocation));
  }
  function get_inscrit($mail)
  {
	$inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');
    return $inscrit->load(array('mail=?',$mail));
  }
  function modif_statut_repas($reponse,$id)
  {
	if($reponse=="accepter")
	{
		return F3::get('dB')->exec("UPDATE repas SET statut='$reponse' WHERE id='$id'");
	}
	elseif($reponse=="refuser")
	{
		return F3::get('dB')->exec("UPDATE repas SET statut='$reponse' WHERE id='$id'");
	}
  }
  function getNext($id){  
    return F3::get('dB')->exec("select id, title from location where id =(select min(id) from location where id > ".$id.")");
  }
  
  function getPrev($id){
    return F3::get('dB')->exec("select id, title from location where id =(select max(id) from location where id < ".$id.")");
  }
  

  function __destruct(){

  }
}






?>