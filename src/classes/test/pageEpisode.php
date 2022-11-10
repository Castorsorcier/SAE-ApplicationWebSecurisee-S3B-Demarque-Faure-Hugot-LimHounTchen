<?php

namespace iutnc\deefy\test;
use iutnc\deefy\factory\ConnectionFactory;
require_once 'Commentaire.php';

class PageEpisode{
  static function afficherEpisode($id){
      $bdd=ConnectionFactory::makeConnection();
      $result = $bdd->query("select numero,titre,resume,duree,file from episode where id=$id");
      $data = $result->fetch(PDO::FETCH_ASSOC);
      $html="
  <head>
      <link rel=\"stylesheet\" href=\"page.css\" type=\"text/css\">
  </head>
  <body>";
      $html.="<center><h1>".$data['numero']." ) ".$data['titre']."</h1>";
      $html.="<p>".$data['resume']."<p>";
      $html.="<p> durée de l'épisode : ".$data['duree']."s.<p>";
      $html.="<video src=\"video/".$data['file']."\"
                  type=\"video/mp4\" controls=\"\" poster=\"\">
                  </video>";
      $html.=sectionCommentaire($id);
      print ($html);
  }
}
