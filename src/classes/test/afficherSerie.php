<?php

namespace iutnc\deefy\test;
require_once 'click.php';

class afficherSerie{

function afficherSerie($liste){
$bdd= new PDO('mysql:host=localhost; dbname=sae-devweb-s3b; charset=utf8','root','');
$resultat = $bdd->query("select titre,descriptif,annee,date_ajout from serie where id=$liste");
$result = $bdd->query("select numero,titre,resume,duree,id from episode where serie_id=$liste");
$data2 = $resultat->fetch(PDO::FETCH_ASSOC);
$html="<u><center><h1>".$data2['titre']." fait en ".$data2['annee']."</h1></u>";
$html.="<h2>".$data2['descriptif']."</h2>";
$html.="<ul></center>";
while($data = $result->fetch(PDO::FETCH_ASSOC)){
    $html.= "<li><b>".$data['numero'].") </b><u>";
    $html.=createEpisode($data['id'],$data['titre']);
    $html.=" :</u> ".$data['resume']."<div> duree ".$data['duree']."s. </div>"."</h3><br>";
}
$html.="</ul>";
$html.="<br><p align=\"right\">ajouter le ".$data2['date_ajout']."</p>";
print($html);
}
}

if(!isset($_GET['function'])){
    afficherSerie(1);
}