<?php
	namespace iutnc\deefy\action;
	use iutnc\deefy\action\Action;
	use iutnc\deefy\factory\ConnectionFactory as ConnectionFactory;
	
	class DejaVue extends Action {
		public function execute(): string{
			$html = "";
			$db = ConnectionFactory::makeConnection();
			$u = unserialize($_SESSION['utilisateur']);
			$dv = $db->prepare("SELECT s.id, titre, descriptif, annee 
								FROM serie s INNER JOIN liste2utilisateur l ON s.id = l.id
								WHERE idListe = 2 AND email = ?");
			$dv->bindParam(1,$u['email']);
			$dv->execute();
			$html .= "<div><h2>Series deja vue : </h2>";
			while($data=$dv->fetch()){
				$html.= "<div name=\"serie\">".$data['titre']." : ".$data['descriptif']."<br>Sortie en ".$data['annee']."</div>";
			}
			$html.="</div>";
			return $html;
		}
	}
?>