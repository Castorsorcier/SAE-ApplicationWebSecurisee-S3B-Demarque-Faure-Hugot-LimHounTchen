<?php

namespace iutnc\deefy\action;

use iutnc\deefy\test\ClickSerie;
use iutnc\deefy\action\Action;
use iutnc\deefy\factory\ConnectionFactory as ConnectionFactory;
ConnectionFactory::setConfig('config.ini');
class Display extends Action {
	public function execute(): string{
		$html=null;
		$db = ConnectionFactory::makeConnection();

		$series = $db->prepare("SELECT id, titre, descriptif, annee
						FROM serie
						WHERE id NOT IN (SELECT id FROM liste2utilisateur WHERE idListe = 1)");
		$fav = $db->prepare("SELECT s.id, titre, descriptif, annee
							FROM serie s INNER JOIN liste2utilisateur l ON s.id = l.id
							WHERE idListe = 1 AND email = ?");
		$lisvide = $db->prepare("SELECT COUNT(id) as nbSerie
								FROM liste2utilisateur
								WHERE idListe = 1 AND email = ? ");
		$u = unserialize($_SESSION['utilisateur']);
		$lisvide->bindParam(1,$u['email']);
		$lisvide->execute();
		$fav->bindParam(1,$u['email']);
		$fav->execute();
		$lv = $lisvide->fetch();
		if($lv>=1){
			$html .= "<div><div><h2>Series Favorites : </h2>";
			while($data2=$fav->fetch()){
				$html.= "<div name=\"serie\">".$data2['titre']." : ".$data2['descriptif']."<br>Sortie en ".$data2['annee']."<a href=\"?action=suppseriepref&id=".$data2['id']."\">Supprimer des favories</a></div>";
			}
		}
		$series->execute();
		$html .= '</div><br><br><div> <h2>Catalogue des series : </h2>';
		while($data=$series->fetch()){
            //$text=ClickSerie::createSerie($data['id'],$data['titre']);
			$html.= "<div name=\"serie\"><li><a href=\"?action=".$data['id']."\">".$data['titre']."</a></li>".$data['descriptif']."<br>Sortie en ".$data['annee']."</div><br>";
		}
		$html .= "</div>";
		return $html;
	}
}
?>
