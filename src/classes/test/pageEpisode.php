<?php

namespace iutnc\deefy\test;
use iutnc\deefy\factory\ConnectionFactory;
require_once 'Commentaire.php';

class PageEpisode{
  static function afficherEpisode($id):string{
      $bdd=ConnectionFactory::makeConnection();
      $video=$bdd->query("select serie_id from episode where id=".$id);
      $autrevideo=$video->fetch();
      $result = $bdd->query("select numero,titre,resume,duree,file from episode where id=$id");
      $data = $result->fetch();
      $cour = $bdd->query("select idListe,id from liste2utilisateur where idListe=3 and email=\"".$_SESSION['email']."\"");
      $locket = false;
      while($truc = $cour->fetch()){
          if($truc['id']==$autrevideo['serie_id']){
              $locket=true;
          }
      }
      $html="";
      if($locket==false){
          $ajouter=$bdd->query("insert into liste2utilisateur values(3,\"".$_SESSION['email']."\",".$autrevideo['serie_id'].")");
      }
      $taille=$bdd->query("select id from episode where serie_id=".$autrevideo['serie_id']);
      $nombre=0;
      while($abruti=$taille->fetch()){
          $nombre+=1;
      }
      if($nombre==$data['numero']){
          $akuro=$bdd->query("select email,id from liste2utilisateur where idListe=2 and email=\"".$_SESSION['email']."\"and id=".$autrevideo['serie_id']);
          $truc = $akuro->fetch();
          if(empty($truc['email'])){
              $ajouter2=$bdd->query("insert into liste2utilisateur values(2,\"".$_SESSION['email']."\",".$autrevideo['serie_id'].")");
          }
      }
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
