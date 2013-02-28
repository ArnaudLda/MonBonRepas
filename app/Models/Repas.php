<?php
class Repas extends Prefab{
  
	function __construct(){
		F3::set('dB',new DB\SQL(
		'mysql:host='.F3::get('db_host').';port=3306;dbname='.F3::get('db_server'),
		F3::get('db_user'),
		F3::get('db_pw')));
	}
	
	/* Création de repas */
	
	function crea_repas($mail,$lat,$lng,$position,$my_id, $date) {
		
		
		
		/* PAR ICI BATARD
			$id_repas = rand(0,1000);
			
			$repas->load(array('id_repas',$id_repas));*/
		
		foreach ($mail as $invit) {
			$repas=new DB\SQL\Mapper(F3::get('dB'),'repas');
			if ($invit) {
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
				
				$repas->log_crea=$my_id;
				$repas->log_invit=$invit;
				$repas->lat=$lat;
				$repas->lng=$lng;
				$repas->date=$date;
				$repas->Lib_lieu=$position;
				$repas->save();
			}
		}
	}
	
	/* Récupération de l'id par rapport au mail */
	
	function mail_to_id($mail) {
		$inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');
		$id = $inscrit->load(array('mail=?',$mail));
		if(!$id) {
			return false;
		}
		return $id;
	}
	
	/* Récupération des contacts */
  
	function get_contact($session_id) {
		$inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');

		$infos = $inscrit->load(array('id=?',$session_id));
		$contact = $infos->contact;

		return unserialize($contact);
	}
	
	/* Récupération de la liste des repas */
	
	function get_liste_repas($Mon_mail) {
		$repas=new DB\SQL\Mapper(F3::get('dB'),'repas');
		return $repas->find(array('log_invit=?',$Mon_mail));
	}
	
	/* Récupération d'un repas */
	
	function get_repas($id) {
		$repas=new DB\SQL\Mapper(F3::get('dB'),'repas');
		return $repas->load(array('id=?',$id));
	}
	
	/* Modification du status repas */
	
	function modif_statut_repas($reponse,$id) {
		return F3::get('dB')->exec("UPDATE repas SET statut='$reponse' WHERE id='$id'");
	}
	
	/* Récupération du flux de repas */
	
	function flux_repas($mail) {
		return F3::get('dB')->exec("select log_invit, statut from repas where log_crea='$mail' and statut<>'non_lu'");
	}
	
	function __destruct(){

	}
}
?>