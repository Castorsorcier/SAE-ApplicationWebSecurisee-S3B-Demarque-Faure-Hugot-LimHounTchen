<?php

namespace iutnc\deefy\action;
use iutnc\deefy\auth\Auth;
use iutnc\deefy\factory\ConnectionFactory;
use iutnc\deefy\action\Action;

class Token extends Action{
  public function execute():string{
    $html="";
    $token=bin2hex(random_bytes(32));
    $html.=<<<END

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
