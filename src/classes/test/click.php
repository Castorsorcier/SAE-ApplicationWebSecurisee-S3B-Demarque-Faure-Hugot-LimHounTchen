<?php

namespace iutnc\deefy\test;
require_once 'pageEpisode.php';

if (isset($_GET['function'])){
    runFunction($_GET['id']);
}
class click{
function runFunction(int $id){
    afficherEpisode($id);
}

function createEpisode(int $id,string $titre): string{
    $text="<a href=\"?function&id=".$id."\">$titre</a>";
    return $text;
}
}