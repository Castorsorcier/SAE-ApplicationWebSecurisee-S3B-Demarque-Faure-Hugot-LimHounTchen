<?php

namespace iutnc\deefy\test;
require_once 'PageEpisode.php';

class Click{
  static function runFunction(int $id){
      PageEpisode::afficherEpisode($id);
  }

  static function createEpisode(int $id,string $titre): string{
      $text="<a href=\"?function&episode=".$id."\">$titre</a>";
      return $text;
  }
}

/*
if (isset($_GET['function'])){
    runFunction($_GET['id']);
}
*/