<?php
class Repas extends Prefab{
  
	function __construct(){
		F3::set('dB',new DB\SQL(
		'mysql:host='.F3::get('db_host').';port=3306;dbname='.F3::get('db_server'),
		F3::get('db_user'),
		F3::get('db_pw')));
	}
	
	/* Création de repas */
	
	function crea_repas($mail,$lat,$lng,$position,$my_id, $date,$is_inscrit) {
		$repas=new DB\SQL\Mapper(F3::get('dB'),'repas');
		$id_repas = rand(0,1000);
		$has_id = $repas->load(array('id_repas',$id_repas));
		$ok=false;
		while($ok=false){
			if($has_id == $id_repas) {
				$repas->reset();
				$has_id = $repas->load(array('id_repas',$id_repas));
				$ok=true;
			}
		}
		
		
		
		foreach ($mail as $i => $invit) {
			if ($invit) {
				$repas->reset();
				
				
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
				$repas->id_repas=$id_repas;
				$repas->is_inscrit=$is_inscrit[$i];
				$repas->save();
			}
		}
	}
	
	/* Récupération de l'id par rapport au mail */
	
	function mail_to_id($mail) {
		$inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');
		return $inscrit->load(array('mail=?',$mail));
	}
	
	/* Récupération des contacts */
  
	function get_contact($session_id) {
		$inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');

		$infos = $inscrit->load(array('id=?',$session_id));
		return unserialize($infos->contact);
	}
	
	/* Récupération de la liste des repas */
	
	function get_liste_repas($id) {
		$repas=new DB\SQL\Mapper(F3::get('dB'),'repas');
		return $repas->find(array('log_invit=?',$id));
	}
	
	/* Récupération d'un repas */
	
	function get_full_repas($id) {
		$repas=new DB\SQL\Mapper(F3::get('dB'),'repas');
		return $repas->find(array('id_repas=?',$id));
	}
	
	function get_repas($id) { 
		$repas=new DB\SQL\Mapper(F3::get('dB'),'repas');
		return $repas->load(array('id=?',$id)); 
	}
	
	/* Récupération des gouts de chacun */
	
	function get_invit_gout($invit) {
		$repas=new DB\SQL\Mapper(F3::get('dB'),'inscrit');
		$invit = $repas->load(array('id=?',$invit));
		return unserialize($invit->gout);
	}
	
	/* Modification du status repas */
	
	function modif_statut_repas($reponse,$id) {
		return F3::get('dB')->exec("UPDATE repas SET statut='$reponse' WHERE id='$id'");
		/*$repas=new DB\SQL\Mapper(F3::get('dB'),'repas');
		$repas->load(array('id=?',$id));
		$repas->statut = $reponse;
		return $repas->update();*/
	}
	
	/* Récupération du flux de repas */
	
	function flux_repas($id) {
		$repas=new DB\SQL\Mapper(F3::get('dB'),'repas');
		$statut='non_lu';
		return $repas->find(array('log_crea=? and statut!=?',$id,$statut));
	}
	
	function __destruct(){

	}
}
?>