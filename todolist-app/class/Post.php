<?php
class Post {
  public int $id;
  public string $name;
  public string $content;
  public ?int $user_id = null;
  public ?string $archived_at = null;
  public $created_at;

  // Retourne les 150 premiers caractères du contenu du post
  public function getExcerpt ():string {
    return substr($this-> content, 0 , 150);
  }

  // C'est pas moi qui l'ai fait, je ne comprends pas bien, mais pas le temps (il convertit la datetime d'utc vers le format paris)
  public function getCreatedAt(): DateTime {
    $utc = new DateTimeZone('UTC');
    $paris = new DateTimeZone('Europe/Paris');
    $date = new DateTime($this->created_at, $utc);
    return $date->setTimezone($paris);
  }
}




?>