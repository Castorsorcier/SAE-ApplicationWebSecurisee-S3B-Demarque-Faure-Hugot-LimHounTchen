<?php

namespace iutnc\deefy\test;
use iutnc\deefy\factory\ConnectionFactory;

class Commentaire{
  static function sectionCommentaire($idvideo):string{
      $html = "
  <div>";
      $html .= "
  <form action=\"\" method=\"post\"> <label>".
          Commentaire::check($idvideo)."
      </label><label>Commentaire : </label>
      <textarea rows=\"20\" cols=\"50\" name=\"commentaire\" id=\"comm\" placeholder=\"Ajouter un commentaire\" required style=\"height:150px;  width: 500px;font-size:14pt;text-align: left;vertical-align: top;resize: none;\"></textarea>
      <select name=\"note\" id=\"note\" style=\"height:40px;width: 40px;font-size:10pt;\">
          <option value=\"1\">1</option>
          <option value=\"2\">2</option>
          <option value=\"3\">3</option>
          <option value=\"4\">4</option>
          <option value=\"5\">5</option>
      </select>
      <input type=\"submit\" name=\"submit\" vlaue=\"Choose options\">
  </form>";

      $html .= Commentaire::afficherCommentaire($idvideo);
      $html .= "</div>";
      return $html;
  }

  static function afficherCommentaire($video): string
  {
      $bdd = ConnectionFactory::makeConnection();
      $seconde= $bdd->query("select serie_id from episode where id=".$video);
      $second=$seconde->fetch();
      $resultat = $bdd->query("select email,comment,note from commentaire where id in (select id from episode where serie_id=".$second['serie_id'].")");
      $liste = "";
      while ($data = $resultat->fetch()) {

          $liste.="<div id='ranger' style=\"text-align: left;\">";
          $liste .= "<label id=\"noter\" style=\"border:none;border-radius:2pt;background-color:white;box-shadow: 0 0 0 2pt black;color: black;font-size:20pt;\">&nbsp;" . $data['note'] . " </label><label>&emsp;</label>";
          $liste .= "<label id=\"auteur\" style=\"border: none;border-radius: 2pt;background-color: white;box-shadow: 0 0 0 2pt black;color: black;font-size:15pt;\">&nbsp;" . $data['email'] . " : </label><label>&emsp;</label>";
          $liste .= "<label id=\"boite\" style=\"border: none;border-radius: 2pt;background-color: white;box-shadow: 0 0 0 2pt black;color: black;\"
    >&nbsp;" . $data['comment'] . "&nbsp;</label>";
          $liste.="</div>";
          $liste .= "<br><br>";
      }
      return $liste;
  }

  static function evaluer($count){
      $bdd=ConnectionFactory::makeConnection();
      $debut="select note from commentaire where id=1";
      $boite=$bdd->query($debut);
      $chiffre=0;
      $diviseur=0;
      while($checko = $boite->fetch()){
          $chiffre+=$checko['note'];
          $diviseur+=1;
      }
      $chiffre=round(($chiffre/$diviseur),1);
      $requete="update serie set note=".$chiffre." where id=".$count;
      $bdd->query($requete);
  }

  static function check($video):string{
      if((!empty($_POST['commentaire']))and(!empty($_SESSION['email']))){
          $bdd=ConnectionFactory::makeConnection();
          $recher="select email from commentaire where id=".$video." and email=\"".$_SESSION['email']."\"";
          $result = $bdd->query($recher);
          $data = $result->fetch();
          if(empty($data['email'])){
              $recherche="insert into commentaire (email,id,comment,note) values(\"".$_SESSION['email']."\",".$video.",\"".$_POST['commentaire']."\",".$_POST['note'].")";
              $bdd->query($recherche);
              commentaire::evaluer($video);
          }else{
              $recherchage="update commentaire set commentaire.comment=\"".$_POST['commentaire']."\",commentaire.note=".$_POST['note']." where email=\"".$_SESSION['email']."\" and id=".$video;
              $bdd->query($recherchage);
              commentaire::evaluer($video);
          }
          return "Votre commentaire a bien été ajouter.<br>";
      }else{
          return "";
      }
  }
}

/*
if(isset($_POST['submit'])) {
    if (!empty($_POST['note'])) {
        $selected = $_POST['note'];
    }
    //print($_POST['commentaire']." /: et une note de ".$_POST['note']);
}
*/