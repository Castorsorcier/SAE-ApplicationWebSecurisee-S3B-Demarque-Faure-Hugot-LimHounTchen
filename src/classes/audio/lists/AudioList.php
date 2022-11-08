<?php

	namespace iutnc\deefy\audio\lists;
	use Exception;

	class AudioList {
		protected string $nom;
		protected int $nbpiste, $dureetot, $id=0;
		protected $tab;

		public function __construct(String $n, $t = []){
			$id=0;
			$this->nom = $n;
			$this->tab=$t;
			$this->nbpiste=0;
			$this->dureetot = 0;
			foreach ($t as $key => $value) {
				$this->dureetot += $value->duree;
				$this->nbpiste++;
			}
		}

		public function __get(String $atr){
			if(property_exists($this, $atr)){
				return $this->$atr;
			} else {
				throw new Exception("Invalid property : $atr");
			}
		}
	}

?>
