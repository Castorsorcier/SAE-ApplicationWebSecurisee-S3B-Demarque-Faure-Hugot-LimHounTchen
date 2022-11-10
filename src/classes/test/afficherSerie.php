<?php

namespace iutnc\deefy\test;
use iutnc\deefy\factory\ConnectionFactory;
require_once 'Click.php';

class afficherSerie{

static function AfficherSerie($liste):string{
  $bdd=ConnectionFactory::makeConnection();
  $resultat = $bdd->query("select titre,descriptif,annee,date_ajout,note from serie where id=$liste");
  $result = $bdd->query("select numero,titre,resume,duree,id from episode where serie_id=$liste");
  $data2 = $resultat->fetch();
  $html="<u><center><h1>".$data2['titre']." fait en ".$data2['annee']." et noté : ".$data2['note']." sur 5."."</h1></u>";
  $html.="<h2>".$data2['descriptif']."</h2>";
  $html.="<ul></center>";
  while($data = $result->fetch()){
      $html.= "<li><b>".$data['numero'].") </b><u>";
      $html.=Click::createEpisode($data['id'],$data['titre']);
      $html.=" :</u> ".$data['resume']."<div> duree ".$data['duree']."s. </div>"."</h3><br>";
  }
  $html.="</ul>";
  $html.="<br><p align=\"right\">ajouter le ".$data2['date_ajout']."</p>";
  return ($html);
}
}
