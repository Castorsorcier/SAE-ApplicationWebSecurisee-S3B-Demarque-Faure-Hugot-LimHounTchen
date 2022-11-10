<?php

namespace iutnc\deefy\action;
use iutnc\deefy\auth\Auth;
use iutnc\deefy\factory\ConnectionFactory;
use iutnc\deefy\action\Action;

class Token extends Action{
  public function execute():string{
    if(Auth::checkToken($_GET['token']))
      Auth::register($_SESSION['email']);
    return "Inscription réussie";
    }
  }
