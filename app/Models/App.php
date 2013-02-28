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
		$exist=false;
		if($inscrit->find(array('mail=?',$mail))) {
			$exist=true;
			return $exist;
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
	
	function locationPictures($idLocation){ // useless ?
		$pictures=new DB\SQL\Mapper(F3::get('dB'),'pictures');
		return $pictures->find(array('idLocation=?',$idLocation));
	}
	
	/* Récupération */
	
	function get_inscrit($mail) {
		$inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');
		return $inscrit->load(array('mail=?',$mail));
	}

	function __destruct(){

	}
}
?>