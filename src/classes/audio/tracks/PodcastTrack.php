<?php
namespace iutnc\deefy\audio\tracks;

use iutnc\deefy\audio\tracks\AudioTrack;

class PodcastTrack extends AudioTrack
{
    protected string $date;
    protected string $auteur;

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