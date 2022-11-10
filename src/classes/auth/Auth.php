<?php

namespace iutnc\deefy\auth;
use iutnc\deefy\factory\ConnectionFactory;
require_once 'vendor/autoload.php';
use Exception;

class Auth{

    //cle ssh de xampp
    const config=array(
"config" => "C:/xampp/php/extras/openssl/openssl.cnf",
'private_key_bits'=> 2048,
'default_md' => "sha256");

    //cle d'encodage
    static $keyPasswd=54000;

    const admin=100;
    const utilisateur=1;

    private array $table;
    private int $role=1;

    /**
    *Permet d'ajouter un nouvel utilisateur dans la bd en verifiant
    *la force de son mot de passe et le nouvel email
    *$email:email utilisateur
    *$pass:mot de passe chiffre
    */
    static function register(string $email):bool{
      $db=ConnectionFactory::makeConnection();
      $query="select * from token where email=?";
      $stmt=$db->prepare($query);
      $stmt->execute([$email]);
      $res=$stmt->fetch();
      if(!$res) throw new Exception('Token inexistant');

      try{
        $query="insert into utilisateur values(?,?, null, null, null, null, null, null, null)";

        $stmt=$db->prepare($query);
        $stmt->execute([$email, $res['passwd']]);
      }
      catch(Exception $e){
        throw new Exception("erreur de creation de compte");
      }
      $_SESSION['numCarte']=null;

      $query="delete from token where email=?";
      $stmt=$db->prepare($query);
      $res=$stmt->execute([$_SESSION['email']]);
      if(!$res)
        throw new Exception("erreur token");

      return true;
    }

    /**
    *Permet la connexion d'un utilisateur en indiquant son email
    *et son mot de passe en clair
    *le mot de passe est compare avec l'encode et l'utilisateur peut
    *ou non acceder au compte
    *$email:email utilisateur
    *$mdp:mot de passe en clair
    *return:email de l'utilisateur
    */
    static function authentificate(string $email, string $mdp):string{
      $db=ConnectionFactory::makeConnection();

      //test existence de l'utilisateur
      $query="select * from utilisateur where email=?";
      $stmt=$db->prepare($query);
      $stmt->execute([$email]);
      $res=$stmt->fetch();
      if(!$res) throw new Exception('Compte inexistant');

      if(!password_verify($mdp, $res['passwd']))
        throw new Exception('Mot de passe incorrect');
      $_SESSION['utilisateur']=serialize($res);
      return $res['email'];
    }

    /**
    *Verifie la force du mot de passe
    *$pass:mot de passe en clair
    *$minimumLength:longueur minimale du mot de passe
    *return:le mot de passe est fort
    */
    static function checkPasswordStrength(string $pass, int $minimumLength):bool{
      $length = strlen($pass)<$minimumLength; // longueur minimale
      if($length)
        throw new Exception("mot de passe trop court");
      $digit = preg_match("#[\d]#", $pass); // au moins un digit
      if(!$digit)
        throw new Exception("mot de passe sans chiffres");
      $special = preg_match("#[\W]#", $pass); // au moins un car. spécial
      if(!$special)
        throw new Exception("mot de passe sans caractere special");
      $lower = preg_match("#[a-z]#", $pass); // au moins une minuscule
      if(!$lower)
        throw new Exception("mot de passe sans lettre minuscule");
      $upper = preg_match("#[A-Z]#", $pass); // au moins une majuscule
      if(!$upper)
        throw new Exception("mot de passe sans lettre majuscule");
      return true;
    }

    static function decrypt(string $message):string{
      openssl_pkey_export(openssl_pkey_new(self::config), static::$keyPasswd);
      return openssl_decrypt($message, "AES-128-ECB", static::$keyPasswd);
    }

    /**
    *Stocke les informations du profil utilisateur dans des variables de session
    */
    static function loadProfil(){
      $query="select * from utilisateur where email=?";
      $db=ConnectionFactory::makeConnection();

      $stmt=$db->prepare($query);
      $utilisateur=$stmt->execute([$_SESSION['email']]);
      if(!$utilisateur) throw new Error('auth error');

      $utilisateur=$stmt->fetch();

      if(!$utilisateur) throw new Exception("auth failed");

      $_SESSION['utilisateur']=serialize($utilisateur);

      $_SESSION['nom']=$utilisateur['nom'];
      $_SESSION['prenom']=$utilisateur['prenom'];
      $_SESSION['genrePref']=$utilisateur['genrePref'];
      //numero de carte encode
      $_SESSION['numCarte']=$utilisateur['numCarte'];
    }

    /**
    *Permet de modifier le profil utilisateur dans la bd et de chiffrer le numero de carte
    *$nom:nom de compte
    *$prenom:prenom de compte
    *$numCarte:numero de carte en clair
    */
    static function setProfil(string $nom, string $prenom, string $genrePref, string $numCarte){
      $db=ConnectionFactory::makeConnection();
      $query="update utilisateur set nom=?, prenom=?, genrePref=?, numCarte=? where email=?";
      $stmt=$db->prepare($query);
      $hash=$numCarte!==""?openssl_encrypt($numCarte, "AES-128-ECB", static::$keyPasswd):"";
      $res=$stmt->execute([$nom, $prenom, $genrePref, $hash, $_SESSION['email']]);
    }

    static function createToken(string $email, string $passwd, string $token){
      $db=ConnectionFactory::makeConnection();

      $query_email="select email from utilisateur where email=?";
      $stmt=$db->prepare($query_email);
      $res=$stmt->execute([$email]);
      if($stmt->fetch())
        throw new Exception("ce compte existe déjà");

      $query="select count(id)+1 from token";
      $stmt=$db->query($query);
      $cpt=$stmt->fetch()[0];

      $hash=password_hash($passwd, PASSWORD_DEFAULT, ['cost'=>12]);
      self::checkPasswordStrength($passwd, 10);

      $query="insert into token values(?, ?, ?, null, ?, ?, ?, ?)";
      $stmt=$db->prepare($query);
      $res=$stmt->execute([$cpt, $email, $hash, $token, date('Y-m-d H:i:s', time()+60*60), $token, date('Y-m-d H:i:s', time()+60*15)]);
      //stockage du mot de passe crypte
      $_SESSION['passwd']=$hash;
    }

    static function checkToken(string $token):bool{
      $db=ConnectionFactory::makeConnection();
      $query="select * from token
where renew_token = ?
and renew_expires > CURRENT_TIMESTAMP;";
      $stmt=$db->prepare($query);
      $stmt->execute([$token]);
      $res=$stmt->fetch();
      if(!$res)
        throw new Exception("token non trouvé");

      /*$query="update token set active = 1, renew_token=null
      where renew_token = ?";
      */
      return true;
    }
}
