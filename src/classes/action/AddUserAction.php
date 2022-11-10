<?php

namespace iutnc\deefy\action;
use iutnc\deefy\auth\Auth;
use iutnc\deefy\action\Action;

class AddUserAction extends Action{
  public function execute():string{
    $html="";
    if($this->http_method==='GET'){
      $html.=<<<END
      <form method="post" action="?action=register"

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
        S'inscrire
        </button>
      </form>
      END;
    }
    else{
      $email=filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
      $_SESSION['email']=$email;
      $passwd=filter_var($_POST['passwd'], FILTER_SANITIZE_STRING);
      $html.="Cliquez sur le lien de confirmation envoyé sur le mail fourni";
      $token=bin2hex(random_bytes(64));

      if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
         $url = "https://";
      else
         $url = "http://";
      $url.= $_SERVER['HTTP_HOST'];
      $url.= $_SERVER['REQUEST_URI'];
      $url=substr($url, 0, strpos($url, "?"));
      $url.="?token=";
      $html.="<br><a href=\"$url$token\">$url$token</a>";
      Auth::createToken($email, $passwd, $token);
    }
    return $html;
  }
}
