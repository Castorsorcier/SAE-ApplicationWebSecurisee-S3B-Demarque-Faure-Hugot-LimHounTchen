<?php
	namespace iutnc\deefy\action;
	use iutnc\deefy\action\Action;
	use iutnc\deefy\factory\ConnectionFactory as ConnectionFactory;
	class suppseriepref extends Action {
		public function execute(): string{
			$db = ConnectionFactory::makeConnection();

			$u = unserialize($_SESSION['utilisateur']);
			$q = $db->prepare("DELETE FROM liste2utilisateur WHERE email = ? AND id = ?");
			$q->bindParam(1,$u['email']);
			$q->bindParam(2,$_GET['id']);
			$q->execute();
			return "";
		}
	}
?>