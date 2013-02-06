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
    
    F3::set('coords',Views::instance()->toJson($location,array('lat'=>'lat','lng'=>'lng')));

    
    $pictures=$App->locationPictures($location->id);

    $json=Views::instance()->toJson($pictures,array('image'=>'src'));
    F3::set('pictures',$json);
    //F3::set('location',App::instance()->locationDetails(););
    
    
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
	 $units=array(
      array('firstname'=>'$_GET["prenom"]','lastname'=>'francois','email'=>'pumir@hetic.net','email_check'=>'pumir@hetic.net'),
      /*array('firstname'=>'','lastname'=>'francois','email'=>'pumir@hetic.net','email_check'=>'pumir@hetic.net'),
      array('firstname'=>'pumir','lastname'=>'','email'=>'pumir@hetic.net','email_check'=>'pumir@hetic.net'),
      array('firstname'=>'','lastname'=>'','email'=>'pumir@hetic.net','email_check'=>'pumir@hetic.net'),
      array('firstname'=>'pumir','lastname'=>'francois','email'=>'pumir@heticnet','email_check'=>'pumir@heticnet'),
      array('firstname'=>'pumir','lastname'=>'francois','email'=>'pumir@hetic.ne','email_check'=>'pumir@hetic.net'),
      array('firstname'=>'pumir','lastname'=>'francois','email'=>'','email_check'=>'pumir@hetic.net'),
      array('firstname'=>'pumir','lastname'=>'francois','email'=>'pumir@hetic.net','email_check'=>''),
      array('firstname'=>'','lastname'=>'francois','email'=>'pumir@hetic.net','email_check'=>'pumir.net')*/
    );
    $test=new \Test;
    foreach ($units as $unit) {
      F3::mock('POST /travel',$unit);
      $test->expect(
        !F3::get('errorMsg'),
        'POST : '.
        $unit['firstname'].' | '.
        $unit['lastname'].' | '.
        $unit['email'].' | '.
        $unit['email_check'].' => '.
        F3::stringify(F3::get('errorMsg'))
        );
    }
    F3::set('results',$test->results());
	echo Views::instance()->render('inscription.html');
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
   function test()
 {
	echo Views::instance()->render('test.html');
 }
 function __destruct(){

 } 
}
?>