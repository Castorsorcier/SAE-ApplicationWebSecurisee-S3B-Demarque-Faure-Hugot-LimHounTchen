<?php

namespace iutnc\deefy\action;
use iutnc\deefy\action\Action;
require_once 'vendor/autoload.php';

class Logout extends Action{
  public function execute():string{
    if(isset($_SESSION['utilisateur']))
      $_SESSION['utilisateur']=null;
    return "Déconnexion réussie";
  }
}
