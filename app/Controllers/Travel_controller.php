<?php
class Travel_controller{

  function __construct(){
    
  }
  
  function get(){
    
  }
  
  function post(){
    F3::set('errorMsg',null);
    $check=array(
      'firstname'=>'required',
      'lastname'=>'required',
      'email'=>'required,Audit->email',
      'email_check'=>'=email'
    );
    $error=Datas::instance()->check(F3::get('POST'),$check);
    if($error){
      F3::set('errorMsg',$error);
    }
    else{
      //record
    }
    
    
  }
  
}
?>