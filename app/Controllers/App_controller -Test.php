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
	echo Views::instance()->render('connexion.html');
 }
  function inscription()
 {
	switch(F3::get('VERB'))
	{
      case 'GET':
        echo Views::instance()->render('inscription.html');
      break;
      case 'POST':
	 $check=array('prenom'=>'required','nom'=>'required','mail'=>'required,Audit->email','passwd'=>'required',);
        $error=Datas::instance()->check(F3::get('POST'),$check);
        if($error)
		{
          F3::set('errorMsg',$error);
          echo Views::instance()->render('inscription.html');
          return;
        }
		$test=App::instance()->create($check['mail']);
		if($test==false)
		{
			$error="Adresse mail déjà existante";
			F3::set('errorMsg[mail]',$error);
			echo Views::instance()->render('inscription.html');
		}
		else
		{
			F3::reroute('/connexion');
		}
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
  function crea_repas()
 {
	echo Views::instance()->render('Crea_repas.html');
 }
  function gest_repas()
 {
	echo Views::instance()->render('Gest_Repas.html');
 }
 
 function __destruct(){

 } 
}
?>