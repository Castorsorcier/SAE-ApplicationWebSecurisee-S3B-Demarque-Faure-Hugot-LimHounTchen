<?php

namespace iutnc\deefy\dispatch;
use \iutnc\deefy\action as AC;
use iutnc\deefy\auth\Auth;
use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\action\AddUserAction;
use iutnc\deefy\action\SigninAction;
use iutnc\deefy\action\DisplayPlaylistAction;
use iutnc\deefy\action\Logout;
use iutnc\deefy\action\Profil;
use iutnc\deefy\action\Display;
use iutnc\deefy\action\addseriepref;
use iutnc\deefy\action\suppseriepref;

use iutnc\deefy\test\AfficherSerie;

class Dispatcher{
  protected ?string $action=null;

  public function __construct(){
    $this->action=isset($_GET['action'])?$_GET['action']:null;
  }

  public function run(){
    $html=null;
    switch ($this->action) {

      /*
      Rajouter les fonctionnalites ici (action)
      */

        case 'register':
          $execution=new AddUserAction();
          $html=$execution->execute();
          break;

        case 'connexion':
          $execution=new SigninAction();
          $html=$execution->execute();
          break;

        case 'profil':
          $execution=new Profil();
          $html=$execution->execute();
          break;

        case 'logout':
          $execution=new Logout();
          $html=$execution->execute();
          break;

        case 'addseriepref':
          $execution=new addseriepref();
          $html=$execution->execute();
          header('Location: index.php');
          break;

        case 'suppseriepref':
          $execution=new suppseriepref();
          $html=$execution->execute();
          header('Location: index.php');
          break;

        default:
          $html='<h2>Bienvenue</h2>';
          if(!is_null($this->action)){
            $html.=AfficherSerie::afficherSerie($this->action);
          }
          else if(isset($_SESSION['utilisateur'])){
            $execution=new Display();
            $html.=$execution->execute();
          }
          break;
      }

      echo $this->renderPage($html);
    }

  public function renderPage(string $html):string{
    if(!isset($_SESSION['utilisateur'])){
      $options=<<<END
      <li><a href="?action=register">S'incrire</a></li>
      <li><a href="?action=connexion">Se connecter</a></li>
      END;
    }

    /*
    Rajouter les liens des actions ci-dessous
    */

    else{
      $email=$_SESSION['email'];
      $options=<<<end
      <li><a href="?action=profil">Profil</a></li>
      <li><a href="?action=logout">Se déconnecter</a></li>
      </nav>Vous êtes connecté : <strong>$email</strong><br>
      end;

    }

    return <<<END
    <!DOCTYPE html>
    <html lang="fr">
      <head>
        <title>NetVOD</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1 /"
      </head>
      <body>
        <h1>NetVOD</h1>
        <nav><ul>
          <li><a href="index.php">Accueil</a></li>
          $options
      </nav><br>
      $html
    </body>
  </html>
  END;
  }
}
