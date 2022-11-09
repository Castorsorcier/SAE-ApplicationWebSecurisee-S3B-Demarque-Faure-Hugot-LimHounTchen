<?php

namespace iutnc\deefy\action;
use iutnc\deefy\auth\Auth;
use iutnc\deefy\action\Action;
require_once 'vendor/autoload.php';

class SigninAction extends Action{
  public function execute():string{
    $html="";
    if($this->http_method==='GET'){
      $html=<<<END
        <form method="post" action="?action=connexion">
        <label>Email
        <input type="email"
               name="email"
               placeholder="test@mail.com">
        </label>

        <label>Password
        <input type="text"
               name="passwd"
               placeholder="passwd">
        </label>

        <button type="submit">
        Se connecter
        </button>
        </form>
      END;
      }
      else{
        $_SESSION['email']=Auth::authentificate($_POST['email'], $_POST['passwd']);
        $email=filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $passwd=filter_var($_POST['passwd'], FILTER_SANITIZE_STRING);
        $html.="Connexion réussie";
      }
    return $html;
  }
}
