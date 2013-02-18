<?php
class App_controller{
 
 function __construct(){
  
 }
 
 function home(){
    $id=F3::get('PARAMS.id');
    #récupération de la destination courante
    $App=new App();
    $location=$App->locationDetails($id);
    if(!$location){
      F3::error('404');
      return;
    }
    F3::set('location',$location);
    
    if(F3::get('AJAX')){
      $ajax['coords']['lat']=$location->lat;
      $ajax['coords']['lng']=$location->lng;
      $pictures=App::instance()->locationPictures($location->id);
      $ajax['pictures']=array_map(function($item){return array('image'=>$item->src);},$pictures);
      echo json_encode($ajax);
      return;
    }

    
    $next=$App->getNext($location->id);
    $prev=$App->getPrev($location->id);
    
   
    $linkNext=$next?$next[0]['id'].'-'.$next[0]['title']:'';
    $linkPrev=$prev?$prev[0]['id'].'-'.$prev[0]['title']:'';
    
    F3::set('next',$linkNext);
    F3::set('prev',$linkPrev);
    
    
    echo Views::instance()->render('travelr.html');
 }
 
 
  function doc(){
    echo Views::instance()->render('userref.html');
  }
  
  function connexion()
 {
	switch(F3::get('VERB'))
	{
      case 'GET':
		echo Views::instance()->render('connexion.html');
      break;
      case 'POST':
	  $check=array('mail'=>'required,Audit->email','passwd'=>'required');
        $error=Datas::instance()->check(F3::get('POST'),$check);
        if($error)
		{
          F3::set('errorMsg',$error);
          echo Views::instance()->render('connexion.html');
          return;
        }
		$connect=App::instance()->connect($_POST['mail'],$_POST['passwd']);
		if($connect)
		{
			F3::set('SESSION.mail',$_POST['mail']);
			F3::reroute('/dashboard');
		}
		else
		{
			F3::set('errorMsg',$error);
			echo Views::instance()->render('connexion.html');
			return;
		}
		break;
    }
 }
  function inscription()
 {
	switch(F3::get('VERB'))
	{
      case 'GET':
        echo Views::instance()->render('inscription.html');
      break;
      case 'POST':
	 $check=array('prenom'=>'required','nom'=>'required','mail'=>'required,Audit->email','passwd'=>'required');
        $error=Datas::instance()->check(F3::get('POST'),$check);
        if($error)
		{
          F3::set('errorMsg',$error);
          echo Views::instance()->render('inscription.html');
          return;
        }
		$test=App::instance()->create($_POST['mail']);
		if($test)
		{
		  $error="error";
		  F3::set('errorMsg["mail"]',$error);
          echo Views::instance()->render('inscription.html');
          return;
		}
		else
			F3::reroute('/connexion');
		break;
    }
 }
   function crea_repas()
 {
	switch(F3::get('VERB'))
	{
      case 'GET':
        echo Views::instance()->render('Crea_Repas.html');
      break;
      case 'POST':
	 $check=array('mail'=>'required,Audit->email');
        $error=Datas::instance()->check(F3::get('POST'),$check);
        if($error)
		{
          F3::set('errorMsg',$error);
          echo Views::instance()->render('Crea_Repas.html');
          return;
        }
		$Mon_mail=F3::get('SESSION.mail');
		App::instance()->crea_repas($_POST['mail'],$Mon_mail);
		echo Views::instance()->render('Crea_Repas.html');
		/*if($test)
		{
		  
          return;
		}
		else
			*/
		break;
    }
 }
   function dashboard()
 {
	echo Views::instance()->render('Dashboard.html');
 }
  function profil()
 {
	echo Views::instance()->render('Profil.html');
 }
  function gest_repas()
 {
	echo Views::instance()->render('Gest_Repas.html');
 }
 
 function __destruct(){

 } 
}
?>