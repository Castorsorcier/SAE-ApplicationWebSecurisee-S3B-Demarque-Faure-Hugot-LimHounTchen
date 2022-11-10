<?php

namespace iutnc\deefy\test;
require_once 'PageEpisode.php';

class ClickSerie{
  static function runFunction(int $id){
      afficherSerie($id);
  }

  static function createSerie(int $id,string $titre): string{
      $text="<a href=\"?function&id=".$id."\">$titre</a>";
      return $text;
  }
}

/*
if (isset($_GET['function'])){
    runFunction($_GET['id']);
}
*/
