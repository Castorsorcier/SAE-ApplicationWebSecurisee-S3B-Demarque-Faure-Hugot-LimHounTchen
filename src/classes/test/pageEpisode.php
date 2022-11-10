<?php

namespace iutnc\deefy\test;
use iutnc\deefy\factory\ConnectionFactory;
require_once 'Commentaire.php';

class PageEpisode{
  static function afficherEpisode($id):string{
      $bdd=ConnectionFactory::makeConnection();
      $result = $bdd->query("select numero,titre,resume,duree,file from episode where id=$id");
      $data = $result->fetch();
      /*
      $html="
  <head>
      <link rel=\"stylesheet\" href=\"page.css\" type=\"text/css\">
  </head>
  <body>";
      */
      $html="";
      $html.="<center><h1 style=\"text-decoration: underline;\">".$data['numero']." ) ".$data['titre']."</h1>";
      $html.="<p>".$data['resume']."<p>";
      $html.="<p> durée de l'épisode : ".$data['duree']."s.<p>";
      $html.="<video src=\"src/classes/test/video/".$data['file']."\"
                  type=\"video/mp4\" controls=\"\" poster=\"\" style=\"border: none;
    border-radius: 10pt;\">
                  </video>";
      $html.=commentaire::sectionCommentaire($id);
      return "$html";
  }
}
