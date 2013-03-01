<?php
class Comment extends Prefab{
  
	function __construct(){
		F3::set('dB',new DB\SQL(
		'mysql:host='.F3::get('db_host').';port=3306;dbname='.F3::get('db_server'),
		F3::get('db_user'),
		F3::get('db_pw')));
	}
	function rec_com($id, $text, $id_mess)
	{
		$mess=new DB\SQL\Mapper(F3::get('dB'),'message');
		$mess->lib=$text;
		$mess->id_auteur=$id;
		$mess->id_repas=$id_mess;
		$mess->save();
	}
	function __destruct(){

	}
}
?>