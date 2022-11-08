<?php
namespace iutnc\deefy\audio\tracks;

use iutnc\deefy\audio\tracks\AudioTrack;
require_once 'AudioTrack.php';

class AlbumTrack extends AudioTrack
{

    protected string $album;
    protected string $artiste;
    protected int $annee;
    protected int $numPiste;

    public function __construct(string $titre, string $cheminFich)
    {
        parent::__construct($titre, $cheminFich);
    }

    public function __toString() : string
    {
        return json_encode($this);
    }

}

?>
