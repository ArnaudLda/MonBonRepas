<?php
class App extends Prefab{
  
  function __construct(){
      F3::set('dB',new DB\SQL(
        'mysql:host='.F3::get('db_host').';port=3306;dbname='.F3::get('db_server'),
        F3::get('db_user'),
        F3::get('db_pw')));
  }
  
  function locationDetails($id=null){
    //return F3::get('dB')->exec('select * from location limit 1');
    $location=new DB\SQL\Mapper(F3::get('dB'),'location');
    if(!$id){
      return $location->load();
    }
    return $location->load(array('id=?',$id));
  }
  
    function create(){
    $inscrit=new DB\SQL\Mapper(F3::get('dB'),'inscrit');
	$inscrit->copyFrom('POST');
	$inscrit->save();
  }
  
  function locationPictures($idLocation){
    $pictures=new DB\SQL\Mapper(F3::get('dB'),'pictures');
    return $pictures->find(array('idLocation=?',$idLocation));
  }
  
  function getNext($id){  
    return F3::get('dB')->exec("select id, title from location where id =(select min(id) from location where id > ".$id.")");
  }
  
  function getPrev($id){
    return F3::get('dB')->exec("select id, title from location where id =(select max(id) from location where id < ".$id.")");
  }
  

  function __destruct(){

  }
}






?>