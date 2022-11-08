<?php
namespace iutnc\deefy\audio\lists;

use iutnc\deefy\audio\lists\AudioList;
use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;
use src\Factory\ConnectionFactory as cF;
require_once 'AlbumTrack.php';
require_once 'PodcastTrack.php';
require_once 'AudioList.php';
require_once 'vendor/autoload.php';
use PDO;

//cF::setConfig("../../../config.ini");

class Playlist extends AudioList
{
    public function ajouterPiste(AudioTrack $piste) : void
    {
        array_push($this->pistes, $piste);
        $this->nbPistes++;
        $this->dureeTot += isset($piste->duree) ? $piste->duree : 0;
    }

    public function supprimerPiste(int $indicePiste) : void
    {
        unset($this->pistes[$indicePiste]);
        return;
    }

    public function ajouterListePistes(array $listePistes)
    {
        /*foreach ($listePistes as $piste) {
            array_push($this->pistes, $piste);
        }
        // supprime les doublons du tableau
        $this->pistes = array_unique($this->pistes); */

        $this->tab = array_unique(array_merge($this->tab, $listePistes), SORT_REGULAR);
        $this->nbPistes = count($this->tab);
         foreach ($this->tab as $piste) {
            $this->dureetot += $piste->duree;
        }
    }

    public function getTrackList() : array
    {
        //cF::setConfig("./config.ini");
        $db = cF::makeConnection();

        $query = 'SELECT * FROM `track` t, `playlist2track` p WHERE t.id = p.id_track AND p.id_pl = ?';
        $st = $db->prepare($query);
        $var = $this->id;
        $st->bindParam(1, $var);
        $st->execute();
        $trackList = [];
        foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $row) {
            switch ($row['type']) {
                case 'A':
                    $track = new AlbumTrack($row['titre'], $row['filename']);
                    $track->genre = $row['genre'];
                    $track->duree = $row['duree'];
                    $track->artiste = $row['artiste_album'];
                    break;

                case 'P':
                    $track = new PodcastTrack($row['titre'], $row['filename']);
                    $track->genre = $row['genre'];
                    $track->duree = $row['duree'];
                    $track->auteur = $row['artiste_album'];
                    break;
            }
            array_push($trackList, $track);
        }

        return $trackList;
    }

    public static function find(int $idPlaylist) : ?Playlist // self
    {
        // cF::setConfig("./././config.ini");
        $db = cF::makeConnection();

        $sql = "SELECT * from playlist WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$idPlaylist]);

        $pl_data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$pl_data) return null;
        $playlist = new Playlist($pl_data['nom']);
        $playlist->id = $pl_data['id'];
        $playlist->ajouterListePistes($playlist->getTrackList());


        return $playlist;


    }






}
?>
