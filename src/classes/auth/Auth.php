<?php

namespace iutnc\deefy\auth;
use iutnc\deefy\factory\ConnectionFactory;
require_once 'vendor/autoload.php';
use Exception;
use PDO;

class Auth{

    const admin=100;
    const utilisateur=1;

    private array $table;
    private int $role=1;

    static function register(string $email, string $pass):bool{
      if(!self::checkPasswordStrength($pass, 10))
        throw new Exception("faible");

      $hash=password_hash($pass, PASSWORD_DEFAULT, ['cost'=>12]);
      try{
        $db=ConnectionFactory::makeConnection();
      }
      catch(Exception $e){
        throw new Exception($e);
      }

      $query_email="select * from utilisateur where email=?";
      $stmt=$db->prepare($query_email);
      $res=$stmt->execute([$email]);
      if($stmt->fetch())
        throw new Exception("compte existant");

      try{
        $query="insert into utilisateur values(?,?, null, null, null, null, null, null)";
        $stmt=$db->prepare($query);
        $res=$stmt->execute([$email, $hash]);
      }
      catch(Exception $e){
        throw new Exception("erreur de creation de compte");
      }
      return true;
    }

    static function authentificate(string $email, string $mdp):string{
      /*if(array_key_exists($email, $table));
        if(isset($table[$mdp]))
          return new utilisateur('email', 'passwd', 'role');
      return null;*/
      $query="select * from utilisateur where email=?";
      $db=ConnectionFactory::makeConnection();

      $stmt=$db->prepare($query);
      $res=$stmt->execute([$email]);
      if(!$res) throw new Error('auth error');

      $utilisateur=$stmt->fetch(PDO::FETCH_ASSOC);

      if(!$utilisateur) throw new Exception("auth failed");
      if(!password_verify($mdp, $utilisateur['passwd']))
        throw new Exception('Mot de passe incorrect');
      $_SESSION['utilisateur']=serialize($utilisateur);
      return $utilisateur['email'];
    }

    static function checkPasswordStrength(string $pass, int $minimumLength):bool{
      return strlen($pass)>$minimumLength;
    }
}
