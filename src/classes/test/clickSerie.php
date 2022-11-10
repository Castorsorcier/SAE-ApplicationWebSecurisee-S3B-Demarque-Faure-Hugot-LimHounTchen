<?php

namespace iutnc\deefy\test;
require_once 'pageEpisode.php';

class clickSerie{
function runFunction(int $id){
    afficherSerie($id);
}

function createSerie(int $id,string $titre): string{
    $text="<a href=\"?function&id=".$id."\">$titre</a>";
    return $text;
}
}

if (isset($_GET['function'])){
    runFunction($_GET['id']);
}