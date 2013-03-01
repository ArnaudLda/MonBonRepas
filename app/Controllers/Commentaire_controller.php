<?php
class Commentaire_controller{
	function __construct(){

	}
	function crea_com()
	{
		switch(F3::get('VERB')) 
		{
			case 'GET':
				echo Views::instance()->render('repas.html');
			break;
			case 'POST':
				$id=F3::get('SESSION.id');
				$text=$_POST['commentaires'];
				$id_mess=$_POST['id_mess'];
				$check=array('commentaires'=>'required');
				$error=Datas::instance()->check(F3::get('POST'),$check);
				if($error) {
					F3::set('errorMsg',$error);
					F3::reroute("/repas?action=$id_mess");
					return;
				}
				$flux_com=Comment::instance()->rec_com($id, $text, $id_mess);		
				F3::reroute("/repas?action=$id_mess");
			break;
		}
	}
	function __destruct(){

	} 
}
?>