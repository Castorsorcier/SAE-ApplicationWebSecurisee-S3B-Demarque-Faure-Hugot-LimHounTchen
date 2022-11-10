<?php

namespace iutnc\deefy\action;

use iutnc\deefy\test\ClickSerie;
use iutnc\deefy\action\Action;
use iutnc\deefy\factory\ConnectionFactory as ConnectionFactory;
ConnectionFactory::setConfig('config.ini');
class Display extends Action {
	public function execute(): string{

		$db = ConnectionFactory::makeConnection();

		$series = $db->query("SELECT titre, descriptif, annee , id FROM serie");
		$html = "<div>";
		while($data=$series->fetch()){
            //$text=ClickSerie::createSerie($data['id'],$data['titre']);
			$html.= "<div name=\"serie\"><li><a href=\"?action=".$data['id']."\">".$data['titre']."</a></li>".$data['descriptif']."<br>Sortie en ".$data['annee']."</div><br>";
		}
		$html .= "</div>";
		return $html;
	}
}
?>
