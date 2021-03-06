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

		$serial = serialize(F3::get('POST'));
		F3::get('dB')->exec("UPDATE inscrit SET gout='$serial' WHERE id='$session_id' ");

		return $inscrit->load(array('id=?',$session_id));
	}
	
	function modif_info($session_id, $nom, $prenom, $mail) {
		$inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');
		if($inscrit->find(array('mail=? and id!=?',$mail,$session_id))) {
			return false;
		}
		else {
			F3::get('dB')->exec("UPDATE inscrit SET nom='$nom', prenom='$prenom', mail='$mail' WHERE id='$session_id'");
			return $inscrit->load(array('id=?',$session_id));
		}
	}
	
	function modif_avatar($session_id, $avatar) {
		F3::get('dB')->exec("UPDATE inscrit SET avatar='$avatar' WHERE id='$session_id'");
	}
	
	
	function modif_pswd($session_id, $old_pswd, $new_pswd, $new_pswd_bis) {
		$inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');

		$in_db = $inscrit->load(array('id=?', $session_id));

		if(md5($old_pswd) == $in_db->passwd && $new_pswd == $new_pswd_bis) {
			$new_pswd=md5($new_pswd);
			F3::get('dB')->exec("UPDATE inscrit SET passwd='$new_pswd' WHERE id='$session_id' ");
		}

		return $inscrit->load(array('id=?',$session_id));
	}
	
	function get_profil($session_id) {
		$inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');

		return $inscrit->load(array('id=?',$session_id));
	}
  
	function get_aliment() {
		$aliment=new DB\SQL\Mapper(F3::get('dB'),'aliments');
		
		return $aliment->find();
	}
	
	function get_contact($session_id) {
		$inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');
		
		$infos = $inscrit->load(array('id=?',$session_id));
		$contact = $infos->contact;
		
		return unserialize($contact);
	}
	
	function modif_contact($session_id) {
		$inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');
		
		$posted = F3::get('POST');
		
		foreach ($posted as $i => $item) {
			if(!$item){
				unset($posted[$i]);
			}
		}
		
		$posted = array_values($posted);
		
		$contact = serialize($posted);

		F3::get('dB')->exec("UPDATE inscrit SET contact='$contact' WHERE id='$session_id' ");

		$infos = $inscrit->load(array('id=?',$session_id));
		$contact = $infos->contact;
		
		return unserialize($contact);
	}
	function __destruct(){

	}
}
?>