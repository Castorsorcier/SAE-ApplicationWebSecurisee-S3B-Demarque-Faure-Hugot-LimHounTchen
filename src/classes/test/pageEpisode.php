<?php

namespace iutnc\deefy\test;
require_once 'commentaire.php';
class pageEpisode{
function afficherEpisode($id){
    $bdd= new PDO('mysql:host=localhost; dbname=sae-devweb-s3b; charset=utf8','root','');
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