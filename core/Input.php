<?php
namespace Core;
use Core\FH;
use Core\Router;

class Input {

  public function isPost(){
    return $this->getRequestMethod() === 'POST';
  }

  public function isPut(){
    return $this->getRequestMethod() === 'PUT';
  }

  public function isGet(){
    return $this->getRequestMethod() === 'GET';
  }

  public function getRequestMethod(){
    return strtoupper($_SERVER['REQUEST_METHOD']);
  }

  public function get($input=false) {
    if(!$input){
      // return entire request array and sanitize it
      $data = [];
      foreach($_REQUEST as $field => $value){
        if(is_array($value)){
          foreach ($value as $field_1 => $value_1) {
            $data[$field_1] = FH::sanitize($value_1);
          }
        }else{
          $data[$field] = FH::sanitize($value);
        }
      }
      return $data;
    }
    return FH::sanitize($_REQUEST[$input]);
  }

  // public function csrfCheck(){
  //   if(!FH::checkToken($this->get('csrf_token'))) Router::redirect('restricted/badToken');
  //   return true;
  // }
}
