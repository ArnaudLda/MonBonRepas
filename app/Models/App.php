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
  function crea_repas($mail,$lat,$lng,$position,$Mon_mail, $date, $contacts)
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
		$repas->lat=$lat;
		$repas->lng=$lng;
		$repas->date=$date;
		$repas->Lib_lieu=$position;
		$repas->save();
	}
	foreach ($contacts as $contact){
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
		$repas->log_invit=$contact;
		$repas->lat=$lat;
		$repas->lng=$lng;
		$repas->date=$date;
		$repas->Lib_lieu=$position;
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
  
  function get_contact($session_id) {
	$inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');
	
	$session_id = 1; // test
	
	$infos = $inscrit->load(array('id=?',$session_id));
	$contact = $infos->contact;
	
	return unserialize($contact);
	
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
  function flux_repas($mail)
  {
	return F3::get('dB')->exec("select log_invit, statut from repas where log_crea='$mail' and statut<>'non_lu'");
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