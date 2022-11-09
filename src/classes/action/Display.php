<?php


namespace iutnc\deefy\action;
use iutnc\deefy\action\Action;
use iutnc\deefy\factory\ConnectionFactory as ConnectionFactory;
ConnectionFactory::setConfig('config.ini');
class Display extends Action {
	public function execute(): string{
		
		$db = ConnectionFactory::makeConnection();

		$series = $db->query("SELECT titre, descriptif, annee 
						FROM serie");
		$html = "<div>";
		while($data=$series->fetch()){
			$html.= "<div name=\"serie\">".$data['titre']." : ".$data['descriptif']."<br>Sortie en ".$data['annee']."</div><br>";
		}
		$html .= "</div>";
		return $html;
	}
}
?>