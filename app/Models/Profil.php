<?php
class Profil extends Prefab{
  
	function __construct(){
		F3::set('dB',new DB\SQL(
			'mysql:host='.F3::get('db_host').';port=3306;dbname='.F3::get('db_server'),
			F3::get('db_user'),
			F3::get('db_pw')));
	}
	
	function modif_gout($session_id) {
		$inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');

		$session_id = 1; // test

		$serial = serialize(F3::get('POST'));
		F3::get('dB')->exec("UPDATE inscrit SET gout='$serial' WHERE id='$session_id' ");

		return $inscrit->load(array('id=?',$session_id));
	}
	
	function modif_info($session_id, $nom, $prenom, $mail) {
		$inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');

		$session_id = 1; // test
		
		F3::get('dB')->exec("UPDATE inscrit SET nom='$nom', prenom='$prenom', mail='$mail' WHERE id='$session_id'");
		
		return $inscrit->load(array('id=?',$session_id));
	}
	
	function modif_pswd($session_id, $old_pswd, $new_pswd, $new_pswd_bis) {
		$inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');

		$session_id = 1; // test

		$in_db = $inscrit->load(array('id=?', $session_id));

		if($old_pswd == $in_db->passwd && $new_pswd == $new_pswd_bis) {
			F3::get('dB')->exec("UPDATE inscrit SET passwd='$new_pswd' WHERE id='$session_id' ");
		}

		return $inscrit->load(array('id=?',$session_id));
	}
	
	function get_profil($session_id) {
		$inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');
		$session_id = 1; // test

		return $inscrit->load(array('id=?',$session_id));
	}
  
	function get_aliment() {
		$aliment=new DB\SQL\Mapper(F3::get('dB'),'aliments');
		$aliments = $aliment->find();

		return $aliments;
	}
	
	function __destruct(){

	}
}
?>