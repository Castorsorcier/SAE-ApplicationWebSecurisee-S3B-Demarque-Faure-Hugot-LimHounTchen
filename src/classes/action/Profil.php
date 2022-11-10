<?php

namespace iutnc\deefy\action;
use iutnc\deefy\auth\Auth;
use iutnc\deefy\factory\ConnectionFactory;
use iutnc\deefy\action\Action;

class Profil extends Action{
  public function execute():string{
    $html="";
    Auth::loadProfil();
    $nom=$_SESSION['nom'];
    $prenom=$_SESSION['prenom'];
    $genrePref=$_SESSION['genrePref'];
    $numCarte=isset($_SESSION['numCarte'])?Auth::decrypt($_SESSION['numCarte']):null;
    if($this->http_method==='GET'){
    $html.=<<<END
      <form method="post" action="?action=profil"

        <label>Nom
        <input type="nom"
               name="nom"
               value="$nom">
        </label>

        <label>Prénom
        <input type="text"
               name="prenom"
               value="$prenom">
        </label>

        <label>Genre préféré
        <input type="text"
               name="genrePref"
               value="$genrePref">
        </label>

        <label>Numéro de carte
        <input type="text"
               name="numCarte"
               value="$numCarte">
        </label>

        <button type="submit">
        Enregistrer
        </button>
      </form>
      END;
    }
    else{
      $nom=filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
      $prenom=filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
      $genrePref=filter_var($_POST['genrePref'], FILTER_SANITIZE_STRING);
      $numCarte=filter_var($_POST['numCarte'], FILTER_SANITIZE_STRING);
      Auth::setProfil($nom, $prenom, $genrePref, $numCarte);
      $html.="Informations enregistrées";
    }
    return $html;
  }
}
