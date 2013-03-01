<?php
class App extends Prefab{
  
	function __construct(){
		F3::set('dB',new DB\SQL(
		'mysql:host='.F3::get('db_host').';port=3306;dbname='.F3::get('db_server'),
		F3::get('db_user'),
		F3::get('db_pw')));
	}
	
	/* Création de compte */
	
	function create($mail) {
		$inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');
		if($inscrit->find(array('mail=?',$mail))) {
			return true;
		}
		else {
			$inscrit->copyFrom('POST');
			$inscrit->save();
		}
	}
	
	/* Connexion */
  
	function connect($mail, $passwd) {
		$connect=new DB\SQL\Mapper(F3::get('dB'),'inscrit');
		return $connect->load(array('mail=? and passwd=?',$mail,$passwd));
	}
	
	/* Récupération */
	
	function get_inscrit($id) {
		$inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');
		return $inscrit->load(array('id=?',$id));
	}

	function __destruct(){

	}
}
?>