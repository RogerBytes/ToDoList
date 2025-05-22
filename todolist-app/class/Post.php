<?php 
class Post {
  public $id;
  public $name;
  public $content;

  public function getExcept ():string {
    return substr($this-> content, 150);
  }

}


?>