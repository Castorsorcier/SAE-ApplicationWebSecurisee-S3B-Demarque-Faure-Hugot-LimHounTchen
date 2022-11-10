<?php

namespace iutnc\deefy\test;
class commentaire{
function sectionCommentaire($idvideo):string
{
    $html = ">
</head>
<body>";
    $html .= "
<form action=\"\" method=\"post\"> <label>".
        check()."
    </label><label>Commentaire : </label>
    <textarea rows=\"20\" cols=\"50\" name=\"commentaire\" id=\"comm\" placeholder=\"Ajouter un commentaire\" required>
</textarea>
    <select name=\"note\" id=\"note\">
        <option value=\"1\">1</option>
        <option value=\"2\">2</option>
        <option value=\"3\">3</option>
        <option value=\"4\">4</option>
        <option value=\"5\">5</option>
    </select>
    <input type=\"submit\" name=\"submit\" vlaue=\"Choose options\">
</form>";

    function afficherCommentaire($video): string
    {
        $bdd = new PDO('mysql:host=localhost; dbname=sae-devweb-s3b; 
        charset=utf8', 'root', '');
        $resultat = $bdd->query("select email,comment,note from commentaire where id=$video");
        $liste = "";
        while ($data = $resultat->fetch(PDO::FETCH_ASSOC)) {

            //créé 3 div 1 pour les notes, 1 pour les nom, 1 pour les commentaires
            //ceci permettra d'aligner chaque catégorie

            $liste.="<div id='ranger'>";
            $liste .= "<label id=\"noter\">&nbsp;" . $data['note'] . " </label><label>&emsp;</label>";
            $liste .= "<label id=\"auteur\">&nbsp;" . $data['email'] . " : </label><label>&emsp;</label>";
            $liste .= "<label id=\"boite\">&nbsp;" . $data['comment'] . "&nbsp;</label>";
            $liste.="</div>";
            $liste .= "<br><br>";
        }
        return $liste;
    }
    $html .= afficherCommentaire($idvideo);
    $html .= "</body>";
    return $html;
}

function check():string{
    if(!empty($_POST['commentaire'])){
        return $texto="Votre commentaire a bien été ajouter.<br>";
    }else{
        return "";
    }
}
}

if(isset($_POST['submit'])) {
    if (!empty($_POST['note'])) {
        $selected = $_POST['note'];
    }
    //print($_POST['commentaire']." /: et une note de ".$_POST['note']);
}