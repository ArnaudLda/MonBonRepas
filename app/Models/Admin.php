<?php
class Admin extends Prefab{
  
  function __construct(){
    F3::set('dB',new DB\SQL('mysql:host='.F3::get('db_host').';port=3306;dbname='.F3::get('db_server'),F3::get('db_user'),F3::get('db_password')));
   
  }

  function getAllLocations(){
    $location=new DB\SQL\Mapper(F3::get('dB'),'location');
    return $location->find();
  }
  
  function create(){
    $location=new DB\SQL\Mapper(F3::get('dB'),'location');
    $location->copyFrom('POST');
    $location->save();
    
    $image=Web::instance()->receive();
    if($image){
      $this->_resize($image,1024,768);
      $picture=new DB\SQL\Mapper(F3::get('dB'),'pictures');
      $picture->src='min_'.$image;
      $picture->idLocation=$location->id;
      $picture->save();
    }
  }
  
  protected function _resize($image,$width,$height){
    $img=new Image(F3::get('UPLOADS').$image,true);
    $img->resize($width,$height);
    file_put_contents(F3::get('UPLOADS').'min_'.$image,$img->dump('jpeg'));
  }
  
  
  
}
?>